<?php
/**
 *                    Jojo CMS
 *                ================
 *
 * Copyright 2008 Jojo CMS <www.jojocms.org>
 *
 * See the enclosed file license.txt for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @author  Michael Cochrane <mikec@jojocms.org>
 * @license http://www.fsf.org/copyleft/lgpl.html GNU Lesser General Public License
 * @link    http://www.jojocms.org JojoCMS
 * @package jojo_pdf
 */

class Jojo_Plugin_Jojo_pdf extends Jojo_Plugin
{
    function _getContent()
    {
        global $smarty, $_USERGROUPS;

        /* Set a flag so other code knows it's going to become a pdf */
        define('_ISPDF', true);
        $smarty->assign('ispdf', true);

        /* Get the page id */
        $newUri = Jojo::getFormData('pdfuri', '');
        $data = Jojo::parsepage($newUri);
        if ($data == $this->id) {
            /* Don't pdf myself - that would be bad */
            exit;
        }

        /* Get the page */
        try {
            $page = Jojo_Plugin::getPage($data);
        } catch (Jojo_Exception_IncludeFile $e) {
            echo $e->getFileToInclude();
            exit;
        }

        /* Check permissions on the page */
        if (!$page->perms->hasPerm($_USERGROUPS, 'view')) {
            echo "Permission denied";
            exit();
        }

        /* Assign all page fields to smarty */
        foreach($page->page as $key => $value) {
            $smarty->assign($key, $value);
        }
        /* Assign all page variables to smarty */
        $content = $page->getContent();
        $content['content'] = str_replace('&nbsp;', ' ', $content['content']); //non-breaking spaces don't seem to translate properly, so strip them out
        $content['content'] = preg_replace('/\[\[.*\]\]/', '', $content['content']); //strip out filter references too
        $smarty->assign('numbreadcrumbs', count($content['breadcrumbs']));
        $smarty->assign('pg_language', $page->getValue('pg_language'));
        foreach($content as $k => $v) {
            $v = Jojo::applyFilter($k, $v);
            if ($k != 'index') $smarty->assign($k, $v); //do not assign a variable called 'index' in case it is already used elsewhere
        }
        $html = $smarty->fetch('pdf_template.tpl');

        require(_PLUGINDIR . '/jojo_pdf/external/dompdf/dompdf_config.inc.php');
        $DOMPDF_PDF_BACKEND = "CPDF";
        $DOMPDF_DPI = 300;
        $dompdf = new DOMPDF();
        $base = parse_url(_SITEURL);
        $dompdf = new DOMPDF();
        if (isset($base['path'])) {
            $dompdf->set_base_path($base['path']);
        } else {
            $dompdf->set_base_path('/');
        }
        $dompdf->set_host($base['host']);
        $dompdf->set_protocol($base['scheme'] . '://');
        $dompdf->set_paper('a4', 'portrait');
        $dompdf->load_html($html);
        $dompdf->render();
        $pdf = $dompdf->output();

        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename=' . str_replace(' ', '_', $content['title']) . '.pdf'); //doesn't seem to like some file names with spaces in them..
        header('Content-Length: ' . strlen($pdf));
        echo $pdf;
        exit;
    }


    function getCorrectUrl()
    {
        //Assume the URL is correct
        return _PROTOCOL . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }

}
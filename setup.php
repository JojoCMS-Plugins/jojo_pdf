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

// PDF Output
$data = Jojo::selectQuery("SELECT pageid FROM {page} WHERE pg_link = 'Jojo_Plugin_Jojo_pdf'");
if (!count($data)) {
    echo "Adding <b>PDF Output Handler</b> Page<br />";
    Jojo::insertQuery("INSERT INTO {page} SET pg_title = 'PDF Output Handler', pg_link = 'Jojo_Plugin_Jojo_pdf', pg_url = 'pdf', pg_parent= ?, pg_order=0, pg_mainnav='no', pg_footernav='no', pg_sitemapnav='no', pg_xmlsitemapnav='no', pg_index='no', pg_body = ''", array($_NOT_ON_MENU_ID));
}
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

/* Register URI patterns */
Jojo::registerURI("pdf/[pdfuri:.*]", 'Jojo_Plugin_Jojo_PDF');  // "pdf/some/other/page"
//Jojo::registerURI("pdf/", 'Jojo_Plugin_Jojo_PDF');  // "pdf/some/other/page"
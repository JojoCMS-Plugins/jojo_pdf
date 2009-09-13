{if $DOCTYPE}
{$DOCTYPE}
<html>
{else}
<?xml version="1.0" encoding="{if $charset}{$charset}{else}utf-8{/if}" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{if $pg_language}{$pg_language}{else}en{/if}" lang="{if $pg_language}{$pg_language}{else}en{/if}">
{/if}
<head>
<title>{$displaytitle|escape:"UTF-8":$charset}</title>
<base href="{if $issecure}{$SECUREURL}{else}{$SITEURL}{/if}/" />
<meta http-equiv="content-Type" content="text/html; charset={if $charset}{$charset}{else}utf-8{/if}" />
<link rel="stylesheet" type="text/css" href="css/styles.css" />
<link rel="stylesheet" type="text/css" href="css/pdf_style.css" />
{if $css}
<style type="text/css">
{$css}
</style>
{/if}
{$customhead}
{jojoHook hook="pdf_customhead"}
</head>
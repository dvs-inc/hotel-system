<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>{block name="pagetitle"}{message name={$pagetitle}}{/block}</title>

	<!-- styles -->
	{foreach from="$styles" item="thisstyle"}
		<link rel="stylesheet" type="text/css" href="{$thisstyle}" />
	{/foreach}
	<!-- scripts -->
	{foreach from="$scripts" item="thisscript"}
		<script src="{$thisscript}" type="text/javascript"></script>
	{/foreach}

</head>
<body>
	<div id="globalwrapper">
		{block name="header"}{include file="header.tpl"}{/block}
		{block name="nav"}{include file="nav.tpl"}{/block}
		{block name="image"}{include file="image.tpl"}{/block}
		<div id="contentwrapper">
			{block name="subnav"}{* For the management system, default empty *}{/block}
			<div id="content">
				{block name="prebody"}{* urrghh *}{/block}
				{block name="body"}{$content|default:"<p>Nothing to see here!</p>"}{/block}
			</div>
		</div>
		{block name="footer"}{include file="footer.tpl"}{/block}
	</div>
</body>
</html>

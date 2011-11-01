<html>
<head>
	<title></title>
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
		{block name="body"}Nothing to see here.{/block}
		{block name="footer"}{include file="footer.tpl"}{/block}
	</div>
</body>
</html>

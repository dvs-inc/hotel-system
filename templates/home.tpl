{extends file="twocolumnuneven.tpl"}

{block name="columnone"}
	{message name="home-column1"}		
{/block}

{block name="columntwo"}
	<h2>{message name="quick-book"}</h2>
	<form method="post" action="{$cScriptPath}/Book">
	{include file="quickbook.tpl"}
	<input type="submit" value="{message name="check-availability"}"/>
	</form>
{/block}
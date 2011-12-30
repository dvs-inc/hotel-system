{extends file="twocolumnuneven.tpl"}

{block name="columnone"}
	{message name="home-column1"}		
{/block}

{block name="columntwo"}
	<h2>{message name="quick-book"}</h2>
	<form>
	{include file="quickbook.tpl"}
	<input type="submit" value="{message name="check-availability"}"/>
	</form>
{/block}
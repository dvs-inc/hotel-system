<div id="nav">
	<ul>
		{foreach from="$mainmenu" item="link" key="text"}
			<li><a href="{$cScriptPath}{$link}">{$text}</a></li>
		{/foreach}
	</ul>
</div>

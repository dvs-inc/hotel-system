<div id="nav">
	<ul>
		{foreach from="$mainmenu" item="link" key="text"}
			<li><a href="{$cScriptPath}{$link}">{$text}</a></li>
		{/foreach}
	</ul>
	<div id="langlinks">
		<ul>
			<li><a><img src="{$cWebPath}/images/United-Kingdom-flag-32.png" alt="English" /></a></li>
			<li><a><img src="{$cWebPath}/images/Finland-Flag-32.png" alt="Finnish" /></a></li>
		</ul>
	</div>
</div>

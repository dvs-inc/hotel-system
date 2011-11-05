<div id="nav">
	<ul>
		{foreach from="$mainmenu" item="menuitem" }
			<li><a href="{$cScriptPath}{$menuitem.link}" {if isset($menuitem.current)}class="current"{/if}>{$menuitem.title}</a></li>
		{/foreach}
	</ul>
	<div id="langlinks">
		<ul>
			<li><a><img src="{$cWebPath}/images/United-Kingdom-flag-32.png" alt="English" /></a></li>
			<li><a><img src="{$cWebPath}/images/Finland-Flag-32.png" alt="Suomi" /></a></li>
		</ul>
	</div>
</div>

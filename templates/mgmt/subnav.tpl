<div id="subnav">
	<ul>
		{foreach from="$mainmenu" item="menuitem" }
			<li><a href="{$cScriptPath}{$menuitem.link}" {if isset($menuitem.current)}class="current"{/if}>{message name={$menuitem.title}}</a></li>
		{/foreach}
	</ul>
</div>

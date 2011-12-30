<div id="nav">
	<div id="nav1">
		<ul>
			{foreach from="$mainmenu" item="menuitem" }
				<li><a href="{$cScriptPath}{$menuitem.link}" {if isset($menuitem.current)}class="current"{/if}>{message name={$menuitem.title}}</a>
				{if isset($menuitem.items)}{assign "submenu" "{$menuitem.items}"}
					<ul>
						{foreach from="$submenu" item="subitem" }
							<li><a href="{$cScriptPath}{$subitem.link}" {if isset($subitem.current)}class="current"{/if}>{message name={$subitem.title}}</a></li>
						{/foreach}
					</ul>
				{/if}
				</li>
			{/foreach}
		</ul>
	</div>
	{block name="langlinks"}
	<div id="langlinks">
		<ul>
			<li><a href="?lang=en-GB"><img src="{$cWebPath}/images/United-Kingdom-flag-32.png" alt="English" /></a></li>
			<li><a href="?lang=fi"><img src="{$cWebPath}/images/Finland-Flag-32.png" alt="Suomi" /></a></li>
		</ul>
	</div>
	{/block}
</div>

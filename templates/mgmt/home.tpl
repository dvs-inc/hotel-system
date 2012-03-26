{extends file="mgmt/base.tpl"}
{block name="body"}
{message name="mhome-content"}
{foreach from="$mainmenu" item="menuitem"}
<h3>{message name="{$menuitem.title}"}</h3>
{foreach from="$menuitem.items" item="subitems"}
<h4>{message name="{$subitems.title}"}</h4>
<p>{message name="$subitems.desc"}</p>
{/foreach}
{/foreach}
{/block}

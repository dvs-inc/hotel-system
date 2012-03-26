{extends file="mgmt/base.tpl"}
{block name="body"}
{message name="mhome-content"}
{foreach from="$mainmenu" item="menuitem"}
<h2>{$menuitem.link}</h2>

{/foreach}
{/block}

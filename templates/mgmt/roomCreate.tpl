{extends file="mgmt/base.tpl"}
{block name="body"}
{message name="mgmt-room-createheader"}
<form method="post" action="{$cScriptPath}/Rooms?action=create">
<div id="constraint">
{include file="mgmt/roomEditForm.tpl" rname="" rmin="" rmax="" rprice="" rtype=""}
</div>
</form>
{/block}

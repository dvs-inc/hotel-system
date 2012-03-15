{extends file="mgmt/base.tpl"}
{block name="body"}
{message name="mgmt-room-editheader"}
<form method="post" action="{$cScriptPath}/Rooms?action=edit&id={$roomid}">
<div id="constraint">
{include file="mgmt/roomEditForm.tpl"}
</div>
</form>
{/block}

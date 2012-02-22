{extends file="mgmt/base.tpl"}
{block name="body"}
{message name="mgmt-user-changeaccessheader"}
<form method="post" action="{$cScriptPath}/SystemUsers?action=changeaccess&id={$userid}">
<div id="constraint">
<label class="infield">{message name="useraccesslevel"}<input type="text" name="accesslevel" /></label>
<input id="submitbutton" type="submit"/>
</div>
</form>
{/block}

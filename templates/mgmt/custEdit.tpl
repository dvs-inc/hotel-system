{extends file="mgmt/base.tpl"}
{block name="body"}
{message name="mgmt-cust-editheader"}
<form method="post" action="{$cScriptPath}/Customers?action=edit&id={$custid}">
<div id="constraint">
{include file="signup-form-fields.tpl"}
<input id="submitbutton" type="submit"/>
</div>
</form>
{/block}

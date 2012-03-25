{extends file="mgmt/base.tpl"}
{block name="body"}
{message name="mgmt-customer-createheader"}
<form method="post" action="{$cScriptPath}/Customers?action=create">
<div id="constraint">
{include file="signup-form-fields.tpl" suTitle="" suFirstname="" suLastname="" suAddress="" suCity="" suPostcode="" suCountry=" " suEmail=""}
<input id="submitbutton" type="submit"/>
</div>
</form>
{/block}

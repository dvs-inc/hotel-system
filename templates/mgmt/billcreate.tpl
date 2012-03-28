{extends file="mgmt/base.tpl"}
{block name="body"}
{message name="mgmt-bill-createheader"}
<form method="post" action="{$cScriptPath}/Billing?action=add&id={$bid}">
<div id="constraint">
{include file="mgmt/billeditform.tpl" billname="" billprice=""}
</div>
</form>
{/block}

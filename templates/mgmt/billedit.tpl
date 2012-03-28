{extends file="mgmt/base.tpl"}
{block name="body"}
{message name="mgmt-bill-edit-header"}
<form method="post" action="{$cScriptPath}/Billing?action=edit&rt={$bid}&id={$itemid}">
<div id="constraint">
{include file="mgmt/billeditform.tpl" billname="$billname" billprice="$billprice"}
</div>
</form>
{/block}

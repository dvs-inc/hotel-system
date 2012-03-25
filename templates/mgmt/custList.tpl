{extends file="mgmt/base.tpl"}
{block name="body"}
{message name="mpage-customer-list-header"}
<table id="custlist">
<tr id="thNONE"><th colspan="2">{message name="customer-name"}</th><th>{message name="customer-email"}</th><th /><th /><th /></tr>
{foreach from="$custList" item="cust"}
	{include file="mgmt/custentry.tpl" room="$cust"}
{/foreach}
</table>
{/block}

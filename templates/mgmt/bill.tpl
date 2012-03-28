{extends file="mgmt/base.tpl"}
{block name="body"}
{message name="mpage-bill-list-header"}
<table id="bill">
<tr id="thNONE"><th>{message name="bill-item"}</th><th>{message name="price"}</th><th id="link" /><th id="link" /></tr>
{foreach from="$billitems" item="item"}
	{include file="mgmt/billitem.tpl" item="$item" bid="$bid"}
{/foreach}
<tr id="thNONE"><th>{message name="bill-total"}</th><th>&pound;{$total|string_format:"%.2f"}</th><th /></tr>
</table>
<div class="billappend">
<a href="?action=add&id={$bid}">{message name="bill-append"}</a>&nbsp;|&nbsp;<a href="?action=pay&id={$bid}">{message name="bill-pay"}</a>
</div>
{/block}

{extends file="mgmt/base.tpl"}
{block name="body"}
{message name="mpage-booking-list-header"}
<table id="bookinglist">
<tr id="thNONE"><th>{message name="booking-id"}</th><th>{message name="customer"}</th><th /><th /></tr>
{*{foreach from="$bookinglist" item="booking"}
	{include file="mgmt/boookingentry.tpl" room="$booking"}
{/foreach}*}
</table>
{/block}

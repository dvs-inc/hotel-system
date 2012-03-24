{extends file="mgmt/base.tpl"}
{block name="body"}
{message name="mpage-booking-list-header"}
<table id="bookinglist">
<tr id="thNONE"><th>{message name="booking-customer"}</th><th>{message name="booking-adults"}</th><th>{message name="booking-children"}</th>
<th>{message name="booking-start"}</th><th>{message name="booking-end"}</th><th>{message name="booking-promocode"}</th><th /><th /></tr>
{*{foreach from="$bookinglist" item="booking"}
	{include file="mgmt/boookingentry.tpl" room="$booking"}*}
{/foreach}
</table>
{/block}

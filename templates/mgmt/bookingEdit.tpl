{extends file="mgmt/base.tpl"}
{block name="body"}
{message name="mgmt-booking-editheader"}
<form method="post" action="{$cScriptPath}/Bookings?action=edit&id={$bookingid}">
<div id="constraint">
{include file="mgmt/bookingEditForm.tpl"}
</div>
</form>
{/block}

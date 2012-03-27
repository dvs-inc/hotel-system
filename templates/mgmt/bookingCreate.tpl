{extends file="mgmt/base.tpl"}
{block name="body"}
{message name="mgmt-booking-createheader"}
<form method="post" action="{$cScriptPath}/Bookings?action=create">
<div id="constraint">
{include file="mgmt/bookingEditForm.tpl" bcust="" badults="" bchildren="" bstart="" bend="" bpromo="" broom=""}
</div>
</form>
{/block}

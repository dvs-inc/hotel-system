{extends file="mgmt/base.tpl"}
{block name="body"}
{message name="mpage-room-list-header"}
<table id="roomlist">
<tr id="thNONE"><th>{message name="room-name"}</th><th>{message name="room-type"}</th><th>{message name="room-minp"}</th><th>{message name="room-maxp"}</th><th>{message name="room-price"}</th><th /><th /></tr>
{foreach from="$roomlist" item="room"}
	{include file="mgmt/roomentry.tpl" room="$room"}
{/foreach}
</table>
{/block}

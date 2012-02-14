{extends file="mgmt/base.tpl"}
{block name="body"}
{message name="mpage-users-list-header"}
<table id="userlist">
<tr><th>{message name="login-username"}</th><th>{message name="useraccesslevel"}</th><th /><th /><th /></tr>
{foreach from="$iuserlist" item="iuser"}
	{include file="mgmt/iuserentry.tpl" iuser="$iuser"}
{/foreach}
</table>
{/block}

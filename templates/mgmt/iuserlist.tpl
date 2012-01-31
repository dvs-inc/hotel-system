{extends file="mgmt/base.tpl"}
{block name="body"}
{message name="mpage-users-list-header"}
<label>{message name="login-username"}</label>
<table id="userlist">
{foreach from="$iuserlist" item="iuser"}
	{include file="mgmt/iuserentry.tpl" iuser="$iuser"}
{/foreach}
</table>
{/block}

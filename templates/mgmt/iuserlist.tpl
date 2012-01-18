{extends file="mgmt/base.tpl"}
{block name="body"}
{message name="mpage-users-list-header"}
<table>
<tr><th>{message name="id"}</th><th>{message name="login-username"}</th><th /><th /></tr>
{foreach from="$iuserlist" item="iuser"}
	{include file="mgmt/iuserentry.tpl" iuser="$iuser"}
{/foreach}
</table>
{/block}

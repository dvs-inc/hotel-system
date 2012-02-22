{extends file="mgmt/base.tpl"}
{block name="body"}
{message name="mgmt-access-header"}
<p>{message name="mgmt-access-description"}</p>
<form action="?submit" method="post">
<table>
<tr>
	<th>{message name="mgmt-access-table-key"}</th>
	<th>{message name="mgmt-access-table-value"}</th>
</tr>
{foreach from="$accesslist" item="accessentry"}
	<tr>
		<td>{$accessentry.name}</td>
		<td><input name="{$accessentry.id}" type="text" value="{$accessentry.value}"></td>
	</tr>
{/foreach}
</table>
<input type="submit" value="{message name="save"}" />
</form>
{/block}

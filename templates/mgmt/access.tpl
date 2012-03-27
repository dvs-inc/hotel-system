{extends file="mgmt/base.tpl"}
{block name="body"}
{message name="mgmt-access-header"}
<p>{message name="mgmt-access-description"}</p>
<form action="?submit" method="post">
<table class="accesstable">
<tr>
	<th>{message name="mgmt-access-table-key"}</th>
	<th>{message name="mgmt-access-table-value"}</th>
</tr>
{foreach from="$accesslist" item="accessentry"}
	<tr>
		<td>{message name="mgmt-access-{$accessentry.name}"}</td>
		<td><input name="{$accessentry.id}" type="text" {$readonly} value="{$accessentry.value}"></td>
	</tr>
{/foreach}
</table>
<input id="submitbutton" type="submit" {$readonly} value="{message name="save"}" />
</form>
{/block}

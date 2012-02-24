{extends file="mgmt/base.tpl"}
{block name="body"}
{message name="mlanguage-editor"}
{include file="mgmt/lang-pager.tpl"}
<form method="post" action="?submit">
<table>
	<tr>
		{foreach from="$languages" item="lang"}
			<th>
				{$lang}
			</th>
		{/foreach}
	</tr>
	{foreach from="$languagetable" item="messagerow"}
		<tr>
			{foreach from="$messagerow" item="message"}
			<td>
				{if $message@key eq 'zxx'}
					{$message.content}
				{else}
					<textarea name="lang{$message.id}msg" cols="40" rows="5" xml:space="preserve">{$message.content|escape}</textarea>
				{/if}
			</td>
			{/foreach}
		</tr>
	{/foreach}
</table>
<input type="submit" value="{message name="save"}" />
</form>
{/block}
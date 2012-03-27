{extends file="base.tpl"}

{block name="body"}

{* start date calStart
   end date,  calEnd
   list of rooms, roomlist
   availability function	 *}

<table>
<tr> <th /> {foreach from="$datelist" item="d"}<th>{$d->format("d-m-Y")}</th>{/foreach}</tr>
{foreach from="$availmatrix" key="k" item="i"}
	<tr>
	<th>{$k->getName()}</th>
	{foreach from="$i" item="j"}
		<td>{$j}</td>
	{/foreach}
	</tr>
{/foreach}
</table>

{/block}
{extends file="base.tpl"}

{block name="body"}

{* start date calStart
   end date,  calEnd
   list of rooms, roomlist
   availability function	 *}

<table id="calroomtable">
<tr> <th >{message name="room-name"}</th>{foreach from="$datelist" item="d"}<th>{$d->format("d-m-Y")}</th>{/foreach}</tr>
{foreach from="$availmatrix" key="k" item="i"}
	<tr data-room="{$k}">
	<th>{$roomlist.{$k}->getName()}</th>
	{foreach from="$i" item="j"}
		<td{if $j == true} style="background-color:red;"{else} style="background-color:green;"{/if} />
	{/foreach}
	</tr>
{/foreach}
</table>

<form name="selectroom" action="#" method="post" onsubmit="return validateForm();">
<input name="calroom" value="" type="hidden"/>
<input type="submit" id="submitbutton" value="{message name="submitbutton"}"/>
</form>

<script type="text/javascript">

function validateForm()
{
	var room = document.forms["selectroom"]["calroom"].value;
	if (room=="" || room==null)
	{
		alert("{message name="book-error-noroomselected"}");
		return false;
	}
}

onload = function() {
    if (!document.getElementsByTagName || !document.createTextNode) return;
    var rows = document.getElementById('calroomtable').getElementsByTagName('tr');
    for (i = 0; i < rows.length; i++) {
        rows[i].onclick = function() {
			for (j = 0; j < rows.length; j++) {
				var currentrow = rows[j];
				currentrow.style.backgroundColor = "transparent";
			}
			this.style.backgroundColor = "white";
			document.forms["selectroom"]["calroom"].value = this.rowIndex + 1;
        }
    }
}

</script>
{/block}
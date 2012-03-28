{extends file="base.tpl"}

{block name="body"}

{* start date calStart
   end date,  calEnd
   list of rooms, roomlist
   availability function	 *}

{message name="roomslection-header"}
{message name="roomslection-content"}

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
<input type="hidden" name="qbCheckin" value="{$valQbCheckin}"/>
<input type="hidden" name="qbCheckout" value="{$valQbCheckout}"/>
<input type="hidden" name="qbAdults" value="{$valQbAdults}"/>
<input type="hidden" name="qbChildren" value="{$valQbChildren}"/>
<input type="hidden" name="qbPromoCode" value="{$valQbPromoCode}"/>
<input type="hidden" name="qbTitle" value="{$valQbTitle}"/>
<input type="hidden" name="qbFirstname" value="{$valQbFirstname}"/>
<input type="hidden" name="qbLastname" value="{$valQbLastname}"/>
<input type="hidden" name="qbAddress" value="{$valQbAddress}"/>
<input type="hidden" name="qbCity" value="{$valQbCity}"/>
<input type="hidden" name="qbPostcode" value="{$valQbPostcode}"/>
<input type="hidden" name="qbCountry" value="{$valQbCountry}"/>
<input type="hidden" name="qbEmail" value="{$valQbEmail}"/>

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
    for (i = 1; i < rows.length-1; i++) {
        rows[i].onclick = function() {
			for (j = 1; j < rows.length-1; j++) {
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
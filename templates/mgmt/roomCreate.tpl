{extends file="mgmt/base.tpl"}
{block name="body"}
{message name="mgmt-room-createheader"}
<form method="post" action="{$cScriptPath}/Rooms?action=create">
<div id="constraint">
<label class="infield">{message name="room-name"}<input type="text" name="rname" /></label>
<label class="infield">{message name="room-type"}<select name="rtype">{include file="roomtypelist.tpl"}</select></label>
<label class="infield">{message name="room-minp"}<input type="text" name="rmin" /></label>
<label class="infield">{message name="room-maxp"}<input type="text" name="rmax" /></label>
<label class="infield">{message name="room-price"}<input type="text" name="rprice" /></label>
<input id="submitbutton" type="submit"/>
</div>
</form>
{/block}

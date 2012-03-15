<label class="infield">{message name="room-name"}<input type="text" name="rname" value="{$rname}" /></label>
<label class="infield">{message name="room-type"}<select name="rtype">{include file="roomtypelist.tpl" selected=$rtype}</select></label>
<label class="infield">{message name="room-minp"}<input type="text" name="rmin" value="{$rmin}" /></label>
<label class="infield">{message name="room-maxp"}<input type="text" name="rmax" value="{$rmax}" /></label>
<label class="infield">{message name="room-price"}<input type="text" name="rprice" value="{$rprice}" /></label>
<input id="submitbutton" type="submit"/>
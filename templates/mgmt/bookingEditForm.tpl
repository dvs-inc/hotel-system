<label class="infield">{message name="booking-customer"}<input type="text" name="bcust" value="{$bcust}" /></label>
<label class="infield">{message name="booking-adults"}<input type="text" id="adultInput" name="badults" value="{$badults}" /></label>
<label class="infield">{message name="booking-children"}<input type="text" name="bchildren" value="{$bchildren}" /></label>
<label class="infield checkdate">{message name="checkin"}<div class="cal"><input id="checkinJS" type="button" value=""/> </div><input id="checkinInput" name="qbCheckin" class="datainput" value="{$bstart}" /></label>
<label class = "infield checkdate">{message name="checkout"}<div class="cal"><input id="checkoutJS" type="button" value=""/> </div><input id="checkoutInput" name="qbCheckout" class="datainput" value="{$bend}" /></label>
<label class="infield">{message name="booking-promocode"}<input type="text" name="bpromo" value="{$bpromo}" /></label>
<label class="infield">{message name="booking-room"}<input type="text" name="broom" value ="{$broom}" /></label>
<input id="submitbutton" type="submit" />
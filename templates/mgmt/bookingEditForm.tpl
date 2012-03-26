<label class="infield">{message name="booking-customer"}<input type="text" name="bcust" value="{$bcust}" /></label>
<label class="infield">{message name="booking-adults"}<input type="text" name="badults" value="{$badults}" /></label>
<label class="infield">{message name="booking-children"}<input type="text" name="bchildren" value="{$bchildren}" /></label>
<label class="cal">{message name="checkin"}<input id="checkinInput" name="qbCheckin" class="datainput" value="{$bstart}" /><input id="checkinJS" type="button" value=""/> </label>
<label>{message name="checkout"}<input id="checkoutInput" name="qbCheckout" class="datainput" value="{$bend}" /></label>
<div class="cal"><input id="checkoutJS" type="button" value=""/> </div>
<label class="infield">{message name="booking-promocode"}<input type="text" name="bpromo" value="{$bpromo}" /></label>
<input id="submitbutton" type="submit"/>
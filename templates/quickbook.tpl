<label>{message name="checkin"}<input id="checkinInput" name="qbCheckin" class="datainput" value="{$valQbCheckin}" /></label>
<div class="cal"><input id="checkinJS" type="button" value=""/> </div>
<label>{message name="checkout"}<input id="checkoutInput" name="qbCheckout" class="datainput" value="{$valQbCheckout}" /></label>
<div class="cal"><input id="checkoutJS" type="button" value=""/> </div>
<label id="adult">{message name="num-adults"}<input name="qbAdults" id="adultInput" class="datainput adultchild" value="{$valQbAdults}" maxlength="2" onkeypress="validateNum(event)" /></label>
<label id="child">{message name="num-children"}<input name="qbChildren" id="childInput" class="datainput adultchild" value="{$valQbChildren}" maxlength="2" onkeypress="validateNum(event)" /></label>
<label class="promo">{message name="promocode"}<input name="qbPromoCode" class="datainput" value="{$valQbPromoCode}" maxlength="9" onkeyup="javascript:this.value=this.value.toUpperCase();" /></label>
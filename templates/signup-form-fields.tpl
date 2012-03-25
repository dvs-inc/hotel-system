<div id="signup-title"><label>{message name="title"}<br><select name="suTitle">{include file="titles.tpl" selectedVal="{$suTitle}"}</select></label></div>
<div id="signup-firstname"><label>{message name="firstname"}<input name="suFirstname" class="datainput" value="{$suFirstname}"/></label></div>
<div id="signup-lastname"><label>{message name="lastname"}<input name="suLastname" class="datainput" value="{$suLastname}" /></label></div>
<div id="signup-address"><label>{message name="address"}<input name="suAddress" class="datainput" value="{$suAddress}" /></label></div>
<div id="signup-city"><label>{message name="city"}<input name="suCity" class="datainput" value="{$suCity}" /></label></div>
<div id="signup-postcode"><label>{message name="postcode"}<input name="suPostcode" class="datainput" value="{$suPostcode}" /></label></div>
<div id="signup-country"><label>{message name="country"}<br><select name="suCountry" id="dropDownCountry">{include file="countries.tpl" selectedVal="{$suCountry}"}</select></label></div>
<div id="signup-email"><label>{message name="email"}<input name="suEmail" class="datainput" value="{$suEmail}"/></label></div>
<div id="signup-password"><label>{message name="signup-password"}<input name="suPassword" type="password" /></label></div>
<div id="signup-confirm-password"><label>{message name="signup-confirm-password"}<input name="suConfirm" type="password" /></label></div>
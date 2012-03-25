{extends file="base.tpl"}

{block name="body"}
<h2>{message name="page-signup-title"}</h2>
<div id="signupform"><form method="post">
<div id="signup-title">	<label>{message name ="title"}<select name="suTitle">{include file="titles.tpl"}</select></label></div>
<div id="signup-firstname">	<label>{message name="firstname"}<input name="suFirstname" class="datainput" /></label></div>
<div id="signup-lastname"> <label>{message name="lastname"}<input name="suLastname" class="datainput" /></label></div>
<div id="signup-address"> <label>{message name="address"}<input name="suAddress" class="datainput" /></label></div>
<div id="signup-city"> <label>{message name="city"}<input name="suCity" class="datainput" /></label></div>
<div id="signup-postcode"> <label>{message name="postcode"}<input name="suPostcode" class="datainput" /></label></div>
<div id="signup-country"> <label>{message name="country"}<select name="suCountry" id="dropDownCountry">{include file="countries.tpl"}</select></label></div>
<div id="signup-email">	<label>{message name="email"}<input name="suEmail" class="datainput"/></label></div>
<div id="signup-password"><label>{message name="signup-password"}<input name="suPassword" type="password" /></label></div>
<div id="signup-confirm-password"><label>{message name="signup-confirm-password"}<input name="suConfirm" type="password" /></label></div>
<div id="submit"><input type="submit" value="{message name="signup-submitbutton"}"/></div>
</form></div>
{/block}

{* This is a comment *}

{extends file="base.tpl"}

{block name="body"}
<h2>{message name="page-signup-title"}</h2>
<p>(*) Required Fields</p><br>
<div id="signupform"><form method="post" action="{$cScriptPath}/Signup">
{include file="signup-form-fields.tpl" suTitle="" suFirstname="" suLastname="" suAddress="" suCity="" suPostcode="" suCountry=" " suEmail=""}
{* Leave the space in the suCountry default above, it's meant to be there :) stw *}
<div id="submit"><input type="submit" value="{message name="signup-submitbutton"}"/></div>
</form></div>
{/block}

{* This is a comment *}

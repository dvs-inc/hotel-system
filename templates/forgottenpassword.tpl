{extends file="base.tpl"}

{* forgotPassword.tpl *}

{block name="body"}
<h2>{message name="page-forgotPassword-title"}</h2>
<p>{message name="page-forgotPassword-desc"}</p><br>
<div id="forgottenPasswordForm"><form method="post" action="{cScriptPath}/forgotPassword">
<div id="signup-email"><label>{message name="forgot-Password-Email"}<input name="suEmail"/></label></div>
<div id="submit"><input type="submit" value="{message name="forgotPassword-submitButton"}"/></div>
</form></div>
{/block}

{* this is a comment *}
{extends file="mgmt/base.tpl"}
{block name="body"}
{message name="mgmt-user-createheader"}
<form method="post" action="{$cScriptPath}/SystemUsers?action=create">
<label>{message name="login-username"}<input type="text" name="username" /></label>
<label>{message name="login-password"}<input type="password" name="pass" /></label>
<label>{message name="confirmpassword"}<input type="password" name="pass2" /></label>
<input type="submit"/>
</form>
{/block}

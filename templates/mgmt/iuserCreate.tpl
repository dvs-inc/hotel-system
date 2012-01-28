{extends file="mgmt/base.tpl"}
{block name="body"}
{message name="mgmt-user-createheader"}
<form method="post" action="{$cScriptPath}/SystemUsers?action=create">
<label class="infield floatleft">{message name="login-username"}<input type="text" name="username" /></label>
<label class="infield floatleft">{message name="login-password"}<input type="password" name="pass" /></label>
<label class="infield">{message name="confirmpassword"}<input type="password" name="pass2" /></label>
<input id="submitbutton" type="submit"/>
</form>
{/block}

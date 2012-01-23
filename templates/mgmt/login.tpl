{extends file="mgmt/base.tpl"}
{block name="body"}
{message name="login-required"}
<div id="loginform"><form method="post">
<div id="username"><label>{message name="login-username"}<input name="lgUsername" /></label></div>
<div id="password"><label>{message name="login-password"}<input name="lgPassword" type="password" /></label></div>
<div id="submit"><input type="submit" value="{message name="login-loginbutton"}"/></div>
<div><input style="left:100px;" type="submit" value="bypass" name="bypass"/></div>
</form></div>
{/block}

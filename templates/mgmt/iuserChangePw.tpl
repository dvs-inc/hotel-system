{extends file="mgmt/base.tpl"}
{block name="body"}
{message name="mgmt-user-changepwheader"}
<form method="post" action="{$cScriptPath}/SystemUsers?action=changepw&id={$userid}">
<label>{message name="newpassword"}<input type="password" name="newpass" /></label>
<label>{message name="confirmpassword"}<input type="password" name="newpass2" /></label>
<input type="submit"/>
</form>
{/block}

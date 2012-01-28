{extends file="mgmt/base.tpl"}
{block name="body"}
{message name="mgmt-user-changepwheader"}
<form method="post" action="{$cScriptPath}/SystemUsers?action=changepw&id={$userid}">
<label class="infield floatleft">{message name="newpassword"}<input type="password" name="newpass" /></label>
<label class="infield">{message name="confirmpassword"}<input type="password" name="newpass2" /></label>
<input id="submitbutton" type="submit"/>
</form>
{/block}

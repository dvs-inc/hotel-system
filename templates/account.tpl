{extends file="base.tpl"}

{block name="body"}
<h2>{message name="page-account-title"}</h2>
<form method="post" action="{$cScriptPath}/Account">
<div id="constraint">
{include file="signup-form-fields.tpl"}
<input id="submitbutton" type="submit"/>
</div>
</form>
{/block}

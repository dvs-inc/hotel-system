{extends file="base.tpl"}

{block name="body"}
<h2>{message name="page-signup-title"}</h2>
<div id="signupform"><form method="post">
{include file="signup-form-fields.tpl"}
<div id="submit"><input type="submit" value="{message name="signup-submitbutton"}"/></div>
</form></div>
{/block}

{* This is a comment *}

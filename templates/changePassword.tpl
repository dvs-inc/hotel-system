{extends file="base.tpl"}

{block name="body"}
	<h2>{message name="page-changePassword-title"}</h2>
	<p>{message name="page-changePassword-desc"}</p>
	<div id="changePasswordForm">
		<form method="post" action="{$cScriptPath}/ForgotPassword?id={$cpid}&hash={$cphash}">
			<div id="signup-password">
				<label>{message name="change-Password"}<input name="suPassword" type="password" /></label>
			</div>
			<div id="signup-confirm-password">
				<label>{message name="confirm-change-Password"}<input name="suConfirm" type="password" /></label>
			</div>
			<div id="submit">
				<input type="submit" value="{message name="changePassword-submitButton"}"/>
			</div>
		</form>
	</div>
{/block}



<div id="header">
	<div id="logo"><img alt="{message name="logo-alt"}"  src="{$cWebPath}/images/bflogo.png" /></div>
	{block name="accountarea"}
	<div id="login">
		<form action="{$cWebPath}/index.php/Login?returnto={$currentPagePath}" method="post">
			<div id="loginparts">
				<label>
					{message name="login-email"}
					<input class="datainput" name="lgEmail" type="text" />
				</label>
				<label>
					{message name="login-password"}
					<input class="datainput" name="lgPasswd" type="password"/>
				</label>
				<label>
					&nbsp;
					<input id="submitbutton" type="submit" value="{message name="login-loginbutton"}"/>
				</label>
			</div>
		</form>
		<div id="loginlinks" >
			<ul>
				<li><a href="{$cScriptPath}/ForgotPassword">{message name="login-forgotpassword"}</a></li>
				<li><a href="{$cScriptPath}/Signup">{message name="login-signup"}</a></li>
			</ul>
		</div>
		{if $lgerror != ""}
			<div id="loginerror">
				{message name="lgerror-{$lgerror}"}
			</div>
		{/if}
	</div>
	{/block}
</div>

<div id="header">
	<div id="logo"><img alt="{message name="logo-alt"}"  src="{$cWebPath}/images/bflogo.png" /></div>
	<div id="login">
		<form action="" method="post">
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
	</div>
</div>
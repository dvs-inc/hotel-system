{extends file="twocolumn.tpl"}

{block name="columnone"}
	<h2>{message name="roomdetails"}</h2>
	{include file="quickbook.tpl"}
{/block}

{block name="columntwo"}
	<h2>{message name="yourdetails"}</h2>
	<label>{message name="firstname"}<input name="qbFirstname" class="datainput" /></label>
	<label>{message name="lastname"}<input name="qbLastname" class="datainput" /></label>
	<label>{message name="address"}<input name="qbAddress" class="datainput" /></label>
	<label>{message name="city"}<input name="qbCity" class="datainput" /></label>
	<label>{message name="postcode"}<input name="qbPostcode" class="datainput" /></label>
	<label>{message name="country"}<select name="qbCountry"/></label>
	<label>{message name="email"}<select name="qbEmail"/></label>
	<input type="submit" id="submitbutton" value="{message name="check-availability"}"/>
{/block}

{block name="twocolpre"}
	<form action="#" method="post">
{/block}

{block name="twocolpost"}
	</form>
{/block}
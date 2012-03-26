{extends file="twocolumn.tpl"}

{block name="columnone"}
	<h2>{message name="roomdetails"}</h2>
	{include file="quickbook.tpl"}
{/block}

{block name="columntwo"}
	<h2>{message name="yourdetails"}</h2>
	<label>{message name="title"}<select name="qbTitle" id="titleInput" class="dropDown">{include file="titles.tpl" selectedVal=""}</select></label>
	<label>{message name="firstname"}<input name="qbFirstname" id="firstnameInput" class="datainput" /></label>
	<label>{message name="lastname"}<input name="qbLastname" id="lastnameInput" class="datainput" /></label>
	<label>{message name="address"}<input name="qbAddress" id="addressInput" class="datainput" /></label>
	<label>{message name="city"}<input name="qbCity" id="cityInput" class="datainput" /></label>
	<label>{message name="postcode"}<input name="qbPostcode" id="postcodeInput" class="datainput" /></label>
	<label>{message name="country"}<select name="qbCountry" id="countryInput" class="dropDown">{include file="countries.tpl" selectedVal=" "}</select></label>
	<label>{message name="email"}<input name="qbEmail" id="emailInput" class="datainput"/></label>
	<input type="submit" id="submitbutton" value="{message name="check-availability"}"/>
{/block}

{block name="twocolpre"}
	<form name="quickBookAndDetails" action="#" method="post" onsubmit="return validateForm();">
{/block}

{block name="twocolpost"}
	</form>
	
	<script type="text/javascript">
	
	function validateNum(evt) {
  		var theEvent = evt || window.event;
  		var key = theEvent.keyCode || theEvent.which;
  		key = String.fromCharCode( key );
  		var regex = /[0-9]/;
  		if( !regex.test(key) ) {
    		theEvent.returnValue = false;
    		if(theEvent.preventDefault) theEvent.preventDefault();
  		}
	}
	
	function validateForm()
	{
	var z="";
	var checkin=document.forms["quickBookAndDetails"]["qbCheckin"].value;
	var checkout=document.forms["quickBookAndDetails"]["qbCheckout"].value;
	var adultNum=document.forms["quickBookAndDetails"]["qbAdults"].value;
	
	var title=document.forms["quickBookAndDetails"]["qbTitle"].value;
	var firstname=document.forms["quickBookAndDetails"]["qbFirstname"].value;
	var lastname=document.forms["quickBookAndDetails"]["qbLastname"].value;
	var address=document.forms["quickBookAndDetails"]["qbAddress"].value;
	var city=document.forms["quickBookAndDetails"]["qbCity"].value;
	var postcode=document.forms["quickBookAndDetails"]["qbPostcode"].value;
	var country=document.forms["quickBookAndDetails"]["qbCountry"].value;
	var email=document.forms["quickBookAndDetails"]["qbEmail"].value;
	
	var atpos=email.indexOf("@");
	var dotpos=email.lastIndexOf(".");
	
	var date = new Date();
	var dd = date.getDate();
	var mm = date.getMonth()+1;
	var yyyy = date.getFullYear();
	
	var checkinInvalid = 0;
	var checkoutInvalid = 0;
	
	if (checkin==null || checkin=="")
	{
		z+="Check in date must be filled out.\n\n";
		checkinInvalid = 1;
	}
	else
	{
		if (checkin.substring(6) < yyyy)
		{
			z+="Cannot check in before today.\n\n";
			checkinInvalid = 1;
		}
		else if (checkin.substring(6) == yyyy && checkin.substring(3,5) < mm)
		{
			z+="Cannot check in before today.\n\n";
			checkinInvalid = 1;
		}
		else if (checkin.substring(6) == yyyy && checkin.substring(3,5) == mm && checkin.substring(0,2) < dd)
		{
			z+="Cannot check in before today.\n\n";
			checkinInvalid = 1;
		}
	}
	
	if (checkout==null || checkout=="")
	{
		z+="Check out date must be filled out.\n\n";
		checkoutInvalid = 1;
	}
	else
	{
		if (checkout.substring(6) < yyyy)
		{
			z+="Cannot check out before today.\n\n";
			checkoutInvalid = 1;
		}
		else if (checkout.substring(6) == yyyy && checkout.substring(3,5) < mm)
		{
			z+="Cannot check out before today.\n\n";
			checkoutInvalid = 1;
		}
		else if (checkout.substring(6) == yyyy && checkout.substring(3,5) == mm && checkout.substring(0,2) < dd)
		{
			z+="Cannot check out before today.\n\n";
			checkoutInvalid = 1;
		}
	}

	if (checkinInvalid==0 && checkoutInvalid==0)
	{
		if (checkin.substring(6) > checkout.substring(6))
		{
			z+="Cannot checkout before checked in.\n\n";
			checkinInvalid = 1;
			checkoutInvalid = 1;
		}
		else if (checkin.substring(6) == checkout.substring(6) && checkin.substring(3,5) > checkout.substring(3,5))
		{
			z+="Cannot checkout before checked in.\n\n";
			checkinInvalid = 1;
			checkoutInvalid = 1;
		}
		else if (checkin.substring(6) == checkout.substring(6) && checkin.substring(3,5) == checkout.substring(3,5) && checkin.substring(0,2) > checkout.substring(0,2))
		{
			z+="Cannot checkout before checked in.\n\n";
			checkinInvalid = 1;
			checkoutInvalid = 1;
		}
		else if (checkin.substring(0,2) == checkout.substring(0,2))
		{
			z+="Cannot check in and out on the same day.\n\n";
			checkinInvalid = 1;
			checkoutInvalid = 1;	
		}
	}
	
	if (checkinInvalid==0)
	{
		$("#checkinInput").css("border-style","hidden");
	}
	else
	{
		$("#checkinInput").css("border-color","red");
		$("#checkinInput").css("border-style","solid");
	}
	
	if (checkoutInvalid==0)
	{
		$("#checkoutInput").css("border-style","hidden");
	}
	else
	{
		$("#checkoutInput").css("border-color","red");
		$("#checkoutInput").css("border-style","solid");
	}
	
	if (adultNum==null || adultNum=="")
	{
		z+="Adults field must be filled out.\n\n";
		$("#adultInput").css("border-color","red");
		$("#adultInput").css("border-style","solid");
	}
	else if (adultNum < 1)
	{
		z+="Invalid adult entry.\n\n";
		$("#adultInput").css("border-color","red");
		$("#adultInput").css("border-style","solid");
	}
	else $("#adultInput").css("border-style","hidden");
	
	if (title==null || title=="")
	{
		z+="Please select a title.\n\n";
		$("#titleInput").css("border-color","red");
		$("#titleInput").css("border-style","solid");
	}
	else $("#titleInput").css("border-style","hidden");
	
	if (firstname==null || firstname=="")
	{
		z+="First name must be filled out.\n\n";
		$("#firstnameInput").css("border-color","red");
		$("#firstnameInput").css("border-style","solid");
	}
	else $("#firstnameInput").css("border-style","hidden");
	
	if (lastname==null || lastname=="")
	{
		z+="Last name must be filled out.\n\n";
		$("#lastnameInput").css("border-color","red");
		$("#lastnameInput").css("border-style","solid");
	}
	else $("#lastnameInput").css("border-style","hidden");
	
	if (address==null || address=="")
	{
		z+="Address must be filled out.\n\n";
		$("#addressInput").css("border-color","red");
		$("#addressInput").css("border-style","solid");
	}
	else $("#addressInput").css("border-style","hidden");
	
	if (city==null || city=="")
	{
		z+="City must be filled out.\n\n";
		$("#cityInput").css("border-color","red");
		$("#cityInput").css("border-style","solid");
	}
	else $("#cityInput").css("border-style","hidden");
	
	if (postcode==null || postcode=="")
	{
		z+="Postcode must be filled out.\n\n";
		$("#postcodeInput").css("border-color","red");
		$("#postcodeInput").css("border-style","solid");
	}
	else $("#postcodeInput").css("border-style","hidden");
	
	if (country==null || country==" ")
	{
		z+="Please select a country.\n\n";
		$("#countryInput").css("border-color","red");
		$("#countryInput").css("border-style","solid");
	}
	else $("#countryInput").css("border-style","hidden");
	
	if (email==null || email=="")
	{
		z+="E-mail must be filled out.\n\n";
		$("#emailInput").css("border-color","red");
		$("#emailInput").css("border-style","solid");
	}
	else if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length)
  	{
  		z+="Not a valid e-mail address";
  	}
	else
	{
		$("#emailInput").css("border-style","hidden");
	}
	
	if (z!="")
		{
			alert(z);
			return false;
		}
	}
	
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"checkinJS",
			display:"checkinInput",
			dateFormat:"%d-%m-%Y",
			path:"{$cWebPath}",
			yearsRange:[2011,2015]
		});

		new JsDatePick({
			useMode:2,
			target:"checkoutJS",
			display:"checkoutInput",
			dateFormat:"%d-%m-%Y",
			path:"{$cWebPath}",
			yearsRange:[2012,2015]			
		});
	};
	</script>
{/block}
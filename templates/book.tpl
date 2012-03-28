{extends file="twocolumn.tpl"}

{block name="columnone"}
	<h2>{message name="roomdetails"}</h2>
	{include file="quickbook.tpl"}
{/block}

{block name="columntwo"}
	<h2>{message name="yourdetails"}</h2>
	<label>{message name="title"}<select name="qbTitle" id="titleInput" class="dropDown">{include file="titles.tpl" selectedVal="{$qbTitle}"}</select></label>
	<label>{message name="firstname"}<input name="qbFirstname" id="firstnameInput" class="datainput" value="{$qbFirstname}" /></label>
	<label>{message name="lastname"}<input name="qbLastname" id="lastnameInput" class="datainput"  value="{$qbLastname}"/></label>
	<label>{message name="address"}<input name="qbAddress" id="addressInput" class="datainput"  value="{$qbAddress}"/></label>
	<label>{message name="city"}<input name="qbCity" id="cityInput" class="datainput"  value="{$qbCity}"/></label>
	<label>{message name="postcode"}<input name="qbPostcode" id="postcodeInput" class="datainput"  value="{$qbPostcode}"/></label>
	<label>{message name="country"}<select name="qbCountry" id="countryInput" class="dropDown">{include file="countries.tpl" selectedVal="$qbCountry"}</select></label>
	<label>{message name="email"}<input name="qbEmail" id="emailInput" class="datainput"  value="{$qbEmail}"/></label>
	<input type="submit" id="submitbutton" value="{message name="check-availability"}"/>
{/block}

{block name="twocolpre"}
	<form name="quickBookAndDetails" action="{$cScriptPath}/Calendar" method="post" onsubmit="return validateForm();">
{/block}

{block name="twocolpost"}
	</form>
	
	<script type="text/javascript">
	
	function validateNum(evt) {
  		var theEvent = evt || window.event;
  		var key = theEvent.keyCode || theEvent.which;
  		key = String.fromCharCode( key );
  		var regex = /[0-9]/;
  		if( key!="\b" && theEvent.keyCode!=37 && theEvent.keyCode!=39 && theEvent.keyCode!=46 && theEvent.keyCode < 112 && theEvent.keyCode > 123 && key!="\t" && !regex.test(key) ) {
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
	
	var regex = /[0-9]/;
	
	if (checkin==null || checkin=="")
	{
		z+="{message name="book-error-nocheckin"}\n\n";
		checkinInvalid = 1;
	}
	else
	{
		if (checkin.length != 10)
		{
			z+="{message name="book-error-invalid-checkin"}\n\n";
			checkinInvalid = 1;
		}
		else if (!regex.test(checkin.substring(0,1))
				|| !regex.test(checkin.substring(1,2))
				|| checkin.substring(2,3)!="-"
				|| !regex.test(checkin.substring(3,4))
				|| !regex.test(checkin.substring(4,5))
				|| checkin.substring(5,6)!="-"
				|| !regex.test(checkin.substring(6,7))
				|| !regex.test(checkin.substring(7,8))
				|| !regex.test(checkin.substring(8,9))
				|| !regex.test(checkin.substring(9)))
		{
			z+="{message name="book-error-invalid-checkin"}\n\n";
			checkinInvalid = 1;
		}
		else if (checkin.substring(6) < yyyy)
		{
			z+="{message name="book-error-checkin-before-today"}\n\n";
			checkinInvalid = 1;
		}
		else if (checkin.substring(6) == yyyy && checkin.substring(3,5) < mm)
		{
			z+="{message name="book-error-checkin-before-today"}\n\n";
			checkinInvalid = 1;
		}
		else if (checkin.substring(6) == yyyy && checkin.substring(3,5) == mm && checkin.substring(0,2) < dd)
		{
			z+="{message name="book-error-checkin-before-today"}\n\n";
			checkinInvalid = 1;
		}
	}
	
	if (checkout==null || checkout=="")
	{
		z+="{message name="book-error-nocheckout"}\n\n";
		checkoutInvalid = 1;
	}
	else
	{
		if (checkout.length != 10)
		{
			z+="{message name="book-error-invalid-checkout"}\n\n";
			checkoutInvalid = 1;
		}
		else if (!regex.test(checkout.substring(0,1))
				|| !regex.test(checkout.substring(1,2))
				|| checkout.substring(2,3)!="-"
				|| !regex.test(checkout.substring(3,4))
				|| !regex.test(checkout.substring(4,5))
				|| checkout.substring(5,6)!="-"
				|| !regex.test(checkout.substring(6,7))
				|| !regex.test(checkout.substring(7,8))
				|| !regex.test(checkout.substring(8,9))
				|| !regex.test(checkout.substring(9)))
		{
			z+="{message name="book-error-invalid-checkout"}\n\n";
			checkoutInvalid = 1;
		}
		else if (checkout.substring(6) < yyyy)
		{
			z+="{message name="book-error-checkout-before-today"}\n\n";
			checkoutInvalid = 1;
		}
		else if (checkout.substring(6) == yyyy && checkout.substring(3,5) < mm)
		{
			z+="{message name="book-error-checkout-before-today"}\n\n";
			checkoutInvalid = 1;
		}
		else if (checkout.substring(6) == yyyy && checkout.substring(3,5) == mm && checkout.substring(0,2) < dd)
		{
			z+="{message name="book-error-checkout-before-today"}\n\n";
			checkoutInvalid = 1;
		}
	}

	if (checkinInvalid==0 && checkoutInvalid==0)
	{
		if (checkin.substring(6) > checkout.substring(6))
		{
			z+="{message name="book-error-checkout-before-checked-in"}\n\n";
			checkinInvalid = 1;
			checkoutInvalid = 1;
		}
		else if (checkin.substring(6) == checkout.substring(6) && checkin.substring(3,5) > checkout.substring(3,5))
		{
			z+="{message name="book-error-checkout-before-checked-in"}\n\n";
			checkinInvalid = 1;
			checkoutInvalid = 1;
		}
		else if (checkin.substring(6) == checkout.substring(6) && checkin.substring(3,5) == checkout.substring(3,5) && checkin.substring(0,2) > checkout.substring(0,2))
		{
			z+="{message name="book-error-checkout-before-checked-in"}\n\n";
			checkinInvalid = 1;
			checkoutInvalid = 1;
		}
		else if (checkin.substring(0,2) == checkout.substring(0,2))
		{
			z+="{message name="book-error-checkin-out-same-day"}\n\n";
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
		z+="{message name="book-error-noadult"}\n\n";
		$("#adultInput").css("border-color","red");
		$("#adultInput").css("border-style","solid");
	}
	else if (adultNum < 1)
	{
		z+="{message name="book-error-invalid-adultentry"}\n\n";
		$("#adultInput").css("border-color","red");
		$("#adultInput").css("border-style","solid");
	}
	else $("#adultInput").css("border-style","hidden");
	
	if (title==null || title=="")
	{
		z+="{message name="book-error-notitle"}\n\n";
		$("#titleInput").css("border-color","red");
		$("#titleInput").css("border-style","solid");
	}
	else $("#titleInput").css("border-style","hidden");
	
	if (firstname==null || firstname=="")
	{
		z+="{message name="book-error-nofirstname"}\n\n";
		$("#firstnameInput").css("border-color","red");
		$("#firstnameInput").css("border-style","solid");
	}
	else $("#firstnameInput").css("border-style","hidden");
	
	if (lastname==null || lastname=="")
	{
		z+="{message name="book-error-nolastname"}\n\n";
		$("#lastnameInput").css("border-color","red");
		$("#lastnameInput").css("border-style","solid");
	}
	else $("#lastnameInput").css("border-style","hidden");
	
	if (address==null || address=="")
	{
		z+="{message name="book-error-noaddress"}\n\n";
		$("#addressInput").css("border-color","red");
		$("#addressInput").css("border-style","solid");
	}
	else $("#addressInput").css("border-style","hidden");
	
	if (city==null || city=="")
	{
		z+="{message name="book-error-nocity"}\n\n";
		$("#cityInput").css("border-color","red");
		$("#cityInput").css("border-style","solid");
	}
	else $("#cityInput").css("border-style","hidden");
	
	if (postcode==null || postcode=="")
	{
		z+="{message name="book-error-nopostcode"}\n\n";
		$("#postcodeInput").css("border-color","red");
		$("#postcodeInput").css("border-style","solid");
	}
	else $("#postcodeInput").css("border-style","hidden");
	
	if (country==null || country==" ")
	{
		z+="{message name="book-error-nocountry"}\n\n";
		$("#countryInput").css("border-color","red");
		$("#countryInput").css("border-style","solid");
	}
	else $("#countryInput").css("border-style","hidden");
	
	if (email==null || email=="")
	{
		z+="{message name="book-error-noemail"}\n\n";
		$("#emailInput").css("border-color","red");
		$("#emailInput").css("border-style","solid");
	}
	else if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length)
  	{
  		z+="{message name="book-error-invalid-email"}";
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
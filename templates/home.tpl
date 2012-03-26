{extends file="twocolumnuneven.tpl"}

{block name="columnone"}
	{message name="home-column1"}		
{/block}

{block name="columntwo"}
	<h2>{message name="quick-book"}</h2>
	<form name="quickBook" method="post" onsubmit="return validateForm();" action="{$cScriptPath}/Book">
	{include file="quickbook.tpl"}
	<input id="submitbutton" type="submit" value="{message name="check-availability"}"/>
	</form>
	
	<script type="text/javascript">
	
	function validateNum(evt) {
  		var theEvent = evt || window.event;
  		var key = theEvent.keyCode || theEvent.which;
  		key = String.fromCharCode( key );
  		var regex = /[0-9]/;
  		if( key!="\b" && theEvent.keyCode!=37 && theEvent.keyCode!=39 && theEvent.keyCode!=46 && (theEvent.keyCode < 112 || theEvent.keyCode > 123) && key!="\t" && !regex.test(key) ) {
    		theEvent.returnValue = false;
    		if(theEvent.preventDefault) theEvent.preventDefault();
  		}
	}

	
	function validateForm()
	{
	var z="";
	var checkin=document.forms["quickBook"]["qbCheckin"].value;
	var checkout=document.forms["quickBook"]["qbCheckout"].value;
	var adultNum=document.forms["quickBook"]["qbAdults"].value;
	

	var date = new Date();
	var dd = date.getDate();
	var mm = date.getMonth()+1;
	var yyyy = date.getFullYear();
	
	var checkinInvalid = 0;
	var checkoutInvalid = 0;
	
	if (checkin==null || checkin=="")
	{
		z+="{message name="book-error-nocheckin"}\n\n";
		checkinInvalid = 1;
	}
	else
	{
		if (checkin.substring(6) < yyyy)
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
		if (checkout.substring(6) < yyyy)
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
		z+="Adults field must be filled out.\n\n";
		$("#adult").css("margin-top","6px");
		$("#adultInput").css("border-color","red");
		$("#adultInput").css("border-style","solid");
	}
	else if (adultNum < 1)
	{
		z+="Invalid adult entry.\n\n";
		$("#adultInput").css("border-color","red");
		$("#adultInput").css("border-style","solid");
	}
	else
	{
		$("#adult").css("margin-top","10px");
		$("#adultInput").css("border-style","hidden");
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
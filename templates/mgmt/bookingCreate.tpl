{extends file="mgmt/base.tpl"}
{block name="body"}
{message name="mgmt-booking-createheader"}
<form name="bookingcreate" method="post" onsubmit="return validateForm();" action="{$cScriptPath}/Bookings?action=create">
<div id="constraint">
{include file="mgmt/bookingEditForm.tpl" bcust="" badults="" bchildren="" bstart="" bend="" bpromo=""}
</div>
</form>

<script type="text/javascript">
	
	function validateForm()
	{
	var z="";
	var checkin=document.forms["bookingcreate"]["qbCheckin"].value;
	var checkout=document.forms["bookingcreate"]["qbCheckout"].value;
	var adultNum=document.forms["bookingcreate"]["badults"].value;
	
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
		$("#checkinInput").css("border-color","#7F9DB9");
		$("#checkinInput").css("border-style","groove");
	}
	else
	{
		$("#checkinInput").css("border-color","red");
		$("#checkinInput").css("border-style","solid");
	}
	
	if (checkoutInvalid==0)
	{
		$("#checkoutInput").css("border-color","#7F9DB9");
		$("#checkoutInput").css("border-style","groove");
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
	else
	{
		$("#adultInput").css("border-color","#7F9DB9");
		$("#adultInput").css("border-style","groove");
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

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
  		if( !regex.test(key) ) {
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
	
	if (checkin==null || checkin=="") z+="Check in date must be filled out.\n\n";
		
	if (checkout==null || checkout=="") z+="Check out date must be filled out.\n\n";
	
	if (adultNum==null || adultNum=="") z+="Adults field must be filled out.\n\n";
	else if (adultNum < 1) z+="Invalid adult entry.\n\n";
	
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
			yearsRange:[2012,2015]
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
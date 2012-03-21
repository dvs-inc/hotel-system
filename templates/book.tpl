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
	<label>{message name="country"}<select name="qbCountry" id="dropDownCountry">{include file="countries.tpl"}</select></label>
	<label>{message name="email"}<input name="qbEmail" class="datainput"/></label>
	<input type="submit" id="submitbutton" value="{message name="check-availability"}"/>
{/block}

{block name="twocolpre"}
	<form action="#" method="post">
{/block}

{block name="twocolpost"}
	</form>
	
	<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"checkinJS",
			display:"checkinInput",
			dateFormat:"%d-%M-%Y"
			/*selectedDate:{				This is an example of what the full configuration offers.
				day:5,						For full documentation about these settings please see the full version of the code.
				month:9,
				year:2006
			},
			yearsRange:[1978,2020],
			limitToToday:false,
			cellColorScheme:"beige",
			dateFormat:"%m-%d-%Y",
			imgPath:"img/",
			weekStartDay:1*/
		});

		new JsDatePick({
			useMode:2,
			target:"checkoutJS",
			display:"checkoutInput",
			dateFormat:"%d-%M-%Y"
			/*selectedDate:{				This is an example of what the full configuration offers.
				day:5,						For full documentation about these settings please see the full version of the code.
				month:9,
				year:2006
			},
			yearsRange:[1978,2020],
			limitToToday:false,
			cellColorScheme:"beige",
			dateFormat:"%m-%d-%Y",
			imgPath:"img/",
			weekStartDay:1*/
		});
	};
	</script>
{/block}
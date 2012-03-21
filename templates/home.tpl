{extends file="twocolumnuneven.tpl"}

{block name="columnone"}
	{message name="home-column1"}		
{/block}

{block name="columntwo"}
	<h2>{message name="quick-book"}</h2>
	<form method="post" action="{$cScriptPath}/Book">
	{include file="quickbook.tpl"}
	<input id="submitbutton" type="submit" value="{message name="check-availability"}"/>
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
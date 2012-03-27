{extends file="base.tpl"}

{block name="body"}
	<h2>{message name="page-gallery-title"}</h2>
	<div id="thumbnails">
		<div class="thumbcontainer">
			<div class="therounit">
				<div class="thumb thero" id="mainPos1background">
					<img id="mainImage1" src="{$cWebPath}/images/bflogo.png" alt=""/>
				</div>
			</div>
			<div class="theroside">
				<div class="thumb">
					<img id="sideImage1" src="{$galimg1}" alt="" onclick="moveleft(this,'mainImage1','mainPos1background')" />
				</div>
				<div class="thumb">
					<img id="sideImage2" src="{$galimg1}" alt="" onclick="moveleft(this,'mainImage1','mainPos1background')" />
				</div>
			</div>
		</div>
		<div class="thumbcontainer">
			<div class="thumb">
				<img id="sideImage3" src="{$galimg1}" alt="" onclick="moveup(this,'mainImage1','mainPos1background')" />
			</div>
			<div class="thumb">
				<img id="sideImage4" src="{$galimg1}" alt="" onclick="moveup(this,'mainImage1','mainPos1background')" />
			</div>
			<div class="thumb">
				<img id="sideImage5" src="{$galimg1}" alt="" onclick="moveleftup(this,'mainImage1','mainPos1background')" />
			</div>
		</div>		
		<div class="thumbcontainer">
			<div class="thumb">
				<img id="sideImage6" src="{$galimg1}" alt="" onclick="movedown(this,'mainImage2','mainPos2background')" />
			</div>
			<div class="thumb">
				<img id="sideImage7" src="{$galimg1}" alt="" onclick="movedown(this,'mainImage2','mainPos2background')" />
			</div>
			<div class="thumb">
				<img id="sideImage8" src="{$galimg1}" alt="" onclick="moveleftdown(this,'mainImage2','mainPos2background')" />
			</div>
		</div>		
		<div class="thumbcontainer">
			<div class="therounit">
				<div class="thumb thero" id="mainPos2background">
					<img id="mainImage2" src="{$galimg1}" alt=""/>
				</div>
			</div>
			<div class="theroside">
				<div class="thumb">
					<img id="sideImage9" src="{$galimg1}" alt="" onclick="moveleft(this,'mainImage2','mainPos2background')" />
				</div>
				<div class="thumb">
					<img id="sideImage10" src="{$galimg1}" alt="" onclick="moveleft(this,'mainImage2','mainPos2background')" />
				</div>
			</div>
		</div>
		<div class="thumbcontainer">
			<div class="thumb">
				<img id="sideImage11" src="{$galimg1}" alt="" onclick="moveup(this,'mainImage2','mainPos2background')" />
			</div>
			<div class="thumb">
				<img id="sideImage12" src="{$galimg1}" alt="" onclick="moveup(this,'mainImage2','mainPos2background')" />
			</div>
			<div class="thumb">
				<img id="sideImage13" src="{$galimg1}" alt="" onclick="moveleftup(this,'mainImage2','mainPos2background')" />
			</div>
		</div>		
	</div>
	
	<script type="text/javascript">
	
	var opacityPercent = 1;
	
	var fish1Position = 0;
	var horizontal = [];
	var fillPosition = 10;
	var num = 20;
	for(var i = 0; i < num; ++i) {
        horizontal[i] = fillPosition;
        fillPosition -= 15;
	}

	function moveleft(obj, foreground, background) {
		document.getElementById(obj.id).style.position = "relative";
        document.getElementById(obj.id).style.left = horizontal[fish1Position] + "px";
		document.getElementById(obj.id).style.opacity = opacityPercent;
		opacityPercent -= 0.05;
        ++fish1Position;
        if (fish1Position == num) {
                document.getElementById(obj.id).style.left = "0px";
				document.getElementById(obj.id).style.opacity = 1;
				fish1Position = 0;
				opacityPercent = 1;
				setTimeout (FadeInImage(foreground,obj.src,background),500);
				return;
		}
		var tim1 = setTimeout(moveleft, 20, obj, foreground, background);
	}
	
	function moveup(obj, foreground, background) {
		document.getElementById(obj.id).style.position = "relative";
        document.getElementById(obj.id).style.top = horizontal[fish1Position] + "px";
		document.getElementById(obj.id).style.opacity = opacityPercent;
		opacityPercent -= 0.05;
        ++fish1Position;
        if (fish1Position == num) {
                document.getElementById(obj.id).style.top = "0px";
				document.getElementById(obj.id).style.opacity = 1;
				fish1Position = 0;
				opacityPercent = 1;
				setTimeout (FadeInImage(foreground,obj.src,background),500);
				return;
		}
		var tim1 = setTimeout(moveup, 20, obj, foreground, background);
	}
	
	function moveleftup(obj, foreground, background) {
		document.getElementById(obj.id).style.position = "relative";
        document.getElementById(obj.id).style.left = horizontal[fish1Position] + "px";
        document.getElementById(obj.id).style.top = horizontal[fish1Position] + "px";
		document.getElementById(obj.id).style.opacity = opacityPercent;
		opacityPercent -= 0.05;
        ++fish1Position;
        if (fish1Position == num) {
                document.getElementById(obj.id).style.left = "0px";
                document.getElementById(obj.id).style.top = "0px";
				document.getElementById(obj.id).style.opacity = 1;
				fish1Position = 0;
				opacityPercent = 1;
				setTimeout (FadeInImage(foreground,obj.src,background),500);
				return;
		}
		var tim1 = setTimeout(moveleftup, 20, obj, foreground, background);
	}

	function movedown(obj, foreground, background) {
		document.getElementById(obj.id).style.position = "relative";
        document.getElementById(obj.id).style.bottom = horizontal[fish1Position] + "px";
		document.getElementById(obj.id).style.opacity = opacityPercent;
		opacityPercent -= 0.05;
        ++fish1Position;
        if (fish1Position == num) {
                document.getElementById(obj.id).style.bottom = "0px";
				document.getElementById(obj.id).style.opacity = 1;
				fish1Position = 0;
				opacityPercent = 1;
				setTimeout (FadeInImage(foreground,obj.src,background),500);
				return;
		}
		var tim1 = setTimeout(movedown, 20, obj, foreground, background);
	}
	
	function moveleftdown(obj, foreground, background) {
		document.getElementById(obj.id).style.position = "relative";
        document.getElementById(obj.id).style.left = horizontal[fish1Position] + "px";
        document.getElementById(obj.id).style.bottom = horizontal[fish1Position] + "px";
		document.getElementById(obj.id).style.opacity = opacityPercent;
		opacityPercent -= 0.05;
        ++fish1Position;
        if (fish1Position == num) {
                document.getElementById(obj.id).style.left = "0px";
                document.getElementById(obj.id).style.bottom = "0px";
				document.getElementById(obj.id).style.opacity = 1;
				fish1Position = 0;
				opacityPercent = 1;
				setTimeout (FadeInImage(foreground,obj.src,background),500);
				return;
		}
		var tim1 = setTimeout(moveleftdown, 20, obj, foreground, background);
	}
	
	
	// Opacity and Fade in script.
	// Script copyright (C) 2008 http://www.cryer.co.uk/.
	// Script is free to use provided this copyright header is included.
	function SetOpacity(object,opacityPct)
	{
  		// IE.
  		object.style.filter = 'alpha(opacity=' + opacityPct + ')';
  		// Old mozilla and firefox
  		object.style.MozOpacity = opacityPct/100;
  		// Everything else.
  		object.style.opacity = opacityPct/100;
	}
	function ChangeOpacity(id,msDuration,msStart,fromO,toO)
	{
		var element=document.getElementById(id);
  		var opacity = element.style.opacity * 100;
  		var msNow = (new Date()).getTime();
  		opacity = fromO + (toO - fromO) * (msNow - msStart) / msDuration;
		if (opacity<0) 
    		SetOpacity(element,0)
  		else if (opacity>100)
    		SetOpacity(element,100)
  		else
  		{
    		SetOpacity(element,opacity);
    		element.timer = window.setTimeout("ChangeOpacity('" + id + "'," + msDuration + "," + msStart + "," + fromO + "," + toO + ")",1);
  		}
	}
	function FadeIn(id)
	{
  		var element=document.getElementById(id);
  		if (element.timer) window.clearTimeout(element.timer); 
  		var startMS = (new Date()).getTime();
  		element.timer = window.setTimeout("ChangeOpacity('" + id + "',1000," + startMS + ",0,100)",1);
}
	function FadeOut(id)
	{
  		var element=document.getElementById(id);
  		if (element.timer) window.clearTimeout(element.timer); 
  		var startMS = (new Date()).getTime();
  		element.timer = window.setTimeout("ChangeOpacity('" + id + "',1000," + startMS + ",100,0)",1);
	}
	function FadeInImage(foregroundID,newImage,backgroundID)
	{
  		var foreground=document.getElementById(foregroundID);
  		if (backgroundID)
  		{
    		var background=document.getElementById(backgroundID);
    		if (background)
    		{
	    		background.style.backgroundImage = 'url(' + foreground.src + ')';
      			background.style.backgroundRepeat = 'no-repeat';
    		}
  		}
  		SetOpacity(foreground,0);
  		foreground.src = newImage;
  		if (foreground.timer) window.clearTimeout(foreground.timer); 
  		var startMS = (new Date()).getTime();
  		foreground.timer = window.setTimeout("ChangeOpacity('" + foregroundID + "',1000," + startMS + ",0,100)",10);
	}
	</script>
{/block}

{* The idea for this is:
  +-----------+ +----+
  |           | |    |
  |           | +----+
  |           | +----+
  |           | |    |
  +-----------+ +----+
  +----+ +----+ +----+
  |    | |    | |    |
  +----+ +----+ +----+
*}

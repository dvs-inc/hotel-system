$(window).bind("load", function() {
	$("div#image").slideViewerPro({
		thumbs: 6, 
		autoslide: true, 
		asTimer: 3500, 
		typo: true,
		galBorderWidth: 0,
		thumbsBorderOpacity: 0, 
		buttonsTextColor: "#707070",
		buttonsWidth: 40,
		thumbsActiveBorderOpacity: 0.8,
		thumbsActiveBorderColor: "aqua",
		shuffle: true
	});
});
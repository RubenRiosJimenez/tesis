/*

    File Name: tpcrn_scripts.js

    Author : Raja CRN

	by ThemePacific

 */

 jQuery(document).ready(function () {

 /*Create the dropdown bases thanks to @chriscoyier*/

jQuery("#catnav").append('<select class="resp-nav container">');

	/* Create default option "Go to..."*/

	jQuery("<option />", {

	"selected": "selected",

	"value"   : "",

	"text"    : "Selecciona Menu"

	}).appendTo("#catnav select");

/* Populate dropdowns with the first menu items*/

jQuery("#catnav li ").each(function() {

	var href = jQuery(this).children('a').attr('href');

	var text = jQuery(this).children('a').html();

	var depth = jQuery(this).parents('ul').length;

	text = (depth > 1) ?   ' &nbsp;&mdash; ' + text : text;

	text = (depth > 2) ?   '&nbsp;&nbsp;'+ text : text;

	text = (depth > 3) ?   '&nbsp;&nbsp;&nbsp;&mdash;'+ text : text;

	 jQuery("#catnav select").append('<option value="' + href + '">' + text + '</option>');

});

/*make responsive dropdown menu actually work			*/

jQuery("#catnav select").change(function() {

	window.location = jQuery(this).find("option:selected").val();

});



/*cat nav menu*/

 

jQuery("#catnav ul li:has(ul)").addClass("parent"); 

 jQuery(".catnav li").hover(function () {

 jQuery(this).has('ul').addClass("dropme");

 jQuery(this).find('ul:first').css({display: "none"}).stop(true, true).slideDown(500);}, function () {

 jQuery(this).removeClass("dropme");

 jQuery(this).find('ul:first').css({display: "block"}).stop(true, true).slideUp(1000);

 });

});

 

 

	jQuery(window).load(function() {

		jQuery(function(){

		

		jQuery('.camera_wrap').camera({

				height				: '360px',

				loader				: 'bar',

				loaderColor			: '#06AFE4', 

				loaderBgColor		: '#2C2727', 

				loaderOpacity		: 1.0,	 

				loaderPadding		: 0,	 

				loaderStroke		: 4,

				pagination			: false,

				navigation			: true,

				autoAdvance			: true,

 

				easing				: 'easeInOutExpo',

				fx					: 'random',

				playPause			: false,	//true or false, to display or not the play/pause buttons

				pieDiameter			: 38,

				piePosition			: 'rightTop',	//'rightTop', 'leftTop', 'leftBottom', 'rightBottom'

				rows				: 4,

				slicedCols			: 6,

				slicedRows			: 4,

				opacityOnGrid		: false,

				thumbnails			: false,

				portrait			: false,

				time				: 7000,	//milliseconds between the end of the sliding effect

				transPeriod			: 1500,	//lenght of the sliding effect in milliseconds

			});

		

		

 

		});

	});
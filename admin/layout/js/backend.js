$(function () {
	'use strict';// لازم اكتب هيي الجملة دائما في الفانكشن 

	// #74 dashboard
	
	$('.toggle-info').click(function () {

		$(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);

		if ($(this).hasClass('selected')) {

			$(this).html('<i class="fa fa-plus fa-lg"></i>');   

		} else {

			$(this).html('<i class="fa fa-minus fa-lg"></i>');
		}

	});

	// #62 trigger the selectboxit 
	
	// #62 Calls the selectBoxIt method on your HTML select box and uses the default theme
    
    $("select").selectBoxIt( {

    	autoWidth: false
    } );

	// hide placeholder on form focus 
	$('[placeholder]').focus(function() {

		$(this).attr('data-text',$(this).attr('placeholder'));
		$(this).attr('placeholder','');
	}).blur (function() {

		$(this).attr('placeholder',$(this).attr('data-text'))
	});

	// #25

	// Add asterisk on required field 

	// $('input') قلتله حددلي عنصر الأنبوت يعني كل الأنبوت يلي عندي 

	// each : مشان شيك على كل الأنبوت يلي عندي

	// باختصار قلتله أي أنبوت فيه أتريبيوت يلي أسمه ريكيور حط بعده علامة ال * مشان اعرف انو هاد أجباري

	$('input').each(function () {

		if ($(this).attr('required') === 'required') {

			$(this).after('<span class="asterisk">*</span>');
		}
		
	});

	// #27 Convert password field to text field on hover 

	var passField = $('.password');

	$('.show-pass').hover(function() {

		passField.attr('type','text');

	}, function () {
		
		passField.attr('type','password');
	});

	// #31 confirmation message on button 

	$('.confirm').click(function() {

		return confirm('Are you sure?')

	});

	//#58 Category view option 

	$('.cat h3').click(function () {

		$(this).next('.full-view').fadeToggle(200);
	
	});

	$('.option span').click(function() {

		$(this).addClass('active').siblings('span').removeClass('active');

		if ($(this).data('view') == 'full') {

			$('.cat .full-view').fadeIn(200);

		} else {

			$('.cat .full-view').fadeOut(200);

		}

	});

});
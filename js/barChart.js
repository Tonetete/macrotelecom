$(function() {

	$('#chart li').each(function() {
		var pc = $(this).attr('title');
		var importe = $(this).attr('name');
		pc = pc > 100 ? 100 : pc;
		$(this).children('.percent').html(importe);
		var ww = $(this).width();
		var len = parseInt(ww, 10) * parseInt(pc, 10) / 100;
		$(this).children('.bar').animate({ 'width' : len + 'px' }, 1500);
		$(this).children('.percent').fadeIn(800);
		
	});

});





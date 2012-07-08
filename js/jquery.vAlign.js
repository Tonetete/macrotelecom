(function ($) {
$.fn.vAlign = function() {
	return this.each(function(i){
	var ah = $(this).height();

	if($(this).parent().get(0).tagName == "A")
	{
		var ph = $(this).parent().parent().height();
	}
	else
	{
		var ph = $(this).parent().height();
	}
	var mh = Math.ceil((ph-ah) / 2);
	
	$(this).css('margin-top', mh);
	$(this).show();
	});
};
})(jQuery);
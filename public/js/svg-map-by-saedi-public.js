(function( $ ) {
	'use strict';

	/**
	* All of the code for your public-facing JavaScript source
	* should reside in this file.
	*
	* Note: It has been assumed you will write jQuery code here, so the
	* $ function reference has been prepared for usage within the scope
	* of this function.
	*
	* This enables you to define handlers, for when the DOM is ready:
	*
	* $(function() {
	*
	* });
	*
	* When the window is loaded:
	*
	* $( window ).load(function() {
	*
	* });
	*
	* ...and/or other possibilities.
	*
	* Ideally, it is not considered best practise to attach more than a
	* single DOM-ready or window-load handler for a particular page.
	* Although scripts in the WordPress core, Plugins and Themes may be
	* practising this, we should strive to set a better example in our own work.
	*/

	var tooltipSpan = document.getElementById('tooltip-span');

	var ul = $("svg.map");
	var items = ul.find("circle");
	if (typeof js_map_points !== 'undefined') {
		for(var i = 0; i < js_map_points.length; i++) {
			items.eq(js_map_points[i]).addClass("selected");
			if (typeof js_map_popup[i] !== 'undefined') {
				items.eq(js_map_points[i]).attr("data-toggle", "tooltip");
				items.eq(js_map_points[i]).attr("title", js_map_popup[i]);
			}
		}
	}
	$(document).ready(function() {
		$('.selected').hover(function (e) {
			var x = e.clientX,
				y = e.clientY;
			tooltipSpan.style.top = (y + 10) + 'px';
			tooltipSpan.style.left = (x + 10) + 'px';
			tooltipSpan.style.display = "block";
			tooltipSpan.innerHTML = $(this).attr('title');
		},function (e) {
			var x = e.clientX,
				y = e.clientY;
			tooltipSpan.style.top = (y + 20) + 'px';
			tooltipSpan.style.left = (x + 20) + 'px';
			tooltipSpan.style.display = "none";
		});
	});
})( jQuery );

(function( $ ) {
	'use strict';

	/**
	* All of the code for your admin-facing JavaScript source
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
	// svg.selectAll("circle").enter().append("circle").on("click", function(d) {
	// 	console.log("clicked!");
	// });
	jQuery(".map").children('.st0').on("click", function(event) {
		console.log($(this).index());
		$(this).toggleClass('selected');
	});
	jQuery(document).ready(function($) {

		//showinmap
		var ul = $("svg.map");
		var items = ul.find("circle");
		for(var i = 0; i < js_map.length; i++) {
			items.eq(js_map[i]).addClass("selected");
		}

		//Save point Ajax
		$('#save_data').click(function() {
			var points = [];
			jQuery(".map").children('.st0').each(function(){
				if($(this).hasClass('selected')) {
					points.push($(this).index());
				}
			});
			if(points.length == 0)
			return;
			var data = {
				'action': 'save_data',
				'points': points
			};

			// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
			jQuery.post(ajaxurl, data, function(response) {
				$('#msg').html(response);
				window.setTimeout( location.reload(), 3000 );
			});
		});

		//Delete point Ajax
		$('.delete_point').click(function() {
			var point = $(this).attr('data-point');
			if(point == null)
			return;
			var data = {
				'action': 'delete_data',
				'point': point
			};

			// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
			jQuery.post(ajaxurl, data, function(response) {
				$('#removemsg').html(response);
				window.setTimeout( location.reload(), 3000 );
			});
		});
	});
})( jQuery );

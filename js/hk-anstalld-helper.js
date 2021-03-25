jQuery(function($) {
	$(document).ready(function () {

		if ($(".home").length > 0) {
			$.each( hkah_js_object['tooltip'], function (index, tooltip) {
				if (tooltip['type'] == 'class') {
					element = "." + tooltip['key'];
					setToggle(element, tooltip);
				} else if (tooltip['type'] == 'text') {
					$.each(["span","h1","h2","h3","h4","h5","a"], function( index, value ) {
						element = $( value + ':contains("'+tooltip['key']+'")');
						if (element.length > 0) {
							setToggle(element, tooltip);
						}
					});
				}

			});
			function setToggle(element, tooltip) {

				$(element).attr('data-toggle','tooltip').attr('data-placement', tooltip['placement']).attr('title', tooltip['title']);
				if (tooltip['questionmark'] == true) {
					$(element).addClass('tooltip-icon');
				}
			}


			$('#toggle-tooltips-button').click(function(ev){
				ev.preventDefault();
				if ($(this).data('toggle-off') == true) {
					$(this).data('toggle-off', false);
					$('[data-toggle="tooltip"]').tooltip('enable').removeClass('tooltip-hide-icon');
				} else {
					$(this).data('toggle-off', true);
					$('[data-toggle="tooltip"]').tooltip('disable').addClass('tooltip-hide-icon');
				}
			});


			//alert(hkail_js_object.iframe_src);

			$('[data-toggle="tooltip"]').tooltip()
		} // end if home

		// add rek.ai data about user
		localStorage.setItem('rekcsf1', hkah_js_object['user_title']);
		localStorage.setItem('rekcsf2', hkah_js_object['user_office']);
		localStorage.setItem('rekcsf3', hkah_js_object['user_department']);
		localStorage.setItem('rekcsf4', hkah_js_object['user_company']);

	});
});

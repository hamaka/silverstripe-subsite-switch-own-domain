/*jslint browser: true, nomen: true*/
/*global $, window, jQuery*/
(function($) {
	'use strict';
	$.entwine('ss', function($) {

		$('#HmkSubsitesSelect').entwine({
			onadd:function(){
				this.on('change', function(){
					window.location= $(this).val();
				});
			}
		});


	});

}(jQuery));

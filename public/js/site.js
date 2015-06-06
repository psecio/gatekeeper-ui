$(function() {

	// Generic function to make requests (GET)
	function makeRequest(target, success, error) {
		target.preventDefault();
		var link = $(target.currentTarget).attr('href');
		if (link) {
			$.ajax({
				url: link,
				dataType: "json",
				success: success,
				error: error
			});
		}
	}

});
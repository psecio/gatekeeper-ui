$(function() {
	$(document).on('click', '.toggle-status', function(e) {
		makeRequest(e,
			function(data) {
				$('#user-'+data.username+' .status').html(data.status).attr('class', data.status);
			}
		);
	});
	$(document).on('click', '.user-delete', function(e) {
		makeRequest(e,
			function(data) {
				$('#user-'+data.username).remove();
				$('#user-alert').addClass('alert-success')
					.html('User deleted successfully')
					.css('display', 'block');
			},
			function(xhr, options, thrownError) {
				var response = $.parseJSON(xhr.responseText);
				$('#user-alert').addClass('alert-danger')
					.html(response.message)
					.css('display', 'block');
			}
		);
	});


	$('#add-user-btn').click(function(e) {
		e.preventDefault();
		$('#myModal').on('shown.bs.modal', function () {
  			$('#myInput').focus();
		});
	});

	$('#form-create-user #username').keyup(function(e) {
		var loader = $('#add-user-group-username .loader');
		if (loader.css('display') == 'none') {
			loader.css('display', 'block');
		}

		// setTimeout(function(e) {
			var value = $(e.currentTarget).val();
			$.ajax({
				url: '/users/'+value,
				dataType: "json",
				success: function(data) {
					console.log(data);
					// username is found,
					$(e.currentTarget).parent().addClass('has-error');
					$('#username-error')
						.toggle()
						.html('Username unavailable, please choose another');
				},
				error: function(xhr, options, thrownError) {
					// do nothing, username isn't found
					$(e.currentTarget).parent().removeClass('has-error');
					$('#username-error').toggle().html();
				},
				complete: function()
				{
					loader.css('display', 'none');
				}
			});
		// }, 1500, e);
	});

	$('#add-user-save').on('click', function(e) {
		e.preventDefault();
		$.ajax({
			url: '/users/add',
			dataType: "json",
			type: "POST",
			data: $('#form-create-user').serialize(),
			success: function(data) {
				$('#add-user-modal').modal('hide');
				$('#add-user-modal #message').css('display', 'none');
			},
			error: function(xhr, options, thrownError) {
				var response = $.parseJSON(xhr.responseText);
				$('#add-user-modal #message')
					.css('display', 'block')
					.addClass('alert-danger')
					.html(response.message);
			}
		});
	});
});
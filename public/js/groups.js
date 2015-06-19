$(function() {

	function Client(server) {
		this.server = server;

		this.get = function(url, success, error) {
			if (typeof success == 'undefined') {
				success = function() { }
			}
			if (typeof error == 'undefined') {
				error = function() {}
			}
			$.ajax({
				url: url,
				type: 'GET',
				dataType: 'json',
				success: success,
				error: error
			});
		}
		this.post = function(url, data, success, error) {
			if (typeof success == 'undefined') {
				success = function() { }
			}
			if (typeof error == 'undefined') {
				error = function() {}
			}
			$.ajax({
				url: url,
				type: 'POST',
				dataType: 'json',
				data: data,
				success: success,
				error: error
			});
		}
	};

	function Group(client) {
		this.client = client;

		this.findByName = function(name, success, error) {
			this.client.get('/permissions/view/'+name, success, error);
		}
		this.savePermissions = function(data, success) {
			this.client.post(
				'/groups/permissions', data, success
			);
		}
		this.getPermissions = function(name, success, error) {
			this.client.get(
				'/groups/permissions/'+name, success, error
			);
		}
		this.saveUsers = function(data, success) {
			this.client.post(
				'/groups/users', data, success
			);
		}
	};

	function User(client) {
		this.client = client;

		this.getAll = function(success, error) {
			this.client.get('/users', success, error);
		}
	}

	var client = new Client();
	var g = new Group(client);
	var u = new User(client);

	$('#add-group-save').on('click', function(e) {
		e.preventDefault();
		$.ajax({
			url: '/groups/add',
			dataType: "json",
			type: "POST",
			data: $('#form-create-group').serialize(),
			success: function(data) {
				$('#add-group-modal').modal('hide');
				$('#add-group-modal #message').css('display', 'none');
			},
			error: function(xhr, options, thrownError) {
				var response = $.parseJSON(xhr.responseText);
				$('#add-group-modal #message')
					.css('display', 'block')
					.addClass('alert-danger')
					.html(response.message);
			}
		});
	});

	$('#add-permission-modal').on('show.bs.modal', function(e) {
		// Get the permission list and populate the multi-select
		var list = $('#permission-list');

		$.ajax({
			url: '/permissions',
			dataType: 'json',
			type: 'GET',
			success: function(permData) {
				// Clear the list and repopulate
				document.getElementById("permission-list").options.length = 0;
				var permSelect = $('#permission-list');
				var groupName = $('#groupName').val();

				g.getPermissions(groupName, function(data) {
					var idList = [];
					$.each (data.permissions, function(k, perm) {
						idList.push(perm.id);
					});

					$.each (permData.permissions, function(k, perm) {
						var option = $('<option/>').attr('value', perm.id)
							.text(perm.description+' ('+perm.name+')');

						if ($.inArray(perm.id, idList) >= 0) {
							option.attr('selected', 'selected');
						}

						permSelect.append(option);
					});
				});
			}
		});
	});

	$('#add-user-modal').on('show.bs.modal', function(e) {
		var list = $('#user-list');

		u.getAll(function(data) {
			$.each (data.users, function(k, user) {
				var option = $('<option/>').attr('value', user.id)
					.text(user.username+' ('+user.firstName+' '+user.lastName+', '+user.email+')');

				list.append(option);
			});
		})

	});
	$('#add-user-save').on('click', function(e) {
		e.preventDefault();

		var userIds = new Array();
		$.each($('#user-list option:selected'), function(k, user) {
			userIds.push($(user).val());
		});
		var data = { ids: userIds, name: $('#groupName').val() };
		g.saveUsers(data, function(data) {
			$('#add-user-modal').modal('hide');
		});
	});

	$('#add-permission-save').on('click', function(e) {
		e.preventDefault();
		// Get the items selected
		var permIds = new Array();
		$.each($('#permission-list option:selected'), function(k, perm) {
			permIds.push($(perm).val());
		});
		var data = { ids: permIds, name: $('#groupName').val() };
		g.savePermissions(data, function(data) {
			$.each(permIds, function(key, value) {
				g.findByName(value, function(data) {
					// check to see if the row already exists
					if ($('#permission-row-'+data.id).length) {
						return true;
					}
					var row = $('<tr/>');
					row.attr('id', 'permission-row-'+data.id);
					row.append('<td><a href="/permissions/view/'+data.name+'">'+data.name+'</a></td>'
						+'<td>'+data.description+'</td>'
						+'<td><a href="#" class="delete-permission" id="permission-'+data.id+'">'
						+'<img src="/img/x.jpeg" width="20" border="0"></a></td>');
					$('#permission-table').append(row);
				});
			});
			$('#add-permission-modal').modal('hide');
		});
	});

	$('#permission-table').on('click', '.delete-permission', function(e) {
		e.preventDefault();
		if (confirm('Are you sure you want to unlink this permission?')) {
			var permId = $(e.currentTarget).attr('id').split('-')[1];
			$.ajax({
				url: '/groups/permissions',
				dataType: 'json',
				type: 'DELETE',
				data: {
					groupName: $('#groupName').val(),
					permissionId: permId
				},
				success: function(data) {
					$('#permission-row-'+permId).remove();
				}
			});
			return true;
		} else {
			return false;
		}
	});

	$('#user-table').on('click', '.delete-user', function(e) {
		e.preventDefault();
		if (confirm('Are you sure you want to unlink this user?')) {
			var userId = $(e.currentTarget).attr('id').split('-')[1];
			$.ajax({
				url: '/groups/users',
				dataType: 'json',
				type: 'DELETE',
				data: {
					groupName: $('#groupName').val(),
					userId: userId
				},
				success: function(data) {
					$('#user-row-'+userId).remove();
				}
			});
			return true;
		} else {
			return false;
		}
	});
});
$(function() {

	// pc = new PermissionCollection();
	// pc.fetch();

	var PermissionListView = Backbone.View.extend({
		el: $('#perm-list'),
		initialize: function(data) {
			if (typeof this.collection == 'undefined') {
				this.collection = new PermissionCollection;
			}
			this.listenTo(
				this.collection, 'reset add change remove', this.render, this
			);
			this.collection.fetch();
		},
		render: function() {
			var template = Handlebars.compile($('#permission-table-rows').html());
			var output = template({
				permissions: this.collection.toJSON()
			});
			this.$el.html(output);
		}
	});
	var UserListView = Backbone.View.extend({
		el: $('#user-list'),
		initialize: function(data) {
			if (typeof this.collection == 'undefined') {
				this.collection = new UserCollection;
			}
			this.listenTo(
				this.collection, 'reset add change remove', this.render, this
			);
			this.collection.fetch();
		},
		render: function() {
			var template = Handlebars.compile($('#user-table-rows').html());
			var output = template({
				users: this.collection.toJSON()
			});
			this.$el.html(output);
		}
	});

	var permissions = new PermissionCollection({ type: 'group', groupId: 1 });
	var permissionView = new PermissionListView({ collection: permissions });

	var c1 = new UserCollection({ groupId: 1 });
	var ulv = new UserListView({ collection: c1 });

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

	$('#delete-permission-btn').on('click', function(e) {
		e.preventDefault();
		var item = v1.at(0);
		item.destroy({ groupId: 1 });
		v1.remove(v1.at(0));
	});

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

		$.each(permIds, function(k, id) {
			// see if the collection has the item
			if (permissions.get(id) == undefined) {
				var perm = new Permission({ id: id });
				perm.fetch().done(function() {
					permissions.create(perm);
				});
			}
		});

		$('#add-permission-modal').modal('hide');
	});

	$('#permission-table').on('click', '.delete-permission', function(e) {
		e.preventDefault();
		if (confirm('Are you sure you want to unlink this permission?')) {
			var permId = $(e.currentTarget).attr('id').split('-')[1];

			var item = permissions.get(permId);
			item.destroy({ groupId: 1 });
			permissions.remove(item);
			return true;
		}
		return false;
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
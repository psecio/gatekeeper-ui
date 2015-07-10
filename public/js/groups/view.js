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

	var c1 = new UserCollection({ type: 'group', groupId: 1 });
	var ulv = new UserListView({ collection: c1 });


	$('#delete-permission-btn').on('click', function(e) {
		e.preventDefault();
		var item = v1.at(0);
		item.destroy({ groupId: 1 });
		v1.remove(v1.at(0));
	});

	$('#add-permission-modal').on('show.bs.modal', function(e) {
		// Get the permission list and populate the multi-select
		var list = $('#permission-list');

		var fullPermList = new PermissionCollection();
		fullPermList.fetch().done(function() {
			_.each(fullPermList.models, function(perm, index) {
				var option = $('<option/>').attr('value', perm.get('id'))
					.text(perm.get('description')+' ('+perm.get('name')+')');

				var id = perm.get('id');
				if (permissions.get(id) !== undefined) {
					option.attr('selected', 'selected');
				}

				list.append(option);
			});
		});
	});

	$('#add-user-modal').on('show.bs.modal', function(e) {
		var list = $('#user-select-list');

		var userList = new UserCollection();
		userList.fetch().done(function() {
			_.each(userList.models, function(user) {
				var option = $('<option/>').attr('value', user.get('id'))
					.text(user.get('username')+' ('+user.get('firstName')+' '+user.get('lastName')
					+', '+user.get('email')+')');

				var id = user.get('id');
				if (c1.get(id) !== undefined) {
					option.attr('selected', 'selected');
				}

				list.append(option);
			});
		});
	});
	$('#group-add-user-save').on('click', function(e) {
		e.preventDefault();

		var userIds = new Array();
		$.each($('#user-list option:selected'), function(k, user) {
			userIds.push($(user).val());
		});

		$.each(userIds, function(k, id) {
			if (c1.get(id) == undefined) {

				var user = new User({ id: id });
				user.fetch().done(function() {
					c1.create(user);
				});
			}
		});
	});

	$('#group-add-permission-save').on('click', function(e) {
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

			var item = c1.get(userId);
			item.destroy({ groupId: 1 });
			c1.remove(item);
			return true;
		} else {
			return false;
		}
	});
});
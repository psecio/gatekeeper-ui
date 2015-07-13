$(function() {

	var GroupListView = Backbone.View.extend({
		el: $('#group-list'),
		initialize: function(data) {
			if (typeof this.collection == 'undefined') {
				this.collection = new GroupCollection;
			}
			this.listenTo(
				this.collection, 'reset add change remove', this.render, this
			);
			this.collection.fetch();
		},
		render: function() {
			var template = Handlebars.compile($('#group-table-rows').html());
			var output = template({
				groups: this.collection.toJSON()
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

	var groups = new GroupCollection({ type: 'permission', permId: $('#permissionId').val() });
	var groupsList = new GroupListView({ collection: groups });

	var users = new UserCollection({ type: 'permission' , permId: $('#permissionId').val() });
	var usersList = new UserListView({ collection: users });


	$('#user-table').on('click', '.delete-user', function(e) {
		e.preventDefault();
		if (confirm('Are you sure you want to unlink this user?')) {
			var userId = $(e.currentTarget).attr('id').split('-')[1];

			var item = users.get(userId);
			item.destroy({ permId: $('#permissionId').val() });
			users.remove(item);
			return true;
		}
		return false;
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
				if (users.get(id) !== undefined) {
					option.attr('selected', 'selected');
				}

				list.append(option);
			});
		});
	});
	$('#permission-add-user-save').on('click', function(e) {
		e.preventDefault();

		var userIds = new Array();
		$.each($('#user-select-list option:selected'), function(k, user) {
			userIds.push($(user).val());
		});

		$.each(userIds, function(k, id) {
			if (users.get(id) == undefined) {
				var user = new User({ id: id });
				user.fetch().done(function() {
					users.create(user);
				});
			}
		});

		$('#add-user-modal').modal('hide');
	});

	$('#group-table').on('click', '.delete-group', function(e) {
		e.preventDefault();
		if (confirm('Are you sure you want to unlink this group?')) {
			var groupId = $(e.currentTarget).attr('id').split('-')[1];

			var item = groups.get(groupId);
			item.destroy({ permId: $('#permissionId').val() });
			groups.remove(item);
			return true;
		}
		return false;
	});
	$('#add-group-modal').on('show.bs.modal', function(e) {
		var list = $('#group-select-list');

		var groupList = new GroupCollection();
		groupList.fetch().done(function() {
			_.each(groupList.models, function(group) {
				var option = $('<option/>').attr('value', group.get('id'))
					.text(group.get('name')+' ('+group.get('description')+')');

				var id = group.get('id');
				if (groups.get(id) !== undefined) {
					option.attr('selected', 'selected');
				}

				list.append(option);
			});
		});
	});
	$('#permission-add-group-save').on('click', function(e) {
		e.preventDefault();

		var groupIds = new Array();
		$.each($('#group-select-list option:selected'), function(k, group) {
			groupIds.push($(group).val());
		});

		$.each(groupIds, function(k, id) {
			if (groups.get(id) == undefined) {
				var group = new Group({ id: id });
				group.fetch().done(function() {
					groups.create(group);
				});
			}
		});

		$('#add-group-modal').modal('hide');
	});

});
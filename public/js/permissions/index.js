$(function() {

	var PermissionsListView = Backbone.View.extend({
		el: $('#permissions-list'),
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

	var permissions = new PermissionCollection();
	var permissionssView = new PermissionsListView({ collection: permissions });

	$('#add-permission-save').click(function(e) {
		e.preventDefault();
		console.log('saving');

		var permission = new Permission({
			name: $('#permission-name').val(),
			description: $('#permission-desc').val()
		});
		permission.save().done(function() {
			permissions.add(permission);
			$('#add-permission-modal').modal('hide');
		});
	});

	$('#permissions-table').on('click', '.permission-delete', function(e) {
		e.preventDefault();
		if (confirm('Are you sure you want to remove this permission?')) {
			var permId = $(e.currentTarget).attr('id').split('-')[1];

			var item = permissions.get(permId);
			item.destroy();
			permissions.remove(item);
			return true;
		}
		return false;
	});
});
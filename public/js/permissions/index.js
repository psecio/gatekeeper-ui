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

});
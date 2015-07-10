$(function() {

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

	var users = new UserCollection();
	var userView = new UserListView({ collection: users });
});
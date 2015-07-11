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

	var groups = new GroupCollection({ type: 'permission', groupId: 1 });
	var groupsList = new GroupListView({ collection: groups });

});
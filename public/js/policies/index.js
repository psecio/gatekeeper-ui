$(function() {

	var PoliciesListView = Backbone.View.extend({
		el: $('#policies-list'),
		initialize: function(data) {
			if (typeof this.collection == 'undefined') {
				this.collection = new PolicyCollection;
			}
			this.listenTo(
				this.collection, 'reset add change remove', this.render, this
			);
			this.collection.fetch();
		},
		render: function() {
			var template = Handlebars.compile($('#policy-table-rows').html());
			var output = template({
				policies: this.collection.toJSON()
			});

			this.$el.html(output);
		}
	});

	var policies = new PolicyCollection();
	var policiesView = new PoliciesListView({ collection: policies });

});
$(function() {

	var GroupsListView = Backbone.View.extend({
		el: $('#groups-list'),
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

	var groups = new GroupCollection();
	var groupsView = new GroupsListView({ collection: groups });

	$('#add-group-save').on('click', function(e) {
		e.preventDefault();

		var group = new Group({
			name: $('#group-name').val(),
			description: $('#group-description').val()
		});
		group.save().done(function() {
			groups.add(group);
			$('#add-group-modal').modal('hide');
		});
	});

	$('#groups-table').on('click', '.group-delete', function(e) {
		e.preventDefault();
		if (confirm('Are you sure you want to remove this group?')) {
			var groupId = $(e.currentTarget).attr('id').split('-')[1];

			var item = groups.get(groupId);
			item.destroy();
			groups.remove(item);
			return true;
		}
		return false;
	});

});
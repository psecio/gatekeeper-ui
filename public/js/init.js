// $(function() {
	var Group = Backbone.Model.extend({
		urlRoot: '/group',
		defaults: {
			name: '',
			description: '',
			// id: 0,
			created: '',
			updated: ''
		}
	});
	var Permission = Backbone.Model.extend({
		urlRoot: '/permission',
		defaults: {
			id: 0,
			name: '',
			description: '',
			created: '',
			updated: ''
		}
	});
	var User = Backbone.Model.extend({
		urlRoot: '/user',
		defaults: {
			id: 0,
			username: '',
			email: '',
			firstName: '',
			lastName: '',
			status: '',
			created: '',
			updated: '',
			lastLogin: ''
		}
	});

	var GroupCollection = Backbone.Collection.extend({
		model: Group,
		url: '/group'
	});
	var PermissionCollection = Backbone.Collection.extend({
		model: Permission,
		initialize: function(data) {
			this.data = (typeof data == 'undefined') ? {} : data;

			this.listenTo(this, 'reset add change remove', this.updateUrl, this);
			this.listenTo(this, 'reset add change', this.updateUrl, this);
		},
		url: function() {
			switch(this.data.type) {
				case 'user':
					var url = '/user/'+this.data.userId+'/permission'; break;
				case 'group':
					var url = '/group/'+this.data.groupId+'/permission'; break;
				default: var url = '/permission'
			}
			return url;
		},
		updateUrl: function() {
			var data = this.data;
			this.each(function(perm) {
				switch(data.type) {
					case 'user':
						var url = '/user/'+data.userId+'/permission'; break;
					case 'group':
						var url = '/group/'+data.groupId+'/permission'; break;
					default: var url = '/permission'
				}
				perm.urlRoot = url;
			});
		}
	});
	var UserCollection = Backbone.Collection.extend({
		model: User,
		initialize: function(data) {
			this.data = (typeof data == 'undefined') ? {} : data;

			this.listenTo(this, 'reset add change remove', this.updateUrl, this);
			this.listenTo(this, 'reset add change', this.updateUrl, this);
		},
		url: function() {
			if (typeof this.data.groupId !== 'undefined') {
				url = '/group/'+this.data.groupId+'/user';
			} else if (typeof this.data.userId !== 'undefined') {
				url = '/permission/'+this.data.userId+'/user';
			} else {
				url = '/user';
			}
			return url;
		},
		updateUrl: function() {
			var data = this.data;
			this.each(function(perm) {
				switch(data.type) {
					case 'user':
						var url = '/user/'+data.userId+'/user'; break;
					case 'group':
						var url = '/group/'+data.groupId+'/user'; break;
					default: var url = '/permission'
				}
				perm.urlRoot = url;
			});
		}
	});
// });
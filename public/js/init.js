// $(function() {
Handlebars.registerHelper('if_eq', function(a, b, opts) {
    if(a == b) // Or === depending on your needs
        return opts.fn(this);
    else
        return opts.inverse(this);
});
Handlebars.registerHelper('date', function(value, format, opts) {
    return moment.unix(value).format(format);
});
//----------

	var Group = Backbone.Model.extend({
		urlRoot: '/group',
		defaults: {
			name: '',
			description: '',
			created: '',
			updated: ''
		}
	});
	var Permission = Backbone.Model.extend({
		urlRoot: '/permission',
		defaults: {
			name: '',
			description: '',
			created: '',
			updated: ''
		}
	});
	var User = Backbone.Model.extend({
		urlRoot: '/user',
		defaults: {
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
	var Policy = Backbone.Model.extend({
		urlRoot: '/policy',
		defaults: {
			name: '',
			expression: '',
			created: ''
		}
	});

	var BaseCollection = Backbone.Collection.extend({
		initialize: function(data) {
			this.data = (typeof data == 'undefined') ? {} : data;

			this.listenTo(this, 'reset add change remove', this.updateUrl, this);
			this.listenTo(this, 'reset add change', this.updateUrl, this);
		},
		url: function() {
			return this.buildUrl(this.data);
		}
	});

	var GroupCollection = BaseCollection.extend({
		model: Group,
		// url: '/group'
		buildUrl: function(data) {
			switch(data.type) {
				case 'user':
					var url = '/user/'+data.userId+'/group'; break;
				case 'permission':
					var url = '/permission/'+data.permId+'/group'; break;
				default: var url = '/group'
			}
			return url;
		},
		updateUrl: function() {
			this.each(function(perm) {
				perm.urlRoot = this.buildUrl(this.data);
			}, this);
		}
	});
	var PermissionCollection = BaseCollection.extend({
		model: Permission,
		buildUrl: function(data) {
			switch(data.type) {
				case 'user':
					var url = '/user/'+data.userId+'/permission'; break;
				case 'group':
					var url = '/group/'+data.groupId+'/permission'; break;
				default: var url = '/permission'
			}
			return url;
		},
		updateUrl: function() {
			this.each(function(perm) {
				perm.urlRoot = this.buildUrl(this.data);
			}, this);
		}
	});
	var UserCollection = BaseCollection.extend({
		model: User,
		buildUrl: function(data) {
			switch(data.type) {
				case 'permission':
					var url = '/permission/'+data.permId+'/user'; break;
				case 'group':
					var url = '/group/'+data.groupId+'/user'; break;
				default: var url = '/user'
			}
			return url;
		},
		updateUrl: function() {
			this.each(function(user) {
				user.urlRoot = this.buildUrl(this.data);
			}, this);
		}
	});
	var PolicyCollection = BaseCollection.extend({
		model: Policy,
		buildUrl: function(data) {
			switch(data.type) {
				case 'permission':
					var url = '/permission/'+data.permId+'/policy'; break;
				case 'group':
					var url = '/group/'+data.groupId+'/policy'; break;
				default: var url = '/policy'
			}
			return url;
		},
		updateUrl: function() {
			this.each(function(policy) {
				policy.urlRoot = this.buildUrl(this.data);
			}, this);
		}
	});
// });
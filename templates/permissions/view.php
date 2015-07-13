{% extends "layout.main.php" %}

{% block content %}

<h2>{{ permission.name }}</h2>

<p>
	{{ permission.description }}
</p>
<br/>
{% if date(permission.expire) < date() %}
	<div class="alert alert-warning">This permission has expired!</div>
{% elseif date(permission.expire) > date() %}
	<div class="alert alert-info">This permission will expire at {{ permission.expire|date('Y.m.d H:i:s') }}</div>
{% endif %}

<div class="row">
	<div class="col-md-6">
		<h3>Groups</h3>
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-group-modal">
  			+ Add group
		</button>
		<table class="table table-striped" id="group-table">
		  <thead>
		    <th>Name</th>
		    <th>Description</th>
		    <th>&nbsp;</th>
		  </thead>
		  <tbody id="group-list">
		  </tbody>
		</table>
	</div>
	<div class="col-md-6">
		<h3>Users</h3>
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-user-modal">
  			+ Add user
		</button>
		<table class="table table-striped" id="user-table">
		  <thead>
		    <th>Username</th>
		    <th>Name</th>
		    <th>&nbsp;</th>
		  </thead>
		  <tbody id="user-list">
		  </tbody>
		</table>
	</div>
</div>

<script id="group-table-rows" type="text/x-handlebars-template">
{% raw %}
{{#each groups}}
<tr>
	<td><a href="/groups/view/{{ id }}">{{ name }}</a></td>
	<td>{{ description }}</td>
	<td><a href="#" class="delete-group" id="group-{{id}}">
		<img src="/img/x.jpeg" width="20" border="0"></a></td>
{{/each}}
{% endraw %}
</script>

<script id="user-table-rows" type="text/x-handlebars-template">
{% raw %}
{{#each users}}
<tr>
	<td><a href="/users/view/{{ id }}">{{ username }}</a></td>
	<td>{{ firstName }} {{ lastName }}</td>
	<td><a href="#" class="delete-user" id="user-{{id}}">
		<img src="/img/x.jpeg" width="20" border="0"></a></td>
{{/each}}
{% endraw %}
</script>

<input type="hidden" id="permissionId" value="{{ permission.id }}"/>

<!-- Add Permission Modal -->
<div class="modal fade" id="add-group-modal" tabindex="-1" role="dialog" aria-labelledby="addGroupModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Select Group(s)</h4>
			</div>
			<div class="modal-body">
				<select name="group-select-list" class="form-control" id="group-select-list" multiple>
				</select>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="permission-add-group-save">Save changes</button>
			</div>
		</div>
	</div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="add-user-modal" tabindex="-1" role="dialog" aria-labelledby="addUserModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Select User(s)</h4>
			</div>
			<div class="modal-body">
				<select name="user-select-list" class="form-control" id="user-select-list" multiple>
				</select>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="permission-add-user-save">Save changes</button>
			</div>
		</div>
	</div>
</div>
{% endblock %}

{% block scripts %}
<script src="/js/permissions/view.js"></script>
{% endblock %}
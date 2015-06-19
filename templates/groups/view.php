{% extends "layout.main.php" %}

{% block content %}

<h2>{{ group.name }}</h2>

<table class="table table-striped">
	<tr>
		<td>Description:</td>
		<td>{{ group.description }}</td>
	</tr>
	<tr>
		<td>Created</td>
		<td>{{ group.created }}</td>
	</tr>
	<tr>
		<td>Updated</td>
		<td>{{ group.updated }}</td>
	</tr>
</table>

<div class="col-md-6">
	<h3>Permissions</h3>

	<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-permission-modal">
  		+ Add permission
	</button>
	<table class="table table-striped" id="permission-table">
		<thead>
			<th>Name</th>
			<th>Description</th>
			<th>&nbsp;</th>
		</thead>
		<tbody>
		{% for permission in permissions %}
		<tr id="permission-row-{{ permission.id }}">
			<td><a href="/permissions/view/{{ permission.name }}">{{ permission.name }}</a></td>
			<td>{{ permission.description }}</td>
			<td>
				<a href="#" class="delete-permission" id="permission-{{ permission.id }}">
					<img src="/img/x.jpeg" width="20" border="0">
				</a>
			</td>
		</tr>
		{% endfor %}
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
			<th>Email</th>
			<th>&nbsp;</th>
		</thead>
		<tbody>
		{% for user in users %}
		<tr id="user-row-{{ user.id }}">
			<td><a href="/user/view/{{ user.username }}">{{ user.username }}</a></td>
			<td>{{ user.firstName }} {{ user.lastName }}</td>
			<td>{{ user.email }}</td>
			<td>
				<a href="#" class="delete-user" id="user-{{ user.id }}">
					<img src="/img/x.jpeg" width="20" border="0">
				</a>
			</td>
		</tr>
		{% endfor %}
		</tbody>
	</table>
</div>

<input type="hidden" id="groupName" value="{{ group.name }}"/>

<!-- Add Permission Modal -->
<div class="modal fade" id="add-permission-modal" tabindex="-1" role="dialog" aria-labelledby="addPermissionModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Select Permission(s)</h4>
			</div>
			<div class="modal-body">
				<select name="permission-list" class="form-control" id="permission-list" multiple>
				</select>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="add-permission-save">Save changes</button>
			</div>
		</div>
	</div>
</div>

<!-- Add Permission Modal -->
<div class="modal fade" id="add-user-modal" tabindex="-1" role="dialog" aria-labelledby="addUserModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Select User(s)</h4>
			</div>
			<div class="modal-body">
				<select name="user-list" class="form-control" id="user-list" multiple>
				</select>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="add-user-save">Save changes</button>
			</div>
		</div>
	</div>
</div>

{% endblock %}
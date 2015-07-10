{% extends "layout.main.php" %}

{% block content %}

<h3>Current Users</h3>

<div class="alert" id="user-alert" style="display:none"></div>

<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-user-modal">
  + Add user
</button>

<table class="table table-striped user-table">
  <thead>
    <th>User</th>
    <th>Status</th>
    <th>Created</th>
    <th>Last Login</th>
    <th>&nbsp;</th>
  </thead>
  <tbody id="user-list">
  </tbody>
</table>

<!-- Add User Modal -->
<div class="modal fade" id="add-user-modal" tabindex="-1" role="dialog" aria-labelledby="addUserModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add New User</h4>
      </div>
      <div class="modal-body">
      	<div id="message" style="display:none" class="alert"></div>

        <form class="form-horizontal" id="form-create-user">
        	<div class="form-group" id="add-user-group-username">
    			<label for="username" class="col-sm-3">Username:</label>
    			<div class="col-sm-8">
    				<input type="text" class="form-control" name="username" id="username" placeholder="Enter username">
    				<div id="username-error" class="message-error"></div>
    			</div>
    			<div class="col-sm-1" style="padding-left:0px">
    				<span class="loader"><img src="/img/ajax-loader.gif" height="15"/></span>
    			</div>
  			</div>
        	<div class="form-group">
    			<label for="email" class="col-sm-3">Email Address:</label>
    			<div class="col-sm-8">
    				<input type="email" class="form-control" name="email" id="email" placeholder="Enter email">
    			</div>
  			</div>
  			<div class="form-group">
    			<label for="first-name" class="col-sm-3">First Name:</label>
    			<div class="col-sm-8">
    				<input type="text" class="form-control" name="first-name" id="first-name" placeholder="Enter first name">
    			</div>
  			</div>
  			<div class="form-group">
    			<label for="last-name" class="col-sm-3">Last Name:</label>
    			<div class="col-sm-8">
    				<input type="text" class="form-control" name="last-name" id="last-name" placeholder="Enter last name">
    			</div>
  			</div>
  			<div class="form-group">
    			<label for="password" class="col-sm-3">Password:</label>
    			<div class="col-sm-8">
    				<input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
    			</div>
  			</div>
  			<div class="form-group">
    			<label for="password-confirm" class="col-sm-3">Password Confirm:</label>
    			<div class="col-sm-8">
    				<input type="password" class="form-control" name="password-confirm" id="password-confirm" placeholder="Confirm password">
    			</div>
  			</div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="add-user-save">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script id="user-table-rows" type="text/x-handlebars-template">
{% raw %}
{{#each users}}
<tr id="user-{{ username }}">
  <td class="username">
    <a href="/users/view/{{ username }}" class="name">{{ firstName }} {{ lastName }}</a><br/>
    <a href="/users/view/{{ username }}">{{ username }}</a><br/>
    <span class="glyphicon glyphicon-envelope"></span>&nbsp;<a href="mailto:{{ email }}">{{ email }}</a>
  </td>
  <td class="status {{ status }}">{{ status }}</td>
  <td class="created">{{ created }}</td>
  <td>{{#if lastLogin }}{{ lastLogin }}{{else}}Never logged in.{{/if}}</td>
  <td>
    <a href="/users/edit/{{ username }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
    <a href="/users/status/{{ username }}" class="toggle-status"><span class="glyphicon glyphicon-off" aria-hidden="true"></span></a>
    <a href="/users/delete/{{ username }}" class="user-delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
  </td>
</tr>
{{/each}}
{% endraw %}
</script>

{% endblock %}

{% block scripts %}
<script src="/js/users/index.js"></script>
{% endblock %}

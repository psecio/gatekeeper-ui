{% extends "layout.main.php" %}

{% block content %}

<h3>Current Permissions</h3>

<!-- Button trigger modal -->
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-permission-modal">
  + Add permission
</button>

<table class="table table-striped" id="permissions-table">
	<thead>
		<th>Name</th>
		<th>Description</th>
		<th>Created</th>
		<th>Expired?</th>
		<th>&nbsp;</th>
	</thead>
	<tbody id="permissions-list">
	</tbody>
</table>

<!-- Add Permission Modal -->
<div class="modal fade" id="add-permission-modal" tabindex="-1" role="dialog" aria-labelledby="addPermissionModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Permission</h4>
			</div>
			<div class="modal-body">
      			<div id="message" style="display:none" class="alert"></div>

      			<form class="form-horizontal" id="form-create-permission">
				<div class="form-group">
	    			<label for="name" class="col-sm-3">Name:</label>
	    			<div class="col-sm-8">
	    				<input type="text" class="form-control" name="permission-name" id="permission-name" placeholder="Enter permission name">
	    			</div>
	    		</div>
	    		<div class="form-group">
	    			<label for="name" class="col-sm-3">Description:</label>
	    			<div class="col-sm-8">
	    				<input type="text" class="form-control" name="permission-desc" id="permission-desc" placeholder="Enter permission description">
	    			</div>
	    		</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="add-permission-save">Save changes</button>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script id="permission-table-rows" type="text/x-handlebars-template">
{% raw %}
{{#each permissions}}
<tr id="permission-{{ id }}" class="{{#if expired}}expired{{/if}}">
  <td><a href="/permissions/view/{{ id }}">{{ name }}</a></td>
  <td>{{ description }}</td>
  <td>{{ created }}</td>
  <td>{{#if expired}}Expired{{/if}}</td>
  <td>
    <a href="/permissions/edit/{{ id }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
    <a href="/permissions/delete/{{ id }}" class="permission-delete" id="permission-{{ id }}"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
  </td>
</tr>
{{/each}}
{% endraw %}
</script>

{% endblock %}

{% block scripts %}
<script src="/js/permissions/index.js"></script>
{% endblock %}
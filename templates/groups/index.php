{% extends "layout.main.php" %}

{% block content %}

<h3>Current Groups</h3>

<!-- Button trigger modal -->
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-group-modal">
  + Add group
</button>

<table class="table table-striped" id="groups-table">
  <thead>
    <th>Name</th>
    <th>Description</th>
    <th>Created</th>
    <th>&nbsp;</th>
  </thead>
  <tbody id="groups-list">
  </tbody>
</table>

<!-- Add Group Modal -->
<div class="modal fade" id="add-group-modal" tabindex="-1" role="dialog" aria-labelledby="addGroupModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add New Group</h4>
      </div>
      <div class="modal-body">
      	<div id="message" style="display:none" class="alert"></div>

        <form class="form-horizontal" id="form-create-group">
        	<div class="form-group">
    			<label for="name" class="col-sm-3">Name:</label>
    			<div class="col-sm-8">
    				<input type="text" class="form-control" name="group-name" id="group-name" placeholder="Enter group name">
    			</div>
  			</div>
        	<div class="form-group">
    			<label for="description" class="col-sm-3">Description:</label>
    			<div class="col-sm-8">
    				<input type="email" class="form-control" name="group-description" id="group-description" placeholder="Enter description">
    			</div>
  			</div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="add-group-save">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script id="group-table-rows" type="text/x-handlebars-template">
{% raw %}
{{#each groups}}
<tr>
  <td><a href="/groups/view/{{name}}">{{name}}</a></td>
  <td>{{ description }}</td>
  <td>{{ created }}</td>
  <td>
      <a href="/groups/edit/{{ name }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
      <a href="/groups/delete/{{ name }}" class="group-delete" id="group-{{ id }}"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
    </td>
  </tr>
{{/each}}
{% endraw %}
</script>


{% endblock %}

{% block scripts %}
<script src="/js/groups/index.js"></script>
{% endblock %}

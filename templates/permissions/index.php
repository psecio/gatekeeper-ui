{% extends "layout.main.php" %}

{% block content %}

<h3>Current Permissions</h3>

<!-- Button trigger modal -->
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-permission-modal">
  + Add permission
</button>

<table class="table table-striped">
	<thead>
		<th>Name</th>
		<th>Description</th>
		<th>Created</th>
	</thead>
	<tbody id="permissions-list">
	</tbody>
</table>

<script id="permission-table-rows" type="text/x-handlebars-template">
{% raw %}
{{#each permissions}}
<tr id="permission-{{ name }}">
  <td>{{ name }}</td>
  <td>{{ description }}</td>
  <td>{{ created }}</td>
</tr>
{{/each}}
{% endraw %}
</script>

{% endblock %}

{% block scripts %}
<script src="/js/permissions/index.js"></script>
{% endblock %}
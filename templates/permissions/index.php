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
		<th>Expired?</th>
		<th>&nbsp;</th>
	</thead>
	<tbody id="permissions-list">
	</tbody>
</table>

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
    <a href="/permissions/delete/{{ id }}" class="permission-delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
  </td>
</tr>
{{/each}}
{% endraw %}
</script>

{% endblock %}

{% block scripts %}
<script src="/js/permissions/index.js"></script>
{% endblock %}
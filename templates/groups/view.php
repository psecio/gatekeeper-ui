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

<h3>Permissions</h3>
<table style="table table-striped">
	{% for permission in permissions %}
	<tr>
		<td><a href="/permissions/view/{{ permission.name }}">{{ permission.name }}</a></td>
	</tr>
	{% endfor %}
</table>

{% endblock %}
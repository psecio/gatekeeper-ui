{% extends "layout.main.php" %}

{% block content %}

<h2>{{ user.firstName }} {{ user.lastName }}</h2>
<a href="/users/status/{{ user.username}}" class="toggle-status">
<span class="glyphicon glyphicon-off" aria-hidden="true"></span></a>
<br/><br/>

<div class="row">
	<div class="col-md-4">
		<table class="table" id="user-{{ user.username }}">
			<tr>
				<td><b>Username:</b></td>
				<td>{{ user.username }}</td>
			</tr>
			<tr>
				<td><b>Name:</b></td>
				<td>{{ user.firstName }} {{ user.lastName }}</td>
			</tr>
			<tr>
				<td><b>Email:</b></td>
				<td>{{ user.email }}</td>
			</tr>
			<tr>
				<td><b>Status:</b></td>
				<td><span class="status {{ user.status }}">{{ user.status }}</span></td>
			</tr>
			<tr>
				<td><b>Created:</b></td>
				<td>{{ user.created }}</td>
			</tr>
		</table>
	</div>
	<div class="col-md-4">
		<h3>Groups</h3>
		<table class="table table-striped">
		{% for group in groups %}
		<tr>
			<td><a href="/group/view/{{ group.name }}">{{ group.name }}</a></td>
			<td>{{ group.description }}</td>
		</tr>
		{% endfor %}
		</table>
	</div>
	<div class="col-md-4">
		<h3>Permissions</h3>
		<table class="table table-striped">
		{% for permission in permissions %}
		<tr>
			<td><a href="/permissions/view/{{ permission.name }}">{{ permission.name }}</a></td>
			<td>{{ permission.description }}</td>
		</tr>
		{% endfor %}
		</table>
	</div>
</div>


{% endblock %}
{% extends "layout.main.php" %}

{% block content %}

<h2>{{ user.firstName }} {{ user.lastName }}</h2>
<a href="/users/status/{{ user.username}}" class="toggle-status">
	<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
</a>
<br/><br/>
<table class="table" style="width:400px" id="user-{{ user.username }}">
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

{% endblock %}
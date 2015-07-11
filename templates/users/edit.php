{% extends "layout.main.php" %}

{% block content %}

<h3>Editing: {{ user.firstName }} {{ user.lastName }} ({{ user.username }})</h3>
{% if success %}
<div class="alert alert-success">User saved successfully!</div>
{% endif %}
<br/>
<form class="form form-horizontal" method="POST" action="/users/edit/{{ user.id }}">
	<div class="form-group">
		<label for="title" class="col-sm-2 control-label">Status:</label>
		<div class="col-sm-5">
			<select class="form-control" name="status" id="status">
				<option value="active" {% if user.status == 'active' %}selected{% endif %}>Enabled</option>
				<option value="inactive" {% if user.status == 'inactive' %}selected{% endif %}>Disabled</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="title" class="col-sm-2 control-label">Email:</label>
		<div class="col-sm-5">
			<input type="email" class="form-control" id="email" name="email" value="{{ user.email }}">
		</div>
	</div>
	<div class="form-group">
		<label for="title" class="col-sm-2 control-label">First Name:</label>
		<div class="col-sm-5">
			<input type="text" class="form-control" id="first-name" name="first-name" value="{{ user.firstName }}">
		</div>
	</div>
	<div class="form-group">
		<label for="title" class="col-sm-2 control-label">Last Name:</label>
		<div class="col-sm-5">
			<input type="text" class="form-control" id="last-name" name="last-name" value="{{ user.lastName }}">
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-2"></div>
		<div class="col-md-3">
			<input type="submit" value="Save" name="sub" class="btn btn-success"/>
		</div>
	</div>
</form>


{% endblock %}
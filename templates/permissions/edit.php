{% extends "layout.main.php" %}

{% block content %}

<h3>Editing: {{ permission.name }}</h3>
{% if success %}
<div class="alert alert-success">Permission saved successfully!</div>
{% endif %}

{% if date(permission.expire) < date() %}
	<div class="alert alert-warning">This permission has expired!</div>
{% elseif date(permission.expire) > date() %}
	<div class="alert alert-info">This permission will expire at {{ permission.expire|date('Y.m.d H:i:s') }}</div>
{% endif %}
<br/>
<form class="form form-horizontal" method="POST" action="/permissions/edit/{{ permission.id }}">
	<div class="form-group">
		<label for="title" class="col-sm-2 control-label">Name:</label>
		<div class="col-sm-5">
			<input type="text" class="form-control" id="name" name="name" value="{{ permission.name }}">
		</div>
	</div>
	<div class="form-group">
		<label for="title" class="col-sm-2 control-label">Description:</label>
		<div class="col-sm-5">
			<input type="text" class="form-control" id="description" name="description" value="{{ permission.description }}">
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
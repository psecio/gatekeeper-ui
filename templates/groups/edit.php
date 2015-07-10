{% extends "layout.main.php" %}

{% block content %}

<h3>Editing: {{ group.name }}</h3>

{% if success %}
<div class="alert alert-success">Group saved successfully!</div>
{% endif %}
<br/>
<form class="form form-horizontal" method="POST" action="/groups/edit/{{ group.name }}">
	<div class="form-group">
		<label for="title" class="col-sm-2 control-label">Name:</label>
		<div class="col-sm-5">
			<input type="text" class="form-control" id="name" name="name" value="{{ group.name }}">
		</div>
	</div>
	<div class="form-group">
		<label for="title" class="col-sm-2 control-label">Description:</label>
		<div class="col-sm-5">
			<textarea class="form-control" name="description" id="description">{{ group.description }}</textarea>
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
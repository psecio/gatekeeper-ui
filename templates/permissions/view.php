{% extends "layout.main.php" %}

{% block content %}

<h2>{{ permission.name }}</h2>

<p>
	{{ permission.description }}
</p>
<br/>
{% if date(permission.expire) < date() %}
	<div class="alert alert-warning">This permission has expired!</div>
{% elseif date(permission.expire) > date() %}
	<div class="alert alert-info">This permission will expire at {{ permission.expire|date('Y.m.d H:i:s') }}</div>
{% endif %}

<h4>Belongs to</h4>
<table class="table table-striped group-table">
  <thead>
    <th>Name</th>
    <th>&nbsp;</th>
  </thead>
  <tbody id="group-list">
  </tbody>
</table>

<script id="group-table-rows" type="text/x-handlebars-template">
{% raw %}
{{#each groups}}
<tr>
	<td>{{ name }}</td>
	<td>actions</td>
{{/each}}
{% endraw %}
</script>

{% endblock %}

{% block scripts %}
<script src="/js/permissions/view.js"></script>
{% endblock %}
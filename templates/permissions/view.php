{% extends "layout.main.php" %}

{% block content %}

<h2>{{ permission.name }}</h2>

<p>
	{{ permission.description }}
</p>
<br/>

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
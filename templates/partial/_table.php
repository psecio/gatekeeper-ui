<h3>{{ title }}</h3>

<table class="table table-striped">
<thead>
	{% for property in properties %}
	<th>{{ property.title }}</ht>
	{% endfor %}
</thead>
<tbody>
{% for index, item in data %}
	<tr id="#permission-{{ attribute(item, primaryKey) }}">
	{% for property in properties %}
		<td>{{ attribute(item, property.key) }}</td>
	{% endfor %}
	</tr>
{% endfor %}
</tbody>
</table>
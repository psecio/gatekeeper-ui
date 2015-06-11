<h3>{{ title }}</h3>

{% if showAdd %}
<!-- Button trigger modal -->
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-{{ addType }}-modal">
  + Add {{ addType }}
</button>
{% endif %}

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
		{% if property.link %}
			<td><a href="{{ link }}/{{ attribute(item, property.key) }}">{{ attribute(item, property.key) }}</a></td>
		{% else %}
			<td>{{ attribute(item, property.key) }}</td>
		{% endif %}
	{% endfor %}
	</tr>
{% endfor %}
</tbody>
</table>
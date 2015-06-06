{% extends "layout.main.php" %}

{% block content %}

{% set vars = {
	data: groups,
	properties: [
		{title: 'Name', key:'name'},
		{title: 'Description', key: 'description'},
		{title: 'Created', key: 'created'}
	],
	primaryKey: 'name',
	title: 'Current Groups'
} %}
{% include 'partial/_table.php' with vars %}

{% endblock %}
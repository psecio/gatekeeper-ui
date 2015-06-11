{% extends "layout.main.php" %}

{% block content %}

{% set vars = {
	data: policies,
	properties: [
		{title: 'Name', key:'name'},
		{title: 'Expression', key: 'expression'},
		{title: 'Created', key: 'created'}
	],
	primaryKey: 'name',
	title: 'Current Policies',
	showAdd: true,
	addType: 'policy'
} %}
{% include 'partial/_table.php' with vars %}

{% endblock %}
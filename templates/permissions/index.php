{% extends "layout.main.php" %}

{% block content %}

{% set vars = {
	data: permissions,
	properties: [
		{title: 'Name', key:'name'},
		{title: 'Description', key: 'description'},
		{title: 'Created', key: 'created'}
	],
	primaryKey: 'name',
	title: 'Current Permissions',
	showAdd: true,
	addType: 'permission'
} %}
{% include 'partial/_table.php' with vars %}

{% endblock %}
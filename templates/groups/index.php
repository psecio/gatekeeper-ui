{% extends "layout.main.php" %}

{% block content %}

{% set vars = {
	data: groups,
	properties: [
		{title: 'Name', key:'name', link: true},
		{title: 'Description', key: 'description'},
		{title: 'Created', key: 'created'}
	],
	primaryKey: 'name',
	title: 'Current Groups',
	showAdd: true,
	addType: 'group',
	link: '/groups/view'
} %}
{% include 'partial/_table.php' with vars %}

{% endblock %}
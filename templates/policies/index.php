{% extends "layout.main.php" %}

{% block content %}

{% set vars = {
	data: policies,
	properties: ['name', 'expression', 'created'],
	primaryKey: 'name',
	title: 'Current Policies'
	}
%}
{% include 'partial/_table.php' with vars %}

{% endblock %}
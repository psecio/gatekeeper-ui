{% extends "layout.main.php" %}

{% block content %}

<h2>Current Policies</h2>

<!-- Button trigger modal -->
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-policy-modal">
  + Add policy
</button>

<table class="table table-striped" id="policy-table">
	<thead>
		<th>Name</th>
		<th>Expression</th>
		<th>Description</th>
		<th>Created</th>
	</thead>
	<tbody id="policies-list">
	</tbody>
</table>

<script id="policy-table-rows" type="text/x-handlebars-template">
{% raw %}
{{#each policies}}
<tr id="policy-{{ id }}">
  <td><a href="/policy/view/{{ id }}">{{ name }}</a></td>
  <td>{{ expression }}</td>
  <td>{{ description }}</td>
  <td>{{ created }}</td>
</tr>
{{/each}}
{% endraw %}
</script>

<!-- Add Policy Modal -->
<div class="modal fade" id="add-policy-modal" tabindex="-1" role="dialog" aria-labelledby="addPolicyModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Policy</h4>
			</div>
			<div class="modal-body">
      			<div id="message" style="display:none" class="alert"></div>

      			<form class="form-horizontal" id="form-create-policy">
				<div class="form-group">
	    			<label for="name" class="col-sm-3">Name:</label>
	    			<div class="col-sm-8">
	    				<input type="text" class="form-control" name="policy-name" id="policy-name" placeholder="Enter policy name">
	    			</div>
	    		</div>
	    		<div class="form-group">
	    			<label for="name" class="col-sm-3">Expression:</label>
	    			<div class="col-sm-8">
	    				<input type="text" class="form-control" name="policy-name" id="policy-expression" placeholder="Enter policy expression">
	    				<p class="help-block">This expression can either follow the
	    					<a href="http://symfony.com/doc/current/components/expression_language/index.html">Symfony Expression Language</a> format
	    					or can be a "Class::method" value.
	    				</p>
	    			</div>
	    		</div>
	    		<div class="form-group">
	    			<label for="name" class="col-sm-3">Description:</label>
	    			<div class="col-sm-8">
	    				<input type="text" class="form-control" name="policy-desc" id="policy-desc" placeholder="Enter policy description">
	    			</div>
	    		</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="add-policy-save">Save changes</button>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>

{% endblock %}

{% block scripts %}
<script src="/js/policies/index.js"></script>
{% endblock %}
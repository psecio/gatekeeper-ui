{% extends "layout.main.php" %}

{% block content %}

<h3>Welcome</h3>
<div class="row">
	<div class="col-md-8">
		<p>
			The Gatekeeper UI allows you to quickly and easily interact with your <a href="http://gatekeeperphp.com">Gatekeeper</a> based
			authentication and authorization system. If you haven't already, be sure to configure the `.env` file in the root directory
			of this installation to point to your Gatekeeper database.
		</p>
	</div>
	<div class="col-md-1">&nbsp;</div>
	<div class="col-md-3">
		<div style="border:1px solid #CCCCCC;padding:6px">
			<h4>Quick Tip</h4>
			<p>
				You can enable and disable users directly from the Users list.
			</p>
		</div>
	</div>
</div>

{% endblock %}
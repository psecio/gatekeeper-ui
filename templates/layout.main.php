
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Gatekeeper UI</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/site.css" rel="stylesheet">
  </head>

  <body role="document">

    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/" style="color:#FFFFFF">Gatekeeper UI</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href='/users'>Users</a></li>
            <li><a href="/groups">Groups</a></li>
            <li><a href="/permissions">Permissions</a></li>
            <li><a href="/policies">Policies</a></li>
            <li class="dropdown">
              <!--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>-->
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container" role="main" style="padding-top:50px">
		{% block content %}{% endblock %}
	</div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/js/jquery.js"></script>
    <script src="/js/underscore-min.js"></script>
    <script src="/js/backbone-min.js"></script>
    <script src="/js/handlebars-v3.0.3.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/site.js"></script>
    <script src="/js/init.js"></script>
    <script src="/js/users.js"></script>
    <script src="/js/groups.js"></script>
  </body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">

	<meta name="HandheldFriendly" content="true" />
	<meta name="MobileOptimized" content="320" />
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=3.0, width=device-width, user-scalable=yes" />


	<title>deconstudio task manager</title>
	
  	<link rel="stylesheet" href="{{asset('assets/bootstrap-3.2.0-dist/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="assets/css/style02.css">

	<style type="text/css">

        #gmap { width: 600px; height: 400px; }
        .glyphicon {
        	margin-right: 15px;
        }

       	.glyphicon-trash, .glyphicon-edit {
       		float: right;
       	}
       	li a:hover  {
			 
			  text-decoration: none;
		}
  	</style>
	
	@yield('style')
	

</head>
<body>



	<div id="ajax-load">
		<img class="ajax-loader" src="{{asset('assets/img/loading2__tr.gif')}}" alt="loading" />
	</div>



	<div>
		  
		<div class="navi">

		@if(Auth::check())
			<p class="navbar-text navbar-right">
				Logged in as <strong>{{{Auth::user()->username}}}</strong>. {{link_to('logout', 'Log Out')}}
			</p>
		@else
			<span class="navbar-brand"><a  id="brand" href="http://www.deconstudio.net" title="deconstudio.net">deconstudio</a> :: list manager</span>

			<form method="POST" action="login" class="navbar-form navbar-right" role="form">
				<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
				<div class="form-group">
					<input type="text" placeholder="Username" name="username" class="form-control">
				</div>
				<div class="form-group">
					<input type="password" placeholder="Password" name="password" class="form-control">
				</div>
				<button type="submit" class="btn btn-success">Log in</button>
			</form>


		@endif
        </div>

      	
    </div>




<!-- 	<div class="jumbotron">
	<div class="container">
		@yield('header')
	</div>
</div> -->

	<div class="container">



		@if(Session::has('message'))
		<div class="alert alert-success">
			{{Session::get('message')}}
		</div>
		@endif


		
		@if(Session::has('error'))
        <div class="alert alert-warning">
          {{Session::get('error')}}
        </div>
      	@endif


		@yield('content')



	</div>

	<script src="assets/js/jquery-1.11.1.min.js" type="text/javascript"></script>
	<script src="assets/js/jquery-ui.min.js" type="text/javascript"></script>
	<script src="assets/js/jquery.ui.touch-punch.min.js" type="text/javascript"></script>

	<script src="assets/bootstrap-3.2.0-dist/js/bootstrap.min.js" type="text/javascript"></script>

	<script src="assets/js/todo.js" type="text/javascript"></script>

</body


<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>
<body>
<div class="container">
	<br/><br/><br/><br/><br/>
	<div style="text-align: center;">
		<h4>Login</h4>
		<form method="post" action="controllers/login_controller.php" >
			<input type="email" name="email" class="form-control" placeholder="email" required autofocus><br/>
			<input type="password" name="password" class="form-control" placeholder="password" required><br/>
			<button type="submit" class="btn btn-success" style="width: 208px;">Login</button>
			
		</form>
	</div>
</div>

</body>
</html>
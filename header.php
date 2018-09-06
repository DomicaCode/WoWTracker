<?php
session_start();
?>


<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<title></title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<header>

<nav class="navbar navbar-expand-lg navbar navbar-dark bg-dark">
  <a class="navbar-brand" href="index.php">Tracker</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="profile.php">My profile <span class="sr-only">(current)</span></a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>





	<nav>
		<div class="main-wrapper">
			<div class="nav-login">
				<?php

				if(isset($_SESSION['u_id']))
				{
				}
				else
				{
					echo '
							<form action="includes/login.inc.php" method="POST">
							<input type="text" name="uid" placeholder="Username/email">
							<input type="password" name="pwd" placeholder="Password">
							<button type="submit" class="btn btn-primary" name="submit">Login</button>
							</form>
							<a href="signup.php">Sign up</a>'; 

				}
				?>

			</div>
		</div>
	</nav>
</header>
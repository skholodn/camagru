<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="/css/style.css")>
		<link rel="icon" href='/img/site/icon.png'>
		<link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
		<title><?= $title ?></title>
	</head>
	<body>
		<header>
			<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
				<div class="container">
					<div class="navbar-header">
						<a class="navbar-brand" href="/">Camagru</a>
					</div>
					<div class="navbar-nav">
						<ul class="navbar-nav nav-right">
							<?php if(Session::isLoggedOnUser()): ?>
								<li class='nav-item'><a class='nav-link' href="/profile">Profile</a></li>
								<li class='nav-item'><a class='nav-link' href="/login/logout">Log Out</a></li>
							<?php else: ?>
								<li class='nav-item'><a class='nav-link' href="/login">Log In</a></li>
								<li class='nav-item'><a class='nav-link' href="/registration">Register</a></li>
							<?php endif; ?>
						</ul>
					</div>
				</div>
			</nav>
		</header>
		<div class="container" id="main">
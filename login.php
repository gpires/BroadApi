<?php session_start();include('config.php');?><html><head><title>Admin MOS Template</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><link rel="shortcut icon" href="stylesheet/img/devil-icon.png"><link rel="stylesheet" type="text/css" href="mos-css/mos-style.css"></head>
<body><div id="header">	<div class="inHeaderLogin"></div></div><?php$info = "<div id=\"loginForm\">	<div class=\"headLoginForm\">	Login Administrator	</div>	<div class=\"fieldLogin\">	<form method=\"POST\" action=\"\">	<label>Username</label><br>	<input type=\"text\" name=\"username\" class=\"login\" id=\"Input\" placeholder=\"Username\" />	<label>Password</label><br>	<input type=\"password\" name=\"password\" class=\"pass\" id=\"Input\" placeholder=\"Password\" />	<br><br><input type=\"submit\" name=\"submit\" value=\"Login\" id=\"Button\" class=\"button\"/>	<input type=\"hidden\" name=\"submitted\" value=\"TRUE\" />	</div></div></body></html>";if (isset($_POST['submit']) || isset($_SESSION['login'])) {	if (isset($_SESSION['login'])) {		if ($_SESSION['login'] == $hash) { 		header("Location: index.php");		} else {			//if the SESSION exists, but does not equal the hash say...			session_destroy();			echo $info;			echo "<br><div class=\"errormsg\">Bad SESSION. Try again.</div>";		}	} else {		if ($_POST['username'] == $transmission_user && $_POST['password'] == $transmission_pass){			$_SESSION["login"] = $hash;			header("Location: index.php");		} else {			echo $info;			echo "<br><div class=\"errormsg\">Incorrect Username/Password</div>";			}		}}else {echo $info;}?>
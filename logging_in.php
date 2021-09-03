<?php

	session_start();
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == true))
	{
		header('Location: index.php');
		exit();
	}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<title>Strona logowania</title>
	<meta name="description" content="Zarządzanie budżetem" />
	<meta name="keywords" content="budżet, przychód, wydatki" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		
	<link rel="stylesheet" href="style2.css" type="text/css" />
	<link rel="stylesheet" href="css/fontello.css" type="text/css" />
	<link rel="shortcut icon" type="image/ico" href="img/bag.jpg">
	
</head>

<body>

	<div id="container">
		<form action="log_in.php" method="post">
		
			<div style="color: #008000; font-size: 24; font-weight: bold; margin-bottom: 20px; text-align: center;"> Podaj dane do logowania: </div>
			
			<div class="text-field" style="float: left"><i class="kafelek icon-user" style="margin-top: 5px"></i></div><input type="text" name="login" placeholder="login" onfocus="this.placeholder=' ' " onblur="this.placeholder='login '" maxlength="20" required>
			<div style="clear:both;">
			</div>
			
			<div class="text-field" style="float: left"><i class="kafelek icon-key"></i></div><input type="password" name="password" placeholder="hasło" onfocus="this.placeholder=' ' " onblur="this.placeholder='hasło'" maxlength="20" required>
			<div style="clear:both;">
			</div>
			
			<?php

			if(isset($_SESSION['blad']))
			{
			echo $_SESSION['blad'];
			}

			?>
			
			<input type="submit" value="Zaloguj się">
			
			<div id="brak" style="margin-left: 15px; margin-top: 15px; font-size: 16px;">Nie posiadasz jeszcze konta? <br /><a href="register.php" class="link"> Załóż konto </a></div>
			
		</form>

	</div>
	
</body>
</html>
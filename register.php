<?php

	session_start();

	if (isset($_POST['email']))
	{
		//Udana walidacja? Załóżmy, że tak!
		$wszystko_OK=true;
		
		//Sprawdź poprawność loginu
		$login = $_POST['login'];
		
		//Sprawdzenie długości loginu
		if ((strlen($login)<3) || (strlen($login)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_login']="Login musi posiadać od 3 do 20 znaków!";
		}
		
		if (ctype_alnum($login)==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_login']="Login może składać się tylko z liter i cyfr (bez polskich znaków)";
		}
		
		//Sprawdź poprawność adresu email
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$wszystko_OK=false;
			$_SESSION['e_email']="Podaj poprawny adres e-mail!";
		}
		
		//Sprawdź poprawność hasła
		$password1 = $_POST['password1'];
		$password2 = $_POST['password2'];
		
		if ((strlen($password1)<8) || (strlen($password1)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_password']="Hasło powinno zawierać od 8 do 20 znaków!";
		}
		
		if ($password1!=$password2)
		{
			$wszystko_OK=false;
			$_SESSION['e_password']="Podane hasła nie są identyczne!";
		}
		
		$password_hash = password_hash($password1, PASSWORD_DEFAULT);
		
		//Bot or not? Oto jest pytanie
		$sekret = "YOUR_SECRET_KEY";
		
		$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
		
		$odpowiedz = json_decode($sprawdz);
		
		if ($odpowiedz->success==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_bot']="Potwierdź, że nie jesteś botem!";
		}	
		
		//Zapamiętaj wprowadzone dane
		$_SESSION['fr_login'] = $login;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_password1'] = $password1;
		$_SESSION['fr_password2'] = $password2;
		
		require_once 'database.php';
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try
		{
				//Czy email już istnieje?
				$sql_email = 'SELECT id FROM uzytkownicy WHERE email=:email';
				$query = $db->prepare($sql_email);
				$query->bindValue(':email', $email, PDO::PARAM_STR);
				$query->execute();
				
				$user = $query->fetch();
				
				if ($user>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
				}
				
				//Czy login jest już zarezerwowany?
				$sql_login = 'SELECT id FROM uzytkownicy WHERE user=:login';
				$query_login = $db->prepare($sql_login);
				$query_login->bindValue(':login', $login, PDO::PARAM_STR);
				$query_login->execute();
				
				$login_user = $query_login->fetch();
				
				if ($login_user)
				{
					$wszystko_OK=false;
					$_SESSION['e_login']="Istnieje już użytkownik o takim loginie! Wybierz inny.";
				}
				
				if ($wszystko_OK==true)
				{
					//Hurra, wszystkie testy zaliczone, dodajemy użytkownika do bazy
					
						$sql_user = 'INSERT INTO uzytkownicy VALUES (NULL, :login, :password, :email)';
						
						
						$query_user = $db->prepare($sql_user);
						
						$query_user->bindValue(':login', $login, PDO::PARAM_STR);
						$query_user->bindValue(':password', $password_hash, PDO::PARAM_STR);
						$query_user->bindValue(':email', $email, PDO::PARAM_STR);
						$query_user->execute();
						
						$sql_test = 'INSERT INTO incomes_category_assigned_to_users (user_id, name) SELECT uzytkownicy.id, incomes_category_default.name FROM uzytkownicy, incomes_category_default WHERE uzytkownicy.email= :email';
						
						$query_incomes = $db->prepare($sql_test);
						$query_incomes->bindValue(':email', $email, PDO::PARAM_STR);
						$query_incomes->execute();
						
						$sql_test2 = 'INSERT INTO expenses_category_assigned_to_users (user_id, name) SELECT uzytkownicy.id, expenses_category_default.name FROM uzytkownicy, expenses_category_default WHERE uzytkownicy.email= :email';
						
						$query_expenses = $db->prepare($sql_test2);
						$query_expenses->bindValue(':email', $email, PDO::PARAM_STR);
						$query_expenses->execute();
						
						$sql_test3 = 'INSERT INTO payment_methods_assigned_to_users (user_id, name) SELECT uzytkownicy.id, payment_methods_default.name FROM uzytkownicy, payment_methods_default WHERE uzytkownicy.email= :email';
						
						$query_payment = $db->prepare($sql_test3);
						$query_payment->bindValue(':email', $email, PDO::PARAM_STR);
						$query_payment->execute();
						
						//var_dump($query_incomes->fetchAll());
						
						$_SESSION['udanarejestracja']=true;
						header('Location: logging_in.php');
				}
		
		}
		catch(Exception $e)
		{
			//var_dump($e);
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
			//echo '<br />Informacja developerska: '.$e;
		}
		
	}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<title>Strona rejestracji</title>
	<meta name="description" content="Zarządzanie budżetem" />
	<meta name="keywords" content="budżet, przychód, wydatki" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		
	<link rel="stylesheet" href="style2.css" type="text/css" />
	<link rel="stylesheet" href="css/fontello.css" type="text/css" />
	<link rel="shortcut icon" type="image/ico" href="img/bag.jpg">
	<script src='https://www.google.com/recaptcha/api.js'></script>
	
</head>

<body>

	<div id="container">
		<form method="post">
		
			<div style="color: #008000; font-size: 24; font-weight: bold; margin-bottom: 20px; text-align: center;"> Podaj dane do rejestracji: </div>
			
			<div class="text-field" style="float: left"><i class="kafelek icon-user"></i></div><input type="text" placeholder="login" name="login" onfocus="this.placeholder=' ' " onblur="this.placeholder='login'" maxlength="20">
			<div style="clear:both;">
			</div>
			
			<?php
			
				if (isset($_SESSION['e_login']))
				{
					echo '<div class="error">'.$_SESSION['e_login'].'</div>';
					unset($_SESSION['e_login']);
				}
			
			?>
			
			<div class="text-field" style="float: left"><i class="kafelek icon-mail"></i></div><input type="email" placeholder="e-mail" name="email" onfocus="this.placeholder=' ' " onblur="this.placeholder='email'">
			<div style="clear:both;">
			</div>
			
			<?php
			
				if (isset($_SESSION['e_email']))
				{
					echo '<div class="error">'.$_SESSION['e_email'].'</div>';
					unset($_SESSION['e_email']);
				}
			
			?>
			
			<div class="text-field" style="float: left"><i class="kafelek icon-key"></i></div><input type="password" placeholder="hasło" name="password1" onfocus="this.placeholder=' ' " onblur="this.placeholder='hasło'" maxlength="20">
			<div style="clear:both;">
			</div>
			
			<?php
			
				if (isset($_SESSION['e_password']))
				{
					echo '<div class="error">'.$_SESSION['e_password'].'</div>';
					unset($_SESSION['e_password']);
				}
			
			?>
			
			<div class="text-field" style="float: left"><i class="kafelek icon-key"></i></div><input type="password" placeholder="Powtórz hasło" name="password2" onfocus="this.placeholder=' ' " onblur="this.placeholder='Powtórz hasło'" style="margin-bottom:10px;">
			<div style="clear:both;">
			</div>
			
			<div class="g-recaptcha" data-sitekey="6LcO6qIaAAAAAArSoVFLOlIVOZccMv794KY-7HSL"></div>
			
			<?php
			
				if (isset($_SESSION['e_bot']))
				{
					echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
					unset($_SESSION['e_bot']);
				}
			
			?>
			
			<input type="submit" value="Zarejestruj się">
			
			<a href="logging_in.php"><button type="button" class="styled" style="margin-top: 10px; margin-left: 10%; margin-right: 5%;">Masz już konto? Zaloguj się!</button></a>
			
		</form>
	</div>
	
</body>
</html>

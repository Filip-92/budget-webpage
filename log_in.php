<?php

	session_start();
	
	if ((!isset($_POST['login'])) || (!isset($_POST['password'])))
	{
		header('Location:loging_in.php');
		exit();
	}

	require_once "connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
	}
	else
	{
		$login = $_POST['login'];
		$password = $_POST['password'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
	
		if ($rezultat = @$polaczenie->query(
		sprintf("SELECT * FROM uzytkownicy WHERE user='%s'",
		mysqli_real_escape_string($polaczenie,$login),
		mysqli_real_escape_string($polaczenie,$password))))
		{
			$ilu_userow = $rezultat->num_rows;
			if($ilu_userow>0)
			{
				$wiersz = $rezultat->fetch_assoc();
				
				if (password_verify($password, $wiersz['pass']))
				{
					$_SESSION['zalogowany'] = true;
							
					$_SESSION['id'] = $wiersz['id'];
					$_SESSION['user'] = $wiersz['user'];
					
					unset($_SESSION['blad']);
					$rezultat->free_result();
					header('Location: index.php');
				}
				else 
				{	
					header('Location: logging_in.php');
					$_SESSION['blad'] = '<div class="error">Nieprawidłowy login lub hasło!</div>';
				}
				
			} 
			else 
			{	
				header('Location: logging_in.php');
				$_SESSION['blad'] = '<div class="error">Nieprawidłowy login lub hasło!</div>';
			}
			
		}
		
		$polaczenie->close();
	}
	
?>
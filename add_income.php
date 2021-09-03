<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.html');
		exit();
	}
	
	$user_id = $_SESSION['logged_id'];

	if (isset($_POST['income_amount']))
	{
		$wszystko_OK=true;
		
		$income_amount = $_POST['income_amount'];
		if($income_amount<0)
		{
			$wszystko_OK=false;
			$_SESSION['e_income_amount']="Wartość przychodu musi być większa od 0";
			header('Location: incomes.html');
			exit();
		}
		if(!is_numeric($income_amount))
		{
			$wszystko_OK=false;
			$_SESSION['e_income_amount']="Musisz podać wartość będącą liczbą arabską";
			header('Location: incomes.html');
			exit();
		}
		$income_amount = str_replace(',','.',$income_amount);
		
		$income_date = filter_input(INPUT_POST, 'income_date');
		$income_category = filter_input(INPUT_POST, 'income_category', FILTER_SANITIZE_STRING);
		
		if (strlen($income_category)==0)
		{
			$wszystko_OK=false;
			$_SESSION['e_income_category']="Należy wybrać kategorię przychodu";
			header('Location: incomes.html');
			exit();
		}
		$income_comment = $_POST['income_comment'];
		if (strlen($income_comment)>30)
		{
			$wszystko_OK=false;
			$_SESSION['e_income_comment']="Komentarz może zawierać maksymalnie 30 znaków";
			header('Location: incomes.html');
			exit();
		}
		
		try
		{
			//$_SESSION['kwota'] = $wiersz['kwota'];
			//$_SESSION['data'] = $wiersz['data'];
			//$_SESSION['kategoria'] = $wiersz['kategoria'];
			//$_SESSION['komentarz'] = $wiersz['komentarz'];
			if($wszystko_OK==true)
			{
				$user_id = $_SESSION['id'];
				
				require_once "database.php";
				
				$sql_check_category_id = 'SELECT id FROM incomes_category_assigned_to_users WHERE user_id = :user_id AND name = :income_category';
				$query_category_id = $db->prepare($sql_check_category_id);
				$query_category_id->bindValue(':user_id', $user_id, PDO::PARAM_STR);
				$query_category_id->bindValue(':income_category', $income_category, PDO::PARAM_STR);
				$query_category_id->execute();
				
				$result = $query_category_id->fetch();
				//var_dump($income_id);
				$income_id = $result[0];
						
				$sql_income = "INSERT INTO incomes VALUES (NULL, :user_id, :income_id, :income_amount, :income_date, :income_comment)";
			
				$query_incomes2 = $db->prepare($sql_income);
				$query_incomes2->bindValue(':user_id', $user_id, PDO::PARAM_STR);
				$query_incomes2->bindValue(':income_id', $income_id, PDO::PARAM_STR);
				$query_incomes2->bindValue(':income_amount', $income_amount, PDO::PARAM_STR);
				$query_incomes2->bindValue(':income_date', $income_date, PDO::PARAM_STR);
				$query_incomes2->bindValue(':income_comment', $income_comment, PDO::PARAM_STR);
				$query_incomes2->execute();
				
				//var_dump($query_incomes2->fetchAll());
					
				$_SESSION['dodanoprzychod']=true;
				echo "Nowy przychód dodany";
				header('Location: index.php');
			}
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o dodanie przychodu w innym terminie!</span>';
			//echo '<br />Informacja developerska: '.$e;
		}
		
	}

?>
<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.html');
		exit();
	}
	
	$user_id = $_SESSION['id'];

	if (isset($_POST['expense_amount']))
	{
		$wszystko_OK=true;
		
		$expense_amount = $_POST['expense_amount'];
		if($expense_amount<0)
		{
			$wszystko_OK=false;
			$_SESSION['e_expense_amount']="Wartość wydatku musi być większa od 0";
			header('Location: expenses.html');
			exit();
		}
		if(!is_numeric($expense_amount))
		{
			$wszystko_OK=false;
			$_SESSION['e_expense_amount']="Musisz podać wartość będącą liczbą arabską";
			header('Location: expenses.html');
			exit();
		}
		$expense_amount = str_replace(',','.',$expense_amount);
		
		$expense_date = filter_input(INPUT_POST, 'expense_date');
		
		$payment_method = filter_input(INPUT_POST, 'payment_method', FILTER_SANITIZE_STRING);
		if (strlen($payment_method)==0)
		{
			$wszystko_OK=false;
			$_SESSION['e_payment_method']="Należy wybrać rodzaj płatności";
			header('Location: expenses.html');
			exit();
		}
		
		$expense_category = filter_input(INPUT_POST, 'expense_category', FILTER_SANITIZE_STRING);
		if (strlen($expense_category)==0)
		{
			$wszystko_OK=false;
			$_SESSION['e_expense_category']="Należy wybrać kategorię wydatku";
			header('Location: expenses.html');
			exit();
		}
		
		$expense_comment = $_POST['expense_comment'];
		if (strlen($expense_comment)>30)
		{
			$wszystko_OK=false;
			$_SESSION['e_expense_comment']="Komentarz może zawierać maksymalnie 30 znaków";
			header('Location: expenses.html');
			exit();
		}
		
		try
		{
			if($wszystko_OK==true)
			{
				$user_id = $_SESSION['id'];
				
				require_once "database.php";
				
				$sql_check_category_id = 'SELECT id FROM expenses_category_assigned_to_users WHERE user_id = :user_id AND name = :expense_category';
				$query_category_id = $db->prepare($sql_check_category_id);
				$query_category_id->bindValue(':user_id', $user_id, PDO::PARAM_STR);
				$query_category_id->bindValue(':expense_category', $expense_category, PDO::PARAM_STR);
				$query_category_id->execute();
				
				$result = $query_category_id->fetch();
				//var_dump($expense_id);
				$expense_id = $result[0];
				
				$sql_payment_method_id = 'SELECT id FROM payment_methods_assigned_to_users WHERE user_id = :user_id AND name = :payment_method';
				$query_payment_method_id = $db->prepare($sql_payment_method_id);
				$query_payment_method_id->bindValue(':user_id', $user_id, PDO::PARAM_STR);
				$query_payment_method_id->bindValue(':payment_method', $payment_method, PDO::PARAM_STR);
				$query_payment_method_id->execute();
				
				$result1 = $query_payment_method_id->fetch();
				//var_dump($payment_method_id);
				$payment_method_id = $result1[0];
						
				$sql_expense = "INSERT INTO expenses VALUES (NULL, :user_id, :expense_id, :payment_method_id, :expense_amount, :expense_date, :expense_comment)";
			
				$query_expenses2 = $db->prepare($sql_expense);
				$query_expenses2->bindValue(':user_id', $user_id, PDO::PARAM_STR);
				$query_expenses2->bindValue(':expense_id', $expense_id, PDO::PARAM_STR);
				$query_expenses2->bindValue(':expense_amount', $expense_amount, PDO::PARAM_STR);
				$query_expenses2->bindValue(':expense_date', $expense_date, PDO::PARAM_STR);
				$query_expenses2->bindValue(':payment_method_id', $payment_method_id, PDO::PARAM_STR);
				$query_expenses2->bindValue(':expense_comment', $expense_comment, PDO::PARAM_STR);
				$query_expenses2->execute();
				
				//var_dump($query_expenses2->fetchAll());
					
				$_SESSION['dodanowydatek']=true;
				echo "Nowy wydatek dodany";
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
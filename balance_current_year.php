<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.html');
		exit();
	}
	
	$id_user = $_SESSION['id'];   
	$current_date = date('Y-m-d');

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title>Bilans</title>
	<meta name="description" content="Zarządzanie budżetem" />
	<meta name="keywords" content="budżet, przychód, wydatki" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="main2.css" type="text/css" />
	<link rel="stylesheet" href="css/fontello.css" type="text/css" />
	<link rel="shortcut icon" type="image/ico" href="img/bag.jpg">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
	
	<!--[if lt IE 9]>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->
	
</head>

<body onload="data();">

	<header>
	
		<nav class="navbar navbar-dark bg-navbar navbar-expand-lg">
			
				<a class="navbar-brand" href="index.php"><img src="img/money.png" width="40" height="35" class="d-inline-block mr-1 align-center mx-2" alt=""> Budżet-Manager </a>
			
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
					<span class="navbar-toggler-icon"></span>
				</button>
			
				<div class="collapse navbar-collapse align-items-start" id="mainmenu">
			
				<ul class="navbar-nav mr-auto menu">
					<li class="nav-item">
						<a class="nav-link" href="incomes.php"><i class="icon-money" style="margin-right: 5px"></i>Dodaj przychód</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="expenses.php"><i class="icon-money-1" style="margin-right: 5px"></i>Dodaj wydatek</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active"><i class="icon-balance-scale" style="margin-right: 5px"></i>Przeglądaj bilans</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#"><i class="icon-cog-outline" style="margin-right: 5px"></i>Ustawienia</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="logout.php"><i class="icon-logout" style="margin-right: 5px"></i>Wyloguj się</a>
					</li>
				</ul>
				
				</div>
				
			</nav>
	
	<div id="container">
	
			<h1 class="logo1 text-center myclass m-auto"><a href="index.php" class="link" title="Strona główna"><img src="img/wallet.png" width="60" height="40" alt="portfel"/>Zarządzaj swoim budżetem<img src="img/wallet.png" width="60" height="40" alt="portfel"/></a></h1>
					
	</div>
		
		</header>
		
			<main>
	
				<article>
		
					<section>
		
						<div class="categories">
				
							<header>
							
								<h5 style="float: left;">Zalogowany jako: <?php echo '<span style="color:green">'.$_SESSION['user'].'</span>'; ?> </h5>
								<div style="clear:both;">
								</div>
		
								<h1 class="mt-3">Bilans z wybranego okresu:</h1>
			
									<form action="balance_current_year.php" method="post">

										<div id="formId" class="justify-content-center row">
								
										<label class="col-form-label">Okres zdefiniowany:</label>
										<select id="płatność" name="date_of_transaction" class="col-lg-12">
												<option value="current_month">Bieżący miesiąc</option>
												<?php
													$date_of_transaction = $_POST['date_of_transaction'];	
													
													if ($date_of_transaction == 'current_month')
													{
													header('Location: balance_default.php');
													exit();
													}
												?>
												<option value="previous_month">Poprzedni miesiąc</option>
												<?php
													if ($date_of_transaction == 'previous_month')
													{
													header('Location: balance_previous_month.php');
													exit();
													}
												?>
												<option value="current_year" selected>Bieżący rok</option>
												<?php
													if ($date_of_transaction == 'current_year')
													{
													header('Location: balance_current_year.php');
													exit();
													}
												?>
												<option value="custom_date">Niestandardowy</option>
												<?php
													if ($date_of_transaction == 'custom_date')
													{
														if ((isset($_POST['starting_date'])) && (isset($_POST['ending_date'])))
														{
															$starting_date = $_POST['starting_date'];;
															$ending_date = $_POST['ending_date'];;

															$_SESSION['starting_date'] = $starting_date;
															$_SESSION['ending_date'] = $ending_date;
															
															header('Location: balance_custom_date.php');
															exit();
														}
													}
												?>
										</select>
										
										<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
										  <div class="modal-dialog" role="document">
											<div class="modal-content">
											  <div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											  </div>
											  <div class="modal-body">
													<div id="formId" class="justify-content-center row">
														<label class="col-form-label" style="text-decoration: underline; color: green;">Zakres dat:</label>
														<label class="col-form-label">Od:</label><input type="date" name="starting_date">
														<label class="col-form-label">Do:</label><input type="date" name="ending_date">
													</div>
											  </div>
											  <div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
												<button type="submit" class="btn btn-success">Wybierz zakres</button>
											  </div>
											</div><!-- /.modal-content -->
										  </div><!-- /.modal-dialog -->
										</div><!-- /.modal -->
						
										</div>
										
											<div class="justify-content-center">
													<input type="submit" value="Filtruj" class="col-form-label" style="margin-top: 20px; margin-bottom: 20px;">
											</div>
										
									</form>
	
											<hr style="height: 5px; color: #000000;">

											<h3>Przychody</h3>
											<div class="category">
													<div class="category_transaction_category">
															<h4>Kategoria: </h4>
													</div>
													<div class="category_amount">
															<h4>Wysokość przychodu: </h4>
													</div>
													<div class="category_date">
															<h4>Data:</h4>
													</div>
													<div class="category_comment">
															<h4>Komentarz: </h4>
													</div>
											</div>
											<div class="kategoriap">
												<div class="column_incomes_category">
												<?php
													  require_once 'database.php';

													  $year = date("Y", strtotime($current_date));
													  													  
													  $sql_balance_incomes = "SELECT category_incomes.name as Category, SUM(incomes.amount) as Amount FROM incomes INNER JOIN incomes_category_assigned_to_users as category_incomes WHERE incomes.income_category_assigned_to_user_id = category_incomes.id AND incomes.user_id= :id_user AND YEAR(date_of_income) = :year GROUP BY Category ORDER BY Amount DESC";
													$query_select_incomes_sum = $db->prepare($sql_balance_incomes);
													$query_select_incomes_sum->bindValue(':id_user', $id_user, PDO::PARAM_INT);
													$query_select_incomes_sum->bindValue(':year', $year, PDO::PARAM_INT);                                
													$query_select_incomes_sum->execute();
												
													$result_sum_of_incomes = $query_select_incomes_sum->fetchAll();
												
													foreach($result_sum_of_incomes as $year_incomes)
													{
														$sql_incomes_details = "SELECT incomes.date_of_income as Date, incomes.income_comment as Comment, incomes.amount as Amount FROM incomes INNER JOIN incomes_category_assigned_to_users as category_incomes WHERE incomes.income_category_assigned_to_user_id = category_incomes.id AND incomes.user_id= :id_user AND YEAR(date_of_income) = :year AND category_incomes.name = :category_name ORDER BY Date DESC";
														$query_select_incomes_details = $db->prepare($sql_incomes_details);
														$query_select_incomes_details->bindValue(':id_user', $id_user, PDO::PARAM_INT);
														$query_select_incomes_details->bindValue(':year', $year, PDO::PARAM_INT);   
														$query_select_incomes_details->bindValue(':category_name', $year_incomes[0], PDO::PARAM_INT);   $query_select_incomes_details->execute();

														$result_details_of_incomes = $query_select_incomes_details->fetchAll();

															 echo $year_incomes[0].'<br>';
														}  
												?>
												</div>
												<div class="column_incomes_amount">
												<?php
													  require_once 'database.php';

													   $year = date("Y", strtotime($current_date));
													  
													  $sql_balance_incomes = "SELECT category_incomes.name as Category, SUM(incomes.amount) as Amount FROM incomes INNER JOIN incomes_category_assigned_to_users as category_incomes WHERE incomes.income_category_assigned_to_user_id = category_incomes.id AND incomes.user_id= :id_user AND Year(date_of_income) = :year GROUP BY Category ORDER BY Amount DESC";
													  $query_select_incomes_sum = $db->prepare($sql_balance_incomes);
													  $query_select_incomes_sum->bindValue(':id_user', $id_user, PDO::PARAM_INT);
													  $query_select_incomes_sum->bindValue(':year', $year, PDO::PARAM_INT);                                
													  $query_select_incomes_sum->execute();
																	
													  $result_sum_of_incomes = $query_select_incomes_sum->fetchAll();
																	
														foreach($result_sum_of_incomes as $year_incomes)
														{
															$sql_incomes_details = "SELECT incomes.date_of_income as Date, incomes.income_comment as Comment, incomes.amount as Amount FROM incomes INNER JOIN incomes_category_assigned_to_users as category_incomes WHERE incomes.income_category_assigned_to_user_id = category_incomes.id AND incomes.user_id= :id_user AND Year(date_of_income) = :year AND category_incomes.name = :category_name ORDER BY Date DESC";
															$query_select_incomes_details = $db->prepare($sql_incomes_details);
															$query_select_incomes_details->bindValue(':id_user', $id_user, PDO::PARAM_INT);
															$query_select_incomes_details->bindValue(':year', $year, PDO::PARAM_INT);   
															$query_select_incomes_details->bindValue(':category_name', $year_incomes[0], PDO::PARAM_INT);   
															$query_select_incomes_details->execute();

															$result_details_of_incomes = $query_select_incomes_details->fetchAll();

															 echo $year_incomes[1].'<br>';
														}  
												?>
												</div>
												<div class="column_incomes_date"> 
												<?php
													  require_once 'database.php';

													  $year = date("Y", strtotime($current_date));
													  
													  $sql_balance_incomes = "SELECT category_incomes.name as Category, SUM(incomes.amount) as Amount FROM incomes INNER JOIN incomes_category_assigned_to_users as category_incomes WHERE incomes.income_category_assigned_to_user_id = category_incomes.id AND incomes.user_id= :id_user AND Year(date_of_income) = :year GROUP BY Category ORDER BY Amount DESC";
													  $query_select_incomes_sum = $db->prepare($sql_balance_incomes);
													  $query_select_incomes_sum->bindValue(':id_user', $id_user, PDO::PARAM_INT);
													  $query_select_incomes_sum->bindValue(':year', $year, PDO::PARAM_INT);                                
													  $query_select_incomes_sum->execute();
																	
													  $result_sum_of_incomes = $query_select_incomes_sum->fetchAll();
																	
														foreach($result_sum_of_incomes as $year_incomes)
														{
															$sql_incomes_details = "SELECT incomes.date_of_income as Date, incomes.income_comment as Comment, incomes.amount as Amount FROM incomes INNER JOIN incomes_category_assigned_to_users as category_incomes WHERE incomes.income_category_assigned_to_user_id = category_incomes.id AND incomes.user_id= :id_user AND Year(date_of_income) = :year AND category_incomes.name = :category_name ORDER BY Date DESC LIMIT 1";
															$query_select_incomes_details = $db->prepare($sql_incomes_details);
															$query_select_incomes_details->bindValue(':id_user', $id_user, PDO::PARAM_INT);
															$query_select_incomes_details->bindValue(':year', $year, PDO::PARAM_INT);   
															$query_select_incomes_details->bindValue(':category_name', $year_incomes[0], PDO::PARAM_INT);   
															$query_select_incomes_details->execute();

															$result_details_of_incomes = $query_select_incomes_details->fetchAll();
															
															 foreach($result_details_of_incomes as $incomes_details)
															{
																  echo $incomes_details[0].'<br>'; 
															}      
														}
												?>
												</div>
												<div class="column_incomes_comment"> 
												<?php
													  require_once 'database.php';

													  $year = date("Y", strtotime($current_date));
													  
													  $sql_balance_incomes = "SELECT category_incomes.name as Category, SUM(incomes.amount) as Amount FROM incomes INNER JOIN incomes_category_assigned_to_users as category_incomes WHERE incomes.income_category_assigned_to_user_id = category_incomes.id AND incomes.user_id= :id_user AND Year(date_of_income) = :year GROUP BY Category ORDER BY Amount DESC";
													  $query_select_incomes_sum = $db->prepare($sql_balance_incomes);
													  $query_select_incomes_sum->bindValue(':id_user', $id_user, PDO::PARAM_INT);
													  $query_select_incomes_sum->bindValue(':year', $year, PDO::PARAM_INT);                                
													  $query_select_incomes_sum->execute();
																	
													  $result_sum_of_incomes = $query_select_incomes_sum->fetchAll();
																	
														foreach($result_sum_of_incomes as $year_incomes)
														{
															$sql_incomes_details = "SELECT incomes.date_of_income as Date, incomes.income_comment as Comment, incomes.amount as Amount FROM incomes INNER JOIN incomes_category_assigned_to_users as category_incomes WHERE incomes.income_category_assigned_to_user_id = category_incomes.id AND incomes.user_id= :id_user AND Year(date_of_income) = :year AND category_incomes.name = :category_name ORDER BY Date DESC LIMIT 1";
															$query_select_incomes_details = $db->prepare($sql_incomes_details);
															$query_select_incomes_details->bindValue(':id_user', $id_user, PDO::PARAM_INT);
															$query_select_incomes_details->bindValue(':year', $year, PDO::PARAM_INT);   
															$query_select_incomes_details->bindValue(':category_name', $year_incomes[0], PDO::PARAM_INT);   
															$query_select_incomes_details->execute();

															$result_details_of_incomes = $query_select_incomes_details->fetchAll();
															
															 foreach($result_details_of_incomes as $incomes_details)
															{
																  echo $incomes_details[1].'<br>'; 
															} 
														}															
												?>
												</div>
											</div>
											<div style="clear:both;">
											</div>
											
											<hr style="height: 5px; color: #000000;">
			
											<h3>Wydatki</h3>
											<div class="category">
													<div class="category_transaction_category">
															<h4>Kategoria: </h4>
													</div>
													<div class="category_amount">
															<h4>Wysokość wydatku: </h4>
													</div>
													<div class="category_date">
															<h4>Data:</h4>
													</div>
													<div class="category_comment">
															<h4>Komentarz: </h4>
													</div>
											</div>
											<div class="kategoriaw">
												<div class="column_incomes_category">
												<?php
													  require_once 'database.php';

													  $year = date("Y", strtotime($current_date));
													  
													  $sql_balance_expenses = "SELECT category_expenses.name as Category, SUM(expenses.amount) as Amount FROM expenses INNER JOIN expenses_category_assigned_to_users as category_expenses WHERE expenses.expense_category_assigned_to_user_id = category_expenses.id AND expenses.user_id= :id_user AND Year(date_of_expense) = :year GROUP BY Category ORDER BY Amount DESC";
													  $query_select_expenses_sum = $db->prepare($sql_balance_expenses);
													  $query_select_expenses_sum->bindValue(':id_user', $id_user, PDO::PARAM_INT);
													  $query_select_expenses_sum->bindValue(':year', $year, PDO::PARAM_INT);                                
													  $query_select_expenses_sum->execute();
																	
													  $result_sum_of_expenses = $query_select_expenses_sum->fetchAll();
																	
														foreach($result_sum_of_expenses as $year_expenses)
														{
															$sql_expenses_details = "SELECT expenses.date_of_expense as Date, expenses.expense_comment as Comment, expenses.amount as Amount FROM expenses INNER JOIN expenses_category_assigned_to_users as category_expenses WHERE expenses.expense_category_assigned_to_user_id = category_expenses.id AND expenses.user_id= :id_user AND Year(date_of_expense) = :year AND category_expenses.name = :category_name ORDER BY Date DESC";
															$query_select_expenses_details = $db->prepare($sql_expenses_details);
															$query_select_expenses_details->bindValue(':id_user', $id_user, PDO::PARAM_INT);
															$query_select_expenses_details->bindValue(':year', $year, PDO::PARAM_INT);   
															$query_select_expenses_details->bindValue(':category_name', $year_expenses[0], PDO::PARAM_INT);   
															$query_select_expenses_details->execute();

															$result_details_of_expenses = $query_select_expenses_details->fetchAll();

															 echo $year_expenses[0].'<br>';
														}  
												?>
												</div>
												<div class="column_incomes_amount">
												<?php
													  require_once 'database.php';

													  $year = date("Y", strtotime($current_date));
													  
													  $sql_balance_expenses = "SELECT category_expenses.name as Category, SUM(expenses.amount) as Amount FROM expenses INNER JOIN expenses_category_assigned_to_users as category_expenses WHERE expenses.expense_category_assigned_to_user_id = category_expenses.id AND expenses.user_id= :id_user AND Year(date_of_expense) = :year GROUP BY Category ORDER BY Amount DESC";
													  $query_select_expenses_sum = $db->prepare($sql_balance_expenses);
													  $query_select_expenses_sum->bindValue(':id_user', $id_user, PDO::PARAM_INT);
													  $query_select_expenses_sum->bindValue(':year', $year, PDO::PARAM_INT);                                
													  $query_select_expenses_sum->execute();
																	
													  $result_sum_of_expenses = $query_select_expenses_sum->fetchAll();
																	
														foreach($result_sum_of_expenses as $year_expenses)
														{
															$sql_expenses_details = "SELECT expenses.date_of_expense as Date, expenses.expense_comment as Comment, expenses.amount as Amount FROM expenses INNER JOIN expenses_category_assigned_to_users as category_expenses WHERE expenses.expense_category_assigned_to_user_id = category_expenses.id AND expenses.user_id= :id_user AND Year(date_of_expense) = :year AND category_expenses.name = :category_name ORDER BY Date DESC";
															$query_select_expenses_details = $db->prepare($sql_expenses_details);
															$query_select_expenses_details->bindValue(':id_user', $id_user, PDO::PARAM_INT);
															$query_select_expenses_details->bindValue(':year', $year, PDO::PARAM_INT);   
															$query_select_expenses_details->bindValue(':category_name', $year_expenses[0], PDO::PARAM_INT);   
															$query_select_expenses_details->execute();

															$result_details_of_expenses = $query_select_expenses_details->fetchAll();

															 echo $year_expenses[1].'<br>';
														}  
												?>
												</div>
												<div class="column_incomes_date"> 
												<?php
													  require_once 'database.php';

													  $year = date("Y", strtotime($current_date));
													  
													  $sql_balance_expenses = "SELECT category_expenses.name as Category, SUM(expenses.amount) as Amount FROM expenses INNER JOIN expenses_category_assigned_to_users as category_expenses WHERE expenses.expense_category_assigned_to_user_id = category_expenses.id AND expenses.user_id= :id_user AND Year(date_of_expense) = :year GROUP BY Category ORDER BY Amount DESC";
													  $query_select_expenses_sum = $db->prepare($sql_balance_expenses);
													  $query_select_expenses_sum->bindValue(':id_user', $id_user, PDO::PARAM_INT);
													  $query_select_expenses_sum->bindValue(':year', $year, PDO::PARAM_INT);                                
													  $query_select_expenses_sum->execute();
																	
													  $result_sum_of_expenses = $query_select_expenses_sum->fetchAll();
																	
														foreach($result_sum_of_expenses as $year_expenses)
														{
															$sql_expenses_details = "SELECT expenses.date_of_expense as Date, expenses.expense_comment as Comment, expenses.amount as Amount FROM expenses INNER JOIN expenses_category_assigned_to_users as category_expenses WHERE expenses.expense_category_assigned_to_user_id = category_expenses.id AND expenses.user_id= :id_user AND Year(date_of_expense) = :year AND category_expenses.name = :category_name ORDER BY Date DESC LIMIT 1";
															$query_select_expenses_details = $db->prepare($sql_expenses_details);
															$query_select_expenses_details->bindValue(':id_user', $id_user, PDO::PARAM_INT);
															$query_select_expenses_details->bindValue(':year', $year, PDO::PARAM_INT);   
															$query_select_expenses_details->bindValue(':category_name', $year_expenses[0], PDO::PARAM_INT);   
															$query_select_expenses_details->execute();

															$result_details_of_expenses = $query_select_expenses_details->fetchAll();
															
															 foreach($result_details_of_expenses as $expenses_details)
															{
																  echo $expenses_details[0].'<br>'; 
															}      
														}
												?>
												</div>
												<div class="column_incomes_comment"> 
												<?php
													  require_once 'database.php';

													  $year = date("Y", strtotime($current_date));
													  
													  $sql_balance_expenses = "SELECT category_expenses.name as Category, SUM(expenses.amount) as Amount FROM expenses INNER JOIN expenses_category_assigned_to_users as category_expenses WHERE expenses.expense_category_assigned_to_user_id = category_expenses.id AND expenses.user_id= :id_user AND Year(date_of_expense) = :year GROUP BY Category ORDER BY Amount DESC";
													  $query_select_expenses_sum = $db->prepare($sql_balance_expenses);
													  $query_select_expenses_sum->bindValue(':id_user', $id_user, PDO::PARAM_INT);
													  $query_select_expenses_sum->bindValue(':year', $year, PDO::PARAM_INT);                                
													  $query_select_expenses_sum->execute();
																	
													  $result_sum_of_expenses = $query_select_expenses_sum->fetchAll();
																	
														foreach($result_sum_of_expenses as $year_expenses)
														{
															$sql_expenses_details = "SELECT expenses.date_of_expense as Date, expenses.expense_comment as Comment, expenses.amount as Amount FROM expenses INNER JOIN expenses_category_assigned_to_users as category_expenses WHERE expenses.expense_category_assigned_to_user_id = category_expenses.id AND expenses.user_id= :id_user AND Year(date_of_expense) = :year AND category_expenses.name = :category_name ORDER BY Date DESC LIMIT 1";
															$query_select_expenses_details = $db->prepare($sql_expenses_details);
															$query_select_expenses_details->bindValue(':id_user', $id_user, PDO::PARAM_INT);
															$query_select_expenses_details->bindValue(':year', $year, PDO::PARAM_INT);   
															$query_select_expenses_details->bindValue(':category_name', $year_expenses[0], PDO::PARAM_INT);   
															$query_select_expenses_details->execute();

															$result_details_of_expenses = $query_select_expenses_details->fetchAll();
															
															 foreach($result_details_of_expenses as $expenses_details)
															{
																  echo $expenses_details[1].'<br>'; 
															} 
														}															
												?>
												</div>
											</div>
							<div style="clear:both;">
							
							<hr style="height: 5px; color: #000000;">
	
	</header>
	
	 <div class="col-12 col-xl-6 my-4" style="float: left">
                    <h3 class="card-title text-center display-4" style="margin-top: 0px; margin-bottom: 60px;">Bilans</h3>
                    <?php 
                        $incomes_sum = 0;                    
                        foreach($result_sum_of_incomes as $year_incomes)
                        {                          
                            $incomes_sum += $year_incomes[1];
                        }    

                        $expenses_sum = 0;
                        foreach($result_sum_of_expenses as $year_expenses)
                        {                          
                            $expenses_sum += $year_expenses[1];
                        }    
                         
                        $balance = $incomes_sum - $expenses_sum;
						
						if($balance >= 0)
                        {
                            echo '<div class = "text-field" style="color: green;">'.$balance.'zł</div>';
                        }
                        else 
						{
							echo '<div class = "text-field" style="color: red;">'.$balance.'zł</div>';
						}
                    ?>            
                    <?php
                        if($balance >= 0)
                        {
                            echo '<p class="message text-primary text-center" style="width: 400px;">Gratulacje. Świetnie zarządzasz finansami!</p>';
                        }
                        else echo '<p class="message text-danger text-center" style="width: 300px;">Uważaj, wpadasz w długi!</p>';
                    ?>                    
        </div>
		
		<div class="col-12 col-xl-6 my-4" style="float: left">
			<div class="display-4 text-center">Wydatki</div>
			<div id="chartWrap"></div>
			<div id="piechart" class="piechart"></div>
		</div>
		<div style="clear:both;">
		</div>
		
		<script src="https://www.gstatic.com/charts/loader.js"></script>

		<script>
			google.charts.load('current', {'packages':['corechart']});
			google.charts.setOnLoadCallback(drawChart);

			function drawChart() 
			{
				const data = google.visualization.arrayToDataTable([
					['Wydatek', 'zł'],
					<?php
						foreach ($result_sum_of_expenses as $expense)
						{
							echo "['".$expense[0]."',".$expense[1]."],";
						}
					?>
				]);

				const options = {
					legend: {position: 'bottom', alignment: 'center'},
					chartArea:{width:'50%',height:'400px'},
			};

			const chart = new google.visualization.PieChart(document.getElementById('piechart'));

			chart.draw(data, options);
			}    

		</script>                         

					</div>
	
				</section>
	
			</article>
		
		</main>
		
		<footer>
				
				<div class="info" style="text-align: center;">
						Wszelkie prawa zastrzeżone &copy; 2021 Zarządzaj swoim budżetem!
				</div>
		
		</footer>
		
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
		
		<script src="modal.js"></script>

</body>
</html>
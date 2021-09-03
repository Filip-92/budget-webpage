<?php

	session_start();
	
	if ((!isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] != true))
	{
		header('Location: index.html');
		exit();
	}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title>Przychody</title>
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

<body>

	<header>
	
		<nav class="navbar navbar-dark bg-navbar navbar-expand-lg">
			
				<a class="navbar-brand" href="index.php"><img src="img/money.png" width="40" height="35" class="d-inline-block mr-1 align-center mx-2" alt=""> Budżet-Manager</a>
			
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
					<span class="navbar-toggler-icon"></span>
				</button>
			
				<div class="collapse navbar-collapse align-items-start" id="mainmenu">
			
				<ul class="navbar-nav mr-auto menu">
					<li class="nav-item">
						<div class="nav-link active"><i class="icon-money" style="margin-right: 5px"></i>Dodaj przychód</div>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="expenses.php"><i class="icon-money-1" style="margin-right: 5px"></i>Dodaj wydatek</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="balance_default.php"><i class="icon-balance-scale" style="margin-right: 5px"></i>Przeglądaj bilans</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#"><i class="icon-cog-outline" style="margin-right: 5px"></i>Ustawienia</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="logout.php"><i class="icon-logout" style="margin-right: 5px"></i>Wyloguj się</a>
					</li>
					
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
			
								<form action="add_income.php" method="post">
								
									<h1 class="mt-3">Dodaj przychód:</h1>
														
									<div id="formId" class="justify-content-center row">	
									
										<label class="col-form-label" >Kwota: </label><input id="kategoria" type="number" placeholder="21.37" onfocus="this.placeholder=' ' " onblur="this.placeholder='21.37' " name="income_amount" step='0.01' style="margin-right: 0px;">
										
										<?php
			
										if (isset($_SESSION['e_income_amount']))
										{
											echo '<div class="error">'.$_SESSION['e_income_amount'].'</div>';
											unset($_SESSION['e_income_amount']);
										}
			
										?>
										
										<label class="col-form-label"> Data przychodu:</label><input type="date" name="income_date" value="<?php echo date('Y-m-d'); ?>" style="margin-top: 5px; margin-right: 0px;">
										
										<?php
			
										if (isset($_SESSION['e_income_date']))
										{
											echo '<div class="error">'.$_SESSION['e_income_date'].'</div>';
											unset($_SESSION['e_income_date']);
										}
			
										?>
										
										<label for="kategoria" class="col-form-label" style="margin-top: 5px;"> Kategoria: </label>
										<select id="kategoria" name="income_category" style="margin-right: 0px;">
											<option value="Wynagrodzenie" selected>Wynagrodzenie</option>
											<option value="Odsetki bankowe">Odsetki bankowe</option>
											<option value="Sprzedaż na allegro">Sprzedaż na allegro</option>
											<option value="Inne">Inne</option>
										</select>
										
										<?php
			
										if (isset($_SESSION['e_income_category']))
										{
											echo '<div class="error">'.$_SESSION['e_income_category'].'</div>';
											unset($_SESSION['e_income_category']);
										}
			
										?>
									
										<label id="komentarz" class="col-form-label" >Komentarz (opcjonalnie):</label><input type="text" placeholder="inne" onfocus="this.placeholder=' ' " onblur="this.placeholder='inne' " name="income_comment" style="margin-top: 5px; margin-right: 0px;">
										
										<?php
			
										if (isset($_SESSION['e_income_comment']))
										{
											echo '<div class="error">'.$_SESSION['e_income_comment'].'</div>';
											unset($_SESSION['e_income_comment']);
										}
			
										?>
										
									</div>
									
									<div class="row row-expenses justify-content-center">
											<div class="col-xl-6 col-lg-12">
													<input type="submit" value="Dodaj" class="col-lg-6 col-form-label">
											</div>
											<div class="col-xl-6 col-lg-12">
												<input type="reset" value="Anuluj" class="col-lg-6 col-form-label">
											</div>
									</div>
						
								</form>
							</header>
						</div>
	
				</section>
	
			</article>
		
		</main>
		
		<footer>
				
				<div class="info" style="text-align: center;">
						Wszelkie prawa zastrzeżone &copy; 2021 Dziękuję za wizytę!
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
		
		<script src="js/bootstrap.min.js"></script>

</body>
</html>

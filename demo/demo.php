<?php
/************************************************************************
 * Przykład wykorzystania API dla strony https://zaradnypolak.eu
 * Copyright (c) 2018 Kamil Wyremski
 * https://wyremski.pl
 *
 * All right reserved
 *
 * Instrukcja API: https://zaradnypolak.eu/info/11,api-instrukcja
 *
 * *********************************************************************/

ini_set("display_errors", "1");
error_reporting(E_ALL);
  
require_once('../zaradny-api.class.php');

$alert_danger = '';
$alert_success = '';

try{
	$zaradnyApi = new zaradnyApi();
	if(!empty($_POST['action'])){
		$zaradnyApi->checkAction($_POST);
		$zaradny_request_url = $zaradnyApi->createRequestUrl($_POST);
		$result = $zaradnyApi->getResult($zaradny_request_url);
		// w zmiennej $result znajduje się tablica z odpowiedzią z serwera  
		//print_r($result);
		$info = $zaradnyApi->generateInfo($_POST,$result);
		if(!empty($info['error'])){
			$alert_danger = $info['error'];
		}
		if(!empty($info['success'])){
			$alert_success = $info['success'];
		}
	}
}catch(Exception $e){
	$alert_danger = $e->getMessage();
}
?>
<!doctype html>
<html lang="pl">
<head>
  <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>API ZaradnyPolak.eu</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css">
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script src="engine.js"></script>
</head>
<body>
<form class="container" action="" method="post">
	<?php 
		if($alert_danger){
			echo('<div class="alert alert-danger" role="alert">'.$alert_danger.'</div>');
		}
		if($alert_success){
			echo('<div class="alert alert-success" role="alert">'.$alert_success.'</div>');
		}
	?>
	<div class="form-group">
		<label for="select_action">Wybierz akcje</label>
		<select class="form-control" id="select_action" required name="action">
			<option value="">-- wybierz --</option>
			<option value="show_offer">Pokaż ogłoszenie</option>
			<option value="list_offers">Listuj ogłoszenia</option>
			<option value="add_offer">Dodaj ogłoszenie</option>
			<option value="edit_offer">Edytuj ogłoszenie</option>
			<option value="remove_offer">Usuń ogłoszenie</option>
			<option value="list_types">Listuj typy ogłoszeń</option>
			<option value="list_categories">Listuj kategorie</option>
			<option value="list_countries">Listuj kraje</option>
			<option value="list_states">Listuj regiony</option>
		</select>
	</div>
	<div class="form-group box_action" id="box_offer_id">
		<label for="offer_id">ID ogłoszenia</label>
		<input type="number" class="form-control" id="offer_id" required disabled name="offer_id" min="1">
	</div>
	<div class="form-group box_action" id="box_page">
		<label for="page">Strona paginacji</label>
		<input type="number" class="form-control" id="page" disabled name="page" min="1" value="1">
	</div>
	<div class="box_action" id="box_add">
		<div class="form-group">
			<label for="name">Tytuł ogłoszenia</label>
			<input type="text" class="form-control" id="name" required disabled name="name" maxlength="128">
		</div>
		<div class="form-group">
			<label for="type_id">ID typu ogłoszenia</label>
			<input type="number" class="form-control" id="type_id" required disabled name="type_id" min="1">
		</div>
		<div class="form-group">
			<label for="category_id">ID kategorii</label>
			<input type="number" class="form-control" id="category_id" required disabled name="category_id" min="1">
		</div>
		<div class="form-group">
			<label for="description">Opis ogłoszenia</label>
			<textarea class="form-control" id="description" required disabled name="description"></textarea>
		</div>
		<div class="form-group">
			<label for="country_id">ID kraju</label>
			<input type="number" class="form-control" id="country_id" required disabled name="country_id" min="1">
		</div>
		<div class="form-group">
			<label for="state_id">ID regionu</label>
			<input type="number" class="form-control" id="state_id" required disabled name="state_id" min="1">
		</div>
		<div class="form-group">
			<label for="state2_id">ID podregionu</label>
			<input type="number" class="form-control" id="state2_id" required disabled name="state2_id" min="1">
		</div>
		<div class="form-group">
			<label for="phone">Telefon</label>
			<input type="text" class="form-control" id="phone" disabled name="phone" maxlength="32">
		</div>
		<div class="form-group">
			<label for="address">Adres</label>
			<input type="text" class="form-control" id="address" disabled name="address" maxlength="512">
		</div>
		<div class="form-group">
			<label for="address_lat">Adres - szerokość geograficzna</label>
			<input type="number" class="form-control" id="address_lat" disabled name="address_lat" step="0.000001">
		</div>
		<div class="form-group">
			<label for="address_long">Adres - długość geograficzna</label>
			<input type="number" class="form-control" id="address_long" disabled name="address_long" step="0.000001">
		</div>
		<div class="form-group">
			<label for="price">Cena</label>
			<input type="number" class="form-control" id="price" disabled name="price" min="0" step="0.01">
		</div>
		<div class="form-group">
			<label for="currency">Waluta</label>
			<input type="text" class="form-control" id="currency" disabled name="currency">
		</div>
		<div class="form-group">
			<label><input type="checkbox" name="price_negotiate"> Cena do negocjacji</label>
		</div>
		<div class="form-group">
			<label><input type="checkbox" name="price_free"> Za darmo</label>
		</div>
	</div>
	<div class="form-group box_action" id="box_category_id">
		<label for="category_id">ID nadkategorii</label>
		<input type="number" class="form-control" id="category_id" disabled name="category_id" min="0">
	</div>
	<div class="box_action" id="box_state">
		<div class="form-group">
			<label for="country_id">ID kraju</label>
			<input type="number" class="form-control" id="country_id" required disabled name="country_id" min="0">
		</div>
		<div class="form-group">
			<label for="state_id">ID regionu</label>
			<input type="number" class="form-control" id="state_id" disabled name="state_id" min="0">
		</div>
	</div>
	<button type="submit" class="btn btn-primary">Wyślij</button>
</form>
</body>
</html>
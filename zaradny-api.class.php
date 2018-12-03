<?php
/************************************************************************
 * Klasa dla API dla strony https://zaradnypolak.eu ver 1.0.0
 * Copyright (c) 2018 Kamil Wyremski
 * https://wyremski.pl
 *
 * All right reserved
 *
 * Instrukcja API: https://zaradnypolak.eu/info/11,api-instrukcja
 *
 * *********************************************************************/

class zaradnyApi{
	
	private $user_id = 0; // Tutaj wpisz ID użytkownika z serwisu zaradnypolak.eu
	private $api_key = ''; // Tutaj wklej klucz API wygenerowany w serwisie zaradnypolak.eu
	
	private $zaradny_url_api = 'https://zaradnypolak.eu/api';

	public function __construct(){
		if(!($this->user_id>0) or strlen($this->api_key)!=32){
			throw new Exception("Nieprawidłowe ID użytkownika lub klucz API");
		}
	}
	
	public function checkAction(array $request){
		if(!(($request['action']=='show_offer' and !empty($request['offer_id'])) or 
			($request['action']=='list_offers') or
			($request['action']=='list_my_offers') or
			(($request['action']=='add_offer' or $request['action']=='edit_offer') and !empty($request['name']) and !empty($request['category_id']) and !empty($request['type_id'])) or 
			($request['action']=='remove_offer' and !empty($request['offer_id'])) or 
			($request['action']=='list_types') or 
			($request['action']=='list_categories') or
			($request['action']=='list_countries') or
			($request['action']=='list_states' and isset($request['country_id']) and $request['country_id']>0))){
			throw new Exception("Nieznana akcja lub brak wszystkich wymaganych parametrów");
		}
	}
	
	public function createRequestUrl(array $request){
		$request['user_id'] = $this->user_id;
		ksort($request);
		$code = '';
		foreach($request as $key=>$value){
			$code .= $value;
		}
		$request['hash'] = hash('sha256', $code.$this->api_key);
		return $this->zaradny_url_api.'/?'.http_build_query($request);
	}
	
	public function getResult(string $request_url){
		return json_decode(file_get_contents($request_url), true);
	} 
	
	public function generateInfo(array $request, array $response){
		$info = ['error'=>'','success'=>''];
		if(!empty($response['error'])){
			$info['error'] = 'Wystąpił błąd! Odpowiedź z serwera: '.$response['error'];
		}else{
			if($request['action']=='show_offer' and !empty($response['name'])){
				$info['success'] = 'Poprawnie pobrano ogłoszenie '.$response['name'];
			}elseif($request['action']=='list_offers' and !empty($response['offers'])){
				$info['success'] = 'Poprawnie pobrano '.count($response['offers']).' ogłoszeń';
			}elseif($request['action']=='list_my_offers' and !empty($response['offers'])){
				$info['success'] = 'Poprawnie pobrano '.count($response['offers']).' ogłoszeń';
			}elseif($request['action']=='add_offer' and !empty($response['success']) and !empty($response['offer_id'])){
				$info['success'] = $response['success'].'. ID ogłoszenia: '.$response['offer_id'];
			}elseif($request['action']=='edit_offer' and !empty($response['success'])){
				$info['success'] = $response['success'];
			}elseif($request['action']=='remove_offer' and !empty($response['success'])){
				$info['success'] = $response['success'];
			}elseif($request['action']=='list_types' and !empty($response['types'])){
				$info['success'] = 'Poprawnie pobrano '.count($response['types']).' typów';
			}elseif($request['action']=='list_categories' and !empty($response['categories'])){
				$info['success'] = 'Poprawnie pobrano '.count($response['categories']).' kategorii';
			}elseif($request['action']=='list_countries' and !empty($response['countries'])){
				$info['success'] = 'Poprawnie pobrano '.count($response['countries']).' krajów';
			}elseif($request['action']=='list_states' and !empty($response['states'])){
				$info['success'] = 'Poprawnie pobrano '.count($response['states']).' regionów';
			}else{
				$info['error'] = 'Nieznany błąd';
			}
		}
		return $info;
	}
}
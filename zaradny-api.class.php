<?php
/************************************************************************
 * Klasa dla API dla strony https://zaradnypolak.eu ver 0.0.1
 * Copyright (c) 2018 Kamil Wyremski
 * https://wyremski.pl
 *
 * All right reserved
 *
 * Instrukcja API: https://zaradnypolak.eu/info/11,api-instrukcja
 *
 * *********************************************************************/

class zaradnyApi{
	
	private $user_id = 'Tutaj wpisz ID użytkownika';
	private $api_key = 'Tutaj wklej klucz API';
	
	private $zaradny_url_api = 'https://zaradnypolak.eu/api';
		
	public function __construct(){
		if(!($this->user_id>0) or strlen($this->api_key)!=32){
			throw new Exception("Nieprawidłowe ID użytkownika lub klucz API");
		}
	}
	
	public function checkAction(array $request){
		if(!(($request['action']=='show_offer' and !empty($request['offer_id'])) or 
			($request['action']=='list_offers') or
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
}
<?php

namespace App\Services\Movie;

use App\Services\Movie\Form\MovieForm;

use App\Foundation\Validation\FormValidationException;

class MovieService
{

    /**
     * MovieService Constructor
    *
    * @param UserRepository $userRepository
    */

    protected $client;
    protected $args;
    protected $response;

	public function __construct() {
		$this->client = new \GuzzleHttp\Client();

        $this->args = array();
        
        $headers = [ 
        	'Content-Type' 	=> 'application/json', 
        	'Accept' 		=> 'application/json', 
        ];

        $this->args['headers'] = $headers;
	}

    /**
     * Send request to omdb api
     *
     * @param string $host
     * @param string $method
     * @return void
     */
	public function sendRequest($host, $method)
    {
    	$prefixUrl = 'http://www.omdbapi.com/?apikey='. env('APIKEY_OMDB');
        
    	$fullUrl = $prefixUrl . $host;
        
        try {
            return $this->response = json_decode( $this->client->request( $method, $fullUrl, $this->args )->getBody() );
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return $this->response = json_decode($e->getResponse()->getBody()->getContents());
        } 
    } 

    public function searchMovie(string $search)
    {
        $host ='&s=' . $search;

        $method = 'GET';

        return $this->sendRequest($host, $method);
    } 
      
}
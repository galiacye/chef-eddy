<?php
namespace App\Controllers;

class Api extends BaseController
{
    private $client;

    public  function __construct()
    {
        $this->client = service('curlrequest');//service curlrequest de ci4 se charge des appels http aux API externes
    }
    public function recipesByCat()
    {
        $req = $this->client->request('GET','https://www.themealdb.com/api/json/v1/1/categories.php',["verify"=>false]);
        //["verify"=>false] dit de ne pas vérif le certif ssl
        $reponse = $req->getBody();//recup le json brut
        $resultat = json_decode($reponse);
        $data = [
            "resultat"=>$resultat
        ];
        return view('Api/recipesByCat',$data);
    }


    public function recipesByName() //with javascript into view
    {
       return view('Api/recipesByNameJs');
    }
}
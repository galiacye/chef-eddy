<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class World extends BaseController
{
    // url de l'API TheMealDB avec clé gratuite 1
    private string $baseUrl  = 'https://www.themealdb.com/api/json/v1/1/';

    // exculre la cuisine française et les entrées inconnues:
    private array  $excluded = ['French', 'Unknown'];
    //propriété de classe on l'utilisera 
    // page principale : affiche la liste des pays
    public function worldIndex(): string
    {
        try {
            $client   = \Config\Services::curlrequest();
            $response = $client->get($this->baseUrl . 'list.php?a=list');
            $data     = json_decode($response->getBody(), true);
            $countries = [];

            foreach ($data['meals'] ?? [] as $country) {
                if (!in_array($country['strArea'], $this->excluded)) {
                    $countries[] = $country;
                }
            };
            //ou avec une fonction fléchée:
            //$countries = array_filter(
            // $data['meals'] ?? [],
            // fn($c) => !in_array($c['strArea'], $this->excluded)
            //);
            // on filtre les pays exclus
            // $countries = array_filter(
            //    $data['meals'] ?? [],
            //     fn($country) => !in_array($country['strArea'], $this->excluded) //propriété de classe d'ou $this
            //si var interne à la méthode serait $excluded


            return view('world/worldIndex', ['countries' => $countries]);
        } catch (\Exception $e) {
            //  cas d'absence de connexion ou d'erreur API
            return view('world/error');
        }
    }
    /**
     * les recettes d'un pays
     * GET /cuisine-du-monde/(:alpha)
     */
    public function byCountry(string $country): string
    {
        // on échappe le param reçu depuis l'url:
        $country = esc($country);

        try {
            $client   = \Config\Services::curlrequest();
            $response = $client->get($this->baseUrl . 'filter.php?a=' . urlencode($country));
            $data     = json_decode($response->getBody(), true);

            // si aucune recette trouvée, on passe un tableau vide
            $meals = $data['meals'] ?? []; //opérateur de coeallescence nulle:
            //si il existe et n'est pas nul sinon tab vide

            return view('world/results', [
                'country' => $country,
                'meals'   => $meals,
            ]);
        } catch (\Exception $e) {
            return view('world/error');
        }
    }

    /**
     * Affiche le détail d'une recette via son ID TheMealDB
     */
    public function detail(int $id): string
    { //les try-catch ne sont nécessaires que pour gérer les erreurs dûes à des sources externes,
        //les nôtres CI4 s'en charge
        try {
            $client   = \Config\Services::curlrequest();
            $response = $client->get($this->baseUrl . 'lookup.php?i=' . $id);
            $data     = json_decode($response->getBody(), true);
            //dd($data)si on veut voir le json en tab php
            $meal = $data['meals'][0] ?? null;
            //idem pour le 1er elem du tab meal , ici ça parait redondant de dire
            //si c'est null la valeur par défaut est null mais c'est surtout pour éviter les erreurs.
            //[0] car l'api retourne un tab même pour une recette donc le premier elem
            // Si l'id ne correspond à aucune recette
            if (!$meal) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }

            return view('world/detail', ['meal' => $meal]);
        } catch (\CodeIgniter\Exceptions\PageNotFoundException $e) {
            //  404 par CI4
            throw $e;
        } catch (\Exception $e) {
            return view('world/error');
           // dd($e->getMessage());
        }
    }
}

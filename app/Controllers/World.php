<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class World extends BaseController
{
    // url de base de l'API TheMealDB +clé gratuite 1
    private string $baseUrl  = 'https://www.themealdb.com/api/json/v1/1/';

    // Pays exclus de la liste (cuisine française et entrées sans catégorie)
    private array  $excluded = ['French', 'Unknown'];

    /**
     * Page principale : affiche la liste des pays disponibles
     * GET /cuisine-du-monde
     */
    public function worldIndex(): string
    {
        try {
            $client   = \Config\Services::curlrequest();
            $response = $client->get($this->baseUrl . 'list.php?a=list');
            $data     = json_decode($response->getBody(), true);

            // On filtre les pays exclus
            $countries = array_filter(
                $data['meals'] ?? [],
                fn($c) => !in_array($c['strArea'], $this->excluded)
            );

            return view('world/worldIndex', ['countries' => $countries]);

        } catch (\Exception $e) {
            // En cas d'absence de connexion ou d'erreur API
            return view('world/error');
        }
    }

    /**
     * Affiche les recettes d'un pays donné
     * GET /cuisine-du-monde/(:alpha)
     */
    public function byCountry(string $country): string
    {
        // Échappement du paramètre reçu depuis l'URL
        $country = esc($country);

        try {
            $client   = \Config\Services::curlrequest();
            $response = $client->get($this->baseUrl . 'filter.php?a=' . urlencode($country));
            $data     = json_decode($response->getBody(), true);

            // Si aucune recette trouvée, on passe un tableau vide
            $meals = $data['meals'] ?? [];

            return view('world/results', [
                'country' => $country,
                'meals'   => $meals,
            ]);

        } catch (\Exception $e) {
            return view('world/error');
        }
    }

    /**
     * affiche le détail d'une recette via son id TheMealDB
     * GET /cuisine-du-monde/recette/(:num)
     */
    public function detail(int $id): string
    {
        try {
            $client   = \Config\Services::curlrequest();
            $response = $client->get($this->baseUrl . 'lookup.php?i=' . $id);
            $data     = json_decode($response->getBody(), true);

            $meal = $data['meals'][0] ?? null;

            // Si l'id ne correspond à aucune recette
            if (!$meal) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }

            return view('world/detail', ['meal' => $meal]);

        } catch (\CodeIgniter\Exceptions\PageNotFoundException $e) {
            // On laisse CI4 gérer le 404 normalement
            throw $e;
        } catch (\Exception $e) {
            return view('world/error');
        }
    }
}
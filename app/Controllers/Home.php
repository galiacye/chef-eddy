<?php

namespace App\Controllers;
use App\Libraries\Pdf;

class Home extends BaseController
{
    public function index(): string
    {
        return view('Home/accueil');
    }
    
    public function salut()
    {
        return view('Home/test');
    }

       public function afficher()
    {
        return view('Home/afficher');
    }

    public function creerPdf()
    {
        $pdf = new Pdf;
        $pdf->generate('<h1>Test pdf</h1>');
    }
}

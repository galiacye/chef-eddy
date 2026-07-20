<?php

namespace App\Controllers;

use App\Models\RecipeModel;
use App\Libraries\Pdf;

class PdfController extends BaseController
{
    public function generate($id)
    {
        $recipeModel = new RecipeModel();
        $recipe = $recipeModel->find($id);

        if (! $recipe) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = ['recipe' => $recipe];
        $html = view('recipes/pdf_template', $data);

        $pdf = new Pdf();
        $pdf->generate($html);
    }
}
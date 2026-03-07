<?php

namespace App\libraries;
use Dompdf\Dompdf;

class Pdf
{
    protected Dompdf $dompdf;

    public function __construct()
    {
        $this->dompdf = new Dompdf();
    }
    public function generate(string $html)
    {
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4','portrait');
        $this->dompdf->render();
        $this->dompdf->stream();
    }

}

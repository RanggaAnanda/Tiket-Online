<?php
use Dompdf\Dompdf;
use Dompdf\Options;

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'third_party/dompdf/autoload.inc.php';

class Dompdf_gen
{
    public $dompdf;

    public function __construct()
    {
        $options = new Options();
        $options->set('isRemoteEnabled', true); // agar bisa load gambar dari path file://
        $this->dompdf = new Dompdf($options);
    }

    public function generate($html, $filename = '', $stream = true, $paper = 'A4', $orientation = 'portrait')
    {
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper($paper, $orientation);
        $this->dompdf->render();

        if ($stream) {
            $this->dompdf->stream($filename . ".pdf", array("Attachment" => 1));
        } else {
            return $this->dompdf->output();
        }
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: enola
 * Date: 26/03/2019
 * Time: 17:33
 */

namespace PhPeteur\Fusion2PDFs;

use SetaPDF_Core_Writer;

class RectoVerso2PDFsIn1
{

    public function __construct($szPDFRecto, $szPDFVerso, $nPDFVersoNbPageToConsider)
    {
        $_PDFRecto = $szPDFRecto;
        $_PDFVerso = $szPDFVerso;
        $_PDFVersoNbPageToConsider = $nPDFVersoNbPageToConsider;

        $objPDFOne = null;

    }

}

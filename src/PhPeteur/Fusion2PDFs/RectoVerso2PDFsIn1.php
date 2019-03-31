<?php
/**
 * Created by PhpStorm.
 * User: enola
 * Date: 26/03/2019
 * Time: 17:33
 */

namespace PhPeteur\Fusion2PDFs;

use SetaPDF_Core;
use SetaPDF_Core_Writer;
use SetaPDF_Core_Writer_FileInterface;
use SetaPDF_Core_Document;


class RectoVerso2PDFsIn1
{

    protected $_PDFRecto;
    protected $_PDFVerso;
    protected $_PDFVersoNbPageToConsider;
    protected $_PDFOutput;
    protected $_bEraseOutputIfExists;

    public function __construct($szPDFRecto, $szPDFVerso, $szOutputPDF, $nPDFVersoNbPageToConsider = 0, $bEraseOutputIfExists = false)
    {
        $this->_PDFRecto = $szPDFRecto;
        $this->_PDFVerso = $szPDFVerso;
        $this->_PDFOutput = $szOutputPDF;
        $this->_PDFVersoNbPageToConsider = $nPDFVersoNbPageToConsider;
        $this->_bEraseOutputIfExists = $bEraseOutputIfExists;
    }

    public function run()
    {
        $arResult = array();
        $arResult['status'] = false;
        if ( (!file_exists($this->_PDFVerso)) || (!file_exists($this->_PDFRecto)) ) {
            $arResult['errormsg'] = 'One of the input PDF is missing.';
            return ($arResult);
        }
        if ( ($this->_bEraseOutputIfExists == false) && file_exists($this->_PDFOutput) )  {
            $arResult['errormsg'] = 'Output PDF exists already add option --forcerewriteoutput.';
            return ($arResult);
        }
        if ( ($this->_bEraseOutputIfExists == true) && file_exists($this->_PDFOutput) )  {
            $arResult['verbose'][] = 'Will remove existing output file : ' . $this->_PDFOutput . '.';
            unlink($this->_PDFOutput);
            $arResult['status'] = true;
        }

        //echo "will load : SetaPDF_Core_Document " . $this->_PDFRecto . PHP_EOL;
        $objPDFRecto = SetaPDF_Core_Document::loadByFilename($this->_PDFRecto);
        //Get pages on recto
        $pagesRecto = $objPDFRecto->getCatalog()->getPages();
        //Count pages on recto
        $pageRectoCount = $pagesRecto->count();

        if ($this->_PDFVersoNbPageToConsider == 0 )
        {
            $this->_PDFVersoNbPageToConsider = $pageRectoCount;
        }

        //Verify number of pages to consider on verso is not superior to num pages on recto
        if ((int)$this->_PDFVersoNbPageToConsider >(int)$pageRectoCount ) {
            $this->_PDFVersoNbPageToConsider = $pageRectoCount;
        }
        $objPDFVerso = SetaPDF_Core_Document::loadByFilename($this->_PDFVerso);


        //Prepare output document (Writer, CoreDoc)
        $oPDFWriter = new \SetaPDF_Core_Writer_File( $this->_PDFOutput );
        $oPDFOutput = new SetaPDF_Core_Document( );
        $oPDFOutput->setWriter( $oPDFWriter );

        $pagesPDFOutputToAppend = $oPDFOutput->getCatalog()->getPages();

        $pagesVerso = $objPDFVerso->getCatalog()->getPages();
        $arResult['verbose'][]= "Number of pages on recto document   : " . $pageRectoCount;
        $arResult['verbose'][]= "Number of pages to append from verso : " . $this->_PDFVersoNbPageToConsider;
        $pagesRectoCount = $pagesVerso->count();

        $v = $pageRectoCount;
        for ($i = 1; $i <= $pageRectoCount; $i++)
        {
            $arResult['verbose'][] = "-> page recto number : " . $i;
            $pageToAppend = $pagesRecto->getPage($i);
            $pageToAppend->flattenInheritedAttributes();
            $pagesPDFOutputToAppend->append($pageToAppend);
            $pageToAppend = null;

            if ($i <= $this->_PDFVersoNbPageToConsider)
            {
                $arResult['verbose'][] = "-> page verso : " . $v;
                $pageToAppend = $pagesVerso->getPage( $v );
                $pageToAppend->flattenInheritedAttributes();
                $pagesPDFOutputToAppend->append( $pageToAppend );
                $v--;
                $pageToAppend = null;
            }
        }

        //Save output document
        $oPDFOutput->save()->finish();
        if (file_exists($this->_PDFOutput)) {
            $arResult['verbose'][] = "File " . $this->_PDFOutput . ' created.';
            $arResult['status'] = true;
        } else {
            $arResult['errormsg'] = "File " . $this->_PDFOutput . ' not created.';
            $arResult['status'] = false;
        }
        //var_dump($arResult);
        return ( $arResult );
    }

}

<?php
/**
 * Created by PhpStorm.
 * User: enola
 * Date: 26/03/2019
 * Time: 18:08
 */

require (__DIR__.'/vendor/autoload.php');

use PhPeteur\Fusion2PDFs\RectoVerso2PDFsIn1Cmd;
use Symfony\Component\Console\Application;


$application = new Application("invoke our tool");

$application->add( new RectoVerso2PDFsIn1Cmd( ) );

$application->run();


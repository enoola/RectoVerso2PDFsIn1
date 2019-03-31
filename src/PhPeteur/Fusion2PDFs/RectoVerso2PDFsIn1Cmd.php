<?php

namespace PhPeteur\Fusion2PDFs;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class RectoVerso2PDFsIn1Cmd extends Command
{
    public function __construct( )
    {
        parent::__construct();
    }

    protected function configure()
    {

        $this->setName('rectoverso2pdfsin1'); //smart recto verso converge maybe ?
        $this->setDescription("Fusion 2 PDFs in 1 My Scanner's document feeder doesn't support recto verso scanning...");
        //$this->addOption('pdfrecto', null,InputOption::VALUE_NONE,'pdf recto path.');
        $this->addArgument('pdfrecto', InputArgument::REQUIRED,'pdf recto path.');
        $this->addArgument('pdfverso', InputArgument::REQUIRED,'pdf verso path.');
        $this->addArgument('pdfoutput', InputArgument::REQUIRED,'output PDF file name.');
        $this->addArgument('numpageverso', InputArgument::OPTIONAL,'number of pages on verso to take and add.');
        $this->addOption('forcerewriteoutput', null,InputOption::VALUE_NONE,'rewrite output file if exists, 0 by default.');
    }

    
    function go(InputInterface $input, OutputInterface $output)
    {
        $bRewriteOutputIfExists = $input->getOption('forcerewriteoutput');


        $oRVPDFs = new RectoVerso2PDFsIn1($input->getArgument('pdfrecto'),
            $input->getArgument('pdfverso'),
            $input->getArgument('pdfoutput'),
            $input->getArgument('numpageverso'),
            $input->getOption('forcerewriteoutput') );

        $arResult = $oRVPDFs->run();
        if ($arResult['status'] == false)
        {
            $output->writeln('<red>' . $arResult['errormsg'] . '</red>');
            return ( false );
        }

        if ($output->isVerbose())
            foreach($arResult['verbose'] as $line)
                $output->writeln('<green>' . $line . '</green>');

        return ( true );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $colors = ['black', 'red', 'green', 'yellow', 'blue', 'magenta', 'cyan', 'white'];
        foreach ($colors as $color) {
            $style = new OutputFormatterStyle($color);
            $output->getFormatter()->setStyle($color, $style);
        }

        try {
            $this->go($input, $output);
            //$ret = $this->myRun($input, $output);
            //$output->writeln('run RectoVerso2PDFsIn1');

            /*if ($output->isVerbose()) {
                $output->writeln("Verbose invoked...");
                var_dump($ret);
            }*/

        } catch (QueryException $e) {
            //$output->write();
            var_dump($e);
        }

    }
}

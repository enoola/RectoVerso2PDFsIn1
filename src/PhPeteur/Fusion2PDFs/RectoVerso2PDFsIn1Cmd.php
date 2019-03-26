<?php

namespace PhPeteur\Fusion2PDFs;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
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
        $this->_PDFsInOne = null;

        $this->setName('rectoverso2pdfsin1'); //smart recto verso converge maybe ?
        $this->setDescription("Fusion 2 PDFs in 1 My Scanner's document feeder doesn't support recto verso scanning...");
        $this->addOption('pdfrecto', null,InputOption::VALUE_NONE,'pdf recto path.');
        $this->addOption('pdfverso', null,InputOption::VALUE_NONE,'pdf verso path.');
        $this->addOption('numpageverso', null,InputOption::VALUE_NONE,'number of pages on verso to take and add.');

    }

    protected function doRun(InputInterface $input, OutputInterface $output) : array
    {
        $output->writeln('<red>Do Run involved</red>');

        //$this->_PDFsInOne = new RectoVerso2PDFsIn1('');
        //$arInterestingParams = [];

        return (array());
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $colors = ['black', 'red', 'green', 'yellow', 'blue', 'magenta', 'cyan', 'white'];
        foreach ($colors as $color) {
            $style = new OutputFormatterStyle($color);
            $output->getFormatter()->setStyle($color, $style);
        }

        try {
            //$ret = $this->doRun($input, $output);
            $output->writeln('run RectoVerso2PDFsIn1');

            if ($output->isVerbose()) {
                $output->writeln("Verbose invoked...");
                var_dump($ret);
            }

        } catch (QueryException $e) {
            $output->write(json_encode($e->getResponse(), JSON_PRETTY_PRINT));
        }

    }
}

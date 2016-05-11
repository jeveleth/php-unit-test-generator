<?php namespace Acme;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

// Read in file,
    // Grep for functions in class file
    // Spit out "test$functionName"
    // Create new file in tests/ dir with current file's name plus Test
    // Write to new file with test functions
class TestGenerator extends Command
{
    /**
     * [configure description]
     * @return [type] [description]
     */
    protected function configure()
    {
        $this->setName('generate-test')
             ->setDescription('Make a test')
             ->addArgument(
                'testFilePath',
                InputArgument::REQUIRED,
                'What class are you testing?'
             )
             ->addOption(
                'yell',
                null,
                InputOption::VALUE_NONE,
                'If set, the task will yell in uppercase letters'
        );
    }

    /**
     * [execute description]
     * @param  InputInterface  $input  [description]
     * @param  OutputInterface $output [description]
     * @return [type]                  [description]
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filePath = $input->getArgument('testFilePath');
        $functions = $this->parseFile($filePath);
        $finalTestFunctions = $this->returnTestFunctions($functions);
        $this->writeFunctionsToFile($finalTestFunctions);
    }

    /**
     * [parseFile description]
     * @param  [type] $filePath [description]
     * @return [type]           [description]
     */
    protected function parseFile($filePath)
    {
        if (file_exists($filePath)) {
            $fileArray = file($filePath, FILE_IGNORE_NEW_LINES);
            $pattern = '/function/';
            $functions = array();
            foreach ($fileArray as $key => $value) {
                if (preg_match($pattern, $value)) {
                    $functions[] = $value;
                }
            }
            return $functions;
        }
    }
    /**
     * [returnTestFunctions description]
     * @param  [type] $functions [description]
     * @return [type]            [description]
     */
    protected function returnTestFunctions($functions)
    {
        $newFunctions = array();
        foreach ($functions as $key => $value) {
            $newFunctions[] = stristr($value, 'function');
        }
        $finalFunctions = array();
        foreach ($newFunctions as $key => $value) {
            $finalFunctions[] = preg_replace('/function /', '', $value);
        }

        $finalTestFunctions = array();
        foreach ($finalFunctions as $key => $value) {
            $rawFunction = preg_replace('/\(+.*\)+/i', '', $value);
            $upcaseFunction = ucfirst($rawFunction);
            $finalTestFunctions[]= "test$upcaseFunction()\n{\n}";
        }
        return $finalTestFunctions;
    }

    protected function writeFunctionsToFile($finalTestFunctions)
    {
        # code...
    }
}
<?php namespace Acme;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Read in file,
 * Grep for functions in class file
 * Spit out "test$functionName"
 * Create new file in tests/ dir with current file's name plus Test
 * Write to new file with test functions
 */
class TestGenerator extends Command
{
    /**
     * [configure description]
     * @return [type] [description]
     */
    protected function myFakeFunction()
    {
        return true;
    }

    public function runMyFakeFunction()
    {
        return $this->myFakeFunction();
    }

    protected function configure()
    {
        $this->setName('generate-test')
             ->setDescription('Make a test')
             ->addArgument(
                'testFilePath',
                InputArgument::REQUIRED,
                'What class are you testing?'
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
        var_dump('hello');
        $filePath = $input->getArgument('testFilePath');
        $functions = $this->parseFile($filePath);
        $finalTestFunctions = $this->returnTestFunctions($functions);
        $this->writeFunctionsToFile($finalTestFunctions, $filePath);
        return 'love';
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
            $pattern = "/\s\bfunction\b\s/";
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
            $upcaseFunctionSuccess =  $upcaseFunction . "Success()";
            $upcaseFunctionFailure =  $upcaseFunction . "Failure()";
            $finalTestFunctions[]= "\n\tpublic function". " test$upcaseFunctionSuccess\n\t{\n\n\t}\n";
            $finalTestFunctions[]= "\n\tpublic function". " test$upcaseFunctionFailure\n\t{\n\n\t}\n";
        }
        return $finalTestFunctions;
    }

    /**
     * [writeFunctionsToFile description]
     * @param  [type] $finalTestFunctions [description]
     * @param  [type] $filePath           [description]
     * @return [type]                     [description]
     */
    protected function writeFunctionsToFile($finalTestFunctions, $filePath)
    {
        $filePath = rtrim($filePath, '.php');
        $pathMatches = preg_match('/([a-z0-9]+\/)+/i', $filePath, $match);
        $class =  ltrim($filePath, $match[0]);
        $filePath = "{$filePath}Test.php";

        $handle = fopen($filePath, 'w');
        fwrite($handle, "<?php\n\nclass {$class}Test extends \PHPUnit_Framework_TestCase\n{\n");
        foreach ($finalTestFunctions as $key => $value) {
            fwrite($handle, $value);
        }
        fwrite($handle, "\n}");
        fclose($handle);
    }
}
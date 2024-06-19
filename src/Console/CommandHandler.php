<?php

namespace Nightfall\Console;

class CommandHandler
{
    public function serve()
    {
        exec('php -S localhost:8000 -t ' . dirname(__DIR__, 2) . '/public/');
    }

    public function generateValidator()
    {
        fputs(
            STDOUT,
            "Input the name of validator(for example StorePostRequestValidator)"
                . PHP_EOL
        );
        $input = fgets(STDIN);
        $validatorName = substr($input, 0, strlen($input) - 1);
        $generatedCode = "<?php " . PHP_EOL
            . PHP_EOL
            . "namespace App\Validator;" . PHP_EOL
            . PHP_EOL
            . "use Nightfall\Validator\AbstractValidatorRequest;" . PHP_EOL
            . PHP_EOL
            . "class $validatorName extends AbstractValidatorRequest" . PHP_EOL
            . "{"
            . PHP_EOL
            . "\t" . "protected function rules(): array" . PHP_EOL
            . "\t" . "{" . PHP_EOL
            . "\t" . "}" . PHP_EOL
            . PHP_EOL
            . "\t" . "protected function messages(): array" . PHP_EOL
            . "\t" . "{" . PHP_EOL
            . "\t" . "}" . PHP_EOL
            . "}"
        ;

        if (!is_dir(dirname(__DIR__, 2) . "/app/Validator/"))
        {
            mkdir(dirname(__DIR__, 2) . "/app/Validator/");
        }

        $fp = fopen(dirname(__DIR__, 2) . "/app/Validator/" . "$validatorName.php", "w");
        fwrite($fp, $generatedCode);
        fclose($fp);

        echo 'Validator created succefully' . PHP_EOL;
    }

    public function generateController()
    {
        fputs(
            STDOUT,
            "Input the name of controller(for example PostController)"
                . PHP_EOL
        );
        $input = fgets(STDIN);
        $controllerName = substr($input, 0, strlen($input) - 1);
        $generatedCode = "<?php " . PHP_EOL
            . PHP_EOL
            . "namespace App\Controller;" . PHP_EOL
            . PHP_EOL
            . "use Nightfall\Http\Controller\BaseController;" . PHP_EOL
            . PHP_EOL
            . "class $controllerName extends BaseController" . PHP_EOL
            . "{"
            . PHP_EOL
            . PHP_EOL
            . PHP_EOL
            . "}"
        ;

        if (!is_dir(dirname(__DIR__, 2) . "/app/Controller/"))
        {
            mkdir(dirname(__DIR__, 2) . "/app/Controller/");
        }

        $fp = fopen(dirname(__DIR__, 2) . "/app/Controller/" . "$controllerName.php", "w");
        fwrite($fp, $generatedCode);
        fclose($fp);

        echo 'Controller created succefully' . PHP_EOL;
    }
}
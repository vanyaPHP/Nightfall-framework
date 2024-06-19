<?php

namespace Nightfall\Validator;

use Nightfall\Http\Request\Request;
use Nightfall\ServiceContainer\ServiceContainer;

abstract class AbstractValidatorRequest
{
    public function __construct(
        private ServiceContainer $serviceContainer
    ) {}

    abstract protected function rules(): array;
    abstract protected function messages(): array;
    
    public function validate(): array
    {
        $definedErrorMessages = static::messages();
        $definedRules = static::rules();
        $errors = [];
        $body = $this->serviceContainer->get(Request::class)->getBody();

        foreach($definedRules as $fieldName => $fieldRules)
        {
            $fieldValue = $body[$fieldName] ?? null;
            if (!is_array($fieldRules))
            {
                $fieldRules = [$fieldRules];
            }

            foreach($fieldRules as $fieldRule)
            {
                if (Rule::handleRule($fieldValue, $fieldRule))
                {
                    $errors []= $definedErrorMessages[$fieldRule] 
                        ?? "Field $fieldName did not pass validation for rule $fieldRule";
                }
            }
        }

        return $errors;
    }
}
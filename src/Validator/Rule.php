<?php

namespace Nightfall\Validator;

class Rule
{
    private static array $validationOptions = [
        'required',
        'enum',
        'in',
        'min',
        'max',
        'equal',
        'less',
        'lessOrEqual',
        'greater',
        'greaterOrEqual',
    ];

    public static function handleRule(mixed $fieldValue, string $ruleDefinition)
    {
        $parts = explode(':', $ruleDefinition);
        if (!in_array($parts[0], self::$validationOptions))
        {
            throw new ValidatorException("Rule $ruleDefinition does not exist");
        }

        return self::${$parts[0]}($fieldValue, $parts);
    }

    public static function required(mixed $fieldValue, array $parts): bool
    {
        return $fieldValue == null;
    }  

    public static function enum(mixed $fieldValue, array $parts): bool
    {
        $className = $parts[1];
        $enumCases = $className::cases();
        $found = false;
        foreach($enumCases as $enumCase)
        {
            if ($enumCase->value == $fieldValue)
            {
                $found = true;
                break;
            }
        }

        return !$found;
    }

    public static function in(mixed $fieldValue, array $parts): bool
    {
        $arr = [];
        $strArray = $parts[1];
        eval("\$arr = $strArray;");
        $found = false;
        foreach($arr as $value)
        {
            if ($fieldValue == $value)
            {
                $found = true;
                break;
            }
        }

        return !$found;
    }

    public static function min(mixed $fieldValue, array $parts): bool
    {
        $minValue = $parts[1];

        return strlen($fieldValue) < $minValue;
    }

    public static function max(mixed $fieldValue, array $parts): bool
    {
        $maxValue = $parts[1];

        return strlen($fieldValue) > $maxValue;
    }

    public static function equal(mixed $fieldValue, array $parts): bool
    {
        $checkedValue = $parts[1];

        return !($fieldValue == $checkedValue);
    }

    public static function less(mixed $fieldValue, array $parts): bool
    {
        $checkedValue = $parts[1];

        return !($fieldValue < $checkedValue);
    }

    public static function lessOrEqual(mixed $fieldValue, array $parts): bool
    {
        $checkedValue = $parts[1];

        return !($fieldValue <= $checkedValue);
    }

    public static function greater(mixed $fieldValue, array $parts): bool
    {
        $checkedValue = $parts[1];

        return !($fieldValue > $checkedValue);
    }

    public static function greaterOrEqual(mixed $fieldValue, array $parts): bool
    {
        $checkedValue = $parts[1];

        return !($fieldValue >= $checkedValue);
    }
}
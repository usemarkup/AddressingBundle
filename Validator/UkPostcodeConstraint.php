<?php

namespace Markup\AddressingBundle\Validator;

use Symfony\Component\Validator\Constraints\Regex as RegexConstraint;

/**
* @Annotation
*/
class UkPostcodeConstraint extends RegexConstraint
{
    public $message = 'This is not a valid UK postcode.';
    public $pattern = '/^([A-PR-UWYZ]([0-9]{1,2}|([A-HK-Y][0-9]|[A-HK-Y][0-9]([0-9]|[ABEHMNPRV-Y]))|[0-9][A-HJKS-UW])\ [0-9][ABD-HJLNP-UW-Z]{2}|(GIR\ 0AA)|(SAN\ TA1)|(BFPO\ (C\/O\ )?[0-9]{1,4})|((ASCN|BBND|[BFS]IQQ|PCRN|STHL|TDCU|TKCA)\ 1ZZ))$/i';

    public function getRequiredOptions()
    {
        //override requirement of a pattern option
        return array();
    }

    public function validatedBy()
    {
        return 'regex_postal_code';
    }
}

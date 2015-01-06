<?php

namespace Markup\AddressingBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * A class-based validator for regions that checks whether the region names are correct for an address's country.
 */
class RegionConstraint extends Constraint
{
    public $usMessage;
    public $caMessage;

    public function validatedBy()
    {
        return 'addressing_region';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}

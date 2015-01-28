<?php

namespace Markup\AddressingBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Markup\Addressing\Geography;

class RegionValidator extends ConstraintValidator
{
    /**
     * @var bool
     */
    private $useStrictRegion;

    /**
     * @param $useStrictRegion
     */
    public function __construct($useStrictRegion = false)
    {
        $this->useStrictRegion = $useStrictRegion;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed      $value      The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     *
     * @api
     */
    public function validate($value, Constraint $constraint)
    {
        //check for accessor methods without dictating use of a specific interface
        if (!is_object($value) or !method_exists($value, 'getCountry') || !method_exists($value, 'getRegion')) {
            throw new \InvalidArgumentException(sprintf('%s should be used for validating address objects with getCountry() and getRegion() methods.', __CLASS__));
        }
        if (!$this->useStrictRegion) {
            return;
        }
        switch ($value->getCountry()) {
            case 'US':
                if (!$this->getGeography()->isUsStateAbbreviation($value->getRegion())) {
                    $this->context->addViolation((isset($constraint->usMessage)) ? $constraint->usMessage : 'addressing.region.us.invalid');
                }
                break;
            case 'CA':
                if (!$this->getGeography()->isCanadianProvinceAbbreviation($value->getRegion())) {
                    $this->context->addViolation((isset($constraint->caMessage)) ? $constraint->caMessage : 'addressing.region.ca.invalid');
                }
                break;
            default:
                break;
        }
    }

    private function getGeography()
    {
        return new Geography();
    }
}

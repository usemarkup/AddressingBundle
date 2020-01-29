<?php

namespace Markup\AddressingBundle\Tests\Validator;

use Markup\AddressingBundle\Validator\LocalizedPostalCodeValidatorClosureProvider;
use Markup\AddressingBundle\Validator\PostalCodeValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidatorInterface;

/**
* A test for a postal code validator that can perform localized postal code validation where available.
*/
class PostalCodeValidatorTest extends TestCase
{
    public function setUp()
    {
        $this->validatorProvider = $this->createMock(LocalizedPostalCodeValidatorClosureProvider::class);
        $this->validator = new PostalCodeValidator($this->validatorProvider);
    }

    public function testIsValidator()
    {
        $this->assertInstanceOf(ConstraintValidatorInterface::class, $this->validator);
    }

    public function testPassingNonObjectThrowsInvalidArgumentException()
    {
        $constraint = $this->createMock(Constraint::class);
        $value = 'POSTCODE';
        $this->expectException(\InvalidArgumentException::class);
        $this->validator->validate($value, $constraint);
    }
}

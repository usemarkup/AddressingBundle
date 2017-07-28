<?php

namespace Markup\AddressingBundle\Tests\Validator;

use Markup\AddressingBundle\Validator\PostalCodeConstraint;
use Symfony\Component\Validator\Constraint;

/**
* A test for a class-based validator for postal codes that applies validation on a per-country basis.
*/
class PostalCodeConstraintTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PostalCodeConstraint
     */
    private $constraint;

    public function setUp()
    {
        $this->constraint = new PostalCodeConstraint();
    }

    public function testIsConstraint()
    {
        $this->assertInstanceOf(Constraint::class, $this->constraint);
    }

    public function testIsDeclaredClassLevelConstraint()
    {
        $this->assertEquals(Constraint::CLASS_CONSTRAINT, $this->constraint->getTargets());
    }

    public function testValidatedByPostalCodeValidator()
    {
        $this->assertEquals('postal_code', $this->constraint->validatedBy());
    }
}

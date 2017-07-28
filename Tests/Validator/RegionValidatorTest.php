<?php

namespace Markup\AddressingBundle\Tests\Validator;

use Markup\AddressingBundle\Validator\RegionConstraint;
use Markup\AddressingBundle\Validator\RegionValidator;
use Mockery as m;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class RegionValidatorTest extends MockeryTestCase
{
    protected function setUp()
    {
        $this->useStrictRegions = true;
        $this->validator = new RegionValidator($this->useStrictRegions);
        $this->context = m::mock(ExecutionContextInterface::class);
        $this->validator->initialize($this->context);
    }

    public function testIsValidator()
    {
        $this->assertInstanceOf(ConstraintValidatorInterface::class, $this->validator);
    }

    public function testThrowInvalidArgumentExceptionWhenInvalid()
    {
        $invalid = 'not an address';
        $this->expectException(\InvalidArgumentException::class);
        $this->validator->validate($invalid, new RegionConstraint());
    }

    /**
     * @dataProvider cases
     */
    public function testValidationCases($country, $region, $expectedPass)
    {
        $address = new TestAddress();
        $address->setRegion($region);
        $address->setCountry($country);
        $expectation = $this->context->shouldReceive('addViolation');
        if ($expectedPass) {
            $expectation->never();
        } else {
            $expectation->once();
        }
        $this->validator->validate($address, new RegionConstraint());
    }

    public function cases()
    {
        return [
            ['FR', 'Île de France', true],
            ['US', 'NY', true],
            ['US', 'New York', false],
            ['CA', 'ON', true],
            ['US', 'Ontario', false],
        ];
    }

    public function testNonAbbreviationsPassWhenNotStrict()
    {
        $validator = new RegionValidator(false);
        $validator->initialize($this->context);
        $address = new TestAddress();
        $address->setRegion('California');
        $address->setCountry('US');
        $this->context
            ->shouldReceive('addViolation')
            ->never();
        $validator->validate($address, new RegionConstraint());
    }
}

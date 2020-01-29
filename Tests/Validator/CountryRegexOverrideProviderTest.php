<?php

namespace Markup\AddressingBundle\Tests\Validator;

use Markup\AddressingBundle\Validator\CountryRegexOverrideProvider;
use PHPUnit\Framework\TestCase;

class CountryRegexOverrideProviderTest extends TestCase
{
    protected function setUp()
    {
        $this->overrides = ['IT' => '/^\d{5}$/'];
        $this->provider = new CountryRegexOverrideProvider($this->overrides);
    }

    public function testGetKnownOverride()
    {
        $this->assertEquals('/^\d{5}$/', $this->provider->getOverrideFor('IT'));
    }

    public function testGetUnknownOverride()
    {
        $this->assertNull($this->provider->getOverrideFor('ES'));
    }
}

<?php

namespace Markup\AddressingBundle\Validator;

/**
 * An object that can provide regex overrides for individual countries.
 */
class CountryRegexOverrideProvider
{
    /**
     * A set of override regexes keyed by country.
     *
     * @var array
     */
    private $overrideRegexes;

    /**
     * @param array $overrideRegexes
     */
    public function __construct(array $overrideRegexes = array())
    {
        $this->setOverrideRegexes($overrideRegexes);
    }

    /**
     * @param string $country
     * @return string|null
     */
    public function getOverrideFor($country)
    {
        if (!isset($this->overrideRegexes[$country])) {
            return null;
        }

        return $this->overrideRegexes[$country];
    }

    /**
     * @param array $overrideRegexes
     * @return self
     */
    public function setOverrideRegexes(array $overrideRegexes = array())
    {
        $this->overrideRegexes = $overrideRegexes;

        return $this;
    }
}

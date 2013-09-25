<?php

namespace Markup\AddressingBundle\Canonicalizer;

/**
 * An interface for an object that can canonicalize inputs.
 **/
interface CanonicalizerInterface
{
    /**
     * @param mixed $input
     *
     * @return mixed
     **/
    public function canonicalize($input);
}

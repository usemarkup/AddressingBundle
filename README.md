# MarkupAddressingBundle

## About

This Symfony bundle provides integration with the markup/addressing package, which is able to format addresses according to the rules set out in [Frank's Compulsive Guide To Postal Addresses](http://www.columbia.edu/~fdc/postal/).

## Installation

Add MarkupAddressingBundle to your composer.json:

```js
{
    "require": {
        "markup/addressing-bundle": "@dev"
    }
}
```

Add MarkupAddressingBundle to your AppKernel.php:

```php
    public function registerBundles()
    {
        $bundles = [
            ...
            new Markup\AddressingBundle\MarkupAddressingBundle(),
        ];
        ...
    }
```

Finally, install the bundle using Composer:

```bash
$ php composer.phar update markup/addressing-bundle
```

## Usage

Simple usage example:

```php
    $renderer = $this->get('markup_addressing.address.renderer');
    $address = new MyAddressAdapter($myAddress); //MyAddressAdapter here wraps a different address definition and makes it implement Markup\Addressing\AddressInterface
    echo $renderer->render($address, ['format' => 'plaintext']);
```

This would echo out an address, formatted correctly according to the country, using plaintext.

## License

Released under the MIT License. See LICENSE.

[![Build Status](https://api.travis-ci.org/usemarkup/AddressingBundle.png?branch=master)](http://travis-ci.org/usemarkup/AddressingBundle)

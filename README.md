PhlexibleGoogleMapsBundle
=========================

The PhlexibleGoogleMapsBundle adds support for country-based content support in phlexible.

Installation
------------

1. Download PhlexibleGoogleMapsBundle using composer
2. Enable the Bundle
3. Clear the symfony cache

### Step 1: Download PhlexibleGoogleMapsBundle using composer

Add PhlexibleGoogleMapsBundle by running the command:

``` bash
$ php composer.phar require phlexible/google-maps-bundle "~1.0.0"
```

Composer will install the bundle to your project's `vendor/phlexible` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Phlexible\Bundle\GoogleMapsBundle\PhlexibleGoogleMapsBundle(),
    );
}
```

### Step 3: Clear the symfony cache

If you access your phlexible application with environment prod, clear the cache:

``` bash
$ php app/console cache:clear --env=prod
```

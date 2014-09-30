<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\GoogleMapsBundle\AssetProvider;

use Assetic\Asset\AssetCollection;
use Assetic\Asset\FileAsset;
use Phlexible\Bundle\GuiBundle\AssetProvider\AssetProviderInterface;
use Symfony\Component\HttpKernel\Config\FileLocator;

/**
 * Google maps asset provider
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class GoogleMapsAssetProvider implements AssetProviderInterface
{
    /**
     * @var FileLocator
     */
    private $locator;

    /**
     * @param FileLocator $locator
     */
    public function __construct(FileLocator $locator)
    {
        $this->locator = $locator;
    }

    /**
     * {@inheritDoc}
     */
    public function getUxScriptsCollection()
    {
        $collection = new AssetCollection(array(
            new FileAsset($this->locator->locate('@PhlexibleGoogleMapsBundle/Resources/scripts/ux/Ext.ux.form.AddressField.js')),
        ));

        return $collection;
    }

    /**
     * {@inheritDoc}
     */
    public function getUxCssCollection()
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function getScriptsCollection()
    {
        $collection = new AssetCollection(array(
            new FileAsset($this->locator->locate('@PhlexibleGoogleMapsBundle/Resources/scripts/Definitions.js')),

            new FileAsset($this->locator->locate('@PhlexibleGoogleMapsBundle/Resources/scripts/MapWindow.js')),
            new FileAsset($this->locator->locate('@PhlexibleGoogleMapsBundle/Resources/scripts/AddressSearch.js')),

            new FileAsset($this->locator->locate('@PhlexibleGoogleMapsBundle/Resources/scripts/field/AddressField.js')),
        ));

        return $collection;
    }

    /**
     * {@inheritDoc}
     */
    public function getCssCollection()
    {
        return null;
    }
}

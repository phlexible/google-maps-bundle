<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\GoogleMapsBundle\AssetProvider;

use Phlexible\Bundle\GuiBundle\AssetProvider\AssetProviderInterface;

/**
 * Google maps asset provider
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class GoogleMapsAssetProvider implements AssetProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function getUxScriptsCollection()
    {
        return array(
            '@PhlexibleGoogleMapsBundle/Resources/scripts/ux/Ext.ux.form.AddressField.js',
        );
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
        return array(
            '@PhlexibleGoogleMapsBundle/Resources/scripts/Definitions.js',

            '@PhlexibleGoogleMapsBundle/Resources/scripts/MapWindow.js',
            '@PhlexibleGoogleMapsBundle/Resources/scripts/AddressSearch.js',

            '@PhlexibleGoogleMapsBundle/Resources/scripts/field/AddressField.js',
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getCssCollection()
    {
        return null;
    }
}

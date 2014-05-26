<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\GoogleMapsComponent\Field;

use Phlexible\ElementtypesComponent\Field\TextField;

/**
 * Address field
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class AddressField extends TextField
{
    public $icon = 'p-googlemaps-component-icon';

    /**
     * Transform item values
     *
     * @param array $item
     * @param array $media
     * @param array $options
     *
     * @return array
     */
    protected function _transform(array $item, array $media, array $options)
    {
        if (!empty($item['data_content'])) {
            try {
                $item['rawContent'] = json_decode($item['data_content']);
            } catch (\Exception $e) {
                $item['rawContent'] = '';
            }

        }

        return $item;
    }
}
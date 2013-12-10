<?php
/**
 * MAKEweb
 *
 * PHP Version 5
 *
 * @category    MAKEweb
 * @package     Makeweb_Fields
 * @copyright   2007 brainbits GmbH (http://www.brainbits.net)
 * @version     SVN: $Id: Exception.php 2943 2007-04-18 09:00:40Z swentz $
 */

/**
 * Address Field
 *
 * @category    MAKEweb
 * @package     Makeweb_Fields
 * @author      Stephan Wentz <sw@brainbits.net>
 * @copyright   2007 brainbits GmbH (http://www.brainbits.net)
 */
class Makeweb_Googlemaps_Field_Address extends Makeweb_Fields_Field_Textfield
{
    const TYPE = 'address';

    public $options = false;
    public $icon = 'm-googlemaps-component-icon';

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
        if (!empty($item['data_content']))
        {
            try
            {
                $item['rawContent'] = Zend_Json::decode($item['data_content']);
            }
            catch (Exception $e)
            {
                MWF_Log::exception($e);
                $item['rawContent'] = '';
            }

        }

        return $item;
    }
}
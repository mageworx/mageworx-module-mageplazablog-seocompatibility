<?php
/**
 * Copyright © MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\MageplazaBlogSeoCompatibility\Model\DataProvider;

/**
 * Data Provider for Mageplaza Blog Home Page
 */
class Home extends \MageWorx\MageplazaBlogSeoCompatibility\Model\DataProvider
{
    /**
     * @return array
     */
    public function getData()
    {
        $code  = 'mageplaza_blog_root';
        $title = __('Mageplaza Blog Home');


        $generators[$code]               = [];
        $generators[$code]['title']      = $title;
        $generators[$code]['changefreq'] = $this->helper->getFrequency();
        $generators[$code]['priority']   = $this->helper->getPriority();
        $this->helper->setStoreId($this->storeId);

        $generators[$code]['items'][] = [
            'url_key'      => $this->getUrlKey(null, null, $this->storeId),
            'date_changed' => date_format(date_create(), 'Y-m-d')
        ];

        return $generators;
    }
}

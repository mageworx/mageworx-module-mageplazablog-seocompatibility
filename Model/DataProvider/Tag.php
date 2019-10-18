<?php
/**
 * Copyright © MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\MageplazaBlogSeoCompatibility\Model\DataProvider;

use Mageplaza\Blog\Helper\Data as MageplazaHelper;

/**
 * Data Provider for Mageplaza Blog Posts
 */
class Tag extends \MageWorx\MageplazaBlogSeoCompatibility\Model\DataProvider
{
    /**
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getData()
    {
        $code       = 'mageplaza_blog_tag';
        $title      = __('Mageplaza Blog Tags');
        $collection = $this->mageplazaHelper->getObjectList(MageplazaHelper::TYPE_TAG, $this->storeId);
        if (!empty($this->excludeMetaRobots)) {
            $collection->addFieldToFilter('meta_robots', ['nin' => $this->excludeMetaRobots]);
        }

        return $this->getItemsForSitemap($collection, $code, $title, MageplazaHelper::TYPE_TAG);
    }
}

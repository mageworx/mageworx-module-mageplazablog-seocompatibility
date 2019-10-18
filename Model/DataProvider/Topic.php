<?php
/**
 * Copyright © MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\MageplazaBlogSeoCompatibility\Model\DataProvider;

use Mageplaza\Blog\Helper\Data as MageplazaHelper;

/**
 * Data Provider for Mageplaza Blog Topic Pages
 */
class Topic extends \MageWorx\MageplazaBlogSeoCompatibility\Model\DataProvider
{
    /**
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getData()
    {
        $code       = 'mageplaza_blog_topic';
        $title      = __('Mageplaza Blog Topics');
        $collection = $this->mageplazaHelper->getObjectList(MageplazaHelper::TYPE_TOPIC, $this->storeId);
        if (!empty($this->excludeMetaRobots)) {
            $collection->addFieldToFilter('meta_robots', ['nin' => $this->excludeMetaRobots]);
        }

        return $this->getItemsForSitemap($collection, $code, $title, MageplazaHelper::TYPE_TOPIC);
    }
}

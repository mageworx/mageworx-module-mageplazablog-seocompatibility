<?php
/**
 * Copyright © MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\MageplazaBlogSeoCompatibility\Model;

use Mageplaza\Blog\Helper\Data as MageplazaHelper;
use MageWorx\MageplazaBlogSeoCompatibility\Helper\Data;

/**
 * Class Abstract DataProvider
 */
abstract class DataProvider implements DataProviderInterface
{
    /**
     * @var MageplazaHelper
     */
    protected $mageplazaHelper;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var int
     */
    protected $storeId;

    /**
     * @var array
     */
    protected $excludeMetaRobots;

    /**
     * DataProvider constructor.
     *
     * @param MageplazaHelper $mageplazaHelper
     * @param Data $helper
     * @param array $excludeMetaRobots
     * @param int $storeId
     */
    public function __construct(
        MageplazaHelper $mageplazaHelper,
        Data $helper,
        array $excludeMetaRobots = [],
        int $storeId = 0
    ) {
        $this->mageplazaHelper   = $mageplazaHelper;
        $this->helper            = $helper;
        $this->excludeMetaRobots = $excludeMetaRobots;
        $this->storeId           = $storeId;
    }

    /**
     * @return array
     */
    abstract public function getData();

    /**
     * @param $collection
     * @param string $code
     * @param string $title
     * @param string $type
     * @return array
     */
    protected function getItemsForSitemap($collection, $code, $title, $type)
    {
        $generators[$code]               = [];
        $generators[$code]['title']      = $title;
        $generators[$code]['changefreq'] = $this->helper->getFrequency();
        $generators[$code]['priority']   = $this->helper->getPriority();

        $this->helper->setStoreId($this->storeId);
        foreach ($collection as $item) {
            $generators[$code]['items'][] = [
                'url_key'      => $this->getUrlKey($item, $type, $this->storeId),
                'date_changed' => $this->getUpdatedDate($item)
            ];
        }

        return $generators;
    }

    /**
     * @param DataObject $item
     * @return string
     */
    protected function getUpdatedDate($item)
    {
        $date = $item->getUpdatedAt() ?: $item->getCreatedAt();

        if (!$date) {
            return '';
        }

        return date_format(date_create($date), 'Y-m-d');
    }

    /**
     * @param mixed $urlKey
     * @param mixed $type
     * @param mixed $store
     * @return string
     */
    protected function getUrlKey($urlKey = null, $type = null, $store = null)
    {
        if (is_object($urlKey)) {
            $urlKey = $urlKey->getUrlKey();
        }

        $urlKey = ($type ? $type . '/' : '') . $urlKey;
        $urlKey = $this->mageplazaHelper->getRoute($store) . '/' . $urlKey;
        $urlKey = explode('?', $urlKey);
        $urlKey = $urlKey[0];

        return rtrim($urlKey, '/') . $this->mageplazaHelper->getUrlSuffix($store);
    }
}

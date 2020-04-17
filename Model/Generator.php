<?php
/**
 * Copyright © MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\MageplazaBlogSeoCompatibility\Model;

use MageWorx\MageplazaBlogSeoCompatibility\Helper\Data;

/**
 * Class Abstract DataProvider
 */
class Generator
{
    /**
     * @var DataProviderFactory
     */
    protected $dataProviderFactory;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * Generator constructor.
     *
     * @param DataProviderFactory $dataProviderFactory
     * @param Data $helper
     * @param array $data
     */
    public function __construct(
        DataProviderFactory $dataProviderFactory,
        Data $helper,
        array $data = []
    ) {
        $this->dataProviderFactory = $dataProviderFactory;
        $this->helper              = $helper;
        $this->data                = $data;
    }

    /**
     * @param int $storeId
     * @param array $excludeMetaRobots
     * @return array
     */
    public function generate($storeId, $excludeMetaRobots)
    {
        $this->helper->setStoreId($storeId);

        if (!$this->helper->isBlogPagesEnabled()) {
            return [];
        }

        $generators = [];
        $arguments  = ['storeId' => $storeId, 'excludeMetaRobots' => $excludeMetaRobots];

        foreach ($this->data as $identifier) {
            if (!$this->isAddPages($identifier)) {
                continue;
            }

            $dataProvider = $this->dataProviderFactory->create($identifier, $arguments);
            $generators   = array_merge($generators, $dataProvider->getData());
        }

        return $generators;
    }

    /**
     * @param string $identifier
     * @return bool
     */
    public function isAddPages($identifier)
    {
        switch ($identifier) {
            case 'post':
                $result = $this->helper->isAddPosts();
                break;
            case 'category':
                $result = $this->helper->isAddCategories();
                break;
            case 'tag':
                $result = $this->helper->isAddTags();
                break;
            case 'topic':
                $result = $this->helper->isAddTopics();
                break;
            case 'home':
            default:
                $result = true;
                break;
        }

        return $result;
    }
}
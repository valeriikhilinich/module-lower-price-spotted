<?php

namespace ValeriiKhilinich\LowerPriceSpotted\Ui\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class CompetitorReference extends Column
{
    /**
     * @inheritDoc
     */
    public function prepareDataSource(array $dataSource): array
    {
        $dataSource = parent::prepareDataSource($dataSource);

        foreach ($dataSource['data']['items'] as &$requestData) {
            $requestData['competitor_reference'] = $requestData['reference_url']
                ?: $requestData['competitor_description'];
        }

        return $dataSource;
    }
}

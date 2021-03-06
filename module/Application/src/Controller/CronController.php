<?php

namespace Application\Controller;

use EbayCrawler\EbayCrawler;
use EbayCrawler\Model\Country;
use EbayCrawler\Model\EbayItemModel;
use EbayCrawler\Model\Item;
use EbayCrawler\Model\Keyword;
use EbayCrawler\Model\Table\CountriesTable;
use EbayCrawler\Model\Table\ItemsTable;
use EbayCrawler\Model\Table\KeywordsTable;
use Laminas\Mvc\Controller\AbstractActionController;

class CronController extends AbstractActionController
{
    private ItemsTable $itemsTable;
    private KeywordsTable $keywordsTable;
    private CountriesTable $countriesTable;

    private EbayCrawler $ebayCrawler;

    public function __construct(
        ItemsTable $itemsTable,
        KeywordsTable $keywordsTable,
        CountriesTable $countriesTable,
        EbayCrawler $ebayCrawler
    ) {
        $this->itemsTable = $itemsTable;
        $this->keywordsTable = $keywordsTable;
        $this->countriesTable = $countriesTable;

        $this->ebayCrawler = $ebayCrawler;

        $this->ebayCrawler->setParams([
            EbayCrawler::PARAM_SORT => EbayCrawler::SORT_NEWLY_LISTED,
            EbayCrawler::PARAM_ITEMS_PER_PAGE => EbayCrawler::ITEMS_PER_PAGE_200
        ]);
    }

    public function getItemsAction()
    {
        $countries = $this->countriesTable->fetchAll();
        $countries->buffer();

        $keywords = $this->keywordsTable->fetchAll();
        $keywords->buffer();

        $totalItems = 0;

        /** @var Country $country */
        foreach ($countries as $country) {
            $this->ebayCrawler->setCountry($country->getAbbreviation());
            $this->ebayCrawler->addParam(
                EbayCrawler::PARAM_DELIVERY_LOCATION,
                $country->getAbbreviation() === EbayCrawler::COUNTRY_UK ?
                    EbayCrawler::DELIVERY_LOCATION_UK :
                    EbayCrawler::DELIVERY_LOCATION_DE
            );

            /** @var Keyword $keyword */
            foreach ($keywords as $keyword) {
                $this->ebayCrawler->addParam(EbayCrawler::PARAM_KEYWORD, $keyword->getName());

                $latestOrder = $this->itemsTable->getLatestOrder($country->getId(), $keyword->getId());

                $items = array_reverse($this->ebayCrawler->getItems());

                /** @var EbayItemModel $item */
                foreach ($items as $item) {

                    if (!$this->itemsTable->getByExternalId($item->getId())) {
                        $latestOrder++;

                        $model = new Item();
                        $model->setExternalId($item->getId());
                        $model->setCountryId($country->getId());
                        $model->setKeywordId($keyword->getId());
                        $model->setTitle($item->getTitle());
                        $model->setLink($item->getLink());
                        $model->setShipping($item->getShipping());
                        $model->setImage($item->getImage());
                        $model->setPrice($item->getPrice());
                        $model->setOrder($latestOrder);

                        $this->itemsTable->save($model);
                        $totalItems++;
                    }
                }
            }
        }

        return 'Items added: ' . $totalItems;
    }
}

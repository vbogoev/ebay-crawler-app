<?php

namespace Application\Controller;

use EbayCrawler\Model\Table\CountriesTable;
use EbayCrawler\Model\Table\ItemsTable;
use EbayCrawler\Model\Table\KeywordsTable;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    private ItemsTable $itemsTable;
    private KeywordsTable $keywordsTable;
    private CountriesTable $countriesTable;

    public function __construct(ItemsTable $itemsTable, KeywordsTable $keywordsTable, CountriesTable $countriesTable)
    {
        $this->itemsTable = $itemsTable;
        $this->keywordsTable = $keywordsTable;
        $this->countriesTable = $countriesTable;
    }

    public function indexAction()
    {
        $keywords = $this->keywordsTable->fetchAll();
        $keywords->buffer();

        $countries = $this->countriesTable->fetchAll();
        $countries->buffer();

        return new ViewModel([
            'keywords' => $keywords,
            'countries' => $countries,
            'countryIdFilter' => $this->getRequest()->getQuery('countryId'),
            'items' => $this->itemsTable->fetchAllGroupedByKeyword([
                'seen' => false,
                'countryId' => $this->getRequest()->getQuery('countryId')
            ])
        ]);
    }

    public function markAsSeenAction() {
        $viewModel = new JsonModel([
            'status' => false
        ]);
        $viewModel->setTerminal(true);

        if ($this->getRequest()->isXmlHttpRequest()) {
            $result = $this->itemsTable->markAsSeen([
                'keywordId' => $this->getRequest()->getPost('keywordId'),
                'countryId' => $this->getRequest()->getPost('countryId')
            ]);
            $viewModel->setVariable('status', (bool) $result);
        }

        return $viewModel;
    }
}

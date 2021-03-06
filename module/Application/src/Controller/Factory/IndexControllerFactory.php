<?php

namespace Application\Controller\Factory;

use Application\Controller\IndexController;
use EbayCrawler\Model\Table\CountriesTable;
use EbayCrawler\Model\Table\ItemsTable;
use EbayCrawler\Model\Table\KeywordsTable;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $itemsTable = $container->get(ItemsTable::class);
        $keywordsTable = $container->get(KeywordsTable::class);
        $countriesTable = $container->get(CountriesTable::class);

        return new IndexController($itemsTable, $keywordsTable, $countriesTable);
    }
}

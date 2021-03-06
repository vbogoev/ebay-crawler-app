<?php

namespace Application\Controller\Factory;

use Application\Controller\CronController;
use EbayCrawler\EbayCrawler;
use EbayCrawler\Model\Table\CountriesTable;
use EbayCrawler\Model\Table\ItemsTable;
use EbayCrawler\Model\Table\KeywordsTable;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class CronControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $itemsTable = $container->get(ItemsTable::class);
        $keywordsTable = $container->get(KeywordsTable::class);
        $countriesTable = $container->get(CountriesTable::class);

        $ebayCrawler = $container->get(EbayCrawler::class);

        return new CronController($itemsTable, $keywordsTable, $countriesTable, $ebayCrawler);
    }
}

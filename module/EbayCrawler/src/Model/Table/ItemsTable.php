<?php

namespace EbayCrawler\Model\Table;

use Laminas\Db\Sql\Predicate\Predicate;
use Laminas\Db\TableGateway\TableGateway;
use EbayCrawler\Model\Item;

class ItemsTable
{
    public const TABLE_NAME = 'items';

    private TableGateway $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function save(Item $item)
    {
        $data = [
            'country_id' => $item->getCountryId(),
            'keyword_id' => $item->getKeywordId(),
            'external_id' => $item->getExternalId(),
            'title' => $item->getTitle(),
            'link' => $item->getLink(),
            'image' => $item->getImage(),
            'price' => $item->getPrice(),
            'shipping' => $item->getShipping(),
            'order' => $item->getOrder(),
        ];

        $id = $item->getId();

        if ($id == 0) {
            $data['date_added'] = (new \DateTime())->format('Y-m-d H:i:s');
            $result = $this->tableGateway->insert($data);
        } else {
            $item = $this->getById($id);
            $result = $this->tableGateway->update($data, ['id' => $id]);
        }

        return $result;
    }

    public function getById(int $id)
    {
        $select = $this->tableGateway
            ->getSql()
            ->select();

        $select->where([
            self::TABLE_NAME . '.id = ?' => $id
        ]);

        return $this->tableGateway->selectWith($select)->current();
    }

    public function getByExternalId(int $externalId)
    {
        $select = $this->tableGateway
            ->getSql()
            ->select();

        $select->where([
            self::TABLE_NAME . '.external_id = ?' => $externalId
        ]);

        return $this->tableGateway->selectWith($select)->current();
    }

    public function fetchAll(array $options = [])
    {
        $select = $this->tableGateway
            ->getSql()
            ->select()
            ->order('date_added DESC, order DESC');

        if(isset($options['seen'])) {
            $select->where->equalTo('seen', $options['seen']);
        }

        if(!empty($options['countryId'])) {
            $select->where->equalTo('country_id', $options['countryId']);
        }

        return $this->tableGateway->selectWith($select);
    }

    public function fetchAllGroupedByKeyword(array $options = []): array
    {
        $items = $this->fetchAll($options);

        $result = [];

        /** @var Item $item */
        foreach ($items as $item) {
            $result[$item->getKeywordId()][] = $item;
        }

        return $result;
    }

    public function getLatestOrder(int $countryId, int $keywordId): int
    {
        $select = $this->tableGateway
            ->getSql()
            ->select()
            ->columns([
                'order'
            ])
            ->where([
                'country_id' => $countryId,
                'keyword_id' => $keywordId
            ])
            ->order('order DESC')
            ->limit(1);

        $statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($select);

        $result = $statement->execute()->current();
        return $result['order'] ?? 0;
    }

    public function delete(int $id)
    {
        $item = $this->getById($id);
        if ($item) {
            $result = $this->tableGateway->delete(['id' => $id]);
            if ($result) {
                return true;
            }
        }
        return false;
    }

    public function markAsSeen(array $options = [])
    {
        $predicate = new Predicate();

        if(!empty($options['countryId'])) {
            $predicate->equalTo('country_id', $options['countryId']);
        }

        if(!empty($options['keywordId'])) {
            $predicate->equalTo('keyword_id', $options['keywordId']);
        }

        return $this->tableGateway->update(['seen' => 1], $predicate);
    }
}

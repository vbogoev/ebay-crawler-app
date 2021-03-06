<?php

namespace EbayCrawler\Model\Table;

use EbayCrawler\Model\Country;
use Laminas\Db\TableGateway\TableGateway;

class CountriesTable
{
    public const TABLE_NAME = 'countries';

    private TableGateway $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function save(Country $country)
    {
        $data = [
            'abbreviation' => $country->getAbbreviation(),
            'name' => $country->getName(),
        ];

        $id = $country->getId();

        if ($id == 0) {
            $data['date_added'] = (new \DateTime())->format('Y-m-d H:i:s');
            $result = $this->tableGateway->insert($data);
        } else {
            $item = $this->getById($id);
            $result = $this->tableGateway->update($data, ['id' => $id]);
        }

        return $result;
    }

    public function getById($id)
    {
        $id = (int) $id;
        $select = $this->tableGateway
            ->getSql()
            ->select();

        $select->where([
            self::TABLE_NAME . '.id = ?' => $id
        ]);

        $row = $this->tableGateway->selectWith($select)->current();

        return $row;
    }

    public function fetchAll(array $options = [])
    {
        $select = $this->tableGateway
            ->getSql()
            ->select()
            ->order('date_added DESC');

        return $this->tableGateway->selectWith($select);
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

}

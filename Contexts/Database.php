<?php

namespace Contexts;

use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;

class Database extends BaseContext
{
    const DB_FILE = 'dss_acceptance.db';
    const TABLE_NAME = 'test';

    /** @var bool */
    private $rowEdited = false;

    /** @var \PDO */
    private $connection;

    /** @var array */
    private $queryResult;

    /**
     * @BeforeScenario
     *
     * @param BeforeScenarioScope $scope
     */
    public function beforeScenario(BeforeScenarioScope $scope)
    {
        parent::beforeScenario($scope);
        $this->connection = new \PDO('sqlite:' . self::DB_FILE);
        $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @Given record with ID :id exists
     *
     * @param string $id
     * @throws BehatException
     */
    public function checkRecordExists($id)
    {
        $id = intval($id);
        $query = 'SELECT * FROM ' . self::TABLE_NAME . ' WHERE id = :id';
        $statement = $this->connection->prepare($query);
        $statement->execute([':id' => $id]);
        if (!$statement->fetch()) {
            throw new BehatException("Row with ID $id does not exist");
        }
    }

    /**
     * @When all data is retrieved
     */
    public function getAllData()
    {
        $query = 'SELECT * FROM ' . self::TABLE_NAME;
        foreach ($this->connection->query($query) as $row) {
            $this->queryResult[] = $row;
        }
    }

    /**
     * @When data is retrieved for ID :id
     *
     * @param string $id
     */
    public function getDataById($id)
    {
        $id = intval($id);
        $query = 'SELECT * FROM ' . self::TABLE_NAME . ' WHERE id = :id';
        $statement = $this->connection->prepare($query);
        $statement->execute([':id' => $id]);
        $this->queryResult = $statement->fetch();
    }

    /**
     * @When record with ID :id is updated to value :value
     *
     * @param string $id
     * @param string $value
     */
    public function updateRecord($id, $value)
    {
        $query = 'UPDATE ' . self::TABLE_NAME . ' SET value = :value WHERE id = :id';
        $statement = $this->connection->prepare($query);
        $statement->execute([':value' => $value, ':id' => $id]);
        $this->rowEdited = true;
    }

    /**
     * @Then contents are displayed:
     *
     * @param TableNode $table
     */
    public function testTableResult(TableNode $table)
    {
        $result = $table->getHash();
        foreach ($result as $rowNumber => $row) {
            Assert::assertEquals($row['id'], $this->queryResult[$rowNumber]['id']);
            Assert::assertEquals($row['value'], $this->queryResult[$rowNumber]['value']);
        }
    }

    /**
     * @Then value equals :value
     *
     * @param string $value
     */
    public function testResultForValue($value)
    {
        Assert::assertEquals($value, $this->queryResult['value']);
    }

    /**
     * @AfterScenario
     *
     * @param AfterScenarioScope $scope
     */
    public function afterScenario(AfterScenarioScope $scope)
    {
        if ($this->rowEdited) {
            $query = 'UPDATE ' . self::TABLE_NAME . ' SET value = :value WHERE id = :id';
            $statement = $this->connection->prepare($query);
            $statement->execute([':value' => 'value 2', ':id' => 2]);
        }
        unset($this->connection);
    }
}

<?php

require 'vendor/adodb/adodb-php/adodb.inc.php';

use PHPUnit\Framework\TestCase;

final class AdodbTest extends TestCase
{
    private $db;

    public function setUp(): void
    {
        $host       = $_ENV['DB_HOST'];
        $database   = $_ENV['DB_NAME'];
        $user       = $_ENV['DB_USER'];
        $password   = $_ENV['DB_PASS'];
        $dsn        = "mysql:host=${host};dbname=${database}";

        $this->db = ADOnewConnection('pdo');
        $this->db->SetFetchMode(ADODB_FETCH_ASSOC);
        $this->db->connect($dsn, $user, $password);
    }

    public function testSqlContainsQuestions(): void
    {
        $sql = 'SELECT * FROM employees WHERE id = ?';
        $params = [2];

        $result = $this->db->execute($sql, $params);
        $row = $result->fetchRow();

        $this->assertEquals(2, $row['id']);
        $this->assertEquals('bar', $row['name']);
    }

    /**
     * NOTE: This test is expected to pass, but fails on ADOdb 5.21.1 and later.
     */
    public function testSqlWithNamedParameters(): void
    {
        $sql = 'SELECT * FROM employees WHERE id = :id';
        $params = ['id' => 2];

        $result = $this->db->execute($sql, $params);
        $row = $result->fetchRow();

        $this->assertEquals(2, $row['id']);
        $this->assertEquals('bar', $row['name']);
    }

    /**
     * NOTE: This test is expected to pass, but fails on ADOdb 5.21.1 and later.
     */
    public function testParameterKeysMustBeNumeric(): void
    {
        $sql = 'SELECT * FROM employees WHERE id = ?';
        $params = ['id' => 2];

        $this->expectWarning();

        $result = $this->db->execute($sql, $params);
        $row = $result->fetchRow();
        // PDOStatement::execute(): SQLSTATE[HY093]: Invalid parameter number: parameter was not defined
    }
}

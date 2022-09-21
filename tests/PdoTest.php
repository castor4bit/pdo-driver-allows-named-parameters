<?php

use PHPUnit\Framework\TestCase;

final class PdoTest extends TestCase
{
    private $dbh;

    public function setUp(): void
    {
        $host       = $_ENV['DB_HOST'];
        $database   = $_ENV['DB_NAME'];
        $user       = $_ENV['DB_USER'];
        $password   = $_ENV['DB_PASS'];
        $dsn        = "mysql:host=${host};dbname=${database}";

        $this->dbh = new PDO($dsn, $user, $password);
    }

    public function testSqlContainsQuestions(): void
    {
        $sql = 'SELECT * FROM employees WHERE id = ?';
        $params = [2];

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals(2, $row['id']);
        $this->assertEquals('bar', $row['name']);
    }

    public function testSqlWithNamedParameters(): void
    {
        $sql = 'SELECT * FROM employees WHERE id = :id';
        $params = ['id' => 2];

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals(2, $row['id']);
        $this->assertEquals('bar', $row['name']);
    }

    public function testParameterKeysMustBeNumeric(): void
    {
        $sql = 'SELECT * FROM employees WHERE id = ?';
        $params = ['id' => 2];

        if (version_compare(PHP_VERSION, '8.0') >= 0) {
            $this->expectException(PDOException::class);
        } else {
            $this->expectWarning();
        }

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($params);
        // PDOStatement::execute(): SQLSTATE[HY093]: Invalid parameter number: parameter was not defined
    }
}

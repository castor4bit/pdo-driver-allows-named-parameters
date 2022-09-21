CREATE DATABASE IF NOT EXISTS pdotest;

USE pdotest;

CREATE TABLE IF NOT EXISTS employees (
  id INT PRIMARY KEY,
  name VARCHAR(64)
);

INSERT IGNORE INTO employees VALUES (1, 'foo'), (2, 'bar'), (3, 'baz');


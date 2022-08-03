<?php

class AddPasswordUsersTable
{
    protected \Bundle\Database\Connection $connection;

    protected string $query;

    public function __construct()
    {
        $this->connection = \Bundle\Foundation\Application::$app->connection;
    }
    public function up()
    {
        $this->connection->pdo->exec('ALTER TABLE users ADD COLUMN password VARCHAR(512) NOT NULL');
    }

    public function down()
    {
        $this->connection->pdo->exec('ALTER TABLE users ADD COLUMN password VARCHAR(512) NOT NULL');
    }
}

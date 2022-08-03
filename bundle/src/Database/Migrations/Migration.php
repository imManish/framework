<?php

namespace Bundle\Database\Migrations;

abstract class Migration
{
    /**
     * Enables, if supported, wrapping the migration within a transaction.
     *
     * @var bool
     */
    public $withinTransaction = true;

    /**
     * The name of the database connection to use.
     *
     * @var null|string
     */
    protected $connection;

    /**
     * Get the migration connection name.
     *
     * @return null|string
     */
    public function getConnection()
    {
        return $this->connection;
    }
}

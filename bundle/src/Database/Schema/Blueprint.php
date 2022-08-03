<?php

namespace Bundle\Database\Schema;

use Closure;

class Blueprint
{
    /**
     * The storage engine that should be used for the table.
     *
     * @var string
     */
    public $engine;

    /**
     * The default character set that should be used for the table.
     *
     * @var string
     */
    public $charset;

    /**
     * The collation that should be used for the table.
     *
     * @var string
     */
    public $collation;

    /**
     * Whether to make the table temporary.
     *
     * @var bool
     */
    public $temporary = false;

    /**
     * The column to add new columns after.
     *
     * @var string
     */
    public $after;

    /**
     * The table the blueprint describes.
     *
     * @var string
     */
    protected $table;

    /**
     * The prefix of the table.
     *
     * @var string
     */
    protected $prefix;

    /**
     * The columns that should be added to the table.
     *
     * @var \Illuminate\Database\Schema\ColumnDefinition[]
     */
    protected $columns = [];

    /**
     * The commands that should be run for the table.
     *
     * @var \Illuminate\Support\Fluent[]
     */
    protected $commands = [];

    /**
     * Create a new schema blueprint.
     *
     * @param string $table
     * @param string $prefix
     */
    public function __construct($table, Closure $callback = null, $prefix = '')
    {
        var_dump($callback);
        exit;
        $this->table = $table;
        $this->prefix = $prefix;

        if (!is_null($callback)) {
            $callback($this);
        }
    }
}

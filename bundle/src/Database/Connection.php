<?php

namespace Bundle\Database;

use Bundle\Foundation\Application;
use JetBrains\PhpStorm\NoReturn;
use \PDO;

class Connection
{
    public \PDO $pdo;

    public string $dsn = '';

    public string $driver = '';

    public string $host = '';

    public string $port = '';

    public string $database = '';

    public string $user = '';

    public string $password = '';

    public function __construct(array $config)
    {
        // DB_DNS=mysql:host=localhost;port=3306;dbname=homebrew
        $this->setup($config);
        $this->pdo = new PDO($this->dsn, $this->user, $this->password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * > This function sets up the database connection.
     *
     * @param config the configuration array that was passed to the constructor
     * @param mixed $config
     */
    private function setup($config): void
    {
        // DB_DNS=mysql:host=localhost;port=3306;dbname=homebrew
        $this->dsn = $config['DB_DRIVER'].':host='.$config['DB_HOST'].';port='
            .$config['DB_PORT'].';dbname='.$config['DB_DATABASE'] ?? $this->dsn;
        $this->driver = $config['DB_DRIVER'] ?? $this->driver;
        $this->host = $config['DB_HOST'] ?? $this->host;
        $this->port = $config['DB_PORT'] ?? $this->port;
        $this->database = $config['DB_DATABASE'] ?? $this->database;
        $this->user = $config['DB_USERNAME'] ?? $this->user;
        $this->password = $config['DB_PASSWORD'] ?? $this->password;
    }

    #[NoReturn]
    // Applying the migrations to the database.
    public function apply(): array
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();
        $files = scandir(Application::$ROOT_DIR.'/database/migrations');
        $toApplyMigrations = array_diff($files, $appliedMigrations);
        $newMigration = [];
        foreach ($toApplyMigrations as $migration) {
            if (in_array($migration, ['.', '..'])) {
                continue;
            }

            require_once Application::$ROOT_DIR.'/database/migrations/'.$migration;
            $className = $this->serialize($migration);
            $instance = new $className();

            echo $this->log("Applying migration {$migration}");
            $instance->up();
            echo $this->log("Applied migration {$migration}");

            $newMigration[] = $migration;
        }
        if (!empty($newMigration)) {
            $this->trigger($newMigration);
        } else {
            $this->log('Nothing to migrate');
        }

        exit;
    }

    /**
     * > Create a table called migrations in the database.
     *
     * @return bool|int the number of rows affected by the last SQL statement
     */
    public function createMigrationsTable(): bool|int
    {
        return $this->pdo->exec($this->statement());
    }

    /**
     * It returns an array of all the migrations that have been applied to the database.
     *
     * @throws Exception
     *
     * @return array|bool an array of all the migrations that have been applied
     */
    protected function getAppliedMigrations(): bool|array
    {
        $statement = $this->pdo->prepare('SELECT migration from migrations');
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * It takes a string as an argument and prints it to the console.
     *
     * @param message the message to log
     * @param mixed $message
     */
    protected function log($message): void
    {
        echo '['.date('Y-m-d H:i:s').'] - '.$message.PHP_EOL;
    }

    /**
     * It returns a string that contains the SQL statement to create the migrations table.
     *
     * @return string a string
     */
    private function statement(): string
    {
        return 'CREATE TABLE IF NOT EXISTS migrations(
              `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
              `migration` VARCHAR(255) NOT NULL,
              `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`)            
            ) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;';
    }

    private function createView(): void
    {
    }

    /**
     * > It takes a string, removes the first 18 characters, removes the file extension,
     * replaces underscores with spaces, capitalizes the first letter of each word, removes the spaces,
     * and capitalizes the first letter of the whole string.
     *
     * @param mixed migration The migration file name
     *
     * @return string the name of the migration file
     */
    private function serialize(mixed $migration): string
    {
        return ucfirst(str_replace(
            ' ',
            '',
            ucwords(
                str_replace(
                    '_',
                    ' ',
                    pathinfo(substr($migration, 18), PATHINFO_FILENAME)
                )
            )
        ));
    }

    /**
     * It takes an array of migration names, and inserts them into the migrations table.
     *
     * @param array migrations An array of migrations to be triggered
     *
     * @throws Exception
     */
    private function trigger(array $migrations): void
    {
        // var_dump($migrations);
        $migrations = implode(',', array_map(fn ($m) => "('{$m}')", $migrations));
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES {$migrations}");
        $statement->execute();
    }
}

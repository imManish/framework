<?php

namespace Bundle\Database;

use Bundle\Foundation\Application;
use JetBrains\PhpStorm\NoReturn;
use PDO;

class Connection
{
    /**
     * @var PDO
     */
    public PDO $pdo;

    /**
     * @var string
     */
    public string $dsn = '';

    /**
     * @var string
     */
    public string $user = '';

    /**
     * @var string
     */
    public string $password = '';


    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->setup($config);
        //var_dump($this->dsn, $this->user, $this->password);
        $this->pdo = new PDO($this->dsn, $this->user, $this->password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @param $config
     * @return void
     */
    private function setup($config): void
    {
        $this->dsn = $config['DB_DNS'] ?? $this->dsn;
        $this->user = $config['DB_USERNAME'] ?? $this->user;
        $this->password = $config['DB_PASSWORD'] ?? $this->password;
    }

    /**
     * @return array
     */
    #[NoReturn]
    public function apply(): array
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();
        $files = scandir(Application::$ROOT_DIR . '/database/migrations');
        $toApplyMigrations = array_diff($files, $appliedMigrations);
        $newMigration = [];
        foreach ($toApplyMigrations as $migration) {
            if (in_array($migration, array('.','..'))) {
                continue;
            }
            require_once Application::$ROOT_DIR . '/database/migrations/' . $migration;
            $className = $this->serilize($migration);
            $instance = new $className();

            echo $this->log("Applying migration $migration");
            $instance->up();
            echo $this->log("Applied migration $migration");

            $newMigration[] = $migration;
        }
        if (!empty($newMigration)) {
            $this->trigger($newMigration);
        } else {
            $this->log("Nothing to migrate");
        }
        exit;
    }

    /**
     * @return false|int
     */
    public function createMigrationsTable()
    {
        return $this->pdo->exec($this->statement());
    }

    /**
     * @return string
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

    /**
     * @return bool|array
     */
    protected function getAppliedMigrations(): bool|array
    {
        $statement = $this->pdo->prepare('SELECT migration from migrations');
        $statement->execute();
        return  $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    private function createView()
    {
    }

    /**
     * @param mixed $migration
     * @return string
     */
    private function serilize(mixed $migration): string
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
     * @param array $migrations
     * @return void
     */
    private function trigger(array $migrations): void
    {
        //var_dump($migrations);
        $migrations = implode(',', array_map(fn ($m) =>"('$m')", $migrations));
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $migrations");
        $statement->execute();
    }

    /**
     * @param $message
     * @return void
     */
    protected function log($message): void
    {
        echo '[' . date('Y-m-d H:i:s') . '] - ' . $message . PHP_EOL;
    }
}

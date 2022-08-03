<?php

use Bundle\Database\Migrations\Migration;
//use Bundle\Database\Schema\Blueprint;
use Bundle\Support\Facades\Schema;

class CreateUsersTable extends Migration
{

    /**
     * It creates a table called users with the columns id, email, firstname, lastname, status, and created_at.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('firstname');
            $table->text('lastname');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamp('created_at')->useCurrent();
        });

        /*$this->query = 'CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(255) NOT NULL,
                firstname VARCHAR(255) NOT NULL,
                lastname VARCHAR(255) NOT NULL,
                status TINYINT DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )  ENGINE=INNODB;';
        $this->connection->pdo->exec($this->query);*/
    }

    /**
     * It drops the table users.
     */
    public function down(): void
    {
        $this->query = 'DROP TABLE users;';
        $this->connection->pdo->exec($this->query);
    }
}

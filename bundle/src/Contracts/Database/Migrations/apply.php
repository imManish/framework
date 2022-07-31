<?php
namespace Bundle\Contracts\Database\Migrations;

interface Migration {

    public function apply() :array;

}
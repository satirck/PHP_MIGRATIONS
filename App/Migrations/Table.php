<?php

declare(strict_types=1);

namespace App\Migrations;

use App\Exceptions\Migrations\DBNameNotSetException;
use App\Exceptions\Migrations\MigrationActionNotSetException;
use App\Exceptions\Migrations\MigrationEmptyFieldsException;
use App\Exceptions\Migrations\TableNameNotSetException;
use App\Migrations\Field\Field;

class Table
{
    /**
     * @var Field[]
     */
    private array $fields = [];

    private TableAction $action = TableAction::Empty;

    private string $db;

    private string $table;

    public function create(string $db, string $table): void
    {
        $this->db = $db;
        $this->table = $table;
        $this->action = TableAction::CREATE;
    }

    public function update(string $db, string $table): void
    {
        $this->db = $db;
        $this->table = $table;
        $this->action = TableAction::UPDATE;
    }

    public function remove(string $db, string $table): void
    {
        $this->db = $db;
        $this->table = $table;
        $this->action = TableAction::REMOVE;
    }

    /**
     * @return void
     * @throws DBNameNotSetException if database name isn`t set
     * @throws TableNameNotSetException if table name isn`t set
     * @throws MigrationActionNotSetException if migration action isn`t set
     */
    private function checkReqFields(): void
    {
        if ($this->action === TableAction::Empty){
            throw new MigrationActionNotSetException('Cannot give sql code cause no type of action is set');
        }

        if ($this->db === ''){
            throw new DBNameNotSetException('Cannot give sql code cause of not set db name');
        }

        if ($this->table === ''){
            throw new TableNameNotSetException('Cannot give sql code cause of not set db name');
        }
    }

    /**
     * @throws MigrationEmptyFieldsException
     */
    private function tableCreateSQL(): string
    {
        if ($this->fields === []){
            throw new MigrationEmptyFieldsException('For creating database ypu need at least 1 attribute');
        }

        return sprintf(
            'CREATE TABLE IF NOT EXISTS `%s`.`%s` ();',
            $this->db,
            $this->table
        );
    }

    private function tableDropSQL(): string
    {
        return sprintf(
            'DROP TABLE IF EXISTS `%s`.`%s` ();',
            $this->db,
            $this->table
        );
    }

    private function tableUpdateSQL(): string{


        return '';
    }


    /**
     * @throws DBNameNotSetException
     * @throws MigrationActionNotSetException
     * @throws TableNameNotSetException
     * @throws MigrationEmptyFieldsException
     */
    public function getSQLQuery(): string
    {
        $this->checkReqFields();

        if ($this->action === TableAction::CREATE){
            return $this->tableCreateSQL();
        }

        if ($this->action === TableAction::REMOVE){
            return $this->tableCreateSQL();
        }

        return $this->tableUpdateSQL();
    }
}

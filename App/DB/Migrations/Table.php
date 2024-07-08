<?php

declare(strict_types=1);

namespace App\DB\Migrations;

use App\DB\SQLGenerator\DBQueryGeneratorInterface;
use App\Exceptions\Migrations\DBNameNotSetException;
use App\Exceptions\Migrations\MigrationActionNotSetException;
use App\Exceptions\Migrations\MigrationEmptyFieldsException;
use App\Exceptions\Migrations\TableNameNotSetException;

class Table
{
    private string $db;

    private string $table;

    /**
     * @var Field[]
     */
    private array $fields = [];

    private TableAction $action = TableAction::EMPTY;

    public function __construct(
        protected DBQueryGeneratorInterface $queryGenerator
    )
    {
    }

    public function getAction(): TableAction
    {
        return $this->action;
    }

    public function create(string $db, string $table): void
    {
        $this->setTableData($db, $table);
        $this->setStatus(TableAction::CREATE);
    }

    public function update(string $db, string $table): void
    {
        $this->setTableData($db, $table);
        $this->setStatus(TableAction::UPDATE);
    }

    public function remove(string $db, string $table): void
    {
        $this->setTableData($db, $table);
        $this->setStatus(TableAction::REMOVE);
    }

    private function setTableData(string $db, string $table): void
    {
        $this->db = $db;
        $this->table = $table;
    }

    private function setStatus(TableAction $action): void
    {
        $this->action = $action;
    }

    public function setColumn(string $name, string $type, bool $isNullable = true): void
    {
        $this->fields[$name] = new Field($name, $type, $isNullable);
    }

    public function getColumn(string $name): Field|null
    {
        return $this->fields[$name] ?? null;
    }

    /**
     * @return void
     * @throws DBNameNotSetException if database name isn`t set
     * @throws TableNameNotSetException if table name isn`t set
     * @throws MigrationActionNotSetException if migration action isn`t set
     */
    private function checkReqFields(): void
    {
        if ($this->action === TableAction::EMPTY) {
            throw new MigrationActionNotSetException('Cannot give sql code cause no type of action is set');
        }

        if ($this->db === '') {
            throw new DBNameNotSetException('Cannot give sql code cause of not set db name');
        }

        if ($this->table === '') {
            throw new TableNameNotSetException('Cannot give sql code cause of not set db name');
        }
    }

    /**
     * @throws MigrationEmptyFieldsException
     */
    private function tableCreateSQL(): string
    {
        if ($this->fields === []) {
            throw new MigrationEmptyFieldsException('For creating database ypu need at least 1 attribute');
        }

        return $this->queryGenerator->createTable(
            $this->db,
            $this->table,
            $this->fields
        );
    }

    private function tableDropSQL(): string
    {
        return $this->queryGenerator->dropTable(
            $this->db,
            $this->table,
        );
    }

    private function tableUpdateSQL(): string
    {
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

        if ($this->action === TableAction::CREATE) {
            return $this->tableCreateSQL();
        }

        if ($this->action === TableAction::REMOVE) {
            return $this->tableDropSQL();
        }

        return $this->tableUpdateSQL();
    }
}

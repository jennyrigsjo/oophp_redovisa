<?php
/**
 * This file contains code to implement the class Query.
 * @author Jenny Rigsjö (anri16)
 * @version 1.0.0
 */
namespace Anri16\Movie;

/**
 * Sql/query class for the 'movie' database (or any other database). The public
 * methods of the class contain sql statements which are executed using the
 * public methods available in the Anax 'database' module.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class Query
{
    /**************************************************************************************
                                        Private variables
    ***************************************************************************************/

    /**
     * @var Array $args    List of (optional) arguments used for some queries.
     */
    private $args = null;

    /**
     * @var Array $resultset    The result from the database query.
     */
    private $resultset = null;

    /**************************************************************************************
                                        Public methods
    ***************************************************************************************/


    /**
     * Constructor to initiate the movie database.
     * @param String $table The name of the table to be queried.
     */
    public function __construct()
    {
        $this->args = [];
        $this->resultset = [];
    }

    /**
     * Get the arguments used in the lastest query.
     * @return Array The arguments.
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * Reset/empty the args array.
     */
    public function resetArgs()
    {
        $this->args = [];
    }

    /**
     * Get the result from the latest query.
     * @return Array with the result of the query.
     */
    public function getResult()
    {
        return $this->resultset;
    }

    /**
     * Reset/empty the resultset array.
     */
    public function resetResult()
    {
        $this->resultset = [];
    }

    /**
     * Select all rows from table $table in database $db. Optionlly specify
     * which columns should be selected, default is all columns.
     * @param Object $db The database.
     * @param String $table The name of the table.
     * @param Array $columns List of the names of the columns to be selected
     */
    public function selectAllFromTable($db, $table, $columns = [])
    {
        $sql = "";
        if (empty($columns)) {
            $sql = "SELECT * FROM {$table};";
        } else {
            $columnsString = implode(", ", $columns);
            $sql = "SELECT {$columnsString} FROM {$table};";
        }
        $db->connect();
        $this->resultset = $db->executeFetchAll($sql);
    }

    /**
     * Select all rows whose values in $column are equal to or between $min and $max.
     * @param Object $db The database.
     * @param String $table The name of the table.
     * @param String $column The name of the column.
     * @param Integer $min The minimum value.
     * @param Integer $max The maximum value.
     */
    public function selectCompareOneColumnTwoValues($db, $table, $column, $min = null, $max = null)
    {
        $args = [];

        if ($min && $max) {
            $sql = "SELECT * FROM {$table} WHERE {$column} >= ? AND {$column} <= ?;";
            $args = [$min, $max];
        } elseif ($min) {
            $sql = "SELECT * FROM {$table} WHERE {$column} >= ?;";
            $args = [$min];
        } elseif ($max) {
            $sql = "SELECT * FROM {$table} WHERE {$column} <= ?;";
            $args = [$max];
        }

        $db->connect();
        $this->resultset = $db->executeFetchAll($sql, $args);
        $this->saveArgs($args);
    }

    /**
     * Select all rows from table $table in database $db whose $column is like $search.
     * @param Object $db The database.
     * @param String $table The name of the table.
     * @param String $column The name of the column.
     * @param String $search The argument to match.
     */
    public function selectFromTableWhereLike($db, $table, $column, $search)
    {
        $db->connect();
        $sql = "SELECT * FROM {$table} WHERE {$column} LIKE ?;";
        $this->resultset = $db->executeFetchAll($sql, [$search]);
        $this->saveArgs([$search]);
    }

    /**
     * Select the first row from table $table in database $db whose $column is equal to $search.
     * @param Object $db The database.
     * @param String $table The name of the table.
     * @param String $column The name of the column.
     * @param String $search The argument to match.
     */
    public function selectFromTableWhereFirstEquals($db, $table, $column, $search)
    {
        $db->connect();
        $sql = "SELECT * FROM {$table} WHERE {$column} = ?;";
        $this->resultset = $db->executeFetch($sql, [$search]);
        $this->saveArgs([$search]);
    }

    /**
     * Insert a row in a table in a database.
     * @param Object $db The database.
     * @param String $table The name of the table.
     * @param Array $columns The columns into which the values will be inserted.
     * @param Array $values The values to be inserted.
     */
    public function executeInsert($db, $table, $columns, $values)
    {
        $columnsString = implode(", ", $columns);

        $sql = "INSERT INTO {$table} ({$columnsString}) VALUES (?, ?, ?);";

        $db->connect();
        $db->execute($sql, $values);
    }

    /**
     * Update a row in a table in a database.
     * @param Object $db The database.
     * @param String $table The name of the table.
     * @param Array $columns The columns that will be updated.
     * @param Array $values The values with which the columns will be updated.
     */
    public function executeUpdate($db, $table, $columns, $values)
    {
        $sql = "UPDATE {$table} SET";

        for ($i = 0; $i < count($columns); $i++) {
            $column = $columns[$i];
            if ($i === count($columns) - 2) {
                $sql .= " {$column} = ?";
            } elseif ($i === count($columns) - 1) {
                $sql .= " WHERE {$column} = ?;";
            } else {
                $sql .= " {$column} = ?,";
            }
        }

        $db->connect();
        $db->execute($sql, $values);
    }

    /**
     * Delete one or more rows in a table in a database.
     * @param Object $db The database.
     * @param String $table The name of the table.
     * @param String $column The column containing the identifying value.
     * @param String $value The value used to identify the row(s).
     */
    public function executeDelete($db, $table, $column, $value)
    {
        $sql = "DELETE FROM {$table} WHERE {$column} = ?;";
        $db->connect();
        $db->execute($sql, [$value]);
    }


    /**************************************************************************************
                                        Private methods
    ***************************************************************************************/

    /**
     * Save the args from the lastest query.
     * @param Array $args The arguments.
     */
    private function saveArgs($args)
    {
        $this->args = $args;
    }
}

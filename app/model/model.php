<?php
require_once __DIR__ . "/../../core/Database.php";

class Model
{
    protected PDO $DB;
    public function __construct()
    {
        $this->DB = \Database::getConnection();
    }

    public static function prepareWhereQuery(array $wheres)
    {
        /*
         * [
         * [col,operator,value , logicalOp],
         * [col,operator,value , logicalOp],
         * [col,operator,value , logicalOp]
         * ]
         */

        $whereQuery = "";
        if (!empty($wheres)) {
            $whereQuery = " WHERE ";
            $counter = 1;
            foreach ($wheres as $where) {
                if ($counter > 1) {
                    if (isset($where[3])) {
                        $whereQuery .= "{$where[3]} ";
                    } else {
                        $whereQuery .= "AND ";
                    }
                }
                $whereQuery .= " {$where[0]} {$where[1]} '{$where[2]}' ";
                $counter++;
            }
        }
        return $whereQuery;
    }
}

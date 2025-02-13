<?php
require_once 'Database.php';

class Type extends Database
{
    // table name
    protected $tableName = 'types';


    /**
     * function is used to get records
     * @param int $stmt
     * @param int @limit
     * @return array $results
     */

     public function getRows($start = 0, $limit = 4)
     {
         $sql = "SELECT * FROM {$this->tableName} ORDER BY id DESC LIMIT {$start},{$limit}";
         $stmt = $this->conn->prepare($sql);
         $stmt->execute();
         if ($stmt->rowCount() > 0) {
             $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
         } else {
             $results = [];
         }
         return $results;
     }
}
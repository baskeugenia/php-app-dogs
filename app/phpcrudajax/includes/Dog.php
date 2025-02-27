<?php
require_once 'Database.php';

class Dog extends Database
{
    // table name
    protected $tableName = 'dogs';
    // table name types
    protected $typesTableName = 'types';

    /**
     * function is used to add record
     * @param array $data
     * @return int $lastInsertedId
     */
    public function add($data)
    {

        if (!empty($data)) {
            $fileds = $placholders = [];
            foreach ($data as $field => $value) {
                $fileds[] = $field;
                $placholders[] = ":{$field}";
            }
        }

        $sql = "INSERT INTO {$this->tableName} (" . implode(',', $fileds) . ") VALUES (" . implode(',', $placholders) . ")";
        $stmt = $this->conn->prepare($sql);
        try {
            $this->conn->beginTransaction();
            $stmt->execute($data);
            $lastInsertedId = $this->conn->lastInsertId();
            $this->conn->commit();
            return $lastInsertedId;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            $this->conn->rollback();
        }

    }

    public function update($data, $id)
    {
        if (!empty($data)) {
            $fileds = '';
            $x = 1;
            $filedsCount = count($data);
            foreach ($data as $field => $value) {
                $fileds .= "{$field}=:{$field}";
                if ($x < $filedsCount) {
                    $fileds .= ", ";
                }
                $x++;
            }
        }
        $sql = "UPDATE {$this->tableName} SET {$fileds} WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        try {
            $this->conn->beginTransaction();
            $data['id'] = $id;
            $stmt->execute($data);
            $this->conn->commit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            $this->conn->rollback();
        }

    }

    /**
     * function is used to get records
     * @param int $stmt
     * @param int @limit
     * @return array $results
     */

    public function getRows($start = 0, $limit = 4)
    {
        $sql = "SELECT {$this->tableName}.id, name, {$this->typesTableName}.id as type_id, {$this->typesTableName}.type, voice, can_hunt 
        FROM {$this->tableName}
        LEFT JOIN {$this->typesTableName} on {$this->tableName}.type={$this->typesTableName}.id
        ORDER BY id DESC LIMIT {$start},{$limit}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $results = [];
        }
        return $results;
    }

    // delete row using id
    public function deleteRow($id)
    {
        $sql = "DELETE FROM {$this->tableName}  WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        try {
            $stmt->execute([':id' => $id]);
            if ($stmt->rowCount() > 0) {
                return true;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }

    }

    public function getCount()
    {
        $sql = "SELECT count(*) as pcount FROM {$this->tableName}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['pcount'];
    }

    /**
     * function is used to get single record based on the column value
     * @param string $fileds
     * @param any $value
     * @return array $results
     */
    public function getRow($field, $value)
    {
        $sql = "SELECT dogs.id AS id, name, {$this->typesTableName}.type, {$this->typesTableName}.id as type_id, voice, can_hunt 
        FROM {$this->tableName}
        LEFT JOIN {$this->typesTableName} on {$this->tableName}.type={$this->typesTableName}.id
        WHERE {$this->tableName}.{$field}=:{$field}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([":{$field}" => $value]);
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $result = [];
        }

        return $result;
    }

    public function searchDog($searchText, $start = 0, $limit = 4)
    {
        $sql = "SELECT dogs.id, name, {$this->typesTableName}.type, voice, can_hunt 
        FROM {$this->tableName}
        LEFT JOIN {$this->typesTableName} on {$this->tableName}.type={$this->typesTableName}.id
        WHERE name LIKE :search 
        ORDER BY id DESC LIMIT {$start},{$limit}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':search' => "%{$searchText}%"]);
        if ($stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $results = [];
        }

        return $results;
    }


}

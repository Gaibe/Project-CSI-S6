<?php

require_once "../base.php";


class ModelExtends {


    public static function findByIdAbstract($table_name, $id) {
        $connection = base::getConnection();
        $stmt = $connection->prepare("SELECT * FROM :table_name WHERE id_client = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':table_name', $table_name);
        $stmt->execute();

        // set the resulting array to associative
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function findByPseudoAbstract($table_name, $pseudo) {
        $connection = base::getConnection();
        $pseudo = strtolower($pseudo);
        $stmt = $connection->prepare("SELECT * FROM :table_name WHERE pseudo = :pseudo");
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->bindParam(':table_name', $table_name);
        $stmt->execute();

        // set the resulting array to associative
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function hydrate($fetched_result, $obj) {
        foreach ($fetched_result as $key => $result) {
            $obj->__set($key, $result);
        }
        return $obj;
    }


}
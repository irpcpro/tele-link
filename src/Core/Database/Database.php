<?php

namespace Irpcpro\TeleLink\Core\Database;

class Database {
    protected $connection = null;

    // connect to database
    public function __construct() {
        try {
            // create connection to sql
            $this->connection = new \Mysqli(
                DATABASE_HOST,
                DATABASE_USERNAME,
                DATABASE_PASSWORD,
                DATABASE_NAME,
                DATABASE_PORT
            );
            if (mysqli_connect_errno()) {
                throw new \Exception("error to connect to database!");
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    // select query
    public function select($query = "", $params = []) {
        try {
            $stmt = $this->executeQuery($query, $params);
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $result;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    // do query with return id
    public function doQuery($query = "") {
        try {
            $stmt = $this->executeQuery($query);
            $result = $stmt->insert_id;
            $stmt->close();
            return $result;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    // convert array key => value to string of sql
    public function arrayFieldsToText($array)
    {
        $keys = [];
        $values = [];

        foreach ($array as $key => $value) {
            $keys[] = $key;
            $values[] = "'$value'";
        }

        $keys = implode(',', $keys);
        $values = implode(',', $values);
        return "($keys) VALUES ($values)";
    }

    // execute sql query
    private function executeQuery($query = "", $params = []) {
        try {
            $statement = $this->connection->prepare($query);

            if ($statement === false) {
                throw new \Exception("Error in execute Query: " . $query);
            }

            if ($params) {
                $statement->bind_param($params[0], $params[1]);
            }

            $statement->execute();

            return $statement;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    // create text fields
    private function createTextFields($fields){
        if( empty($fields) )
            return;

        $out = '';
        $get_fields = $fields;
        if( !empty( $get_fields ) ){
            foreach( $get_fields as $item ){
                $out .= '`'.$item['name'].'` '.$item['type'].',';
            }
        }
        return $out;
    }

    // create table if not exists
    public function TableCreate($PrimaryKey, $NameTable, $fields){
        if( $PrimaryKey == null || $NameTable == null )
            return;

        // get default character
        $charset_collate = "DEFAULT CHARACTER SET UTF8";

        // get fields and primary key table
        $get_fields = $this->CreateTextFields($fields);
        $get_primary_key = $PrimaryKey;

        // if fields not empty, create table
        if( $get_fields != '' ){
            // login logs table
            $Query = "CREATE TABLE IF NOT EXISTS `{$NameTable}` (
				$get_fields
				PRIMARY KEY (`$get_primary_key`)
			) $charset_collate AUTO_INCREMENT = 1;";

            // create table if not exists
            $this->executeQuery( $Query );
        }
    }
}

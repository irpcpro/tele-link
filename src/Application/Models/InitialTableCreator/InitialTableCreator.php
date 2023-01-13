<?php

namespace Irpcpro\TeleLink\Application\Models\InitialTableCreator;

use Phpass\Hash;
use Irpcpro\TeleLink\Application\Models\Links\Links;
use Irpcpro\TeleLink\Application\Models\Users\Users;
use Irpcpro\TeleLink\Core\Database\Database;

class InitialTableCreator extends Database {

    // create initial table
    public static function create() {
        try {
            // include config file
            require_once __DIR__."/../../../../config/app-config.php";

            // get this parent
            $_this = new self;

            // create table users
            $modelUser = new Users();
            $_this->TableCreate($modelUser->table_primary, $modelUser->table_name, $modelUser->table_fields);

            // create main user
            $phpassHash = new Hash();
            $data = $modelUser->arrayFieldsToText([
                'username' => 'admin',
                'password' => $phpassHash->hashPassword('123')
            ]);
            $sql = "INSERT INTO $modelUser->table_name $data";
            $modelUser->doQuery($sql);

            // create table links
            $modelLinks = new Links();
            $_this->TableCreate($modelLinks->table_primary, $modelLinks->table_name, $modelLinks->table_fields);

            // output message
            print("\n*********************\n");
            print("Database created :)\n");
            print("username: admin\n");
            print("password: 123\n");
            print("*********************\n");
            return;
        } catch (\Exception $e){
            // output message
            print("\n*********************\n");
            print("An error happened !\n");
            print($e->getMessage() . "\n");
            print("*********************\n");
            return;
        }
    }

}

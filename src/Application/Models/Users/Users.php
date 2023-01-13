<?php
namespace Irpcpro\TeleLink\Application\Models\Users;

use Irpcpro\TeleLink\Core\Database\Database;

class Users extends Database {

    public $table_name = 'users';
    public $table_primary = 'user_id';
    public $table_fields = [
        [
            'name' => 'user_id',
            'type' => 'bigint(20) unsigned NOT NULL AUTO_INCREMENT',
        ],
        [
            'name' => 'username',
            'type' => 'varchar(20) NOT NULL',
        ],
        [
            'name' => 'password',
            'type' => 'varchar(255) NOT NULL',
        ]
    ];

}

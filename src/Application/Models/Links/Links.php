<?php
namespace Irpcpro\TeleLink\Application\Models\Links;

use Irpcpro\TeleLink\Core\Database\Database;

class Links extends Database {

    public $table_name = 'links';
    public $table_primary = 'link_id';
    public $table_fields = [
        [
            'name' => 'link_id',
            'type' => 'bigint(20) unsigned NOT NULL AUTO_INCREMENT',
        ],
        [
            'name' => 'link_original',
            'type' => 'longtext NOT NULL',
        ],
        [
            'name' => 'suffix',
            'type' => 'longtext NOT NULL',
        ],
        [
            'name' => 'user_id',
            'type' => 'bigint(20) unsigned NOT NULL',
        ],
        [
            'name' => 'deleted',
            'type' => 'int(2) NOT NULL DEFAULT 0',
        ]
    ];

}

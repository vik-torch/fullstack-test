<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'text'       => [
                'type'  => 'TEXT'
            ],
            'user_id'    => [
                'type'     => 'INT',
                'unsigned' => true
            ],
            'date'       => [
                'type' => 'DATETIME'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id');
        $this->forge->createTable('comments', true);
    }

    public function down()
    {
        $this->forge->dropTable('comments');
    }
}

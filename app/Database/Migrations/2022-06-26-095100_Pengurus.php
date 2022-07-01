<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pengurus extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pengurus' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'poin' => [
                'type' => 'INT',
                'contraint' => 11
            ],
        ]);

        $this->forge->addKey('id_pengurus', TRUE);
        $this->forge->addForeignKey('id_user', 'auth_groups_users', 'user_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pengurus', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('transaksi_preorder');
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JadwalJagaToko extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'hari' => [
                'type' => 'DATE',
            ],
            'sesi' => [
                'type' => 'INT',
                'constraint' => 1,
                'unsigned' => true
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('jadwal_jaga_toko');
    }

    public function down()
    {
        $this->forge->dropTable('jadwal_jaga_toko');
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AbsensiPengurus extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_absensi' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'waktu_datang' => [
                'type' => 'datetime',
            ],
            'waktu_pulang' => [
                'type' => 'datetime',
                'null' => true
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'kegiatan' => [
                'type' => 'text',
                'null' => true
            ]
        ]);

        $this->forge->addKey('id_absensi', TRUE);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('absensi_pengurus', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('absensi_pengurus');
    }
}

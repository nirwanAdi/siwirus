<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MetodePembayaran extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'=> 'INT',
                'constraint' => 2,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_bank' => [
                'type'=> 'VARCHAR',
                'constraint' => 255,
            ],
            'no_rekening' => [
                'type'=> 'VARCHAR',
                'constraint' => 255,
            ],
        ]);
        
        $this->forge->addKey('id',true);
        $this->forge->createTable('metode_pembayaran',true);
    }

    public function down()
    {
        $this->forge->dropTable('metode_pembayaran');
    }
}

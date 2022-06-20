<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BarangPreorder extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'=> 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_barang' => [
                'type'=> 'VARCHAR',
                'constraint' => 255,
            ],
            'gambar_barang' => [
                'type'=> 'VARCHAR',
                'constraint' => 2555,
            ],
            'harga' => [
                'type'=> 'INT',
                'constraint' => 11,
            ],
            'created_at' => [
                'type' => 'datetime', 
                'null' => true
            ],
            'updated_at' => [
                'type' => 'datetime', 
                'null' => true],
        ]);
        
        $this->forge->addKey('id',TRUE);

        $this->forge->createTable('barang_preorder',TRUE);

    }

    public function down()
    {
        $this->forge->dropTable('barang_preorder');
    }
}

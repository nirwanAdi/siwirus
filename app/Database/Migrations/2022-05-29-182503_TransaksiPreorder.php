<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TransaksiPreorder extends Migration
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
            'id_pembeli' => [
                'type'=> 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_barang' => [
                'type'=> 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_metode_pembayaran' => [
                'type'=> 'INT',
                'constraint' => 2,
                'unsigned' => true,
            ],
            'jumlah' => [
                'type'=> 'INT',
                'constraint' => 2,
            ],
            'total_harga' => [
                'type'=> 'INT',
                'constraint' => 11,
            ],
            'status' => [
                'type'=> 'INT',
                'constraint' => 1,
            ],
            'gambar_bukti_pembayaran' => [
                'type'=> '  VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'datetime', 
                'null' => true
            ],
            'updated_at' => [
                'type' => 'datetime', 
                'null' => true],
        ]);

        $this->forge->addKey('id',true);
        $this->forge->addForeignKey('id_pembeli','users','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('id_barang','barang_preorder','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('id_metode_pembayaran','metode_pembayaran','id','CASCADE','CASCADE');
        $this->forge->createTable('transaksi_preorder',true);
    }

    public function down()
    {
        $this->forge->dropTable('transaksi_preorder');
    }
}

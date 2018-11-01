<?php

use Phinx\Migration\AbstractMigration;

class TablaEelectronicaDtocliente extends AbstractMigration {

    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * http://docs.phinx.org/en/latest/migrations.html
     * 
      CREATE TABLE [DtoCliente]
      (
      [Cliente]			Text (12),
      [Familia]			Text (20)
      );
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up() {
        $articulos = $this->table('modulo_eelectronica_dtocliente');
        $articulos->addColumn('Cliente', 'string', ['limit' => 12])
                ->addColumn('Familia', 'string', ['limit' => 20])
                ->addTimestamps('creado_en', 'actualizado_en')
                ->create();
    }

    /*
     * Todo lo que se hace en el rollback
     */

    public function down() {

        $this->dropTable('modulo_eelectronica_dtocliente');
    }

}

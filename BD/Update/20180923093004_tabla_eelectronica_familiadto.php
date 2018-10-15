<?php

use Phinx\Migration\AbstractMigration;

class TablaEelectronicaFamiliadto extends AbstractMigration {

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
      CREATE TABLE [FamiliaDto]
      (
      [Familia]			Text (20),
      [Dto]			Byte
      );
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up() {
        $articulos = $this->table('modulo_eelectronica_familiadto');
        $articulos->addColumn('Familia', 'string', ['limit' => 20])
                ->addColumn('Dto', 'integer', ['limit' => 4])
                ->addTimestamps('creado_en', 'actualizado_en')
                ->addIndex(['Familia'], ['unique' => true])
                ->create();
    }

    /*
     * Todo lo que se hace en el rollback
     */

    public function down() {

        $this->dropTable('modulo_eelectronica_familiadto');
    }

}

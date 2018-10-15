<?php

use Phinx\Migration\AbstractMigration;

class TablaEelectronicaCategorias extends AbstractMigration {

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
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     * CREATE TABLE [Categorias]
      (
      [Cat]			Text (50),
      [Des]			Text (400)
      );

     */
    public function up() {
        $articulos = $this->table('modulo_eelectronica_categorias');
        $articulos->addColumn('Cat', 'string', ['limit' => 50])
                ->addColumn('Des', 'string', ['null'=>true,'limit' => 400])
                ->addTimestamps('creado_en', 'actualizado_en')
                ->addIndex(['Cat'], ['unique' => true])
                ->create();
    }

    /*
     * Todo lo que se hace en el rollback
     */

    public function down() {

        $this->dropTable('modulo_eelectronica_categorias');
    }

}

<?php



use Phinx\Migration\AbstractMigration;

class ModuloEelectronicaImportar extends AbstractMigration
{
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
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up(){
        $users = $this->table('modulo_eelectronica_importar');
        $users->addColumn('fechaInicio', 'datetime',['default' => 'CURRENT_TIMESTAMP'])
                ->addColumn('accion', 'string', ['null'=>true, 'limit' => 50])
                ->addColumn('totalRegistros','integer',['limit'=>11])
                ->addColumn('numRegistro','integer',['limit'=>11])
                ->addColumn('progreso', 'decimal', ['null' => true, 'precision'=>10,'scale'=>3])
                ->addColumn('fechaFin', 'datetime',['null'=>true])                
                ->addTimestamps('creado_en', 'actualizado_en')
            ->create();
    }        
    

    
    
    /*
     * Todo lo que se hace en el rollback
     */
    public function down(){

        $this->dropTable('modulo_eelectronica_importar');
    }
}

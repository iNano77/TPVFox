<?php



use Phinx\Migration\AbstractMigration;

class ModificarFamiliasEstado extends AbstractMigration
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
    public function change(){
        $users = $this->table('familias');
        $users->addColumn('descripcion', 'string', ['null' => true, 'limit'=>400])                
            ->addColumn('estado', 'string', ['null' => true, 'limit'=>12])                
                ->update();
    }                
}

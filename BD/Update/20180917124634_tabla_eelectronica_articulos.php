<?php



use Phinx\Migration\AbstractMigration;

class TablaEelectronicaArticulos extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Art,Cat,Nom,detalle,Stock,pvp,iva,dto,notas,Fstock0,NoFstock0
     * CREATE TABLE [Articulos]
 (
	[Art]			Text (26), 
	[Cat]			Text (50), 
	[Nom]			Text (400), 
	[detalle]			Text (400), 
	[Stock]			Double, 
	[pvp]			Currency, 
	[iva]			Byte, 
	[dto]			Text (20), 
	[notas]			Memo/Hyperlink (255), 
	[Fstock0]			DateTime, 
	[NoFstock0]			Boolean NOT NULL
);
     */
    public function up(){
        $articulos = $this->table('modulo_eelectronica_articulos');
        $articulos->addColumn('Art', 'string', ['limit' => 50])
              ->addColumn('Cat', 'string', ['null'=>true,'limit' => 50])
              ->addColumn('Nom', 'string', ['limit' => 400])
              ->addColumn('detalle', 'string', ['null'=>true, 'limit' => 400])
              ->addColumn('Stock', 'decimal', ['null' => true, 'precision'=>10,'scale'=>3]) 
              ->addColumn('pvp', 'decimal', ['null' => true, 'precision'=>10,'scale'=>2]) 
              ->addColumn('iva', 'integer', ['null' => true]) 
              ->addColumn('dto', 'string', ['null' => true, 'limit'=>20]) 
              ->addColumn('notas', 'string', ['null' => true, 'limit'=>255]) 
              ->addColumn('Fstock0', 'datetime', ['null'=> true, 'default' => 'CURRENT_TIMESTAMP'])
              ->addColumn('NoFstock0', 'boolean', ['default' => false])
              ->addColumn('idFamilia', 'integer', ['null' => false, 'default'=>0,'limit'=>11]) 
              ->addTimestamps('creado_en', 'actualizado_en')
              ->addIndex(['Art'], ['unique' => true])
              ->create();
    }        
    

    
    
    /*
     * Todo lo que se hace en el rollback
     */
    public function down(){

        $this->dropTable('modulo_eelectronica_articulos');
    }
}

<?php

use Phinx\Migration\AbstractMigration;

class UserProfileMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
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
    public function up()
    {
        $table = $this->table('userProfile');

        $table
            ->addColumn('userId', 'integer', ['limit' => 255])
            ->addColumn('namaDepan', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('namaBelakang', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('ttl', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('alamat', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('jenisIdentitas', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('noIdentitas', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('profilePicturePath', 'string', ['limit' => 255, 'null' => true])
            ->create();
    }

}









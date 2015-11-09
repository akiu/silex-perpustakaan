<?php

use Phinx\Migration\AbstractMigration;

class ApprovedRequestMigration extends AbstractMigration
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
        $table = $this->table('approvedBooksRequest');

        $table
            ->addColumn('userId', 'integer', ['limit' => 255])
            ->addColumn('userName', 'string', ['limit' => 255])
            ->addColumn('bookId', 'string', ['limit' => 255])
            ->addColumn('bookTitle', 'string', ['limit' => 255])
            ->addColumn('bookNumber', 'integer', ['limit' => 255])
            ->addColumn('daysBorrow', 'integer', ['limit' => 255])
            ->addColumn('createdDate', 'date')
            ->addColumn('returningDate', 'date')
            ->create();
    }
}

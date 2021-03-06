<?php

use Phinx\Migration\AbstractMigration;

class DigitalBookMigration extends AbstractMigration
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

        $book = $this->table('digitalbooks');
        $book->addColumn('title', 'string', ['limit' => 255])
            ->addColumn('category', 'integer', ['limit' => 255])
            ->addColumn('author', 'string', ['limit' => 255])
            ->addColumn('totalPage', 'integer', ['limit' => 255])
            ->addColumn('description', 'text')
            ->addColumn('imagePath', 'string', ['limit' => 255])
            ->addColumn('slug', 'string', ['limit' => 255])
            ->addColumn('attachmentPath', 'string', ['limit' => 255])
            ->create();

    }
}

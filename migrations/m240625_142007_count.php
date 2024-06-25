<?php

use yii\db\Migration;

/**
 * Class m240625_142007_count
 */
class m240625_142007_count extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('count', [
            'id' => $this->primaryKey(),
            'user_id'=>$this->integer()->notNull(),
            'template_id' => $this->integer()->notNull(),
            'copy_count' => $this->integer()->defaultValue(0),
        ], 'ENGINE=InnoDB');
        $this->addForeignKey(
            'fk-count-user',
            'count',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-count-template',
            'count',
            'template_id',
            'template',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-count-user', 'count');
        $this->dropForeignKey('fk-count-template', 'count');
        $this->dropTable('{{%count}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240625_142007_count cannot be reverted.\n";

        return false;
    }
    */
}

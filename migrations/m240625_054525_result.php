<?php

use yii\db\Migration;

/**
 * Class m240625_054525_result
 */
class m240625_054525_result extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('result', [
            'id' => $this->primaryKey(),
            'user_id'=>$this->integer()->notNull(),
            'template_id'=>$this->integer()->notNull(),
            'score'=>$this->integer(),
        ], 'ENGINE=InnoDB');
        $this->addForeignKey(
            'fk-result-user',
            'result',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-result-template',
            'result',
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
        $this->dropForeignKey('fk-result-user', 'result');
        $this->dropForeignKey('fk-result-template', 'result');
        $this->dropTable('{{%result}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240625_054525_result cannot be reverted.\n";

        return false;
    }
    */
}

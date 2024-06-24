<?php

use yii\db\Migration;

/**
 * Class m240624_170829_question
 */
class m240624_170829_question extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('question', [
            'id' => $this->primaryKey(),
            'template_id' => $this->integer()->notNull(),
            'question_text'=>$this->text()->notNull(),
        ],'ENGINE=InnoDB');
        $this->addForeignKey(
            'fk-question-template',
            'question',
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
        $this->dropForeignKey('fk-question-template', 'question');
        $this->dropTable('{{%question}}');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240624_170829_question cannot be reverted.\n";

        return false;
    }
    */
}

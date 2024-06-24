<?php

use yii\db\Migration;

/**
 * Class m240624_171225_answer
 */
class m240624_171225_answer extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('answer', [
            'id' => $this->primaryKey(),
            'question_id' => $this->integer()->notNull(),
            'answer_text' => $this->text()->notNull(),
            'is_correct' => $this->boolean()->notNull()->defaultValue(false),
        ],'ENGINE=InnoDB');
        $this->addForeignKey(
            'fk-answer-question',
            'answer',
            'question_id',
            'question',
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
        $this->dropForeignKey('fk-answer-question', 'answer');
        $this->dropTable('{{%answer}}');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240624_171225_answer cannot be reverted.\n";

        return false;
    }
    */
}

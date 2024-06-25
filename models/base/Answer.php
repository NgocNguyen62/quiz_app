<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "answer".
 *
 * @property int $id
 * @property int $question_id
 * @property string $answer_text
 * @property int $is_correct
 *
 * @property Question $question
 */
class Answer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'answer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['question_id', 'answer_text'], 'required'],
            [['question_id', 'is_correct'], 'integer'],
            [['answer_text'], 'string'],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Question::class, 'targetAttribute' => ['question_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question_id' => 'Question ID',
            'answer_text' => 'Answer Text',
            'is_correct' => 'Is Correct',
        ];
    }

    /**
     * Gets query for [[Question]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::class, ['id' => 'question_id']);
    }
    const TRUE_ANSWER = 1;
    const FALSE_ANSWER = 0;
    public static function getStatus(){
        return[
            self::FALSE_ANSWER => 'False',
            self::TRUE_ANSWER => 'True'
        ];
    }
}

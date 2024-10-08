<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "question".
 *
 * @property int $id
 * @property int $template_id
 * @property string $question_text
 *
 * @property Template $template
 */
class Question extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'question';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['template_id', 'question_text'], 'required'],
            [['template_id'], 'integer'],
            [['question_text'], 'string'],
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => Template::class, 'targetAttribute' => ['template_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'template_id' => 'Template ID',
            'question_text' => 'Question Text',
        ];
    }

    /**
     * Gets query for [[Template]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::class, ['id' => 'template_id']);
    }
    public function getAnswers(){
        return $this->hasMany(Answer::class, ['question_id'=>'id']);
    }
    public function getCorrectAnswer(){
        foreach ($this->getAnswers()->all() as $answer) {
            if ($answer->is_correct == 1) {
                return $answer->answer_text;
            }
        }
        return null;
    }
    public function getOptions(){
        return $this->hasMany(Answer::className(), ['question_id' => 'id'])
            ->where(['is_correct' => 0])
            ->all();
    }
}

<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "template".
 *
 * @property int $id
 * @property string|null $content
 *
 * @property Question[] $questions
 */
class Template extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
        ];
    }

    /**
     * Gets query for [[Questions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Question::class, ['template_id' => 'id']);
    }

    public function canCopy(){
        $result = Result::find()->where(['user_id'=>Yii::$app->user->id])->andWhere(['template_id'=>$this->id])->one();
        $questions = $this->getQuestions()->count();

        if ($result !== null && $result->score == $questions) {
            return true;
        }
        return false;
    }
}

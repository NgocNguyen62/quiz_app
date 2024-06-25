<?php

namespace app\models\form;

use app\models\base\Answer;
use app\models\base\Result;
use yii\base\Model;

class QuizForm extends Model
{
    public $answers = [];
    public $user_id;
    public $template_id;

    public function rules()
    {
        return [
            [['answers', 'user_id', 'template_id'], 'safe'],
        ];
    }
    public function checkAnswer(){
        $score = 0;
        foreach ($this->answers as $answer_id){
            $answer = Answer::findOne(['id'=>$answer_id]);
            if($answer->is_correct == 1){
                $score ++;
            }
        }
        return $score;
    }
    public function save($score){
        $result = new Result();
        $result->user_id = $this->user_id;
        $result->template_id = $this->template_id;
        $result->score = $score;
        return $result->save();
    }
}
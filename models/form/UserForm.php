<?php

namespace app\models\form;

use app\models\User;
use Yii;
use yii\base\Model;

class UserForm extends Model
{
    public $id;
    public $username;
    public $password;

    public $role;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username'], 'string', 'max' => 255],
            ['password', 'string', 'min' => 8, 'message' => 'Mật khẩu ít nhất 8 kí tự'],
            ['password', 'match', 'pattern' => '/[!@#$%^&*(),.?":{}|<>]/', 'message' => 'Mật khẩu bao gồm ít nhất 1 kí tự đặc biệt.'],
            //            [['firstName', 'lastName'], 'string', 'max' => 255],
            //            [['phoneNum'], 'string', 'max' => 10],
            [['role'], 'string']
        ];
    }

    public function save($user)
    {
        if ($this->role == '') {
            $this->role = 'user';
        }
        if ($this->validate()) {
            //            $user = new User();
            $user->username = $this->username;
            $user->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
            //            $user->created_at = time();
            //            $user->created_by = Yii::$app->user->identity->username;
            //$user->password = $this->password;
            $user->role = $this->role;

            $rs = $user->save();
            $auth = Yii::$app->authManager;
            $this->id = $user->id;
//            var_dump($user);
//            var_dump($this);
//            die();
            //            return $rs;
            // var_dump($rs);
            if ($rs) {
                return true;
            }
        }
        return false;
    }
}

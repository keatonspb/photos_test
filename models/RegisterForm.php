<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class RegisterForm extends Model
{
    public $email;
    public $password;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['email', 'email'],
            [['email', 'password'], 'required'],
            [['email'], 'unique', 'targetClass' => User::class, 'message' => "Пользователь с таким email уже существует"],
        ];
    }


    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     * @throws \yii\base\Exception
     */
    public function register()
    {
        if ($this->validate()) {
            $User = new User();
            $User->email = $this->email;
            $User->setPassword($this->password);
            $User->save();
            return Yii::$app->user->login($User);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }
}

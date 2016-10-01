<?php

namespace app\models\Form;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $userid;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['userid', 'password'], 'required'],
            [['userid'], 'integer','min' => '100000', 'max' => '10000000000'],
            [['password'], 'string','min' => '6', 'max' => '12'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            Yii::trace($this->password);
            if (!$user || !$this->checkPassword($this->password)) {
                $this->addError($attribute, '请检查工号/学号和密码');
            }
        }
    }
    
    public function checkPassword($password)
    {
        if($password != NULL){
            $model = $this->getUser();
            if(md5($password) == $model->user_password){
                 return true;
            }else{
                return false;
            } 
        }else{
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userid' => '学号/工号',
            'password' => '密码',
            'rememberMe' => '记住我'
        ];
    }
    
    
    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
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
            $this->_user = User::findIdentity($this->userid);
        }

        return $this->_user;
    }
}

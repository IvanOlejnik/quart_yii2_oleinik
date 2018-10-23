<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;
use common\models\Resources;
use common\models\UserResources;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $firstname;
    public $lastname;
   // public $avatar_image;
    public $password;
    public $password_repeat;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['firstname', 'trim'],
            ['firstname', 'required'],
            ['firstname', 'string', 'max' => 255],

            ['lastname', 'trim'],
            ['lastname', 'required'],
            ['lastname', 'string', 'max' => 255],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            
            ['password_repeat', 'required'],
            ['password_repeat', 'string', 'min' => 6],
            ['password_repeat', 'validatePasswordRepeat'],
        ];
    }
    
     public function validatePasswordRepeat()
    {
        if(!($this->password === $this->password_repeat)){
            $this->addError('password', 'Passwords must match');
            $this->addError('password_repeat', 'Passwords must match');
        }
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->firstname = $this->firstname;
        $user->lastname = $this->lastname;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        if($save = $user->save()){//;
            $resources = new Resources();
            $resourcArr = $resources->find()->all();
            foreach($resourcArr as $resoueVal){
                $userResources = new UserResources();
                $userResources->user_id = $user->id;
                $userResources->resources_id = $resoueVal->id;
/*подразумевается что мы уже знаем какие будут ресурсы и указать конкретное значение конкренному ресурсу ,
без кода "привязанного" к ресурсам не получается т.к. по умолчанию задается значение для всех строк разом
без разбора где какой ресурс например - в столбце count в таблице UserResources по умолачанию 100 ед ресурсов.*/  
                if($resoueVal->name == "experience") {
                    $userResources->count = 0;
                }elseif($resoueVal->name == "rocks") {
                    $userResources->count = 200;
                }elseif($resoueVal->name == "premium coins") {
                    $userResources->count = 50;
                }else{
                    $userResources->count = 80;
                }   
                $userResources->save();
            }
        }
        
        return $save ? $user : null;
    }
}

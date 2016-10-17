<?php
namespace app\models;

use suver\notifications\Notifications;
use yii\base\Model;
use app\modules\users\models\User;
use yii\helpers\Url;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\modules\users\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\modules\users\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
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
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generatePasswordResetToken();

        if($user->save()) {

            $auth = \Yii::$app->authManager;
            $role = $auth->getRole(\app\models\User::DEFAULT_ROLE);
            $auth->assign($role, $user->id);

            $params = [
                'checkLink' => Url::to(['/site/check-email', 'token'=>$user->password_reset_token], true),
            ];
            Notifications::get('user-registration-check-email', $user->id)->setParams($params)->setChannel('email')->send();

            $admins = \Yii::$app->authManager->getUserIdsByRole('admin');
            if($admins) {
                foreach ($admins as $adminId) {
                    $params = [
                        'userName' => $user->username,
                    ];
                    Notifications::get('user-new-registration', $adminId)->setParams($params)->setChannel('email')->holdOver();
                }
            }

            return $user;
        }
        else {
            return null;
        }
    }
}

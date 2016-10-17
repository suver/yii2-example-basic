<?php

namespace app\models;

use suver\notifications\Notifications;
use Yii;
use yii\base\Model;

/**
 * SendForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class SendForm extends Model
{
    public $username;
    public $role;
    public $subject;
    public $message;
    public $notify;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['subject', 'message'], 'required'],
            [['username', 'role'], 'string'],
            ['notify', 'each', 'rule' => ['string']],
        ];
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function send()
    {
        if($this->role) {
            $ids = Yii::$app->authManager->getUserIdsByRole($this->username);
            $users = User::find()->andWhere(['id' => $ids])->all();
        }
        else {
            $users = User::find()->andWhere(['username' => $this->username])->all();
        }

        if(!$this->notify) {
            $this->notify = ['email', 'flash-notifications'];
        }

        foreach($users as $user) {
            foreach ($this->notify as $channel) {
                Notifications::getInstance($user->id)
                    ->setMessage($this->message)
                    ->setSubject($this->subject)
                    ->setChannel($channel)
                    ->holdOver();
            }
        }

    }
}

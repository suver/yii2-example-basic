<?php

namespace app\models;

use app\modules\users\models\UserNotificationsSettings;
use suver\notifications\Notifications;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class ProfileForm extends User
{
    public $password_repeat;

    public $notify;

    public function afterFind()
    {
        parent::afterFind();
        $this->notify = $this->getNotificationChannels();

    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Пароли не совпали"];
        $rules[] = ['notify', 'each', 'rule' => ['string']];
        return $rules;
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['password_repeat'] = Yii::t('app', 'Повторить пароль');
        $labels['notify'] = Yii::t('app', 'Уведомления');
        return $labels;
    }

    public function notifySave() {
        if($this->notify) {
            foreach ($this->notify as $item) {
                $nU = UserNotificationsSettings::find()->andWhere(['user_id' => Yii::$app->user->getId()])->one();
                if(!$nU) {
                    $nU = new UserNotificationsSettings;
                    $nU->user_id = Yii::$app->user->getId();
                }

                if(in_array('email', $this->notify)) {
                    $nU->email = 1;
                }
                else {
                    $nU->email = 0;
                }

                if(in_array('flash-notifications', $this->notify)) {
                    $nU->flash = 1;
                }
                else {
                    $nU->flash = 0;
                }

                $nU->save();
            }
        }
    }

    public function changePassword()
    {
        if(!empty($this->password_repeat)) {
            $this->setPassword($this->password);
            $this->generateAuthKey();
            if($this->save(false)) {
                $params = ['password' => $this->password];
                Notifications::get('user-change-password', $this->id)->setParams($params)->setChannel('email')->send();
                return true;
            }
            else {
                return false;
            }
        }
        return true;
    }
}

<?php

namespace app\modules\users\models;

use Yii;

/**
 * This is the model class for table "{{%user_notifications_settings}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $email
 * @property integer $flash
 */
class UserNotificationsSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_notifications_settings}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'email', 'flash'], 'required'],
            [['user_id', 'email', 'flash'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'email' => Yii::t('app', 'Email'),
            'flash' => Yii::t('app', 'Flash'),
        ];
    }

    /**
     * @inheritdoc
     * @return \app\modules\users\models\query\UserNotificationsSettingsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\users\models\query\UserNotificationsSettingsQuery(get_called_class());
    }
}

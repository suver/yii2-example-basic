<?php

namespace app\modules\users\models\query;

/**
 * This is the ActiveQuery class for [[\app\modules\users\models\UserNotificationsSettings]].
 *
 * @see \app\modules\users\models\UserNotificationsSettings
 */
class UserNotificationsSettingsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \app\modules\users\models\UserNotificationsSettings[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\modules\users\models\UserNotificationsSettings|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

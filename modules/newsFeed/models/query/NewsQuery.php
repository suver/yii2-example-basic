<?php

namespace app\modules\newsFeed\models\query;

/**
 * This is the ActiveQuery class for [[\app\modules\newsFeed\models\News]].
 *
 * @see \app\modules\newsFeed\models\News
 */
class NewsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \app\modules\newsFeed\models\News[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\modules\newsFeed\models\News|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

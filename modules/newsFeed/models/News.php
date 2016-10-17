<?php

namespace app\modules\newsFeed\models;

use app\modules\users\models\User;
use suver\behavior\upload\UploadBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "{{%news_feed}}".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property string $body
 * @property string $params
 * @property integer $created_by
 * @property string $created_at
 * @property string $updated_at
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news_feed}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => UploadBehavior::className(),
                'attribute' => 'cover',
                'thumbnail' => [
                    'small' => ['size' => '128x128', 'prefix' => 'v1'],
                    'medium' => ['size' => '256x256', 'prefix' => 'v1'],
                    'big' => ['size' => '512x512', 'prefix' => 'v1'],
                    'very_big' => ['size' => '1024x1024', 'prefix' => 'v1'],
                    'narrow' => ['size' => '256', 'prefix' => 'v1'],
                    'wide' => ['size' => 'x256', 'prefix' => 'v1'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug', 'title', 'created_by'], 'required'],
            [['description', 'body', 'params'], 'string'],
            [['created_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['slug', 'title'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            ['cover', 'file', 'extensions' => ['jpg','png','gif'], 'maxSize' => 100*1024*1024, 'maxFiles' => 1,]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'slug' => Yii::t('app', 'URL индентификатор новости'),
            'title' => Yii::t('app', 'Заголовок'),
            'description' => Yii::t('app', 'Описание'),
            'body' => Yii::t('app', 'Текст новости'),
            'params' => Yii::t('app', 'Параметры'),
            'cover' => Yii::t('app', 'Обложка'),
            'created_by' => Yii::t('app', 'Создал'),
            'created_at' => Yii::t('app', 'Создано'),
            'updated_at' => Yii::t('app', 'Обновлено'),
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)) {

            if(!Yii::$app->user->isGuest && $this->isNewRecord) {
                $this->created_by = Yii::$app->user->getId();
            }

            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     * @return \app\modules\newsFeed\models\query\NewsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\newsFeed\models\query\NewsQuery(get_called_class());
    }

    /**
     * Relation with News
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
}

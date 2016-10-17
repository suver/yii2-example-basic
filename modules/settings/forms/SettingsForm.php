<?php
namespace app\modules\settings\forms;

use suver\settings\Settings;
use \Yii;
use suver\behavior\upload\UploadBehavior;

/**
 * Class SettingsForm
 * @package backend\modules\settings\forms
 *
 * @mixin UploadBehavior
 */
class SettingsForm extends \yii\base\Model
{
    public $siteName;
    //public $siteLogo;

    public function behaviors()
    {
        return [
        ];
    }

    public function init()
    {
        parent::init();

        $this->siteName = Settings::get('site-name')->configure(Settings::TYPE_VARCHAR)->value(Yii::t('app', 'Site Name'));
        //$this->siteLogo = Settings::get('site-logo')->configure(Settings::TYPE_FILE)->value('');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['siteName'], 'required'],
            [['siteName'], 'string', 'max' => 255],
            //['logoFile', 'file', 'extensions' => ['jpg','png','gif'], 'maxSize' => 10*1024*1024, 'maxFiles' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'logo' => Yii::t('app', 'Логотип'),
            'siteNmae' => Yii::t('app', 'Название сайта'),
            //'logoFile' => Yii::t('common', 'Логотип'),
        ];
    }

    public function save()
    {
        //$this->siteLogo = $this->linkedFile('siteLogo')->thumbnail('logo')->getDomainPath();
        Settings::get('site-name')->configure(Settings::TYPE_VARCHAR)->set($this->siteName);
        //Settings::get('site-logo')->configure(Settings::TYPE_FILE)->set($this->siteLogo);
    }

}

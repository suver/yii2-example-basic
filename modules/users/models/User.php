<?php
namespace app\modules\users\models;

use app\modules\users\models\query\UserQuery;
use suver\behavior\upload\UploadBehavior;
use suver\notifications\UserNotificationsInterface;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface, UserInterface, UserNotificationsInterface
{
    const STATUS_DELETED = 0;
    const STATUS_BLOCKED = 5;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    const DEFAULT_ROLE = 'user';

    public $password;
    public $role;

    protected static $status = [];

    public function init() {
        self::$status = [
            self::STATUS_ACTIVE => Yii::t('app', 'Активен'),
            self::STATUS_INACTIVE => Yii::t('app', 'Не активен'),
            self::STATUS_BLOCKED => Yii::t('app', 'Заблокирован'),
            self::STATUS_DELETED => Yii::t('app', 'Удален'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
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
                'attribute' => 'avatar',
                'thumbnail' => [
                    'small' => ['size' => '100x100', 'prefix' => 'v1'],
                    'medium' => ['size' => '250x250', 'prefix' => 'v1'],
                    'big' => ['size' => '500x500', 'prefix' => 'v1'],
                    'narrow' => ['size' => '100', 'prefix' => 'v1'],
                    'wide' => ['size' => 'x100', 'prefix' => 'v1'],
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
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => array_keys(self::getStatusList())],
            [['created_at', 'updated_at'], 'safe'],
            [['email','username','first_name','last_name','family_name','phone','password','role'], 'string', 'max' => 255],
            [['description','about'], 'string'],
            ['avatar', 'file', 'extensions' => ['jpg','png','gif'], 'maxSize' => 100*1024*1024, 'maxFiles' => 1, /*'tooBig' => 'Лимит 10Мб', 'tooMany' => '', 'wrongExtension', 'wrongMimeType'*/]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'role' => Yii::t('app', 'Роль пользователя'),
            'password' => Yii::t('app', 'Пароль'),
            'avatar' => Yii::t('app', 'Аватар'),
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'Email'),
            'auth_key' => Yii::t('app', 'Ключ авторизации'),
            'password_hash' => Yii::t('app', 'Hash пароля'),
            'password_reset_token' => Yii::t('app', 'Токен сброса'),
            'status' => Yii::t('app', 'Статус'),
            'fullname' => Yii::t('app', 'Полное имя'),
            'first_name' => Yii::t('app', 'Имя'),
            'last_name' => Yii::t('app', 'Фамилия'),
            'family_name' => Yii::t('app', 'Отчество'),
            'phone' => Yii::t('app', 'Телефон'),
            'description' => Yii::t('app', 'Информация'),
            'about' => Yii::t('app', 'О себе'),
            'updated_at' => Yii::t('app', 'Обновлено'),
            'created_at' => Yii::t('app', 'Создано'),
        ];
    }

    public function getStatusLabel()
    {
        return isset(self::$status[$this->status]) ? self::$status[$this->status] : null;
    }

    public function getFullname()
    {
        return $this->last_name . ' ' . $this->first_name . ' ' . $this->first_name;
    }

    public static function getStatusList() {
        return self::$status;
    }

    public function getNotificationChannels(){
        $channels = [];
        $nU = UserNotificationsSettings::find()->andWhere(['user_id' => Yii::$app->user->getId()])->one();
        if(!$nU) {
            $channels[] = 'email';
            $channels[] = 'flash-notifications';
        }
        else {
            if ($nU->email) $channels[] = 'email';
            if ($nU->flash) $channels[] = 'flash-notifications';
        }

        return $channels;
    }

    public function afterFind()
    {
        parent::afterFind();

        $auth = Yii::$app->authManager;

        $roles = $auth->getRolesByUser($this->id);
        if($roles) {
            $role = key($roles);
            $this->role = $role;
        }

    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);

        $auth = Yii::$app->authManager;

        //$assignments = $auth->getAssignments($this->id);
        $roles = $auth->getRolesByUser($this->id);

        if($roles) {
            $auth->revokeAll($this->id);
        }

        if($this->isNewRecord && empty($this->role)) {
            $role = $auth->getRole(self::DEFAULT_ROLE);
        }
        else if(!empty($this->role)){
            $role = $auth->getRole($this->role);
        }
        else {
            $role = false;
        }
        if($role) {
            $auth->assign($role, $this->id);
        }
    }

    public function afterDelete() {
        parent::afterDelete();
        $auth = Yii::$app->authManager;
        $auth->revokeAll($this->id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE],
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
}

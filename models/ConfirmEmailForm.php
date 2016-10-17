<?php
namespace app\models;

use suver\notifications\Notifications;
use yii\base\Model;
use yii\base\InvalidParamException;
use app\modules\users\models\User;

/**
 * Confirm Email form
 */
class ConfirmEmailForm extends Model
{

    /**
     * @var \app\modules\users\models\User
     */
    private $_user;

    public $password;

    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Password reset token cannot be blank.');
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidParamException('Wrong password reset token.');
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function changePassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();
        return $user->save(false);
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function checkEmail()
    {
        $user = $this->_user;
        $user->status = User::STATUS_ACTIVE;
        $user->removePasswordResetToken();

        $params = [];
        Notifications::get('user-registration-success', $user->id)->setParams($params)->setChannel('email')->send();

        return $user->save(false) ? $user : null;
    }
}

<?php
namespace common\models;

use Yii;
use yii\base\Exception;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $email
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $auth_key
 * @property integer $status
 * @property string $password write-only password
 */
class UserRecord extends \common\base\ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = -2;
    const STATUS_BANNED = -1;
    const STATUS_NEW = 0;
    const STATUS_ACTIVE = 1;

    // readable status after find
    public $statusReadable;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    public function attributeLabels()
    {
        return [
            'statusReadable' => 'Status'
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created',
                'updatedAtAttribute' => 'updated',
                'value' => new Expression('NOW()')
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_NEW],
            [
                'status',
                'in',
                'range' => [
                    self::STATUS_BANNED,
                    self::STATUS_DELETED,
                    self::STATUS_ACTIVE,
                    self::STATUS_NEW
                ]
            ],
            [['email', 'status'], 'safe', 'on' => ['create', 'update']],
            [['password_hash'], 'safe', 'on' => ['passwordUpdate']],
        ];
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
     * Return users list
     */
    public static function getUsers($condition = null)
    {
        return static::find();
    }

    /**
     * Finds user by email
     * @param string $email
     * @param int $status
     * @return UserRecord|null
     */
    public static function findByEmail($email, $status = self::STATUS_ACTIVE)
    {
        return static::findOne([
            'email' => $email,
            'status' => $status
        ]);
    }

    /**
     * Resets attempts of inactive user registrations with the same email
     * @param $email
     * @return bool
     */
    public static function removeTokenByEmail($email)
    {
        $result = static::updateAll([
            'password_reset_token' => null
        ], [
            'email' => $email
        ]);

        return $result >= 0 ? true : false;
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @param int $status user status
     * @return UserRecord|null
     */
    public static function findByPasswordResetToken($token, $status = self::STATUS_ACTIVE)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => $status,
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
        return true;
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
     * Sets users status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Makes user active
     */
    public function setActive()
    {
        $this->setStatus(self::STATUS_ACTIVE);
    }
}

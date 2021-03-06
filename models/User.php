<?php

namespace pantera\YiiYii2User\models;

use pantera\YiiYii2User\Module;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "shop_users".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $activkey
 * @property int $superuser
 * @property int $status
 * @property string $create_at
 * @property string $lastvisit_at
 *
 * @property ShopProfiles $shopProfiles
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    public $password_repeat;

    public static function findIdentity($id)
    {
        return static::findOne($id);
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
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return md5($password) === $this->password;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['activkey' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->activkey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->activkey === $authKey;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        /** @var Module $userModule */
        $userModule = Yii::$app->getModule('user');

        if(!empty($userModule->userTableName)) return $userModule->userTableName;

        throw new InvalidConfigException('Please set a name for user table');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username'], 'string', 'max' => 20],
            [['password', 'email', 'activkey'], 'string', 'max' => 128],
            [['email', 'username'], 'unique'],
            [['superuser', 'status'], 'integer'],
            [['create_at', 'lastvisit_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'activkey' => 'Activkey',
            'superuser' => 'Superuser',
            'status' => 'Status',
            'create_at' => 'Create At',
            'lastvisit_at' => 'Lastvisit At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profiles::className(), ['user_id' => 'id']);
    }
}

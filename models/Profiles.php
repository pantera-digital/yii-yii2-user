<?php

namespace pantera\YiiYii2User\models;

use pantera\YiiYii2User\Module;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "shop_profiles".
 *
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 *
 * @property ShopUsers $user
 */
class Profiles extends \yii\db\ActiveRecord
{
    public $profileFields;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        /** @var Module $userModule */
        $userModule = Yii::$app->getModule('user');

        if(!empty($userModule->profilesTableName)) return $userModule->profilesTableName;

        throw new InvalidConfigException('Please set a name for user table');
    }


    public function init()
    {
        $this->profileFields = ProfilesFields::find()->orderBy('position ASC')->all();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {

        $rules = [
            //[['first_name', 'last_name'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];

        foreach ($this->profileFields as $profileField) {
            switch ($profileField->field_type) {
                case 'INTEGER':
                    $type = 'integer';
                    break;
                case 'VARCHAR':
                    $type = 'string';
                    break;
                default:
                    $type = 'safe';
            }
            $attribute = $profileField->varname;

            $rules[$profileField->id] = [[$attribute], $type];

            if ($profileField->field_size > 0) {
                if ($type != 'integer') {
                    $rules[$profileField->id]['max'] = $profileField->field_size;
                }
            }

            if ($profileField->required) {
                $rules[] = [[$profileField->varname], 'required'];
            }
        }

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [
            'user_id' => 'User ID',
        ];
        foreach ($this->profileFields as $profileField) {
            $labels[$profileField->varname] = $profileField->title;
        }
        return $labels;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}

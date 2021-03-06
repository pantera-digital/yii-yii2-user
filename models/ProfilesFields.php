<?php

namespace pantera\YiiYii2User\models;

use pantera\YiiYii2User\Module;
use Yii;
use yii\base\InvalidConfigException;

/**
 * This is the model class for table "shop_profiles_fields".
 *
 * @property int $id
 * @property string $varname
 * @property string $title
 * @property string $field_type
 * @property int $field_size
 * @property int $field_size_min
 * @property int $required
 * @property string $match
 * @property string $range
 * @property string $error_message
 * @property string $other_validator
 * @property string $default
 * @property string $widget
 * @property string $widgetparams
 * @property int $position
 * @property int $visible
 */
class ProfilesFields extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        /** @var Module $userModule */
        $userModule = Yii::$app->getModule('user');

        if(!empty($userModule->profilesFieldsTableName)) return $userModule->profilesFieldsTableName;

        throw new InvalidConfigException('Please set a name for user table');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['field_size', 'field_size_min', 'required', 'position', 'visible'], 'integer'],
            [['other_validator', 'widgetparams'], 'string'],
            [['varname', 'field_type'], 'string', 'max' => 50],
            [['title', 'match', 'range', 'error_message', 'default', 'widget'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'varname' => 'Varname',
            'title' => 'Title',
            'field_type' => 'Field Type',
            'field_size' => 'Field Size',
            'field_size_min' => 'Field Size Min',
            'required' => 'Required',
            'match' => 'Match',
            'range' => 'Range',
            'error_message' => 'Error Message',
            'other_validator' => 'Other Validator',
            'default' => 'Default',
            'widget' => 'Widget',
            'widgetparams' => 'Widgetparams',
            'position' => 'Position',
            'visible' => 'Visible',
        ];
    }
}

<?php
namespace pantera\YiiYii2User\models;

use yii\base\Model;

class ResetPasswordForm extends Model
{
    public $email;
    public $user;

    public function rules()
    {
        return [
            [['email'], 'email'],
            [['email'], 'required'],
        ];
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        if (parent::validate($attributeNames, $clearErrors)) {
            $user = User::findOne(['email' => $this->email]);
            if (empty($user)) {
                $this->addError('email', 'User with this email not found');
                return false;
            } else {
                $this->user = $user;
            }
            return true;
        } else {
            return false;
        } // TODO: Change the autogenerated stub
    }
}

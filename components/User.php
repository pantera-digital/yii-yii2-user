<?php
namespace maxcom\user\components;

use yii\base\Component;

class User extends \yii\web\User
{

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    public function afterLogin($identity, $cookieBased, $duration)
    {
        parent::afterLogin($identity, $cookieBased, $duration); // TODO: Change the autogenerated stub
        $identity->lastvisit_at = date('Y-m-d h:i:s');
        $identity->save();
    }

    public function afterLogout($identity)
    {
        parent::afterLogout($identity); // TODO: Change the autogenerated stub
        $identity->lastvisit_at = date('Y-m-d h:i:s');
        $identity->save();
    }
}
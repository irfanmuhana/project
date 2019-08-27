<?php

namespace app\models;
use app\models\Users; //mendefinisikan model class Users yang telah dibuat
class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $user_id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;
    public $role;

    /*
    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];
    */

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($user_id)
    {
        //return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
        
        //mencari users berdasarkan ID-nya dan hanya dicari 1.
        $user = Users::findOne($user_id);
        if(count($user)){
            return new static($user);
        }
    return null;
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        //foreach (self::$users as $user) {
    //mencari user berdasarkan accessToken dan hanya dicari 1.
        $user = Users::find()->where(['accessToken'=>$token])->one();
        //if ($user['accessToken'] === $token) {
        if(count($user)){
                return new static($user);
            }
        //}

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        //foreach (self::$users as $user) {
    //mencari user login berdasarkn username dan hanya dicari 1.
            $user = Users::find()->where(['username'=>$username])->one();
            //if (strcasecmp($user['username'], $username) === 0) {
              if(count($user)){  
                return new static($user);
            }
        //}

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        //return $this->id;
        return $this->user_id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}

<?php

use common\models\User;
use yii\db\Migration;

/**
 * Class m230409_154732_admin
 */
class m230409_154732_admin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $users = [
            [
                'username' => 'administrator',
                'email' => 'admin@mail.ru'
            ], [
                'username' => 'ivan',
                'email' => 'ivan@mail.ru'
            ], [
                'username' => 'aleksey',
                'email' => 'aleksey@mail.ru'
            ], [
                'username' => 'artyom',
                'email' => 'artyomn@mail.ru'
            ], [
                'username' => 'masha',
                'email' => 'masha@mail.ru'
            ], [
                'username' => 'lena',
                'email' => 'lena@mail.ru'
            ],  [
                'username' => 'sasha',
                'email' => 'sasha@mail.ru'
            ], [
                'username' => 'katya',
                'email' => 'katya@mail.ru'
            ], [
                'username' => 'pavel',
                'email' => 'pavel@mail.ru'
            ], [
                'username' => 'elena',
                'email' => 'elena@mail.ru'
            ],
        ];

        $password = '123456789';
        foreach ($users as $key=>$item) {
           $user =  (new \yii\db\Query())
                ->select(['id'])
                ->from('user')
                ->where(['=', 'email',$item['email']])
                ->one();


            if ($user) {
                continue;
            }
            $user = new User();
            $user->email = $item['email'];
            $user->username = $item['username'];
            $user->status = User::STATUS_ACTIVE;
            $user->setPassword($password);
            $user->generateAuthKey();

            $user = $user->save();

        }

        $user =  (new \yii\db\Query())
            ->select(['id'])
            ->from('user')
            ->where(['=', 'username', 'administrator'])
            ->one();
        if ($user) {
            $auth = Yii::$app->authManager;
            $admin = $auth->getRole('admin');
            // Задаем пользователю с id=1 роль администратора
            $auth->assign($admin, $user['id']);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230409_154732_admin cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230409_154732_admin cannot be reverted.\n";

        return false;
    }
    */
}

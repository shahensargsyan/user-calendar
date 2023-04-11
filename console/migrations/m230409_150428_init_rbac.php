<?php

use yii\db\Migration;

/**
 * Class m230409_150428_init_rbac
 */
class m230409_150428_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230409_150428_init_rbac cannot be reverted.\n";

        return false;
    }

    public function up()
    {
        $auth = Yii::$app->authManager;

        // добавить роль «admin» и даем этой роли разрешение «updatePost»
        // а также все права роли «author»
        $admin = $auth->createRole('admin');
        $auth->add($admin);
    }

    public function down()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();
    }
}

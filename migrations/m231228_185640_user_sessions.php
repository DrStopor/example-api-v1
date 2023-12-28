<?php

use yii\db\Migration;

/**
 * Class m231228_185640_user_sessions
 */
class m231228_185640_user_sessions extends Migration
{
    private string $tableName = 'users_sessions';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'user_id' => $this->integer()->notNull()->unique()->comment('FK ID пользователя'),
            'access_token' => $this->string()->notNull()->comment('Токен'),
        ]);

        $this->addCommentOnTable($this->tableName, 'Сессии пользователей');

        $this->addForeignKey(
            'fk-users_sessions-user_id',
            $this->tableName,
            'user_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->createIndex('idx-users_sessions-user_id', $this->tableName, 'user_id');
        $this->createIndex('idx-users_sessions-access_token', $this->tableName, 'access_token');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-users_sessions-user_id', $this->tableName);
        $this->dropIndex('idx-users_sessions-access_token', $this->tableName);

        $this->dropForeignKey(
            'fk-users_sessions-user_id',
            $this->tableName
        );

        $this->dropTable($this->tableName);
    }
}

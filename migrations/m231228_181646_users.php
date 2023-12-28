<?php

use yii\db\Migration;

/**
 * Class m231228_181646_users
 */
class m231228_181646_users extends Migration
{
    private string $tableName = 'users';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'pk_user_id' => $this->primaryKey()->comment('Первичный ключ'),
            'id' => $this->integer()->notNull()->unique()->comment('Идентификатор пользователя'),
            'first_name' => $this->string()->notNull()->comment('Имя пользователя'),
            'last_name' => $this->string()->notNull()->comment('Фамилия пользователя'),
            'city' => $this->string()->notNull()->comment('Город'),
            'country' => $this->string()->notNull()->comment('Страна'),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->comment('Дата создания записи'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')->comment('Дата обновления записи'),
        ]);

        $this->addCommentOnTable($this->tableName, 'Пользователи');

        $this->createIndex('idx-user-id', $this->tableName, 'id');
        $this->createIndex('idx-user-first_name', $this->tableName, 'first_name');
        $this->createIndex('idx-user-last_name', $this->tableName, 'last_name');
        $this->createIndex('idx-user-city', $this->tableName, 'city');
        $this->createIndex('idx-user-country', $this->tableName, 'country');
        $this->createIndex('idx-user-created_at', $this->tableName, 'created_at');
        $this->createIndex('idx-user-updated_at', $this->tableName, 'updated_at');
        $this->createIndex('idx-first_name-last_name', $this->tableName, ['first_name', 'last_name']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-user-id', $this->tableName);
        $this->dropIndex('idx-user-first_name', $this->tableName);
        $this->dropIndex('idx-user-last_name', $this->tableName);
        $this->dropIndex('idx-user-city', $this->tableName);
        $this->dropIndex('idx-user-country', $this->tableName);
        $this->dropIndex('idx-user-created_at', $this->tableName);
        $this->dropIndex('idx-user-updated_at', $this->tableName);
        $this->dropIndex('idx-first_name-last_name', $this->tableName);

        $this->dropTable($this->tableName);
    }
}

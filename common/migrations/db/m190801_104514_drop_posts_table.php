<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `posts`.
 */
class m190801_104514_drop_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('posts');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('posts', [
            'id' => $this->primaryKey(),
            'post_title' => $this->string(45)->notNull(),
            'post_description' => $this->string(300),
            'post_image' => $this->string(30),
            'user_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-posts-user_id}}',
            '{{%posts}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-posts-user_id}}',
            '{{%posts}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }
}

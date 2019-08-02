<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `comments`.
 */
class m190801_110427_drop_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('comments');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('comments', [
            'id' => $this->primaryKey(),
        ]);
    }
}

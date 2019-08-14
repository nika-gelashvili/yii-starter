<?php

use yii\db\Migration;

/**
 * Handles the creation of table `domain`.
 */
class m190813_093411_create_domain_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('domain', [
            'id' => $this->primaryKey(),
            'ip' => $this->string(21)->notNull(),
            'region' => $this->string(10),
            'region_json' => $this->string(1500),
            'server' => $this->string(50),
            'latest_full_headers' => $this->string(1500),
            'secure' => $this->string(50),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('domain');
    }
}

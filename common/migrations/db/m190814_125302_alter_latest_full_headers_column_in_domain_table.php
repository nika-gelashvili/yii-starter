<?php

use yii\db\Migration;

/**
 * Class m190814_125302_alter_latest_full_headers_column_in_domain_table
 */
class m190814_125302_alter_latest_full_headers_column_in_domain_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('domain', 'latest_full_headers', $this->string(3000));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('domain', 'latest_full_headers', $this->string(1500));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190814_125302_alter_latest_full_headers_column_in_domain_table cannot be reverted.\n";

        return false;
    }
    */
}

<?php

use yii\db\Migration;

/**
 * Class m190814_124603_alter_region_column_in_domain_table
 */
class m190814_124603_alter_region_column_in_domain_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('domain', 'region', $this->string(20));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('domain', 'region', $this->string(10));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190814_124603_alter_region_column_in_domain_table cannot be reverted.\n";

        return false;
    }
    */
}

<?php

use yii\db\Migration;

/**
 * Handles adding domain_name to table `domain`.
 */
class m190814_114054_add_domain_name_column_to_domain_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('domain', 'domain_name', $this->string(30));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('domain', 'domain_name');
    }
}

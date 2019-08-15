<?php

use yii\db\Migration;

/**
 * Handles the creation of table `google_analytics`.
 * Has foreign keys to the tables:
 *
 * - `domain`
 */
class m190815_143359_create_google_analytics_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('google_analytics', [
            'id' => $this->primaryKey(),
            'load_first_contentful_paint' => $this->string(15),
            'load_first_input_delay' => $this->string(15),
            'origin_first_contentful_paint' => $this->string(15),
            'domain_id' => $this->integer()->notNull(),
            'light_first_contentful_paint' => $this->string(10),
            'light_speed_index' => $this->string(10),
            'light_time_to_interactive' => $this->string(10),
            'light_first_cpu_idle' => $this->string(10),
            'light_first_meaningful_paint' => $this->string(10),
            'light_estimated_input_latency' => $this->string(10),
            'captcha' => $this->string(50),
            'kind' => $this->string(50),
            'time' => $this->string(25),
        ]);

        // creates index for column `domain_id`
        $this->createIndex(
            'idx-google_analytics-domain_id',
            'google_analytics',
            'domain_id'
        );

        // add foreign key for table `domain`
        $this->addForeignKey(
            'fk-google_analytics-domain_id',
            'google_analytics',
            'domain_id',
            'domain',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `domain`
        $this->dropForeignKey(
            'fk-google_analytics-domain_id',
            'google_analytics'
        );

        // drops index for column `domain_id`
        $this->dropIndex(
            'idx-google_analytics-domain_id',
            'google_analytics'
        );

        $this->dropTable('google_analytics');
    }
}

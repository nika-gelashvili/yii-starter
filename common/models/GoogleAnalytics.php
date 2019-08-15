<?php
/**
 * Created by PhpStorm
 * User: nika
 * Date: 15/08/2019
 * Time: 18:38
 */

namespace common\models;

use Yii;

/**
 * This is the model class for table "google_analytics".
 *
 * @property int $id
 * @property string $load_first_contentful_paint
 * @property string $load_first_input_delay
 * @property string $origin_first_contentful_paint
 * @property int $domain_id
 * @property string $light_first_contentful_paint
 * @property string $light_speed_index
 * @property string $light_time_to_interactive
 * @property string $light_first_cpu_idle
 * @property string $light_first_meaningful_paint
 * @property string $light_estimated_input_latency
 * @property string $captcha
 * @property string $kind
 * @property string $time
 *
 * @property Domain $domain
 */
class GoogleAnalytics extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'google_analytics';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['domain_id'], 'required'],
            [['domain_id'], 'integer'],
            [['load_first_contentful_paint', 'load_first_input_delay', 'origin_first_contentful_paint'], 'string', 'max' => 15],
            [['light_first_contentful_paint', 'light_speed_index', 'light_time_to_interactive', 'light_first_cpu_idle', 'light_first_meaningful_paint', 'light_estimated_input_latency'], 'string', 'max' => 10],
            [['captcha', 'kind'], 'string', 'max' => 50],
            [['time'], 'string', 'max' => 25],
            [['domain_id'], 'exist', 'skipOnError' => true, 'targetClass' => Domain::className(), 'targetAttribute' => ['domain_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'load_first_contentful_paint' => 'Load First Contentful Paint',
            'load_first_input_delay' => 'Load First Input Delay',
            'origin_first_contentful_paint' => 'Origin First Contentful Paint',
            'domain_id' => 'Domain ID',
            'light_first_contentful_paint' => 'Light First Contentful Paint',
            'light_speed_index' => 'Light Speed Index',
            'light_time_to_interactive' => 'Light Time To Interactive',
            'light_first_cpu_idle' => 'Light First Cpu Idle',
            'light_first_meaningful_paint' => 'Light First Meaningful Paint',
            'light_estimated_input_latency' => 'Light Estimated Input Latency',
            'captcha' => 'Captcha',
            'kind' => 'Kind',
            'time' => 'Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDomain()
    {
        return $this->hasOne(Domain::className(), ['id' => 'domain_id']);
    }
}
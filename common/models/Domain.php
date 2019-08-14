<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "domain".
 *
 * @property int $id
 * @property string $ip
 * @property string $region
 * @property string $region_json
 * @property string $server
 * @property string $latest_full_headers
 * @property string $secure
 */
class Domain extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'domain';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ip'], 'required'],
            [['ip'], 'string', 'max' => 21],
            [['region'], 'string', 'max' => 20],
            [['region_json', 'latest_full_headers'], 'string', 'max' => 3000],
            [['server', 'secure'], 'string', 'max' => 50],
            [['domain_name'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'Ip',
            'region' => 'Region',
            'region_json' => 'Region Json',
            'server' => 'Server',
            'latest_full_headers' => 'Latest Full Headers',
            'secure' => 'Secure',
            'domain_name' => 'Domain Name',
        ];
    }
}
<?php
/**
 * Created by PhpStorm
 * User: nika
 * Date: 22/08/2019
 * Time: 16:36
 */

use common\models\GoogleAnalytics;

echo json_encode(Yii::$app->db->createCommand('select concat(20*floor(light_estimated_input_latency/20), \'-\' ,20*floor(light_estimated_input_latency/20)+20) as `response delay`, count(*) as domains
from google_analytics
where light_estimated_input_latency <100
group by 1
union
select \'100-500\',count(light_estimated_input_latency) from google_analytics where light_estimated_input_latency between 100 and 1000
group by 1
union
select \'500 +\',count(light_estimated_input_latency) from google_analytics where replace(light_estimated_input_latency,\',\',\'\') >=500;')
    ->queryAll());
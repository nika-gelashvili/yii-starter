<?php
/**
 * Created by PhpStorm
 * User: nika
 * Date: 22/08/2019
 * Time: 14:23
 */

use common\models\GoogleAnalytics;

echo json_encode(GoogleAnalytics::find()
    ->select(['concat(0.5*floor(light_first_contentful_paint/0.5), \'-\' ,0.5*floor(light_first_contentful_paint/0.5)+0.5) as delay , count(*) as domains'])
    ->groupBy('delay')
    ->createCommand()
    ->queryAll());
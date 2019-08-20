<?php
/**
 * Created by PhpStorm
 * User: nika
 * Date: 20/08/2019
 * Time: 13:37
 */

use common\models\Domain;

//try {
//    $regionsData = ;
//} catch (\yii\db\Exception $e) {
//    var_dump($e);
//}
echo(json_encode(Domain::find()->select(['region', 'count(*) as amount'])->groupBy('region')->createCommand()->queryAll()));


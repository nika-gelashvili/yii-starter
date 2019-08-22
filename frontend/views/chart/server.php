<?php
/**
 * Created by PhpStorm
 * User: nika
 * Date: 22/08/2019
 * Time: 19:41
 */

use common\models\Domain;

echo(json_encode(Domain::find()->select(['server', 'count(*) as amount'])->groupBy('server')->createCommand()->queryAll()));
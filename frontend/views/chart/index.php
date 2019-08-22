<?php
/**
 * Created by PhpStorm
 * User: nika
 * Date: 16/08/2019
 * Time: 17:59
 */
/* @var $regionsData \frontend\controllers\ChartController */
\frontend\assets\FrontendAsset::register($this);
?>
<select id="chartOptions">
    <option>Select</option>
    <option>Domains in Region</option>
    <option>Delay</option>
    <option>Response Time</option>
    <option>Server Types</option>
</select>
<canvas id="regionChart" width="400" height="400"></canvas>
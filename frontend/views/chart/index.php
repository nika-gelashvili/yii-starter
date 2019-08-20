<?php
/**
 * Created by PhpStorm
 * User: nika
 * Date: 16/08/2019
 * Time: 17:59
 */
/* @var $regionsData \frontend\controllers\ChartController */
?>

<canvas id="regionChart" width="100%" height="400"></canvas>
<?php
//var_dump($regionsData);

$this->registerJS(/** @lang JavaScript */ "
  $.ajax({
url : 'data',
type : 'POST',
data:{_csrf: yii.getCsrfToken()},
success:function(data){
console.log(data)
},
error: function(data){
console.log(data)
}
});
", \yii\web\View::POS_LOAD);
?>

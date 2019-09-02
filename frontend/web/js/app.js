/**
 *  @author Eugene Terentev <eugene@terentev.net>
 */
import Chart from 'chart.js';

let ctx = $('#regionChart');

let dataChart = null;


$('select').change(function () {
        if ($(this).val() === 'Domains in Region') {
            ajaxData('data', function (data) {
                let array = jsonToArray(data, 'region', 'amount');
                let chartData = {
                    labels: array[0],
                    datasets: [{
                        label: 'Servers in Region',
                        data: array[1],
                        backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(255, 99, 132)'
                    }]
                };
                drawChart(ctx, chartData, 'bar');
            });

        } else if ($(this).val() === 'Delay') {
            ajaxData('delay', function (data) {
                let array = jsonToArray(data, 'delay', 'domains');
                let delay = array[0];
                let domain = array[1];
                let chartData = {
                    labels: delay,
                    datasets: [{
                        label: 'Server Delay',
                        data: domain,
                        backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(255, 99, 132)'
                    }]
                };
                drawChart(ctx, chartData, 'bar');
            });
        } else if ($(this).val() === 'Server Types') {
            ajaxData('server', function (data) {
                let array = jsonToArray(data, 'server', 'amount');
                let server = array[0];
                let amount = array[1];
                let chartData = {
                    labels: server,
                    datasets: [{
                        label: 'Server Type',
                        data: amount,
                        backgroundColor: ['rgb(255,0,0)',
                            'rgb(255,127,0)',
                            'rgb(255,255,0)',
                            'rgb(0,255,0)',
                            'rgb(0,0,255)',
                            'rgb( 39,0,51)',
                            'rgb(139,0,255)',
                            'rgb(110,52,112)',
                            'rgb(118,220,63)',
                            'rgb(27,162,69)',
                            'rgb(125,209,197)',
                            'rgb(157,105,191)',
                            'rgb(113,164,139)',
                            'rgb(137,222,109)',
                            'rgb(94,130,202)',
                            'rgb(67,2,241)',
                            'rgb(115,43,255)',
                            'rgb(64,114,68)',
                            'rgb(202,33,3)',
                        ]
                    }]
                };
                drawChart(ctx, chartData, 'bar');
            });
        } else if ($(this).val() === 'Response Time') {
            ajaxData('response', function (data) {
                let array = jsonToArray(data, 'response delay', 'domains')
                let responseDelay = array[0];
                let domain = array[1];
                let chartData = {
                    labels: responseDelay,
                    datasets: [{
                        data: domain,
                        backgroundColor: ['rgb(255, 0, 0)',
                            'rgb(255, 127, 0)',
                            'rgb(255, 255, 0)',
                            'rgb(0, 255, 0)',
                            'rgb(0, 0, 255)',
                            'rgb( 39, 0, 51)',
                            'rgb(139, 0, 255)',
                        ]
                    }]
                };
                drawChart(ctx, chartData, 'pie')
            });
        } else {
            ctx.hide();
        }
    }
);

function ajaxData(url, returnData) {
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'JSON',
        data: {_csrf: yii.getCsrfToken()},
        success: function (data) {
            returnData(data);
        },
        error: function (data) {
            console.log('error')
        }
    });
}

function jsonToArray(data, keyElement, valueElement) {
    let key = [];
    let value = [];
    for (let i = 0; i < data.length; i++) {
        key.push(data[i][keyElement]);
        value.push(data[i][valueElement]);
    }
    return [key, value];
}

function drawChart(ctx, data, type) {
    if (dataChart !== null) {
        dataChart.destroy();
    }
    dataChart = new Chart(ctx, {
        type: type,
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}
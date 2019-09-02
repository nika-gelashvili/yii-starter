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
                        backgroundColor: chartCollor(array[1].length)
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
                        backgroundColor: chartCollor(domain.length)
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
                        backgroundColor: chartCollor(amount.length)
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
                        backgroundColor: chartCollor(domain.length)
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

function chartCollor(amount) {
    let backgroundColor = [];
    for (let i = 0; i < amount; i++) {
        backgroundColor.push('rgb(' + Math.floor(Math.random() * 255) + ',' + Math.floor(Math.random() * 255) + ',' + Math.floor(Math.random() * 255) + ')');
    }
    return backgroundColor;
}
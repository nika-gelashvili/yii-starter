/**
 *  @author Eugene Terentev <eugene@terentev.net>
 */
import Chart from 'chart.js';

let ctx = document.getElementById('regionChart');
$.ajax({
    url: 'data',
    type: 'POST',
    dataType: 'JSON',
    data: {_csrf: yii.getCsrfToken()},
    success: function (data) {
        let region = [];
        let amount = [];
        for (let i = 0; i < data.length; i++) {
            region.push(data[i].region);
            amount.push(data[i].amount);
        }
        // console.log(number);
        let myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: region,
                datasets: [{
                    label: 'Region Dataset',
                    data: amount,
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    },
    error: function (data) {
        console.log('error')
    }
});
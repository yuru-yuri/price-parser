$(function () {
    'use strict';

    let statistic = $('#test-chart canvas');

    if(statistic.length)
    {
        let chrtJs = new Chart(statistic[0], {
            type: 'line',
            data: {
                labels: ['Lbl1', 'Lbl2', 'Lbl3', 'Lbl4', 'Lbl5',],
                datasets: [{
                    label: 'Label',
                    backgroundColor: '#fff',
                    borderColor: '#dd1',
                    data: [
                        13,
                        44,
                        52,
                        22,
                        12,
                    ],
                }],
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: 'Line Chart'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'index',
                    intersect: false
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        type: 'logarithmic',
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        }
                    }],
                },
            },
        });
    }

});

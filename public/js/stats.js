$(document).ready(function () {
    $.get(url, function (response) {

        var data = {
            bandwidth: {
                labels: [
                    "Лимит",
                    "Использовано"
                ],
                datasets: [{
                    data: [response.bandwidth.limit, response.bandwidth.usage],
                    percent: response.bandwidth.used_percent,
                    backgroundColor: [
                        'rgba(190, 190, 190, 0.3)',
                        'rgba(40 ,167 ,69, 0.5)'
                    ],
                    hoverBackgroundColor: [
                        'rgba(190, 190, 190, 0.4)',
                        'rgba(40 ,167 ,69, 0.6)'
                    ],
                    labels: [response.bandwidth.human_limit, response.bandwidth.human_usage]
                }]
            },
            storage: {
                labels: [
                    "Лимит",
                    "Использовано"
                ],
                datasets: [{
                    data: [response.storage.limit, response.storage.usage],
                    percent: response.storage.used_percent,
                    backgroundColor: [
                        'rgba(190, 190, 190, 0.3)',
                        'rgba(40 ,167 ,69, 0.5)'
                    ],
                    hoverBackgroundColor: [
                        'rgba(190, 190, 190, 0.4)',
                        'rgba(40 ,167 ,69, 0.6)'
                    ],
                    labels: [response.storage.human_limit, response.storage.human_usage]
                }]
            },
            images:{
                labels: [
                    "Лимит",
                    "Использовано"
                ],
                datasets: [{
                    data: [response.images.limit, response.images.usage],
                    percent: response.images.used_percent,
                    backgroundColor: [
                        'rgba(190, 190, 190, 0.3)',
                        'rgba(40 ,167 ,69, 0.5)'
                    ],
                    hoverBackgroundColor: [
                        'rgba(190, 190, 190, 0.4)',
                        'rgba(40 ,167 ,69, 0.6)'
                    ]
                }]
            },
            transformations:{
                labels: [
                    "Лимит",
                    "Использовано"
                ],
                datasets: [{
                    data: [response.transformations.limit, response.transformations.usage],
                    percent: response.transformations.used_percent,
                    backgroundColor: [
                        'rgba(190, 190, 190, 0.3)',
                        'rgba(40 ,167 ,69, 0.5)'
                    ],
                    hoverBackgroundColor: [
                        'rgba(190, 190, 190, 0.4)',
                        'rgba(40 ,167 ,69, 0.6)'
                    ]
                }]
            }
        };


        var arr = [];

        $('canvas').each(function () {
            arr.push($(this).attr('id'));
        });

        arr.forEach(function (el) {
            var chart = new Chart(el, {
                type: 'doughnut',
                data: data[el],
                plugins: [{
                    beforeDraw: function (chart) {
                        var width = chart.chart.width,
                            height = chart.chart.height - chart.legend.height,
                            ctx = chart.chart.ctx;

                        ctx.restore();
                        var fontSize = (height / 114).toFixed(2);
                        ctx.font = fontSize + "em sans-serif";
                        ctx.textBaseline = "middle";

                        var text = data[el].datasets[0].percent + '%',
                            textX = Math.round((width - ctx.measureText(text).width) / 2),
                            textY = height / 2;

                        ctx.fillText(text, textX, textY);
                        ctx.save();
                    }
                }],
                options: {
                    responsive: true,
                    tooltips: {
                        callbacks: {
                            label: function (tooltipItem, data) {
                                if(data.datasets[0].labels !== undefined) {
                                    return label = data.datasets[0].labels[tooltipItem.index];
                                }
                                return label = data.labels[tooltipItem.index];
                            }
                        }
                    },
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                }
            });
        });
    });
});

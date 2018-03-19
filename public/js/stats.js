$(document).ready(function () {
    $.get(url, function (response) {
        var ctx = document.getElementById("bandwidth").getContext('2d');
        var bandwidth = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Лимит', 'Использовано'],
                datasets: [{
                    data: [response.bandwidth.limit, response.bandwidth.usage],
                    backgroundColor: [
                        'rgba(190, 190, 190, 0.3)',
                        'rgba(40 ,167 ,69, 0.5)'
                    ],
                    labels: [response.bandwidth.human_limit, response.bandwidth.human_usage]
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Трафик'
                },
                legend: {
                    position: 'bottom'
                },
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            return label = data.datasets[0].labels[tooltipItem.index];
                        }
                    }
                }
            }

        });
        var xtc = document.getElementById("storage").getContext('2d');
        var storage = new Chart(xtc, {
            type: 'doughnut',
            data: {
                labels: ['Лимит', 'Использовано'],
                datasets: [{
                    data: [response.storage.limit, response.storage.usage],
                    backgroundColor: [
                        'rgba(190, 190, 190, 0.3)',
                        'rgba(40 ,167 ,69, 0.5)'
                    ],
                    labels: [response.storage.human_limit, response.storage.human_usage]
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Место'
                },
                legend: {
                    position: 'bottom'
                },
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            return label = data.datasets[0].labels[tooltipItem.index];
                        }
                    }
                }
            }
        });
        var tcx = document.getElementById("images").getContext('2d');
        var images = new Chart(tcx, {
            type: 'doughnut',
            data: {
                labels: ['Лимит', 'Использовано'],
                datasets: [{
                    data: [response.images.limit, response.images.usage],
                    backgroundColor: [
                        'rgba(190, 190, 190, 0.3)',
                        'rgba(40 ,167 ,69, 0.5)'
                    ]
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Изображения'
                },
                legend: {
                    position: 'bottom'
                }
            }
        });
        var txc = document.getElementById("transformations").getContext('2d');
        var transformations = new Chart(txc, {
            type: 'doughnut',
            data: {
                labels: ['Лимит', 'Использовано'],
                datasets: [{
                    data: [response.transformations.limit, response.transformations.usage],
                    backgroundColor: [
                        'rgba(190, 190, 190, 0.3)',
                        'rgba(40 ,167 ,69, 0.5)'
                    ]
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Трансформации'
                },
                legend: {
                    position: 'bottom'
                }
            }
        });
    });
});
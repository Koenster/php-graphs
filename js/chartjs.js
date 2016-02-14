// Base form - https://github.com/HugoHeneault/Chart.js-PHP/blob/master/chart.js-php.js
var GraphPHPChartJS = new Array();
window.onload = function() {
    var elements = document.querySelectorAll("[data-chart]");
    for (var i in elements) {
        if (i === 'length' || i === 'item') {
            continue;
        }
        var canvas = elements[i];
        var id = canvas.id;
        var ctx = canvas.getContext('2d');
        var htmldata = canvas.dataset;
        var data = JSON.parse(htmldata.chartData);
        var type = htmldata.chartType;
        GraphPHPChartJS[id] = new Chart(ctx)[type](data);
    }
};
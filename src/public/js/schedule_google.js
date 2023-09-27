google.charts.load('current', {'packages':['timeline']});
google.charts.setOnLoadCallback(drawChart);
var summary = Object.values(js_summary);

function drawChart() {
    var container = document.getElementById('timeline');
    var chart = new google.visualization.Timeline(container);
    var dataTable = new google.visualization.DataTable();

    dataTable.addColumn({ type: 'string', id: 'date' });
    dataTable.addColumn({ type: 'string', id: 'type' });
    dataTable.addColumn({ type: 'date', id: 'start' });
    dataTable.addColumn({ type: 'date', id: 'end' });
    arr = [];
    summary.forEach(date => {
        date.forEach(record => {
            arr.push([record[0], record[1], new Date(record[2]), new Date(record[3])]);
        })
    });
    dataTable.addRows(arr);
    var options = {
        timeline: { groupByRowLabel: true }
    };
    chart.draw(dataTable,options);
}
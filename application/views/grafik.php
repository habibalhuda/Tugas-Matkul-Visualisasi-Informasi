<html>

<head>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    // Load the Visualization API and the corechart package.
    google.charts.load('current', {
        'packages': ['corechart']
    });

    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);

    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawChart() {

        // piechart

        var PieChartData = '<?php echo $PieChartData;?>';

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');

        data.addRows(JSON.parse(PieChartData));





        // Set chart options
        var options = {
            'title': '<?php echo $PieChartTitle; ?>',
            'width': 400,
            'height': 300
        };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);

        //line Chart
        var LineChartData = '<?php echo $LineChartData; ?>';
        var line_data = google.visualization.arrayToDataTable(JSON.parse(LineChartData));

        var line_options = {
            title: '<?php echo $LineChartTitle; ?>',
            //curveType: 'function',
            legend: {
                position: 'bottom'
            }
        };

        var line_chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        line_chart.draw(line_data, line_options);



        //bar chart
        var BarChartData = '<?php echo $BarChartData; ?>';
        var Bar_data = google.visualization.arrayToDataTable(JSON.parse(BarChartData));
        var Bar_options = {
            width: 800,
            chart: {
                title: '<?php echo $BarChartTitle; ?>',
                subtitle: 'distance on the left, brightness on the right'
            },
            bars: 'horizontal', // Required for Material Bar Charts.
            series: {
                0: {
                    axis: 'distance'
                }, // Bind series 0 to an axis named 'distance'.
                1: {
                    axis: 'brightness'
                } // Bind series 1 to an axis named 'brightness'.
            },
            axes: {
                x: {
                    distance: {
                        label: 'parsecs'
                    }, // Bottom x-axis.
                    brightness: {
                        side: 'top',
                        label: 'apparent magnitude'
                    } // Top x-axis.
                }
            }
        };

        var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
        chart.draw(Bar_data, Bar_options);

        // Column Chart'
        var ColumnChart = '<?php echo $ColumnChartData ?>';
        var data = google.visualization.arrayToDataTable(JSON.parse(ColumnChart));

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
            {
                calc: "stringify",
                sourceColumn: 1,
                type: "string",
                role: "annotation"
            },
            2
        ]);

        var options = {
            title: '<?php echo $ColumnChartTitle; ?>',
            width: 600,
            height: 400,
            bar: {
                groupWidth: "95%"
            },
            legend: {
                position: "none"
            },
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
        chart.draw(view, options);

    }
    </script>
</head>

<body>
    <h3>
        Data Penjualan Produk dari Bisnis Thrifitng
    </h3>

    <!--Div that will hold the pie chart-->
    <div id="chart_div"></div>
    <div id="curve_chart"></div>
    <div id='barchart_values'></div>
    <div id='columnchart_values'></div>
</body>

</html>
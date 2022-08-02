<html>
  <head>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {
        var grafik_data='<?php echo $grafik_data;?>'
        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows(JSON.parse(grafik_data)); 

        

        // Set chart options
        var options = {'title':'<?php echo $title;?>',
                       'width':400,
                       'height':300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }

      var ar=[1,2,3,4,5,6,7];
      for(var i=0; i<ar.length; i++)
      {
        console.log('Item: '+ar[i]);
      }

      var obj={
        nama:'Hasan'
      }

      console.log(obj);
    </script>
  </head>

  <body>
    
      <?php echo $grafik_data;?>
    
    
    <!--Div that will hold the pie chart-->
    <div id="chart_div"></div>
  </body>
</html>
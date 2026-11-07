<?php
/********************************************************
Copyright © 2023 Engr. Dom Sahagun. All rights reserved.
********************************************************/
include_once("../includes/constants.php");	  // Page constants
require_once(absolutedir."config/connect.php"); // Connect to the database and table
include_once(absolutedir."includes/function.class.php");
require_once(absolutedir."config/settings.php");
require_once(absolutedir."query/market.updates.php");
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
  <title>Market Updates</title>
  <meta charset="utf-8"/>
  <link rel="stylesheet" href="bootstrap.css"/>
  <link rel="stylesheet" href="bootstrap.theme.min.css"/>
  <link rel="stylesheet" href="css/font.awesome.min.css"/>

  <!-- Google fonts -->
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="custom.css"/>
  <style>
  #market-updates {
    min-height: 400px !important;
  }
  .highcharts-credits {
    display: none !important;
  }
  </style>

</head>
<body style="overflow: hidden !important;">
  <div id="market-update"></div>

  <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

  <script src="highcharts.js"></script>
  <script src="highcharts-3d.js"></script>
  <script src="series-label.js"></script>
  <script src="accessibility.js"></script>

  <script>
  $(function(){

    var chart;

    chart = new Highcharts.Chart({
      chart: {
        renderTo: "market-update",
        marginRight: 20,
        marginLeft: 70,
        marginTop: 100,
        marginBottom: 100,
        reflow: true
      },
      title: {
        text: null,
        x: -20 // Center
      },
      subtitle: {
        text: null,
        x: -20
      },
      xAxis: {
        categories: [<?php echo $performance_category; ?>],
        labels: {
          style: {
            font: "15px DM Sans"
          }
        }
      },
      yAxis: {
        title: {
          text: null,
          align: "high"
        },
        plotLines: [{
          value: 0,
          width: 1,
          color: "#2B2C3F"
        }],
        min: 0,
        labels: {
          style: {
            font: "15px DM Sans"
          }
        }
      },
      tooltip: {
        formatter: function() {
          var s;
          if(this.point.name) {
            s = this.point.name+": <b>"+Highcharts.numberFormat(this.y,0)+"</b>";
          } else {
            s = this.series.name+": <b>"+Highcharts.numberFormat(this.y,0)+"</b>";
          }
          return s;
        },
        style: {
          font: "15px DM Sans"
        }
      },
      series: [{
        type: 'column',
        color : '#2B2C3F',
        name: 'Sales Volume',
        showInLegend: false,
        data: [<?php echo $performance_value; ?>]
      }]
    });
  });
  </script>

</body>
</html>
<?php
// Close database connection
$conn->close();
?>

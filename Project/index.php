<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>

    <script type="text/javascript">

    google.load("visualization", "1", {packages:["corechart",'controls']});
    google.setOnLoadCallback(drawChart);
      
    function drawChart() {
      var jsonData = $.ajax({
          url: "Total_Violations.php",
          dataType: "json",
          async: false
          }).responseText;
        var jsonData1 = $.ajax({
          url: "Avg_Scores.php",
          dataType: "json",
          async: false
          }).responseText;
        var jsonData2 = $.ajax({
          url: "Range_Violations.php",
          dataType: "json",
          async: false
          }).responseText; 
      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(jsonData);
      console.log(data);
      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
      chart.draw(data, {width: 400, height: 240});

      var data1 = new google.visualization.DataTable(jsonData1);
      var dashboard1 = new google.visualization.Dashboard(
      document.getElementById('dashboard_div1'));
      // Instantiate and draw our chart, passing in some options.
      //var chart = new google.visualization.BarChart(document.getElementById('chart_div2'));
      //var chart2 = new google.visualization.BarChart(document.getElementById('chart_div2_B'));
      var score = new google.visualization.ControlWrapper({
          'controlType': 'CategoryFilter',
          'containerId': 'filter1_div',
          'options': {
            'filterColumnLabel': 'Range of Score'
          }
        });
       var chart1 = new google.visualization.ChartWrapper({
      'chartType': 'ColumnChart',
      'containerId': 'chart_div1',
      'options': {
      'width': 300,
      'height': 300
    }
  });
       dashboard1.bind(score,chart1);
       dashboard1.draw(data1, {width: 400, height: 240});

      var data2 = new google.visualization.DataTable(jsonData2);
      var dashboard2 = new google.visualization.Dashboard(
      document.getElementById('dashboard_div2'));
      // Instantiate and draw our chart, passing in some options.
      //var chart = new google.visualization.BarChart(document.getElementById('chart_div2'));
      //var chart2 = new google.visualization.BarChart(document.getElementById('chart_div2_B'));
      var score2 = new google.visualization.ControlWrapper({
          'controlType': 'CategoryFilter',
          'containerId': 'filter2_div',
          'options': {
            'filterColumnLabel': 'Violation Count'
          }
        });
       var chart2 = new google.visualization.ChartWrapper({
      'chartType': 'ColumnChart',
      'containerId': 'chart_div2',
      'options': {
      'width': 300,
      'height': 300
    }
  });
       dashboard2.bind(score2,chart2);
       dashboard2.draw(data2, {width: 400, height: 240});
      // var data2 = new google.visualization.DataTable(jsonData2);
      // console.log(data2);
      // // Instantiate and draw our chart, passing in some options.
      // var chart2 = new google.visualization.BarChart(document.getElementById('chart_div2'));
      // chart2.draw(data2, {width: 400, height: 240});
    }
    </script>


<link
    href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css"
    rel="stylesheet" type="text/css">
<link href="index.css" rel="stylesheet" type="text/css">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="https://cdn.datatables.net/1.10.10/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css">

<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>
</head>
<body>
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Business ID</th>
                                <th>Business Name</th>
                                <th>Street Name</th>
                            </tr>
                        </thead>
                        <tbody>
                
                <?php
                try {
                // Connect to the database. My username is root and password is root. I created a database named cmpe226 with a table called computerSale
                $con = new PDO("mysql:host=localhost;dbname=cmpe226",                               
                               "root", "root");

                $con->setAttribute(PDO::ATTR_ERRMODE,
                                   PDO::ERRMODE_EXCEPTION);



                $query = "SELECT business.Business_ID,  Business_Name, StreetName FROM business, location WHERE business.Business_ID= location.Business_ID";
                $ps = $con->prepare($query);
                $ps->execute();
                $data=$ps->fetchAll(PDO::FETCH_ASSOC);


                if (empty($data))
                {
                    print "No result found";
                }
                else
                { 
                    foreach ($data as $row) {
                print "            <tr>\n";
                
                foreach ($row as $name => $value) {
                print " <td><a href=business.php?action&business=$value>$value</a></td>\n";
                }
            }
                print "            </tr>\n";
                print "            </tbody>\n";
                print "        </table>\n";

                }

                }
                catch(PDOException $ex) {
                    echo 'ERROR: '.$ex->getMessage();
                }        
?>
                </div>
            </div>
        </div>
    </div>
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <hr>
                </div>
            </div>
        </div>
    </div> 
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class = "img-responsive" id="chart_div"></div>
                    <h2>Number of Violations per each Category</h2>
                    <p>
                        Displays the different types of violation categories <br>
                    </p>
                </div>
                <div class="col-md-4">
                  <div id="dashboard_div1">
                    <div id="filter1_div"></div>
                    <div class = "img-responsive" id="chart_div1"></div>
                    </div>
                    <h2>Number of Businesses in Score Ranges</h2>
                    <p>
                        Displays the number of businesses within a set of scores <br>
                    </p>
                </div>
                <div class="col-md-4">
                  <div id="dashboard_div2">
                  <div id="filter2_div"></div>
                    <div class = "img-responsive" id="chart_div2"></div>
                  </div>
                    <h2>Number of Businesses in Violation Ranges</h2>
                    <p>
                        Displays the number of businesses within a set of violation ranges <br>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
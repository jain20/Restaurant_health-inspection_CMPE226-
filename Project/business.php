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
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript">
    
    google.load("visualization", "1", {packages:["corechart",'controls']});
    google.setOnLoadCallback(drawChart);
      
    function drawChart() {
        //var urlapi = require('url');
        var url = window.location.href;
        //var url2 = urlapi.parse(url);
        console.log("The ID is: "+url);
        var parser = document.createElement('a');
        parser.href =url;
        var id = parser.search;
        id= id.split('=')[1];
        console.log("The ID is: "+id);

        var violation_year = $.ajax({
            url: "violation_year.php?action&business="+id+">",
            dataType: "json",
            async: false
        }).responseText;

        // var options_violation_year = {
        //     title: 'Average Score per Year',
        //     hAxis: {
        //         title: 'Year',
        //     },
        //     vAxis: {
        //         title: 'Average Score'
        //     }
        // };

        // // Create our data table out of JSON data loaded from server.
        // var data_violation_year = new google.visualization.DataTable(violation_year);

        // // Instantiate and draw our chart, passing in some options.
        // var chart_violation_year = new google.visualization.ColumnChart(document.getElementById('chart_div_violation_year'));
        // chart_violation_year.draw(data_violation_year, options_violation_year,{width: 400, height: 240});

        var inspection_year = $.ajax({
	        url: "inspection_year.php?action&business="+id+">",
	        dataType: "json",
	        async: false
	    }).responseText;
        
        // var options_inspection_year = {
        //     title: 'Number of Inspections Per Year',
        //     hAxis: {
        //         title: 'Year',
        //     },
        //     vAxis: {
        //         title: 'Number of Inspections'
        //     }
        // };

        // // Create our data table out of JSON data loaded from server.
        // var data_inspection_year = new google.visualization.DataTable(inspection_year);

        // // Instantiate and draw our chart, passing in some options.
        // var chart_inspection_year = new google.visualization.ColumnChart(document.getElementById('chart_div_inspection_year'));
        // chart_inspection_year.draw(data_inspection_year, options_inspection_year,{width: 400, height: 240});

        var violation_category = $.ajax({
            url: "Violation_category.php?action&business="+id+">",
            dataType: "json",
             async: false
        }).responseText;

        // Create our data table out of JSON data loaded from server.
        var data_violation_category = new google.visualization.DataTable(violation_category);

        // Instantiate and draw our chart, passing in some options.
        var chart_violation_category = new google.visualization.PieChart(document.getElementById('chart_div_violation_category'));
        chart_violation_category.draw(data_violation_category, {width: 400, height: 240});

        var dashboard = new google.visualization.Dashboard(document.getElementById('dashboard_div'));
        var dashboard2 = new google.visualization.Dashboard(document.getElementById('dashboard_div2'));
          // Instantiate and draw our chart, passing in some options.

        var year = new google.visualization.ControlWrapper({
            'controlType': 'NumberRangeFilter',
            'containerId': 'filter_div',
            'options': {
                'filterColumnLabel': 'Year'
            }
        });

        var year2 = new google.visualization.ControlWrapper({
            'controlType': 'NumberRangeFilter',
            'containerId': 'filter_div2',
            'options': {
                'filterColumnLabel': 'Year'
            }
        });

        var chart1 = new google.visualization.ChartWrapper({
            'chartType': 'ColumnChart',
            'containerId': 'chart_div_violation_year',
            'options': {
            'width': 300,
            'height': 300
            }
        });

           var chart2 = new google.visualization.ChartWrapper({
            'chartType': 'ColumnChart',
            'containerId': 'chart_div_inspection_year',
            'options': {
            'width': 300,
            'height': 300
            }
        });


      dashboard.bind(year,chart1);
      dashboard2.bind(year2,chart2);

      dashboard.draw(violation_year, {width: 400, height: 240});
      dashboard2.draw(inspection_year, {width: 400, height: 240});

    }

</script>

    <style>
    #violationCategory{
        margin-bottom:70px;
    }
    #piechart{
        margin-bottom:70px;
    }
</style>

<link
	href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css"
	rel="stylesheet" type="text/css">
<link href="index.css" rel="stylesheet" type="text/css">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="https://cdn.datatables.net/1.10.10/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="section">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Business Name</th>
								<th>Business Owner</th>
								<th>Business Address</th>
								<th>Average Score</th>
								<th>Number of Violations</th>
							</tr>
						</thead>
						<tbody>
				
				<?php
				try {
                // Connect to the database. My username is root and password is root. I created a database named cmpe226 with a table called computerSale
                $con = new PDO("mysql:host=localhost;dbname=cmpe226_dimensional",                               
                               "root", "root");

                if($con)
                {

                $con->setAttribute(PDO::ATTR_ERRMODE,
                                   PDO::ERRMODE_EXCEPTION);

           		$businessID = $_GET["business"];

				$query = "SELECT Business_Dimension.business_name,Business_Dimension.Owner,location_dimension.Street_Name, AVG(Inspection_Fact_Table.Score), COUNT(DISTINCT Violation_Fact_Table.Violation_Category_Key) FROM `Violation_Fact_Table`,Business_Dimension,Inspection_Fact_Table,location_dimension WHERE Violation_Fact_Table.Business_Key =Business_Dimension.Business_Key and Business_Dimension.Business_Key = Inspection_Fact_Table.Business_Key and Inspection_Fact_Table.Location_Key=location_dimension.Location_Key and Business_Dimension.Business_ID = '$businessID'";
				$ps = $con->prepare($query);
                $ps->execute();
 				$data=$ps->fetchAll(PDO::FETCH_ASSOC);
 				//$data2 = json_encode($data);
 				//echo $data2.[0].business_name;

                if (empty($data))
                {
                    print "No result found";
                }
                else
                { 
                	foreach ($data as $row) {
                print "            <tr>\n";
				
                foreach ($row as $name => $value) {
                print "  <a href=business.php?action&business=$value> <td>$value</td> </a>\n";
            	}
            }

                print "            </tr>\n";
                print "            </tbody>\n";
                print "        </table>\n";

				}
}
else
{
    echo "Failed to connect";
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
                    <div id="dashboard_div">
                        <div id="filter_div"></div>
					 <div class = "img-responsive" id="chart_div_violation_year"></div>
                    </div>
                     <h2>Average Score Per Year</h2>
					<p>
						Displays averages scores for a particular business within a range of years
					</p>
				</div>
				<div class="col-md-4">
					<div id="dashboard_div2">
                     <div id="filter_div2"></div>
					<div class = "img-responsive" id="chart_div_inspection_year"></div>
                    </div>
                    <h2>Number of Inspections</h2>
					<p>
						Displays the number of inspections for a particular business within a range of years
					</p>
				</div>
				<div class="col-md-4" id ="piechart">
					<div class = "img-responsive" id="chart_div_violation_category"></div>
                    <h2 id = "violationCategory">Number of Violations in each Category</h2>
					<p>
						Displays the number of violations for a particular category for a particular business
					</p>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
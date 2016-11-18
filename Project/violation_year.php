<?php
                // Connect to the database. My username is root and password is root. I created a database named cmpe226 with a table called computerSale
                $con = new PDO("mysql:host=localhost;dbname=cmpe226_dimensional",                               
                               "root", "root");

                $con->setAttribute(PDO::ATTR_ERRMODE,
                                   PDO::ERRMODE_EXCEPTION);

                $businessID = $_GET["business"];

              //$businessID = $_GET["business"];

        $query = "SELECT AVG(Inspection_Fact_Table.Score) as Score,Calendar_TIME_DIMENSION.YEAR as Year FROM Inspection_Fact_Table, Business_Dimension, Calendar_TIME_DIMENSION WHERE Inspection_Fact_Table.Calendar_Key=Calendar_TIME_DIMENSION.Calendar_Key and Inspection_Fact_Table.Business_Key=Business_Dimension.Business_Key and Business_Dimension.Business_ID='$businessID' GROUP BY Calendar_TIME_DIMENSION.YEAR";
        $ps = $con->prepare($query);
                $ps->execute();
        $data=$ps->fetchAll(PDO::FETCH_ASSOC);
                $rows = array();
                $table = array();
                $table['cols'] = array(

                    // Labels for your chart, these represent the column titles.
                    /* 
                        note that one column is in "string" format and another one is in "number" format 
                        as pie chart only required "numbers" for calculating percentage 
                        and string will be used for Slice title
                    */

                    array('label' => 'Year', 'type' => 'number'),
                    array('label' => 'Score', 'type' => 'number')

                );
                /* Extract the information from $result */
                foreach($data as $r) {

                    $temp = array();

                    // the following line will be used to slice the Pie chart

                    $temp[] = array('v' => (int) $r['Year']); 

                    // Values of each slice

                    $temp[] = array('v' => (int) $r['Score']); 
                    $rows[] = array('c' => $temp);
                }

                $table['rows'] = $rows;

                // convert data into JSON format
                $jsonTable = json_encode($table);
                echo $jsonTable;
?>
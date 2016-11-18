<?php
                // Connect to the database. My username is root and password is root. I created a database named cmpe226 with a table called computerSale
                $con = new PDO("mysql:host=localhost;dbname=cmpe226_dimensional",                               
                               "root", "root");

                $con->setAttribute(PDO::ATTR_ERRMODE,
                                   PDO::ERRMODE_EXCEPTION);

                $businessID = $_GET["business"];

              //$businessID = $_GET["business"];

        $query = "SELECT Violation_Category_Dimension.Category_Description as Type_of_Violation, COUNT(DISTINCT Violation_Fact_Table.Violation_Category_Key) as count_of_violations FROM Violation_Fact_Table,Violation_Category_Dimension,Business_Dimension WHERE Violation_Category_Dimension.Violation_Category_Key=Violation_Fact_Table.Violation_Category_Key AND Violation_Fact_Table.Business_Key = Business_Dimension.Business_Key AND Business_Dimension.Business_ID = '$businessID' GROUP BY Violation_Category_Dimension.Category_Description";
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

                    array('label' => 'Type_of_Violation', 'type' => 'string'),
                    array('label' => 'count_of_violations', 'type' => 'number')

                );
                /* Extract the information from $result */
                foreach($data as $r) {

                    $temp = array();

                    // the following line will be used to slice the Pie chart

                    $temp[] = array('v' => (string) $r['Type_of_Violation']); 

                    // Values of each slice

                    $temp[] = array('v' => (int) $r['count_of_violations']); 
                    $rows[] = array('c' => $temp);
                }

                $table['rows'] = $rows;

                // convert data into JSON format
                $jsonTable = json_encode($table);
                echo $jsonTable;
?>
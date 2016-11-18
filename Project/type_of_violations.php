<?php
                // Connect to the database. My username is root and password is root. I created a database named cmpe226 with a table called computerSale
                $con = new PDO("mysql:host=localhost;dbname=cmpe226_dimensional",                               
                               "root", "root");

                $con->setAttribute(PDO::ATTR_ERRMODE,
                                   PDO::ERRMODE_EXCEPTION);


                $query = "SELECT COUNT(Violation_Fact_Table.Business_Key) as No_of_Violations,Violation_Category_Dimension.Category_Description as Category FROM Violation_Fact_Table,Violation_Category_Dimension WHERE Violation_Fact_Table.Violation_Category_Key=Violation_Category_Dimension.Violation_Category_Key GROUP BYViolation_Category_Dimension.Violation_Category_ID";
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

                    array('label' => 'No_of_Violations', 'type' => 'number'),
                    array('label' => 'Category', 'type' => 'string')

                );
                /* Extract the information from $result */
                foreach($data as $r) {

                    $temp = array();

                    // the following line will be used to slice the Pie chart

                    $temp[] = array('v' => (int) $r['No_of_Violations']); 

                    // Values of each slice

                    $temp[] = array('v' => (int) $r['Category']); 
                    $rows[] = array('c' => $temp);
                }

                $table['rows'] = $rows;

                // convert data into JSON format
                $jsonTable = json_encode($table);
                echo $jsonTable;
?>
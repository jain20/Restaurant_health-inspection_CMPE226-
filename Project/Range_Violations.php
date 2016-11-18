<?php
    // Connect to the database. My username is root and password is root. I created a database named cmpe226 with a table called computerSale
    $con = new PDO("mysql:host=localhost;dbname=cmpe226_dimensional",                               
                               "root", "root");

    $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);


    $query = "SELECT countTwenty as '0-20',countForty as '20-40',countSixty as '40-60',countEighty as '60-80',countHundred as '80-100' FROM (SELECT COUNT(*) AS countTwenty FROM (SELECT COUNT(Violation_Fact_Table.Violation_Category_Key) as No_of_violations FROM Violation_Fact_Table,Business_Dimension WHERE Violation_Fact_Table.Business_Key = Business_Dimension.Business_Key GROUP BY Business_Dimension.Business_ID HAVING No_of_violations BETWEEN 0 AND 20) AS twenty )AS twentyTable INNER JOIN (SELECT COUNT(*) AS countForty FROM (SELECT COUNT(Violation_Fact_Table.Violation_Category_Key) as No_of_violations FROM Violation_Fact_Table,Business_Dimension WHERE Violation_Fact_Table.Business_Key = Business_Dimension.Business_Key GROUP BY Business_Dimension.Business_ID HAVING No_of_violations BETWEEN 20 AND 40) AS forty )AS fortyTable INNER JOIN (SELECT COUNT(*) AS countSixty FROM (SELECT COUNT(Violation_Fact_Table.Violation_Category_Key) as No_of_violations FROM Violation_Fact_Table,Business_Dimension WHERE Violation_Fact_Table.Business_Key = Business_Dimension.Business_Key GROUP BY Business_Dimension.Business_ID HAVING No_of_violations BETWEEN 40 AND 60) AS sixty )AS sixtyTable INNER JOIN (SELECT COUNT(*) AS countEighty FROM (SELECT COUNT(Violation_Fact_Table.Violation_Category_Key) as No_of_violations FROM Violation_Fact_Table,Business_Dimension WHERE Violation_Fact_Table.Business_Key = Business_Dimension.Business_Key GROUP BY Business_Dimension.Business_ID HAVING No_of_violations BETWEEN 60 AND 80) AS eighty )AS eightyTable INNER JOIN (SELECT COUNT(*) AS countHundred FROM (SELECT COUNT(Violation_Fact_Table.Violation_Category_Key) as No_of_violations FROM Violation_Fact_Table,Business_Dimension WHERE Violation_Fact_Table.Business_Key = Business_Dimension.Business_Key GROUP BY Business_Dimension.Business_ID HAVING No_of_violations BETWEEN 80 AND 100) AS hundred )AS hundredTable";
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
    array('label' => 'Violation Count', 'type' => 'string'),
    array('label' => 'No_of_Businesses', 'type' => 'number')
    );
    /* Extract the information from $result */
    foreach($data as $r) {
        foreach ($r as $name => $value){
            $temp = array();
            // the following line will be used to slice the Pie chart
            $temp[] = array('v' => (string) $name); 
            // Values of each slice
            $temp[] = array('v' => (int) $value); 
            $rows[] = array('c' => $temp);
        }
    }
    $table['rows'] = $rows;
    // convert data into JSON format
    $jsonTable = json_encode($table);
    echo $jsonTable;
?>
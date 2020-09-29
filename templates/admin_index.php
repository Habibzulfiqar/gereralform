<?php
/**
* @package IqraFchaudhry
*
*/
?>
<!DOCTYPE html>
<html>
<head>
	<title>iqra Chart sizes</title>
</head>
<body>
<style type="text/css">
	h1{
		text-align: center;
		margin: 20px 0px;
	}
</style>
	<h1>chart sizes of all users</h1>
	<?php
    global $wpdb;
    $table_name = $wpdb->prefix . 'iqrafchaudhry';
	$results = $wpdb->get_results( "SELECT * FROM $table_name"); // Query to fetch data from database table and storing in $results
if(!empty($results))                        // Checking if $results have some values or not
{    
    echo "<table class='table table-hover ' width='100%' border='0'>"; // Adding <table> and <tbody> tag outside foreach loop so that it wont create again and again
    echo "<tbody>";
?>
 <thead>
<tr>
		<th>user id</th>
		<th>chart name</th>
		<th>Shoulder</th>
 		<th>waist</th>
		<th>bust</th>
		<th>hip</th>
		<th>shirt length</th>
		<th>armhole</th>
		<th>sleve hole</th>
		<th>wrist</th>
		<th>additional notes</th>
 </tr>
</thead>

<?php
    foreach($results as $row){   
    $userip = $row->user_id;               //putting the user_ip field value in variable to use it later in update query
   

    
    echo "<tr>";
      echo "<td>" . $row->user_id . "</td>";   //fetching data from user_ip field
      echo "<td>" . $row->chart_name . "</td>";
      echo "<td>" . $row->shoulder . "</td>";
       echo "<td>" . $row->waist . "</td>";
      echo "<td>" . $row->bust . "</td>";
      echo "<td>" . $row->hip . "</td>";
      echo "<td>" . $row->shirt_length . "</td>";
      echo "<td>" . $row->armhole . "</td>";
      echo "<td>" . $row->sleve_hole . "</td>";
      echo "<td>" . $row->wrist . "</td>";
      echo "<td><a href='#' data-toggle='popover' class='btn btn-primary' title='important note' data-content='kkk"  . $row->addnote . "'>user message</a></td>";
    echo "</tr>";

     }
    echo "</tbody>";
    echo "</table>"; 

}

    global $wpdb;
    $table_name = $wpdb->prefix . 'iqrafchaudhry';
    $user_id = get_current_user_id();
    $retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE user_id = $user_id" );
     //print_r($retrieve_data);
?>
<select name="custom_text_add_on" >
            <?php
            foreach ( $retrieve_data as $chartname ) {
                echo '<option value="'.$chartname->chart_name.'">' .$chartname->chart_name. '</option>';
            }
            ?>
        </select>




</body>
</html>
<script>
$(document).ready(function(){
  $('[data-toggle="popover"]').popover();   
});
</script>
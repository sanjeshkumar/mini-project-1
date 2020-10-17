<?php 
	
    session_start();
    $get_recent = $db->query("SELECT * FROM food LIMIT 9");
    $result = "";
    ?>
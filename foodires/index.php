<?php 
	
    session_start();
    $get_recent = $db->query("SELECT * FROM food LIMIT 9");
    $result = "";
    if($get_recent->num_rows) {
        while($row = $get_recent->fetch_assoc()) {
			
			$result .= "<div class='parallax_item'>
				
                            <a href='detail.php?fid=".$row['id']."'><img src='image/FoodPics/".$row['id'].".jpg' width='80px' height='80px' />
                             
    }
}

    ?>
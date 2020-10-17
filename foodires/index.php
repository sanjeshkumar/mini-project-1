<?php 
	
    session_start();
    $get_recent = $db->query("SELECT * FROM food LIMIT 9");
    $result = "";
    if($get_recent->num_rows) {
        while($row = $get_recent->fetch_assoc()) {
			
			$result .= "<div class='parallax_item'>
				
                            <a href='detail.php?fid=".$row['id']."'><img src='image/FoodPics/".$row['id'].".jpg' width='80px' height='80px' />
                            <div class='detail'>
								
                            <h4>".$row['food_name']."</h4>
                            <p class='desc'>".substr($row['food_description'], 0, 33)."...</p>
                            <p class='price'>#".$row['food_price']."</p>
                            
                        </div>
                        <p class='clear'></p>
                        </a>
                        
                    </div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content=""/>
    <title>Document</title>
    <link rel="stylesheet" href="css/main.css" />
    <script src="js/myscript.js"></script>
</head>
<body>
<?php require "includes/header.php"; ?>
<div class="parallax" onclick="remove_class()">
	
	<div class="parallax_head">
		
		<h2>Welcome</h2>
		<h3>We are Excited to Cook special for You</h3>
		
	</div>
	
</div>
</body>
</html>

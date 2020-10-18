<?php 
	
	session_start();
	require "admin/includes/functions.php";
	require "admin/includes/db.php";
	
?>

<?php 

	if (isset($_GET['fid']) && isset($_GET['qty'])) {
		$fid = $_GET['fid'];
		$qty = isset($_GET['qty']) ? (int)$_GET['qty'] : 1;
		$wasFound = false;
        $i = 0;
        if (!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) { 
			
			$_SESSION["cart_array"] = array(0 => array("item_id" => $fid, "quantity" => $qty));
		}
        else {
			
            $qty = isset($_GET['qty']) ? (int)$_GET['qty'] : 1;
            foreach ($_SESSION["cart_array"] as $each_item) { 
                $i++;
                while (list($key, $value) = each($each_item)) {
                    if ($key == "item_id" && $value == $fid) {
                        // That item is in cart already so let's adjust its quantity using array_splice()
                        array_splice($_SESSION["cart_array"], $i-1, 1, array(array("item_id" => $fid, "quantity" => $each_item['quantity'] + $qty)));
                        $wasFound = true;
                    } 
                }
    }
    if ($wasFound == false) {
        array_push($_SESSION["cart_array"], array("item_id" => $fid, "quantity" => $qty));
    }
    header("location: basket.php"); 
		exit();
}
    ?>

<?php
 
 if (isset($_GET['cmd']) && $_GET['cmd'] == "emptycart") {
     unset($_SESSION["cart_array"]); //empty the foody cart
 }
 
?>

<?php 

	if (isset($_POST['index_to_remove']) && $_POST['index_to_remove'] != "") {
		// Access the array and run code to remove that array index
		$key_to_remove = $_POST['index_to_remove'];
		if (count($_SESSION["cart_array"]) <= 1) {
			unset($_SESSION["cart_array"]);
		} else {
			unset($_SESSION["cart_array"]["$key_to_remove"]);
			sort($_SESSION["cart_array"]);
		}
	}
	
?>
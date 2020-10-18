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
}
    ?>
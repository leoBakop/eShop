<?php
include "./application_logic/functions.php";
include "./sql_connection/sql_connection.php";
include "./application_logic/sp_functions.php";
if (session_status() === PHP_SESSION_NONE) session_start();
if (!loged_in_user()) back_to_index();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./javaScript/basic_functionality.js"></script>
    <link rel="stylesheet" href="style.css">
    <title>Update product</title>
</head>

<body>
    <form method="GET" class="search">
            <label for="changes">What would you like to update</label>
            <select name="changes">
                <option value="Name">Name</option>
                <option value="Price">Price</option>
               <!-- <option value="ProductCode">Product Code</option> is forbidenn
                    cause if the product code will change, the orion i will have problem
                    in the orion entity (id of the entity is the product code)
            -->
                <option value="DateOfWithdrawal">DateOfWithdrawal</option>
                <option value="Category">Category</option>
                <option value="Availability">Availability</option>
            </select>
        <input type="submit" name="update" value="update product">
    </form>

    <?php
        if(array_key_exists('update', $_GET)){
            if ($_GET['changes'] == "Name") {
            ?>
                <form method="post">
                    <label for="Name">name:</label><br>
                    <input type="text" id="Name" name="Name"><br>
                    <input type="submit" name="change_name" value="Change Name">
                </form>

            <?php
                if (array_key_exists('change_name', $_POST)) sp_update_product(
                    $_SESSION['product_id'],
                    "Name",
                    $_POST['Name']
                );
            }elseif($_GET['changes'] == "Price") {
            ?>
                <form method="post">
                    <label for="Price">Price:</label><br>
                    <input type="text" id="Price" name="Price"><br>
                    <input type="submit" name="change_price" value="Change Price">
                </form>
            <?php
                if (array_key_exists('change_price', $_POST)) sp_update_product(
                    $_SESSION['product_id'],
                    "Price",
                    $_POST['Price']
                );
            }elseif($_GET['changes']=="ProductCode"){
            ?>
                <form method="post">
                    <label for="ProductCode">New ProductCode:</label><br>
                    <input type="text" id="ProductCode" name="ProductCode"><br>
                    <input type="submit" name="change_ProductCode" value="Change ProductCode">
                </form>

            <?php
                if (array_key_exists('change_ProductCode', $_POST)) sp_update_product(
                    $_SESSION['product_id'],
                    "Product_code",
                    $_POST['ProductCode']
                );
            }elseif($_GET['changes']=="DateOfWithdrawal"){
                ?>
                    <form method="post">
                        <label for="DateOfWithdrawal">New DateOfWithdrawal:</label><br>
                        <input type="text" id="DateOfWithdrawal" name="DateOfWithdrawal"><br>
                        <input type="submit" name="change_DateOfWithdrawal" value="Change DateOfWithdrawal">
                    </form>
    
                <?php
                    if (array_key_exists('change_DateOfWithdrawal', $_POST)) sp_update_product(
                        $_SESSION['product_id'],
                        "DateOfWithdrawl",
                        $_POST['DateOfWithdrawal']
                    );
                }elseif($_GET['changes']=="Category"){
                    ?>
                        <form method="post">
                            <label for="Category">New Category:</label><br>
                            <input type="text" id="Category" name="Category"><br>
                            <input type="submit" name="change_Category" value="Change Category">
                        </form>
        
                    <?php
                        if (array_key_exists('change_Category', $_POST)) sp_update_product(
                            $_SESSION['product_id'],
                            "Category",
                            $_POST['Category']
                        );
                }elseif($_GET['changes']=="Availability"){
                    ?>
                        <form method="post">
                            <input type="submit" style="background-color:DodgerBlue;" name="change_avail" value="Change Availability">
                        </form>
        
                    <?php
                        if (array_key_exists('change_avail', $_POST)) {
                            $avail=sp_update_product_availability($_SESSION['product_code']);
                            //now i have to update the entity in orion
                            echo "current availability is ".$avail;
                            update_entity_orion($avail,$_SESSION['product_code']);
                        }
                        
                }
        }
        ?>
    </div>

    <br>
    <button class="button" onclick="go_to_welcome()">back </button>

</body>

</html>
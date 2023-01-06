<?php
session_start();


//sign_up.php
/**
 * method that creates new users
 * input: take the necessarily arguments,
 *      check if any user has the same username,
 *      and push it to the database
 */
function sign_up_sql($name, $surname,
                     $username, $password, $email, $role,$con){
    
    
    if(same_username_sql($con, $username)){
        echo "please choose another username";
        return ;
    }
    $sql = "INSERT INTO `users` (`Name`, `Surname`, `Username`, `Password`, `Email`, `Role`, `Confirmed`) 
        VALUES ('$name', '$surname', '$username', '$password', '$email', '$role', '0')";
    $res=mysqli_query($con, $sql);
    ?><script>window.location.replace("./index.php");</script><?php //relocation using js
    return;

}
//index.php
/**
 * simple check using the db 
 * and relocate into the main webpage
 */
function log_in_sql($username, $password,$con){
    $sql = "select * from users WHERE Password=$password and Username='$username'";
    $res=mysqli_query($con, $sql);

    $row=$res->fetch_assoc();
    if($res->num_rows<1) return false;   
    if($row["Confirmed"]==0){
        alert("You are not Confirmed,please communicate with an admin");
        return false;
    }
    
    
    $_SESSION["Role"]=$row["Role"];
    $_SESSION["Username"]=$username;
    $_SESSION["User_id"]=$row["ID"];
    ?><script>window.location.replace("./welcome.php");</script><?php
    return true;
}

function same_username_sql($con, $username){
    
    $sql = "select * from users WHERE Username='$username';";
    $res=mysqli_query($con, $sql);

    $row=mysqli_fetch_row($res);
    if(!is_null($row)) return true;
    return false;
}
//admin.php
/**
 * print all the users,
 * and the necessarily buttons, 
 * update confirm, update user, delete user
 *  without ajax
 * 
 * First function, just communicates
 * with the db
 * 
 * Second Function, prints 
 * every user and the buttons
 */
function print_users_sql($con){
    $sql = "select * from users ";
    $res=mysqli_query($con, $sql);

    echo "<table>";
    ?>
    <tr class="header_line">
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Confirmed</th>
    </tr>
    <?php
    for($i=0; $i<$res->num_rows; $i++){
        $row=$res->fetch_assoc();
        print_single_user_sql($row, $i,$con);
    }
    echo "</table>";

}
function print_single_user_sql($row, $i,$con){

    echo "<tr>";
    echo "<th class=\"normal_th\">".$row["Username"]."</th>";
    echo "<th class=\"normal_th\">".$row["Email"]."</th>";
    echo "<th class=\"normal_th\">".$row["Role"]."</th>";
    echo "<th class=\"normal_th\">".$row["Confirmed"]."</th>";
    ?><!-- button in order to upadte confirm and delete-->
    <th class="normal_th">
    <form  method="post">
        <input type="submit" value="Update Confirmed" 
               name="confirmed_button<?php echo "_$i"; ?>" class="button"/> <!-- $i in order to create different buttons and listeners for every row -->
        <input type="submit" value="Delete User" 
               name="delete_button<?php echo "_$i"; ?>" class="button"/> 
    </form>
    </th>
    <?php
    if(array_key_exists('confirmed_button_'.$i, $_POST)) update_confirmed_sql($row["ID"],$con);
    if(array_key_exists('delete_button_'.$i, $_POST)) delete_sql($row["ID"],$con);
    echo "</tr>";
}
/**
 * same as the previous
 * but with ajax 
 * 
 * ajax, asks a request in the ajax_function.php.
 * That page, calls the above functions and waits 
 * for the answer
 */
function print_users_ajax_sql($con){
    $sql = "select * from users ";
    $res=mysqli_query($con, $sql);

    echo "<table>";
    //first line of the table/title of each column
    ?>
    <tr class="header_line">
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Confirmed</th>
    </tr>
    
    <?php

    for($i=0; $i<$res->num_rows; $i++){
        
        $row=$res->fetch_assoc();
        $tmp_id=$row["ID"];
        print_single_user_ajax_sql($row, $tmp_id,$con);
        
        echo (
            "<th class=\"normal_th\">
        
            <button class=\"button\" type=\"button\" onclick=\"update_user($tmp_id)\"> confirm</button> 
            </th>
            <th class=\"normal_th\">
            <button class=\"button\" type=\"button\" onclick=\"delete_user($tmp_id)\"> delete</button> 
            </tr>
            </th>
            "
        );
        
    
    }
    echo "</table>";

    
    ?>
    
    <script src="./application_logic/jquery-3.6.1.js"></script>
    <script type="text/javascript">
    
    function update_user(id){
        $.ajax({

            type:'post',
            url:'./application_logic/ajax_functions.php',
            data:{function: 'update_user_confirmation', id:id},
            success:function(data){
                $('#'+id).replaceWith("1");
            }
        });
    
    };
    function delete_user(id){
        $.ajax({

            type:'post',
            url:'./application_logic/ajax_functions.php',
            data:{function: 'delete_user_confirmation', id:id},
            success:function(data){
                $('#all'+id).detach();
             
            }
        });
    
    };
    </script>

    <?php

}

function print_single_user_ajax_sql($row, $tmp_id,$con){
    $tmp_id=$row["ID"];
    echo "<tr id=all$tmp_id>";
    echo "<th class=\"normal_th\">".$row["Username"]."</th>";
    echo "<th class=\"normal_th\">".$row["Email"]."</th>";
    echo "<th class=\"normal_th\">".$row["Role"]."</th>";
    echo "<th class=\"normal_th\"><div id=$tmp_id >".$row["Confirmed"]."</div></th>";
    
    echo "<form method=\"GET\"> 
    <th class=\"normal_th\">
    <button class=\"button\" type=\"sumbit\" name=\"change_user_$tmp_id\"> change user</button> 
    </th>
    </form>";

    //listeners

    if(array_key_exists('change_user_'.$tmp_id, $_GET)){
        $_SESSION['tmp_user_id']=$tmp_id;
        ?><script>window.location.replace("update_user.php")</script><?php
    }
    
    
}

/**
 * listeners buttons for the buttons
 */
function update_confirmed_sql($ID, $con){
    $sql = "UPDATE users SET confirmed=1 WHERE ID='$ID'" ;
    $res=mysqli_query($con, $sql);
}

function delete_sql($ID,$con){
    $sql = "DELETE FROM users WHERE ID='$ID'" ;
    $res=mysqli_query($con, $sql);
}

function change_user($ID, $field_to_change, $value, $con){
    $sql = "UPDATE users SET $field_to_change='$value' WHERE ID='$ID'" ;
    $res=mysqli_query($con, $sql);
    ?><script>
        window.location.replace("./administration.php");
    </script><?php
}

//welcome.php

function log_out_function(){
    unset($_SESSION["Role"]);
    unset($_SESSION["Username"]);
    unset($_SESSION["User_id"]);
    unset($_SESSION["totCost"]);
    session_destroy();
    ?><script>window.location.replace("./index.php");</script><?php
    die;
}

function return_to_welcome(){
    ?><script>window.location.replace("./welcome.php");</script><?php
    return ;
}

//seller.php
/**
 * just pushes in the db
 */

function add_product_sql($seller, $name,$code, $date,
                            $price,$category,$con){
    
    $sql = "INSERT INTO `products` (`Name`, `ProductCode`, `Price`, `DateOfWithdrawal`, `SellerName`, Category) 
        VALUES ('$name', '$code', '$price', '$date', '$seller', '$category')";
    $res=mysqli_query($con, $sql);
    ?><script>window.location.replace("./seller.php");</script><?php
}

function  go_to_update_product_sql($id, $code){
    alert("product code is ".$code);
    $_SESSION["product_code"]=$code;
    $_SESSION["product_id"]=$id;
    ?><script>window.location.replace("./update_product_sql.php");</script><?php    

}
/**
 * update a product with given 
 * product id
 */

function update_product($product_id, $field_to_change, $value, $con){
    $sql = "UPDATE `products` SET $field_to_change='$value'
        WHERE  ID='$product_id'";
    $res=mysqli_query($con, $sql);
    ?><script>
        window.location.replace("./seller.php");
    </script><?php
}

/**
 * select * from products where sellername=this seller
 */
function print_sellers_products_sql($creator,$con){
    $sql = "select * from products where  SellerName='$creator'";
    $res=mysqli_query($con, $sql);
    echo "<table>";
    ?>
    <tr class="header_line">
        <th>Name</th>
        <th>Product Code</th>
        <th>Price</th>
        <th>Date Of Withdrawal</th>
    </tr>
    <?php
    for($i=0; $i<$res->num_rows; $i++){
        $row=$res->fetch_assoc();
        print_single_product_sql($row, $i,$con);
    }
    echo "</table>";
}

/**
 * print every previously mentioned product and
 * the dynamically buttons 
 */
function print_single_product_sql($row, $i,$con){
    echo "<tr>";
    echo "<th class=\"normal_th\">".$row["Name"]."</th>";
    echo "<th class=\"normal_th\">".$row["ProductCode"]."</th>";
    echo "<th class=\"normal_th\">".$row["Price"]."</th>";
    echo "<th class=\"normal_th\">".$row["DateOfWithdrawal"]."</th>";
    ?><!-- button in order to upadte confirm and delete-->
    <th class="normal_th">
    <form method="post">
        <input type="submit" value="Update product" 
                name="update_product_button<?php echo "_$i"; ?>"  class="button"/> 
        <input type="submit" value="Delete product" 
                name="delete_product_button<?php echo "_$i"; ?>" class="button"/> 
    </form>    
           
    
    </th>
    <?php
    
    if(array_key_exists('update_product_button_'.$i, $_POST)){
        
        go_to_update_product_sql($row["ID"],$con);
        die;
    }
    if(array_key_exists('delete_product_button_'.$i, $_POST)) delete_product_sql($row["ID"],$con);
    echo "</tr>";
}
/**
 * delete a product with given 
 * product id
 */

function delete_product_sql($id,$con){
    $sql = "DELETE FROM products WHERE ID='$id'" ;
    $res=mysqli_query($con, $sql);
}

// ajax/sellers
/**
 * same as above but in ajax
 * ajax was implemented as it
 * was mentioned prevously
 */
function print_sellers_products_sql_ajax($creator,$con){
    $sql = "select * from products where  SellerName='$creator'";
    $res=mysqli_query($con, $sql);
    echo "<table>";
    ?>
    <tr class="header_line">
        <th>Name</th>
        <th>Product Code</th>
        <th>Price</th>
        <th>Date Of Withdrawal</th>
    </tr>
    <?php
    for($i=0; $i<$res->num_rows; $i++){
        $row=$res->fetch_assoc();
        print_single_product_sql_ajax($row, $i,$con);
    }
    echo "</table>";

    ?>
    <script src="./application_logic/jquery-3.6.1.js"></script>
    <script type="text/javascript">
    
    function delete_product(id,con){
        $.ajax({
            type:'post',
            url:'./application_logic/ajax_functions.php',
            data:{function: 'delete_product', id:id, con:con},
            success:function(data){
                $('#'+id).detach();
            }
        });
    
    };
    </script>
    <?php
}

function print_single_product_sql_ajax($row, $i,$con){
    $id=$row["ID"];
    echo "<tr id=$id>";
    echo "<th class=\"normal_th\">".$row["Name"]."</th>";
    echo "<th class=\"normal_th\">".$row["ProductCode"]."</th>";
    echo "<th class=\"normal_th\">".$row["Price"]."</th>";
    echo "<th class=\"normal_th\">".$row["DateOfWithdrawal"]."</th>";
    ?><!-- button in order to upadte confirm and delete-->
    
    <form method="post">
    <th class="normal_th">
        <input type="submit" value="Update product"  
                name="update_product_button<?php echo "_$i"; ?>"  class="button"/> 
    </th>
    <th class="normal_th">
            <input type="submit" value="Delete product" 
                onclick="delete_product(<?php echo $id?>)" class="button"/> 
    </th>
    </form>    
           
    
    
    <?php
    
    if(array_key_exists('update_product_button_'.$i, $_POST)){
        
        go_to_update_product_sql($row["ID"],$con);
        die;
    }
    echo "</tr>";
    
}
//products.php
/**
 * there was no need for ajax in products 
 * because the only functionality is the
 * "add to cart" that can happens in the 
 * "background"
 */

/**
 * select * from products
 */
function print_all_products_sql($con, $user_id){
    $sql = "select * from products";
    $res=mysqli_query($con, $sql);

    echo "<table>";
    ?>
    <tr class="header_line">
        <th>Product Name</th>
        <th>Product Code</th>
        <th>Seller Name</th>
        <th>Price</th>
        <th>Date Of Withdrawal</th>
        <th>Category</th>

    </tr>
    <?php
    for($i=0; $i<$res->num_rows; $i++){
        $row=$res->fetch_assoc();
        print_single_product_user_sql($row,$con,$user_id);
    }
    echo "</table>";
}
/**
 * print every product
 */
function print_single_product_user_sql($row,$con, $user_id){
    $tmp_id=$row['ID'];
    echo "<tr>";
    echo "<th class=\"normal_th\">".$row["Name"]."</th>";
    echo "<th class=\"normal_th\">".$row["ProductCode"]."</th>";
    echo "<th class=\"normal_th\">".$row["SellerName"]."</th>";
    echo "<th class=\"normal_th\">".$row["Price"]."</th>";
    echo "<th class=\"normal_th\">".$row["DateOfWithdrawal"]."</th>";
    echo "<th class=\"normal_th\">".$row["Category"]."</th>";
    ?>
    <th class="normal_th">
    <form  method="post">
        <input class="button" type="submit" value="Add to Cart" 
               name="cart_button<?php echo "_$tmp_id"; ?>" class="button"/> <!-- $i in order to create different buttons and listeners for every row -->
    </form>
    </th>
    <?php
    if(array_key_exists('cart_button_'.$tmp_id, $_POST)) add_to_cart_sql($row,$con,$user_id);
    echo "</tr>";
}
/**
 * insert into cart (product, user's cart, date that was added)
 */

function add_to_cart_sql($row,$con, $user_id){
    $product_id=(int)$row["ID"];
    $date=date("Y-m-d");
    $sql =  "INSERT INTO `carts` (`ID`, `User_id`, `Product_id`, `DateOfInsertion`) 
        VALUES (NULL, '$user_id', '$product_id', '$date');";
    
    $res=mysqli_query($con, $sql);
    

}

function search_product_by_specific_attribute_sql($attribute,$attribute_value,$con, $user_id){
    $sql = "select * from products where  $attribute='$attribute_value'";
    $res=mysqli_query($con, $sql);

    if($res->num_rows==0){
        echo "<div class=\"not_authorized\">";
        echo "there is no product with that specification :(";
        echo "</div>";
        return ;
    }
    echo "<table>";
    ?>
    <tr class="header_line">
        <th>Product Name</th>
        <th>Product Code</th>
        <th>Seller Name</th>
        <th>Price</th>
        <th>Date Of Withdrawal</th>
        <th>Category</th>
    </tr>
    <?php
    for($i=0; $i<$res->num_rows; $i++){
        $row=$res->fetch_assoc();
        print_single_product_user_sql($row,$con, $user_id);
    }
    echo "</table>";
    
}


//cart.php
/**
 * select * from cart where user_id=this user
 */

function print_cart($user_id,$con){
    $sql = "SELECT * from carts where User_id='$user_id' ";
    $res=mysqli_query($con, $sql);
    $totCost=0;

    echo "<table>";
    ?>
    <tr class="header_line">
        <th>Name</th>
        <th>Product Code</th>
        <th>Category</th>
        <th>Price</th>
    </tr>
    <?php
    for($i=0; $i<$res->num_rows; $i++){
        $row=$res->fetch_assoc();
        $totCost+=print_single_cart_user_sql($row, $i,$con);
    }
    echo "</table>";
  
    $_SESSION['totCost']=$totCost;
    echo "total cost is ".   $_SESSION['totCost']."$ <br>" ;
}

/**
 * print single prodcut from cart and the button
 * (not in ajax)
 */
function print_single_cart_user_sql($row,$i,$con){
    $cart_id=$row["ID"];
    $product_id=$row["Product_id"];
    $sql = "SELECT * from products where ID=$product_id ";
    $res=mysqli_query($con, $sql);
    $row=$res->fetch_assoc();
    echo "<tr>";
    echo "<th class=\"normal_th\">".$row["Name"]."</th>";
    echo "<th class=\"normal_th\">".$row["ProductCode"]."</th>";
    echo "<th class=\"normal_th\">".$row["Category"]."</th>";
    echo "<th class=\"normal_th\">".$row["Price"]."$ </th>";
    
    ?><!-- button in order to upadte confirm and delete-->
    <th class="normal_th">
    <form  method="post">
        <input type="submit" value="delete this" 
               name="delete_button<?php echo "_$i"; ?>" class="button"/> <!-- $i in order to create different buttons and listeners for every row -->
    </form>
    </th>
    <?php
    if(array_key_exists('delete_button_'.$i, $_POST)){ 
        delete_from_cart_sql($cart_id,$con);
        $_SESSION['totCost']-=$row["Price"];
        return ;
    }
    echo "</tr>";

    return $row["Price"];
}


// cart/ajax version
/**
 * select * from cart where user_id=this user
 */
function print_cart_ajax($user_id,$con){
    $sql = "SELECT * from carts where User_id='$user_id' ";
    $res=mysqli_query($con, $sql);
    $totCost=0;

    echo "<table>";
    ?>
    <tr class="header_line">
        <th>Name</th>
        <th>Product Code</th>
        <th>Category</th>
        <th>Price</th>
    </tr>
    <?php
    for($i=0; $i<$res->num_rows; $i++){
        $row=$res->fetch_assoc();
        //$totCost+=print_single_cart_user_sql($row, $i,$con);
        $totCost+=print_single_cart_user_sql_ajax($row, $i,$con);
    }
    echo "</table>";
    ?>
    <script src="./application_logic/jquery-3.6.1.js"></script>
    <script type="text/javascript">
    
    function remove_from_cart(id,con){
        $.ajax({
            type:'post',
            url:'./application_logic/ajax_functions.php',
            data:{function: 'remove_from_cart', id:id, con:con},
            success:function(data){
                $('#'+id).detach();
            }
        });
    
    };
    </script>

    <div class="total_cost">
    <?php
    $_SESSION['totCost']=$totCost;
    echo "total cost is ".   $_SESSION['totCost']."$ <br>" ;
    ?>
    </div>
    
    <?php
    
}
/**
 * print single prodcut from cart and the button
 * (ajax)
 * 
 */
function print_single_cart_user_sql_ajax($row, $i,$con){
    $cart_id=$row["ID"];
    $product_id=$row["Product_id"];
    $sql = "SELECT * from products where ID=$product_id ";
    $res=mysqli_query($con, $sql);
    $row=$res->fetch_assoc();
    echo "<tr id=$cart_id>";
    echo "<th class=\"normal_th\">".$row["Name"]."</th>";
    echo "<th class=\"normal_th\">".$row["ProductCode"]."</th>";
    echo "<th class=\"normal_th\">".$row["Category"]."</th>";
    echo "<th class=\"normal_th\">".$row["Price"]."$ </th>";
    
    ?><!-- button in order to upadte confirm and delete-->
    <th class="normal_th">
    <form  method="post">
        <input type="submit" value="delete this" onclick="remove_from_cart(<?php echo $cart_id ?>)"
                class="button"/> 
    </form>
    </th>

    

    <?php
    echo "</tr>";
    echo "</div>";
    return $row["Price"];
}

/**
 * listeners to the buttons
 * (either synchronous or asynchronous ) 
 */
function delete_from_cart_sql($cart_id,$con){
    $sql = "DELETE FROM carts WHERE ID='$cart_id'";
    $res=mysqli_query($con, $sql);
    
}


//miscellaneous

function go_to_error(){
    ?><script>window.location.replace("./unauthorized_user.php");</script><?php
    
}

function loged_in_user(){
    return isset($_SESSION["User_id"]) && isset($_SESSION["Role"]) && isset($_SESSION["User_id"]);
    
}

function back_to_index(){
    ?><script>window.location.replace("./index.php");</script><?php
}
/**
 * an conversion from 
 * js alert to a php alert
 */
function alert($string){
    ?><script> alert("<?php echo $string ?>");</script><?php
}


<?php
session_start();


//sign_up.php
function sign_up_sql($name, $surname,
                     $username, $password, $email, $role,$con){
    
    
    if(same_username_sql($con, $username)){
        echo "please choose another username";
        return ;
    }
    $sql = "INSERT INTO `users` (`Name`, `Surname`, `Username`, `Password`, `Email`, `Role`, `Confirmed`) 
        VALUES ('$name', '$surname', '$username', '$password', '$email', '$role', '0')";
    $res=mysqli_query($con, $sql);
    ?><script>window.location.replace("./index.php");</script><?php
    return;

}
//index.php
function log_in_sql($username, $password,$con){
    $sql = "select * from users WHERE Password=$password and Username='$username' and Confirmed=1;";
    $res=mysqli_query($con, $sql);

    $row=$res->fetch_assoc();
    if($res->num_rows<1) return false;
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
function print_users_sql($con){
    $sql = "select * from users ";
    $res=mysqli_query($con, $sql);

    echo "<table>";
    for($i=0; $i<$res->num_rows; $i++){
        $row=$res->fetch_assoc();
        print_single_user_sql($row, $i,$con);
    }
    echo "</table>";

}

function print_users_ajax_sql($con){
    $sql = "select * from users ";
    $res=mysqli_query($con, $sql);

    echo "<table>";
    for($i=0; $i<$res->num_rows; $i++){
        
        $row=$res->fetch_assoc();
        print_single_user_ajax_sql($row, $i,$con);
        $tmp_id=$row["ID"];
        echo (
            "<th>
        
            <button class=\"button\" type=\"button\" onclick=\"update_user($tmp_id)\"> update</button> <br>
            <button class=\"button\" type=\"button\" onclick=\"delete_user($tmp_id)\"> delete</button> <br>
    
            </th>
            </tr>
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

function print_single_user_ajax_sql($row, $i,$con){
    $tmp_id=$row["ID"];
    echo "<tr id=all$tmp_id>";
    echo "<th>".$row["Username"]."</th>";
    echo "<th>".$row["Email"]."</th>";
    echo "<th>".$row["Role"]."</th>";
    echo "<th><div id=$tmp_id >".$row["Confirmed"]."</div></th>";
    
    
}


function print_single_user_sql($row, $i,$con){
    echo "<tr>";
    echo "<th>".$row["Username"]."</th>";
    echo "<th>".$row["Email"]."</th>";
    echo "<th>".$row["Role"]."</th>";
    echo "<th>".$row["Confirmed"]."</th>";
    ?><!-- button in order to upadte confirm and delete-->
    <th>
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


function update_confirmed_sql($ID, $con){
    $sql = "UPDATE users SET confirmed=1 WHERE ID='$ID'" ;
    $res=mysqli_query($con, $sql);
}

function delete_sql($ID,$con){
    $sql = "DELETE FROM users WHERE ID='$ID'" ;
    $res=mysqli_query($con, $sql);
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

function add_product_sql($seller, $name,$code, $date,
                            $price,$category,$con){
    
    $sql = "INSERT INTO `products` (`Name`, `ProductCode`, `Price`, `DateOfWithdrawal`, `SellerName`, Category) 
        VALUES ('$name', '$code', '$price', '$date', '$seller', '$category')";
    $res=mysqli_query($con, $sql);
    ?><script>window.location.replace("./seller.php");</script><?php
}

function  go_to_update_product_sql($id){
    $_SESSION["product_id"]=$id;
    ?><script>window.location.replace("./update_product_sql.php");</script><?php    

}

function update_product_sql($id, $con,$name,$code,$price,$date,$category){
    $sql = "UPDATE `products` SET Name='$name', ProductCode='$code', Price='$price'
                , DateOfWithdrawal='$date', Category='$category'
            WHERE  ID='$id'";
    $res=mysqli_query($con, $sql);
    ?><script>
        alert("concert was updated succesfully");
        window.location.replace("./seller.php");
    </script><?php
}

function print_sellers_products_sql($creator,$con){
    $sql = "select * from products where  SellerName='$creator'";
    $res=mysqli_query($con, $sql);
    echo "<table>";
    for($i=0; $i<$res->num_rows; $i++){
        $row=$res->fetch_assoc();
        print_single_product_sql($row, $i,$con);
    }
    echo "</table>";
}

function print_single_product_sql($row, $i,$con){
    echo "<tr>";
    echo "<th>".$row["Name"]."</th>";
    echo "<th>".$row["ProductCode"]."</th>";
    echo "<th>".$row["Price"]."</th>";
    echo "<th>".$row["DateOfWithdrawal"]."</th>";
    ?><!-- button in order to upadte confirm and delete-->
    <th>
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

function delete_product_sql($id,$con){
    $sql = "DELETE FROM products WHERE ID='$id'" ;
    $res=mysqli_query($con, $sql);
}

// ajax/sellers
function print_sellers_products_sql_ajax($creator,$con){
    $sql = "select * from products where  SellerName='$creator'";
    $res=mysqli_query($con, $sql);
    echo "<table>";
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
    echo "<th>".$row["Name"]."</th>";
    echo "<th>".$row["ProductCode"]."</th>";
    echo "<th>".$row["Price"]."</th>";
    echo "<th>".$row["DateOfWithdrawal"]."</th>";
    ?><!-- button in order to upadte confirm and delete-->
    <th>
    <form method="post">
        <input type="submit" value="Update product"  
                name="update_product_button<?php echo "_$i"; ?>"  class="button"/> 
        <input type="submit" value="Delete product" 
                onclick="delete_product(<?php echo $id?>)" class="button"/> 
    </form>    
           
    
    </th>
    <?php
    
    if(array_key_exists('update_product_button_'.$i, $_POST)){
        
        go_to_update_product_sql($row["ID"],$con);
        die;
    }
    echo "</tr>";
    
}


//products.php
function print_all_products_sql($con, $user_id){
    $sql = "select * from products";
    $res=mysqli_query($con, $sql);

    echo "<table>";
    for($i=0; $i<$res->num_rows; $i++){
        $row=$res->fetch_assoc();
        print_single_product_user_sql($row, $i,$con,$user_id);
    }
    echo "</table>";
}

function print_single_product_user_sql($row,$i,$con, $user_id){
    echo "<tr>";
    echo "<th>".$row["Name"]."</th>";
    echo "<th>".$row["ProductCode"]."</th>";
    echo "<th>".$row["Price"]."</th>";
    echo "<th>".$row["DateOfWithdrawal"]."</th>";
    ?><!-- button in order to upadte confirm and delete-->
    <th>
    <form  method="post">
        <input class="button" type="submit" value="Add to Cart" 
               name="cart_button<?php echo "_$i"; ?>" class="button"/> <!-- $i in order to create different buttons and listeners for every row -->
    </form>
    </th>
    <?php
    if(array_key_exists('cart_button_'.$i, $_POST)) add_to_cart_sql($row,$con,$user_id);
    echo "</tr>";
}

function add_to_cart_sql($row,$con, $user_id){
    $product_id=(int)$row["ID"];
    $date=date("Y-m-d");
    $sql =  "INSERT INTO `carts` (`ID`, `User_id`, `Product_id`, `DateOfInsertion`) 
        VALUES (NULL, '$user_id', '$product_id', '$date');";
    
    $res=mysqli_query($con, $sql);

}

function search_product_by_productName_sql($productName,$con, $user_id){
    $sql = "select * from products where  Name='$productName'";
    $res=mysqli_query($con, $sql);

    if($res->num_rows==0){
        echo "there is no produxt with that name :(";
        return ;
    }
    echo "<table>";
    for($i=0; $i<$res->num_rows; $i++){
        $row=$res->fetch_assoc();
        print_single_product_user_sql($row, $i,$con, $user_id);
    }
    echo "</table>";
    
}

function search_product_by_sellerName_sql($sellerName,$con, $user_id){
    
    $sql = "select * from products where  SellerName='$sellerName'";
    $res=mysqli_query($con, $sql);
    echo "<table>";
    for($i=0; $i<$res->num_rows; $i++){
        $row=$res->fetch_assoc();
        print_single_product_user_sql($row, $i,$con, $user_id);
    }
    echo "</table>";

}

function search_product_by_category_sql($category,$con, $user_id){
    $sql = "select * from products where  Category='$category'";
    $res=mysqli_query($con, $sql);

    if($res->num_rows==0){
        echo "there are no products in this category";
        return ;
    }
    echo "<table>";
    for($i=0; $i<$res->num_rows; $i++){
        $row=$res->fetch_assoc();
        print_single_product_user_sql($row, $i,$con, $user_id);
    }
    echo "</table>";
}

function search_product_by_date_sql($date,$con, $user_id){
    $sql = "select * from products where  DateOfWithdrawal='$date'";
    $res=mysqli_query($con, $sql);

    if($res->num_rows==0){
        echo "there are no products with this DateOfWithdrawal";
        return ;
    }
    echo "<table>";
    for($i=0; $i<$res->num_rows; $i++){
        $row=$res->fetch_assoc();
        print_single_product_user_sql($row, $i,$con, $user_id);
    }
    echo "</table>";
}

function search_product_by_title_sql($title,$con, $user_id){
    $sql = "select * from products where  Title='$title'";
    $res=mysqli_query($con, $sql);

    if($res->num_rows==0){
        echo "there are no product with this title";
        return ;
    }
    echo "<table>";
    for($i=0; $i<$res->num_rows; $i++){
        $row=$res->fetch_assoc();
        print_single_product_user_sql($row, $i,$con, $user_id);
    }
    echo "</table>";
}

//cart.php


function print_cart($user_id,$con){
    $sql = "SELECT * from carts where User_id='$user_id' ";
    $res=mysqli_query($con, $sql);
    $totCost=0;

    echo "<table>";
    for($i=0; $i<$res->num_rows; $i++){
        $row=$res->fetch_assoc();
        $totCost+=print_single_cart_user_sql($row, $i,$con);
    }
    echo "</table>";
  
    $_SESSION['totCost']=$totCost;
    echo "total cost is ".   $_SESSION['totCost']."$ <br>" ;
}

function print_single_cart_user_sql($row,$i,$con){
    $cart_id=$row["ID"];
    $product_id=$row["Product_id"];
    $sql = "SELECT * from products where ID=$product_id ";
    $res=mysqli_query($con, $sql);
    $row=$res->fetch_assoc();
    echo "<tr>";
    echo "<th>".$row["Name"]."</th>";
    echo "<th>".$row["ProductCode"]."</th>";
    echo "<th>".$row["Category"]."</th>";
    echo "<th>".$row["Price"]."$ </th>";
    
    ?><!-- button in order to upadte confirm and delete-->
    <th>
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
function print_cart_ajax($user_id,$con){
    $sql = "SELECT * from carts where User_id='$user_id' ";
    $res=mysqli_query($con, $sql);
    $totCost=0;

    echo "<table>";
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

function print_single_cart_user_sql_ajax($row, $i,$con){
    $cart_id=$row["ID"];
    $product_id=$row["Product_id"];
    $sql = "SELECT * from products where ID=$product_id ";
    $res=mysqli_query($con, $sql);
    $row=$res->fetch_assoc();
    echo "<tr id=$cart_id>";
    echo "<th>".$row["Name"]."</th>";
    echo "<th>".$row["ProductCode"]."</th>";
    echo "<th>".$row["Category"]."</th>";
    echo "<th>".$row["Price"]."$ </th>";
    
    ?><!-- button in order to upadte confirm and delete-->
    <th>
    <form  method="post">
        <input type="submit" value="delete this" onclick="remove_from_cart(<?php echo $cart_id ?>)"
                class="button"/> <!-- $i in order to create different buttons and listeners for every row -->
    </form>
    </th>

    

    <?php
    echo "</tr>";
    echo "</div>";
    return $row["Price"];
}

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
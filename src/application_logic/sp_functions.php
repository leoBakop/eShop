<?
/*this file consists all the functions
that use curl requests*/
include("parser.php");

//sp stands for second phase
#######################################################################################################
/* functions for keyrock sign up */
function sp_signup($name, $surname,
            $username, $password, $email, $role, $con){
    $token=get_admin_token();
    //create user
    create_user($name, $surname,
                $username, $password, $email, $role, $token);
    
    //find the id of the user added
    $user_id=find_user_keyrock($email, $token)[0];
    $tmp=ask_app_id("e_shop", $token);
    if ($tmp==-1){
        ?><script>alert("a problem has occured");
        window.location.replace("index.php");</script><?php
        die;
    }
    
    //assign role in this user by skipping the keyrock and 
    //add it in user table in description column in mysql
    $sql = "UPDATE user SET description='$role' WHERE ID='$user_id'" ;
    mysqli_query($con, $sql);
    ?><script>window.location.replace("index.php")</script><?php
    die;
}

function create_user($name, $surname,
                        $username, $password, $email, $role, $xtoken){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "http://keyrock:3005/v1/users");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        
        curl_setopt($ch, CURLOPT_POST, TRUE);
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{
            \"user\": {
            \"name\": \"".$name."\",
            \"surname\": \"".$surname."\",
            \"username\": \"".$username."\",
            \"password\": \"".$password."\",
            \"email\": \"".$email."\",
            \"role\": \"".$role."\"
            }
        }");
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "X-Auth-token: ".$xtoken.""
        ));
        
        curl_exec($ch);
        curl_close($ch);
        

}


####################################################################
/* functions for keyrock login */

function sp_login($email, $password, $con){
    $xtoken=get_admin_token();
    $app_id=ask_app_id("e_shop", $xtoken);
    $secret=get_client_id($app_id, $xtoken); //in order to get the base64(clientid:clientsecret)
    $tmp_array=auth_user($email, $password, $secret, $xtoken);
    
    if($tmp_array==-1){
        ?><script>alert("error in login");</script><?php
        die;
    }
    $user_id=$tmp_array[0];
    $access_token=$tmp_array[1];
    $username=$tmp_array[2];
    //last but not least i have to take the role of the entering user
    $role=ask_role_mysql($user_id, $con);
    session_start();
    $_SESSION['User_id']=$user_id;
    $_SESSION['Access_token']=$access_token;
    $_SESSION['Role']=$role;
    $_SESSION['Email']=$email;
    $_SESSION['Username']=$username;
    ?><script>window.location.replace("welcome.php");</script><?php
    
    return;
}


/* function in order to authenticate user */
function auth_user($email, $password, $base64, $xtoken){
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://keyrock:3005/oauth2/token',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'grant_type=password&username='.$email.'&password='.$password.'',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded',
        'Authorization: Basic '.$base64 // this huge string is the base-64(client_id:client_secret) string
      ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    $result1 = json_decode($response);
    if ( $result1 != "Invalid grant: user credentials are invalid"){
        $tmp=find_user_keyrock($email, $xtoken);
        $user_id=$tmp[0];
        $username=$tmp[1];
        return array($user_id, $result1->access_token, $username); //implode in order to return it as string
    }
    return -1;
}

/* function in order to take the role of a 
user given the user_id */
function ask_role_mysql($user_id, $con){
    $sql="SELECT * FROM user WHERE id='$user_id'";
    $res=mysqli_query($con, $sql);
    $row=$res->fetch_assoc();
    return $row['description'];
}

####################################################################
/* miscelanius keyrock functions */
function get_admin_token(){
    $user_creds = array("name"=>"l@tuc.gr","password"=>"admin");

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "http://keyrock:3005/v1/auth/tokens");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_POST, TRUE);

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($user_creds));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:application/json"));
    
      
    $response = curl_exec($ch);
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $header = substr($response, 0, $header_size);
    $body = substr($response, $header_size);

    curl_close($ch);

    $data = http_parse_headers($header);
    return $data['X-Subject-Token'];
}

/* 
function in order to ask the appId from an application 
with a given name
*/

function ask_app_id($app_name, $xtoken){
    $ch = curl_init();
    //request in order to ask all the role for a application
    curl_setopt($ch, CURLOPT_URL, "http://keyrock:3005/v1/applications");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "X-Auth-token: ".$xtoken.""
    ));
    
    $response = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($response, true);
    foreach($result as $key){
        foreach($key as $doc){
            if ($doc['name']==$app_name) return $doc['id'];
        }
    }
    return -1;
   
}

/* function in order to get the 
base64(client_id:clientsecret) of the application */

function get_client_id($app_id, $xtoken){
    $ch = curl_init();
    //request in order to ask all the role for a application
    curl_setopt($ch, CURLOPT_URL, "http://keyrock:3005/v1/applications/".$app_id);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "X-Auth-token: ".$xtoken.""
    ));
    
    $response = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($response, true);
    $result=$result['application'];
    return base64_encode($result['id'].":".$result['secret']);
}

//just lists the users
function find_user_keyrock($email, $xtoken){
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://keyrock:3005/v1/users', 
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        "X-Auth-Token: ".$xtoken.""
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $result = json_decode($response, true);

    foreach($result as $key){
        foreach($key as $doc){
            if($doc['email'] == $email){
                $userid = $doc['id'];
                $username=$doc['username'];
            }
        }
    }
    return array($userid, $username);
}
############################################################################
/*                data storage service and proxy                          */
/* communicate with mongo api */

//products

function sp_print_all_products(){
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://data-storage-proxy:4001/api/api-get-products.php?search=0', 
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET'
    ));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-Auth-Token: '.$_SESSION['Access_token']));
    $response = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($response, true);
    
    //printing the table products
    ?>
    <table>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Date of withdrawl</th>
            <th>Seller Name</th>
            <th>Category</th>
        </tr>
        <?php
        foreach ($result as $row){
            sp_print_product_line($row);
        }
        ?>
    </table>
    <?php
}

function sp_print_searched_products($changes, $search){

    $arr=array('column'=>$changes, 'value'=>$search);
    $data=json_encode($arr);
    $url="http://data-storage-proxy:4001/api/api-get-products.php?search=1";
    
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL,$url);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST,'GET');
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-Auth-Token: '.$_SESSION['Access_token']));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response=curl_exec($curl);
    curl_close($curl);

    $result = json_decode($response, true);
    if($result==null){
        echo "No product with that values";
        return;
    }
    
    //printing the table products
    ?>
    <table>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Date of withdrawl</th>
            <th>Seller Name</th>
            <th>Category</th>
        </tr>
        <?php
        foreach ($result as $row){
            sp_print_product_line($row);
        }
        ?>
    </table>
    <?php
}

function sp_print_product_line($row){
    $id=$row['id_c'];
    echo "<tr>";
    echo "<td>".$row['Name']."</td>";
    echo "<td>".$row['Price']."</td>";
    echo "<td>".$row['DateOfWithdrawl']."</td>";
    echo "<td>".$row['SellerName']."</td>";
    echo "<td>".$row['Category']."</td>";
    //echo button
    echo "<form method=\"post\">";
    echo "<td id=$id>";?><input type="submit" class="button" name="cart_<?php echo $id; ?>" value="Add to cart"><?php echo "</td>";
    echo "</form>";
    echo "</tr>";
    //echo listeners

    if(array_key_exists("cart_".$id, $_POST)) sp_add_to_cart($_SESSION['User_id'], $row);
}

function sp_add_to_cart($user_id, $row){
    $arr=array('user_id'=>$user_id, 'product_id'=>$row['id_c'], 'product_name'=>$row['Name'], 'Price'=>$row['Price']);
    $data=json_encode($arr);
    $url="http://data-storage-proxy:4001/api/api-add-to-cart.php";
    
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL,$url);
    curl_setopt($curl, CURLOPT_POST, TRUE);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST,'POST');
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-Auth-Token: '.$_SESSION['Access_token']));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response=curl_exec($curl);
    curl_close($curl);
}

//cart

function sp_print_cart(){
    $totCost=0;
    $user_id=$_SESSION['User_id'];

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://data-storage-proxy:4001/api/api-get-cart.php?user_id='.$user_id, 
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET'
    ));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-Auth-Token: '.$_SESSION['Access_token']));
    $response = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($response, true);
    ?> 
    <table>
        <tr>
            <th>Product name</th>
            <th>Date of Insertion</th>
            <th>Price</th>
        </tr> 
    <?php

    foreach($result as $row){
        $totCost+=sp_print_cart_line($row);
    }
    ?>
    </table>

    <script src="./application_logic/jquery-3.6.1.js"></script>
    <script type="text/javascript">
    
    function sp_remove_from_cart(id){

        $.ajax({
            type:'post',
            url:'./application_logic/ajax_functions_sp.php',
            data:{function: 'sp_remove_from_cart', id:id},
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


function sp_print_cart_line($row){
    $cart_id=$row['id_c'];
    echo "<tr id=$cart_id>";
        echo "<td>".$row['product_name']."</td>";
        echo "<td>".$row['date']."</td>";
        echo "<td>".$row['price']."</td>";

        //creation off ajax function in order to 
        //remove sth from cart
        ?> 
        <th class="normal_th">
            <form  method="post">
                <input type="submit" value="delete this" onclick="sp_remove_from_cart(<?php echo $cart_id ?>)"
                    class="button"/> 
            </form>
        </th>
        <?php
    echo "</tr>";
    return $row["price"];
}

//method that is called from ajax_functions.php
function sp_remove_from_cart($id_c, $x_auth_token){
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://data-storage-proxy:4001/api/api-delete-from-cart.php?id_c='.$id_c, 
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    ));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-Auth-Token: '.$x_auth_token));
    curl_exec($curl);
    curl_close($curl);
}


//seller 
//add product

function sp_add_product($name, $product_code, $price, $date, $category){
    
    $arr=array('name'=>$name, 'product_code'=>$product_code, 
                'price'=>$price,'date'=>$date, 'sellerName'=>$_SESSION['Username'], 
                'category'=>$category );

    $data=json_encode($arr);
    $url="http://data-storage-proxy:4001/api/api-add-product.php";
    
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL,$url);
    curl_setopt($curl, CURLOPT_POST, TRUE);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST,'POST');
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-Auth-Token: '.$_SESSION['Access_token']));
    curl_exec($curl);
    curl_close($curl);
}

//print all products for a specific seller
function sp_print_seller_products(){
    $user_name=$_SESSION['Username'];

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://data-storage-proxy:4001/api/api-get-seller-products.php?seller_name='.$user_name, 
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET'
    ));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-Auth-Token: '.$_SESSION['Access_token']));
    $response = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($response, true);
    ?>
    <table>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Product Code</th>
            <th>Date of withdrawl</th>
            <th>Category</th>
        </tr>
        <?php
        foreach($result as $row){
            sp_print_seller_product_line($row);
        }
        ?>
    </table>
    <script src="./application_logic/jquery-3.6.1.js"></script>
    <script type="text/javascript">
    
    function sp_delete_seller_product(id){
        alert(id);
         $.ajax({
            type:'post',
            url:'./application_logic/ajax_functions_sp.php',
            data:{function: 'sp_delete_seller_product', id:id},
            success:function(data){
                $('#'+id).detach();

            }
        }); 
    
    };
    </script>


    <?php
}

function sp_print_seller_product_line($row){
    $id_c=$row['id_c'];
    echo "<tr id=$id_c>";
        echo "<td>".$row['Name']."</td>";
        echo "<td>".$row['Price']."</td>";
        echo "<td>".$row['Product_code']."</td>";
        echo "<td>".$row['DateOfWithdrawl']."</td>";
        echo "<td>".$row['Category']."</td>";
        ?> 
        <th class="normal_th">
            <form  method="post">
                <input type="submit" value="delete this" onclick="sp_delete_seller_product(<?php echo $id_c ?>)"
                    class="button"/> 
                <input type="submit" value="Update product" 
                    name="update_product_button<?php echo "_$id_c"; ?>"  class="button"/> 
            </form>
        </th>
        <?php
    echo "</tr>";

    if(array_key_exists('update_product_button_'.$id_c, $_POST)){ 
        //just a method in order to navigate to the update product page
        //stores the product id in order to use ot in update_product_sql.php (name for the first phase)
        go_to_update_product_sql($id_c);
        die;
    }
}


//method that is called from ajax_functions.php
function sp_delete_seller_product($id_c, $x_auth_token){
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://data-storage-proxy:4001/api/api-delete-from-seller-products.php?id_c='.$id_c, 
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    ));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-Auth-Token: '.$x_auth_token));
    curl_exec($curl);
    curl_close($curl);
}


function sp_update_product($product_id, $changes, $value){
    $arr=array('id_c'=>$product_id, 'column'=>$changes, 'value'=>$value);

    $data=json_encode($arr);
    $url="http://data-storage-proxy:4001/api/api-update-seller-product.php";

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL,$url);
    curl_setopt($curl, CURLOPT_POST, TRUE);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST,'PUT');
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-Auth-Token: '.$_SESSION['Access_token']));
    curl_exec($curl);
    curl_close($curl);
}
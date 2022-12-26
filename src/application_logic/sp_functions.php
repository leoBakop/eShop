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
    $user_id=find_user_keyrock($email, $token);
    $tmp=ask_app_id("e_shop", $token);
    if ($tmp==-1){
        ?><script>alert("a problem was occured");
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
            sp_print_product($row);
        }
        ?>
    </table>
    <?php
}

function sp_print_searched_products($changes, $search){
    echo ($changes."  ".$search."<br>");
    echo $_SESSION['Access_token']."<br>";
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

    var_dump($response);
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
            sp_print_product($row);
        }
        ?>
    </table>
    <?php
}

function sp_print_product($row){
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
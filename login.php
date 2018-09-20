<?php
  session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <style>
            body{
                border: 6px solid #4CAF50;
                padding: 9px;
            }
            input[type=text], input[type=password]{
                width: 98%;
                padding: 12px 20px;
                margin: 10px 0;
                display: inline-block;
                border: 1px solid #ccc;
                box-sizing: border-box;
            }
            button{
                background-color: #4CAF50;
                color: white;
                padding: 12px 20px;
                margin: 17px 0;
                cursor: pointer;
                width: 49%;
                border: 1px solid #ccc;
            }
            button:hover{
                opacity: 0.8;
            }
            .container{
                padding: 24px;
            }
        </style>
    </head>
    <body>
        <?php
            $db_host = "dbhome.cs.nctu.edu.tw";
            $db_name = "hwpeng0521_cs_hw1";
            $db_user = "hwpeng0521_cs";
            $db_password = "way860521";
            $db = new mysqli($db_host, $db_user, $db_password, $db_name);
            if($db->connect_error){
                die("Connection failed: " . $db->connect_error);
            }
            if(isset($_POST['login'])){
                $user = $_POST['uname'];
                $password = $_POST['psw'];
                $password = hash('sha384', $password);

                $stmt = "select * FROM hw1 where account = ? and password = ?";
                if($select = $db->prepare($stmt)){
                    $select->bind_param('ss', $user, $password);
                    $select->execute();
                    $result = $select->get_result();
                }
                else echo "Fail to prepare";
                
                if(mysqli_num_rows($result) > 0){
                    $row = mysqli_fetch_assoc($result);
                    echo "login success";
                    $_SESSION["id"] = $row['id'];
                    $_SESSION["name"] = $row['name'];
                    $_SESSION["user"] = $row['account'];
                    $_SESSION["mail"] = $row['mail'];
                    $_SESSION["identity"] = $row['identity'];
                    $_SESSION['fid'] = '';
                    $_SESSION['fname'] = '';
                    $_SESSION['Pf'] = '';
                    $_SESSION['Pt'] = '';
                    $_SESSION['price'] = '';
                    $_SESSION['flocation'] = '';
                    $_SESSION['ftime'] = '';
                    $_SESSION['fowner'] = '';
                    $_SESSION['order'] = 'ORDER by H.id';
                    $_SESSION['info1'] = "";
                    $_SESSION['info2'] = "";
                    $_SESSION['info3'] = "";
                    $_SESSION['info4'] = "";
                    $_SESSION['info5'] = "";
                    $_SESSION['info6'] = "";
                    $_SESSION['info7'] = "";
                    $_SESSION['info8'] = "";
                    $_SESSION['info9'] = "";
                    $_SESSION['info10'] = "";
                    if($_SESSION["identity"] == "user"){
                        echo '<script>window.location.assign("http://people.cs.nctu.edu.tw/~hwpeng0521/home.php")</script>';
                    }
                    else if($_SESSION["identity"] == "admin"){
                        echo '<script>window.location.assign("http://people.cs.nctu.edu.tw/~hwpeng0521/home.php")</script>';
                    }
                }
                else{
                    echo "wrong username or password";
                }
            }
            $db->close();
        ?>
        <form method="post">
            <div class="container">
                <input type="text" placeholder="Enter Username Here" name="uname" required>
                <input type="password" placeholder="Enter Password Here" name="psw" required>
                <button type="submit" name = 'login'>Login</button>
                <button type="button" onclick = 'window.location.assign("http://people.cs.nctu.edu.tw/~hwpeng0521/register.php")'>Register</button>
            </div>
        </form>
    </body>
</html>
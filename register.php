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
        width: 98%;
        border: 1px solid #ccc;
      }
      button:hover {
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
      if(isset($_POST['submit'])){
        $user = $_POST['user'];
        $mail = $_POST['mail'];
        $stmt = "select account FROM hw1 where account = ?";
        if($select = $db->prepare($stmt)){
          $select->bind_param('s', $user);
          $select->execute();
          $result = $select->get_result();
        }
        else echo "Fail to prepare";
        if(preg_match('/\s/',$user)){
          echo "No Space in Username, Sorry.";
        }
        if(!(preg_match('/.*@.*\..*/',$mail))){
          echo "There should be at least one '@'' and '.', '@' should appear before '.'.";
        }
        else if(mysqli_num_rows($result) <= 0){
          $password = $_POST['psw'];
          $confirm = $_POST['pswf'];
          if($password == $confirm){
            $password = hash('sha384', $password);
            $name = $_POST['name'];
            $stmt = "INSERT into hw1 (account, password, name, mail, identity) VALUES (?, '$password', ?, ?, 'user') ";
            if($insert = $db->prepare($stmt)){
              $insert->bind_param('sss', $user, $name, $mail);
              $insert->execute();
              echo '<script>window.location.assign("http://people.cs.nctu.edu.tw/~hwpeng0521/login.php")</script>';
            }
            else echo "Fail to prepare";
          }
        else
          echo "Please Confirm Your Password Again.";
        }
        else
          echo "Username Has Been Registered, Please Pick Another User Name.";
      }
      $db->close();
    ?>
    <form  method="post">
      <div class="container">
        <input type="text" placeholder="Your Username" name="user" required>
        <input type="password" placeholder="Your Password" name="psw" required>
        <input type="password" placeholder="Confirm Password" name="pswf" required>
        <input type="text" placeholder="Your Name" name="name" required>
        <input type="text" placeholder="Your Email" name="mail" required>
        <button type="submit" name = 'submit'>Register</button>
      </div>
    </form>
  </body>
</html>
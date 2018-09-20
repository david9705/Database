<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <style>
      input[type=text],input[type=password]{
        width: 10%;
        padding: 12px 20px;
        margin: 10px 5px;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
      }
      body{
        border: 6px solid #4CAF50;
        padding: 9px;
      }
      td{
        color: #4CAF50;
      }
      h1{
        color: #4CAF50;
        padding: 16px 20px;
      }
      h2{
        color: #4F4F4F;
        padding: 8px 10px;
      }
      button{
        background-color: #4CAF50;
        color: white;
        padding: 12px 6px;
        margin: 3px 6px;
        cursor: pointer;
        width: 160px;
        border: 1px solid #ccc;
      }
      button:hover {
        opacity: 0.8;
      }
      .container{
        padding: 24px;
      }
      .size{
        width: 15%;
        margin: 10px 5px;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <button type="button" style="float: right;" onclick = 'window.location.assign("http://people.cs.nctu.edu.tw/~hwpeng0521/home.php")' class = "size">Home Page</button>
      <h1>
        Name
      </h1>
      <h2>
        <?php echo $_SESSION['name'] ?>
      </h2>
      <h1>
        User
      </h1>
      <h2>
        <?php echo $_SESSION['user'] ?>
      </h2>
      <h1>
        Mail
      </h1>
      <h2>
        <?php echo $_SESSION['mail'] ?>
      </h2>
      <form method ='post'>
        <input type="text" placeholder="Username" name="user" required>
        <input type="password" placeholder="Password" name="psw" required>
        <input type="password" placeholder="Confirm Password" name="pswf" required>
        <input type="text" placeholder="Name" name="name" required>
        <input type="text" placeholder="Email" name="mail" required>
        <input type="text" placeholder="Identity" name="id" required>
        <button type="Submit" name = "add" class = "size">Add</button>
      </form>
      <table>
        <tr>
          <th><h1>ID</h1></th>
          <th><h1>Name</h1></th>
          <th><h1>Account</h1></th>
          <th><h1>mail</h1></th>
          <th><h1>Identity</h1></th>
        </tr>
    <?php
      if($_SESSION['identity'] == "admin"){
        $db_host = "dbhome.cs.nctu.edu.tw";
        $db_name = "hwpeng0521_cs_hw1";
        $db_user = "hwpeng0521_cs";
        $db_password = "way860521";
        $db = new mysqli($db_host, $db_user, $db_password, $db_name);
        if($db->connect_error){
            die("Connection failed: " . $db->connect_error);
        }
        $select = "select * FROM hw1";
        $result = mysqli_query($db, $select);
        while($eachUser = $result->fetch_assoc()){
    ?>
        <tr>
          <form method='post'>
            <td><h2><?php echo $eachUser["id"] ?></h2></td>
            <td><h2><?php echo $eachUser["name"] ?></h2></td>
            <td><h2><?php echo $eachUser["account"] ?></h2></td>
            <td><h2><?php echo $eachUser["mail"] ?></h2></td>
            <td><h2><?php echo $eachUser["identity"] ?></h2></td>
            <td><button type="Submit" name = 'promote'>Promote</button></td>
            <td><button type="Submit" name = 'delete'>Delete</button></td>
            <td><?php echo "<input type = 'hidden' value =".$eachUser['id']." name='id'>";?></td>
          </form>
        </tr>  
    <?php
        }
      }
      else echo "No Authority!";
      if(isset($_POST['promote'])){
        $Pid = $_POST['id'];
        $update = "UPDATE hw1 SET identity = 'admin' WHERE id = '$Pid'";
        mysqli_query($db, $update);
        echo '<script>window.location.assign("http://people.cs.nctu.edu.tw/~hwpeng0521/member_management.php")</script>';
      }
      else if(isset($_POST['delete'])){
        $Did = $_POST['id'];
        $delete = "DELETE FROM hw1 WHERE id = '$Did'";
        mysqli_query($db, $delete);
        echo '<script>window.location.assign("http://people.cs.nctu.edu.tw/~hwpeng0521/member_management.php")</script>';
      }
      else if(isset($_POST['add'])){
        $user = $_POST['user'];
        $mail = $_POST['mail'];
        $stmt = "SELECT account FROM hw1 where account = ?";
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
            $identity = $_POST['id'];
            $stmt = "INSERT into hw1 (account, password, name, mail, identity) VALUES (?, '$password', ?, ?, ?)";
            if($insert = $db->prepare($stmt)){
              $insert->bind_param('ssss', $user, $name, $mail ,$identity);
              $insert->execute();
            }
            else echo "Fail to prepare";
            echo '<script>window.location.assign("http://people.cs.nctu.edu.tw/~hwpeng0521/member_management.php")</script>';
            }
          else
            echo "Please Confirm Your Password Again.";
        }
        else
          echo "Username Has Been Registered, Please Pick Another User Name.";
      }
      else if(isset($_POST['logout'])){
        session_unset(); 
        session_destroy();
        echo '<script>window.location.assign("http://people.cs.nctu.edu.tw/~hwpeng0521/login.php")</script>';
        $db->close();
      }
    ?>
      </table>
      <form method ='post'>
        <button type="Submit" name = "logout" class = "size">Logout</button>
      </form>
    </div>
  </body>
</html>
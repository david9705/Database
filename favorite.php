<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <style>
      input[type=text]{
        width: 10%;
        padding: 12px 20px;
        margin: 10px 5px;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
      }
      .price{
        width: 4.9%;
      }
      input[type=checkbox]{
        width: 2%;
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
      .big_button{
        width:30%;
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
      .small{
        background-color: #ccc;
        width: 24px;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <button type="button" style="float: right;" onclick = 'window.location.assign("http://people.cs.nctu.edu.tw/~hwpeng0521/home.php")' class = "size">Home Page</button>
      <br>
      <table><form  method='post'>
        <tr>
          <th><h1>ID</h1></th>
          <th><h1>Name</h1></th>
          <th><h1>Price</h1></th>
          <th><h1>Location</h1></th>
          <th><h1>Time</h1></th>
          <th><h1>Owner</h1></th>
          <th><h1>information</h1></th>
        </tr></form>
    <?php
      if($_SESSION['identity'] == "user" || $_SESSION['identity'] == "admin"){
        $db_host = "dbhome.cs.nctu.edu.tw";
        $db_name = "hwpeng0521_cs_hw1";
        $db_user = "hwpeng0521_cs";
        $db_password = "way860521";
        $db = new mysqli($db_host, $db_user, $db_password, $db_name);
        if($db->connect_error){
            die("Connection failed: " . $db->connect_error);
        }
        $s1 = $_SESSION['id'];
        if($select = $db->prepare(
          "SELECT H.id, H.name, price, location, time_, hw1.name, information 
          FROM House H 
          INNER JOIN hw1 ON H.owner_id = hw1.id 
          LEFT JOIN Information I ON H.id = I.house_id
          INNER JOIN Favorite F ON H.id = F.favorite_id 
          WHERE F.user_id = $s1")){
          $select->execute();
        }
        else echo "Fail to prepare!";
        $result = $select->get_result();
        $last_id = 0;
        while($eachHouse = $result->fetch_row()){
          if($last_id != $eachHouse[0]){
    ?>
            <tr>
              <form method='post'>
                <td><h2><?php echo $eachHouse[0] ?></h2></td>
                <td><h2><?php echo $eachHouse[1] ?></h2></td>
                <td><h2><?php echo $eachHouse[2] ?></h2></td>
                <td><h2><?php echo $eachHouse[3] ?></h2></td>
                <td><h2><?php echo $eachHouse[4] ?></h2></td>
                <td><h2><?php echo $eachHouse[5] ?></h2></td>
                <td><h2><?php echo $eachHouse[6] ?></h2></td>
                <td><button type="Submit" name = 'delete'>Delete</button></td>
                <td><?php echo "<input type = 'hidden' value =".$eachHouse[0]." name='Hid'>";?>
                <?php $last_id = $eachHouse[0] ?>
              </form>
            </tr>  
    <?php
          }
          else{
    ?>
            <tr>
              <td><h2><?php echo "-" ?></h2></td>
              <td><h2><?php echo " " ?></h2></td>
              <td><h2><?php echo " " ?></h2></td>
              <td><h2><?php echo " " ?></h2></td>
              <td><h2><?php echo " " ?></h2></td>
              <td><h2><?php echo " " ?></h2></td>
              <td><h2><?php echo $eachHouse[6] ?></h2></td>
            </tr>
    <?php
          }
        }
        if($last_id == 0){
          echo "You don’t have any house in favorite yet.";
        }
      }
      else echo "No Authority!";
      if(isset($_POST['delete'])){
        $Hid = $_POST['Hid'];
        mysqli_query($db, "DELETE FROM Favorite WHERE favorite_id = $Hid");
        echo '<script>window.location.assign("http://people.cs.nctu.edu.tw/~hwpeng0521/favorite.php")</script>';
      }
      if(isset($_POST['logout'])){
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
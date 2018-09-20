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
        <button type="Submit" name = "toadd" class = "size">Add</button><br>
        <?php
          if(isset($_POST['toadd'])){
        ?>
            <tr>
              <input type="text" placeholder="name" name="aname">
              <input type="text" placeholder="price " name="aprice">
              <input type="text" placeholder="location" name="alocation">
              <input type="text" placeholder="time" name="atime"><br>
            </tr>
            <tr>
              <input type="checkbox" name="ainfo1" value="1">Laundry facilities
              <input type="checkbox" name="ainfo2" value="2">Wifi
              <input type="checkbox" name="ainfo3" value="3">Lockers
              <input type="checkbox" name="ainfo4" value="4">Kitchen
              <input type="checkbox" name="ainfo5" value="5">Elevator
              <input type="checkbox" name="ainfo6" value="6">No smoking
              <input type="checkbox" name="ainfo7" value="7">Television
              <input type="checkbox" name="ainfo8" value="8">Breakfast
              <input type="checkbox" name="ainfo9" value="9">Toiletries provided
              <input type="checkbox" name="ainfo10" value="10">Shuttle service
              <button type="Submit" name = 'add'>Submit</button>
              <button type="button" onclick = 'window.location.assign("http://people.cs.nctu.edu.tw/~hwpeng0521/house_management.php")'>Cancel</button><br>
            </tr>
        <?php
          }
        ?>
        <button type="Submit" name = "toupdate" class = "size">Update</button><br>
        <?php
          if(isset($_POST['toupdate'])){
        ?>
            <tr>
              <input type="text" placeholder="id" name="uid">
              <input type="text" placeholder="name" name="uname">
              <input type="text" placeholder="price " name="uprice">
              <input type="text" placeholder="location" name="ulocation">
              <input type="text" placeholder="time" name="utime"><br>
            </tr>
            <tr>
              <input type="checkbox" name="uinfo1" value="1">Laundry facilities
              <input type="checkbox" name="uinfo2" value="2">Wifi
              <input type="checkbox" name="uinfo3" value="3">Lockers
              <input type="checkbox" name="uinfo4" value="4">Kitchen
              <input type="checkbox" name="uinfo5" value="5">Elevator
              <input type="checkbox" name="uinfo6" value="6">No smoking
              <input type="checkbox" name="uinfo7" value="7">Television
              <input type="checkbox" name="uinfo8" value="8">Breakfast
              <input type="checkbox" name="uinfo9" value="9">Toiletries provided
              <input type="checkbox" name="uinfo10" value="10">Shuttle service
              <button type="Submit" name = 'update'>Submit</button>
              <button type="button" onclick = 'window.location.assign("http://people.cs.nctu.edu.tw/~hwpeng0521/house_management.php")'>Cancel</button><br>
            </tr>
        <?php
          }
        ?>
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
          WHERE hw1.id = $s1")){
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
          echo "You don’t own any house yet.";
        }
      }
      else echo "No Authority!";
      if(isset($_POST['delete'])){
        $Hid = $_POST['Hid'];
        mysqli_query($db, "DELETE FROM House WHERE id = $Hid");
        echo '<script>window.location.assign("http://people.cs.nctu.edu.tw/~hwpeng0521/house_management.php")</script>';
      }
      if(isset($_POST['add'])){
        if($_POST['aname'] != '' && $_POST['aprice'] != '' && $_POST['alocation'] != '' && $_POST['atime'] != ''){
          $i2 = $_POST['aname'];
          $i3 = $_POST['aprice'];
          $i4 = $_POST['alocation'];
          $i5 = $_POST['atime'];
          $i6 = $_SESSION['id'];;
          if($insert = $db->prepare(
          "INSERT INTO House (name, price, location, time_, owner_id)
          VALUES (?, ?, ?, ?, ?)")){
            $insert->bind_param('sssss', $i2, $i3, $i4, $i5, $i6);
            $insert->execute();
          }
          else echo "Fail to insert to House!";
        }
        else echo "Please fill the information in the blanks properly.";
        $result = mysqli_query($db, "SELECT max(id) FROM House");
        $max = $result->fetch_row();
        $aid = $max[0];
        if(isset($_POST['ainfo1'])){
          $db->query("INSERT INTO Information (information, house_id) VALUES ('laundry facilities', $aid)");
        }
        if(isset($_POST['ainfo2'])){
          $db->query("INSERT INTO Information (information, house_id) VALUES ('wifi', $aid)");
        }
        if(isset($_POST['ainfo3'])){
          $db->query("INSERT INTO Information (information, house_id) VALUES ('lockers', $aid)");
        }
        if(isset($_POST['ainfo4'])){
          $db->query("INSERT INTO Information (information, house_id) VALUES ('kitchen', $aid)");
        }
        if(isset($_POST['ainfo5'])){
          $db->query("INSERT INTO Information (information, house_id) VALUES ('elevator', $aid)");
        }
        if(isset($_POST['ainfo6'])){
          $db->query("INSERT INTO Information (information, house_id) VALUES ('no smoking', $aid)");
        }
        if(isset($_POST['ainfo7'])){
          $db->query("INSERT INTO Information (information, house_id) VALUES ('television', $aid)");
        }
        if(isset($_POST['ainfo8'])){
          $db->query("INSERT INTO Information (information, house_id) VALUES ('breakfast', $aid)");
        }
        if(isset($_POST['ainfo9'])){
          $db->query("INSERT INTO Information (information, house_id) VALUES ('toiletries provided', $aid)");
        }
        if(isset($_POST['ainfo10'])){
          $db->query("INSERT INTO Information (information, house_id) VALUES ('shuttle service', $aid)");
        }
        echo '<script>window.location.assign("http://people.cs.nctu.edu.tw/~hwpeng0521/house_management.php")</script>';
      }
      if(isset($_POST['update'])){
        if($_POST['uid'] != ''){
          $u1 = $_POST['uid'];
          $u2 = $_SESSION['id'];
          if($select = $db->prepare("SELECT id FROM House WHERE id = ? and owner_id = $u2")){
            $select->bind_param('s', $u1);
            $select->execute();
          }
          else echo "Fail to prepare!";
          $result = $select->get_result();
          if(mysqli_num_rows($result) > 0){
            $edit_house = $result->fetch_row();
            $hid = $edit_house[0];
            if($_POST['uname'] != ''){
              $temp = $_POST['uname'];
              if($update = $db->prepare("UPDATE House SET name = ? WHERE id = $hid")){
                $update->bind_param('s', $temp);
                $update->execute();
              }
              else echo "Fail to prepare, uname!";
            }
            if($_POST['uprice'] != ''){
              $temp = $_POST['uprice'];
              if($update = $db->prepare("UPDATE House SET price = ? WHERE id = $hid")){
                $update->bind_param('s', $temp);
                $update->execute();
              }
              else echo "Fail to prepare, uprice!";
            }
            if($_POST['ulocation'] != ''){
              $temp = $_POST['ulocation'];
              if($update = $db->prepare("UPDATE House SET location  = ? WHERE id = $hid")){
                $update->bind_param('s', $temp);
                $update->execute();
              }
              else echo "Fail to prepare, ulocation!";
            }
            if($_POST['utime'] != ''){
              $temp = $_POST['utime'];
              if($update = $db->prepare("UPDATE House SET time_ = ? WHERE id = $hid")){
                $update->bind_param('s', $temp);
                $update->execute();
              }
              else echo "Fail to prepare, utime!";
            }
            mysqli_query($db, "DELETE FROM Information WHERE house_id = $hid");
            if(isset($_POST['uinfo1'])){
              mysqli_query($db, "INSERT INTO Information (information, house_id) VALUES ('laundry facilities', $hid)");
            }
            if(isset($_POST['uinfo2'])){
              mysqli_query($db, "INSERT INTO Information (information, house_id) VALUES ('wifi', $hid)");
            }
            if(isset($_POST['uinfo3'])){
              mysqli_query($db, "INSERT INTO Information (information, house_id) VALUES ('lockers', $hid)");
            }
            if(isset($_POST['uinfo4'])){
              mysqli_query($db, "INSERT INTO Information (information, house_id) VALUES ('kitchen', $hid)");
            }
            if(isset($_POST['uinfo5'])){
              mysqli_query($db, "INSERT INTO Information (information, house_id) VALUES ('elevator', $hid)");
            }
            if(isset($_POST['uinfo6'])){
              mysqli_query($db, "INSERT INTO Information (information, house_id) VALUES ('no smoking', $hid)");
            }
            if(isset($_POST['uinfo7'])){
              mysqli_query($db, "INSERT INTO Information (information, house_id) VALUES ('television', $hid)");
            }
            if(isset($_POST['uinfo8'])){
              mysqli_query($db, "INSERT INTO Information (information, house_id) VALUES ('breakfast', $hid)");
            }
            if(isset($_POST['uinfo9'])){
              mysqli_query($db, "INSERT INTO Information (information, house_id) VALUES ('toiletries provided', $hid)");
            }
            if(isset($_POST['uinfo10'])){
              mysqli_query($db, "INSERT INTO Information (information, house_id) VALUES ('shuttle service', $hid)");
            }
            echo '<script>window.location.assign("http://people.cs.nctu.edu.tw/~hwpeng0521/house_management.php")</script>';
          }
          else echo "Enter correct id to choose which house to update.";
        }
        else echo "Enter id to choose which house to update.";
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
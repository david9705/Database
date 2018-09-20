<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <style>
      input[type=text], input[type=number]{
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
      <button type="button" onclick = 'window.location.assign("http://people.cs.nctu.edu.tw/~hwpeng0521/house_management.php")' class = "big_button">House Management Page</button>
      <button type="button" onclick = 'window.location.assign("http://people.cs.nctu.edu.tw/~hwpeng0521/favorite.php")' class = "big_button">Favorite List Page</button>
      <?php
        if($_SESSION['identity'] == "admin"){
      ?>
        <button type="button" onclick = 'window.location.assign("http://people.cs.nctu.edu.tw/~hwpeng0521/member_management.php")' class = "big_button">Member Management Page</button>
      <?php
        }
        $fid = $_SESSION['fid'];
        $fname = $_SESSION['fname'];
        $Pf = $_SESSION['Pf'];
        $Pt = $_SESSION['Pt'];
        $flocation = $_SESSION['flocation'];
        $ftime = $_SESSION['ftime'];
        $fowner = $_SESSION['fowner'];
        if($_SESSION['info1'] != '') $finfo1 = "and I.house_id IN (SELECT house_id FROM Information WHERE information = 'laundry facilities')";
        else $finfo1 = '';
        if($_SESSION['info2'] != '') $finfo2 = "and I.house_id IN (SELECT house_id FROM Information WHERE information = 'wifi')";
        else $finfo2 = '';
        if($_SESSION['info3'] != '') $finfo3 = "and I.house_id IN (SELECT house_id FROM Information WHERE information = 'lockers')";
        else $finfo3 = '';
        if($_SESSION['info4'] != '') $finfo4 = "and I.house_id IN (SELECT house_id FROM Information WHERE information = 'kitchen')";
        else $finfo4 = '';
        if($_SESSION['info5'] != '') $finfo5 = "and I.house_id IN (SELECT house_id FROM Information WHERE information = 'elevator')";
        else $finfo5 = '';
        if($_SESSION['info6'] != '') $finfo6 = "and I.house_id IN (SELECT house_id FROM Information WHERE information = 'no smoking')";
        else $finfo6 = '';
        if($_SESSION['info7'] != '') $finfo7 = "and I.house_id IN (SELECT house_id FROM Information WHERE information = 'television')";
        else $finfo7 = '';
        if($_SESSION['info8'] != '') $finfo8 = "and I.house_id IN (SELECT house_id FROM Information WHERE information = 'breakfast')";
        else $finfo8 = '';
        if($_SESSION['info9'] != '') $finfo9 = "and I.house_id IN (SELECT house_id FROM Information WHERE information = 'toiletries provided')";
        else $finfo9 = '';
        if($_SESSION['info10'] != '') $finfo10 = "and I.house_id IN (SELECT house_id FROM Information WHERE information = 'shuttle service')";
        else $finfo10 = '';
      ?>
      <br>
      <table><form  method='post'>
      	<tr>
      		<input type="text" placeholder="Find id" name="id" value= '<?php echo "$fid"; ?>'>
      		<input type="text" placeholder="Find name" name="name" value= '<?php echo "$fname"; ?>'>
      		<input type="number" placeholder="Price from 0" name="Pf" class="price" value= '<?php echo "$Pf"; ?>'>
      		<input type="number" placeholder="Price to 99999999" name="Pt" class="price" value= '<?php echo "$Pt"; ?>'>
      		<input type="text" placeholder="Find location" name="location" value= '<?php echo "$flocation"; ?>'>
      		<input type="text" placeholder="Find time" name="time" value= '<?php echo "$ftime"; ?>'>
      		<input type="text" placeholder="Find owner" name="owner" value= '<?php echo "$fowner"; ?>'><br>
      	</tr>
        <tr>
          <input type="checkbox" name="info1" value="1" <?php if ($finfo1 != "") echo "checked";?>>Laundry facilities
          <input type="checkbox" name="info2" value="2" <?php if ($finfo2 != "") echo "checked";?>>Wifi
          <input type="checkbox" name="info3" value="3" <?php if ($finfo3 != "") echo "checked";?>>Lockers
          <input type="checkbox" name="info4" value="4" <?php if ($finfo4 != "") echo "checked";?>>Kitchen
          <input type="checkbox" name="info5" value="5" <?php if ($finfo5 != "") echo "checked";?>>Elevator
          <input type="checkbox" name="info6" value="6" <?php if ($finfo6 != "") echo "checked";?>>No smoking
          <input type="checkbox" name="info7" value="7" <?php if ($finfo7 != "") echo "checked";?>>Television
          <input type="checkbox" name="info8" value="8" <?php if ($finfo8 != "") echo "checked";?>>Breakfast
          <input type="checkbox" name="info9" value="9" <?php if ($finfo9 != "") echo "checked";?>>Toiletries provided
          <input type="checkbox" name="info10" value="10" <?php if ($finfo10 != "") echo "checked";?>>Shuttle service
          <button type="Submit" name = 'find'>Find</button>
          <button type="Submit" name = 'showall'>Show all</button>
        </tr>
        <tr>
         	<th><h1>ID</h1></th>
         	<th><h1>Name</h1></th>
         	<th><h1>
         	<button type="Submit" name = 'price_up' class = "small">↑</button>
         		Price
            <button type="Submit" name = 'price_down' class = "small">↓</button>
          	</h1></th>
          	<th><h1>Location</h1></th>
          	<th><h1>
            <button type="Submit" name = 'time_up' class = "small">↑</button>
            	Time
            <button type="Submit" name = 'time_down' class = "small">↓</button>
          	</h1></th>
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
        $s6 = $_SESSION["price"];
        $s7 = $_SESSION["order"];
        if($select = $db->prepare(
          "SELECT H.id, H.name, price, location, time_, hw1.name, information 
          FROM House H 
          INNER JOIN hw1 ON H.owner_id = hw1.id 
          LEFT JOIN Information I ON H.id = I.house_id 
          WHERE H.id like ? and H.name like ? and location like ? and time_ like ? and hw1.name like ? $s6 $finfo1 $finfo2 $finfo3 $finfo4 $finfo5 $finfo6 $finfo7 $finfo8 $finfo9 $finfo10 $s7")){
          $s1 = "%{$fid}%";
          $s2 = "%{$fname}%";
          $s3 = "%{$flocation}%";
          $s4 = "%{$ftime}%";
          $s5 = "%{$fowner}%";
          $select->bind_param('sssss', $s1, $s2, $s3, $s4, $s5);
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
                <td><button type="Submit" name = 'favorite'>Favorite</button></td>
                <?php
                  if($_SESSION['identity'] == "admin"){
                ?>
                  <td><button type="Submit" name = 'delete'>Delete</button></td>
                <?php
                  }
                ?>
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
      }
      else echo "No Authority!";
      if(isset($_POST['price_up'])){
        $_SESSION['order'] = 'ORDER BY price DESC';
        echo '<script>window.location.assign("http://people.cs.nctu.edu.tw/~hwpeng0521/home.php")</script>';
      }
      else if(isset($_POST['price_down'])){
        $_SESSION['order'] = 'ORDER BY price ASC';
        echo '<script>window.location.assign("http://people.cs.nctu.edu.tw/~hwpeng0521/home.php")</script>';
      }
      else if(isset($_POST['time_up'])){
        $_SESSION['order'] = 'ORDER BY time_ DESC';
        echo '<script>window.location.assign("http://people.cs.nctu.edu.tw/~hwpeng0521/home.php")</script>';
      }
      else if(isset($_POST['time_down'])){
        $_SESSION['order'] = 'ORDER BY time_ ASC';
        echo '<script>window.location.assign("http://people.cs.nctu.edu.tw/~hwpeng0521/home.php")</script>';
      }

      if(isset($_POST['favorite'])){
        $user = $_SESSION["id"];
        $Hid = $_POST['Hid'];
        $result = $db->query("SELECT * FROM Favorite  F where F.user_id = '$user' and F.favorite_id = '$Hid'");
        if(mysqli_num_rows($result) > 0){
          echo "Have added to the Favorite";
        }
        else{
          mysqli_query($db, "INSERT INTO Favorite (user_id, favorite_id) VALUES('$user', '$Hid')");
          echo '<script>window.location.assign("http://people.cs.nctu.edu.tw/~hwpeng0521/home.php")</script>';
        }
      }
      else if(isset($_POST['delete'])){
        $Hid = $_POST['Hid'];
        mysqli_query($db, "DELETE FROM House WHERE id = $Hid");
        echo '<script>window.location.assign("http://people.cs.nctu.edu.tw/~hwpeng0521/home.php")</script>';
      }
      if(isset($_POST['find'])){
      	if( $_POST['id'] != '') $_SESSION['fid'] = $_POST['id'];
        else $_SESSION['fid'] = '';
        if( $_POST['name'] != '') $_SESSION['fname'] = $_POST['name'];
        else $_SESSION['fname'] = '';
        if($_POST['Pf'] != '' && $_POST['Pt'] != ''){
          $temp = $_POST['Pf'];
          $_SESSION['Pf'] = $temp;
          $temp2 = $_POST['Pt'];
          $_SESSION['Pt'] = $temp2;
          $_SESSION['price'] = "and price between $temp and $temp2";
        }
        else if($_POST['Pf'] != '' && $_POST['Pt'] == ''){
          $temp = $_POST["Pf"];
          $_SESSION['Pf'] = $temp;
          $_SESSION['Pt'] = '';
          $_SESSION['price'] = "and price between $temp and 99999999";
        }
        else if($_POST['Pf'] == '' && $_POST['Pt'] != ''){
          $temp = $_POST["Pt"];
          $_SESSION['Pt'] = $temp;
          $_SESSION['Pf'] = '';
          $_SESSION['price'] = "and price between 0 and $temp";
        }
        if($_POST['location'] != '') $_SESSION['flocation'] = $_POST['location'];
        else  $_SESSION['flocation'] = '';
        if($_POST['time'] != '') $_SESSION['ftime'] = $_POST['time'];
        else $_SESSION['ftime'] = '';
        if($_POST['owner'] != '')$_SESSION['fowner'] = $_POST['owner'];
        else $_SESSION['fowner'] = '';
        echo '<script>window.location.assign("http://people.cs.nctu.edu.tw/~hwpeng0521/home.php")</script>';
        if($_POST['info1'] == "1"){
          $_SESSION['info1'] = "1";
        }
        else $_SESSION['info1'] ='';
        if($_POST['info2'] == "2"){
          $_SESSION['info2'] = "2";
        }
        else $_SESSION['info2'] ='';
        if($_POST['info3'] == "3"){
          $_SESSION['info3'] = "3";
        }
        else $_SESSION['info3'] ='';
        if($_POST['info4'] == "4"){
          $_SESSION['info4'] = "4";
        }
        else $_SESSION['info4'] ='';
        if($_POST['info5'] == "5"){
          $_SESSION['info5'] = "5";
        }
        else $_SESSION['info5'] ='';
        if($_POST['info6'] == "6"){
          $_SESSION['info6'] = "6";
        }
        else $_SESSION['info6'] ='';
        if($_POST['info7'] == "7"){
          $_SESSION['info7'] = "7";
        }
        else $_SESSION['info7'] ='';
        if($_POST['info8'] == "8"){
          $_SESSION['info8'] = "8";
        }
        else $_SESSION['info8'] ='';
        if($_POST['info9'] == "9"){
          $_SESSION['info9'] = "9";
        }
        else $_SESSION['info9'] ='';
        if($_POST['info10'] == "10"){
          $_SESSION['info10'] = "10";
        }
        else $_SESSION['info10'] ='';
      }
      else if(isset($_POST['showall'])){
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
        echo '<script>window.location.assign("http://people.cs.nctu.edu.tw/~hwpeng0521/home.php")</script>';
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
<?php
session_start();
// print_r($_SESSION);

require('db.php');

$groups_list = array();
$sql = "SELECT * FROM contactgroups";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result) > 0){
    $groups_list = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <title>Telephone Book</title>
</head>
<body>
<div class="page">
  <div class="content">
    <div class="foo">

      <div><form class="ageForm" method="post" action="submit.php">
         <div class="input-field category-field">
         <h1 class="header-top">Add a New Contact</h1>
         <div class="container">
         <label for="userName" class="category-section">Contact's Name
        <input class="locationStyle input-icon" type="text" id="userName" name="userName" value="<?php echo isset($_SESSION['name']) ? ($_SESSION['name']) : '';  ?>" required placeholder="Contact's Name goes here...">
        <i class="fas fa-user"></i>
      </label>
      </div>
      <div class="container phoneIcon">
        <label for="userPhone" class="category-section">Contact's Phone
        <input class="locationStyle" type="phone" id="userPhone" name="userPhone" value="<?php echo isset($_SESSION['phone']) ? ($_SESSION['phone']) : '';  ?>" required placeholder="Contact's Phone goes here...">
        <i class="fa fa-phone fa-rotate-90"></i>
      </div>
        </label>
      <div class="container">
        <label for="userGroup" class="category-section">Contact's Group
        <i class="fa fa-address-book"></i>
        
        <select name="userGroup" id="userGroup" class="locationStyle groupSelect">
        <option value="<?php echo isset($_SESSION['group']) ? ($_SESSION['group']) : ''; // echo isset($_SESSION['location']) ? ($_SESSION['location']) : ''; ?>" disabled selected>&nbsp;&nbsp;&nbsp;&nbsp;Choose your relative Group</option>
        <?php
        foreach($groups_list as $row) {
            $id = $row["groupid"];
            $group = $row["select_group"];
            echo '<option ';

             if(isset($_SESSION['group']) && $_SESSION['group'] == $group){
               echo 'selected="selected"';
             }
            
             echo ' value="'.$group.'">&nbsp;&nbsp;&nbsp;&nbsp;'.$group.'</option>';
        }
       ?>
    </select>   
            </div>
          </select>
        </label>
</div>
        <label for="notes" class="category-section">Contact's Description</label>
        <textarea class="contactNotes"name="contactNotes" id="contactNotes" cols="30" rows="10"required placeholder="Contact's Notes goes here..."> <?php echo isset($_SESSION['notes']) ? ($_SESSION['notes']) : '';  ?></textarea><br>
     	<button id="btn" type="submit">Add Contact</button>
     </form></div>
    </div>
  </div>
</body>
</html>
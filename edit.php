<?php
session_start();

function validate($data){
    return htmlspecialchars(
        stripslashes(
            trim($data)
        )
    );
}

require('db.php');

$groups_list = array();
$sql = "SELECT * FROM contactgroups";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result) > 0){
    $groups_list = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
$id = $_GET['id'];
$sql = "SELECT * FROM phonecontacts p INNER JOIN contactgroups c on p.contact_group = c.groupid WHERE id=$id;";
$result = mysqli_query($conn, $sql);
$rows2=mysqli_fetch_assoc($result);

if(!empty($_GET['id']) && is_numeric($_GET['id'])) {
	require('db.php');
	
		$id = $_GET['id'];
		$query = "SELECT * FROM phonecontacts p INNER JOIN contactgroups c on p.id = c.groupid WHERE id=$id;";
		$result = mysqli_query($conn, $query);
		$rows=mysqli_fetch_assoc($result);

	$errors = array();
	$userNameEdit = $userPhoneEdit = $userGroupEdit = $contactNotesEdit = '';
	if(!empty($_POST)){
		$userNameEdit = validate($_POST['userNameEdit']);
		if(empty($userNameEdit)) $errors[] = 'Contacts Name field is required';

		$userPhoneEdit = validate($_POST['userPhoneEdit']);
		if(empty($userPhoneEdit)) $errors[] = 'Contacts Phone field is required';

		$userGroupEdit = validate($_POST['userGroupEdit']);
		if(empty($userGroupEdit)) $errors[] = 'Contacts Group field is required';

		$contactNotesEdit = validate($_POST['contactNotesEdit']);
		if(empty($contactNotesEdit)) $errors[] = 'Contacts Note field is required'; 
	}
	if(!empty($userNameEdit) && !empty($userPhoneEdit) && !empty($userGroupEdit) && !empty($contactNotesEdit)){
    
    $userGroupEdit = $_POST['userGroupEdit'];
    $sql = "SELECT groupid FROM contactgroups WHERE select_group = '$userGroupEdit'";
    $result = mysqli_query($conn, $sql);
    $groupId = mysqli_fetch_row($result);

	$sql = "UPDATE phonecontacts SET 
	`contact_name` = ?,
	`contact_phone`  = ?,
	`contact_description` = ?,
	`contact_group` = ? 
	WHERE `phonecontacts`.`id` = $id;";
	$stmt= $conn->prepare($sql);
	$stmt->bind_param("sisi", $userNameEdit, $userPhoneEdit, $contactNotesEdit, $groupId[0]);

	$stmt->execute();


	$_SESSION['message'] = 'Contact has been updated succesfully!';
	header('Location: index.php');
	exit();
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="styles.css">

    <title>Update Contact</title>
</head>
<body>
<div class="page">
  <div class="content">
    <div class="foo">

      <div><form class="ageForm" method="post">
         <div class="input-field category-field">
         <h1 class="header-top">Edit <?php echo $rows2['contact_name']?> Information</h2>
         <div class="container">
         <label for="userName" class="category-section">Contact's Name
        <input class="locationStyle input-icon" type="text" id="userNameEdit" name="userNameEdit" value="<?php echo $rows2['contact_name']; ?>" required placeholder="Contact's Name goes here...">
        <i class="fas fa-user"></i>
      </label>
      </div>
      <div class="container phoneIcon">
        <label for="userPhone" class="category-section">Contact's Phone
        <input class="locationStyle" type="phone" id="userPhoneEdit" name="userPhoneEdit" value="<?php echo $rows2['contact_phone']; ?>" required placeholder="Contact's Phone goes here...">
        <i class="fa fa-phone fa-rotate-90"></i>
      </div>
        </label>
      <div class="container">
        <label for="userGroup" class="category-section">Contact's Group
        <i class="fa fa-address-book"></i>
        
        <select name="userGroupEdit" id="userGroupEdit" class="locationStyle groupSelect">
        <option value="<?php echo $rows2['contact_group']; ?>" disabled selected hidden>&nbsp;&nbsp;&nbsp;&nbsp;Choose your relative Group</option>
        <?php
        foreach($groups_list as $row) {
            $id = $row["id"];
            $group = $row["select_group"];
            echo '<option ';

             if(isset($rows2['select_group']) && $rows2['select_group'] == $group){
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
        <textarea class="contactNotes" name="contactNotesEdit" id="contactNotesEdit" cols="30" rows="10" required placeholder="Contact's Notes goes here..."><?php echo $rows2['contact_description']; ?></textarea><br>
     	<button id="btn" type="submit">Save Information</button>
     </form></div>
    </div>
  </div>
</body>
</html> 
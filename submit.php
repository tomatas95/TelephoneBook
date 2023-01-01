<?php
session_start();

function validate($data){
    return htmlspecialchars(
        stripslashes(
            trim($data)
        )
    );
}

if(empty($_POST)){
    header("Location: register.php");
  }

require('db.php');

$_SESSION['name'] = $_POST['userName'];
$_SESSION['phone'] = $_POST['userPhone'];
$_SESSION['group'] = $_POST['userGroup'];
$_SESSION['notes'] = $_POST['contactNotes'];

$userContact = validate($_SESSION['name']);
$userPhone = validate($_SESSION['phone']);
$userGroup = validate($_SESSION['group']);
$userNotes = validate($_SESSION['notes']);



if(!empty($userContact) && !empty($userPhone) && !empty($userNotes) && !empty($userGroup)){
    $userGroup = $_POST['userGroup'];
    $sql = "SELECT groupid FROM contactgroups WHERE select_group = '$userGroup'";
    $result = mysqli_query($conn, $sql);
    $groupId = mysqli_fetch_row($result);

    $SELECT = "SELECT id FROM phonecontacts WHERE contact_phone = ? LIMIT 1";
    $INSERT = "INSERT INTO phonecontacts (contact_name,contact_phone,contact_description,contact_group) values(?,?,?,?)";

    $stmt = $conn->prepare($SELECT);
    $stmt->bind_param("i",$userPhone);
    $stmt->execute();
    $stmt->bind_result($userPhone);
    $stmt->store_result();
    $rnum = $stmt->num_rows;

    if($rnum == 0){
        $stmt->close();
        $stmt = $conn->prepare($INSERT);
        $stmt->bind_param("sisi", $userContact,$userPhone,$userNotes,$groupId[0]);
        $stmt->execute();
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <title>Contact Register</title>
</head>
<body>
<div class="page">
  <div class="content">
    <div class="foo">
        <?php if($rnum == 0){
            ?>
             <div><form class="ageForm" method="post" action="index.php">
             <div class="input-field category-field">
             <h1 class="header-top">New Contact has been added successfully!</h1>
             <button class="btn btn-secondary"type="submit">Home</button>
             </form></div>
    </div>
  </div>
            <?php
            }else{
            ?>  <div><form class="ageForm" method="post" action="register.php">
            <div class="input-field category-field">
            <h1 class="header-top">Unfortunately, the Mobile Phone already exists in the Contact Page...</h1>
            <button class="btn btn-secondary"type="submit">Edit my Contact</button>
            </form></div>
   </div>
 </div>
            <?php
        }?>
        </div>
    </div>
</div>
</body>
</html>
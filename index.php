<?php
session_start();
require('db.php');
$query = "SELECT * FROM phonecontacts p INNER JOIN contactgroups c on p.contact_group = c.groupid;";
$result = mysqli_query($conn,$query);

if(!empty($_SESSION['message'])){
    echo "<p class='status'>{$_SESSION['message']}</p>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="contactstyle.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Users</title>
</head>
<body>
    <form method="post" action="register.php">
    <div class="buttonContainer">
    <button type="submit" class="btn btn-secondary addContact">Create a new Contact!</button>
    </div>
    </form>
<section>
    <h1 class="header">Contact Book</h1>
    <div class="tbl-header">
    <table cellpadding="0" cellspacing="0" border="0">
        <thead>
            <th class="fix-name"style="width: 100px">Name</th>
            <th class="fix-phone"style="width: 100px">Phone</th>
            <th class="fix-description"style="width: 100px">Description</th>
            <th class="fix-group"style="width: 70px">Group</th>
            <th class="fix-stuff fix-veiksmai"style="width: 50px">Action</th>
        </thead>
    </table>
    </div>
    <div class="tbl-content">
    <table cellpadding="0" cellspacing="0" border="0">
        <tbody>
        <?php
        while($rows=mysqli_fetch_assoc($result))
        {        
?>            <tr>
            <td style="width: 100px"><?php echo $rows['contact_name']; ?></td>
            <td style="width: 100px"><?php echo $rows['contact_phone']; ?></td>
            <td style="width: 100px"><?php echo $rows['contact_description']; ?></td>
            <td style="width: 70px"><?php echo $rows['select_group']; ?></td>
            <td style="width: 60px">
            <a href="edit.php?id=<?=$rows['id']?>"><i class="text-warning fa-2x fa-solid fa-pen-to-square me-2"></i></a>
            <a href="delete.php?id=<?=$rows['id']?>"><i class="text-danger fa-2x fa-solid fa-trash"></i></a></td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
    </div>
    </section>

    <script>
$(window).on("load resize ", function() {
  var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
  $('.tbl-header').css({'padding-right':scrollWidth});
}).resize();
    </script>
</body>
</html>
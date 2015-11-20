<?php
include("utils.php");
include("Queries.php");
include("header.php");

$username = "";
$username_error = "";

$password = "";
$password_error = "";

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize_input($_POST['username']);
    $password = sanitize_input($_POST['password']);
    
    $has_error = false;
    if(empty($username)) {
        $username_error = "Username cannot be empty";
        $has_error = true;
    }
    
    if(empty($password)) {
        $password_error = "Password cannot be empty";
        $has_error = true;
    }
  
    $ret = login_user($username, $password);
    if(!$has_error && $ret) {
        // Successful login
        header('Location: profile.php', true);
        die();
    } else {
        $password_error = "Username and password combination did not work";
        $has_error = true;
    }
}
?>


<form action="" method="POST">
<table>
    <tr>
        <td>Username:</td>
        <td><input type="text" name="username" style="width:100%" value="<?=$username?>"></input>
        <?php if(!empty($username_error)) { ?>
        <span class="error">* <?=$username_error?></span>
        <?php } ?>
        </td>
    </tr>
    <tr>
        <td>Password:</td>
        <td><input type="password" name="password" style="width:100%" value="<?=$password?>"></input>
        <?php if(!empty($password_error)) { ?>
        <span class="error">* <?=$password_error?></span>
        <?php } ?>
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center"><input type="submit" value="Submit" style="width:100%"></input>
    </tr>
</table>
</form>


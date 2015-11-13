<?php
include("header.php");

$username = "";
$username_error = "";

$email = "";
$email_error = "";

$password = "";
$password_error = "";

$firstname = "";
$firstname_error = "";

$lastname = "";
$lastname_error = "";

$age = 0;
$age_error = "";

$zipcode = 10000;
$zipcode_error = "";

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize_input($_POST['username']);
    $email = sanitize_input($_POST['email']);
    $password = sanitize_input($_POST['password']);
    $firstname = sanitize_input($_POST['firstname']);
    $lastname = sanitize_input($_POST['lastname']);
    $age = intval($_POST['age']);
    $zipcode = intval($_POST['zipcode']);
    
    $has_error = false;
    if(empty($username)) {
        $username_error = "Username cannot be empty";
        $has_error = true;
    }
    
    if(empty($email)) {
        $email_error = "Email cannot be empty";
        $has_error = true;
    }
    
    if(empty($password)) {
        $password_error = "Password cannot be empty";
        $has_error = true;
    }
    
    if(empty($firstname)) {
        $firstname_error = "First name cannot be empty";
        $has_error = true;
    }
    
    if(empty($lastname)) {
        $lastname_error = "Last name cannot be empty";
        $has_error = true;
    }
    
    if($age < 13) {
        $age_error = "Must be 13 or older to register on this website";
        $has_error = true;
    }
    
    if($zipcode <= 9999) {
        $zipcode_error = "Zipcode must be 5 digits";
        $has_error = true;
    }
    
    if(!$has_error) {
        // Successful registration
        
        $ret = register_user($username, $email, $password, $firstname, $lastname, $age, $zipcode);
        
        if($ret == 1) {
            // Username already in use
            $username_error = "Username already in use";
            $has_error = true;
        }
        
        if(!$has_error) {
            header('Location: profile.php', true);
            die();
        }
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
        <td>Email:</td>
        <td><input type="email" name="email" style="width:100%" value="<?=$email?>"></input>
        <?php if(!empty($email_error)) { ?>
        <span class="error">* <?=$email_error?></span>
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
        <td>First Name:</td>
        <td><input type="text" name="firstname" style="width:100%" value="<?=$firstname?>"></input>
        <?php if(!empty($firstname_error)) { ?>
        <span class="error">* <?=$firstname_error?></span>
        <?php } ?>
        </td>
    </tr>
    <tr>
        <td>Last Name:</td>
        <td><input type="text" name="lastname" style="width:100%" value="<?=$lastname?>"></input>
        <?php if(!empty($lastname_error)) { ?>
        <span class="error">* <?=$lastname_error?></span>
        <?php } ?>
        </td>
    </tr>
    <tr>
        <td>Age:</td>
        <td><input type="number" name="age" min="13" style="width:100%" value="<?=$age?>"></input>
        <?php if(!empty($age_error)) { ?>
        <span class="error">* <?=$age_error?></span>
        <?php } ?>
        </td>
    </tr>
    <tr>
        <td>Zipcode:</td>
        <td><input type="number" name="zipcode" min="10000" max="99999" style="width:100%" value="<?=$zipcode?>"></input>
        <?php if(!empty($zipcode_error)) { ?>
        <span class="error">* <?=$zipcode_error?></span>
        <?php } ?>
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center"><input type="submit" value="Submit" style="width:100%"></input></td>
    </tr>
</table>
</form>
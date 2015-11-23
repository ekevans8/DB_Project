<?php
include("header.php");
include("utils.php");
include("Queries.php");

if(isset($_SESSION['username']) && ((isset($_GET['action']) && $_GET['action'] != "update") || !isset($_GET['action']))) {
    header("Location: profile.php", true);
    die();
}

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

if(isset($_GET['action']) && $_GET['action'] == "update") {
    $username = $_SESSION['username'];
    $profile = get_profile($username);
    
    $email = $profile['email'];
    $firstname = $profile['firstName'];
    $lastname = $profile['lastName'];
    $age = $profile['age'];
    $zipcode = $profile['zipcode'];
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_GET['action']) && $_GET['action'] == "update" && isset($_GET['id']))
        $username = $_SESSION['username'];
    else
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
        if(isset($_GET['action']) && $_GET['action'] == "update") {
            update_user($username, $email, $password, $firstname, $lastname, $age, $zipcode);
        } else {
        
            $profile = get_profile($username);
            if($profile != null) {
                // Username already in use
                $username_error = "Username already in use";
                $has_error = true;
            } else {
                $ret = register_user($username, $email, $password, $firstname, $lastname, $age, $zipcode);
            }
        }
        
        if(!$has_error) {
            $profile = get_profile($username);
            
            $_SESSION['username'] = $profile['username'];
            $_SESSION['firstname'] = $profile['firstName'];
            $_SESSION['lastname'] = $profile['lastName'];
            
            header('Location: profile.php', true);
            die();
        }
    }
}
?>
<form id="login-form" action="" method="post" style="display: block;">
	<?php
	if("$_SERVER[REQUEST_URI]" == "/register.php?action=update") {
	?>
		<div class="form-group">
			<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="<?=$username?>" disabled>
		</div>
		
	<?php } else {
	?>
		<div class="form-group">
			<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="<?=$username?>">
		</div>
		<?php if(!empty($username_error)) { ?>
            <span class="error"><font color="red">* <?=$username_error?></font></span>
        <?php } ?>
	<?php } ?>
		<div class="form-group">
			<input type="email" name="email" id="email" tabindex="2" class="form-control" placeholder="Email" value="<?=$email?>">
		</div>
		<?php if(!empty($email_error)) { ?>
			<span class="error"><font color="red">* <?=$email_error?></font></span>
        <?php } ?>
		
		<div class="form-group">
			<input type="password" name="password" id="password" tabindex="3" class="form-control" placeholder="Password" value="<?=$password?>">
		</div>
		<?php if(!empty($password_error)) { ?>
            <span class="error"><font color="red">* <?=$password_error?></font></span>
        <?php } ?>
		
		<div class="form-group">
			<input type="text" name="firstname" id="firstname" tabindex="4" class="form-control" placeholder="First Name" value="<?=$firstname?>">
		</div>
		<?php if(!empty($firstname_error)) { ?>
            <span class="error"><font color="red">* <?=$firstname_error?></font></span>
        <?php } ?>
		
		<div class="form-group">
			<input type="text" name="lastname" id="lastname" tabindex="5" class="form-control" placeholder="Last Name" value="<?=$lastname?>">
		</div>
		<?php if(!empty($lastname_error)) { ?>
            <span class="error"><font color="red">* <?=$lastname_error?></font></span>
        <?php } ?>
		
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon3">Age</span>
				<input type="number" name="age" id="age" min="13" tabindex="6" class="form-control" value="<?=$age?>">
			</div>
		</div>
		<?php if(!empty($age_error)) { ?>
            <span class="error"><font color="red">* <?=$age_error?></font></span>
        <?php } ?>

		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon3">Zipcode</span>
				<input type="number" name="zipcode" id="zipcode" min="10000" max="99999" tabindex="7" class="form-control" value="<?=$zipcode?>">
			</div>
		</div>
		<?php if(!empty($zipcode_error)) { ?>
            <span class="error"><font color="red">* <?=$zipcode_error?></font></span>
        <?php } ?>
		
		<div class="form-group">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					<?php
					if("$_SERVER[REQUEST_URI]" == "/register.php?action=update") {
					?>
						<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Update">
					<?php } else {?>
						<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Register">
					<?php } ?>
				</div>
			</div>
		</div>
	</form>
<!--<form action="" method="POST">
<table>
<?php
if(isset($_GET['action']) && $_GET['action'] == "update" && isset($_GET['id'])) {
?>
    <tr>
        <td>Username:</td>
        <td><?=$username?></td>
    </tr>
    
<?php } else {
?>
    <tr>
        <td>Username:</td>
        <td><input type="text" name="username" style="width:100%" value="<?=$username?>"></input>
        <?php if(!empty($username_error)) { ?>
        <span class="error">* <?=$username_error?></span>
        <?php } ?>
        </td>
    </tr>
<?php } ?>
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
</form>-->
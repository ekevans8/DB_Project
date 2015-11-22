<?php
include("utils.php");
include("Queries.php");
include("header.php");

$username = "";
$username_error = "";

$password = "";
$password_error = "";

if(!isset($_GET['action']) || $_GET['action'] == "login") {
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_destroy();
        session_start();
        
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
            $profile = get_profile($username);
            
            $_SESSION['username'] = $profile['username'];
            $_SESSION['firstname'] = $profile['firstName'];
            $_SESSION['lastname'] = $profile['lastName'];
            
            header('Location: profile.php', true);
            die();
        } else {
            $password_error = "Username and password combination did not work";
            $has_error = true;
        }
    }
    ?>

	<form id="login-form" action="" method="post" style="display: block;">
		<div class="form-group">
			<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="<?=$username?>">
		</div>
		<?php if(!empty($username_error)) { ?>
            <span class="error"><font color="red">* <?=$username_error?></font></span>
        <?php } ?>
		<div class="form-group">
			<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" value="<?=$password?>">
		</div>
		<?php if(!empty($password_error)) { ?>
            <span class="error"><font color="red">* <?=$password_error?></font></span>
        <?php } ?>
		<div class="form-group">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
				</div>
			</div>
		</div>
	</form>

    <!--<form action="" method="POST">
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
    </form>-->
<?php
} 
else if($_GET['action'] == "logout") {
    session_destroy();  
    $_SESSION = array();
    header("Location: login.php");
    die();
}
?>
<?php

include("configuration.php");

session_start();

if($_SERVER["REQUEST METHOD"]=="POST"){
      
    //  username and password from form
$myusername=myqli_escape_string($db, $_POST["username"]);

$mypassword=myqli_escape_string($db, $_POST["password"]);

$sql="SELECT id FROM admin WHERE username =$myusername and passcode=$mypassword ";

$result = mysqli_query($db, $sql);

$row =mysqli_fetch_array($result, mysqli_assoc);

$active =$row['active'];

$count = myqli_num_row($result);

//if result matched $myusername and $mypassword, table row must be 1 row

 if($count==1){
      
 // session_register("$myusername");
      
 $_SESSION["login_user"]=$myusername;
      
 header("location:welcome.php");
      
      }
      else{
        
            $error ="Your login name or password is invalid5";
      }
      
}

?>
<html>
<head></head>
<body>
<div id ="member" align ="right" style ="font-size:20px;">
Members' corner
<form action ="login.php" method="post" >
<label>Username: </label><input type="text",name="username" placeholder="Enter username" /> &nbsp; <br>

<label>Password:</label> <input type="password" name="password" placeholder="Enter password" /> &nbsp; <br>
<input type="submit" name="submit" value ="LOGIN"  placeholder="Enter username" style ="margin-right:100px;" />
</form>
Not yet a member? Register <a href="#">here.</a> &nbsp;
</div>
<div><?php echo $error ?></div>
</body>
</html>

<?php

/* Database credentials. Assuming you are running MySQL

server with default setting (user 'root' with no password) */

define('DB_SERVER', 'localhost');

define('DB_USERNAME', 'root');

define('DB_PASSWORD', '');

define('DB_NAME', 'demo');

 

/* Attempt to connect to MySQL database */

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

 

// Check connection

if($link === false){

    die("ERROR: Could not connect. " . mysqli_connect_error());

}

?>

<?php

// Include config file

require_once 'config.php';

 

// Define variables and initialize with empty values

$username = $password = $confirm_password = "";

$username_err = $password_err = $confirm_password_err = "";

 

// Processing form data when form is submitted

if($_SERVER["REQUEST_METHOD"] == "POST"){

 

    // Validate username

    if(empty(trim($_POST["username"]))){

        $username_err = "Please enter a username.";

    } else{

        // Prepare a select statement

        $sql = "SELECT id FROM users WHERE username = ?";

        

        if($stmt = mysqli_prepare($link, $sql)){

            // Bind variables to the prepared statement as parameters

            mysqli_stmt_bind_param($stmt, "s", $param_username);

            

            // Set parameters

            $param_username = trim($_POST["username"]);

            

            // Attempt to execute the prepared statement

            if(mysqli_stmt_execute($stmt)){

                /* store result */

                mysqli_stmt_store_result($stmt);

                

                if(mysqli_stmt_num_rows($stmt) == 1){

                    $username_err = "This username is already taken.";

                } else{

                    $username = trim($_POST["username"]);

                }

            } else{

                echo "Oops! Something went wrong. Please try again later.";

            }

        }

         

        // Close statement

        mysqli_stmt_close($stmt);

    }

    

    // Validate password

    if(empty(trim($_POST['password']))){

        $password_err = "Please enter a password.";     

    } else if(strlen(trim($_POST['password'])) < 6){

        $password_err = "Password must have atleast 6 characters.";

    } else{

        $password = trim($_POST['password']);

    }

    

    // Validate confirm password

    if(empty(trim($_POST["confirm_password"]))){

        $confirm_password_err = 'Please confirm password.';     

    } else{

        $confirm_password = trim($_POST['confirm_password']);

        if($password != $confirm_password){

            $confirm_password_err = 'Password did not match.';

        }

    }

    

    // Check input errors before inserting in database

    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

        

        // Prepare an insert statement

        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

         

        if($stmt = mysqli_prepare($link, $sql)){

            // Bind variables to the prepared statement as parameters

            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            

            // Set parameters

            $param_username = $username;

            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            

            // Attempt to execute the prepared statement

            if(mysqli_stmt_execute($stmt)){

                // Redirect to login page

                header("location: login.php");

            } else{

                echo "Something went wrong. Please try again later.";

            }

        }

         

        // Close statement

        mysqli_stmt_close($stmt);

    }

    

    // Close connection

    mysqli_close($link);

}

?>

 

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Sign Up</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

    <style type="text/css">

        body{ font: 14px sans-serif; }

        .wrapper{ width: 350px; padding: 20px; }

    </style>

</head>

<body>

    <div class="wrapper">

        <h2>Sign Up</h2>

        <p>Please fill this form to create an account.</p>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">

                <label>Username:<sup>*</sup></label>

                <input type="text" name="username"class="form-control" value="<?php echo $username; ?>">

                <span class="help-block"><?php echo $username_err; ?></span>

            </div>    

            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">

                <label>Password:<sup>*</sup></label>

                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">

                <span class="help-block"><?php echo $password_err; ?></span>

            </div>

            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">

                <label>Confirm Password:<sup>*</sup></label>

                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">

                <span class="help-block"><?php echo $confirm_password_err; ?></span>

            </div>

            <div class="form-group">

                <input type="submit" class="btn btn-primary" value="Submit">

                <input type="reset" class="btn btn-default" value="Reset">

            </div>

            <p>Already have an account? <a href="login.php">Login here</a>.</p>

        </form>

    </div>    

</body>

</html>
    <?php

    // Initialize the session

    session_start();

     

    // If session variable is not set it will redirect to login page

    if(!isset($_SESSION['username']) || empty($_SESSION['username'])){

      header("location: login.php");

      exit;

    }

    ?>

     

    <!DOCTYPE html>

    <html lang="en">

    <head>

        <meta charset="UTF-8">

        <title>Welcome</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

        <style type="text/css">

            body{ font: 14px sans-serif; text-align: center; }

        </style>

    </head>

    <body>

        <div class="page-header">

            <h1>Hi, <b><?php echo $_SESSION['username']; ?></b>. Welcome to our site.</h1>

        </div>

        <p><a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a></p>

    </body>

    </html>

<?php

// Initialize the session

session_start();

 

// Unset all of the session variables

$_SESSION = array();

 

// Destroy the session.

session_destroy();

 

// Redirect to login page

header("location: login.php");

exit;

?>

<?php

// Step 1: Creating the Database Table

$sql="CREATE TABLE users (

    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,

    username VARCHAR(50) NOT NULL UNIQUE,

    password VARCHAR(255) NOT NULL,

    created_at DATETIME DEFAULT CURRENT_TIMESTAMP

)";

?>
<?php

/* Attempt MySQL server connection. Assuming you are running MySQL

server with default setting (user 'root' with no password) */

$link = mysqli_connect("localhost", "root", "", "demo");

 

// Check connection

if($link === false){

    die("ERROR: Could not connect. " . mysqli_connect_error());

}

 

// Attempt select query execution

$sql = "SELECT * FROM persons";

if($result = mysqli_query($link, $sql)){

    if(mysqli_num_rows($result) > 0){

        echo "<table>";

            echo "<tr>";

                echo "<th>id</th>";

                echo "<th>first_name</th>";

                echo "<th>last_name</th>";

                echo "<th>email</th>";

            echo "</tr>";

        while($row = mysqli_fetch_array($result)){

            echo "<tr>";

                echo "<td>" . $row['id'] . "</td>";

                echo "<td>" . $row['first_name'] . "</td>";

                echo "<td>" . $row['last_name'] . "</td>";

                echo "<td>" . $row['email'] . "</td>";

            echo "</tr>";

        }

        echo "</table>";

        // Free result set

        mysqli_free_result($result);

    } else{

        echo "No records matching your query were found.";

    }

} else{

    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);

}


// Close connection

mysqli_close($link);

?>
















































































































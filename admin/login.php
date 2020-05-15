<?php
ob_start();
@session_start();
include_once 'include/include.php';
if(isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id']))
{
    header('location:dashboard');
}
ini_set( 'date.timezone', 'US/Eastern' );
$date= date("m/d/y h:i:s A");
$error="";
if(isset($_POST['email'])&&isset($_POST['password']))
{
    $email=$_POST['email'];
    $password=$_POST['password'];
    if(!empty($_POST['email']) && !empty($_POST['password']))
    {
        $query="SELECT id, type FROM admin WHERE email='$email' and password='$password'";
        $query_run=@mysqli_query($connect,$query);
        $result=@mysqli_fetch_assoc($query_run);
        $row=@mysqli_num_rows($query_run);
        if($row==1)
        {
            if(!empty($_POST['remember']))
            {
                setcookie ("email",$_POST["email"],time()+ (30 * 24 * 60 * 60));
                setcookie ("password",$_POST["password"],time()+ (30 * 24 * 60 * 60));
            }
            else
            {
                if(isset($_COOKIE["email"]))
                {
                  setcookie ("email","");
                }
                if(isset($_COOKIE["password"]))
                {
                  setcookie ("password","");
                }
            }   
            $admin_id=$result['id'];
            $admin_type=$result['type'];
            $_SESSION['admin_id']=$admin_id;
            $_SESSION['admin_type']=$admin_type;

            $query21="INSERT INTO `system_logs`(`admin_id`, `module`, `action`, `time`) VALUES ('$admin_id', 'admin panel', 'login','$date')";
            $query21_run=mysqli_query($connect,$query21);

            $msg='<div class="alert alert-success alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                      </button>
                      <small>Login Successful, Redirecting.....</small>
                    </div>';

            header('Refresh:1; url=dashboard');
        }
        else
        {
        $msg='<div class="alert alert-danger alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                  </button>
                  <small>INCORRECT EMAIL OR PASSWORD, TRY AGAIN!!!</small>
                </div>';
        }
    }
    else
    {
    $msg='<div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
              </button>
              Please Enter Your Correct Email & Password!
            </div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include_once 'include/head.php'; ?>
<body>	
    <div class="container">
    	<div class="row">
    	<div class="col-lg-4 col-lg-offset-4">
            <br/>
            <p class="text-center"></p>
			<img src="../images/logo.jpg" class = "img-circle" width="200" height="200" alt="...">	
            
			<h3>Fund for a Future<h3>
           
			
            <div class="text-center"><b><?php echo @$msg; ?></b></div>
            <hr class="clean">
        	<form action="login" method="POST">
              <div class="form-group input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="email" class="form-control" name="email" placeholder="Email Adress" value="<?php if(isset($_COOKIE["email"])){ echo $_COOKIE["email"]; } ?>" required>
              </div>
              <div class="form-group input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="password" class="form-control" name="password" placeholder="Password" value="<?php if(isset($_COOKIE["password"])){ echo $_COOKIE["password"]; } ?>" required>
              </div>
              <div class="form-group">
                <label class="cr-styled">
                    <input type="checkbox" name="remember" ng-model="todo.done" <?php if(isset($_COOKIE["email"])){ echo 'checked'; } ?>>
                    <i class="fa"></i>
                  <font size="3">Remember me</font>
                </label>
                
              </div>
              <button type="submit" class="btn btn-purple btn-block">Log in</button>
            </form>
            <hr>
        </div>
        </div>
    </div>
    
<?php include_once 'include/footer-scripts.php'; ?>
    
</body>

</html>

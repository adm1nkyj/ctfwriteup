<!-- Here is some gift 4 u. GLHF -->
<!-- ducnt/__testtest__ -->
<!-- guest/__EG-Fangay__ -->
<!-- test/__test__ -->
<!-- eesama/hoho@hihi -->
<!-- fightme/123 -->
<!-- sumail/thebest -->
<!-- messi/ronaldo -->

<!DOCTYPE html>
<html lang="en">
<center>
<style>
    body {
    background: url("1m4g3s/background.jpg") no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    }
</style>

<?php
$servername = "there is no place like home dude!!!";
$username = "XXXXXXXXXXXXX";
$password = "XXXXXXXXXXXXX";
$dbname = "flagshop";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if(isset($_POST["username"]) && !empty($_POST["username"]) && isset($_POST["password"]) && !empty($_POST["password"]))
{
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);
    $sql  = "SELECT * FROM users WHERE username='$username' AND password='$password' limit 1";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) == 0)
        echo "<span style='color: red;'/><center><h1><tr>Nothing is easy. Go away dude!!!!</h1></center></style></span>";
    else{
        $sql1  = "SELECT * FROM buyflag WHERE username='admin' limit 1";
        $check1 = mysqli_fetch_array(mysqli_query($conn, $sql1));
        echo "<tr><center><strong><td><font color='yellow' size=8 >Need " . $check1["value"] . " gold to buy flag dude!!!</font></td>";
        echo "<tr><center><strong><td><font color=#ff3300s size=8 >==========================</font></td>";
        $sql2  = "SELECT * FROM buyflag WHERE username='$username' limit 1";
        $result2 = mysqli_fetch_array(mysqli_query($conn, $sql2));
        echo "<tr><center><strong><td><font color='red' size=8 >Hello: " . $result2["username"] . "</font></td>";
        echo "<tr><center><strong><td><font color='red' size=8 >You have: " . $result2["value"] . " gold</font></td>";
        
        if(isset($_POST['buyflag']) && !empty($_POST['buyflag']))
        {
            $buyflag=$_POST["buyflag"];
            $buyflag=preg_replace('/drop|sleep|benchmark|load|substr|substring|strcmp|union|and|offset|mid|binary|regexp|match|ord|right|locate|left|rpad|length|hex|write|join|=|-|#| |floor|=/i','~nothingisezdude~',strtolower($buyflag));
            $sql3 = mysqli_query($conn,"UPDATE buyflag SET value=value+1 WHERE username='admin'");
            $sql4 = mysqli_query($conn,"UPDATE buyflag SET value=value+1 WHERE username='$buyflag'");
        }
    }
}
mysqli_close($conn);
?>

<head>
    <meta charset="utf-8">
    <title>Just another flag shop</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700|Lato:400,100,300,700,900' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="login-box animated fadeInUp">
            <div class="box-header">
            <font color=orange size="6"><h2><b>Welcome to my flag shop and good luck have fun dude<b></h2>
            </div>
            <div class="box-header">
            <font color=#0099ff size="6">
            </div>
            <form action="index.php" method="POST">
            <label for="username">Username</label>
            <br/>
            <input type="text" id="username" name="username" size="40" required>
            <br/>
            <label for="password">Password</label>
            <br/>
            <input type="password" id="password" name="password" size="40" required>
            <!-- <br/> -->
            <label for="buyflag"><font color=red size="4"><h1>Wanna buy flag huh?? Input your username here</h1></font></label>
            <!-- <br/> -->
            <input type="text" id="buyflag" name="buyflag" size="40">
            <br/>
            <button type="submit">Login now, buy more gold and capture the flag</button>
            <br/>
            </form>
            <center>
            <font color=#cc00ff><h2><b>...or relax here!!!<b></h2>
            <iframe width="60%" height="350" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/playlists/125000363&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true"></iframe>
            </center>
        </div>
    </div>
</body>
<script>
    $(document).ready(function () {
        $('#logo').addClass('animated fadeInDown');
        $("input:text:visible:first").focus();
    });
    $('#username').focus(function() {
        $('label[for="username"]').addClass('selected');
    });
    $('#username').blur(function() {
        $('label[for="username"]').removeClass('selected');
    });
    $('#password').focus(function() {
        $('label[for="password"]').addClass('selected');
    });
    $('#password').blur(function() {
        $('label[for="password"]').removeClass('selected');
    });
</script>
</center>
</html>


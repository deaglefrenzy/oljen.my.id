<?php
require_once "../../cdn/func.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin PADEL</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js">
    </script>

</head>

<body>
    <br>
    <?php
    if ($_COOKIE['admin'] != "ok") {
    ?>
        <br>
        <form action="login.php" method="post">
            <table border="0" cellpadding="5" cellspacing="3" align="center" width="100%">
                <tr>
                    <td align="center">
                        <input type="password" name="pass" size="12" style="border:2px solid #000;" class="w3-xxlarge" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <button type="submit" name="action" value="logadmin" class="button2 w3-xlarge">Login Admin</button>
                    </td>
                </tr>
            </table>
        </form>
    <?php
    } else {
    ?>
        <center>
            <form action="logout.php" method="post">
                <button type="submit" class="button2 w3-xlarge">Logout Admin</button>
            </form>
        </center>
    <?php
    }
    ?>
    <br>
    <center>
        <form action="https://oljen.my.id/padel/" method="post">
            <button type="submit" class="button2 w3-xlarge">Go to Main Website</button>
        </form>
    </center>
</body>

</html>

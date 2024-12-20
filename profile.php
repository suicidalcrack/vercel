<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "cheat");

if (!isset($_GET['username'])) {
  header('Location: ../error.html');
  exit;
}

$username = $_GET['username'];

$query = "SELECT * FROM users WHERE username = ?";
$stmt = mysqli_prepare($conn, $query);
if (!$stmt) {
    echo "Error preparing statement: " . mysqli_error($conn);
    exit;
}
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user_data = mysqli_fetch_assoc($result);

if (!$user_data) {
  header('Location: ../error.html');
  exit;
}

if ($user_data['sub'] === null && strtotime($user_data['createdAt']) < strtotime('-30 seconds') && $user_data['hadsub'] === 0) {
  $query = "DELETE FROM users WHERE uid = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "i", $user_data['uid']);
  mysqli_stmt_execute($stmt);
  header('Location: index');
  exit;
}

$sub = $user_data['sub'];
$admin = $user_data['admin'];

?>

<html>
<head>
    <title>velocity | @<?php echo $username; ?></title>
    <link rel="stylesheet" href="/files/app.css">
    <script src="/files/jquery.min.js.download"></script>
    <script src="/files/socket.io.js.download"></script>
    <link rel="stylesheet" href="/files/toastr.min.css">
    <script src="/files/toastr.min.js.download"></script>
</head>

<body>
    <div class="modal-overlay">

    </div>
    <div class="invites modal" style="max-height: 350px; overflow-y:scroll;">
        <table style="width:100%; text-align: left;">

        </table>
    </div>
    <div class="main">
        <div class="panel-card">
            <div class="header"><span>user profile</span></div>
            username: <a href="#" style="color:rgb(255, 255, 255);"><?php echo $username; ?></a><br>
            invited by: <a href="/profile/<?php echo $user_data['invitedBy']; ?>" style="color:<?php
                $inviter_query = mysqli_query($conn, "SELECT admin, sub FROM users WHERE username = '$user_data[invitedBy]'");
                if ($inviter_query) {
                    $inviter_data = mysqli_fetch_assoc($inviter_query);
                    if ($inviter_data['admin']) {
                        echo 'rgb(255, 0, 0)';
                    } elseif ($inviter_data['sub']) {
                        echo 'rgb(255, 213, 5)';
                    } else {
                        echo 'rgb(86,86,86)';
                    }
                } else {
                    echo 'rgb(86,86,86)';
                }
            ?>;"><?php echo $user_data['invitedBy']; ?></a><br>
            role: <?php
                if ($admin) {
                    echo '<span style="color: rgb(255, 0, 0);">admin</span>';
                } elseif ($sub) {
                    echo '<span style="color: rgb(255, 213, 5);">premium</span>';
                } else {
                    echo '<span style="color: rgb(86, 86, 86);">user</span>';
                }
            ?><br><br>
            uid: <a style="color:rgb(255, 255, 255);"><?php echo $user_data['uid']; ?></a><br><br>
        </div>
        </div>
    </div>
    <div class="controls">
        <a href="/logout">log out</a>
    </div>
    <div class="user-controls">
        <a href="../index" class="panel-link">panel</a>
    </div>

    <script>
        $(".modal-overlay").click(() => {
            $(".invites").removeClass("shown");
            $(".modal-overlay").removeClass("shown");
        });
    </script>
</body>
</html>
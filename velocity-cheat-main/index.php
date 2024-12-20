<?php
require_once 'app/require.php';
require_once 'app/controllers/CheatController.php';

$user = new UserController;
$cheat = new CheatController;

Session::init();

if (!Session::isLogged()) { Util::redirect('/main.html'); }

$username = Session::get("username");
$invitedBy = Session::get("invitedBy");
$sub = $user->getSubStatus();
$uid = Session::get("uid");

Util::banCheck();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>velocity - panel</title>
    <link rel="stylesheet" href="./files/app.css">
    <script src="./files/jquery.min.js.download"></script>
    <link rel="stylesheet" href="./files/toastr.min.css">
    <script src="./files/toastr.min.js.download"></script>
    <style>
        .modal-overlay {
            display: none; /* Ukryj domyślnie */
        }
        .modal-overlay.shown {
            display: block; /* Pokaż, gdy klasa `shown` jest dodana */
        }
    </style>
</head>
<body>
    <script>
        if (location.href.indexOf("?") != -1) {
            toastr.error(location.href.substring(location.href.indexOf("?") + 1, location.href.length).split("_").join(" ").split("=")[0]);
        }        function show_invites() {
    </script>
    <div class="modal-overlay"></div>
    <div class="invites modal" style="max-height: 350px; overflow-y: scroll;">
        <table style="width: 100%; text-align: left;"></table>
    </div>
    <div class="main">
        <div class="panel-card">
            <div class="header">
                <span>user info</span>
            </div>
            welcome, <a href="/profile/<?php Util::display($username) ?>" style="color: rgb(255, 255, 255);"><?php Util::display($username) ?></a> (UID: <?php Util::display($uid); ?>)<br>
            your inviter: <a href="/profile/<?php Util::display($invitedBy) ?>" style="color: rgb(255, 255, 255);"><?php Util::display($invitedBy) ?></a><br>
            <div class="inner">
                <div class="separator">
                    <br>
                    <span>sub</span><br>
                    <span style="color: <?php echo ($sub > 0) ? 'lime' : 'red'; ?>;">
    <?php 
    if ($sub > 0) {
        // Obliczenia dla miesięcy, dni i godzin
        $months = floor($sub / 30); // Przyjmuję, że miesiąc to 30 dni
        $days = $sub % 30;

        // Formatowanie tekstu
        $output = '';
        if ($months > 0) {
            $output .= $months . ' month' . ($months > 1 ? 's' : '') . ' and ';
        }
        $output .= $days . ' day' . ($days > 1 ? 's' : '') . '';

        // Wyświetlanie wyniku
        Util::display($output);
    } else {
        Util::display('no sub');
    }
    ?>
</span>
<br>
                    <a href="/purchase">extend</a><br>
                    <br>
                    <span>client</span><br>
                    <a href="/download">download loader</a><br>
                </div>
                <div class="separator">
                    <br>
                    <span>discord</span><br>
                    <a href="https://discord.gg/FrdhPSEj7D">discord server</a><br>
                    <a href="discord-linking">link account</a><br>
                    <br>
                    <span>information</span><br>
                    <a href="/faq">frequently asked questions</a><br>
                    <br>
                </div>
            </div>
            <span>management</span><br>
            <a href="invites">invites</a>
            <?php if (Session::isAdmin()) : ?>
                <br>
                <a class="nav-link" href="<?= SUB_DIR ?>/admin">admin panel</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="panel-card stats" style="width: 300px">
        <div class="header"><span>stats</span></div>
        <span>registered users: <?php Util::display($user->getUserCount()); ?></span><br>
        <span>newest user: <a href="/profile/<?php Util::display($user->getNewUser()) ?>" style="color: rgb(255, 255, 255);"><?php Util::display($user->getNewUser()); ?></a></span><br>
    </div>
    <div class="controls">
        <a href="/logout">log out</a>
    </div>
    <div class="user-controls">
        <a href="/#" class="panel-link">panel</a>
    </div>
    <script>
        $(".modal-overlay").click(() => {
            $(".invites").removeClass("shown");
            $(".modal-overlay").removeClass("shown");
        });
    </script>
</body>
</html>

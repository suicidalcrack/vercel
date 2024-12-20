<?php

require_once 'app/require.php';

$user = new UserController;

Session::init();

if (!Session::isLogged()) { 
    Util::redirect('/login'); 
}

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // trade to access key
    $tokenResponse = file_get_contents("https://discord.com/api/oauth2/token", false, stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'content' => http_build_query([
                'client_id' => 'botclientid',
                'client_secret' => 'puturbotclientsecret',
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => 'http://localhost/discord-linking',
            ]),
        ],
    ]));

    $tokenData = json_decode($tokenResponse, true);

    if (isset($tokenData['access_token'])) {
        // info abt user
        $userResponse = file_get_contents("https://discord.com/api/v10/users/@me", false, stream_context_create([
            'http' => [
                'header' => 'Authorization: Bearer ' . $tokenData['access_token'],
            ],
        ]));

        $userInfo = json_decode($userResponse, true);
        $discordUserId = $userInfo['id'];

        if ($discordUserId) {
            // Dodaj rolę użytkownikowi na serwerze
            $guildId = '1273723869492154433'; // ID ur server
            $roleId = '1273724069048614976'; // ID role that u want to add after linking

            $addRoleResponse = file_get_contents("https://discord.com/api/v10/guilds/$guildId/members/$discordUserId/roles/$roleId", false, stream_context_create([
                'http' => [
                    'method' => 'PUT',
                    'header' => [
                        'Authorization: Bot TOKEN', // put ur token / dont delete Bot prefix
                        'Content-Length: 0',
                    ],
                ],
            ]));

            if ($addRoleResponse === false) {
                // Błąd przy dodawaniu roli
                echo "Wystąpił problem przy dodawaniu roli.";
            } else {
                echo "Rola została poprawnie dodana.";
            }
        } else {
            echo "Nie udało się pobrać ID użytkownika Discorda.";
        }
    } else {
        echo "Nie udało się uzyskać tokenu dostępu.";
    }

    // Przekieruj użytkownika na stronę bez kodu w URL
    header("Location: http://localhost/discord-linking");
    exit();
}

// Inne operacje (np. zmiana hasła, aktywacja subskrypcji)...
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["updatePassword"])) {
        $error = $user->updateUserPass($_POST);
    }

    if (isset($_POST["activateSub"])) {
        $error = $user->activateSub($_POST);
    }
}

$uid = Session::get("uid");
$username = Session::get("username");
$admin = Session::get("admin");

$sub = $user->getSubStatus();

Util::banCheck();

?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <title>velocity - discord linking</title>
    <link rel="stylesheet" href="./files/app.css">
    <script src="./files/jquery.min.js.download"></script>
    <script src="./files/socket.io.js.download"></script>
    <link rel="stylesheet" href="./files/toastr.min.css">
    <script src="./files/toastr.min.js.download"></script>
    <style>
        .toast {
            background: black;
            box-shadow: none !important;
        }
        .toast-error {
            border: 1px solid red;
        }
        .toast-success {
            border: 1px solid red;
        }
    </style>
    <style>
        input[type="text"] {
            padding: 2px !important;
            margin: 5px !important;
            width: 150px !important;
            display: inline-block;
        }
        button {
            background: black;
            border: 1px solid rgb(255, 255, 255);
            padding: 2px !important;
            margin: 0 !important;
            width: 150px !important;
            display: inline-block;
            color: rgb(180, 180, 180);
        }
        .inner {
            border-top: 0 !important;
            border-bottom: 0 !important;
        }
    </style>
</head>

<body>
    <script>
        if (location.href.indexOf("?") != -1 && location.href.indexOf("username=") == -1) {
            if (location.href.indexOf("succ") != -1)
                toastr.success(location.href.substring(location.href.indexOf("?") + 1, location.href.length).split("_").join(" ").split("=")[0]);
            else
                toastr.error(location.href.substring(location.href.indexOf("?") + 1, location.href.length).split("_").join(" ").split("=")[0]);
        }
    </script>

    <?php if (isset($error)) : ?>
        <div class="alert alert-primary" role="alert">
            <?php Util::display($error); ?>
        </div>
    <?php endif; ?>

    <div class="main">
        <div class="panel-card" style="min-height: 125px">
            <div class="header">
                <span>discord linking</span>
            </div>
            <div class="inner">
                <div class="separator"><br>
                    <span>discord server</span><br><br>
                    <button onclick="window.location.href='https://discord.gg/';">click to join</button>
                </div>

                <div class="separator"><br>
                    <span>link ur discord</span><br><br>
                    <button onclick="window.location.href='';">click to link</button>
                </div>
            </div>
        </div>
    </div>

    <div class="controls">
        <a href="/logout">log out</a>
    </div>

    <div class="user-controls">
        <a href="./" class="panel-link">panel</a>
    </div>

<iframe name="__privateStripeMetricsController1540" frameborder="0" allowtransparency="true" scrolling="no" allow="payment *" src="./files/m-outer-fd3c67f2efa9f22f2ecd16b13f2a7fb3.html" aria-hidden="true" tabindex="-1" style="border: none !important; margin: 0px !important; padding: 0px !important; width: 1px !important; min-width: 100% !important; overflow: hidden !important; display: block !important; visibility: hidden !important; position: fixed !important; height: 1px !important; pointer-events: none !important; user-select: none !important;"></iframe></body>
</html>

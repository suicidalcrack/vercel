<?php

require_once 'app/require.php';

$user = new UserController;

Session::init();

if (!Session::isLogged()) {
    Util::redirect('/login');
}

$username = Session::get('username');

$invites = $user->getInvitesByUser($username);

?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <title>velocity - invites</title>
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

    <div class="main">
        <div class="panel-card" style="min-height: 125px">
            <div class="header">
                <span>Invites</span>
            </div>
            <div class="content">
                <?php if (empty($invites)): ?>
                    <p>No invites found.</p>
                <?php else: ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Invite Code</th>
                                <th>Date Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($invites as $invite): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($invite->code); ?></td>
                                    <td><?php echo htmlspecialchars($invite->createdAt); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="controls">
        <a href="/logout">log out</a>
    </div>

    <div class="user-controls">
        <a href="./" class="panel-link">panel</a>
    </div>

</body>
</html>

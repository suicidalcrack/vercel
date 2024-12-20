<?php

require_once '../app/require.php';
require_once '../app/controllers/AdminController.php';

$user = new UserController;
$admin = new AdminController;

Session::init();

$username = Session::get("username");

Util::adminCheck();
Util::navbar();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>velocity - home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        /* styles.css */

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #000; /* Dark background for the body */
            color: #000; /* Light text color */
        }

        .card {
            background-color: #0000; /* Darker card background */
            color: #000; /* Light text color inside cards */
			box-shadow: 0 0 1px rgba(255, 255, 255, 1); /* Delikatny efekt poświaty */
			display: flex;
    		justify-content: center;
			transition: transform 0.5s ease, box-shadow 0.5s ease; /* Smooth transitions for both tilt and glow effect */
			border-radius: 15px;
        }
		
		.card:hover {
			transform: rotateX(10deg) rotateY(10deg); /* Tilt effect */
		}

        .card-body {
            color: #fff;
            padding: 20px;
        }

        .card i {
            color: #fff; /* Black color for icons */
        }

        .text-muted {
            color: #a6a6a6 !important; /* Muted text color */
        }

        .bg-dark {
            background-color: #000 !important; /* Dark background for the body */
			box-shadow: 0 0 1px rgba(255, 255, 255, 1); /* Delikatny efekt poświaty */
        }

        .navbar {
            background-color: #fff; /* Dark background for navbar */
        }

        .navbar-brand {
            color: #ffffff !important; /* Light text color for navbar brand */
        }

        .nav-link {
            color: #ffffff !important; /* Light text color for navbar links */
			transition: color 0.8s ease, transform 0.8s ease;
        }

        .nav-link:hover {
            color: #919191 !important; /* Light blue color on hover */
			transition: color 0.8s ease, transform 0.8s ease;
        }

        .h3 {
            white-space: nowrap;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <?php Util::adminNavbar(); ?>

            <div class="col-xl-3 col-sm-6 col-xs-12 mt-3">
                <div class="card">
                    <div class="card-body row">
                        <div class="col-6 text-center">
                            <h3><i class="fas fa-users fa-2x"></i></h3>
                        </div>
                        <div class="col-6">
                            <h3><?php Util::display($user->getUserCount()); ?></h3>
                            <span class="small text-muted text-uppercase">Total</span>
                        </div>
                    </div>
                </div>
            </div>

            <!--Newest Registered User-->
            <div class="col-xl-3 col-sm-6 col-xs-12 mt-3">
                <div class="card">
                    <div class="card-body row">
                        <div class="col-6 text-center">
                            <h3><i class="fas fa-user fa-2x"></i></h3>
                        </div>
                        <div class="col-6">
                            <h3 class="text-truncate"><?php Util::display($user->getNewUser()); ?></h3>
                            <span class="small text-muted text-uppercase">Latest</span>
                        </div>
                    </div>
                </div>
            </div>

            <!--Total Banned Users-->
            <div class="col-xl-3 col-sm-6 col-xs-12 mt-3">
                <div class="card">
                    <div class="card-body row">
                        <div class="col-6 text-center">
                            <h3><i class="fas fa-user-slash fa-2x"></i></h3>
                        </div>
                        <div class="col-6">
                            <h3><?php Util::display($user->getBannedUserCount()); ?></h3>
                            <span class="small text-muted text-uppercase">Banned</span>
                        </div>
                    </div>
                </div>
            </div>

            <!--Total Active Sub Users-->
            <div class="col-xl-3 col-sm-6 col-xs-12 mt-3">
                <div class="card">
                    <div class="card-body row">
                        <div class="col-6 text-center">
                            <h3><i class="fas fa-user-clock fa-2x"></i></h3>
                        </div>
                        <div class="col-6">
                            <h3><?php Util::display($user->getActiveUserCount()); ?></h3>
                            <span class="small text-muted text-uppercase">Subs</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

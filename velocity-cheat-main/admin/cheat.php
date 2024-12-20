<?php

require_once '../app/require.php';
require_once '../app/controllers/AdminController.php';
require_once '../app/controllers/CheatController.php';

$user = new UserController;
$cheat = new CheatController;
$admin = new AdminController;

Session::init();

$username = Session::get("username");

Util::adminCheck();
Util::navbar();

// if post request 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	if (isset($_POST["cheatStatus"])) {
		$admin->setCheatStatus(); 
	}

	if (isset($_POST["cheatMaint"])) {
		$admin->setCheatMaint(); 
	}

	if (isset($_POST["cheatVersion"])) {
		$ver = floatval($_POST['version']);
		$admin->setCheatVersion($ver); 
	}

	header("location: cheat.php");

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>velocity - cheat</title>
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
            text-align: center;
        }

        .btn-custom {
            background-color: #000;
            color: #fff;
            border: 1px solid #777;
        }
        .btn-custom:hover {
            background-color: #333;
            color: #fff;
            border-color: #fff;
        }
        
        .form-control-custom {
            background-color: #000; /* Black background */
            color: #fff; /* White text */
            border: 1px solid #777; /* White border */
            border-radius: 0.25rem; /* Rounded corners */
        }
        .form-control-custom::placeholder {
            color: #ccc; /* Light grey placeholder text */
        }
        .form-control-custom:focus {
            background-color: #000; /* Keep black background on focus */
            color: #fff; /* White text on focus */
            border-color: #fff; /* White border on focus */
            box-shadow: none; /* Remove default box-shadow on focus */
        }

        .form-control-short {
            max-width: 70px; /* Adjust to desired width */
        }

        .form-row {
            display: flex;
            align-items: center;
        }

        .form-row .col {
            margin-right: 0.5rem; /* Adjust space between columns */
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
                            <h3><i class="fas fa-thermometer fa-2x"></i></h3>
                        </div>
                        <div class="col-6">
                            <h3><?php Util::display($cheat->getCheatData()->status); ?></h3>
                            <span class="small text-muted text-uppercase">undetected    </span>
                        </div>
                    </div>
                </div>
            </div>

            <!--Newest Registered User-->
            <div class="col-xl-3 col-sm-6 col-xs-12 mt-3">
                <div class="card">
                    <div class="card-body row">
                        <div class="col-6 text-center">
                            <h3><i class="fas fa-code-branch fa-2x"></i></h3>
                        </div>
                        <div class="col-6">
                            <h3 class="text-truncate"><?php Util::display($cheat->getCheatData()->version); ?></h3>
                            <span class="small text-muted text-uppercase">version</span>
                        </div>
                    </div>
                </div>
            </div>

            <!--Total Banned Users-->
            <div class="col-xl-3 col-sm-6 col-xs-12 mt-3">
                <div class="card">
                    <div class="card-body row">
                        <div class="col-6 text-center">
                            <h3><i class="fas fa-wrench fa-2x"></i></h3>
                        </div>
                        <div class="col-6">
                            <h3><?php Util::display($cheat->getCheatData()->maintenance); ?></h3>
                            <span class="small text-muted text-uppercase">maintenance</span>
                        </div>
                    </div>
                </div>
            </div>

            <!--Total Active Sub Users-->
            <div class="col-xl-3 col-sm-6 col-xs-12 mt-3">
                <div class="card">
                    <div class="card-body row">
                        <div class="col-6 text-center">
                            <h3><i class="fas fa-user-slash fa-2x"></i></h3>
                        </div>
                        <div class="col-6">
                            <h3><?php Util::display($user->getBannedUserCount()); ?></h3>
                            <span class="small text-muted text-uppercase">banned</span>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Form Actions -->
            <div class="col-12 mt-3">
                <div class="rounded p-3 mb-3">
                <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                        <button name="cheatStatus" type="submit" class="btn btn-custom btn-sm">
                            set detection
                        </button>

                        <button name="cheatMaint" type="submit" class="btn btn-custom btn-sm">
                            set maintenance
                        </button>
                    </form>

                    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                        <div class="form-row mt-1">
                        <div class="col-auto">
                                <input type="text" class="form-control form-control-custom form-control-short form-control-sm" placeholder="version" name="version" required>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-custom btn-sm" name="cheatVersion" type="submit" value="submit">update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php

require_once '../app/require.php';
require_once '../app/controllers/AdminController.php';

$user = new UserController;
$admin = new AdminController;

Session::init();

$username = Session::get("username");

$userList = $admin->getUserArray();

Util::adminCheck();
Util::navbar(); // Ensure this outputs the navbar HTML correctly

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["resetHWID"])) { 
        $rowUID = $_POST['resetHWID'];
        $admin->resetHWID($rowUID); 
    }

    if (isset($_POST["setBanned"])) { 
        $rowUID = $_POST['setBanned'];
        $admin->setBanned($rowUID); 
    }

    if (isset($_POST["setAdmin"])) { 
        $rowUID = $_POST['setAdmin'];
        $admin->setAdmin($rowUID); 
    }

    header("Location: users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>velocity - users</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #000;
            color: #fff; /* Light text color */
        }

        .card {
            background-color: #000;
            color: #fff; /* Light text color inside cards */
            box-shadow: 0 0 1px rgba(255, 255, 255, 0.5);
            display: flex;
            justify-content: center;
            transition: transform 0.5s ease, box-shadow 0.5s ease;
            border-radius: 15px;
        }

        .card:hover {
            transform: rotateX(10deg) rotateY(10deg);
        }

        .card-body {
            color: #fff;
            padding: 20px;
        }

        .card i {
            color: #fff;
        }

        .text-muted {
            color: #a6a6a6 !important;
        }

        .bg-dark {
            background-color: #000 !important;
            box-shadow: 0 0 1px rgba(255, 255, 255, 1);
        }

        .navbar {
            background-color: #000; /* Correcting navbar color */
        }

        .navbar-brand {
            color: #fff !important; /* Correcting navbar brand color */
        }

        .nav-link {
            color: #fff !important; /* Correcting nav-link color */
            transition: color 0.8s ease, transform 0.8s ease;
        }

        .nav-link:hover {
            color: #919191 !important;
        }

        .table {
            background-color: #000;
            color: #fff;
            border: 2px solid; /* Outer stroke */
            border-radius: 15px;
        }

        .table thead th {
            background-color: #000;
            text-align: center; /* Center text in header */
        }

        .table tbody tr:hover {
            background-color: #333;
        }

        .table tbody td,
        .table tbody th {
            vertical-align: middle; /* Center content vertically */
            text-align: center; /* Center content horizontally */
        }

        .btn-custom {
            color: #fff !important; /* Correcting nav-link color */
            transition: color 0.8s ease, transform 0.8s ease;
            border: 1px solid white;
            border-radius: 50px;
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
            height: 30px;
            line-height: 1;
        }

        .btn-custom i {
            font-size: 0.9rem;
        }

        .btn-custom:hover {
            color: #919191 !important;
        }

        .rounded {
            margin-top: 16px;
            border-radius: 15px;
        }

        .action-buttons {
            justify-content: center; /* Wyśrodkowuje przyciski poziomo */
            align-items: center;     /* Wyśrodkowuje przyciski pionowo */
        }

/* Styl dla formularza w celu usunięcia marginesów i wyrównania przycisków */
        .action-buttons form {
            gap: 5px; /* Opcjonalne odstępy między przyciskami */
            margin: 0;
        }


    </style>
</head>
<body>
    <div class="container mt-2">
        <div class="row">
            <?php Util::adminNavbar(); ?>

            <div class="col-12 mt-3 mb-2">
                <table class="rounded table">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">UID</th>
                            <th scope="col">Username</th>
                            <th scope="col" class="text-center">Admin</th>
                            <th scope="col" class="text-center">Banned</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Loop for number of rows -->
                        <?php foreach ($userList as $row) : ?>
                            <tr>
                                <th scope="row" class="text-center"><?php Util::display($row->uid); ?></th>
                                <td><?php Util::display($row->username); ?></td>
                                <td class="text-center">
                                    <?php if ($row->admin == 1) : ?>
                                        <i class="fas fa-check-circle"></i>
                                    <?php else : ?>
                                        <i class="fas fa-times-circle"></i>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($row->banned == 1) : ?>
                                        <i class="fas fa-check-circle"></i>
                                    <?php else : ?>
                                        <i class="fas fa-times-circle"></i>
                                    <?php endif; ?>
                                </td>
                                <td class="action-buttons form">
                                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
									<button value="<?php Util::display($row->uid); ?>" name="resetHWID" title="Reset HWID" class="btn btn-custom btn-sm" type="submit">
    									<i class="fas fa-microchip"></i>
									</button>
                                        <button value="<?php Util::display($row->uid); ?>" name="setBanned" title="Ban/unban user" class="btn btn-custom btn-sm" type="submit">
                                            <i class="fas fa-user-slash"></i>
                                        </button>
                                        <button value="<?php Util::display($row->uid); ?>" name="setAdmin" title="Set admin/non admin" class="btn btn-custom btn-sm" type="submit">
                                            <i class="fas fa-crown"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php Util::footer(); ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });
    </script>
</body>
</html>

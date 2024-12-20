<?php

require_once '../app/require.php';
require_once '../app/controllers/AdminController.php';

$user = new UserController;
$admin = new AdminController;

Session::init();

$username = Session::get("username");

$invList = $admin->getInvCodeArray();

Util::adminCheck();
Util::navbar();

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST["genInv"])) {
        $admin->getInvCodeGen($username); 
    }

    if (isset($_POST["deleteInv"])) {
        $invCode = $_POST['deleteInv'];
        $admin->deleteInvCode($invCode); 
    }

    header("location: invites.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>velocity - invites</title>
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
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Invite code copied to clipboard');
            }, function(err) {
                alert('Failed to copy code: ' + err);
            });
        }
    </script>
</head>
<body>
    <div class="container mt-2">
        <div class="row">

            <?php Util::adminNavbar(); ?> 

            <div class="col-12 mt-3">
                <div class="rounded p-3 mb-3">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <button name="genInv" type="submit" class="btn btn-custom btn-sm">
                            gen inv code
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-12 mb-2">
                <table class="rounded table">
                    <thead>
                        <tr>
                            <th scope="col">Code</th>
                            <th scope="col">Created By</th>
                            <th scope="col">Actions</th> <!-- Dodaj kolumnę "Actions" -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($invList as $row) : ?>
                            <tr>
                                <td><?php Util::display($row->code); ?></td>
                                <td><?php Util::display($row->createdBy); ?></td>
                                <td class="text-center">
                                    <!-- Przycisk do kopiowania kodu -->
                                    <button type="button" class="btn btn-custom btn-sm" onclick="copyToClipboard('<?php echo htmlspecialchars($row->code); ?>')">
                                        <i class="fas fa-copy"></i>
                                    </button>

                                    <!-- Przycisk do usuwania zaproszenia -->
                                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" style="display: inline;">
                                        <input type="hidden" name="deleteInv" value="<?php echo htmlspecialchars($row->code); ?>">
                                        <button type="submit" class="btn btn-custom btn-sm" title="Delete invite">
                                            <i class="fas fa-trash"></i>
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

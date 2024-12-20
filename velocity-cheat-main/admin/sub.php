<?php

require_once '../app/require.php';
require_once '../app/controllers/AdminController.php';

$user = new UserController;
$admin = new AdminController;

Session::init();

$username = Session::get("username");

$subList = $admin->getSubCodeArray();

Util::adminCheck();
Util::navbar();

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST["genSub"])) {
        $admin->getSubCodeGen($username); 
    }

    if (isset($_POST["deleteSub"])) {
        $subCode = $_POST['deleteSub'];
        $admin->deleteSubCode($subCode); 
    }

    header("location: sub.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>velocity - subs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #000;
            color: #fff;
        }

        .card {
            background-color: #000;
            color: #fff;
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
            background-color: #000;
        }

        .navbar-brand {
            color: #fff !important;
        }

        .nav-link {
            color: #fff !important;
            transition: color 0.8s ease, transform 0.8s ease;
        }

        .nav-link:hover {
            color: #919191 !important;
        }

        .table {
            background-color: #000;
            color: #fff;
            border: 2px solid;
            border-radius: 15px;
        }

        .table thead th {
            background-color: #000;
            text-align: center;
        }

        .table tbody tr:hover {
            background-color: #333;
        }

        .table tbody td,
        .table tbody th {
            vertical-align: middle;
            text-align: center;
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
            justify-content: center;
            align-items: center;
        }

        .action-buttons form {
            gap: 5px;
            margin: 0;
        }
    </style>
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Subscription code copied to clipboard');
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
                        <button name="genSub" type="submit" class="btn btn-custom btn-sm">
                            gen sub code
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
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($subList as $row) : ?>
                            <tr>
                                <td><?php Util::display($row->code); ?></td>
                                <td><?php Util::display($row->createdBy); ?></td>
                                <td class="text-center">
                                    <!-- Przycisk do kopiowania kodu -->
                                    <button type="button" class="btn btn-custom btn-sm" onclick="copyToClipboard('<?php echo htmlspecialchars($row->code); ?>')">
                                        <i class="fas fa-copy"></i>
                                    </button>

                                    <!-- Przycisk do usuwania subskrypcji -->
                                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" style="display: inline;">
                                        <input type="hidden" name="deleteSub" value="<?php echo htmlspecialchars($row->code); ?>">
                                        <button type="submit" class="btn btn-custom btn-sm" title="Delete subscription">
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
</body>
</html>

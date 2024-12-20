
<head>
    <style>
        /* Custom styles for the admin panel buttons */
        .btn-outline-custom {
            color: #ffffff; /* Text color */
            box-shadow: 0 0 1px rgba(255, 255, 255, 1); /* Delikatny efekt poświaty */
			border-radius: 7px;
			transition: color 0.5s ease, transform 0.5s ease;
        }

        .btn-outline-custom:hover {
            background-color: #ffffff; /* Background color on hover */
            box-shadow: 0 0 1px rgba(0, 0, 0, 1); /* Delikatny efekt poświaty */
			transition: color 0.5s ease, transform 0.5s ease;
        }

    </style>
</head>
<body>
    <!--Admin navigation-->
    <!-- Check if admin // This is not important really.-->
    <?php if (Session::isAdmin()) : ?>
        <div class="col-12 mt-3 mb-2">
            <div class="rounded p-3">
                <a href='index.php' class="btn btn-outline-custom btn-sm">home</a>
                <a href='users.php' class="btn btn-outline-custom btn-sm">users</a>
                <a href='invites.php' class="btn btn-outline-custom btn-sm">invites</a>
                <a href='sub.php' class="btn btn-outline-custom btn-sm">subs</a>
                <a href='cheat.php' class="btn btn-outline-custom btn-sm">cheat</a>
            </div>
        </div>
    <?php endif; ?>
    
</body>
</html>

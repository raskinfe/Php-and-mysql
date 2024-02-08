<?php

$title = "Register";
require $_SERVER['DOCUMENT_ROOT'].'/controllers/registercontroller.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/views/layouts/header.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/views/layouts/includes.php';

?>

<body>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/views/layouts/navigation.php';?>
<div class="container">
    <main>
        <?php include __DIR__. '/layouts/alert.php'; ?>
        <div class="form-container">
            <header class="__text">
                <h3>Sign up</h3>
            </header>
            <form action="" method="post">
                <div class="form-items">
                    <i class="fa-solid fa-person"></i>
                    <input type="text" name="name" placeholder="Full Name" id="name" required>
                </div>
                <div class="form-items">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" id="email" placeholder="Email" name="email" required>
                </div>
                <div class="form-items">
                    <i class="fa-solid fa-key"></i>
                    <input type="password" name="password" placeholder="Password" id="password" required>
                </div>
                <div class="form-items">
                    <i class="fa-solid fa-unlock-keyhole"></i>
                    <input type="password" name="repeat_password" placeholder="Repeat password" id="repeat_password" required>
                </div>
                <input type="submit" class="btn btn-primary" value="Submit">
            </form>
        </div>
    </main>
</div>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/views/layouts/footer.php';?>
</body>

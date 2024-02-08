<?php

$title = "About";
require_once $_SERVER['DOCUMENT_ROOT'].'/views/layouts/header.php';
require_once$_SERVER['DOCUMENT_ROOT'].'/views/layouts/includes.php';
?>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'].'/views/layouts/navigation.php';?>
    <main class="about-container">
        <div>
            <header>
                <span>About us</span>
            </header>
            <section class="about-content">
               <p>
               This platform provides a customer customer service for students to sell and buy their used books.
                Students can register on the site and look through existing offers and bid their price on the offers.
               </p>
                
               <p>
                Registered students can also create their offer so other can bid in.
               </p>
               <p>
                This website is a simplest form of showing a CRUD operation using sql and php.
               </p>
            </section>
        </div>
    </main>
    <?php require_once $_SERVER['DOCUMENT_ROOT'].'/views/layouts/footer.php';?>
</body>
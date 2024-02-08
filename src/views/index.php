<?php

$title = "Home";
require_once $_SERVER['DOCUMENT_ROOT'].'/views/layouts/header.php';
require_once$_SERVER['DOCUMENT_ROOT'].'/views/layouts/includes.php';
require_once$_SERVER['DOCUMENT_ROOT'].'/services/helper.php';

?>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'].'/views/layouts/navigation.php';?>
    <main class="offer-container">
        <div class="sidebar">
            <button class="btn btn-primary new-item" onclick="window.location.href = '/create-new';">
                <span>Create a new offer</span>
                <i class="fa fa-plus"></i>
            </button>
            <div class="__filter-category">
                <?php foreach (CATEGORIES as $key => $category): ?>
                    <div class="__single-offer">
                        <input type="checkbox" value="<?= $key ?>" onclick="filterCategory()" class="category">
                        <span><?= $category ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
            <div class="offers" id="offers" style="display: none">

            </div>
            <div class="__no_offers" hidden id="hidden">
                <span>No offers available</span>
            </div>
        <div class="right-panel" style="display: none">

        </div>
    </main>
    <?php require_once $_SERVER['DOCUMENT_ROOT'].'/views/layouts/footer.php';?>
</body>

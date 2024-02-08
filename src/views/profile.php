<?php
$title = "Profile";
session_start();
require $_SERVER['DOCUMENT_ROOT'].'/controllers/profileController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/views/layouts/header.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/views/layouts/includes.php';
?>

<body>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/views/layouts/navigation.php';?>
<div class="container">
    <main>
        <?php include __DIR__. '/layouts/alert.php'; ?>
        <div class="middle">
            <div class="profile-container">
                <?php if(isset($user)): ?>
                <div class="avatar">
                    <input type="file" id="avatar" hidden>
                        <?php if (isset($user['avatar'])): ?>
                            <img src="./assets/uploads/<?= $user["avatar"] ?>" alt="profile picture">
                            <i class="fa fa-edit" onclick="updateAvatar()"> Edit profile</i>
                        <?php else: ?>
                            <img src="./assets/images/profile.png" alt="profile picture">
                            <i class="fa fa-edit" onclick="updateAvatar()"> Edit profile</i>
                        <?php endif ?>
                </div>
                    <div class="profile-item" id="name">
                        <span><?= $user['name'] ?></span>
                        <i class="fa fa-edit" onclick="editName()"></i>
                    </div>
                    <div class="form-items" id="name-input" style="display: none">
                        <input type="text" value="<?= $user['name'] ?>" name="name"  id="--name" />
                        <i class="fa fa-check" onclick="updateName()"></i>
                    </div>
                    <div class="profile-item">
                        <span><?= $user['email'] ?></span>
                    </div>
                    <button class="btn btn-secondary" onclick="destroyUser()">
                        <span>Delete account</span>
                        <i class="fa fa-trash"></i>
                    </button>
                <?php endif ?>
            </div>
            <div class="offers-container" id="offer-container" style="display: none"></div>
        </div>
    </main>
</div>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/views/layouts/footer.php';?>
</body>

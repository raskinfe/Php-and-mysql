<?php
    session_start();
    if(!isset($page_title)){ $page_title = ''; }
    $current_url = explode('/', $_SERVER['REQUEST_URI'])[1];
    require_once $_SERVER['DOCUMENT_ROOT']. '/services/helper.php';
?>

<div class="nav-container">
    <header class="title">
        <div class="logo">
            <img src="../../assets/images/THD-Logo.png" alt="logo">
        </div>
        <p class="nav-items">
            <a href="/" <?php if ($current_url == "/" || $current_url == ''){echo "class='--active'"; } ?>>Home</a>
        </p>
    </header>
    <nav>
        <ul class="nav">
            <li class="nav-items">
                <a href="/about" <?php if ($current_url == "about"){echo "class='--active'"; } ?>>about</a>
            </li>
            <li class="nav-items">
                <i class="fa fa-shopping-cart" aria-hidden="true" onclick="showCart()">
                    <span class="counter" id="counter"></span>
                </i>
            </li>
            <?php if (!isLoggedIn()): ?>
                <li class="nav-items">
                    <a href="/register" <?php if ($current_url == "register"){echo "class='--active'"; } ?>>register</a>
                </li>
                <li class="nav-items">
                    <a href="/login" <?php if ($current_url == "login"){echo "class='--active'"; } ?>>login</a>
                </li>
            <?php else: ?>
                <li class="nav-items">
                    <a href="/profile" <?php if ($current_url == "profile"){echo "class='--active'"; } ?>>
                        <?php
                            echo $_SESSION['user']['name'] ?? '';
                        ?>
                    </a>
                </li>
                <li class="nav-items">
                    <a href="#" <?php if ($current_url == "logout"){echo "class='--active'"; } ?> id="logout" onclick="clearLocal()">Logout</a>
                </li>
            <?php endif ?>
        </ul>
    </nav>
</div>

<script>
    getResults();
</script>

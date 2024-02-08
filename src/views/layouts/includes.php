<link rel="stylesheet" href="../../assets/css/main.css" >
<link rel="stylesheet" href="../../assets/css/404.css" >
<link rel="stylesheet" href="../../assets/css/nav.css" >
<link rel="stylesheet" href="../../assets/css/footer.css" >
<link rel="stylesheet" href="../../assets/css/register.css" >
<link rel="stylesheet" href="../../assets/css/about.css" >
<script src="../../assets/js/form.js"></script>
<script src="../../assets/js/helper.js"></script>

<?php
    $requestUrl = $_SERVER['REQUEST_URI'];
    $requestUrl = explode('?', $requestUrl)[0];
?>

<?php if ($requestUrl == '/'): ?>
    <link rel="stylesheet" href="../../assets/css/index.css" >
    <script src="../../assets/js/index.js" defer></script>
<?php endif; ?>

<?php if ($requestUrl == '/profile'): ?>
    <link rel="stylesheet" href="../../assets/css/profile.css">
    <script src="../../assets/js/profile.js" defer></script>
<?php endif; ?>

<?php if ($requestUrl == '/edit-book'): ?>
    <link rel="stylesheet" href="../../assets/css/edit.css">
    <!-- <script src="../../assets/js/profile.js" defer></script> -->
<?php endif; ?>

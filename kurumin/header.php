<!doctype html>
<html lang="ja">
<head>
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <title>
        <?php
        if(!is_home()) {
            wp_title('|', true, 'right');
        }
        bloginfo('name');
        ?>
    </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/reset.css">
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); echo '?' . filemtime( get_stylesheet_directory() . '/style.css'); ?>">


    <script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/admin.js"></script>

<!--
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kosugi+Maru&display=swap" rel="stylesheet">
    <style>
    @import url(//fonts.googleapis.com/earlyaccess/hannari.css);
    </style>
-->


    <?php wp_head(); ?>
</head>
<body>

    <?php
        if (isset($_SESSION['login_id'])) {
            $login_id = $_SESSION['login_id'];
     ?>
    // ログイン中
    <header class=" admin_header">
        <div class="logo">
            <img src="<?php echo get_template_directory_uri();?>/imgs/family01.png"><p>くるみん申請(管理者)</p>
        </div>
    </header>
    <?php } else { ?>
    <header>
        <div class="logo">
            <img src="<?php echo get_template_directory_uri();?>/imgs/family01.png"><p>くるみん申請サイト</p>
        </div>
    </header>
    <?php } ?>


<!--
        <div class="menu_wrap">
            <nav class="main_menu">
                <ul>
                    <li>申請書</li>
                    <li>誓約書</li>
                    <li>実施報告書</li>
                </ul>
            </nav>
        </div>
-->

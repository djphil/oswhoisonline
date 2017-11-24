<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $title." v".$version; ?>">
    <meta name="author" content="Philippe Lemaire (djphil)">
    <link rel="icon" href="img/favicon.ico">
    <link rel="author" href="inc/humans.txt" />

    <title><?php echo $title." v".$version; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <!-- <link rel="stylesheet" href="./css/style.css"> -->
    <?php if ($useTheme === TRUE): ?>
        <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <?php endif ?>
    
    <?php if ($display_ribbon === TRUE): ?>
        <link href="css/gh-fork-ribbon.min.css" rel="stylesheet">
    <?php endif ?>

    <link href="css/oswhoisonline.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="container">
        <?php if ($display_ribbon === TRUE): ?>
            <div class="github-fork-ribbon-wrapper left">
                <div class="github-fork-ribbon">
                    <a href="<?php echo $github_url; ?>" target="_blank">Fork me on GitHub</a>
                </div>
            </div>
        <?php endif ?>

        <div class="row">

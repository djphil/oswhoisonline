<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
ini_set('magic_quotes_gpc', 0);

$title = "OpenSim Whois Online";
$version = "v0.2";
$debug = FALSE;

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "<DB PASS>";
$dbname = "<DB NAME>";
$tbname = "presence";
$tbmodu = "oswhoisonline_settings";

/* SIMULATOR CONFIG */
$robustHOST = "domain.com";
$robustPORT = 8002;

/* MODULE CONFIG */
$friends_only = TRUE;

$admins = [
    "29736bb5-063f-4c77-b408-e592d884b019",
    "",
    ""
];

/* RIBBON CONFIG */
$display_ribbon = TRUE;
$github_url = "https://github.com/djphil/oswhoisonline";

/* STYLE CONFIG */
$useTheme = TRUE;
/* Navbar Style */
// navbar
// navbar-btn
// navbar-form
// navbar-left
// navbar-right
// navbar-default
// navbar-inverse
// navbar-collapse
// navbar-fixed-top
// navbar-fixed-bottom
$CLASS_NAVBAR = "navbar navbar-default";
$CLASS_ORDERBY_NAVBAR = "navbar navbar-default";

/* Nav Style */
// nav
// nav-tabs
// nav-pills
// navbar-nav
// nav-stacked
// nav-justified
$CLASS_NAV = "nav navbar-nav";
$CLASS_ORDERBY_NAV = "nav navbar-nav";
?>

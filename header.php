<?php
$siteName = $siteName ?? 'Nintendo Homebrew';
$pageTitle = $pageTitle ?? $siteName;
$pageMetaTitle = $pageMetaTitle ?? $siteName;
$pageDescription = $pageDescription ?? "The official website of the Nintendo Homebrew Discord server. We're a collection of homebrew and console enthusiasts and modders.";
$pageUrl = $pageUrl ?? 'https://nintendohomebrew.com/';
$pageImage = $pageImage ?? 'https://nintendohomebrew.com/assets/img/NintendoHomebrewLogo.png';
$pageOgTitle = $pageOgTitle ?? $pageMetaTitle;
$pageOgDescription = $pageOgDescription ?? $pageDescription;
$pageOgUrl = $pageOgUrl ?? $pageUrl;
$pageOgImage = $pageOgImage ?? $pageImage;
$pageTwitterCard = $pageTwitterCard ?? 'summary_large_image';
$pageTwitterTitle = $pageTwitterTitle ?? $pageOgTitle;
$pageTwitterDescription = $pageTwitterDescription ?? $pageOgDescription;
$pageTwitterUrl = $pageTwitterUrl ?? $pageOgUrl;
$pageTwitterImage = $pageTwitterImage ?? $pageOgImage;
$appleMobileWebAppTitle = $appleMobileWebAppTitle ?? $siteName;
$stylesheet = $stylesheet ?? 'styles.css';
$escape = function ($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};
?>
<!doctype html>
<html lang="en">
<head>
<title><?= $escape($pageTitle) ?></title>
<meta name="title" content="<?= $escape($pageMetaTitle) ?>" />
<meta name="description" content="<?= $escape($pageDescription) ?>" />
<meta property="og:type" content="website" />
<meta property="og:url" content="<?= $escape($pageOgUrl) ?>" />
<meta property="og:title" content="<?= $escape($pageOgTitle) ?>" />
<meta property="og:description" content="<?= $escape($pageOgDescription) ?>" />
<meta property="og:image" content="<?= $escape($pageOgImage) ?>" />
<meta property="twitter:card" content="<?= $escape($pageTwitterCard) ?>" />
<meta property="twitter:url" content="<?= $escape($pageTwitterUrl) ?>" />
<meta property="twitter:title" content="<?= $escape($pageTwitterTitle) ?>" />
<meta property="twitter:description" content="<?= $escape($pageTwitterDescription) ?>" />
<meta property="twitter:image" content="<?= $escape($pageTwitterImage) ?>" />
<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
<link rel="icon" type="image/svg+xml" href="/favicon.svg" />
<link rel="shortcut icon" href="/favicon.ico" />
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
<meta name="apple-mobile-web-app-title" content="<?= $escape($appleMobileWebAppTitle) ?>" />
<link rel="manifest" href="/site.webmanifest" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="<?= $escape($stylesheet) ?>">
</head>
<body>
<div class="container">
    <header class="header-bar">
		<button class="menu-icon" type="button" aria-label="Open navigation menu" aria-controls="site-navigation" aria-expanded="false" title="Navigation Menu">
            &#9776;
		</button>
        <h1><?= $escape($siteName) ?></h1>
        <img src="/assets/img/NintendoHomebrewLogo.png" alt="<?= $escape($siteName) ?> Logo" class="logo">
    </header>
    <nav aria-label="Main navigation">
        <ul class="nav-links" id="site-navigation">
            <li class="nav-close-item"><button class="nav-close" type="button" aria-label="Close navigation menu">&times;</button></li>
            <li><a href="/index">Home</a></li>
            <li><a href="/rules">Rules</a></li>
            <li><a href="/contact">Contact</a></li>
            <li><a href="/appeal">Appeals</a></li>
        </ul>
    </nav>
<div class="content">

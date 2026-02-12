<?php 
$formConfig = [
  'toEmail'   => 'staff@nintendohomebrew.com',
  'fromName'  => 'nh contact',
  'formEmail' => 'contact@nintendohomebrew.com',
  'subject'   => 'New submission from NH MAIN FORM',
];

require '/var/www/eipmain/lib/submit.php';
?>
<!doctype html>
<html lang="en">
<head>
<!-- Primary Meta Tags -->
<title>Nintendo Homebrew | Contact Us</title>
<meta name="title" content="Nintendo Homebrew" />
<meta name="description" content="The official website of the Nintendo Homebrew Discord server. We're a collection of homebrew and console enthusiasts and modders." />

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website" />
<meta property="og:url" content="https://nintendohomebrew.com/" />
<meta property="og:title" content="Nintendo Homebrew" />
<meta property="og:description" content="The official website of the Nintendo Homebrew Discord server. We're a collection of homebrew and console enthusiasts and modders." />
<meta property="og:image" content="https://nintendohomebrew.com/assets/img/NintendoHomebrewLogo.png" />

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image" />
<meta property="twitter:url" content="https://nintendohomebrew.com/" />
<meta property="twitter:title" content="Nintendo Homebrew" />
<meta property="twitter:description" content="The official website of the Nintendo Homebrew Discord server. We're a collection of homebrew and console enthusiasts and modders." />
<meta property="twitter:image" content="https://nintendohomebrew.com/assets/img/NintendoHomebrewLogo.png" />

<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
<link rel="icon" type="image/svg+xml" href="/favicon.svg" />
<link rel="shortcut icon" href="/favicon.ico" />
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
<meta name="apple-mobile-web-app-title" content="Nintendo Homebrew" />
<link rel="manifest" href="/site.webmanifest" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <!-- Header Bar -->
    <header class="header-bar">
        <div class="menu-icon" onclick="toggleMenu()">
            &#9776; <!-- Hamburger icon -->
        </div>
        <h1>Nintendo Homebrew</h1>
        <img src="/assets/img/NintendoHomebrewLogo.png" alt="Nintendo Homebrew Logo" class="logo">
    </header>
    <!-- Navigation Menu (inside header) -->
        <ul class="nav-links">
            <li><a href="/index">Home</a></li>
            <li><a href="/rules">Rules</a></li>
            <li><a href="/contact">Contact</a></li>
        </ul>
    </nav>

    <!-- Main content -->
<div class="content">
<div class="intro"><h2>Contact Us</h2>
	<div class="divider"></div>
	<p>Email us here if you need to.</p>
	</div>
      <form class="form" action="" method="post" novalidate>
        <div class="status-msg" role="status" aria-live="polite" <?php echo empty($statusMsg) ? 'hidden' : ''; ?>>
          <?php if (!empty($statusMsg)) echo $statusMsg; ?>
        </div>

        <label>
          Name
          <input name="name" required autocomplete="name"
                 value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8') : ''; ?>">
        </label>

        <label>
          Email
          <input type="email" name="email" required autocomplete="email"
                 value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8') : ''; ?>">
        </label>

        <label>
          Subject
          <input type="text" name="usersubject" required autocomplete="off" placeholder="Enter subject"
                 value="<?php echo isset($_POST['usersubject']) ? htmlspecialchars($_POST['usersubject'], ENT_QUOTES, 'UTF-8') : ''; ?>">
        </label>

        <label>
          Message
          <textarea name="message" rows="6" required><?php
            echo isset($_POST['message']) ? htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8') : '';
          ?></textarea>
        </label>

        <input type="hidden" name="token" value="">
        <!-- honeypot + time gate -->
        <label class="hp" aria-hidden="true"
               style="position:absolute; left:-10000px; top:auto; width:1px; height:1px; overflow:hidden; opacity:0;">
          Website
          <input name="favourite_colour" tabindex="-1" autocomplete="new-password">
        </label>
        <input type="hidden" name="ts" value="<?php echo time(); ?>">

        <button class="btn" type="submit" name="submit">Send</button>
      </form>
<p />
	</div>
</div>
<script src="script.js"></script>
</body>
</html>

<?php 
// Include form submission script 
include_once 'submit.php'; 
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
<?php if(!empty($statusMsg)){ ?>
    <div class="status-msg <?php echo $status; ?>" style="text-align: center; margin: 1em 0;">
        <?php echo $statusMsg; ?>
    </div>
<?php } ?>
<form action="" method="post" class="cnt-form" id="contact-form" novalidate>
  <table>
    <tr>
      <td><div class="form-input"><label for="name">Name</label></div></td>
      <td>
        <input
          type="text"
          name="name"
          id="name"
          placeholder="Enter your name"
          value="<?php echo !empty($postData['name']) ? htmlspecialchars($postData['name'], ENT_QUOTES, 'UTF-8') : ''; ?>"
          required
          autocomplete="name"
        >
      </td>
    </tr>
    <tr>
      <td><div class="form-input"><label for="email">Email</label></div></td>
      <td>
        <input
          type="email"
          name="email"
          id="email"
          placeholder="Enter your email"
          value="<?php echo !empty($postData['email']) ? htmlspecialchars($postData['email'], ENT_QUOTES, 'UTF-8') : ''; ?>"
          required
          autocomplete="email"
        >
      </td>
    </tr>
    <tr>
      <td><div class="form-input"><label for="usersubject">Subject</label></div></td>
      <td>
        <input
          type="text"
          name="usersubject"
          id="usersubject"
          placeholder="Enter subject"
          value="<?php echo !empty($postData['usersubject']) ? htmlspecialchars($postData['usersubject'], ENT_QUOTES, 'UTF-8') : ''; ?>"
          required
          autocomplete="off"
        >
      </td>
    </tr>
    <tr>
      <td><div class="form-input"><label for="message">Message</label></div></td>
      <td>
        <textarea
          name="message"
          id="message"
          placeholder="Type your message here"
          rows="6"
          required
        ><?php echo !empty($postData['message']) ? htmlspecialchars($postData['message'], ENT_QUOTES, 'UTF-8') : ''; ?></textarea>
      </td>
    </tr>
  </table>

  <!-- anti-bot fields -->
  <input
    type="text"
    name="website"
    id="website"
    tabindex="-1"
    autocomplete="off"
    aria-hidden="true"
    style="position:absolute; left:-10000px; top:auto; width:1px; height:1px; overflow:hidden; opacity:0;"
  >
  <input type="hidden" name="ts" value="<?php echo time(); ?>">

  <input type="submit" name="submit" class="btn" value="Submit">
</form>
<p />
	</div>
</div>
<script src="script.js"></script>
</body>
</html>

<?php 
$formConfig = [
  'toEmail'   => 'staff@nintendohomebrew.com',
  'fromName'  => 'nh contact',
  'formEmail' => 'contact@nintendohomebrew.com',
  'subject'   => 'New submission from NH MAIN FORM',
];

require '/var/www/eipmain/lib/submit.php';

$pageTitle = 'Nintendo Homebrew | Contact Us';
$pageMetaTitle = 'Nintendo Homebrew';
$pageDescription = 'Nintendo Homebrew general contact form.';
$pageUrl = 'https://nintendohomebrew.com/';
$pageImage = 'https://nintendohomebrew.com/assets/img/NintendoHomebrewLogo.png';
require __DIR__ . '/header.php';
?>
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
          <input name="favourite-colour" tabindex="-1" autocomplete="new-password">
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

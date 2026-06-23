<?php
$pageTitle = 'Nintendo Homebrew | NH PDF Generator';
$pageMetaTitle = 'Nintendo Homebrew';
$pageDescription = 'Nintendo Homebrew branded PDF generator for media releases.';
$pageUrl = 'https://nintendohomebrew.com/';
$pageImage = 'https://nintendohomebrew.com/assets/img/NintendoHomebrewLogo.png';
require __DIR__ . '/header.php';
?>
<div class="intro"><h2>NH Letterhead PDF generator</h2>
	<div class="divider"></div>
	<p>Use this to make a NH-branded PDF. Might be useful.</p>
	</div>
<form action="genpdf.php" method="POST" enctype="application/x-www-form-urlencoded">
    <label for="userName">Your Name:</label>
    <input type="text" id="userName" name="userName" required><br>

    <label for="doctype">Document Type:</label>
    <input type="text" id="doctype" name="doctype" required><br>

    <label for="content">Content:</label>
    <textarea id="content" name="content" rows="10" required></textarea>

    <button type="submit">Generate PDF</button>
</form>
</div>
</div>
<script src="script.js"></script>
</body>
</html>

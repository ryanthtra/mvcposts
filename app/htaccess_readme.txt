<IfModule mod_rewrite.c>
  Options -Multiviews // Disables multiple views of various extensions (e.g., index.php, index.html, etc.)
  RewriteEngine On // Turns on the rewrite engine
  RewriteBase /phpmvc/public // Defining the root url
  RewriteCond %{REQUEST_FILENAME} !-d // If filename in URL not found...
  RewriteCond %{REQUEST_FILENAME} !-f // If filename in URL not found...
  RewriteRule ^(.+)$ index.php?url=$1 [QSA,L] // Run this rewrite rule (example: allows "[BASE_URL]/index.php?something" to be typed as "[BASE_URL]/something".  If file not found, then just go to [BASE_URL].
</IfModule>
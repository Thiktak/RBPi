<?php

/**
 * @author Olivarès Georges
 * @version see _index/commons.php const::RBPI_VERSION
 * @link https://github.com/Thiktak/RBPi
 */

/**
 * Installation
 * ============
 *   Add files into `/` server directory (/var/www for example)
 *     - /index.php
 *     - /_index/
 *
 *    Apache
 *    ------
 *      Edit `httpd.conf` or any `.htaccess`
 *        ``DirectoryIndex index.php index.html /index.php``
 *
 *    Lighttpd 
 *    --------
 *      Edit `nginx.conf`
 *        ``index-file.names += ( "index.php", "index.php", "/index.php")``
 *
 *    Ngnix
 *    ------
 *      Edit `nginx.conf`
 *        ``index  index.php index.html /index.php``
 *
 * Personalize files & directories
 * ===============================
 *   Create optional files to persolnalize files and directories
 *   Into your directory create `.options` file
 *
 */

include dirname(__FILE__) . '/_index/commons.php';

if( trim(str_ireplace('index.php', '', $_SERVER['REQUEST_URI']), '/') )
{
    include BASEDIR_INDEX . 'dir.php';
    exit();
}

define('DISPLAY_HTML', false);
define('DISPLAY_UP', false);

?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>rb(&pi;)</title>
    <meta name="author" content="Olivarès Georges" />
    <link rel="stylesheet" href="/_index/style.css">
  </head>
  <body class="index">
    <a data-scroll-to="content" href="#content">
      <div id="rbpi">
        <header id="header" role="header">
          <hgroup>
            <h1>rb<span class="ppi">(<span class="pi">&pi;</span>)</span></h1>
          </hgroup>
        </header>
      </div>
    </a>
    <aside id="nav">
    <!--
      <ul>
        <li><a href="#">twitter</a></li>
        <li><a href="#">raspcontrol</a></li>
      </ul>
    -->
    </aside>
    <div id="content">
      <section class="content">
        <a id="scroll-up" data-scroll-to="rbpi" href="#rbpi">&#9650;</a>
<?php include BASEDIR_INDEX . 'dir.php'; ?>
      </section>
    </div>
    <footer id="footer" role="footer">
      &copy; Olivarès Georges - rb(&pi;) v<?php echo RBPI_VERSION; ?> - PHP <?php echo phpversion(); ?>
    </footer>
    <script src="_index/jquery.min.js"></script>
    <script src="_index/jquery.scrollTo.min.js"></script>
    <script>
      function goTo(_where) { $.scrollTo(_where, 2000); }

      $('a[data-scroll-to]').on('click', function(e) {
          goTo($(this).attr('href'));
          e.preventDefault();
      });
      $(window).bind('keypress', function(e) {
          if (e.which == 32) {
              goTo('#content');
              e.preventDefault();
          }
      });
    </script>
  </body>
</html>
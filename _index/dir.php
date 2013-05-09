<?php

include_once dirname(__FILE__) . '/commons.php';

if( !defined('DISPLAY_HTML') )
  define('DISPLAY_HTML', true);

if( !defined('DISPLAY_UP') )
  define('DISPLAY_UP', true);

$baseDir = dirname($_SERVER['SCRIPT_FILENAME']);
$displayDir = preg_replace('`^(' . BASEDIR . ')`sUi', DIRECTORY_SEPARATOR, $baseDir);
$displayDir = preg_replace('`/{1,}`', DIRECTORY_SEPARATOR, $displayDir);

$dirToExplore = trim($_SERVER['REQUEST_URI'], '/');

if( DISPLAY_HTML ): ?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>rp(&pi;) - <?php echo $displayDir; ?></title>
    <meta name="author" content="Olivarès Georges" />
    <link rel="stylesheet" href="<?php echo BASEDIR_RBPI; ?>/_index/style.css">
  </head>
  <body class="directory">
    <div id="content">
      <div class="content">
        <div id="background"></div>
<?php endif; ?>

      <h1>
        <span class="pi">Index of</span>
        <ul class="ariane">
          <li><a href="<?php echo DIRECTORY_SEPARATOR; ?>" class="pi">rb(&pi;)</a></li>
        <?php $dirs = array(null); foreach( explode(DIRECTORY_SEPARATOR, trim($dirToExplore, DIRECTORY_SEPARATOR)) as $dir ): if( empty($dir) ) continue; $dirs[] = $dir; ?>
          <li><a href="<?php echo implode(DIRECTORY_SEPARATOR, $dirs); ?>" class="ppi"><?php echo $dir; ?></a></li>
        <?php endforeach; ?>
        </ul>
      </h1>

      <table class="files">
        <thead>
          <tr>
            <th>&nbsp;</th>
            <th>Name</th>
            <th>Last modified</th>
            <th>Size</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach( list_files(ROOT_RBPI . $dirToExplore, true, true) as $href => $dir ):
          if( !DISPLAY_UP && in_array($href, array('/.', '/..'))) continue;
        ?>
          <tr>
            <td class="icon">
              <img src="<?php echo $dir['icon']; ?>" alt="[DIR] <?php echo $dir['icon']; ?>" />
            </td>
            <td>
              <a href="<?php echo trim($href, DIRECTORY_SEPARATOR); ?>"><?php echo $dir['name']; ?></a>
            </td>
            <td>
              <?php echo date(trim(DATE_RFC1036, ' O')); ?>
            </td>
            <td>
              <?php if( $dir['size'] ): ?>
              <?php echo $dir['size']; ?> <span class="ppi">o</span>
              <?php else: ?>
              <span class="pi">-</span>
              <?php endif; ?>
            </td>
            <td>
              <?php echo $dir['description']; ?>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>

      <?php echo $_SERVER['SERVER_SIGNATURE']; ?>

<?php if( DISPLAY_HTML ): ?>
      </div>
    </div>
  </body>
</html><?php endif; ?>
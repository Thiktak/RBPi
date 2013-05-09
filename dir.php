<?php

include_once dirname(__FILE__) . '/commons.php';
use \Michelf\Markdown; // dependencies Markdown



if( !defined('DISPLAY_HTML') )
  define('DISPLAY_HTML', true);

if( !defined('DISPLAY_UP') )
  define('DISPLAY_UP', true);

$baseDir = dirname($_SERVER['SCRIPT_FILENAME']);
$displayDir = preg_replace('`^(' . BASEDIR . ')`sUi', DIRECTORY_SEPARATOR, $baseDir);
$displayDir = preg_replace('`/{1,}`', DIRECTORY_SEPARATOR, $displayDir);

$dirToExplore = trim($_SERVER['REQUEST_URI'], '/');

$tabIndex = 1;

$ariane = explode(DIRECTORY_SEPARATOR, trim($dirToExplore, DIRECTORY_SEPARATOR));
$ariane = array_merge(array('/' => 'rb(&pi;)'), array_combine($ariane, $ariane));

if( DISPLAY_HTML ): ?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>rp(&pi;) - <?php echo $displayDir; ?></title>
    <meta name="author" content="Olivarès Georges" />
    <link rel="stylesheet" href="<?php echo BASEDIR_RBPI; ?>/web/style.css">
  </head>
  <body class="directory">
    <div>
      <div class="content">
        <div id="background"></div>
<?php endif; ?>

      <h1>
        <span class="pi">Index of</span>
        <ul class="ariane">
        <?php $dirs = array(); $i = 0; foreach( $ariane as $path => $dir ): if( empty($dir) ) continue; $dirs[] = $path; $i++; ?>
          <li><a data-id="<?php echo $i > 1 ? $dir : null; ?>" href="<?php echo DIRECTORY_SEPARATOR . trim(implode(DIRECTORY_SEPARATOR, $dirs), DIRECTORY_SEPARATOR); ?>" class="<?php echo $i == 1 ? 'pi' : 'ppi'; ?><?php echo $i == count($ariane) - 1 ? ' prev' : null; ?>"><?php echo $dir; ?></a></li>
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
          <tr tabindex="<?php echo $tabIndex++; ?>">
            <td class="icon">
              <img src="<?php echo $dir['icon']; ?>" alt="[DIR] <?php echo $dir['icon']; ?>" />
            </td>
            <td>
              <a tabindex="-1" id="<?php echo urlencode($dir['name']); ?>" href="<?php echo trim($href, DIRECTORY_SEPARATOR); ?>" class="link"><?php echo $dir['name']; ?></a>
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

      <?php if( file_exists($f = ROOT_RBPI . $dirToExplore . DIRECTORY_SEPARATOR . 'readme.md') ): ?>
      <div class="md">
        <?php echo Markdown::defaultTransform(file_get_contents($f)); ?>
      </div>
      <?php endif; ?>

      <?php echo $_SERVER['SERVER_SIGNATURE']; ?>

<?php if( DISPLAY_HTML ): ?>
      </div>
    </div>
    <script src="<?php echo BASEDIR_RBPI; ?>/web/jquery.min.js"></script>
    <script src="<?php echo BASEDIR_RBPI; ?>/web/jquery.scrollTo.min.js"></script>
    <script src="<?php echo BASEDIR_RBPI; ?>/web/scripts.js"></script>
  </body>
</html><?php endif; ?>
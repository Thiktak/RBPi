<?php

// error_reporting(E_ALL); ini_set('display_errors', 1);

/**************************************************
 *   Defines                                      *
 **************************************************/

define('RBPI_VERSION', '0.0.2');

define('BASEDIR_INDEX', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('BASEDIR', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('DIR_INDEX', str_replace(BASEDIR, null, realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR));
define('BASEDIR_RBPI', str_replace($_SERVER['DOCUMENT_ROOT'], null, BASEDIR));
define('ROOT_RBPI', $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR);


/**************************************************
 *   Vendors                                      *
 **************************************************/

include_once BASEDIR . '/lib/markdown/Michelf/Markdown.php';

# Get Markdown class
use \Michelf\Markdown;


/**************************************************
 *   Functions                                    *
 **************************************************/

function list_files($dir = '.', $listFile = true, $listDir = true)
{
    $directories = array();

    foreach( scandir($dir) as $file )
    {
        $_file = $dir . DIRECTORY_SEPARATOR . $file;

        if( $file == '.option' || preg_match('`^\.[A-Za-z]+$`', $file) || $file == 'index.php' )
            continue;

        if( !$listFile AND !is_file($_file) )
            continue;

        if( !$listDir AND !is_dir($_file) )
            continue;

        $options = array(
          'name' => $file,
          'icon' => is_file($_file) ? 'file' : 'dir',
          'hidden' => false,
          'size' => 0,
          'description' => null
        );

        if( file_exists($iniFile = $_file . DIRECTORY_SEPARATOR . '.options') )
          $options = array_merge($options, (array) parse_ini_file($iniFile));

        if( $options['hidden'] )
            continue;

        if( !file_exists($options['icon']) )
        {
            if( file_exists($f = $file . '/' . $options['icon'] . '.png') ) $options['icon'] = $f;
            else if( file_exists($f = $file . '/' . $options['icon']) ) $options['icon'] = $f;
            else if( file_exists(ROOT_RBPI . ($f = BASEDIR_RBPI . DIR_INDEX . '/web/' . $options['icon'] . '.png')) ) $options['icon'] = $f;
            else if( file_exists(ROOT_RBPI . ($f = BASEDIR_RBPI . DIR_INDEX . '/web/' . $options['icon'])) ) $options['icon'] = $f;
        }

        if( is_file($_file) )
            $options['size'] = @filesize($_file);

        $directories[(is_dir($_file) ? DIRECTORY_SEPARATOR : null) . $file] = $options;
    }

    ksort($directories);

    return $directories;
}

function is_index()
{
    // directory
    $dir = dirname($_SERVER['SCRIPT_NAME']);

    // clean
    $dir = trim($dir, '/\\');
    
    return !empty($dir);
}

?>
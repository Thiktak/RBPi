<?php

// error_reporting(E_ALL); ini_set('display_errors', 1);

/**************************************************
 *   Defines                                      *
 **************************************************/

define('RBPI_VERSION', '0.1.0');

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

Class RBPiFiles
{
    static $options = array();

    public static function extractOptions($file, $force = false)
    {
        if( !$force && isset(self::$options[$file]) )
            return self::$options[$file];

        if( !file_exists($file) )
            return;

        // default
        self::$options[$file]['name'] = pathinfo($file, PATHINFO_BASENAME);
        self::$options[$file]['modified'] = @filemtime($file);
        self::$options[$file]['size'] = is_file($file) ? @filesize($file) : null;

        if( !isset(self::$options[$file]['icon']) )        self::$options[$file]['icon'] = is_file($file) ? 'file' : 'dir';
        if( !isset(self::$options[$file]['hidden']) )      self::$options[$file]['hidden'] = false;
        if( !isset(self::$options[$file]['description']) ) self::$options[$file]['description'] = null;
        
        // Parse .options (ini) file
        if( is_dir($file) &&  file_exists($iniFile = $file . DIRECTORY_SEPARATOR . '.options') )
        {
            $ini = parse_ini_file($iniFile, true);

            foreach( $ini as $key => $value )
            {
                if( is_array($value) )
                {
                    foreach( $value as $key2 => $value2 )
                    {
                        self::$options[$file . DIRECTORY_SEPARATOR . $key][$key2] = $value2;
                    }
                }
                else
                {
                    self::$options[$file][$key] = $value;
                }
            }
        }

    }

    public static function getOptions($file)
    {

        if( !file_exists($file) )
            return;

        $dirs = array();
        foreach( explode(DIRECTORY_SEPARATOR, is_file($file) ? dirname($file) : realpath($file)) as $dir ) {
            $dirs[] = $dir;
            self::extractOptions(implode(DIRECTORY_SEPARATOR, $dirs));
        }

        if( is_file($file) )
            self::extractOptions($file, true);
        else if( in_array($name = substr(strrchr($file, DIRECTORY_SEPARATOR), 1), array('.', '..')) ) {
            $file = realpath($file);
            return array('name' => $name) + (isset(self::$options[$file]) ? self::$options[$file] : array());
        }
        else
            $file = realpath($file);

        return isset(self::$options[$file]) ? self::$options[$file] : array();
    }

    public static function getList($dir = '.', $listFile = true, $listDir = true)
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

            $options = self::getOptions($_file);
            if( !$options || $options['hidden'] )
                continue;

            if( !file_exists($options['icon']) )
            {
                if( file_exists($f = $file . '/' . $options['icon'] . '.png') ) $options['icon'] = $f;
                else if( file_exists($f = $file . '/' . $options['icon']) ) $options['icon'] = $f;
                else if( file_exists(ROOT_RBPI . ($f = BASEDIR_RBPI . DIR_INDEX . '/web/' . $options['icon'] . '.png')) ) $options['icon'] = $f;
                else if( file_exists(ROOT_RBPI . ($f = BASEDIR_RBPI . DIR_INDEX . '/web/' . $options['icon'])) ) $options['icon'] = $f;
                else {
                  if( file_exists(ROOT_RBPI . ($f = BASEDIR_RBPI . DIR_INDEX . '/web/' . (is_file($_file) ? 'file' : 'dir') . '.png')) )
                      $options['icon'] = $f;
                }
            }

            $directories[(is_dir($_file) ? DIRECTORY_SEPARATOR : null) . $file] = $options;
        }

        ksort($directories);

        return $directories;
    }
}

?>
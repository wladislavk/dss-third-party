<?php
namespace Ds3ThirdParty\elfinder\php;

error_reporting(E_ALL); // Set E_ALL for debuging


if (function_exists('date_default_timezone_set')) {
	date_default_timezone_set('Europe/Moscow');
}

function debug($o) {
	echo '<pre>';
	print_r($o);
}


/**
 * Simple logger function.
 * Demonstrate how to work with elFinder event api.
 *
 * @param  string   $cmd       command name
 * @param  array    $result    command result
 * @param  array    $args      command arguments from client
 * @param  elFinder $elfinder  elFinder instance
 * @return void|true
 * @author Dmitry (dio) Levashov
 **/
function logger($cmd, $result, $args, $elfinder) {
	$logfile = '../files/temp/log.txt';

	$dir = dirname($logfile);
	if (!is_dir($dir) && !mkdir($dir)) {
		return;
	}
	
	$log = $cmd.' ['.date('d.m H:s')."]\n";
	
	if (!empty($result['error'])) {
		$log .= "\tERROR: ".implode(' ', $result['error'])."\n";
	}
	
	if (!empty($result['warning'])) {
		$log .= "\tWARNING: ".implode(' ', $result['warning'])."\n";
	}
	
	if (!empty($result['removed'])) {
		foreach ($result['removed'] as $file) {
			// removed file contain additional field "realpath"
			$log .= "\tREMOVED: ".$file['realpath']."\n";
		}
	}
	
	if (!empty($result['added'])) {
		foreach ($result['added'] as $file) {
			$log .= "\tADDED: ".$elfinder->realpath($file['hash'])."\n";
		}
	}
	
	if (!empty($result['changed'])) {
		foreach ($result['changed'] as $file) {
			$log .= "\tCHANGED: ".$elfinder->realpath($file['hash'])."\n";
		}
	}
	
	if (($fp = fopen($logfile, 'a'))) {
		fwrite($fp, $log."\n");
		fclose($fp);
	}
}


/**
 * Simple logger function.
 * Demonstrate how to work with elFinder event api.
 *
 * @package elFinder
 * @author Dmitry (dio) Levashov
 **/
class elFinderSimpleLogger {
	
	/**
	 * Log file path
	 *
	 * @var string
	 **/
	protected $file = '';
	
	/**
	 * constructor
	 *
	 * @return void
	 * @author Dmitry (dio) Levashov
	 **/
	public function __construct($path) {
		$this->file = $path;
		$dir = dirname($path);
		if (!is_dir($dir)) {
			mkdir($dir);
		}
	}
	
	/**
	 * Create log record
	 *
	 * @param  string   $cmd       command name
	 * @param  array    $result    command result
	 * @param  array    $args      command arguments from client
	 * @param  elFinder $elfinder  elFinder instance
	 * @return void|true
	 * @author Dmitry (dio) Levashov
	 **/
	public function log($cmd, $result, $args, $elfinder) {
		$log = $cmd.' ['.date('d.m H:s')."]\n";
		
		if (!empty($result['error'])) {
			$log .= "\tERROR: ".implode(' ', $result['error'])."\n";
		}
		
		if (!empty($result['warning'])) {
			$log .= "\tWARNING: ".implode(' ', $result['warning'])."\n";
		}
		
		if (!empty($result['removed'])) {
			foreach ($result['removed'] as $file) {
				// removed file contain additional field "realpath"
				$log .= "\tREMOVED: ".$file['realpath']."\n";
			}
		}
		
		if (!empty($result['added'])) {
			foreach ($result['added'] as $file) {
				$log .= "\tADDED: ".$elfinder->realpath($file['hash'])."\n";
			}
		}
		
		if (!empty($result['changed'])) {
			foreach ($result['changed'] as $file) {
				$log .= "\tCHANGED: ".$elfinder->realpath($file['hash'])."\n";
			}
		}
		
		$this->write($log);
	}
	
	/**
	 * Write log into file
	 *
	 * @param  string  $log  log record
	 * @return void
	 * @author Dmitry (dio) Levashov
	 **/
	protected function write($log) {
		
		if (($fp = @fopen($this->file, 'a'))) {
			fwrite($fp, $log."\n");
			fclose($fp);
		}
	}
	
	
} // END class 


/**
 * Simple function to demonstrate how to control file access using "accessControl" callback.
 *
 * @param  string  $attr  attribute name (read|write|locked|hidden)
 * @param  string  $path  file path. Attention! This is path relative to volume root directory started with directory separator.
 * @return bool
 * @author Dmitry (dio) Levashov
 **/
function access($attr, $path, $data, $volume) {
	return strpos(basename($path), '.') === 0
		? !($attr == 'read' || $attr == 'write')
		: $attr == 'read' || $attr == 'write';
}

/**
 * Access control example class
 *
 * @author Dmitry (dio) Levashov
 **/
class elFinderTestACL {
	
	/**
	 * make dotfiles not readable, not writable, hidden and locked
	 *
	 * @param  string  $attr  attribute name (read|write|locked|hidden)
	 * @param  string  $path  file path. Attention! This is path relative to volume root directory started with directory separator.
	 * @param  mixed   $data  data which seted in 'accessControlData' elFinder option
	 * @param  elFinderVolumeDriver  $volume  volume driver
	 * @return bool
	 * @author Dmitry (dio) Levashov
	 **/
	public function fsAccess($attr, $path, $data, $volume) {
		
		if ($volume->name() == 'localfilesystem') {
			return strpos(basename($path), '.') === 0
				? !($attr == 'read' || $attr == 'write')
				: $attr == 'read' || $attr == 'write';
		}
		
		return true;
	}
	
} // END class 

$acl = new elFinderTestACL();

function validName($name) {
	return strpos($name, '.') !== 0;
}


$logger = new elFinderSimpleLogger('../files/temp/log.txt');

$opts = array(
	'locale' => 'en_US.UTF-8',
	'bind' => array(
		'mkdir mkfile  rename duplicate upload rm paste' => array($logger, 'log'), 
	),
	'debug' => true,
	
	'roots' => array(
		
		array(
			'driver'     => 'LocalFileSystem',
			'path'       => '../files/',
			'URL'        => dirname($_SERVER['PHP_SELF']) . '/../files/',
			'alias'      => 'File system',
			'mimeDetect' => 'internal',
			'tmbPath'    => '.tmb',
			'utf8fix'    => true,
			'tmbCrop'    => false,
			'attributes' => array(
				array(
					'pattern' => '~/\.~',
					'read' => false,
					'write' => false,
					'hidden' => true,
					'locked' => false
				),
				array(
					'pattern' => '~/replace/.+png$~',
				)
			),
		),
		
		array(
			'driver'     => 'LocalFileSystem',
			'path'       => '../files2/',
			'URL'        => dirname($_SERVER['PHP_SELF']) . '/../files2/',
			'alias'      => 'Files',
			'mimeDetect' => 'internal',
			'tmbPath'    => '.tmb',
			'utf8fix'    => true,
			'attributes' => array(
				array(
					'pattern' => '~/\.~',
					'hidden' => true,
					'locked' => false
				),
			)
		),
		
		array(
			'driver' => 'MySQL',
			'path' => 1,
			// 'treeDeep' => 2,
			'socket'          => '/opt/local/var/run/mysql5/mysqld.sock',
			'user' => 'root',
			'pass' => 'hane',
			'db' => 'elfinder',
			'user_id' => 1,
			'accessControl' => 'access',
			'separator' => ':',
			'tmbCrop'         => false,
			'tmbPath' => '../files/dbtmb',
			'tmbURL' => dirname($_SERVER['PHP_SELF']) . '/../files/dbtmb/',
		)
	)
);

header('Access-Control-Allow-Origin: *');
$connector = new elFinderConnector(new elFinder($opts), true);
$connector->run();

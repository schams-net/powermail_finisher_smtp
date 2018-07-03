<?php

/*
 * This file is part of the TYPO3 CMS Extension "Powermail SMTP Finisher"
 * Extension author: Michael Schams - https://schams.net
 *
 * @package     TYPO3
 * @subpackage  powermail_finisher_smtp
 * @author      Michael Schams <schams.net>
 */

if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY);

// generate unique file name
//$logFilename = $_EXTKEY . '_' . date('Ymd') . '.' . substr(md5(mt_rand()), 0, 8) . '.log';
$logFilename = $extensionName . '_' . date('Ymd') . '.log';

// configure logging
$logging = array(
	// configuration for ERROR level log entries
	\TYPO3\CMS\Core\Log\LogLevel::INFO => array(
		// add a FileWriter
		'TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter' => array(
			// configuration for the writer
			'logFile' => 'typo3temp/var/logs/' . $logFilename
		)
	)
);

$GLOBALS['TYPO3_CONF_VARS']['LOG']['SchamsNet']['PowermailFinisherSmtp']['Finisher']['writerConfiguration'] = $logging;

unset($logging);

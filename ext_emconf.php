<?php

/*
 * This file is part of the TYPO3 CMS Extension "Powermail SMTP Finisher"
 * Extension author: Michael Schams - https://schams.net
 *
 * @package     TYPO3
 * @subpackage  powermail_finisher_smtp
 * @author      Michael Schams <schams.net>
 */

$EM_CONF[$_EXTKEY] = [
    'title' => 'Powermail SMTP Finisher',
    'description' => 'Use specific SMTP servers for each powermail form.',
    'category' => 'backend',
    'author' => 'Michael Schams',
    'author_email' => '',
    'author_company' => 'schams.net',
    'state' => 'beta',
    'uploadfolder' => false,
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '7.6.0-8.9.99',
            'powermail' => '6.0.0-6.999.999'
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ],
    ],
];

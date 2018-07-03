<?php
namespace SchamsNet\PowermailFinisherSmtp\Finisher;

/*
 * This file is part of the TYPO3 CMS Extension "Powermail SMTP Finisher"
 * Extension author: Michael Schams - https://schams.net
 *
 * @package     TYPO3
 * @subpackage  powermail_finisher_smtp
 * @author      Michael Schams <schams.net>
 */

use In2code\Powermail\Domain\Model\Mail;
use In2code\Powermail\Finisher\AbstractFinisher;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * SMTP Finisher class
 */
class SmtpFinisher extends AbstractFinisher
{
	/**
	 * @access protected
	 * @var TYPO3\CMS\Core\Log\LogManager
	 */
	protected $logger;

	/**
	 * @access protected
	 * @var In2code\Powermail\Domain\Model\Mail
	 */
	protected $mail;

	/**
	 * @access protected
	 * @var array
	 */
	protected $configuration;

	/**
	 * @access protected
	 * @var array
	 */
	protected $settings;

	/**
	 * Constructor
	 *
	 * @access public
	 * @param In2code\Powermail\Domain\Model\Mail $mail
	 * @param array $configuration
	 * @param array $settings
	 * @param @TODO
	 * @param @TODO
	 * @param @TODO
	 * @param TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer $contentObject
	 * @return
	 */
	public function __construct(Mail $mail, array $configuration, array $settings, $formSubmitted, $actionMethodName, ContentObjectRenderer $contentObject)
	{
		$this->logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
		parent::__construct($mail, $configuration, $settings, $formSubmitted, $actionMethodName, $contentObject);
	}

	/**
	 * Initialize Finisher
	 *
	 * @access public
	 * @return void
	 */
	public function initializeFinisher()
	{
		$this->logger->info(preg_replace('/^[^:]*::(.*)$/', '\1', __METHOD__) . ':' . __LINE__);
	}

	/**
	 * Initialize custom Finisher
	 *
	 * @access public
	 * @return void
	 */
	public function initializeSmtpFinisher()
	{
		$this->logger->info(preg_replace('/^[^:]*::(.*)$/', '\1', __METHOD__) . ':' . __LINE__);
	}

	/**
	 * SMTP Finisher
	 *
	 * @access public
	 * @return void
	 */
	public function smtpFinisher()
	{
		$this->logger->info(preg_replace('/^[^:]*::(.*)$/', '\1', __METHOD__) . ':' . __LINE__);

		// Override default mail transport settings
		$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport'] = 'smtp';

		if (isset($this->configuration['smtp']['host'])) {
			$this->logger->info('SMTP host: ' . $this->configuration['smtp']['host']);
			$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_server'] = $this->configuration['smtp']['host'];
		}
		if (isset($this->configuration['smtp']['user'])) {
			$this->logger->info('SMTP user name: ' . $this->configuration['smtp']['user']);
			$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_username'] = $this->configuration['smtp']['user'];
		}
		if (isset($this->configuration['smtp']['password'])) {
			$this->logger->info('SMTP password: ' . $this->configuration['smtp']['password']);
			$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_password'] = $this->configuration['smtp']['password'];
		}

		$mail = GeneralUtility::makeInstance(MailMessage::class);
		$mail->setSubject($this->getSubject());
		$mail->setFrom([$this->getSenderMail() => $this->getSenderName()]);
		$mail->setTo([$this->getReceiverMail()]);
		$mail->setBody($this->getBody());

		try {
			$mail->send();
		}
		catch (\Swift_TransportException $e) {
			// ...
			$message = GeneralUtility::makeInstance(
				FlashMessage::class,
				$e->getMessage(),
				'Error',
				FlashMessage::ERROR,
				true
			);
		}
	}

	/**
	 * Returns sender name
	 *
	 * @access private
	 * @return string
	 */
	private function getSenderName()
	{
		return $this->getMail()->getSenderName();
	}

	/**
	 * Returns sender email address
	 *
	 * @access private
	 * @return string
	 */
	private function getSenderAddress()
	{
		return $this->getMail()->getSenderMail();
	}

	/**
	 * Returns mail subject
	 *
	 * @access private
	 * @return string
	 */
	private function getSubject()
	{
		return $this->getMail()->getSubject();
	}

	/**
	 * Returns recipient email address
	 *
	 * @access private
	 * @return string
	 */
	private function getRecipientAddress()
	{
		return $this->getMail()->getReceiverMail();
	}

	/**
	 * Returns mail body
	 *
	 * @access private
	 * @return string
	 */
	private function getBody()
	{
		return $this->getMail()->getBody();
	}

	/**
	 * Returns user agent string
	 *
	 * @access private
	 * @return string
	 */
	private function getUserAgent()
	{
		return $this->getMail()->getUserAgent();
	}

	/**
	 * Returns spam factor
	 *
	 * @access private
	 * @return string
	 */
	private function getSpamFactor()
	{
		return $this->getMail()->getSpamFactor();
	}
}

<?php
namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
//
//	/**
//	 * @var string
//	 */
//	public $fromEmail;
//
//	/**
//	 * @var string
//	 */
//	public $fromName;
//
//	/**
//	 * @var string
//	 */
//	public $recipients;
//
//	/**
//	 * The "user agent"
//	 *
//	 * @var string
//	 */
//	public $userAgent = 'CodeIgniter';
//
//	/**
//	 * The mail sending protocol: mail, sendmail, smtp
//	 *
//	 * @var string
//	 */
//	public $protocol = 'mail';
//
//	/**
//	 * The server path to Sendmail.
//	 *
//	 * @var string
//	 */
//	public $mailPath = '/usr/sbin/sendmail';
//
//	/**
//	 * SMTP Server Address
//	 *
//	 * @var string
//	 */
//	public $SMTPHost;
//
//	/**
//	 * SMTP Username
//	 *
//	 * @var string
//	 */
//	public $SMTPUser;
//
//	/**
//	 * SMTP Password
//	 *
//	 * @var string
//	 */
//	public $SMTPPass;
//
//	/**
//	 * SMTP Port
//	 *
//	 * @var integer
//	 */
//	public $SMTPPort = 25;
//
//	/**
//	 * SMTP Timeout (in seconds)
//	 *
//	 * @var integer
//	 */
//	public $SMTPTimeout = 5;
//
//	/**
//	 * Enable persistent SMTP connections
//	 *
//	 * @var boolean
//	 */
//	public $SMTPKeepAlive = false;
//
//	/**
//	 * SMTP Encryption. Either tls or ssl
//	 *
//	 * @var string
//	 */
//	public $SMTPCrypto = 'tls';
//
//	/**
//	 * Enable word-wrap
//	 *
//	 * @var boolean
//	 */
//	public $wordWrap = true;
//
//	/**
//	 * Character count to wrap at
//	 *
//	 * @var integer
//	 */
//	public $wrapChars = 76;
//
//	/**
//	 * Type of mail, either 'text' or 'html'
//	 *
//	 * @var string
//	 */
//	public $mailType = 'text';
//
//	/**
//	 * Character set (utf-8, iso-8859-1, etc.)
//	 *
//	 * @var string
//	 */
//	public $charset = 'UTF-8';
//
//	/**
//	 * Whether to validate the email address
//	 *
//	 * @var boolean
//	 */
//	public $validate = false;
//
//	/**
//	 * Email Priority. 1 = highest. 5 = lowest. 3 = normal
//	 *
//	 * @var integer
//	 */
//	public $priority = 3;
//
//	/**
//	 * Newline character. (Use “\r\n” to comply with RFC 822)
//	 *
//	 * @var string
//	 */
//	public $CRLF = "\r\n";
//
//	/**
//	 * Newline character. (Use “\r\n” to comply with RFC 822)
//	 *
//	 * @var string
//	 */
//	public $newline = "\r\n";
//
//	/**
//	 * Enable BCC Batch Mode.
//	 *
//	 * @var boolean
//	 */
//	public $BCCBatchMode = false;
//
//	/**
//	 * Number of emails in each BCC batch
//	 *
//	 * @var integer
//	 */
//	public $BCCBatchSize = 200;
//
//	/**
//	 * Enable notify message from server
//	 *
//	 * @var boolean
//	 */
//	public $DSN = false;

//  PARAMETRI GMAIL
    
	public $fromEmail = 'your@gmail.com';
	public $fromName = 'yourname';
	public $recipients;
	public $userAgent = 'CodeIgniter';
	public $protocol = 'smtp';
	public $mailPath = '/usr/sbin/sendmail';
	public $SMTPHost = 'smtp.googlemail.com';
	public $SMTPUser = 'your@gmail.com';
	public $SMTPPass = 'password';
	public $SMTPPort = 465;
	public $SMTPTimeout = 5;
	public $SMTPKeepAlive = false;
	public $SMTPCrypto = 'ssl';
	public $wordWrap = true;
	public $wrapChars = 76;
	public $mailType = 'text';
	public $charset = 'UTF-8';
	public $validate = false;
	public $priority = 3;
	public $CRLF = "\r\n";
	public $newline = "\r\n";
	public $BCCBatchMode = false;
	public $BCCBatchSize = 200;
	public $DSN = false;        
}

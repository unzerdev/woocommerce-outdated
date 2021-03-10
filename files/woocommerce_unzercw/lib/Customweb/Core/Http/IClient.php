<?php 
/**
  * You are allowed to use this API in your web application.
 *
 * Copyright (C) 2018 by customweb GmbH
 *
 * This program is licenced under the customweb software licence. With the
 * purchase or the installation of the software in your application you
 * accept the licence agreement. The allowed usage is outlined in the
 * customweb software licence which can be found under
 * http://www.sellxed.com/en/software-license-agreement
 *
 * Any modification or distribution is strictly forbidden. The license
 * grants you the installation in one application. For multiuse you will need
 * to purchase further licences at http://www.sellxed.com/shop.
 *
 * See the customweb software licence agreement for more details.
 *
 */



/**
 * This interface defines a HTTP client. 
 * 
 * A HTTP client can be used to send a HTTP request object
 * to a remote server.
 * 
 * @author Thomas Hunziker
 *
 */
interface Customweb_Core_Http_IClient {
	/**
	 * @deprecated as of june 2015
	 * @var string
	 */
	const SSL_VERSION_SSLV2 = 'sslv2';
	/**
	 * @deprecated as of june 2015
	 * @var string
	 */
	const SSL_VERSION_SSLV3 = 'sslv3';
	/**
	 * @deprecated as of march 2020
	 * @var string
	 */
	const SSL_VERSION_TLSV1 = 'tlsv1';
	/**
	 * @deprecated as of march 2020
	 * @var string
	 */
	const SSL_VERSION_TLSV11 = 'tlsv11';
	const SSL_VERSION_TLSV12 = 'tlsv12';
	const SSL_VERSION_TLSV13 = 'tlsv13';
	
	const ENVIRONMENT_VARIABLE_SSL_VERSION = 'PHP_FORCE_SSL_VERSION';
	
	const ENVIRONMENT_VARIABLE_PROXY_URL = 'PHP_HTTP_CLIENT_PROXY_URL';
	const ENVIRONMENT_VARIABLE_PROXY_URL_LEGACY = 'PHP_STREAM_PROXY_SERVER';
	
	const IP_ADDRESS_VERSION_V4 = 'IPv4';
	
	const IP_ADDRESS_VERSION_V6 = 'IPv6';
	
	const ENVIRONMENT_VARIABLE_IP_ADDRESS_VERSION = 'PHP_FORCE_IP_ADDRESS_VERSION';
	
	/**
	 * This method sends a HTTP request synchronously. 
	 * 
	 * @param Customweb_Core_Http_IRequest $request
	 * @return Customweb_Core_Http_IResponse
	 */
	public function send(Customweb_Core_Http_IRequest $request);
	
	/**
	 * This method sends a HTTP request asynchronously to the 
	 * remote host. Because it is asynchrone no response will be 
	 * returned.
	 * 
	 * Since the message is sent asynchronously the client will not follow any 
	 * header redirections. So setRedirectionFollowLimit() has no effect.
	 * 
	 * @param Customweb_Core_Http_IRequest $request
	 * @return void
	 */
	public function sendAsynchronous(Customweb_Core_Http_IRequest $request);

	/**
	 * Returns an input stream for the certificate authority file.
	 * 
	 * @return Customweb_Core_Stream_IInput
	 */
	public function getCertificateAuthority();
	
	/**
	 * Sets the certificate authority file. The file must be provided as an input stream. The certificate authority 
	 * is used to verify the identity of the remote server. By setting this option the default certificate authority 
	 * file will be overridden. 
	 * 
	 * To deactivate the check please use self::disableCertificateAuthorityCheck()
	 * 
	 * @param Customweb_Core_Stream_IInput $certificateAuthorityInputStream
	 * @return Customweb_Core_Http_IClient
	 */
	public function setCertificateAuthority(Customweb_Core_Stream_IInput $certificateAuthorityInputStream);

	/**
	 * The number of http header redirects to follow. If it is 0 (zero), then a unlimited
	 * number of redirects are handled. If it is NULL, then no redirections are handled.
	 *
	 * The default value is NULL (no following of redirection).
	 *
	 * @return int
	 */
	public function getRedirectionFollowLimit();
	
	/**
	 * The number of http header redirects to follow. If it is 0 (zero), then a unlimited
	 * number of redirects are handled. If it is NULL, then no redirections are handled.
	 *
	 * @param int $limit The maximal number of redirects done automatically.
	 * @return Customweb_Core_Http_IClient
	*/
	public function setRedirectionFollowLimit($limit);
	
	/**
	 * Enables the check of the certificate authority. By checking 
	 * the certificate authority the whole certificate chain is checked. 
	 * the authority check prevents an attacker to use a man-in-the-middle 
	 * attack.
	 * 
	 * However the check will prevent the usage of self-signed certificates,
	 * because the root CA is not recognized.
	 * 
	 * @return Customweb_Core_Http_IClient
	 */
	public function enableCertificateAuthorityCheck();
	
	/**
	 * Disable the check of the certificate authority. See enableCertificateAuthorityCheck()
	 * for more details.
	 * 
	 * @return Customweb_Core_Http_IClient
	 */
	public function disableCertificateAuthorityCheck();
	
	/**
	 * Returns true, when the authority check is enabled. See enableCertificateAuthorityCheck() 
	 * for more details about the authority check.
	 * 
	 * @return boolean
	 */
	public function isCertificateAuthorityCheckEnabled();

	/**
	 * This method sets the client certificate from a input stream. The format of the 
	 * certificate must be PEM.
	 *
	 * @param Customweb_Core_Stream_IInput $input
	 * @return Customweb_Core_Http_IClient
	 */
	public function setClientCertificate(Customweb_Core_Stream_IInput $input);
	
	/**
	 * Returns the input stream of the client certificate.
	 *
	 * @return Customweb_Core_Stream_IInput
	 */
	public function getClientCertificate();
	
	/**
	 * Sets the client certificate passphrase.
	 * 
	 * @param string $password
	 * @return Customweb_Core_Http_IClient
	 */
	public function setClientCertificatePassphrase($passphrase);

	/**
	 * Returns the client certificate passphrase.
	 *
	 * @return string
	 */
	public function getClientCertificatePassphrase();
	
	/**
	 * Returns the connection timeout. 
	 * 
	 * @return int
	 */
	public function getConnectionTimeout();
	
	/**
	 * This method sets the connection timeout in seconds. 
	 *
	 * @param int $timeout
	 * @return Customweb_Core_Http_IClient
	 */
	public function setConnectionTimeout($timeout);
	
	/**
	 * With this method a certain SSL version can be forced. Some servers are not
	 * able to negotiate a working SSL version. This method allows to force one of 
	 * them.
	 * 
	 * The SSL version can be also forced by setting the environment variable 
	 * 'PHP_STREAM_SSL_VERSION'. 
	 * 
	 * In Apache this can be set in the virutal host configuration or in the
	 * .htaccess file by using:
	 * <code>
	 * SetEnv PHP_FORCE_SSL_VERSION {version}
	 * </code>
	 * 
	 * {version} must be replaced by the one of the following:
	 * sslv2, sslv3, tlsv1, tlsv11, tlsv12
	 * 
	 * The same values are also accepted by this method.
	 * 
	 * @param string $version
	 * @return Customweb_Core_Http_IClient
	 */
	public function setForcedSslVersion($version);
	
	/**
	 * Returns the forced SSL version. If non is forced the method returns null.
	 * 
	 * @return string Forced SSL version.
	 */
	public function getForcedSslVersion();
	
	/**
	 * Sets the Internet Protocol (IP) address version. For some servers is required
	 * that only IPv6 or IPv4 works. This method allows to force one version.
	 * 
	 * This can be done also over the environment variable 'PHP_FORCE_IP_ADDRESS_VERSION'. 
	 * Sample Apache vHost configuration:
	 * <code>
	 * SetEnv PHP_FORCE_IP_ADDRESS_VERSION {version} # Either IPv6 or IPv4
	 * </code>
	 * 
	 * The tag '{version}' has to be replaced with either 'IPv6' or 'IPv4'.
	 * 
	 * This method accepts also either 'IPv6' or 'IPv4'.
	 * 
	 * @param string $version
	 * @return Customweb_Core_Http_IClient
	 */
	public function setForcedInternetProtocolAddressVersion($version);
	
	/**
	 * Returns the forced Internet Protocol (IP) address version.
	 * 
	 * @return string
	 */
	public function getForcedInternetProtocolAddressVersion();
	
	/**
	 * Sets the proxy URL to be used. The proxy URL allows the routing of the 
	 * request over a proxy.
	 * 
	 * The proxy URL can be also set over an environment variable. For Apache this 
	 * can be done in the virtual host confirguration or in a .htaccess file in the 
	 * following way:
	 * <code>
	 * SetEnv PHP_HTTP_CLIENT_PROXY_URL {url}
	 * </code>
	 * 
	 * The {url} must be replaced with a valid URL string. It can include a user name
	 * and a password.
	 * 
	 * This method requires a valid Customweb_Core_Url object. The URL may contain 
	 * a user name and a password.
	 *  
	 * @param Customweb_Core_Url $url
	 * @return Customweb_Core_Http_IClient
	 */
	public function setProxyUrl(Customweb_Core_Url $url);
	
	/**
	 * Returns the configured proxy URL.
	 * 
	 * @return Customweb_Core_Url
	 */
	public function getProxyUrl();
}
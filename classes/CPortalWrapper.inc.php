<?php

/*=======================================================================================
 *																						*
 *								CPortalWrapper.inc.php									*
 *																						*
 *======================================================================================*/
 
/**
 *	{@link CPortalWrapper} definitions.
 *
 *	This file contains common definitions used by the {@link CPortalWrapper} class.
 *
 *	@package	MyWrapper
 *	@subpackage	Wrappers
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 14/12/2012
 */

/*=======================================================================================
 *	WEB-SERVICE REQUEST PARAMETERS														*
 *======================================================================================*/

/**
 * Credentials.
 *
 * This offset tags the element that holds the login credentials, the parameter must be
 * expressed as an array whose contents depend on the operation.
 *
 * Type: string.
 * Cardinality: any.
 */
define( "kAPI_CREDENTIALS",						':WS:CREDENTIALS' );

/*=======================================================================================
 *	WEB-SERVICE REQUEST ELEMENTS														*
 *======================================================================================*/

/**
 * User code.
 *
 * This offset tags the user code in the {@link kAPI_CREDENTIALS} parameter.
 *
 * Type: string.
 * Cardinality: one.
 */
define( "kAPI_CREDENTIALS_CODE",				':WS:CREDENTIALS-CODE' );

/**
 * User password.
 *
 * This offset tags the user password in the {@link kAPI_CREDENTIALS} parameter.
 *
 * Type: string.
 * Cardinality: one.
 */
define( "kAPI_CREDENTIALS_PASS",				':WS:CREDENTIALS-PASS' );

/*=======================================================================================
 *	WEB-SERVICE OPERATIONS																*
 *======================================================================================*/

/**
 * Login web-service.
 *
 * This is the tag that represents the Login web-service operation, which will return a user
 * record upon providing correct credentials in the {@link kAPI_CREDENTIALS} parameter.
 *
 * The service expects the following parameters:
 *
 * <ul>
 *	<li><i>{@link kAPI_FORMAT}</i>: This parameter is required to indicate how to encode the
 *		response.
 *	<li><i>{@link kAPI_DATABASE}</i>: This parameter is required to indicate the working
 *		database.
 *	<li><i>{@link kAPI_CONTAINER}</i>: This optional parameter is used to indicate the
 *		working container in case of a non-standard configuration.
 *	<li><i>{@link kAPI_CREDENTIALS}</i>: This parameter is required for validating the user:
 *	 <ul>
 *		<li><tt>{@link kAPI_CREDENTIALS_CODE}</tt>: User code.
 *		<li><tt>{@link kAPI_CREDENTIALS_PASS}</tt>: User password.
 *	 </ul>
 *		Note that these parameters may grow in derived classes, this represents the bare minimum.
 * </ul>
 */
define( "kAPI_OP_Login",						'WS:OP:Login' );

/**
 * Create user.
 *
 * This is the tag that represents the user creation web-service operation, which will
 * create a new user.
 *
 * The service expects the following parameters:
 *
 * <ul>
 *	<li><i>{@link kAPI_FORMAT}</i>: This parameter is required to indicate how to
 *		encode the response.
 *	<li><i>{@link kAPI_DATABASE}</i>: This parameter is required to indicate the working
 *		database.
 *	<li><i>{@link kAPI_OBJECT}</i>: This parameter is required and contains an array
 *		corresponding to the new user attributes.
 * </ul>
 */
define( "kAPI_OP_NewUser",						'WS:OP:NewUser' );


?>

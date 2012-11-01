<?php
	
/**
 * Mongo data wrapper server.
 *
 * This file contains a wrapper server using the {@link CMongoDataWrapper CMongoDataWrapper}
 * class.
 *
 * This can effectively be used as a wrapper to a MongoDB database.
 *
 *	@package	MyWrapper
 *	@subpackage	Server
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 22/12/2011
 *				2.00 23/02/2012
 */

/*=======================================================================================
 *																						*
 *								MongoDataWrapper.php									*
 *																						*
 *======================================================================================*/

/**
 * Local includes.
 *
 * This include file contains local definitions.
 */
require_once( 'local.inc.php' );

/**
 * Global includes.
 *
 * This include file contains default path definitions and an
 * {@link __autoload() autoloader} used to automatically include referenced classes in this
 * library.
 */
require_once( '/Library/WebServer/Library/PHPWrapper/includes.inc.php' );

/**
 * Session includes.
 *
 * This include file contains the definition of the session object.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CMongoContainer.php" );

/**
 * Class includes.
 *
 * This include file contains the working class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CMongoDataWrapper.php" );

/**
 * Start session.
 */
session_start();


/*=======================================================================================
 *	INIT SESSION																		*
 *======================================================================================*/
 
$_SESSION[ kAPI_SESSION_SERVER ] = new CMongoServer();


/*=======================================================================================
 *	TEST WRAPPER OBJECT																	*
 *======================================================================================*/

//
// Instantiate wrapper.
//
$wrapper = new CMongoDataWrapper();

//
// Handle request.
//
$wrapper->HandleRequest();

exit;

?>

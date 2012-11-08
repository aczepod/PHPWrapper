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
 *									MongoDataWrapper.php								*
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
 * Class includes.
 *
 * This include file contains the working class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CDataWrapper.php" );


/*=======================================================================================
 *	TEST WRAPPER OBJECT																	*
 *======================================================================================*/

//
// Instantiate wrapper.
//
$wrapper = new CDataWrapper( new CMongoServer( kDEFAULT_SERVER ) );

//
// Handle request.
//
$wrapper->HandleRequest();

exit;

?>

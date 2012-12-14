<?php
	
/**
 * Mongo portal wrapper server.
 *
 * This file contains a wrapper server using the {@link CPortalWrapper} class implemented
 * through a MongoDB server.
 *
 * This can effectively be used as a wrapper to a MongoDB based portal.
 *
 *	@package	MyWrapper
 *	@subpackage	Server
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 14/12/2012
 */

/*=======================================================================================
 *																						*
 *									MongoPortalWrapper.php								*
 *																						*
 *======================================================================================*/

/**
 * Global includes.
 *
 * This include file contains default path definitions and an
 * {@link __autoload() autoloader} used to automatically include referenced classes in this
 * library.
 */
require_once( 'includes.inc.php' );

/**
 * Local includes.
 *
 * This include file contains local definitions.
 */
require_once( 'local.inc.php' );

/**
 * Class includes.
 *
 * This include file contains the working class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CPortalWrapper.php" );


/*=======================================================================================
 *	TEST WRAPPER OBJECT																	*
 *======================================================================================*/

//
// Instantiate wrapper.
//
$wrapper = new CPortalWrapper( new CMongoServer( kDEFAULT_SERVER ) );

//
// Handle request.
//
$wrapper->HandleRequest();

exit;

?>

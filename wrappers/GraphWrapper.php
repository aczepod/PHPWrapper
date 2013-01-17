<?php
	
/**
 * Wrapper server.
 *
 * This file contains a wrapper server using the {@link COntologyWrapper} class and
 * implementing a Mongo database and a Neo4j graph.
 *
 *	@package	MyWrapper
 *	@subpackage	Server
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 22/11/2012
 *				2.00 14/12/2012
 */

/*=======================================================================================
 *																						*
 *										Wrapper.php										*
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
 *	INSTANTIATE CLIENT OBJECTS															*
 *======================================================================================*/

//
// Instantiate Neo4j graph.
//
$tmp = explode( ':', kDEFAULT_GRAPH );
$graph = new CNeo4jGraph( $tmp[ 0 ], $tmp[ 1 ] );

/*=======================================================================================
 *	INSTANTIATE SERVER OBJECT															*
 *======================================================================================*/

//
// Instantiate Mongo server.
//
$server = new CMongoServer( kDEFAULT_SERVER );

//
// Connect to Neo4j.
//
$server->Graph( $graph );

/*=======================================================================================
 *	INSTANTIATE WRAPPER OBJECT															*
 *======================================================================================*/

//
// Instantiate wrapper.
//
$wrapper = new CPortalWrapper( $server );

//
// Handle request.
//
$wrapper->HandleRequest();

exit;

?>

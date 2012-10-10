<?php

/**
 * Test ontology suite.
 *
 * This file contains routines to create a test ontology.
 *
 *	@package	MyWrapper
 *	@subpackage	Test
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 10/10/2012
 */

/*=======================================================================================
 *																						*
 *									DefaultOntology.php									*
 *																						*
 *======================================================================================*/

//
// Global includes.
//
require_once( 'includes.inc.php' );

//
// Local includes.
//
require_once( 'local.inc.php' );

//
// Class includes.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntology.php" );

//
// Start session.
//
session_start();


/*=======================================================================================
 *	MAIN																				*
 *======================================================================================*/
 
//
// TRY BLOCK.
//
try
{
	//
	// Open connections.
	//
	$_SESSION[ kSESSION_SERVER ] = New CMongoServer();
	$_SESSION[ kSESSION_DATABASE ] = $_SESSION[ kSESSION_SERVER ]->Database( "TEST" );
	
	//
	// Clear database.
	//
	$_SESSION[ kSESSION_DATABASE ]->Drop();
	
	//
	// Instantiate ontology.
	//
	$_SESSION[ kSESSION_ONTOLOGY ] = new COntology( $_SESSION[ kSESSION_DATABASE ] );
}

//
// CATCH BLOCK.
//
catch( Exception $error )
{
	echo( (string) $error );
}

echo( "\nDone!\n" );

?>

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
 *	@version	1.00 18/09/2012
 */

/*=======================================================================================
 *																						*
 *									TestOntology.php									*
 *																						*
 *======================================================================================*/

//
// Global includes.
//
require_once( 'includes.inc.php' );

//
// Class includes.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntology.php" );


/*=======================================================================================
 *	MAIN																				*
 *======================================================================================*/
 
//
// TRY BLOCK.
//
try
{
	//
	// Create and clean database.
	//
	$server = New CMongoServer();
	$database = $server->Database( "TEST" );
	$database->Drop();
	
	//
	// Instantiate ontology.
	//
	$ontology = new COntology( $database );
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

<?php

/**
 * Initialise ontologies.
 *
 * This file contains the routine to build the ontologies database.
 *
 *	@package	MyWrapper
 *	@subpackage	Data
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 10/10/2012
 */

/*=======================================================================================
 *																						*
 *								LoadOntologies.test.php									*
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
// Inform.
//
echo( "\n==> Ontology creation procedure.\n" );

//
// Init local storage.
//
$start = time();

//
// TRY BLOCK.
//
try
{
	//
	// Initialise connections and ontology.
	//
	Init();

	echo( "\nTime elapsed: ".(time() - $start)."\n" );
}

//
// CATCH BLOCK.
//
catch( Exception $error )
{
	echo( (string) $error );
}

echo( "\nDone!\n" );

		

/*=======================================================================================
 *																						*
 *										FUNCTIONS										*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Init																			*
	 *==================================================================================*/

	/**
	 * <h4>Initialise connections and resources</h4>
	 *
	 * This method will open database connections, clear the existing database and
	 * instantiate the {@link COntology} object.
	 */
	function Init()
	{
		//
		// Open connections.
		//
		echo( "  • Opening connections.\n" );
		$_SESSION[ kSESSION_SERVER ] = New CMongoServer();
		
		//
		// Set graph reference.
		//
		$tmp = explode( ':', kDEFAULT_GRAPH );
		$graph = new CNeo4jGraph( $tmp[ 0 ], $tmp[ 1 ] );
		$_SESSION[ kSESSION_SERVER ]->Graph( $graph );
		
		//
		// Set database reference.
		//
		$_SESSION[ kSESSION_DATABASE ]
			= $_SESSION[ kSESSION_SERVER ]
				->Database( kDEFAULT_DATABASE );
		
		//
		// Instantiate ontology.
		//
		echo( "  • Instantiating ontology.\n" );
		$_SESSION[ kSESSION_ONTOLOGY ]
			= new COntology( $_SESSION[ kSESSION_DATABASE ] );
		
		//
		// Initialising ontology.
		//
		echo( "  • Initialising ontology.\n" );
		$_SESSION[ kSESSION_ONTOLOGY ]->InitOntology();

	} // Init.

?>

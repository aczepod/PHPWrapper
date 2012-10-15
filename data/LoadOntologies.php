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
 *									LoadOntologies.php									*
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
// Default ontologies.
//
require_once( 'DefaultOntologies.php' );

//
// ISO codes.
//
require_once( 'ISOCodes.php' );

//
// ISO ontologies.
//
require_once( 'ISOOntologies.php' );

//
// Landrace ontology.
//
require_once( 'LandracesPassport.php' );

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
$list = array( 'TERMS', 'NODES', 'TAGS' );
foreach( $list as $item )
	$_SESSION[ $item ] = Array();

//
// TRY BLOCK.
//
try
{
	//
	// Initialise connections.
	//
	Init();
	
	echo( "  • Loading default ontologies.\n" );
	
	//
	// Load default ontologies.
	//
	LoadDefaultNamespace();
	LoadDefaultOntology();
	LoadDefaultCategories();
	LoadDefaultPredicates();
	LoadDefaultAttributes();
	LoadDefaultTypes();
	
	echo( "  • Loading ISO standards.\n" );
	
	//
	// Load ISO standards.
	//
	LoadISOOntologies();
	LoadISOStandards();
	LoadISO639Categories();
	LoadISO639Enums();
	LoadISO3166Categories();
	
	echo( "  • Loading ISO codes.\n" );
	
	//
	// Load ISO codes.
	//
	ISODecodePOFiles();
	ISOBuildXMLFiles();
	
	echo( "  • Loading landraces passport ontology.\n" );
	
	//
	// Load landrace passport ontology.
	//
	LoadLandraceOntology();
	LoadLandraceCategories();
	LoadLandraceInventoryTraits();
	LoadLandraceTaxonomyTraits();
	LoadLandraceIdentificationTraits();
	LoadLandraceSiteTraits();
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
		$_SESSION[ kSESSION_DATABASE ]
			= $_SESSION[ kSESSION_SERVER ]
				->Database( kDEFAULT_DATABASE );
		
		//
		// Clear database.
		// Note that when creating the default ontology the database is cleared by default.
		//
		echo( "  • Clearing database.\n" );
		$_SESSION[ kSESSION_DATABASE ]->Drop();
		
		//
		// Instantiate ontology.
		//
		echo( "  • Instantiating ontology.\n" );
		$_SESSION[ kSESSION_ONTOLOGY ]
			= new COntology( $_SESSION[ kSESSION_DATABASE ] );

	} // Init.

?>

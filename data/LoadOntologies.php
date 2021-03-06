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
if( kOPTION_VERBOSE )
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
	
	//
	// Loading ISO standards categories.
	//
	if( kOPTION_VERBOSE )
		echo( "  • Loading ISO standards.\n" );
	$_SESSION[ kSESSION_ONTOLOGY ]->LoadXMLOntologyFile(
		kPATH_MYWRAPPER_LIBRARY_DATA."/ISO_UNITS.xml" );
	
	//
	// Loading ISO standards categories.
	//
	if( kOPTION_VERBOSE )
		echo( "  • Decoding ISO files.\n" );
	$_SESSION[ kSESSION_ONTOLOGY ]->LoadISOPOFiles();
	
	//
	// Loading ISO country relationships.
	//
	if( kOPTION_VERBOSE )
		echo( "  • Loading ISO standards.\n" );
	$_SESSION[ kSESSION_ONTOLOGY ]->LoadXMLOntologyFile(
		kPATH_MYWRAPPER_LIBRARY_DATA."/ISO_3166_RELATIONSHIPS.xml" );
	
	//
	// Loading UN stats categories.
	//
	if( kOPTION_VERBOSE )
		echo( "  • Loading UN regions.\n" );
	$_SESSION[ kSESSION_ONTOLOGY ]->LoadXMLOntologyFile(
		kPATH_MYWRAPPER_LIBRARY_DATA."/UNSTAT_REGIONS.xml" );
	
	//
	// Loading World Bank categories.
	//
	if( kOPTION_VERBOSE )
		echo( "  • Loading World Bank categories.\n" );
	$_SESSION[ kSESSION_ONTOLOGY ]->LoadXMLOntologyFile(
		kPATH_MYWRAPPER_LIBRARY_DATA."/WORLD_BANK.xml" );
	
	//
	// Loading country World Bank categories.
	//
	if( kOPTION_VERBOSE )
		echo( "  • Loading country World Bank categories.\n" );
	$_SESSION[ kSESSION_ONTOLOGY ]->LoadXMLOntologyFile(
		kPATH_MYWRAPPER_LIBRARY_DATA."/COUNTRY_WORLD_BANK.xml" );
	
	//
	// Loading GR descriptors.
	//
	if( kOPTION_VERBOSE )
		echo( "  • Loading GRINFO descriptors.\n" );
	$_SESSION[ kSESSION_ONTOLOGY ]->LoadXMLOntologyFile(
		kPATH_MYWRAPPER_LIBRARY_DATA."/GR_UNITS.xml" );
	
	//
	// Load all countries.
	//
	$_SESSION[ kSESSION_ONTOLOGY ]->SetAllCountries(
		'GR:COUNTRIES' );

	//
	// Loading FAO institute descriptors.
	//
	if( kOPTION_VERBOSE )
		echo( "  • Loading FAO institutes.\n" );
	$_SESSION[ kSESSION_ONTOLOGY ]->LoadXMLOntologyFile(
		kPATH_MYWRAPPER_LIBRARY_DATA."/FAO_INSTITUTES.xml" );

	//
	// Loading landrace descriptors.
	//
	if( kOPTION_VERBOSE )
		echo( "  • Loading landrace descriptors.\n" );
	$_SESSION[ kSESSION_ONTOLOGY ]->LoadXMLOntologyFile(
		kPATH_MYWRAPPER_LIBRARY_DATA."/LR_UNITS.xml" );

	//
	// Loading multicrop descriptors.
	//
	if( kOPTION_VERBOSE )
		echo( "  • Loading multicrop descriptors.\n" );
	$_SESSION[ kSESSION_ONTOLOGY ]->LoadXMLOntologyFile(
		kPATH_MYWRAPPER_LIBRARY_DATA."/MCPD_UNITS.xml" );
	
	if( kOPTION_VERBOSE )
		echo( "\nTime elapsed: ".(time() - $start)."\n" );
}

//
// CATCH BLOCK.
//
catch( Exception $error )
{
	echo( (string) $error );
}

if( kOPTION_VERBOSE )
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
		if( kOPTION_VERBOSE )
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
		if( kOPTION_VERBOSE )
			echo( "  • Instantiating ontology.\n" );
		$_SESSION[ kSESSION_ONTOLOGY ]
			= new COntology( $_SESSION[ kSESSION_DATABASE ] );
		
		//
		// Initialising containers.
		//
		if( kOPTION_VERBOSE )
			echo( "  • Initialising containers.\n" );
		$_SESSION[ kSESSION_ONTOLOGY ]->InitContainers();
		
		//
		// Initialising ontology.
		//
		if( kOPTION_VERBOSE )
			echo( "  • Initialising ontology.\n" );
		$_SESSION[ kSESSION_ONTOLOGY ]->InitOntology();

	} // Init.

?>

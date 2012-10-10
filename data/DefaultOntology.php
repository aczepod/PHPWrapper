<?php

/**
 * Test ontology suite.
 *
 * This file contains routines to create a test ontology.
 *
 *	@package	MyWrapper
 *	@subpackage	Data
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
// Private includes.
//
require_once( 'DefaultOntology.inc.php' );

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
echo( "\n==> Default ontology creation.\n" );

//
// TRY BLOCK.
//
try
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
	$_SESSION[ kSESSION_ONTOLOGY ] = new COntology( $_SESSION[ kSESSION_DATABASE ] );
	
	echo( "  • Loading ontology.\n" );

	//
	// Create default namespace term.
	//
	$ns = $_SESSION[ kSESSION_ONTOLOGY ]
			->NewTerm(
				"",
				NULL,
				"Default namespace",
				"This represents the default namespace term.",
				kDEFAULT_LANGUAGE );

	//
	// Create and relate root and attributes category.
	//
	$_SESSION[ kSESSION_ONTOLOGY ]
		->SubclassOf(
			$category = $_SESSION[ kSESSION_ONTOLOGY ]
							->NewNode(
								"ATTRIBUTES",
								NULL, NULL,
								$ns,
								"Default attributes",
								"The predefined default attributes available to all.",
								kDEFAULT_LANGUAGE,
								FALSE ),
			$root = $_SESSION[ kSESSION_ONTOLOGY ]
						->NewRootNode(
							kONTOLOGY_DEFAULT_ROOT,
							$ns,
							"Default ontology",
							"The default ontology collects all attributes and properties used "
						   ."by the ontology elements themselves. This ontology serves as the "
						   ."building blocks of all other ontologies.",
							kDEFAULT_LANGUAGE,
							FALSE ) );

	//
	// Create and relate authorship to attributes category.
	//
	$_SESSION[ kSESSION_ONTOLOGY ]
		->SubclassOf(
			$trait = $_SESSION[ kSESSION_ONTOLOGY ]
						->NewScaleNode(
							"AUTHORS",
							array( kTYPE_STRING, kTYPE_CARD_ARRAY ),
							$ns,
							"Authors",
							"List of authors.",
							kDEFAULT_LANGUAGE,
							FALSE ),
			$category );
	
	//
	// Create authorship attribute tag.
	//
	$tag = NULL;
	$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag( $tag, $trait );
	$attribute_authorship
		= $_SESSION[ kSESSION_ONTOLOGY ]->AddToTag( $tag, TRUE );

	//
	// Create and relate notes to attributes category.
	//
	$_SESSION[ kSESSION_ONTOLOGY ]
		->SubclassOf(
			$trait = $_SESSION[ kSESSION_ONTOLOGY ]
						->NewScaleNode(
							"NOTES",
							kTYPE_STRING,
							$ns,
							"Notes",
							"General notes.",
							kDEFAULT_LANGUAGE,
							FALSE ),
			$category );
	
	//
	// Create authorship attribute tag.
	//
	$tag = NULL;
	$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag( $tag, $trait );
	$attribute_notes
		= $_SESSION[ kSESSION_ONTOLOGY ]->AddToTag( $tag, TRUE );

	//
	// Create and relate acknowledgments to attributes category.
	//
	$_SESSION[ kSESSION_ONTOLOGY ]
		->SubclassOf(
			$trait = $_SESSION[ kSESSION_ONTOLOGY ]
						->NewScaleNode(
							"ACKNOWLEDGMENTS",
							kTYPE_STRING,
							$ns,
							"Acknowledgments",
							"General acknowledgments.",
							kDEFAULT_LANGUAGE,
							FALSE ),
			$category );
	
	//
	// Create authorship attribute tag.
	//
	$tag = NULL;
	$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag( $tag, $trait );
	$attribute_acknowledgments
		= $_SESSION[ kSESSION_ONTOLOGY ]->AddToTag( $tag, TRUE );

	//
	// Create and relate bibliography to attributes category.
	//
	$_SESSION[ kSESSION_ONTOLOGY ]
		->SubclassOf(
			$trait = $_SESSION[ kSESSION_ONTOLOGY ]
						->NewScaleNode(
							"BIBLIOGRAPHY",
							array( kTYPE_STRING, kTYPE_CARD_ARRAY ),
							$ns,
							"Bibliography",
							"List of bibliographic references.",
							kDEFAULT_LANGUAGE,
							FALSE ),
			$category );
	
	//
	// Create authorship attribute tag.
	//
	$tag = NULL;
	$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag( $tag, $trait );
	$attribute_bibliography
		= $_SESSION[ kSESSION_ONTOLOGY ]->AddToTag( $tag, TRUE );
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

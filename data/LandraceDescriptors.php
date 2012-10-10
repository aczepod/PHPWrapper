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
 *								LandraceDescriptors.php									*
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
// Default attributes.
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
echo( "\n==> Landrace inventory ontology creation.\n" );

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
	// Instantiate ontology.
	//
	echo( "  • Instantiating ontology.\n" );
	$_SESSION[ kSESSION_ONTOLOGY ] = new COntology( $_SESSION[ kSESSION_DATABASE ] );
	
	echo( "  • Loading ontology.\n" );
	
	//
	// Load default attribute tags.
	//
	$authors
		= (string) $_SESSION[ kSESSION_ONTOLOGY ]
			->ResolveTag(
				$_SESSION[ kSESSION_ONTOLOGY ]
					->ResolveTerm( kONTOLOGY_DEFAULT_AUTHORS, "" ) )
						[ 0 ][ kOFFSET_NID ];
	$notes
		= (string) $_SESSION[ kSESSION_ONTOLOGY ]
			->ResolveTag(
				$_SESSION[ kSESSION_ONTOLOGY ]
					->ResolveTerm( kONTOLOGY_DEFAULT_NOTES, "" ) )
						[ 0 ][ kOFFSET_NID ];
	$ackw
		= (string) $_SESSION[ kSESSION_ONTOLOGY ]
			->ResolveTag(
				$_SESSION[ kSESSION_ONTOLOGY ]
					->ResolveTerm( kONTOLOGY_DEFAULT_ACKNOWLEDGMENTS, "" ) )
						[ 0 ][ kOFFSET_NID ];
	$biblio
		= (string) $_SESSION[ kSESSION_ONTOLOGY ]
			->ResolveTag(
				$_SESSION[ kSESSION_ONTOLOGY ]
					->ResolveTerm( kONTOLOGY_DEFAULT_BIBLIOGRAPHY, "" ) )
						[ 0 ][ kOFFSET_NID ];
	$exemple
		= (string) $_SESSION[ kSESSION_ONTOLOGY ]
			->ResolveTag(
				$_SESSION[ kSESSION_ONTOLOGY ]
					->ResolveTerm( kONTOLOGY_DEFAULT_EXAMPLES, "" ) )
						[ 0 ][ kOFFSET_NID ];
	
	//
	// Create root node.
	//
	echo( "    - LR\n" );
	$root = $_SESSION[ kSESSION_ONTOLOGY ]
				->NewRootNode(
					$_SESSION[ kSESSION_ONTOLOGY ]
						->NewTerm(
							"LR",
							NULL,
							"DESCRIPTORS FOR WEB-ENABLED NATIONAL IN SITU LANDRACE INVENTORIES",
							"Descriptors For Web-Enabled National In Situ Landrace (LR) Inventories",
							kDEFAULT_LANGUAGE,
							array( $authors	=>	array( 'V. Negri', 'N. Maxted', 'R. Torricelli', 'M. Heinonen', 'M. Vetelainen', 'S. Dias' ),
								   $notes	=>	"Landraces are part of agro-biodiversity in urgent need of conservation. A prerequisite of any active conservation is some form of inventory of what is conserved.\n\n"
											   ."In this context, the EC Framework 7 PGR Secure project is aimed to provide help in generating National Landrace Inventories in European countries and so to begin the process of creating a European Landrace Inventory pivoted on the National Inventories.\n\n"
											   ."A European LR Inventory can only be based on National Inventories considered that the responsibility to conserve and sustainably use landrace diversity (as well as any other biodiversity component) lies with individual Nations and that any concerted action will be implemented at national level, even when driven by policy at European level.\n\n"
											   ."This draft descriptor list was worked out to facilitate the development of National Inventories of landraces that are still maintained in situ (i.e. on farm or in garden).\n\n"
											   ."It was drafted to record different types of information that were discussed at the “Crop Wild Relative and Landrace Conservation Training Workshop” held in Palanga Lithuania, 7-9 September 2011 by the in situ National Inventory Focal Points, the ECPGR Documentation and Information Network members and the PGR Secure team working on landraces.\n\n"
											   ."However, it also takes into account the contribution that the ECPGR On-farm Conservation and Management Working Group of the In Situ and On-Farm Conservation Network gave through years to the definition of descriptors for extant landraces (see draft descriptor list downloadable from http://www.ecpgr.cgiar.org/networks/in_situ_and_on_farm/on_farm_wg.html).\n\n"
											   ."The draft descriptor list includes fields related to the Inventory, taxon, landrace, site and farmer identification, the landrace status, characteristics and use and finally fields concerning conservation and monitoring actions eventually taken in favour of the landrace diversity maintenance.",
								   $ackw	=>	"Thanks are due to Adriana Alercia (Bioversity International, Rome), Theo van Hintum (Centre for Genetic Resources _ Wageningen University and Research Centre, the Netherlands) and Lorenzo Maggioni (ECPGR Secretariat, Rome) for helpful suggestions and comments.",
								   $biblio	=>	"Bioversity and The Christensen Fund, 2009. Descriptors for farmer’s knowledge of plants. Bioversity International, Rome, Italy and The Christensen Fund, Palo Alto, California, USA."
							) ) );

	//
	// Create and relate category nodes to ontology node.
	//
	echo( "    - LR:INVENTORY\n" );
	$_SESSION[ kSESSION_ONTOLOGY ]
		->SubclassOf(
			$cat_inventory = $_SESSION[ kSESSION_ONTOLOGY ]
							->NewNode(
								"INVENTORY",
								NULL, NULL,
								$root->Term(),
								"INVENTORY IDENTIFICATION",
								"Descriptors identifying the inventory and origin of the landrace or population.",
								kDEFAULT_LANGUAGE,
								FALSE ),
			$root );
	echo( "    - LR:TAXONOMY\n" );
	$_SESSION[ kSESSION_ONTOLOGY ]
		->SubclassOf(
			$cat_taxonomy = $_SESSION[ kSESSION_ONTOLOGY ]
							->NewNode(
								"TAXONOMY",
								NULL, NULL,
								$root->Term(),
								"TAXON IDENTIFICATION",
								"Descriptors identifying the scientific nomenclature of the landrace or population.",
								kDEFAULT_LANGUAGE,
								FALSE ),
			$root );
	echo( "    - LR:IDENTIFICATION\n" );
	$_SESSION[ kSESSION_ONTOLOGY ]
		->SubclassOf(
			$cat_identification = $_SESSION[ kSESSION_ONTOLOGY ]
							->NewNode(
								"IDENTIFICATION",
								NULL, NULL,
								$root->Term(),
								"LANDRACE/POPULATION IDENTIFICATION",
								"Descriptors identifying the specific landrace or population.",
								kDEFAULT_LANGUAGE,
								FALSE ),
			$root );
	echo( "    - LR:SITE\n" );
	$_SESSION[ kSESSION_ONTOLOGY ]
		->SubclassOf(
			$cat_site = $_SESSION[ kSESSION_ONTOLOGY ]
							->NewNode(
								"SITE",
								NULL, NULL,
								$root->Term(),
								"SITE/LOCATION IDENTIFICATION",
								"Descriptors identifying the location of the landrace or population.",
								kDEFAULT_LANGUAGE,
								FALSE ),
			$root );
	echo( "    - LR:MAINTAINER)\n" );
	$_SESSION[ kSESSION_ONTOLOGY ]
		->SubclassOf(
			$cat_maintainer = $_SESSION[ kSESSION_ONTOLOGY ]
							->NewNode(
								"MAINTAINER",
								NULL, NULL,
								$root->Term(),
								"THE FARMER (I.E. THE MAINTAINER)",
								"Descriptors identifying the maintainer of the landrace or population.",
								kDEFAULT_LANGUAGE,
								FALSE ),
			$root );
	echo( "    - LR:LANDRACE)\n" );
	$_SESSION[ kSESSION_ONTOLOGY ]
		->SubclassOf(
			$cat_landrace = $_SESSION[ kSESSION_ONTOLOGY ]
							->NewNode(
								"LANDRACE",
								NULL, NULL,
								$root->Term(),
								"THE LANDRACE",
								"Descriptors describing the landrace.",
								kDEFAULT_LANGUAGE,
								FALSE ),
			$root );
	echo( "    - LR:MONITOR)\n" );
	$_SESSION[ kSESSION_ONTOLOGY ]
		->SubclassOf(
			$cat_monitor = $_SESSION[ kSESSION_ONTOLOGY ]
							->NewNode(
								"MONITOR",
								NULL, NULL,
								$root->Term(),
								"CONSERVATION AND MONITORING",
								"Descriptors covering conservation and maintenance of the landrace or population.",
								kDEFAULT_LANGUAGE,
								FALSE ),
			$root );
	echo( "    - LR:REMARKS)\n" );
	$_SESSION[ kSESSION_ONTOLOGY ]
		->SubclassOf(
			$cat_remark = $_SESSION[ kSESSION_ONTOLOGY ]
							->NewNode(
								"REMARKS",
								NULL, NULL,
								$root->Term(),
								"REMARKS",
								"Descriptors collecting comments on the landrace or population.",
								kDEFAULT_LANGUAGE,
								FALSE ),
			$root );

	//
	// Handle inventory descriptors.
	//
	echo( "    - LR:NICODE\n" );
	$_SESSION[ kSESSION_ONTOLOGY ]
		->SubclassOf(
			$trait
				= $_SESSION[ kSESSION_ONTOLOGY ]
					->NewScaleNode(
						$_SESSION[ kSESSION_ONTOLOGY ]
							->NewTerm(
								"NICODE",
								$root->Term(),
								"National Inventory code",
								"Country code identifying the National in situ LR Inventory; the code of the country preparing the National Inventory. For country codes use the three-letter ISO 3166-1 (see: http://unstats.un.org/unsd/methods/m49/m49alpha.htm).",
								kDEFAULT_LANGUAGE,
								FALSE ),
						array( kTYPE_STRING, kTYPE_CARD_REQUIRED ) ),
			$category );
	
	//
	// Create NICODE attribute tag.
	//
	$tag = NULL;
	$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag( $tag, $trait );
	$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag( $tag, TRUE );
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

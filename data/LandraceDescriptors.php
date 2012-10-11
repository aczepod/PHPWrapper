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
// Init local storage.
//
$tags = array( 'ATTRIBUTES', 'TERMS', 'NODES', 'TAGS' );
foreach( $tags as $tag )
	$_SESSION[ $tag ] = Array();

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
	
	//
	// Load default attribute tags.
	//
	$codes = array( kONTOLOGY_DEFAULT_AUTHORS, kONTOLOGY_DEFAULT_NOTES,
					kONTOLOGY_DEFAULT_ACKNOWLEDGMENTS, kONTOLOGY_DEFAULT_BIBLIOGRAPHY,
					kONTOLOGY_DEFAULT_EXAMPLES );
	foreach( $codes as $code )
		$_SESSION[ 'ATTRIBUTES' ][ $code ]
			= (string) $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTag(
				$_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					$code, "" ) )
						[ 0 ][ kOFFSET_NID ];
	
	echo( "  • Loading ontology.\n" );
	
/*=======================================================================================
 *	ROOT																				*
 *======================================================================================*/
 
	//
	// Create ontology.
	//
	$code = 'LR';
	$_SESSION[ 'NODES' ][ $code ]
		= $_SESSION[ kSESSION_ONTOLOGY ]->NewRootNode(
			$_SESSION[ 'TERMS' ][ $code ]
				= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
					$code,
					NULL,
					"DESCRIPTORS FOR WEB-ENABLED NATIONAL IN SITU LANDRACE INVENTORIES",
					"Descriptors For Web-Enabled National In Situ Landrace (LR) Inventories",
					kDEFAULT_LANGUAGE,
					array( kOFFSET_SYNONYMS => array( $code ),
						   $_SESSION[ 'ATTRIBUTES' ][ kONTOLOGY_DEFAULT_AUTHORS ]
							=>	array( 'V. Negri', 'N. Maxted', 'R. Torricelli', 'M. Heinonen', 'M. Vetelainen', 'S. Dias' ),
						   $_SESSION[ 'ATTRIBUTES' ][ kONTOLOGY_DEFAULT_NOTES ]
							=>	"Landraces are part of agro-biodiversity in urgent need of conservation. A prerequisite of any active conservation is some form of inventory of what is conserved.\n\n"
							   ."In this context, the EC Framework 7 PGR Secure project is aimed to provide help in generating National Landrace Inventories in European countries and so to begin the process of creating a European Landrace Inventory pivoted on the National Inventories.\n\n"
							   ."A European LR Inventory can only be based on National Inventories considered that the responsibility to conserve and sustainably use landrace diversity (as well as any other biodiversity component) lies with individual Nations and that any concerted action will be implemented at national level, even when driven by policy at European level.\n\n"
							   ."This draft descriptor list was worked out to facilitate the development of National Inventories of landraces that are still maintained in situ (i.e. on farm or in garden).\n\n"
							   ."It was drafted to record different types of information that were discussed at the “Crop Wild Relative and Landrace Conservation Training Workshop” held in Palanga Lithuania, 7-9 September 2011 by the in situ National Inventory Focal Points, the ECPGR Documentation and Information Network members and the PGR Secure team working on landraces.\n\n"
							   ."However, it also takes into account the contribution that the ECPGR On-farm Conservation and Management Working Group of the In Situ and On-Farm Conservation Network gave through years to the definition of descriptors for extant landraces (see draft descriptor list downloadable from http://www.ecpgr.cgiar.org/networks/in_situ_and_on_farm/on_farm_wg.html).\n\n"
							   ."The draft descriptor list includes fields related to the Inventory, taxon, landrace, site and farmer identification, the landrace status, characteristics and use and finally fields concerning conservation and monitoring actions eventually taken in favour of the landrace diversity maintenance.",
						   $_SESSION[ 'ATTRIBUTES' ][ kONTOLOGY_DEFAULT_ACKNOWLEDGMENTS ]
							=>	"Thanks are due to Adriana Alercia (Bioversity International, Rome), Theo van Hintum (Centre for Genetic Resources _ Wageningen University and Research Centre, the Netherlands) and Lorenzo Maggioni (ECPGR Secretariat, Rome) for helpful suggestions and comments.",
						   $_SESSION[ 'ATTRIBUTES' ][ kONTOLOGY_DEFAULT_BIBLIOGRAPHY ]
							=>	"Bioversity and The Christensen Fund, 2009. Descriptors for farmer’s knowledge of plants. Bioversity International, Rome, Italy and The Christensen Fund, Palo Alto, California, USA."
					) ) );
	echo( "    - ".$_SESSION[ 'TERMS' ][ $code ][ kOFFSET_GID ]." [".$_SESSION[ 'NODES' ][ $code ]."]\n" );
	
/*=======================================================================================
 *	CATEGORIES																			*
 *======================================================================================*/
 
	//
	// Create and relate category nodes to ontology node.
	//
	$code = 'INVENTORY';
	$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
		$_SESSION[ 'NODES' ][ $code ]
			= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
				$_SESSION[ 'TERMS' ][ $code ]
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
						$code,
						$_SESSION[ 'TERMS' ][ 'LR' ],
						"INVENTORY IDENTIFICATION",
						"Descriptors identifying the inventory and origin of the landrace or population.",
						kDEFAULT_LANGUAGE,
						array( kOFFSET_SYNONYMS => array( $code, '1' ) ) ) ),
		$_SESSION[ 'NODES' ][ 'LR' ] );
	echo( "    - ".$_SESSION[ 'TERMS' ][ $code ][ kOFFSET_GID ]." [".$_SESSION[ 'NODES' ][ $code ]."]\n" );

	$code = 'TAXONOMY';
	$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
		$_SESSION[ 'NODES' ][ $code ]
			= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
				$_SESSION[ 'TERMS' ][ $code ]
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
						$code,
						$_SESSION[ 'TERMS' ][ 'LR' ],
						"TAXON IDENTIFICATION",
						"Descriptors identifying the scientific nomenclature of the landrace or population.",
						kDEFAULT_LANGUAGE,
						array( kOFFSET_SYNONYMS => array( $code, '2' ) ) ) ),
		$_SESSION[ 'NODES' ][ 'LR' ] );
	echo( "    - ".$_SESSION[ 'TERMS' ][ $code ][ kOFFSET_GID ]." [".$_SESSION[ 'NODES' ][ $code ]."]\n" );

	$code = 'IDENTIFICATION';
	$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
		$_SESSION[ 'NODES' ][ $code ]
			= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
				$_SESSION[ 'TERMS' ][ $code ]
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
						$code,
						$_SESSION[ 'TERMS' ][ 'LR' ],
						"LANDRACE/POPULATION IDENTIFICATION",
						"Descriptors identifying the specific landrace or population.",
						kDEFAULT_LANGUAGE,
						array( kOFFSET_SYNONYMS => array( $code, '3' ) ) ) ),
		$_SESSION[ 'NODES' ][ 'LR' ] );
	echo( "    - ".$_SESSION[ 'TERMS' ][ $code ][ kOFFSET_GID ]." [".$_SESSION[ 'NODES' ][ $code ]."]\n" );

	$code = 'SITE';
	$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
		$_SESSION[ 'NODES' ][ $code ]
			= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
				$_SESSION[ 'TERMS' ][ $code ]
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
						$code,
						$_SESSION[ 'TERMS' ][ 'LR' ],
						"SITE/LOCATION IDENTIFICATION",
						"Descriptors identifying the location of the landrace or population.",
						kDEFAULT_LANGUAGE,
						array( kOFFSET_SYNONYMS => array( $code, '4' ) ) ) ),
		$_SESSION[ 'NODES' ][ 'LR' ] );
	echo( "    - ".$_SESSION[ 'TERMS' ][ $code ][ kOFFSET_GID ]." [".$_SESSION[ 'NODES' ][ $code ]."]\n" );

	$code = 'MAINTAINER';
	$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
		$_SESSION[ 'NODES' ][ $code ]
			= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
				$_SESSION[ 'TERMS' ][ $code ]
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
						$code,
						$_SESSION[ 'TERMS' ][ 'LR' ],
						"THE FARMER (I.E. THE MAINTAINER)",
						"Descriptors identifying the maintainer of the landrace or population.",
						kDEFAULT_LANGUAGE,
						array( kOFFSET_SYNONYMS => array( $code, '5' ) ) ) ),
		$_SESSION[ 'NODES' ][ 'LR' ] );
	echo( "    - ".$_SESSION[ 'TERMS' ][ $code ][ kOFFSET_GID ]." [".$_SESSION[ 'NODES' ][ $code ]."]\n" );

	$code = 'LANDRACE';
	$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
		$_SESSION[ 'NODES' ][ $code ]
			= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
				$_SESSION[ 'TERMS' ][ $code ]
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
						$code,
						$_SESSION[ 'TERMS' ][ 'LR' ],
						"THE LANDRACE",
						"Descriptors describing the landrace.",
						kDEFAULT_LANGUAGE,
						array( kOFFSET_SYNONYMS => array( $code, '6' ) ) ) ),
		$_SESSION[ 'NODES' ][ 'LR' ] );
	echo( "    - ".$_SESSION[ 'TERMS' ][ $code ][ kOFFSET_GID ]." [".$_SESSION[ 'NODES' ][ $code ]."]\n" );

	$code = 'MONITOR';
	$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
		$_SESSION[ 'NODES' ][ $code ]
			= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
				$_SESSION[ 'TERMS' ][ $code ]
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
						$code,
						$_SESSION[ 'TERMS' ][ 'LR' ],
						"CONSERVATION AND MONITORING",
						"Descriptors covering conservation and maintenance of the landrace or population.",
						kDEFAULT_LANGUAGE,
						array( kOFFSET_SYNONYMS => array( $code, '7' ) ) ) ),
		$_SESSION[ 'NODES' ][ 'LR' ] );
	echo( "    - ".$_SESSION[ 'TERMS' ][ $code ][ kOFFSET_GID ]." [".$_SESSION[ 'NODES' ][ $code ]."]\n" );

	$code = 'REMARKS';
	$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
		$_SESSION[ 'NODES' ][ $code ]
			= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
				$_SESSION[ 'TERMS' ][ $code ]
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
						$code,
						$_SESSION[ 'TERMS' ][ 'LR' ],
						"REMARKS",
						"Descriptors collecting comments on the landrace or population.",
						kDEFAULT_LANGUAGE,
						array( kOFFSET_SYNONYMS => array( $code, '8' ) ) ) ),
		$_SESSION[ 'NODES' ][ 'LR' ] );
	echo( "    - ".$_SESSION[ 'TERMS' ][ $code ][ kOFFSET_GID ]." [".$_SESSION[ 'NODES' ][ $code ]."]\n" );
	
/*=======================================================================================
 *	INVENTORY																			*
 *======================================================================================*/
 
	//
	// National inventory (NICODE).
	//
	$code = 'NICODE';
	// Relate.
	$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
		$_SESSION[ 'NODES' ][ $code ]
			= $_SESSION[ kSESSION_ONTOLOGY ]->NewScaleNode(
				$_SESSION[ 'TERMS' ][ $code ]
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
						$code,
						$_SESSION[ 'TERMS' ][ 'LR' ],
						"National Inventory code",
						"Country code identifying the National in situ LR Inventory; the code of the country preparing the National Inventory. For country codes use the three-letter ISO 3166-1 (see: http://unstats.un.org/unsd/methods/m49/m49alpha.htm).",
						kDEFAULT_LANGUAGE,
						array( kOFFSET_SYNONYMS
								=> array( $code, '1.1' ),
							   $_SESSION[ 'ATTRIBUTES' ][ kONTOLOGY_DEFAULT_EXAMPLES ]
								=> array( 'NLD' ) ) ),
				array( kTYPE_ENUM, kTYPE_CARD_REQUIRED ) ),
		$_SESSION[ 'NODES' ][ 'INVENTORY' ] );
	// Tag.
	$_SESSION[ 'TAGS' ][ $code ] = NULL;
	$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag(
		$_SESSION[ 'TAGS' ][ $code ],
		$_SESSION[ 'NODES' ][ $code ] );
	$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag(
		$_SESSION[ 'TAGS' ][ $code ],
		TRUE );
	echo( "    - ".$_SESSION[ 'TAGS' ][ $code ][ kOFFSET_GID ]." [".$_SESSION[ 'NODES' ][ $code ]."] (".$_SESSION[ 'TAGS' ][ $code ][ kOFFSET_NID ].")\n" );
 
	//
	// National inventory edition number (NIENUMB).
	//
	$code = 'NIENUMB';
	// Relate.
	$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
		$_SESSION[ 'NODES' ][ $code ]
			= $_SESSION[ kSESSION_ONTOLOGY ]->NewScaleNode(
				$_SESSION[ 'TERMS' ][ $code ]
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
						$code,
						$_SESSION[ 'TERMS' ][ 'LR' ],
						"National Inventory edition number",
						"Code identifying the edition of the National in situ LR Inventory made up of the edition number and the year of publication.",
						kDEFAULT_LANGUAGE,
						array( kOFFSET_SYNONYMS
								=> array( $code, '1.2' ),
							   $_SESSION[ 'ATTRIBUTES' ][ kONTOLOGY_DEFAULT_EXAMPLES ]
								=> array( 'the first edition that is compiled in 2012 will be coded as 001/2012',
										  'the second edition that is compiled in 2014 will be coded 002/2014' ) ) ),
				array( kTYPE_STRING, kTYPE_CARD_REQUIRED ) ),
		$_SESSION[ 'NODES' ][ 'INVENTORY' ] );
	// Tag.
	$_SESSION[ 'TAGS' ][ $code ] = NULL;
	$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag(
		$_SESSION[ 'TAGS' ][ $code ],
		$_SESSION[ 'NODES' ][ $code ] );
	$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag(
		$_SESSION[ 'TAGS' ][ $code ],
		TRUE );
	echo( "    - ".$_SESSION[ 'TAGS' ][ $code ][ kOFFSET_GID ]." [".$_SESSION[ 'NODES' ][ $code ]."] (".$_SESSION[ 'TAGS' ][ $code ][ kOFFSET_NID ].")\n" );
 
	//
	// Institute code (INSTCODE).
	//
	$code = 'INSTCODE';
	// Relate.
	$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
		$_SESSION[ 'NODES' ][ $code ]
			= $_SESSION[ kSESSION_ONTOLOGY ]->NewScaleNode(
				$_SESSION[ 'TERMS' ][ $code ]
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
						$code,
						$_SESSION[ 'TERMS' ][ 'LR' ],
						"Institute code",
						"FAO WIEWS code of the institute (see: http://apps3.fao.org/wiews/institute_query.htm?i_l=EN) who is responsible at the national level for the production of the National in situ LR Inventory.",
						kDEFAULT_LANGUAGE,
						array( kOFFSET_SYNONYMS
								=> array( $code, '1.2' ),
							   $_SESSION[ 'ATTRIBUTES' ][ kONTOLOGY_DEFAULT_EXAMPLES ]
								=> array( 'NLD037', 'ARM001' ) ) ),
				array( kTYPE_ENUM, kTYPE_CARD_REQUIRED ) ),
		$_SESSION[ 'NODES' ][ 'INVENTORY' ] );
	// Tag.
	$_SESSION[ 'TAGS' ][ $code ] = NULL;
	$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag(
		$_SESSION[ 'TAGS' ][ $code ],
		$_SESSION[ 'NODES' ][ $code ] );
	$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag(
		$_SESSION[ 'TAGS' ][ $code ],
		TRUE );
	echo( "    - ".$_SESSION[ 'TAGS' ][ $code ][ kOFFSET_GID ]." [".$_SESSION[ 'NODES' ][ $code ]."] (".$_SESSION[ 'TAGS' ][ $code ][ kOFFSET_NID ].")\n" );
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

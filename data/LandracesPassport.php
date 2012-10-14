<?php

/**
 * Landraces passport ontology loader.
 *
 * This file contains routines to create the landrace passport ontology.
 *
 *	@package	MyWrapper
 *	@subpackage	Data
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 10/10/2012
 */

/*=======================================================================================
 *																						*
 *								LandracesPassport.php									*
 *																						*
 *======================================================================================*/

		

/*=======================================================================================
 *																						*
 *										FUNCTIONS										*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	LoadLandraceOntology															*
	 *==================================================================================*/

	/**
	 * <h4>Load landrace ontology</h4>
	 *
	 * This method will create the landrace ontology term and node.
	 */
	function LoadLandraceOntology()
	{
		//
		// Create default ontology.
		//
		$code = 'LR';
		$id = $code;
		$_SESSION[ 'NODES' ][ $id ]
			= $_SESSION[ kSESSION_ONTOLOGY ]->NewRootNode(
				$_SESSION[ 'TERMS' ][ $id ]
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
						$code,
						NULL,
						"DESCRIPTORS FOR WEB-ENABLED NATIONAL IN SITU LANDRACE INVENTORIES",
						"Descriptors For Web-Enabled National In Situ Landrace (LR) Inventories",
						kDEFAULT_LANGUAGE,
						array( kOFFSET_SYNONYMS => array( $code ),
							   $_SESSION[ 'TAGS' ]
							   			[ kTOKEN_NAMESPACE_SEPARATOR.kONTOLOGY_DEFAULT_AUTHORS ]
							   			[ kOFFSET_NID ]
								=>	array( 'V. Negri', 'N. Maxted', 'R. Torricelli', 'M. Heinonen', 'M. Vetelainen', 'S. Dias' ),
							   $_SESSION[ 'TAGS' ]
							   			[ kTOKEN_NAMESPACE_SEPARATOR.kONTOLOGY_DEFAULT_NOTES ]
							   			[ kOFFSET_NID ]
								=>	"Landraces are part of agro-biodiversity in urgent need of conservation. A prerequisite of any active conservation is some form of inventory of what is conserved.\n\n"
								   ."In this context, the EC Framework 7 PGR Secure project is aimed to provide help in generating National Landrace Inventories in European countries and so to begin the process of creating a European Landrace Inventory pivoted on the National Inventories.\n\n"
								   ."A European LR Inventory can only be based on National Inventories considered that the responsibility to conserve and sustainably use landrace diversity (as well as any other biodiversity component) lies with individual Nations and that any concerted action will be implemented at national level, even when driven by policy at European level.\n\n"
								   ."This draft descriptor list was worked out to facilitate the development of National Inventories of landraces that are still maintained in situ (i.e. on farm or in garden).\n\n"
								   ."It was drafted to record different types of information that were discussed at the “Crop Wild Relative and Landrace Conservation Training Workshop” held in Palanga Lithuania, 7-9 September 2011 by the in situ National Inventory Focal Points, the ECPGR Documentation and Information Network members and the PGR Secure team working on landraces.\n\n"
								   ."However, it also takes into account the contribution that the ECPGR On-farm Conservation and Management Working Group of the In Situ and On-Farm Conservation Network gave through years to the definition of descriptors for extant landraces (see draft descriptor list downloadable from http://www.ecpgr.cgiar.org/networks/in_situ_and_on_farm/on_farm_wg.html).\n\n"
								   ."The draft descriptor list includes fields related to the Inventory, taxon, landrace, site and farmer identification, the landrace status, characteristics and use and finally fields concerning conservation and monitoring actions eventually taken in favour of the landrace diversity maintenance.",
							   $_SESSION[ 'TAGS' ]
							   			[ kTOKEN_NAMESPACE_SEPARATOR.kONTOLOGY_DEFAULT_ACKNOWLEDGMENTS ]
							   			[ kOFFSET_NID ]
								=>	"Thanks are due to Adriana Alercia (Bioversity International, Rome), Theo van Hintum (Centre for Genetic Resources _ Wageningen University and Research Centre, the Netherlands) and Lorenzo Maggioni (ECPGR Secretariat, Rome) for helpful suggestions and comments.",
							   $_SESSION[ 'TAGS' ]
							   			[ kTOKEN_NAMESPACE_SEPARATOR.kONTOLOGY_DEFAULT_BIBLIOGRAPHY ]
							   			[ kOFFSET_NID ]
								=>	"Bioversity and The Christensen Fund, 2009. Descriptors for farmer’s knowledge of plants. Bioversity International, Rome, Italy and The Christensen Fund, Palo Alto, California, USA."
							)
						)
					);

		//
		// Inform.
		//
		if( kOPTION_VERBOSE )
			echo( "    - $id [".$_SESSION[ 'NODES' ][ $id ]."]\n" );

	} // LoadLandraceOntology.

	 
	/*===================================================================================
	 *	LoadLandraceCategories															*
	 *==================================================================================*/

	/**
	 * <h4>Load landrace categories</h4>
	 *
	 * This method will create the landrace category nodes and relate them to their root.
	 */
	function LoadLandraceCategories()
	{
		//
		// Init top level storage.
		//
		$namespace = $_SESSION[ 'TERMS' ][ 'LR' ];
		$root = $_SESSION[ 'NODES' ][ 'LR' ];
		$params = array(
			array( 'code' => 'INVENTORY',
				   'syn' => '1',
				   'label' => "INVENTORY IDENTIFICATION",
				   'descr' => "Descriptors identifying the inventory and origin of the landrace or population." ),
			array( 'code' => 'TAXONOMY',
				   'syn' => '2',
				   'label' => "TAXON IDENTIFICATION",
				   'descr' => "Descriptors identifying the scientific nomenclature of the landrace or population." ),
			array( 'code' => 'IDENTIFICATION',
				   'syn' => '3',
				   'label' => "LANDRACE/POPULATION IDENTIFICATION",
				   'descr' => "Descriptors identifying the specific landrace or population." ),
			array( 'code' => 'SITE',
				   'syn' => '4',
				   'label' => "SITE/LOCATION IDENTIFICATION",
				   'descr' => "Descriptors identifying the location of the landrace or population." ),
			array( 'code' => 'MAINTAINER',
				   'syn' => '5',
				   'label' => "THE FARMER (I.E. THE MAINTAINER)",
				   'descr' => "Descriptors identifying the maintainer of the landrace or population." ),
			array( 'code' => 'LANDRACE',
				   'syn' => '6',
				   'label' => "THE LANDRACE",
				   'descr' => "Descriptors describing the landrace." ),
			array( 'code' => 'MONITOR',
				   'syn' => '7',
				   'label' => "CONSERVATION AND MONITORING",
				   'descr' => "Descriptors covering conservation and maintenance of the landrace or population." ),
			array( 'code' => 'REMARKS',
				   'syn' => '8',
				   'label' => "REMARKS",
				   'descr' => "Descriptors collecting comments on the landrace or population." )
		);
		
		//
		// Create landrace categories.
		//
		foreach( $params as $param )
		{
			//
			// Set global identifier.
			//
			$id = 'LR'.kTOKEN_NAMESPACE_SEPARATOR.$param[ 'code' ];
			
			//
			// Relate to root.
			//
			$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
				//
				// Create node.
				//
				$_SESSION[ 'NODES' ][ $id ]
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
						//
						// Create term.
						//
						$_SESSION[ 'TERMS' ][ $id ]
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
								$param[ 'code' ],		// Local identifier.
								$namespace,				// Namespace.
								$param[ 'label' ],		// Label or name.
								$param[ 'descr' ],		// Description or definition.
								kDEFAULT_LANGUAGE,		// Language.
								array( kOFFSET_SYNONYMS	// Additional attributes.
										=> array( $param[ 'code' ], $param[ 'syn' ] ) ) ) ),
				$root );
	
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - $id [".$_SESSION[ 'NODES' ][ $id ]."]\n" );
		}

		//
		// Init site category storage.
		//
		$category = 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'SITE';
		$namespace = $_SESSION[ 'TERMS' ][ $category ];
		$root = $_SESSION[ 'NODES' ][ $category ];
		$params = array(
			array( 'code' => 'COORD-FARM',
				   'syn' => '4.5',
				   'label' => "Farm coordinates",
				   'descr' => "Coordinates of the farm house or headquarters, to be recorded as either Degrees Minutes and Seconds-DMS or Decimal Degrees DD as specified below." ),
			array( 'code' => 'COORD-LR',
				   'syn' => '4.7',
				   'label' => "Coordinates of the LR site",
				   'descr' => "Coordinates of the field where the LR is/has been grown in the year the Inventory is compiled; to be recorded as either Degrees Minutes and Seconds-DMS or Decimal Degrees- DD, as described above for ‘Farm coordinates’." )
		);
		
		//
		// Create landrace categories.
		//
		foreach( $params as $param )
		{
			//
			// Set global identifier.
			//
			$id = $category.kTOKEN_NAMESPACE_SEPARATOR.$param[ 'code' ];
			
			//
			// Relate to root.
			//
			$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
				//
				// Create node.
				//
				$_SESSION[ 'NODES' ][ $id ]
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
						//
						// Create term.
						//
						$_SESSION[ 'TERMS' ][ $id ]
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
								$param[ 'code' ],		// Local identifier.
								$namespace,				// Namespace.
								$param[ 'label' ],		// Label or name.
								$param[ 'descr' ],		// Description or definition.
								kDEFAULT_LANGUAGE,		// Language.
								array( kOFFSET_SYNONYMS	// Additional attributes.
										=> array( $param[ 'code' ], $param[ 'syn' ] ) ) ) ),
				$root );
	
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - $id [".$_SESSION[ 'NODES' ][ $id ]."]\n" );
		}

	} // LoadLandraceCategories.

	 
	/*===================================================================================
	 *	LoadLandraceInventoryTraits														*
	 *==================================================================================*/

	/**
	 * <h4>Load landrace inventory traits</h4>
	 *
	 * This method will create the landrace inventory trait nodes and relate them to their
	 * category.
	 */
	function LoadLandraceInventoryTraits()
	{
		//
		// Init local storage.
		//
		$namespace = $_SESSION[ 'TERMS' ][ 'LR' ];
		$category = $_SESSION[ 'NODES' ][ 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'INVENTORY' ];
		$params = array(
			array( 'code' => 'NICODE',
				   'syn' => '1.1',
				   'type' => array( kTYPE_STRING, kTYPE_CARD_REQUIRED ),
				   'label' => "National Inventory code",
				   'descr' => "Country code identifying the National in situ LR Inventory; the code of the country preparing the National Inventory. For country codes use the three-letter ISO 3166-1 (see: http://unstats.un.org/unsd/methods/m49/m49alpha.htm).",
				   'examp' => array( 'NLD' ) ),
			array( 'code' => 'NIENUMB',
				   'syn' => '1.2',
				   'type' => array( kTYPE_STRING, kTYPE_CARD_REQUIRED ),
				   'label' => "National Inventory edition number",
				   'descr' => "Code identifying the edition of the National in situ LR Inventory made up of the edition number and the year of publication.",
				   'examp' => array( 'NLD' ) ),
			array( 'code' => 'INSTCODE',
				   'syn' => '1.3',
				   'type' => array( kTYPE_STRING, kTYPE_CARD_REQUIRED ),
				   'label' => "National Inventory edition number",
				   'descr' => "Code identifying the edition of the National in situ LR Inventory made up of the edition number and the year of publication.",
				   'examp' => array( 'NLD' ) ) );
		
		//
		// Load data.
		//
		foreach( $params as $param )
		{
			//
			// Set global identifier.
			//
			$id = 'LR'.kTOKEN_NAMESPACE_SEPARATOR.$param[ 'code' ];
			
			//
			// Relate to category.
			//
			$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
				//
				// Create node.
				//
				$_SESSION[ 'NODES' ][ $id ]
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewScaleNode(
						$_SESSION[ 'TERMS' ][ $id ]
							//
							// Create term.
							//
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
								$param[ 'code' ],		// Local identifier.
								$namespace,				// Namespace.
								$param[ 'label' ],		// Label or name.
								$param[ 'descr' ],		// Description or definition.
								kDEFAULT_LANGUAGE,		// Language.
								array( kOFFSET_SYNONYMS	// Additional attributes.
											=> array( $param[ 'code' ], $param[ 'syn' ] ),
										kTOKEN_NAMESPACE_SEPARATOR.kONTOLOGY_DEFAULT_EXAMPLES
											=> $param[ 'examp' ] ) ),
						$param[ 'type' ] ),				// Node data type.
				$category );							// Object vertex node.
			
			//
			// Create tag.
			//
			$_SESSION[ 'TAGS' ][ $id ] = NULL;
			$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag(
				$_SESSION[ 'TAGS' ][ $id ], $_SESSION[ 'NODES' ][ $id ] );
			$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag(
				$_SESSION[ 'TAGS' ][ $id ], TRUE );
			
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - $id ["
					 .$_SESSION[ 'NODES' ][ $id ]
					 ."] ("
					 .$_SESSION[ 'TAGS' ][ $id ][ kOFFSET_NID ]
					 .")\n" );
		}

	} // LoadLandraceInventoryTraits.

	 
	/*===================================================================================
	 *	LoadLandraceTaxonomyTraits														*
	 *==================================================================================*/

	/**
	 * <h4>Load landrace taxonomy traits</h4>
	 *
	 * This method will create the landrace taxonomy trait nodes and relate them to their
	 * category.
	 */
	function LoadLandraceTaxonomyTraits()
	{
		//
		// Init local storage.
		//
		$namespace = $_SESSION[ 'TERMS' ][ 'LR' ];
		$category = $_SESSION[ 'NODES' ][ 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'TAXONOMY' ];
		$params = array(
			array( 'code' => 'GENUS',
				   'syn' => '2.1',
				   'type' => array( kTYPE_STRING, kTYPE_CARD_REQUIRED ),
				   'label' => "Genus",
				   'descr' => "Genus name for taxon, in Latin. Initial uppercase letter required.",
				   'examp' => array( 'Vigna', 'Vicia' ) ),
			array( 'code' => 'SPECIES',
				   'syn' => '2.2',
				   'type' => array( kTYPE_STRING, kTYPE_CARD_REQUIRED ),
				   'label' => "Species",
				   'descr' => "Specific epithet portion of the scientific name, in Latin, in lower case letters.",
				   'examp' => array( 'unguiculata', 'faba' ) ),
			array( 'code' => 'SPAUTHOR',
				   'syn' => '2.3',
				   'type' => array( kTYPE_STRING, kTYPE_CARD_REQUIRED ),
				   'label' => "Species authority",
				   'descr' => "The authority for the species name.",
				   'examp' => array( '(L.) Wald.', 'L.' ) ),
			array( 'code' => 'SUBTAXA',
				   'syn' => '2.4',
				   'type' => kTYPE_STRING,
				   'label' => "Subtaxa",
				   'descr' => "This field can be used to store any additional taxonomic identifier (in Latin, in lower case letters) preceded by the rank (for example: subspecies, convariety, variety, form, cultivar group). The following abbreviations are foreseen for the rank: ‘subsp.’ (for subspecies); ‘convar.’ (for convariety); ‘var.’ (for variety); ‘f.’ (for form), ‘Group’ (for cultivar group).",
				   'examp' => array( 'subsp. sesquipedalis', 'subsp. faba var. minuta' ) ),
			array( 'code' => 'SUBTAUTHOR',
				   'syn' => '2.5',
				   'type' => kTYPE_STRING,
				   'label' => "Subtaxa authority",
				   'descr' => "The subtaxa authority at the most detailed taxonomic level.",
				   'examp' => array( '(L.) Verdc.', '(hort. ex Alef.) Mansf.' ) ),
			array( 'code' => 'TAXREF',
				   'syn' => '2.6',
				   'type' => array( kTYPE_STRING, kTYPE_CARD_ARRAY ),
				   'label' => "Taxonomic references",
				   'descr' => "Taxonomy used by Inventory compiler to identify the material (e.g.. The Plant List, Euro+Med PlantBase, GRIN taxonomy, etc).",
				   'examp' => array( 'The Plant List', 'GRIN Taxonomy' ) ),
			array( 'code' => 'CROPNAME)',
				   'syn' => '2.7',
				   'type' => array( kTYPE_STRING, kTYPE_CARD_ARRAY ),
				   'label' => "Common crop name",
				   'descr' => "Name of the crop in colloquial language, preferably English if any.",
				   'examp' => array( 'yard–long-bean', 'tick-bean' ) ) );
		
		//
		// Load data.
		//
		foreach( $params as $param )
		{
			//
			// Set global identifier.
			//
			$id = 'LR'.kTOKEN_NAMESPACE_SEPARATOR.$param[ 'code' ];
			
			//
			// Relate to category.
			//
			$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
				//
				// Create node.
				//
				$_SESSION[ 'NODES' ][ $id ]
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewScaleNode(
						$_SESSION[ 'TERMS' ][ $id ]
							//
							// Create term.
							//
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
								$param[ 'code' ],		// Local identifier.
								$namespace,				// Namespace.
								$param[ 'label' ],		// Label or name.
								$param[ 'descr' ],		// Description or definition.
								kDEFAULT_LANGUAGE,		// Language.
								array( kOFFSET_SYNONYMS	// Additional attributes.
											=> array( $param[ 'code' ], $param[ 'syn' ] ),
										kTOKEN_NAMESPACE_SEPARATOR.kONTOLOGY_DEFAULT_EXAMPLES
											=> $param[ 'examp' ] ) ),
						$param[ 'type' ] ),				// Node data type.
				$category );							// Object vertex node.
			
			//
			// Create tag.
			//
			$_SESSION[ 'TAGS' ][ $id ] = NULL;
			$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag(
				$_SESSION[ 'TAGS' ][ $id ], $_SESSION[ 'NODES' ][ $id ] );
			$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag(
				$_SESSION[ 'TAGS' ][ $id ], TRUE );
			
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - $id ["
					 .$_SESSION[ 'NODES' ][ $id ]
					 ."] ("
					 .$_SESSION[ 'TAGS' ][ $id ][ kOFFSET_NID ]
					 .")\n" );
		}

	} // LoadLandraceTaxonomyTraits.

	 
	/*===================================================================================
	 *	LoadLandraceIdentificationTraits												*
	 *==================================================================================*/

	/**
	 * <h4>Load landrace identification traits</h4>
	 *
	 * This method will create the landrace identification trait nodes and relate them to
	 * their category.
	 */
	function LoadLandraceIdentificationTraits()
	{
		//
		// Init local storage.
		//
		$namespace = $_SESSION[ 'TERMS' ][ 'LR' ];
		$category = $_SESSION[ 'NODES' ][ 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'IDENTIFICATION' ];
		$params = array(
			array( 'code' => 'LRRECDATE',
				   'syn' => '3.1',
				   'type' => kTYPE_DATE,
				   'label' => "Landrace in situ recording date",
				   'descr' => "Date on which the LR was recorded in the current in situ Inventory, as YYYYMMDD. Missing data (MM or DD) should be indicated with zeros. Leading zeros are required.",
				   'examp' => array( '19980000', '20020620' ) ),
			array( 'code' => 'LRNUMB',
				   'syn' => '3.2',
				   'type' => array( kTYPE_STRING, kTYPE_CARD_REQUIRED ),
				   'label' => "Landrace number",
				   'descr' => "Unique progressive number which identifies the in situ LR in the Inventory, not to be duplicated (i.e. reassigned) for other LRs or the same LR that is cultivated by other farmers in the current Inventory. To be assigned by the institute which is responsible at the national level for the production of the National LR in situ Inventory.",
				   'examp' => array( '00010' ) ),
			array( 'code' => 'LRNAME',
				   'syn' => '3.3',
				   'type' => kTYPE_STRING,
				   'label' => "Landrace local names",
				   'descr' => "Local name/s of the LR in the colloquial language of the farm. Free text.",
				   'examp' => array( 'fagiolina, cornetti, fagiolino dall’occhio' ) ),
			array( 'code' => 'LRLANG',
				   'syn' => '3.4',
				   'type' => kTYPE_ENUM,
				   'label' => "Landrace language codes",
				   'descr' => "The language code of the LR local name. Use ISO 639-2 is the alpha-3 code in Codes for the representation of names of languages (see: http://www.loc.gov/standards/iso639- 2/php/code_list.php).",
				   'examp' => array( 'eng', 'fra', 'ita' ) ) );
		
		//
		// Load data.
		//
		foreach( $params as $param )
		{
			//
			// Set global identifier.
			//
			$id = 'LR'.kTOKEN_NAMESPACE_SEPARATOR.$param[ 'code' ];
			
			//
			// Relate to category.
			//
			$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
				//
				// Create node.
				//
				$_SESSION[ 'NODES' ][ $id ]
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewScaleNode(
						$_SESSION[ 'TERMS' ][ $id ]
							//
							// Create term.
							//
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
								$param[ 'code' ],		// Local identifier.
								$namespace,				// Namespace.
								$param[ 'label' ],		// Label or name.
								$param[ 'descr' ],		// Description or definition.
								kDEFAULT_LANGUAGE,		// Language.
								array( kOFFSET_SYNONYMS	// Additional attributes.
											=> array( $param[ 'code' ], $param[ 'syn' ] ),
										kTOKEN_NAMESPACE_SEPARATOR.kONTOLOGY_DEFAULT_EXAMPLES
											=> $param[ 'examp' ] ) ),
						$param[ 'type' ] ),				// Node data type.
				$category );							// Object vertex node.
			
			//
			// Create tag.
			//
			$_SESSION[ 'TAGS' ][ $id ] = NULL;
			$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag(
				$_SESSION[ 'TAGS' ][ $id ], $_SESSION[ 'NODES' ][ $id ] );
			$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag(
				$_SESSION[ 'TAGS' ][ $id ], TRUE );
			
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - $id ["
					 .$_SESSION[ 'NODES' ][ $id ]
					 ."] ("
					 .$_SESSION[ 'TAGS' ][ $id ][ kOFFSET_NID ]
					 .")\n" );
		}

	} // LoadLandraceIdentificationTraits.

	 
	/*===================================================================================
	 *	LoadLandraceSiteTraits															*
	 *==================================================================================*/

	/**
	 * <h4>Load landrace site traits</h4>
	 *
	 * This method will create the landrace site trait nodes and relate them to their
	 * category.
	 */
	function LoadLandraceSiteTraits()
	{
		//
		// Init local storage.
		//
		$namespace = $_SESSION[ 'TERMS' ][ 'LR' ];
		$params = array(
			array( 'code' => 'FARMFIRSTADMIN',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'SITE',
				   'syn' => '4.1',
				   'type' => kTYPE_STRING,
				   'label' => "Farm location: primary administrative subdivision of the country where farm is located",
				   'descr' => "Name of the primary administrative subdivision of the country where the farm is located for the most part of its extension. Free text.",
				   'examp' => array( 'Umbria Region' ) ),
			array( 'code' => 'FARMSECONDADMIN',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'SITE',
				   'syn' => '4.2',
				   'type' => kTYPE_STRING,
				   'label' => "Farm location: secondary administrative subdivision",
				   'descr' => "Name of the secondary administrative subdivision (within the primary administrative subdivision) of the country where the farm is located. Free text.",
				   'examp' => array( 'Perugia Province' ) ),
			array( 'code' => 'FARMLOWESTADMIN',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'SITE',
				   'syn' => '4.3',
				   'type' => kTYPE_STRING,
				   'label' => "Farm location: lowest administrative subdivision",
				   'descr' => "Name of the lowest administrative subdivision (i.e. municipality). Free text.",
				   'examp' => array( 'Panicale municipality' ) ),
			array( 'code' => 'LOCATION',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'SITE',
				   'syn' => '4.4',
				   'type' => kTYPE_STRING,
				   'label' => "Location of the nearest known place",
				   'descr' => "Information relevant to the nearest known place, distance from nearest named place, and directions from the nearest named place. Descriptive field as detailed as possible. Free text.",
				   'examp' => array( '7 km south of Panicale towards Perugia on SS.74' ) ),
			array( 'code' => 'FLATDMS',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'SITE'.kTOKEN_NAMESPACE_SEPARATOR.'COORD-FARM',
				   'syn' => '4.5.1',
				   'type' => array( kTYPE_STRING, kTYPE_CARD_REQUIRED ),
				   'label' => "Latitude of farm site",
				   'descr' => "Degrees (2 digits) minutes (2 digits), and seconds (2 digits) followed by N (North) or S (South). Every missing digit (minutes or seconds) should be indicated with a zero. Leading zeros are also required for figures that are lower than ten.",
				   'examp' => array( '45° (i.e. 45 degrees), 4’ (i.e. 4 minutes) and unknown seconds North (Turin latitude) is coded as 450400N', '45°, 4’ and 8’’ (i.e. 8 seconds) North (Turin_Mole Antonelliana latitude) is coded as 450408N', '40° 25’ 6" N (Madrid) is coded as 402506N', '00° 13’ 23’’ S (Quito) is coded as 001323S' ) ),
			array( 'code' => 'FLATDD',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'SITE'.kTOKEN_NAMESPACE_SEPARATOR.'COORD-FARM',
				   'syn' => '4.5.1bis',
				   'type' => array( kTYPE_FLOAT, kTYPE_CARD_REQUIRED ),
				   'label' => "Latitude of farm site",
				   'descr' => "Latitude expressed in decimal degrees. Degree measurements should be written with decimal places like 45.069031° with the degree symbol behind the decimals. Every missing digit should be indicated with a zero. Positive values are North of the Equator; negative values are South of the Equator.",
				   'examp' => array( 'the same latitude of Turin_Mole Antonelliana reported above is coded as 45.069031°', 'the Madrid latitude reported above is coded as 40.418446°', 'the Quito latitude reported above is coded as -0.222900°' ) ),
			array( 'code' => 'FLONGDMS',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'SITE'.kTOKEN_NAMESPACE_SEPARATOR.'COORD-FARM',
				   'syn' => '4.5.2',
				   'type' => array( kTYPE_STRING, kTYPE_CARD_REQUIRED ),
				   'label' => "Longitude of farm site",
				   'descr' => "Degrees (3 digits), minutes (2 digits), and seconds (2 digits) followed by E (East) or W (West). Every missing digit (minutes or seconds) should be indicated with a zero. Leading zeros are also required for figures lower than ten.",
				   'examp' => array( '7° 41’ and unknown seconds E (Turin) is coded as 0074100E (2 zeros before the 7 degrees because longitude varies from 0 and 180 degrees and needs 3 digits)', '7° 41’ 36" E (Turin_Mole Antonelliana longitude) is coded as 0074135E', '3°42’ 51" W (Madrid) is coded as 0034251W', '78° 30’ 19’’ W (Quito) is coded as 0783019W' ) ),
			array( 'code' => 'FLONGDD',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'SITE'.kTOKEN_NAMESPACE_SEPARATOR.'COORD-FARM',
				   'syn' => '4.5.2bis',
				   'type' => array( kTYPE_FLOAT, kTYPE_CARD_REQUIRED ),
				   'label' => "Longitude of farm site",
				   'descr' => "Longitude expressed in decimal degrees. Degree measurements should be written with decimal places like 74.044636° with the degree symbol behind the decimals. Every missing digit should be indicated with a zero. Positive values are East of the Greenwich Meridian; negative values are West of the Greenwich Meridian.",
				   'examp' => array( 'the same longitude of Turin_Mole Antonelliana reported above is coded as 7.693154°', 'the same longitude of Madrid reported above is coded as -3.714277°', 'the same longitude of Quito reported above is coded as -78.505386°' ) ),
			array( 'code' => 'FEPSGCODE',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'SITE'.kTOKEN_NAMESPACE_SEPARATOR.'COORD-FARM',
				   'syn' => '4.5.3',
				   'type' => kTYPE_STRING,
				   'label' => "Geodetic datum",
				   'descr' => "The geodetic datum or spatial reference system upon which the coordinates given in decimal latitude and decimal longitude are based. If not known, use ‘not recorded’, when not known the default WGS 1984 Datum will be used.",
				   'examp' => array( 'WGS84 (for World Geodetic System 1984 – EPSG 4326)' ) ),
			array( 'code' => 'FGPS',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'SITE'.kTOKEN_NAMESPACE_SEPARATOR.'COORD-FARM',
				   'syn' => '4.5.4',
				   'type' => kTYPE_ENUM,
				   'label' => "Geographic data recording system",
				   'descr' => "Data recorded by GPS: Yes or No.",
				   'examp' => array( '10', '20' ) ),
			array( 'code' => 'FRADIALED',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'SITE'.kTOKEN_NAMESPACE_SEPARATOR.'COORD-FARM',
				   'syn' => '4.5.5',
				   'type' => kTYPE_INT32,
				   'label' => "Maximum error distance",
				   'descr' => "To be compiled if the field GPS is ‘No’. The upper limit of the distance (in meters) from the given latitude and longitude describing a circle within which the whole of the described locality must lie.",
				   'examp' => array( '1000', '100000' ) ),
			array( 'code' => 'FELEVATION',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'SITE',
				   'syn' => '4.6',
				   'type' => array( kTYPE_INT32, kTYPE_CARD_REQUIRED ),
				   'label' => "Elevation of farm site",
				   'descr' => "Elevation of farm site expressed in meters above sea level. Negative values are allowed.",
				   'examp' => array( '763', '-35' ) ),
			array( 'code' => 'LRSLATDMS',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'SITE'.kTOKEN_NAMESPACE_SEPARATOR.'COORD-LR',
				   'syn' => '4.7.1',
				   'type' => array( kTYPE_STRING, kTYPE_CARD_REQUIRED ),
				   'label' => "Latitude of LR site",
				   'descr' => "Degrees (2 digits) minutes (2 digits), and seconds (2 digits) followed by N (North) or S (South).",
				   'examp' => array( '45° (i.e. 45 degrees), 4’ (i.e. 4 minutes) and unknown seconds North (Turin latitude) is coded as 450400N', '45°, 4’ and 8’’ (i.e. 8 seconds) North (Turin_Mole Antonelliana latitude) is coded as 450408N', '40° 25’ 6" N (Madrid) is coded as 402506N', '00° 13’ 23’’ S (Quito) is coded as 001323S' ) ),
			array( 'code' => 'LRSLATDD',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'SITE'.kTOKEN_NAMESPACE_SEPARATOR.'COORD-LR',
				   'syn' => '4.7.1bis',
				   'type' => array( kTYPE_FLOAT, kTYPE_CARD_REQUIRED ),
				   'label' => "Latitude of LR site",
				   'descr' => "Latitude expressed in decimal degrees.",
				   'examp' => array( 'the same latitude of Turin_Mole Antonelliana reported above is coded as 45.069031°', 'the Madrid latitude reported above is coded as 40.418446°', 'the Quito latitude reported above is coded as -0.222900°' ) ),
			array( 'code' => 'LRSLONGDMS',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'SITE'.kTOKEN_NAMESPACE_SEPARATOR.'COORD-LR',
				   'syn' => '4.7.2',
				   'type' => array( kTYPE_STRING, kTYPE_CARD_REQUIRED ),
				   'label' => "Longitude of LR site",
				   'descr' => "Degrees (3 digits), minutes (2 digits), and seconds (2 digits) followed by E (East) or W (West).",
				   'examp' => array( '7° 41’ and unknown seconds E (Turin) is coded as 0074100E (2 zeros before the 7 degrees because longitude varies from 0 and 180 degrees and needs 3 digits)', '7° 41’ 36" E (Turin_Mole Antonelliana longitude) is coded as 0074135E', '3°42’ 51" W (Madrid) is coded as 0034251W', '78° 30’ 19’’ W (Quito) is coded as 0783019W' ) ),
			array( 'code' => 'LRSLONGITUDEDD',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'SITE'.kTOKEN_NAMESPACE_SEPARATOR.'COORD-LR',
				   'syn' => '4.7.2bis',
				   'type' => array( kTYPE_FLOAT, kTYPE_CARD_REQUIRED ),
				   'label' => "Longitude of LR site",
				   'descr' => "Longitude expressed in decimal degrees.",
				   'examp' => array( 'the same longitude of Turin_Mole Antonelliana reported above is coded as 7.693154°', 'the same longitude of Madrid reported above is coded as -3.714277°', 'the same longitude of Quito reported above is coded as -78.505386°' ) ),
			array( 'code' => 'LRSEPSGCODE',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'SITE'.kTOKEN_NAMESPACE_SEPARATOR.'COORD-LR',
				   'syn' => '4.7.3',
				   'type' => kTYPE_STRING,
				   'label' => "Geodetic datum",
				   'descr' => "The geodetic datum or spatial reference system upon which the coordinates given in decimal latitude and decimal longitude are based. If not known, use ‘not recorded’, when not known the default WGS 1984 Datum will be used.",
				   'examp' => array( 'WGS84 (for World Geodetic System 1984 – EPSG 4326)' ) ),
			array( 'code' => 'LRSGPS',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'SITE'.kTOKEN_NAMESPACE_SEPARATOR.'COORD-LR',
				   'syn' => '4.7.4',
				   'type' => kTYPE_ENUM,
				   'label' => "Geographic data recording system",
				   'descr' => "Data recorded by GPS: Yes or No.",
				   'examp' => array( '10', '20' ) ),
			array( 'code' => 'LRSRADIALED',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'SITE'.kTOKEN_NAMESPACE_SEPARATOR.'COORD-LR',
				   'syn' => '4.7.5',
				   'type' => kTYPE_INT32,
				   'label' => "Maximum error distance",
				   'descr' => "To be compiled if the field GPS is ‘No’. The upper limit of the distance (in meters) from the given latitude and longitude describing a circle within which the whole of the described locality must lie.",
				   'examp' => array( '1000', '100000' ) ),
			array( 'code' => 'LRSELEVATION',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'SITE',
				   'syn' => '4.8',
				   'type' => array( kTYPE_INT32, kTYPE_CARD_REQUIRED ),
				   'label' => "Elevation of LR site",
				   'descr' => "Elevation of LR site expressed in meters above sea level. Negative values are allowed.",
				   'examp' => array( '763', '-35' ) ) );
		
		//
		// Load data.
		//
		foreach( $params as $param )
		{
			//
			// Set global identifier.
			//
			$id = 'LR'.kTOKEN_NAMESPACE_SEPARATOR.$param[ 'code' ];
			$category = $_SESSION[ 'NODES' ][ $param[ 'parent' ] ];
			
			//
			// Relate to category.
			//
			$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
				//
				// Create node.
				//
				$_SESSION[ 'NODES' ][ $id ]
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewScaleNode(
						$_SESSION[ 'TERMS' ][ $id ]
							//
							// Create term.
							//
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
								$param[ 'code' ],		// Local identifier.
								$namespace,				// Namespace.
								$param[ 'label' ],		// Label or name.
								$param[ 'descr' ],		// Description or definition.
								kDEFAULT_LANGUAGE,		// Language.
								array( kOFFSET_SYNONYMS	// Additional attributes.
											=> array( $param[ 'code' ], $param[ 'syn' ] ),
										kTOKEN_NAMESPACE_SEPARATOR.kONTOLOGY_DEFAULT_EXAMPLES
											=> $param[ 'examp' ] ) ),
						$param[ 'type' ] ),				// Node data type.
				$category );							// Object vertex node.
			
			//
			// Create tag.
			//
			$_SESSION[ 'TAGS' ][ $id ] = NULL;
			$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag(
				$_SESSION[ 'TAGS' ][ $id ], $_SESSION[ 'NODES' ][ $id ] );
			$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag(
				$_SESSION[ 'TAGS' ][ $id ], TRUE );
			
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - $id ["
					 .$_SESSION[ 'NODES' ][ $id ]
					 ."] ("
					 .$_SESSION[ 'TAGS' ][ $id ][ kOFFSET_NID ]
					 .")\n" );
		}

		//
		// Init site enumerations storage.
		//
		$params = array(
			array( 'code' => '10',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'FGPS',
				   'syn' => '10',
				   'label' => "Yes",
				   'descr' => "Yes." ),
			array( 'code' => '20',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'FGPS',
				   'syn' => '20',
				   'label' => "No",
				   'descr' => "No." ),
			array( 'code' => '10',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSGPS',
				   'syn' => '10',
				   'label' => "Yes",
				   'descr' => "Yes." ),
			array( 'code' => '20',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSGPS',
				   'syn' => '20',
				   'label' => "No",
				   'descr' => "No." ) );
		
		//
		// Create landrace categories.
		//
		foreach( $params as $param )
		{
			//
			// Set global identifier.
			//
			$namespace = $_SESSION[ 'TERMS' ][ $param[ 'parent' ] ];
			$trait = $_SESSION[ 'NODES' ][ $param[ 'parent' ] ];
			$id = $param[ 'parent' ].kTOKEN_NAMESPACE_SEPARATOR.$param[ 'code' ];
			
			//
			// Relate to root.
			//
			$_SESSION[ kSESSION_ONTOLOGY ]->EnumOf(
				//
				// Create node.
				//
				$_SESSION[ 'NODES' ][ $id ]
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewEnumerationNode(
						//
						// Create term.
						//
						$_SESSION[ 'TERMS' ][ $id ]
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
								$param[ 'code' ],		// Local identifier.
								$namespace,				// Namespace.
								$param[ 'label' ],		// Label or name.
								$param[ 'descr' ],		// Description or definition.
								kDEFAULT_LANGUAGE ) ),	// Language.
				$trait );
	
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - $id [".$_SESSION[ 'NODES' ][ $id ]."]\n" );
		}

	} // LoadLandraceSiteTraits.


?>

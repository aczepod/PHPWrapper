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

//
// Local includes.
//
require_once( 'LandracesPassport.inc.php' );

		

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
		$node = $_SESSION[ kSESSION_ONTOLOGY ]->NewRootNode(
			$term = $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
						kLR_ROOT,
						NULL,
						"DESCRIPTORS FOR WEB-ENABLED NATIONAL IN SITU LANDRACE INVENTORIES",
						"Descriptors For Web-Enabled National In Situ Landrace (LR) Inventories",
						kDEFAULT_LANGUAGE,
						array( kTAG_SYNONYMS => array( kLR_ROOT ),
							   kTAG_AUTHORS => array( 'V. Negri', 'N. Maxted', 'R. Torricelli', 'M. Heinonen', 'M. Vetelainen', 'S. Dias' ),
							   kTAG_NOTES => "Landraces are part of agro-biodiversity in urgent need of conservation. A prerequisite of any active conservation is some form of inventory of what is conserved.\n\nIn this context, the EC Framework 7 PGR Secure project is aimed to provide help in generating National Landrace Inventories in European countries and so to begin the process of creating a European Landrace Inventory pivoted on the National Inventories.\n\nA European LR Inventory can only be based on National Inventories considered that the responsibility to conserve and sustainably use landrace diversity (as well as any other biodiversity component) lies with individual Nations and that any concerted action will be implemented at national level, even when driven by policy at European level.\n\nThis draft descriptor list was worked out to facilitate the development of National Inventories of landraces that are still maintained in situ (i.e. on farm or in garden).\n\nIt was drafted to record different types of information that were discussed at the “Crop Wild Relative and Landrace Conservation Training Workshop” held in Palanga Lithuania, 7-9 September 2011 by the in situ National Inventory Focal Points, the ECPGR Documentation and Information Network members and the PGR Secure team working on landraces.\n\nHowever, it also takes into account the contribution that the ECPGR On-farm Conservation and Management Working Group of the In Situ and On-Farm Conservation Network gave through years to the definition of descriptors for extant landraces (see draft descriptor list downloadable from http://www.ecpgr.cgiar.org/networks/in_situ_and_on_farm/on_farm_wg.html).\n\nThe draft descriptor list includes fields related to the Inventory, taxon, landrace, site and farmer identification, the landrace status, characteristics and use and finally fields concerning conservation and monitoring actions eventually taken in favour of the landrace diversity maintenance.",
							   kTAG_ACKNOWLEDGMENTS => "Thanks are due to Adriana Alercia (Bioversity International, Rome), Theo van Hintum (Centre for Genetic Resources _ Wageningen University and Research Centre, the Netherlands) and Lorenzo Maggioni (ECPGR Secretariat, Rome) for helpful suggestions and comments.",
							   kTAG_BIBLIOGRAPHY => "Bioversity and The Christensen Fund, 2009. Descriptors for farmer’s knowledge of plants. Bioversity International, Rome, Italy and The Christensen Fund, Palo Alto, California, USA."
						)
					)
				);

		//
		// Inform.
		//
		if( kOPTION_VERBOSE )
			echo( "    - ".$term->GID()." [".$node[ kTAG_NID ]."]\n" );

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
		// Get namespace.
		//
		$root
			= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode(
				$namespace
					= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
						kLR_ROOT,
						NULL,
						TRUE ),
				TRUE )[ 0 ]	;
		
		//
		// Init top level storage.
		//
		$params = array(
			array( 'code' => substr( KLR_INVENTORY, 3 ),
				   'syn' => '1',
				   'label' => "INVENTORY IDENTIFICATION",
				   'descr' => "Descriptors identifying the inventory and origin of the landrace or population." ),
			array( 'code' => substr( KLR_TAXONOMY, 3 ),
				   'syn' => '2',
				   'label' => "TAXON IDENTIFICATION",
				   'descr' => "Descriptors identifying the scientific nomenclature of the landrace or population." ),
			array( 'code' => substr( KLR_IDENTIFICATION, 3 ),
				   'syn' => '3',
				   'label' => "LANDRACE/POPULATION IDENTIFICATION",
				   'descr' => "Descriptors identifying the specific landrace or population." ),
			array( 'code' => substr( KLR_SITE, 3 ),
				   'syn' => '4',
				   'label' => "SITE/LOCATION IDENTIFICATION",
				   'descr' => "Descriptors identifying the location of the landrace or population." ),
			array( 'code' => substr( KLR_MAINTAINER, 3 ),
				   'syn' => '5',
				   'label' => "THE FARMER (I.E. THE MAINTAINER)",
				   'descr' => "Descriptors identifying the maintainer of the landrace or population." ),
			array( 'code' => substr( KLR_LANDRACE, 3 ),
				   'syn' => '6',
				   'label' => "THE LANDRACE",
				   'descr' => "Descriptors describing the landrace." ),
			array( 'code' => substr( KLR_MONITOR, 3 ),
				   'syn' => '7',
				   'label' => "CONSERVATION AND MONITORING",
				   'descr' => "Descriptors covering conservation and maintenance of the landrace or population." )
		);
		
		//
		// Create landrace categories.
		//
		foreach( $params as $param )
		{
			//
			// Relate to root.
			//
			$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
				$node
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
						$term
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
								$param[ 'code' ],		// Local identifier.
								$namespace,				// Namespace.
								$param[ 'label' ],		// Label or name.
								$param[ 'descr' ],		// Description or definition.
								kDEFAULT_LANGUAGE,		// Language.
								// Additional attributes.
								array( kTAG_SYNONYMS => array( $param[ 'code' ], $param[ 'syn' ] )
							)
						)
					),
				$root );
			
			//
			// Save site node.
			//
			if( $param[ 'code' ] == substr( KLR_SITE, 3 ) )
			{
				$save_term = $term;
				$save_node = $node;
			}
	
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - ".$term->GID()." [".$node[ kTAG_NID ]."]\n" );
		}

		//
		// Get site category.
		//
		$root = $save_node;
		$namespace = $save_term;

		//
		// Create site subcategories.
		//
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
			$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
				$node
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
						$term
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
								$param[ 'code' ],		// Local identifier.
								$namespace,				// Namespace.
								$param[ 'label' ],		// Label or name.
								$param[ 'descr' ],		// Description or definition.
								kDEFAULT_LANGUAGE,		// Language.
								// Additional attributes.
								array( kTAG_SYNONYMS => array( $param[ 'code' ], $param[ 'syn' ] )
							)
						)
					),
				$root );
	
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - ".$term->GID()." [".$node[ kTAG_NID ]."]\n" );
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
		// Get namespace.
		//
		$namespace
			= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
				kLR_ROOT,
				NULL,
				TRUE );
		
		//
		// Get category.
		//
		$category
			= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode(
				$_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					KLR_INVENTORY,
					NULL,
					TRUE ),
				TRUE )[ 0 ]	;
		
		//
		// Init local storage.
		//
		$params = array(
			array( 'code' => 'NICODE',
				   'syn' => '1.1',
				   'type' => array( kTYPE_STRING, kTYPE_REQUIRED ),
				   'label' => "National Inventory code",
				   'descr' => "Country code identifying the National in situ LR Inventory; the code of the country preparing the National Inventory. For country codes use the three-letter ISO 3166-1 (see: http://unstats.un.org/unsd/methods/m49/m49alpha.htm).",
				   'examp' => array( 'NLD' ) ),
			array( 'code' => 'NIENUMB',
				   'syn' => '1.2',
				   'type' => array( kTYPE_STRING, kTYPE_REQUIRED ),
				   'label' => "National Inventory edition number",
				   'descr' => "Code identifying the edition of the National in situ LR Inventory made up of the edition number and the year of publication.",
				   'examp' => array( 'the first edition that is compiled in 2012 will be coded as 001/2012', 'the second edition that is compiled in 2014 will be coded 002/2014' ) ),
			array( 'code' => 'INSTCODE',
				   'syn' => '1.3',
				   'type' => array( kTYPE_STRING, kTYPE_REQUIRED ),
				   'label' => "Institute code",
				   'descr' => "FAO WIEWS code of the institute (see: http://apps3.fao.org/wiews/institute_query.htm?i_l=EN) who is responsible at the national level for the production of the National in situ LR Inventory.",
				   'examp' => array( 'NLD037' ) ) );
		
		//
		// Load data.
		//
		foreach( $params as $param )
		{
			//
			// Relate to category.
			//
			$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
				$node
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
						$term
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
								$param[ 'code' ],		// Local identifier.
								$namespace,				// Namespace.
								$param[ 'label' ],		// Label or name.
								$param[ 'descr' ],		// Description or definition.
								kDEFAULT_LANGUAGE,		// Language.
								// Additional attributes.
								array( kTAG_SYNONYMS => array( $param[ 'code' ], $param[ 'syn' ] ),
									   kTAG_EXAMPLES => $param[ 'examp' ] ) ),
						array( kKIND_FEATURE, kKIND_SCALE ),
						$param[ 'type' ] ),				// Node data type.
				$category );
			
			//
			// Create tag.
			//
			$tag = NULL;
			$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag( $tag, $node );
			$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag( $tag, TRUE );
			
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - ".$term->GID()." ["
							  .$node[ kTAG_NID ]."] ("
							  .$tag[ kTAG_NID ].")\n" );
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
		// Get namespace.
		//
		$namespace
			= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
				kLR_ROOT,
				NULL,
				TRUE );
		
		//
		// Get category.
		//
		$category
			= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode(
				$_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					KLR_TAXONOMY,
					NULL,
					TRUE ),
				TRUE )[ 0 ]	;
		
		//
		// Init local storage.
		//
		$params = array(
			array( 'code' => 'GENUS',
				   'syn' => '2.1',
				   'type' => array( kTYPE_STRING, kTYPE_REQUIRED ),
				   'label' => "Genus",
				   'descr' => "Genus name for taxon, in Latin. Initial uppercase letter required.",
				   'examp' => array( 'Vigna', 'Vicia' ) ),
			array( 'code' => 'SPECIES',
				   'syn' => '2.2',
				   'type' => array( kTYPE_STRING, kTYPE_REQUIRED ),
				   'label' => "Species",
				   'descr' => "Specific epithet portion of the scientific name, in Latin, in lower case letters.",
				   'examp' => array( 'unguiculata', 'faba' ) ),
			array( 'code' => 'SPAUTHOR',
				   'syn' => '2.3',
				   'type' => array( kTYPE_STRING, kTYPE_REQUIRED ),
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
				   'type' => array( kTYPE_STRING, kTYPE_ARRAY ),
				   'label' => "Taxonomic references",
				   'descr' => "Taxonomy used by Inventory compiler to identify the material (e.g.. The Plant List, Euro+Med PlantBase, GRIN taxonomy, etc).",
				   'examp' => array( 'The Plant List', 'GRIN Taxonomy' ) ),
			array( 'code' => 'CROPNAME)',
				   'syn' => '2.7',
				   'type' => array( kTYPE_STRING, kTYPE_ARRAY ),
				   'label' => "Common crop name",
				   'descr' => "Name of the crop in colloquial language, preferably English if any.",
				   'examp' => array( 'yard–long-bean', 'tick-bean' ) ) );
		
		//
		// Load data.
		//
		foreach( $params as $param )
		{
			//
			// Relate to category.
			//
			$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
				$node
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
						$term
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
								$param[ 'code' ],		// Local identifier.
								$namespace,				// Namespace.
								$param[ 'label' ],		// Label or name.
								$param[ 'descr' ],		// Description or definition.
								kDEFAULT_LANGUAGE,		// Language.
								// Additional attributes.
								array( kTAG_SYNONYMS => array( $param[ 'code' ], $param[ 'syn' ] ),
									   kTAG_EXAMPLES => $param[ 'examp' ] ) ),
						array( kKIND_FEATURE, kKIND_SCALE ),
						$param[ 'type' ] ),				// Node data type.
				$category );
			
			//
			// Create tag.
			//
			$tag = NULL;
			$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag( $tag, $node );
			$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag( $tag, TRUE );
			
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - ".$term->GID()." ["
							  .$node[ kTAG_NID ]."] ("
							  .$tag[ kTAG_NID ].")\n" );
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
		// Get namespace.
		//
		$namespace
			= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
				kLR_ROOT,
				NULL,
				TRUE );
		
		//
		// Get category.
		//
		$category
			= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode(
				$_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					KLR_IDENTIFICATION,
					NULL,
					TRUE ),
				TRUE )[ 0 ]	;
		
		//
		// Init local storage.
		//
		$params = array(
			array( 'code' => 'LRRECDATE',
				   'syn' => '3.1',
				   'type' => kTYPE_DATE_STRING,
				   'label' => "Landrace in situ recording date",
				   'descr' => "Date on which the LR was recorded in the current in situ Inventory, as YYYYMMDD. Missing data (MM or DD) should be indicated with zeros. Leading zeros are required.",
				   'examp' => array( '19980000', '20020620' ) ),
			array( 'code' => 'LRNUMB',
				   'syn' => '3.2',
				   'type' => array( kTYPE_STRING, kTYPE_REQUIRED ),
				   'label' => "Landrace number",
				   'descr' => "Unique progressive number which identifies the in situ LR in the Inventory, not to be duplicated (i.e. reassigned) for other LRs or the same LR that is cultivated by other farmers in the current Inventory. To be assigned by the institute which is responsible at the national level for the production of the National LR in situ Inventory.",
				   'examp' => array( '00010' ) ),
			array( 'code' => 'LRNAME',
				   'syn' => '3.3',
				   'type' => array( kTYPE_STRING, kTYPE_REQUIRED ),
				   'label' => "Landrace local names",
				   'descr' => "Local name/s of the LR in the colloquial language of the farm. Free text.",
				   'examp' => array( 'fagiolina, cornetti, fagiolino dall’occhio' ) ),
			array( 'code' => 'LRLANG',
				   'syn' => '3.4',
				   'type' => kTYPE_ENUM,
				   'label' => "Landrace language codes",
				   'descr' => "The language code of the LR local name. Use ISO 639-2 is the alpha-3 code in Codes for the representation of names of languages (see: http://www.loc.gov/standards/iso639- 2/php/code_list.php).",
				   'examp' => array( 'en', 'fra', 'ita' ) ) );
		
		//
		// Load data.
		//
		foreach( $params as $param )
		{
			//
			// Relate to category.
			//
			$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
				$node
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
						$term
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
								$param[ 'code' ],		// Local identifier.
								$namespace,				// Namespace.
								$param[ 'label' ],		// Label or name.
								$param[ 'descr' ],		// Description or definition.
								kDEFAULT_LANGUAGE,		// Language.
								// Additional attributes.
								array( kTAG_SYNONYMS => array( $param[ 'code' ], $param[ 'syn' ] ),
									   kTAG_EXAMPLES => $param[ 'examp' ] ) ),
						array( kKIND_FEATURE, kKIND_SCALE ),
						$param[ 'type' ] ),				// Node data type.
				$category );
			
			//
			// Create tag.
			//
			$tag = NULL;
			$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag( $tag, $node );
			$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag( $tag, TRUE );
			
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - ".$term->GID()." ["
							  .$node[ kTAG_NID ]."] ("
							  .$tag[ kTAG_NID ].")\n" );
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
		// Get namespace.
		//
		$namespace
			= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
				kLR_ROOT,
				NULL,
				TRUE );
		
		//
		// Init local storage.
		//
		$params = array(
			array( 'code' => 'FARMFIRSTADMIN',
				   'parent' => KLR_SITE,
				   'syn' => '4.1',
				   'type' => kTYPE_STRING,
				   'label' => "Farm location: primary administrative subdivision of the country where farm is located",
				   'descr' => "Name of the primary administrative subdivision of the country where the farm is located for the most part of its extension. Free text.",
				   'examp' => array( 'Umbria Region' ) ),
			array( 'code' => 'FARMSECONDADMIN',
				   'parent' => KLR_SITE,
				   'syn' => '4.2',
				   'type' => kTYPE_STRING,
				   'label' => "Farm location: secondary administrative subdivision",
				   'descr' => "Name of the secondary administrative subdivision (within the primary administrative subdivision) of the country where the farm is located. Free text.",
				   'examp' => array( 'Perugia Province' ) ),
			array( 'code' => 'FARMLOWESTADMIN',
				   'parent' => KLR_SITE,
				   'syn' => '4.3',
				   'type' => kTYPE_STRING,
				   'label' => "Farm location: lowest administrative subdivision",
				   'descr' => "Name of the lowest administrative subdivision (i.e. municipality). Free text.",
				   'examp' => array( 'Panicale municipality' ) ),
			array( 'code' => 'LOCATION',
				   'parent' => KLR_SITE,
				   'syn' => '4.4',
				   'type' => kTYPE_STRING,
				   'label' => "Location of the nearest known place",
				   'descr' => "Information relevant to the nearest known place, distance from nearest named place, and directions from the nearest named place. Descriptive field as detailed as possible. Free text.",
				   'examp' => array( '7 km south of Panicale towards Perugia on SS.74' ) ),
			array( 'code' => 'FLATDMS',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR,
				   						array( KLR_SITE, 'COORD-FARM' ) ),
				   'syn' => '4.5.1',
				   'type' => array( kTYPE_STRING, kTYPE_REQUIRED ),
				   'label' => "Latitude of farm site",
				   'descr' => "Degrees (2 digits) minutes (2 digits), and seconds (2 digits) followed by N (North) or S (South). Every missing digit (minutes or seconds) should be indicated with a zero. Leading zeros are also required for figures that are lower than ten.",
				   'examp' => array( '45° (i.e. 45 degrees), 4’ (i.e. 4 minutes) and unknown seconds North (Turin latitude) is coded as 450400N', '45°, 4’ and 8’’ (i.e. 8 seconds) North (Turin_Mole Antonelliana latitude) is coded as 450408N', '40° 25’ 6" N (Madrid) is coded as 402506N', '00° 13’ 23’’ S (Quito) is coded as 001323S' ) ),
			array( 'code' => 'FLATDD',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR,
				   						array( KLR_SITE, 'COORD-FARM' ) ),
				   'syn' => '4.5.1bis',
				   'type' => array( kTYPE_FLOAT, kTYPE_REQUIRED ),
				   'label' => "Latitude of farm site",
				   'descr' => "Latitude expressed in decimal degrees. Degree measurements should be written with decimal places like 45.069031° with the degree symbol behind the decimals. Every missing digit should be indicated with a zero. Positive values are North of the Equator; negative values are South of the Equator.",
				   'examp' => array( 'the same latitude of Turin_Mole Antonelliana reported above is coded as 45.069031°', 'the Madrid latitude reported above is coded as 40.418446°', 'the Quito latitude reported above is coded as -0.222900°' ) ),
			array( 'code' => 'FLONGDMS',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR,
				   						array( KLR_SITE, 'COORD-FARM' ) ),
				   'syn' => '4.5.2',
				   'type' => array( kTYPE_STRING, kTYPE_REQUIRED ),
				   'label' => "Longitude of farm site",
				   'descr' => "Degrees (3 digits), minutes (2 digits), and seconds (2 digits) followed by E (East) or W (West). Every missing digit (minutes or seconds) should be indicated with a zero. Leading zeros are also required for figures lower than ten.",
				   'examp' => array( '7° 41’ and unknown seconds E (Turin) is coded as 0074100E (2 zeros before the 7 degrees because longitude varies from 0 and 180 degrees and needs 3 digits)', '7° 41’ 36" E (Turin_Mole Antonelliana longitude) is coded as 0074135E', '3°42’ 51" W (Madrid) is coded as 0034251W', '78° 30’ 19’’ W (Quito) is coded as 0783019W' ) ),
			array( 'code' => 'FLONGDD',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR,
				   						array( KLR_SITE, 'COORD-FARM' ) ),
				   'syn' => '4.5.2bis',
				   'type' => array( kTYPE_FLOAT, kTYPE_REQUIRED ),
				   'label' => "Longitude of farm site",
				   'descr' => "Longitude expressed in decimal degrees. Degree measurements should be written with decimal places like 74.044636° with the degree symbol behind the decimals. Every missing digit should be indicated with a zero. Positive values are East of the Greenwich Meridian; negative values are West of the Greenwich Meridian.",
				   'examp' => array( 'the same longitude of Turin_Mole Antonelliana reported above is coded as 7.693154°', 'the same longitude of Madrid reported above is coded as -3.714277°', 'the same longitude of Quito reported above is coded as -78.505386°' ) ),
			array( 'code' => 'FEPSGCODE',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR,
				   						array( KLR_SITE, 'COORD-FARM' ) ),
				   'syn' => '4.5.3',
				   'type' => kTYPE_STRING,
				   'label' => "Geodetic datum",
				   'descr' => "The geodetic datum or spatial reference system upon which the coordinates given in decimal latitude and decimal longitude are based. If not known, use ‘not recorded’, when not known the default WGS 1984 Datum will be used.",
				   'examp' => array( 'WGS84 (for World Geodetic System 1984 – EPSG 4326)' ) ),
			array( 'code' => 'FGPS',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR,
				   						array( KLR_SITE, 'COORD-FARM' ) ),
				   'syn' => '4.5.4',
				   'type' => kTYPE_ENUM,
				   'label' => "Geographic data recording system",
				   'descr' => "Data recorded by GPS: Yes or No.",
				   'examp' => array( '10', '20' ) ),
			array( 'code' => 'FRADIALED',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR,
				   						array( KLR_SITE, 'COORD-FARM' ) ),
				   'syn' => '4.5.5',
				   'type' => kTYPE_INT32,
				   'label' => "Maximum error distance",
				   'descr' => "To be compiled if the field GPS is ‘No’. The upper limit of the distance (in meters) from the given latitude and longitude describing a circle within which the whole of the described locality must lie.",
				   'examp' => array( '1000', '100000' ) ),
			array( 'code' => 'FELEVATION',
				   'parent' => KLR_SITE,
				   'syn' => '4.6',
				   'type' => array( kTYPE_INT32, kTYPE_REQUIRED ),
				   'label' => "Elevation of farm site",
				   'descr' => "Elevation of farm site expressed in meters above sea level. Negative values are allowed.",
				   'examp' => array( '763', '-35' ) ),
			array( 'code' => 'LRSLATDMS',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR,
				   						array( KLR_SITE, 'COORD-LR' ) ),
				   'syn' => '4.7.1',
				   'type' => array( kTYPE_STRING, kTYPE_REQUIRED ),
				   'label' => "Latitude of LR site",
				   'descr' => "Degrees (2 digits) minutes (2 digits), and seconds (2 digits) followed by N (North) or S (South).",
				   'examp' => array( '45° (i.e. 45 degrees), 4’ (i.e. 4 minutes) and unknown seconds North (Turin latitude) is coded as 450400N', '45°, 4’ and 8’’ (i.e. 8 seconds) North (Turin_Mole Antonelliana latitude) is coded as 450408N', '40° 25’ 6" N (Madrid) is coded as 402506N', '00° 13’ 23’’ S (Quito) is coded as 001323S' ) ),
			array( 'code' => 'LRSLATDD',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR,
				   						array( KLR_SITE, 'COORD-LR' ) ),
				   'syn' => '4.7.1bis',
				   'type' => array( kTYPE_FLOAT, kTYPE_REQUIRED ),
				   'label' => "Latitude of LR site",
				   'descr' => "Latitude expressed in decimal degrees.",
				   'examp' => array( 'the same latitude of Turin_Mole Antonelliana reported above is coded as 45.069031°', 'the Madrid latitude reported above is coded as 40.418446°', 'the Quito latitude reported above is coded as -0.222900°' ) ),
			array( 'code' => 'LRSLONGDMS',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR,
				   						array( KLR_SITE, 'COORD-LR' ) ),
				   'syn' => '4.7.2',
				   'type' => array( kTYPE_STRING, kTYPE_REQUIRED ),
				   'label' => "Longitude of LR site",
				   'descr' => "Degrees (3 digits), minutes (2 digits), and seconds (2 digits) followed by E (East) or W (West).",
				   'examp' => array( '7° 41’ and unknown seconds E (Turin) is coded as 0074100E (2 zeros before the 7 degrees because longitude varies from 0 and 180 degrees and needs 3 digits)', '7° 41’ 36" E (Turin_Mole Antonelliana longitude) is coded as 0074135E', '3°42’ 51" W (Madrid) is coded as 0034251W', '78° 30’ 19’’ W (Quito) is coded as 0783019W' ) ),
			array( 'code' => 'LRSLONGITUDEDD',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR,
				   						array( KLR_SITE, 'COORD-LR' ) ),
				   'syn' => '4.7.2bis',
				   'type' => array( kTYPE_FLOAT, kTYPE_REQUIRED ),
				   'label' => "Longitude of LR site",
				   'descr' => "Longitude expressed in decimal degrees.",
				   'examp' => array( 'the same longitude of Turin_Mole Antonelliana reported above is coded as 7.693154°', 'the same longitude of Madrid reported above is coded as -3.714277°', 'the same longitude of Quito reported above is coded as -78.505386°' ) ),
			array( 'code' => 'LRSEPSGCODE',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR,
				   						array( KLR_SITE, 'COORD-LR' ) ),
				   'syn' => '4.7.3',
				   'type' => kTYPE_STRING,
				   'label' => "Geodetic datum",
				   'descr' => "The geodetic datum or spatial reference system upon which the coordinates given in decimal latitude and decimal longitude are based. If not known, use ‘not recorded’, when not known the default WGS 1984 Datum will be used.",
				   'examp' => array( 'WGS84 (for World Geodetic System 1984 – EPSG 4326)' ) ),
			array( 'code' => 'LRSGPS',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR,
				   						array( KLR_SITE, 'COORD-LR' ) ),
				   'syn' => '4.7.4',
				   'type' => kTYPE_ENUM,
				   'label' => "Geographic data recording system",
				   'descr' => "Data recorded by GPS: Yes or No.",
				   'examp' => array( '10', '20' ) ),
			array( 'code' => 'LRSRADIALED',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR,
				   						array( KLR_SITE, 'COORD-LR' ) ),
				   'syn' => '4.7.5',
				   'type' => kTYPE_INT32,
				   'label' => "Maximum error distance",
				   'descr' => "To be compiled if the field GPS is ‘No’. The upper limit of the distance (in meters) from the given latitude and longitude describing a circle within which the whole of the described locality must lie.",
				   'examp' => array( '1000', '100000' ) ),
			array( 'code' => 'LRSELEVATION',
				   'parent' => KLR_SITE,
				   'syn' => '4.8',
				   'type' => array( kTYPE_INT32, kTYPE_REQUIRED ),
				   'label' => "Elevation of LR site",
				   'descr' => "Elevation of LR site expressed in meters above sea level. Negative values are allowed.",
				   'examp' => array( '763', '-35' ) ) );
		
		//
		// Load data.
		//
		foreach( $params as $param )
		{
			//
			// Get category.
			//
			$category
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode(
					$_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
						$param[ 'parent' ],
						NULL,
						TRUE ),
					TRUE )[ 0 ]	;
			
			//
			// Relate to category.
			//
			$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
				$node
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
						$term
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
								$param[ 'code' ],		// Local identifier.
								$namespace,				// Namespace.
								$param[ 'label' ],		// Label or name.
								$param[ 'descr' ],		// Description or definition.
								kDEFAULT_LANGUAGE,		// Language.
								// Additional attributes.
								array( kTAG_SYNONYMS => array( $param[ 'code' ], $param[ 'syn' ] ),
									   kTAG_EXAMPLES => $param[ 'examp' ] ) ),
						array( kKIND_FEATURE, kKIND_SCALE ),
						$param[ 'type' ] ),				// Node data type.
				$category );
			
			//
			// Create tag.
			//
			$tag = NULL;
			$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag( $tag, $node );
			$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag( $tag, TRUE );
			
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - ".$term->GID()." ["
							  .$node[ kTAG_NID ]."] ("
							  .$tag[ kTAG_NID ].")\n" );
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
			// Get namespace.
			//
			$namespace
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					$param[ 'parent' ],
					NULL,
					TRUE );
			
			//
			// Get trait.
			//
			$trait
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode(
					$_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
						$namespace,
						NULL,
						TRUE ),
					TRUE )[ 0 ]	;
			
			//
			// Relate to trait.
			//
			$_SESSION[ kSESSION_ONTOLOGY ]->EnumOf(
				$node
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
						$term
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
				echo( "    - ".$term->GID()." [".$node[ kTAG_NID ]."]\n" );
		}

	} // LoadLandraceSiteTraits.

	 
	/*===================================================================================
	 *	LoadLandraceMaintainerTraits													*
	 *==================================================================================*/

	/**
	 * <h4>Load landrace maintainer traits</h4>
	 *
	 * This method will create the landrace farmer or maintainer trait nodes and relate them
	 * to their category.
	 */
	function LoadLandraceMaintainerTraits()
	{
		//
		// Get namespace.
		//
		$namespace
			= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
				kLR_ROOT,
				NULL,
				TRUE );
		
		//
		// Init local storage.
		//
		$params = array(
			array( 'code' => 'FARMERID',
				   'parent' => KLR_MAINTAINER,
				   'syn' => '5.1',
				   'type' => kTYPE_STRING,
				   'label' => "Farmer identification number",
				   'descr' => "Unique number identifier of the farmer who maintains the LR and provides information (Landrace maintainer unique ID to be held in database). It is assigned by the institute that is responsible at the national level for the production of the National LR in situ Inventory. This number should not be duplicated or reassigned to other unit. This number should be composed of the ‘National Inventory Code (NICODE 1.1.)’ + ’National Inventory Edition Number (1.2.NIENUMB)’ + ’Landrace number (3.2. LRNUMB)’.",
				   'examp' => array( 'NLD001/201200010' ) ),
			array( 'code' => 'FARMERYB',
				   'parent' => KLR_MAINTAINER,
				   'syn' => '5.2',
				   'type' => kTYPE_STRING,
				   'label' => "Farmer year of birth",
				   'descr' => "Recorded as YYYY. If not certain, indicate that this is an estimate in REMARKS.",
				   'examp' => array( '1957' ) ),
			array( 'code' => 'FARMHT',
				   'parent' => KLR_MAINTAINER,
				   'syn' => '5.3',
				   'type' => kTYPE_ENUM_SET,
				   'label' => "Holding/tenancy of the farm/estate",
				   'descr' => "Multiple choices are allowed since the farm can be made of several types of holdings. Multiple choices are allowed separated by a semicolon (;) without space.",
				   'examp' => array( '10;30' ) ),
			array( 'code' => 'FIR',
				   'parent' => KLR_MAINTAINER,
				   'syn' => '5.4',
				   'type' => kTYPE_ENUM,
				   'label' => "Farmer identification restrictions",
				   'descr' => "Restriction in making the above mentioned (i.e. 5.2. and 5.3.) farmer data publicly available: ‘Yes’ or ‘No’. If ‘No’ only FARMERID (5.1) will be public.",
				   'examp' => array( '10' ) ) );
		
		//
		// Load data.
		//
		foreach( $params as $param )
		{
			//
			// Get category.
			//
			$category
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode(
					$_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
						$param[ 'parent' ],
						NULL,
						TRUE ),
					TRUE )[ 0 ]	;
			
			//
			// Relate to category.
			//
			$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
				$node
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
						$term
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
								$param[ 'code' ],		// Local identifier.
								$namespace,				// Namespace.
								$param[ 'label' ],		// Label or name.
								$param[ 'descr' ],		// Description or definition.
								kDEFAULT_LANGUAGE,		// Language.
								// Additional attributes.
								array( kTAG_SYNONYMS => array( $param[ 'code' ], $param[ 'syn' ] ),
									   kTAG_EXAMPLES => $param[ 'examp' ] ) ),
						array( kKIND_FEATURE, kKIND_SCALE ),
						$param[ 'type' ] ),				// Node data type.
				$category );
			
			//
			// Create tag.
			//
			$tag = NULL;
			$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag( $tag, $node );
			$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag( $tag, TRUE );
			
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - ".$term->GID()." ["
							  .$node[ kTAG_NID ]."] ("
							  .$tag[ kTAG_NID ].")\n" );
		}

		//
		// Init site enumerations storage.
		//
		$params = array(
			array( 'code' => '10',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'FARMHT',
				   'syn' => '10',
				   'label' => "Owner",
				   'descr' => "Owner." ),
			array( 'code' => '20',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'FARMHT',
				   'syn' => '20',
				   'label' => "Tenant",
				   'descr' => "Tenant." ),
			array( 'code' => '30',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'FARMHT',
				   'syn' => '30',
				   'label' => "Life tenant",
				   'descr' => "Life tenant." ),
			array( 'code' => '40',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'FARMHT',
				   'syn' => '40',
				   'label' => "Cultivating public land",
				   'descr' => "Cultivating public land." ),
			array( 'code' => '99',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'FARMHT',
				   'syn' => '99',
				   'label' => "Other",
				   'descr' => "Other (elaborate in REMARKS)." ),
			array( 'code' => '10',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'FIR',
				   'syn' => '10',
				   'label' => "Yes",
				   'descr' => "Yes." ),
			array( 'code' => '20',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'FIR',
				   'syn' => '20',
				   'label' => "No",
				   'descr' => "No." ) );
		
		//
		// Create landrace categories.
		//
		foreach( $params as $param )
		{
			//
			// Get namespace.
			//
			$namespace
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					$param[ 'parent' ],
					NULL,
					TRUE );
			
			//
			// Get trait.
			//
			$trait
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode(
					$_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
						$namespace,
						NULL,
						TRUE ),
					TRUE )[ 0 ]	;
			
			//
			// Relate to trait.
			//
			$_SESSION[ kSESSION_ONTOLOGY ]->EnumOf(
				$node
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
						$term
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
				echo( "    - ".$term->GID()." [".$node[ kTAG_NID ]."]\n" );
		}

	} // LoadLandraceMaintainerTraits.

	 
	/*===================================================================================
	 *	LoadLandraceLandraceTraits														*
	 *==================================================================================*/

	/**
	 * <h4>Load landrace description traits</h4>
	 *
	 * This method will create the landrace description trait nodes and relate them to their
	 * category.
	 */
	function LoadLandraceLandraceTraits()
	{
		//
		// Get namespace.
		//
		$namespace
			= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
				kLR_ROOT,
				NULL,
				TRUE );
		
		//
		// Init local storage.
		//
		$params = array(
			array( 'code' => 'LRTOTAREA',
				   'parent' => KLR_LANDRACE,
				   'syn' => '6.1',
				   'type' => kTYPE_FLOAT,
				   'label' => "Landrace total area",
				   'descr' => "The total area (ha) cultivated under the inventoried LR on that farm as from farmer statement.",
				   'examp' => array( '125.7' ) ),
			array( 'code' => 'LRCULTPER',
				   'parent' => KLR_LANDRACE,
				   'syn' => '6.2',
				   'type' => array( kTYPE_ENUM, kTYPE_REQUIRED ),
				   'label' => "Landrace cultivation period",
				   'descr' => "The length of time the LR was cultivated on that farm as from farmer memory, i.e. cultivated for an unknown number of years, over 50 years, less than 50 years; in the latter case it can be specified the time.",
				   'examp' => array( '20' ) ),
			array( 'code' => 'LRSTATUS',
				   'parent' => KLR_LANDRACE,
				   'syn' => '6.3',
				   'type' => kTYPE_ENUM,
				   'label' => "Landrace status",
				   'descr' => "The status of the LR on that farm, i.e. whether inherent the farm or reintroduced in the farm as from farmer statement. For ‘inherent the farm’ a cultivation period over 25 years in that farm should be intended. If introduced/reintroduced from other farms it can be specified from where. To be eventually elaborated in REMARKS.",
				   'examp' => array( '30' ) ),
			array( 'code' => 'LRSSS',
				   'parent' => KLR_LANDRACE,
				   'syn' => '6.4',
				   'type' => array( kTYPE_ENUM, kTYPE_REQUIRED ),
				   'label' => "Landrace seed/propagation material supply system",
				   'descr' => "From where the seed (or propagation material in general) initially came, as from farmer statement.",
				   'examp' => array( '20' ) ),
			array( 'code' => 'LRCONT',
				   'parent' => KLR_LANDRACE,
				   'syn' => '6.5',
				   'type' => kTYPE_ENUM,
				   'label' => "Landrace continuity",
				   'descr' => "Whether the LR maintainer plans to continue to grow LR for the foreseeable future.",
				   'examp' => array( '20' ) ),
			array( 'code' => 'LRDISTR',
				   'parent' => KLR_LANDRACE,
				   'syn' => '6.6',
				   'type' => kTYPE_ENUM,
				   'label' => "Landrace distribution",
				   'descr' => "Whether the LR maintainer plans to give/exchange the LR to/with other growers.",
				   'examp' => array( '12' ) ),
			array( 'code' => 'LRFARMERMOT',
				   'parent' => KLR_LANDRACE,
				   'syn' => '6.7',
				   'type' => kTYPE_ENUM_SET,
				   'label' => "Farmer motivations for growing the landrace",
				   'descr' => "Taken from farmer statement. See codes in the table below. Multiple choices are allowed separated by a semicolon (;) without space.",
				   'examp' => array( '12' ) ),
			array( 'code' => 'LRFARMERSELCRI',
				   'parent' => KLR_LANDRACE,
				   'syn' => '6.8',
				   'type' => kTYPE_ENUM,
				   'label' => "Farmer LR selection criteria",
				   'descr' => "The main criteria farmer uses when selecting material for propagation.",
				   'examp' => array( '12' ) ),
			array( 'code' => 'PPU',
				   'parent' => KLR_LANDRACE,
				   'syn' => '6.9',
				   'type' => kTYPE_ENUM_SET,
				   'label' => "Part of the plant used",
				   'descr' => "Part/s of the plant used by the farmer, as from farmer statement. Multiple choices are allowed separated by a semicolon (;) without space.",
				   'examp' => array( '110;70' ) ),
			array( 'code' => 'LRPRODUSE',
				   'parent' => KLR_LANDRACE,
				   'syn' => '6.10',
				   'type' => kTYPE_ENUM_SET,
				   'label' => "Product use",
				   'descr' => "Type of use of the product obtained from the LR: if as direct product or as processed product for larger use, as from farmer statement. Multiple choices are allowed separated by a semicolon (;) without space.",
				   'examp' => array( '13;16' ) ),
			array( 'code' => 'LRPRODEST',
				   'parent' => KLR_LANDRACE,
				   'syn' => '6.11',
				   'type' => kTYPE_ENUM,
				   'label' => "Main destination of the product",
				   'descr' => "Where the product from the LR is mainly destined for use, as from farmer statement.",
				   'examp' => array( '21' ) ),
			array( 'code' => 'LRMARKTDEMAND',
				   'parent' => KLR_LANDRACE,
				   'syn' => '6.12',
				   'type' => kTYPE_ENUM,
				   'label' => "Market landrace demand",
				   'descr' => "Demand for LR / LR product as from farmer statement.",
				   'examp' => array( '30' ) ),
			array( 'code' => 'LRTHREATF',
				   'parent' => KLR_LANDRACE,
				   'syn' => '6.13',
				   'type' => kTYPE_ENUM,
				   'label' => "Loss risk as for the farmer",
				   'descr' => "Risk of losing this LR as perceived by the interviewed farmer. It helps to decide if conservation is needed and plan monitoring actions.",
				   'examp' => array( '40' ) ),
			array( 'code' => 'LRTHREATCT',
				   'parent' => KLR_LANDRACE,
				   'syn' => '6.14',
				   'type' => kTYPE_ENUM,
				   'label' => "Loss risk as assessed by the collecting team",
				   'descr' => "Risk of losing this LR as perceived by the team recording data. It helps to decide if conservation is needed and plan monitoring actions.",
				   'examp' => array( '40' ) ) );
		
		//
		// Load data.
		//
		foreach( $params as $param )
		{
			//
			// Get category.
			//
			$category
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode(
					$_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
						$param[ 'parent' ],
						NULL,
						TRUE ),
					TRUE )[ 0 ]	;
			
			//
			// Relate to category.
			//
			$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
				$node
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
						$term
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
								$param[ 'code' ],		// Local identifier.
								$namespace,				// Namespace.
								$param[ 'label' ],		// Label or name.
								$param[ 'descr' ],		// Description or definition.
								kDEFAULT_LANGUAGE,		// Language.
								// Additional attributes.
								array( kTAG_SYNONYMS => array( $param[ 'code' ], $param[ 'syn' ] ),
									   kTAG_EXAMPLES => $param[ 'examp' ] ) ),
						array( kKIND_FEATURE, kKIND_SCALE ),
						$param[ 'type' ] ),				// Node data type.
				$category );
			
			//
			// Create tag.
			//
			$tag = NULL;
			$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag( $tag, $node );
			$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag( $tag, TRUE );
			
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - ".$term->GID()." ["
							  .$node[ kTAG_NID ]."] ("
							  .$tag[ kTAG_NID ].")\n" );
		}

		//
		// Init site enumerations storage.
		//
		$params = array(
			array( 'code' => '10',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRCULTPER',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRCULTPER',
				   'syn' => '10',
				   'label' => "Does not answer",
				   'descr' => "Does not answer." ),
			array( 'code' => '20',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRCULTPER',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRCULTPER',
				   'syn' => '20',
				   'label' => "Over 50 years",
				   'descr' => "Over 50 years." ),
			array( 'code' => '30',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRCULTPER',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRCULTPER',
				   'syn' => '30',
				   'label' => "Under 50 years",
				   'descr' => "Under 50 years." ),
			array( 'code' => '31',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRCULTPER',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRCULTPER', '30' ) ),
				   'syn' => '31',
				   'label' => "Less than 10 years ago",
				   'descr' => "Less than 10 years ago." ),
			array( 'code' => '32',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRCULTPER',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRCULTPER', '30' ) ),
				   'syn' => '32',
				   'label' => "11-25 years ago",
				   'descr' => "11-25 years ago." ),
			array( 'code' => '33',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRCULTPER',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRCULTPER', '30' ) ),
				   'syn' => '33',
				   'label' => "26-50 years ago",
				   'descr' => "26-50 years ago." ),
				   
			array( 'code' => '10',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSTATUS',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSTATUS',
				   'syn' => '10',
				   'label' => "Does not answer",
				   'descr' => "Does not answer." ),
			array( 'code' => '20',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSTATUS',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSTATUS',
				   'syn' => '20',
				   'label' => "Inherent",
				   'descr' => "Should match with LRCULTPER 20 or 33, at least." ),
			array( 'code' => '30',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSTATUS',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSTATUS',
				   'syn' => '30',
				   'label' => "Reintroduced by the family which presently cultivates the LR from a different estate belonging to the same family",
				   'descr' => "For example: the very same LR has been grown for several decades and generations in the same family at the same farm/garden, but now it is grown at the summer cottage in different district/neighboring house belonging to the same family. Provide details under REMARKS." ),
			array( 'code' => '40',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSTATUS',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSTATUS',
				   'syn' => '40',
				   'label' => "Introduced/Reintroduced from gene bank",
				   'descr' => "Provide Gene Bank name in REMARKS." ),
			array( 'code' => '50',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSTATUS',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSTATUS',
				   'syn' => '50',
				   'label' => "Introduced/Reintroduced from other farms",
				   'descr' => "Introduced/Reintroduced from other farms." ),
			array( 'code' => '51',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSTATUS',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRSTATUS', '50' ) ),
				   'syn' => '51',
				   'label' => "Introduced/Reintroduced from neighbouring farm",
				   'descr' => "Introduced/Reintroduced from other farms: neighbouring farm." ),
			array( 'code' => '52',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSTATUS',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRSTATUS', '50' ) ),
				   'syn' => '52',
				   'label' => "Introduced/Reintroduced from farm in the same district",
				   'descr' => "Introduced/Reintroduced from other farms: farm in the same district." ),
			array( 'code' => '53',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSTATUS',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRSTATUS', '50' ) ),
				   'syn' => '53',
				   'label' => "Introduced/Reintroduced from farm in different district/country",
				   'descr' => "Introduced/Reintroduced from other farms: farm in different district/country." ),
			array( 'code' => '60',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSTATUS',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSTATUS',
				   'syn' => '60',
				   'label' => "Introduced/Reintroduced from the seed market",
				   'descr' => "Introduced/Reintroduced from the seed market." ),
			array( 'code' => '99',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSTATUS',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSTATUS',
				   'syn' => '99',
				   'label' => "Other",
				   'descr' => "Other (elaborate in REMARKS)." ),
				   
			array( 'code' => '10',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSSS',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSSS',
				   'syn' => '10',
				   'label' => "Informal sector",
				   'descr' => "Informal sector." ),
			array( 'code' => '11',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSSS',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRSSS', '10' ) ),
				   'syn' => '11',
				   'label' => "Own family harvest",
				   'descr' => "Own family harvest." ),
			array( 'code' => '12',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSSS',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRSSS', '10' ) ),
				   'syn' => '12',
				   'label' => "Exchanges with relatives, neighbours",
				   'descr' => "Exchanges with relatives, neighbours." ),
			array( 'code' => '13',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSSS',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRSSS', '10' ) ),
				   'syn' => '13',
				   'label' => "Exchanges between close villages via barter system",
				   'descr' => "Exchanges between close villages via barter system." ),
			array( 'code' => '14',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSSS',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRSSS', '10' ) ),
				   'syn' => '14',
				   'label' => "Local / regional market",
				   'descr' => "Local / regional market." ),
			array( 'code' => '20',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSSS',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSSS',
				   'syn' => '20',
				   'label' => "Formal sector",
				   'descr' => "Formal sector." ),
			array( 'code' => '21',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSSS',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRSSS', '20' ) ),
				   'syn' => '21',
				   'label' => "Certified material from the seed market",
				   'descr' => "Certified material from the seed market." ),
			array( 'code' => '22',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSSS',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRSSS', '20' ) ),
				   'syn' => '22',
				   'label' => "Genebank",
				   'descr' => "Genebank (to be specified from which genebank in REMARKS)." ),
			array( 'code' => '30',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSSS',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSSS',
				   'syn' => '30',
				   'label' => "Does not answer",
				   'descr' => "Does not answer." ),
			array( 'code' => '99',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSSS',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRSSS',
				   'syn' => '99',
				   'label' => "Other",
				   'descr' => "Other (elaborate in REMARKS)." ),
				   
			array( 'code' => '10',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRCONT',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRCONT',
				   'syn' => '10',
				   'label' => "Undecided",
				   'descr' => "Undecided." ),
			array( 'code' => '20',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRCONT',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRCONT',
				   'syn' => '20',
				   'label' => "Will stop next year",
				   'descr' => "Will stop next year." ),
			array( 'code' => '30',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRCONT',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRCONT',
				   'syn' => '30',
				   'label' => "Will continue, but considers changing within a few years",
				   'descr' => "Will continue, but considers changing within a few years." ),
			array( 'code' => '40',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRCONT',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRCONT',
				   'syn' => '40',
				   'label' => "Will continue as long as possible",
				   'descr' => "Will continue as long as possible." ),
			array( 'code' => '99',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRCONT',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRCONT',
				   'syn' => '99',
				   'label' => "Other",
				   'descr' => "Other (elaborate in REMARKS)." ),
				   
			array( 'code' => '10',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRDISTR',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRDISTR',
				   'syn' => '10',
				   'label' => "Yes",
				   'descr' => "Yes." ),
			array( 'code' => '11',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRDISTR',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRDISTR', '10' ) ),
				   'syn' => '11',
				   'label' => "To relative",
				   'descr' => "Yes, to relative." ),
			array( 'code' => '12',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRDISTR',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRDISTR', '10' ) ),
				   'syn' => '12',
				   'label' => "To friend or neighbour",
				   'descr' => "Yes, to friend or neighbour." ),
			array( 'code' => '13',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRDISTR',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRDISTR', '10' ) ),
				   'syn' => '13',
				   'label' => "To another grower",
				   'descr' => "Yes, to another grower." ),
			array( 'code' => '14',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRDISTR',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRDISTR', '10' ) ),
				   'syn' => '14',
				   'label' => "To seed/seedlings-swap event",
				   'descr' => "Yes, to seed/seedlings-swap event." ),
			array( 'code' => '15',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRDISTR',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRDISTR', '10' ) ),
				   'syn' => '15',
				   'label' => "To plant genebank",
				   'descr' => "Yes, to plant genebank." ),
			array( 'code' => '20',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRDISTR',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRDISTR',
				   'syn' => '20',
				   'label' => "No",
				   'descr' => "No." ),
			array( 'code' => '30',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRDISTR',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRDISTR',
				   'syn' => '30',
				   'label' => "Undecided",
				   'descr' => "Undecided." ),

			array( 'code' => '10',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'syn' => '10',
				   'label' => "Agronomical traits",
				   'descr' => "Agronomical traits." ),
			array( 'code' => '11',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRFARMERMOT', '10' ) ),
				   'syn' => '11',
				   'label' => "Easy/simple cultivation required",
				   'descr' => "Easy/simple cultivation required." ),
			array( 'code' => '12',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRFARMERMOT', '10' ) ),
				   'syn' => '12',
				   'label' => "Precocity",
				   'descr' => "Precocity (early development or maturity)." ),
			array( 'code' => '13',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRFARMERMOT', '10' ) ),
				   'syn' => '13',
				   'label' => "Lateness",
				   'descr' => "Lateness." ),
			array( 'code' => '14',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRFARMERMOT', '10' ) ),
				   'syn' => '14',
				   'label' => "Lodging resistance",
				   'descr' => "Lodging resistance." ),
			array( 'code' => '15',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRFARMERMOT', '10' ) ),
				   'syn' => '15',
				   'label' => "High yield",
				   'descr' => "High yield." ),
			array( 'code' => '16',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRFARMERMOT', '10' ) ),
				   'syn' => '16',
				   'label' => "Stable yield",
				   'descr' => "Stable yield." ),
			array( 'code' => '20',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'syn' => '20',
				   'label' => "Resistance to stresses",
				   'descr' => "Resistance to stresses." ),
			array( 'code' => '21',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRFARMERMOT', '20' ) ),
				   'syn' => '21',
				   'label' => "Abiotic factors",
				   'descr' => "Abiotic factors." ),
			array( 'code' => '211',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRFARMERMOT', '21' ) ),
				   'syn' => '211',
				   'label' => "Cold",
				   'descr' => "Abiotic factors: cold." ),
			array( 'code' => '212',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRFARMERMOT', '21' ) ),
				   'syn' => '212',
				   'label' => "Drought",
				   'descr' => "Abiotic factors: drought." ),
			array( 'code' => '213',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRFARMERMOT', '21' ) ),
				   'syn' => '213',
				   'label' => "High humidity",
				   'descr' => "Abiotic factors: high humidity." ),
			array( 'code' => '214',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRFARMERMOT', '21' ) ),
				   'syn' => '214',
				   'label' => "Salinity",
				   'descr' => "Abiotic factors: salinity." ),
			array( 'code' => '22',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRFARMERMOT', '20' ) ),
				   'syn' => '22',
				   'label' => "Biotic factors",
				   'descr' => "Biotic factors." ),
			array( 'code' => '221',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRFARMERMOT', '22' ) ),
				   'syn' => '221',
				   'label' => "Fungal/bacterial/virus",
				   'descr' => "Biotic factors: fungal/bacterial/virus." ),
			array( 'code' => '222',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRFARMERMOT', '22' ) ),
				   'syn' => '222',
				   'label' => "Insect/nematode/etc.",
				   'descr' => "Biotic factors: insect/nematode/etc." ),
			array( 'code' => '30',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'syn' => '30',
				   'label' => "Cultural and religious motivations",
				   'descr' => "Cultural and religious motivations." ),
			array( 'code' => '31',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRFARMERMOT', '30' ) ),
				   'syn' => '31',
				   'label' => "Personal affection",
				   'descr' => "Personal affection." ),
			array( 'code' => '32',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRFARMERMOT', '30' ) ),
				   'syn' => '32',
				   'label' => "Special family food preparations",
				   'descr' => "Special family food preparations." ),
			array( 'code' => '33',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRFARMERMOT', '30' ) ),
				   'syn' => '33',
				   'label' => "Special family ceremonies",
				   'descr' => "Special family ceremonies." ),
			array( 'code' => '34',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRFARMERMOT', '30' ) ),
				   'syn' => '34',
				   'label' => "Ritual or religious use of the community",
				   'descr' => "Ritual or religious use of the community." ),
			array( 'code' => '35',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRFARMERMOT', '30' ) ),
				   'syn' => '35',
				   'label' => "Local fairs/festivals",
				   'descr' => "Local fairs/festivals." ),
			array( 'code' => '36',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRFARMERMOT', '30' ) ),
				   'syn' => '36',
				   'label' => "Historical/collector/ amateur interest",
				   'descr' => "Historical/collector/ amateur interest." ),
			array( 'code' => '40',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'syn' => '40',
				   'label' => "Quality traits",
				   'descr' => "Quality traits (taste, fragrance, colour, etc.)." ),
			array( 'code' => '50',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'syn' => '50',
				   'label' => "Market traits",
				   'descr' => "Market traits (good storability, easy transformation etc.)." ),
			array( 'code' => '99',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERMOT',
				   'syn' => '99',
				   'label' => "Other",
				   'descr' => "Other (elaborate in REMARKS)." ),

			array( 'code' => '10',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERSELCRI',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERSELCRI',
				   'syn' => '10',
				   'label' => "Yield",
				   'descr' => "Yield." ),
			array( 'code' => '20',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERSELCRI',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERSELCRI',
				   'syn' => '20',
				   'label' => "Organ size",
				   'descr' => "Organ size." ),
			array( 'code' => '30',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERSELCRI',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERSELCRI',
				   'syn' => '30',
				   'label' => "Taste",
				   'descr' => "Taste." ),
			array( 'code' => '40',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERSELCRI',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERSELCRI',
				   'syn' => '40',
				   'label' => "Colour",
				   'descr' => "Colour." ),
			array( 'code' => '50',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERSELCRI',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERSELCRI',
				   'syn' => '50',
				   'label' => "Shape",
				   'descr' => "Shape." ),
			array( 'code' => '60',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERSELCRI',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERSELCRI',
				   'syn' => '60',
				   'label' => "Uniformity",
				   'descr' => "Uniformity." ),
			array( 'code' => '99',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERSELCRI',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRFARMERSELCRI',
				   'syn' => '99',
				   'label' => "Other",
				   'descr' => "Other (elaborate in REMARKS)." ),

			array( 'code' => '10',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'PPU',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'PPU',
				   'syn' => '10',
				   'label' => "Entire plant",
				   'descr' => "Entire plant." ),
			array( 'code' => '20',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'PPU',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'PPU',
				   'syn' => '20',
				   'label' => "Branch",
				   'descr' => "Branch." ),
			array( 'code' => '30',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'PPU',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'PPU',
				   'syn' => '30',
				   'label' => "Seedling/germinated seed",
				   'descr' => "Seedling/germinated seed." ),
			array( 'code' => '40',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'PPU',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'PPU',
				   'syn' => '40',
				   'label' => "Gall",
				   'descr' => "Gall." ),
			array( 'code' => '50',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'PPU',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'PPU',
				   'syn' => '50',
				   'label' => "Stem/trunk",
				   'descr' => "Stem/trunk." ),
			array( 'code' => '60',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'PPU',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'PPU',
				   'syn' => '60',
				   'label' => "Bark",
				   'descr' => "Bark." ),
			array( 'code' => '70',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'PPU',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'PPU',
				   'syn' => '70',
				   'label' => "Leaf",
				   'descr' => "Leaf." ),
			array( 'code' => '80',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'PPU',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'PPU',
				   'syn' => '80',
				   'label' => "Flower/inflorescence",
				   'descr' => "Flower/inflorescence." ),
			array( 'code' => '90',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'PPU',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'PPU',
				   'syn' => '90',
				   'label' => "Fruit/infructescence",
				   'descr' => "Fruit/infructescence." ),
			array( 'code' => '100',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'PPU',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'PPU',
				   'syn' => '100',
				   'label' => "Seed",
				   'descr' => "Seed." ),
			array( 'code' => '110',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'PPU',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'PPU',
				   'syn' => '110',
				   'label' => "Root/corm",
				   'descr' => "Root/corm." ),
			array( 'code' => '120',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'PPU',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'PPU',
				   'syn' => '120',
				   'label' => "Exudate",
				   'descr' => "Exudate." ),
			array( 'code' => '99',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'PPU',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'PPU',
				   'syn' => '99',
				   'label' => "Other",
				   'descr' => "Other (elaborate in REMARKS)." ),

			array( 'code' => '10',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRPRODUSE',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRPRODUSE',
				   'syn' => '10',
				   'label' => "As direct product",
				   'descr' => "As direct product." ),
			array( 'code' => '11',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRPRODUSE',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRPRODUSE', '10' ) ),
				   'syn' => '11',
				   'label' => "Food",
				   'descr' => "Food (e.g. vegetable, soups)." ),
			array( 'code' => '12',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRPRODUSE',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRPRODUSE', '10' ) ),
				   'syn' => '12',
				   'label' => "Fodder",
				   'descr' => "Fodder." ),
			array( 'code' => '13',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRPRODUSE',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRPRODUSE', '10' ) ),
				   'syn' => '13',
				   'label' => "Spice - aromatic",
				   'descr' => "Spice - aromatic." ),
			array( 'code' => '14',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRPRODUSE',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRPRODUSE', '10' ) ),
				   'syn' => '14',
				   'label' => "Medicinal purpose",
				   'descr' => "Medicinal purpose." ),
			array( 'code' => '15',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRPRODUSE',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRPRODUSE', '10' ) ),
				   'syn' => '15',
				   'label' => "Odoriferous purpose",
				   'descr' => "Odoriferous purpose." ),
			array( 'code' => '16',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRPRODUSE',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRPRODUSE', '10' ) ),
				   'syn' => '16',
				   'label' => "Ornamental purpose",
				   'descr' => "Ornamental purpose." ),
			array( 'code' => '20',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRPRODUSE',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRPRODUSE',
				   'syn' => '20',
				   'label' => "As processed product",
				   'descr' => "As processed product." ),
			array( 'code' => '21',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRPRODUSE',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRPRODUSE', '20' ) ),
				   'syn' => '21',
				   'label' => "Bakery product",
				   'descr' => "Bakery product." ),
			array( 'code' => '22',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRPRODUSE',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRPRODUSE', '20' ) ),
				   'syn' => '22',
				   'label' => "Long term storage culinary product",
				   'descr' => "Long term storage culinary product (e.g. canned food)." ),
			array( 'code' => '23',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRPRODUSE',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRPRODUSE', '20' ) ),
				   'syn' => '23',
				   'label' => "Distillery product",
				   'descr' => "Distillery product." ),
			array( 'code' => '24',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRPRODUSE',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRPRODUSE', '20' ) ),
				   'syn' => '24',
				   'label' => "For oil extraction",
				   'descr' => "For oil extraction." ),
			array( 'code' => '25',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRPRODUSE',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRPRODUSE', '20' ) ),
				   'syn' => '25',
				   'label' => "For textile fibers production",
				   'descr' => "For textile fibers production." ),
			array( 'code' => '99',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRPRODUSE',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRPRODUSE',
				   'syn' => '99',
				   'label' => "Other",
				   'descr' => "Other (elaborate in REMARKS)." ),

			array( 'code' => '10',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRPRODEST',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRPRODEST',
				   'syn' => '10',
				   'label' => "Owner's household",
				   'descr' => "Owner's household." ),
			array( 'code' => '20',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRPRODEST',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRPRODEST',
				   'syn' => '20',
				   'label' => "Market",
				   'descr' => "Market." ),
			array( 'code' => '21',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRPRODEST',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRPRODEST', '10' ) ),
				   'syn' => '21',
				   'label' => "Local market",
				   'descr' => "In local market." ),
			array( 'code' => '22',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRPRODEST',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRPRODEST', '10' ) ),
				   'syn' => '22',
				   'label' => "District / regional markets",
				   'descr' => "In district / regional markets." ),
			array( 'code' => '23',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRPRODEST',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRPRODEST', '10' ) ),
				   'syn' => '23',
				   'label' => "National markets",
				   'descr' => "In national markets." ),
			array( 'code' => '24',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRPRODEST',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'LRPRODEST', '10' ) ),
				   'syn' => '24',
				   'label' => "International sale",
				   'descr' => "In international sale." ),
			array( 'code' => '99',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRPRODEST',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRPRODEST',
				   'syn' => '99',
				   'label' => "Other",
				   'descr' => "Other (elaborate in REMARKS)." ),

			array( 'code' => '10',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRMARKTDEMAND',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRMARKTDEMAND',
				   'syn' => '10',
				   'label' => "Does not answer",
				   'descr' => "Does not answer." ),
			array( 'code' => '20',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRMARKTDEMAND',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRMARKTDEMAND',
				   'syn' => '20',
				   'label' => "Strong existing market demand",
				   'descr' => "Strong existing market demand." ),
			array( 'code' => '30',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRMARKTDEMAND',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRMARKTDEMAND',
				   'syn' => '30',
				   'label' => "Growing market demand",
				   'descr' => "Growing market demand." ),
			array( 'code' => '40',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRMARKTDEMAND',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRMARKTDEMAND',
				   'syn' => '40',
				   'label' => "Stable market demand",
				   'descr' => "Stable market demand." ),
			array( 'code' => '50',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRMARKTDEMAND',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRMARKTDEMAND',
				   'syn' => '50',
				   'label' => "Falling market demand",
				   'descr' => "Falling market demand." ),
			array( 'code' => '99',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRMARKTDEMAND',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRMARKTDEMAND',
				   'syn' => '99',
				   'label' => "Other",
				   'descr' => "Other (elaborate in REMARKS)." ),

			array( 'code' => '10',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRTHREATF',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRTHREATF',
				   'syn' => '10',
				   'label' => "Does not answer/know",
				   'descr' => "Does not answer/know." ),
			array( 'code' => '20',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRTHREATF',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRTHREATF',
				   'syn' => '20',
				   'label' => "Null / scarce",
				   'descr' => "Null / scarce." ),
			array( 'code' => '30',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRTHREATF',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRTHREATF',
				   'syn' => '30',
				   'label' => "Low",
				   'descr' => "Low." ),
			array( 'code' => '40',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRTHREATF',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRTHREATF',
				   'syn' => '40',
				   'label' => "Medium",
				   'descr' => "Medium." ),
			array( 'code' => '50',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRTHREATF',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRTHREATF',
				   'syn' => '50',
				   'label' => "High",
				   'descr' => "High." ),
			array( 'code' => '99',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRTHREATF',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRTHREATF',
				   'syn' => '99',
				   'label' => "Other",
				   'descr' => "Other (elaborate in REMARKS)." ),

			array( 'code' => '10',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRTHREATCT',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRTHREATCT',
				   'syn' => '10',
				   'label' => "Unable to judge/assess",
				   'descr' => "Unable to judge/assess." ),
			array( 'code' => '20',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRTHREATCT',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRTHREATCT',
				   'syn' => '20',
				   'label' => "Null / scarce",
				   'descr' => "Null / scarce." ),
			array( 'code' => '30',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRTHREATCT',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRTHREATCT',
				   'syn' => '30',
				   'label' => "Low",
				   'descr' => "Low." ),
			array( 'code' => '40',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRTHREATCT',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRTHREATCT',
				   'syn' => '40',
				   'label' => "Medium",
				   'descr' => "Medium." ),
			array( 'code' => '50',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRTHREATCT',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRTHREATCT',
				   'syn' => '50',
				   'label' => "High",
				   'descr' => "High." ),
			array( 'code' => '99',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRTHREATCT',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'LRTHREATCT',
				   'syn' => '99',
				   'label' => "Other",
				   'descr' => "Other (elaborate in REMARKS)." ) );
		
		//
		// Create landrace categories.
		//
		foreach( $params as $param )
		{
			//
			// Get namespace.
			//
			$namespace
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					$param[ 'namespace' ],
					NULL,
					TRUE );
			
			
			//
			// Get parent.
			//
			$parent
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode(
					$_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
						$param[ 'parent' ],
						NULL,
						TRUE ),
					TRUE )[ 0 ]	;
			
			//
			// Relate to trait.
			//
			$_SESSION[ kSESSION_ONTOLOGY ]->EnumOf(
				$node
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
						$term
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
								$param[ 'code' ],		// Local identifier.
								$namespace,				// Namespace.
								$param[ 'label' ],		// Label or name.
								$param[ 'descr' ],		// Description or definition.
								kDEFAULT_LANGUAGE ) ),	// Language.
				$parent );
	
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - ".$term->GID()." [".$node[ kTAG_NID ]."]\n" );
		}

	} // LoadLandraceLandraceTraits.

	 
	/*===================================================================================
	 *	LoadLandraceMonitoringTraits														*
	 *==================================================================================*/

	/**
	 * <h4>Load landrace conservation and monitoring traits</h4>
	 *
	 * This method will create the landrace conservation and monitoring trait nodes and
	 * relate them to their category.
	 */
	function LoadLandraceMonitoringTraits()
	{
		//
		// Get namespace.
		//
		$namespace
			= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
				kLR_ROOT,
				NULL,
				TRUE );
		
		//
		// Init local storage.
		//
		$params = array(
			array( 'code' => 'CONSERVACTIONS',
				   'parent' => KLR_MONITOR,
				   'syn' => '7.1',
				   'type' => kTYPE_ENUM,
				   'label' => "Conservation actions",
				   'descr' => "Whether any structured and funded in situ conservation action related to the LR is in place at the moment of the Inventory compilation.",
				   'examp' => array( '11' ) ),
			array( 'code' => 'CONORG',
				   'parent' => KLR_MONITOR,
				   'syn' => '7.2',
				   'type' => kTYPE_STRING,
				   'label' => "Conservation organiser",
				   'descr' => "To be compiled if CONSERVACTIONS is ‘Yes’. Name of the Authority/Public subject/Farmer organisation/Foundation that has organised the conservation action. Free text.",
				   'examp' => array( 'FNR' ) ),
			array( 'code' => 'MONIT',
				   'parent' => KLR_MONITOR,
				   'syn' => '7.3',
				   'type' => kTYPE_ENUM,
				   'label' => "Monitoring",
				   'descr' => "Whether any monitoring of the in situ maintenance of LR is foreseen across years. Yes or No.",
				   'examp' => array( '10' ) ),
			array( 'code' => 'MONITRESP',
				   'parent' => KLR_MONITOR,
				   'syn' => '7.4',
				   'type' => kTYPE_STRING,
				   'label' => "Monitoring responsible",
				   'descr' => "To be compiled if MONIT is ‘Yes’. Indicate who is in charge of monitoring. Free text.",
				   'examp' => array( 'Raul Sanchez' ) ),
			array( 'code' => 'MONINT',
				   'parent' => KLR_MONITOR,
				   'syn' => '7.5',
				   'type' => kTYPE_INT32,
				   'label' => "Monitoring interval",
				   'descr' => "To be compiled if MONIT is ‘Yes’. Indicate the monitoring interval in years.",
				   'examp' => array( '2' ) ),
			array( 'code' => 'EXSECURE',
				   'parent' => KLR_MONITOR,
				   'syn' => '7.6',
				   'type' => kTYPE_ENUM,
				   'label' => "Safety duplication ex situ",
				   'descr' => "State if a sample was collected for safety duplication in gene bank. Yes or No.",
				   'examp' => array( '10' ) ),
			array( 'code' => 'EXDUPL',
				   'parent' => KLR_MONITOR,
				   'syn' => '7.7',
				   'type' => kTYPE_STRING,
				   'label' => "Location of ex situ duplicate/s",
				   'descr' => "To be filled in if the answer of EXSECURE (7.6) is ‘Yes’. FAO WIEWS institute code/s of the institute/s where an ex situ safety duplicate of the landrace has been eventually deposited. The codes consist of the 3-letter ISO 3166 country code of the country where the institute is located plus a number. Multiple codes are separated by a semicolon (;) without space.",
				   'examp' => array( 'ARM002' ) ) );
		
		//
		// Load data.
		//
		foreach( $params as $param )
		{
			//
			// Get category.
			//
			$category
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode(
					$_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
						$param[ 'parent' ],
						NULL,
						TRUE ),
					TRUE )[ 0 ]	;
			
			//
			// Relate to category.
			//
			$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
				$node
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
						$term
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
								$param[ 'code' ],		// Local identifier.
								$namespace,				// Namespace.
								$param[ 'label' ],		// Label or name.
								$param[ 'descr' ],		// Description or definition.
								kDEFAULT_LANGUAGE,		// Language.
								// Additional attributes.
								array( kTAG_SYNONYMS => array( $param[ 'code' ], $param[ 'syn' ] ),
									   kTAG_EXAMPLES => $param[ 'examp' ] ) ),
						array( kKIND_FEATURE, kKIND_SCALE ),
						$param[ 'type' ] ),				// Node data type.
				$category );
			
			//
			// Create tag.
			//
			$tag = NULL;
			$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag( $tag, $node );
			$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag( $tag, TRUE );
			
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - ".$term->GID()." ["
							  .$node[ kTAG_NID ]."] ("
							  .$tag[ kTAG_NID ].")\n" );
		}

		//
		// Init site enumerations storage.
		//
		$params = array(
			array( 'code' => '10',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'CONSERVACTIONS',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'CONSERVACTIONS',
				   'syn' => '10',
				   'label' => "Yes",
				   'descr' => "Yes." ),
			array( 'code' => '11',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'CONSERVACTIONS',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'CONSERVACTIONS', '10' ) ),
				   'syn' => '11',
				   'label' => "Policy-based actions",
				   'descr' => "Policy-based actions." ),
			array( 'code' => '12',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'CONSERVACTIONS',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'CONSERVACTIONS', '10' ) ),
				   'syn' => '12',
				   'label' => "Educational actions",
				   'descr' => "Educational actions (didactic gardens, living museum etc.)." ),
			array( 'code' => '13',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'CONSERVACTIONS',
				   'parent' => implode( kTOKEN_NAMESPACE_SEPARATOR, array( 'LR', 'CONSERVACTIONS', '10' ) ),
				   'syn' => '13',
				   'label' => "Other",
				   'descr' => "Other (To be specified in REMARKS)." ),
			array( 'code' => '20',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'CONSERVACTIONS',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'CONSERVACTIONS',
				   'syn' => '20',
				   'label' => "No",
				   'descr' => "No." ),
			array( 'code' => '30',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'CONSERVACTIONS',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'CONSERVACTIONS',
				   'syn' => '30',
				   'label' => "Unknown",
				   'descr' => "Unknown." ),

			array( 'code' => '10',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'MONIT',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'MONIT',
				   'syn' => '10',
				   'label' => "Yes",
				   'descr' => "Yes." ),
			array( 'code' => '20',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'MONIT',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'MONIT',
				   'syn' => '20',
				   'label' => "No",
				   'descr' => "No." ),

			array( 'code' => '10',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'EXSECURE',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'EXSECURE',
				   'syn' => '10',
				   'label' => "Yes",
				   'descr' => "Yes." ),
			array( 'code' => '20',
				   'namespace' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'EXSECURE',
				   'parent' => 'LR'.kTOKEN_NAMESPACE_SEPARATOR.'EXSECURE',
				   'syn' => '20',
				   'label' => "No",
				   'descr' => "No." ) );
		
		//
		// Create landrace categories.
		//
		foreach( $params as $param )
		{
			//
			// Get namespace.
			//
			$namespace
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					$param[ 'namespace' ],
					NULL,
					TRUE );
			
			
			//
			// Get parent.
			//
			$parent
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode(
					$_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
						$param[ 'parent' ],
						NULL,
						TRUE ),
					TRUE )[ 0 ]	;
			
			//
			// Relate to trait.
			//
			$_SESSION[ kSESSION_ONTOLOGY ]->EnumOf(
				$node
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
						$term
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
								$param[ 'code' ],		// Local identifier.
								$namespace,				// Namespace.
								$param[ 'label' ],		// Label or name.
								$param[ 'descr' ],		// Description or definition.
								kDEFAULT_LANGUAGE ) ),	// Language.
				$parent );
	
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - ".$term->GID()." [".$node[ kTAG_NID ]."]\n" );
		}

	} // LoadLandraceMonitoringTraits.

	 
	/*===================================================================================
	 *	LoadLandraceRemarkTraits														*
	 *==================================================================================*/

	/**
	 * <h4>Load landrace remark traits</h4>
	 *
	 * This method will create the landrace remark trait nodes and relate them to their
	 * category.
	 */
	function LoadLandraceRemarkTraits()
	{
		//
		// Get namespace.
		//
		$namespace
			= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
				kLR_ROOT,
				NULL,
				TRUE );
		
		//
		// Get parent.
		//
		$root
			= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode(
				$_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					$namespace,
					NULL,
					TRUE ),
				TRUE )[ 0 ]	;
		
		//
		// Init local storage.
		//
		$params = array(
			array( 'code' => 'REMARKS',
				   'syn' => '8',
				   'type' => kTYPE_STRING,
				   'label' => "Remarks",
				   'descr' => "The remarks field is used to add notes or to elaborate on descriptors with value 99 or 999 (=Other). Prefix remarks with the field name they refer to and make them follow by a colon (:). Distinct remarks referring to different fields are separated by semicolons (;) without space.",
				   'examp' => array( 'The farmer often observes flower colour instability; PRODUCTUSE: chaff also used for fuel pellet and pillow filling; LRMARKTDEMAND: falling locally but growing in the district nearby.' ) ) );
		
		//
		// Load data.
		//
		foreach( $params as $param )
		{
			//
			// Relate to category.
			//
			$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
				$node
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
						$term
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
								$param[ 'code' ],		// Local identifier.
								$namespace,				// Namespace.
								$param[ 'label' ],		// Label or name.
								$param[ 'descr' ],		// Description or definition.
								kDEFAULT_LANGUAGE,		// Language.
								// Additional attributes.
								array( kTAG_SYNONYMS => array( $param[ 'code' ], $param[ 'syn' ] ),
									   kTAG_EXAMPLES => $param[ 'examp' ] ) ),
						array( kKIND_FEATURE, kKIND_SCALE ),
						$param[ 'type' ] ),				// Node data type.
				$root );
			
			//
			// Create tag.
			//
			$tag = NULL;
			$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag( $tag, $node );
			$_SESSION[ kSESSION_ONTOLOGY ]->AddToTag( $tag, TRUE );
			
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - ".$term->GID()." ["
							  .$node[ kTAG_NID ]."] ("
							  .$tag[ kTAG_NID ].")\n" );
		}

	} // LoadLandraceRemarkTraits.


?>

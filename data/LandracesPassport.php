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
		// Init local storage.
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
			echo( "    - $id [".$_SESSION[ 'NODES' ][ $id ]."]\n" );
		}

	} // LoadLandraceCategories.

	 
	/*===================================================================================
	 *	LoadLandraceInventoryTraits														*
	 *==================================================================================*/

	/**
	 * <h4>Load default attributes</h4>
	 *
	 * This method will create the default attribute nodes and relate them to their
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
				   'type' => array( kTYPE_ENUM, kTYPE_CARD_REQUIRED ),
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
			echo( "    - $id ["
				 .$_SESSION[ 'NODES' ][ $id ]
				 ."] ("
				 .$_SESSION[ 'TAGS' ][ $id ][ kOFFSET_NID ]
				 .")\n" );
		}

	} // LoadLandraceInventoryTraits.

?>

<?php

/**
 * ISO ontologies load scripts.
 *
 * This file contains routines to create the default ontologies.
 *
 *	@package	MyWrapper
 *	@subpackage	Data
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 10/10/2012
 */

/*=======================================================================================
 *																						*
 *									ISOOntologies.php									*
 *																						*
 *======================================================================================*/

//
// Local includes.
//
require_once( 'ISOOntologies.inc.php' );

		

/*=======================================================================================
 *																						*
 *										FUNCTIONS										*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	LoadISOOntologies																*
	 *==================================================================================*/

	/**
	 * <h4>Load ISO ontologies</h4>
	 *
	 * This method will create the ISO root nodes.
	 */
	function LoadISOOntologies()
	{
		//
		// Create ISO term.
		//
		$id = kONTOLOGY_ISO;
		$_SESSION[ 'TERMS' ][ $id ] = new COntologyTerm();
		$_SESSION[ 'TERMS' ][ $id ]->LID( $id );
		$_SESSION[ 'TERMS' ][ $id ]->Label( 'en', 'International Organization for Standardization' );
		$_SESSION[ 'TERMS' ][ $id ]->Label( 'fr', 'Organisation internationale de normalisation' );
		$_SESSION[ 'TERMS' ][ $id ]->Label( 'ru', 'Международная организация по стандартизации' );
		$_SESSION[ 'TERMS' ][ $id ]->Description( 'en', 'Collection of industrial and commercial standards and codes.' );
		$_SESSION[ 'TERMS' ][ $id ]->Insert( $_SESSION[ kSESSION_ONTOLOGY ]->Connection() );

		//
		// Create ISO ontology.
		//
		$_SESSION[ 'NODES' ][ $id ]
			= $_SESSION[ kSESSION_ONTOLOGY ]->NewRootNode(
				$_SESSION[ 'TERMS' ][ $id ] );

		//
		// Inform.
		//
		if( kOPTION_VERBOSE )
			echo( "    - $id [".$_SESSION[ 'NODES' ][ $id ]."]\n" );

	} // LoadISOOntologies.

	 
	/*===================================================================================
	 *	LoadISOStandards																*
	 *==================================================================================*/

	/**
	 * <h4>Load ISO standards</h4>
	 *
	 * This method will create the ISO main standard nodes and relate them to their roots.
	 */
	function LoadISOStandards()
	{
		//
		// Init top level storage.
		//
		$namespace = $_SESSION[ 'TERMS' ][ kONTOLOGY_ISO ];
		$root = $_SESSION[ 'NODES' ][ kONTOLOGY_ISO ];
		$params = array(
			array( 'code' => kONTOLOGY_ISO_639,
				   'label' => "International Standard for language codes",
				   'descr' => "The purpose of ISO 639 is to establish internationally recognised codes (either 2, 3, or 4 letters long) for the representation of languages or language families." ),
			array( 'code' => kONTOLOGY_ISO_3166,
				   'label' => "International Standard for country codes and codes for their subdivisions",
				   'descr' => "The purpose of ISO 3166 is to establish internationally recognised codes for the representation of names of countries, territories or areas of geographical interest, and their subdivisions. However, ISO 3166 does not establish the names of countries, only the codes that represent them." ),
			array( 'code' => kONTOLOGY_ISO_4217,
				   'label' => "International Standard for currency codes",
				   'descr' => "The purpose of ISO 4217 is to establish internationally recognised codes for the representation of currencies. Currencies can be represented in the code in two ways: a three-letter alphabetic code and a three-digit numeric code." )
		);
		
		//
		// Create landrace categories.
		//
		foreach( $params as $param )
		{
			//
			// Set global identifier.
			//
			$id = kONTOLOGY_ISO.kTOKEN_NAMESPACE_SEPARATOR.$param[ 'code' ];
			
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
								kDEFAULT_LANGUAGE ) ),	// Language.
				$root );
	
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - $id [".$_SESSION[ 'NODES' ][ $id ]."]\n" );
		}

		//
		// Set ISO 15924 trait..
		//
		$id = kONTOLOGY_ISO.kTOKEN_NAMESPACE_SEPARATOR.kONTOLOGY_ISO_15924;
		$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
			//
			// Create node.
			//
			$_SESSION[ 'NODES' ][ $id ]
				= $_SESSION[ kSESSION_ONTOLOGY ]->NewScaleNode(
					//
					// Create term.
					//
					$_SESSION[ 'TERMS' ][ $id ]
						= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
							kONTOLOGY_ISO_15924,	// Local identifier.
							$namespace,				// Namespace.
							"Codes for the representation of names of scripts",
							"ISO 15924 provides a code for the presentation of names of scripts. The codes were devised for use in terminology, lexicography, bibliography and linguistics, but they may be used for any application requiring the expression of scripts in coded form. ISO 15924 also includes guidance on the use of script codes in some of these applications.",
							kDEFAULT_LANGUAGE ),	// Language.
					kTYPE_ENUM ),					// Node data type.
			$root );

		//
		// Inform.
		//
		if( kOPTION_VERBOSE )
			echo( "    - $id [".$_SESSION[ 'NODES' ][ $id ]."]\n" );

	} // LoadISOStandards.

	 
	/*===================================================================================
	 *	LoadISO639Categories															*
	 *==================================================================================*/

	/**
	 * <h4>Load ISO 639 categories</h4>
	 *
	 * This method will create the ISO 639 category nodes and relate them to their
	 * standards.
	 */
	function LoadISO639Categories()
	{
		//
		// Set part 1 and 3 categories.
		//
		$ns_id = kONTOLOGY_ISO.kTOKEN_NAMESPACE_SEPARATOR.kONTOLOGY_ISO_639;
		$namespace = $_SESSION[ 'TERMS' ][ $ns_id ];
		$category = $_SESSION[ 'NODES' ][ $ns_id ];
		$params = array(
			array( 'code' => kONTOLOGY_ISO_639_1,
				   'label' => "Part 1",
				   'descr' => "Alpha-2 code." ),
			array( 'code' => kONTOLOGY_ISO_639_3,
				   'label' => "Part 3",
				   'descr' => "Alpha-3 code for comprehensive coverage of languages." ) );
		
		//
		// Load data.
		//
		foreach( $params as $param )
		{
			//
			// Set global identifier.
			//
			$id = $ns_id.kTOKEN_NAMESPACE_SEPARATOR.$param[ 'code' ];
			
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
								kDEFAULT_LANGUAGE ),	// Language.
						kTYPE_ENUM ),					// Node data type.
				$category );							// Object vertex node.
	
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - $id [".$_SESSION[ 'NODES' ][ $id ]."]\n" );
		}

		//
		// Set part 2 category.
		//
		$id = $ns_id.kTOKEN_NAMESPACE_SEPARATOR.kONTOLOGY_ISO_639_2;
		$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
			//
			// Create node.
			//
			$_SESSION[ 'NODES' ][ $id ]
				= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
					$_SESSION[ 'TERMS' ][ $id ]
						//
						// Create term.
						//
						= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
							kONTOLOGY_ISO_639_2,	// Local identifier.
							$namespace,				// Namespace.
							"Part 2",				// Label or name.
							"Alpha-3 code.",		// Description or definition.
							kDEFAULT_LANGUAGE ) ),	// Language.
			$category );							// Object vertex node.

		//
		// Inform.
		//
		if( kOPTION_VERBOSE )
			echo( "    - $id [".$_SESSION[ 'NODES' ][ $id ]."]\n" );

		//
		// Set part 2 traita.
		//
		$ns_id = $id;
		$namespace = $_SESSION[ 'TERMS' ][ $ns_id ];
		$category = $_SESSION[ 'NODES' ][ $ns_id ];
		$params = array(
			array( 'code' => kONTOLOGY_ISO_639_2T,
				   'label' => "Terminological code",
				   'descr' => "While most languages are given one code by the standard, twenty of the languages described have two three-letter codes, the “terminological” code (ISO 639-2/T), is derived from the native name for the language." ),
			array( 'code' => kONTOLOGY_ISO_639_2B,
				   'label' => "Bibliographic code",
				   'descr' => "While most languages are given one code by the standard, twenty of the languages described have two three-letter codes, the “bibliographic” code (ISO 639-2/B), is derived from the English name for the language and was a necessary legacy feature." ) );
		
		//
		// Load data.
		//
		foreach( $params as $param )
		{
			//
			// Set global identifier.
			//
			$id = $ns_id.kTOKEN_NAMESPACE_SEPARATOR.$param[ 'code' ];
			
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
								kDEFAULT_LANGUAGE ),	// Language.
						kTYPE_ENUM ),					// Node data type.
				$category );							// Object vertex node.
	
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - $id [".$_SESSION[ 'NODES' ][ $id ]."]\n" );
		}

	} // LoadISO639Categories.

	 
	/*===================================================================================
	 *	LoadISO3166Categories															*
	 *==================================================================================*/

	/**
	 * <h4>Load ISO 3166 categories</h4>
	 *
	 * This method will create the ISO 3166 category nodes and relate them to their
	 * standards.
	 */
	function LoadISO3166Categories()
	{
		//
		// Set part 1, 2 and 3 categories.
		//
		$ns_id = kONTOLOGY_ISO.kTOKEN_NAMESPACE_SEPARATOR.kONTOLOGY_ISO_3166;
		$namespace = $_SESSION[ 'TERMS' ][ $ns_id ];
		$category = $_SESSION[ 'NODES' ][ $ns_id ];
		$params = array(
			array( 'code' => kONTOLOGY_ISO_3166_2,
				   'label' => "Part 2",
				   'descr' => "Country subdivision code, defines codes for the names of the principal subdivisions (e.g., provinces or states) of all countries coded in ISO 3166-1." ),
			array( 'code' => kONTOLOGY_ISO_3166_3,
				   'label' => "Part 3",
				   'descr' => "Code for formerly used names of countries, defines codes for country names which have been deleted from ISO 3166-1 since its first publication in 1974." ) );
		
		//
		// Load data.
		//
		foreach( $params as $param )
		{
			//
			// Set global identifier.
			//
			$id = $ns_id.kTOKEN_NAMESPACE_SEPARATOR.$param[ 'code' ];
			
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
								kDEFAULT_LANGUAGE ),	// Language.
						kTYPE_ENUM ),					// Node data type.
				$category );							// Object vertex node.
	
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - $id [".$_SESSION[ 'NODES' ][ $id ]."]\n" );
		}

		//
		// Set part 1 category.
		//
		$id = $ns_id.kTOKEN_NAMESPACE_SEPARATOR.kONTOLOGY_ISO_3166_1;
		$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
			//
			// Create node.
			//
			$_SESSION[ 'NODES' ][ $id ]
				= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
					$_SESSION[ 'TERMS' ][ $id ]
						//
						// Create term.
						//
						= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
							kONTOLOGY_ISO_3166_1,	// Local identifier.
							$namespace,				// Namespace.
							"Part 1",				// Label or name.
							"Country codes, defines codes for the names of countries, dependent territories, and special areas of geographical interest.",
							kDEFAULT_LANGUAGE ) ),	// Language.
			$category );							// Object vertex node.

		//
		// Inform.
		//
		if( kOPTION_VERBOSE )
			echo( "    - $id [".$_SESSION[ 'NODES' ][ $id ]."]\n" );

		//
		// Set part 1 traits.
		//
		$ns_id = $id;
		$namespace = $_SESSION[ 'TERMS' ][ $ns_id ];
		$category = $_SESSION[ 'NODES' ][ $ns_id ];
		$params = array(
			array( 'code' => kONTOLOGY_ISO_3166_1_ALPHA2,
				   'label' => "Alpha-2 code",
				   'descr' => "Two-letter country codes which are the most widely used of the three ISO 3166-1 subdivisions, and used most prominently for the Internet's country code top-level domains (with a few exceptions)." ),
			array( 'code' => kONTOLOGY_ISO_3166_1_ALPHA3,
				   'label' => "Alpha-3 code",
				   'descr' => "Three-letter country codes which allow a better visual association between the codes and the country names than the alpha-2 codes." ),
			array( 'code' => kONTOLOGY_ISO_3166_1_NUMERIC,
				   'label' => "Numeric code",
				   'descr' => "Three-digit country codes which are identical to those developed and maintained by the United Nations Statistics Division, with the advantage of script (writing system) independence, and hence useful for people or systems using non-Latin scripts." ) );
		
		//
		// Load data.
		//
		foreach( $params as $param )
		{
			//
			// Set global identifier.
			//
			$id = $ns_id.kTOKEN_NAMESPACE_SEPARATOR.$param[ 'code' ];
			
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
								kDEFAULT_LANGUAGE ),	// Language.
						kTYPE_ENUM ),					// Node data type.
				$category );							// Object vertex node.
	
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - $id [".$_SESSION[ 'NODES' ][ $id ]."]\n" );
		}

	} // LoadISO3166Categories.

	 
	/*===================================================================================
	 *	LoadISO4217Traits																*
	 *==================================================================================*/

	/**
	 * <h4>Load ISO 4217 categories</h4>
	 *
	 * This method will create the ISO 4217 category nodes and relate them to their
	 * standards.
	 */
	function LoadISO4217Traits()
	{
		//
		// Set active and historic traits.
		//
		$ns_id = kONTOLOGY_ISO.kTOKEN_NAMESPACE_SEPARATOR.kONTOLOGY_ISO_4217;
		$namespace = $_SESSION[ 'TERMS' ][ $ns_id ];
		$category = $_SESSION[ 'NODES' ][ $ns_id ];
		$params = array(
			array( 'code' => kONTOLOGY_ISO_4217_A,
				   'label' => "Active codes",
				   'descr' => "Codes currently in use." ),
			array( 'code' => kONTOLOGY_ISO_4217_H,
				   'label' => "Historic codes",
				   'descr' => "Historical or obsolete codes." ) );
		
		//
		// Load data.
		//
		foreach( $params as $param )
		{
			//
			// Set global identifier.
			//
			$id = $ns_id.kTOKEN_NAMESPACE_SEPARATOR.$param[ 'code' ];
			
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
								kDEFAULT_LANGUAGE ),	// Language.
						kTYPE_ENUM ),					// Node data type.
				$category );							// Object vertex node.
	
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - $id [".$_SESSION[ 'NODES' ][ $id ]."]\n" );
		}

	} // LoadISO4217Traits.

?>

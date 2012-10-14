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
			array( 'code' => kONTOLOGY_ISO_639_2,
				   'label' => "Part 2",
				   'descr' => "Alpha-3 code." ),
			array( 'code' => kONTOLOGY_ISO_639_2T,
				   'label' => "Terminological code",
				   'descr' => "While most languages are given one code by the standard, twenty of the languages described have two three-letter codes, the “terminological” code (ISO 639-2/T), is derived from the native name for the language." ),
			array( 'code' => kONTOLOGY_ISO_639_2B,
				   'label' => "Bibliographic code",
				   'descr' => "While most languages are given one code by the standard, twenty of the languages described have two three-letter codes, the “bibliographic” code (ISO 639-2/B), is derived from the English name for the language and was a necessary legacy feature." ),
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

	} // LoadISO639Categories.

	 
	/*===================================================================================
	 *	LoadISO639Enums																	*
	 *==================================================================================*/

	/**
	 * <h4>Load ISO 639 enumerations</h4>
	 *
	 * This method will create the ISO 639 enumeration nodes and relate them to their
	 * standards.
	 */
	function LoadISO639Enums()
	{
		//
		// Init data.
		//
		$ns_id = kONTOLOGY_ISO.kTOKEN_NAMESPACE_SEPARATOR.kONTOLOGY_ISO_639;
		$namespace = $_SESSION[ 'TERMS' ][ $ns_id ];
		$category = $_SESSION[ 'NODES' ][ $ns_id ];
		$params = array(
			array( 'code' => kONTOLOGY_ISO_639_3_scope,
				   'type' => kTYPE_ENUM,
				   'label' => "Scope",
				   'descr' => "Scope of denotation for language identifiers." ),
			array( 'code' => kONTOLOGY_ISO_639_3_type,
				   'type' => kTYPE_ENUM,
				   'label' => "Type",
				   'descr' => "Type of individual language." ),
			array( 'code' => kONTOLOGY_ISO_639_3_status,
				   'type' => kTYPE_STRING,
				   'label' => "Status",
				   'descr' => "Type of individual language." ),
			array( 'code' => kONTOLOGY_ISO_639_3_INVNAME,
				   'type' => kTYPE_CODED_LIST,
				   'label' => "Inverted name",
				   'descr' => "An \"inverted\" name is one that is altered from the usual English-language order by moving adjectival qualifiers to the end, after the main language name and separated by a comma." ) );
		
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
		// Set scope enumerations.
		//
		$ns_id = implode(
					kTOKEN_NAMESPACE_SEPARATOR,
					array( kONTOLOGY_ISO, kONTOLOGY_ISO_639, kONTOLOGY_ISO_639_3_scope ) );
		$namespace = $_SESSION[ 'TERMS' ][ $ns_id ];
		$trait = $_SESSION[ 'NODES' ][ $ns_id ];
		$params = array(
			array( 'code' => 'I',
				   'label' => "Individual",
				   'descr' => "A distinct individual language." ),
			array( 'code' => 'M',
				   'label' => "Macrolanguage",
				   'descr' => "Language that corresponds in a one-to-many manner with several individual languages." ),
			array( 'code' => 'C',
				   'label' => "Collection of languages",
				   'descr' => "A collective language code element is an identifier that represents a group of individual languages that are not deemed to be one language in any usage context." ),
			array( 'code' => 'D',
				   'label' => "Dialect",
				   'descr' => "Sub-variety of a language such as might be based on geographic region, age, gender, social class, time period, or the like." ),
			array( 'code' => 'R',
				   'label' => "Reserved",
				   'descr' => "Reserved for local use." ),
			array( 'code' => 'S',
				   'label' => "Special",
				   'descr' => "Special situation." ) );
		
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
			$_SESSION[ kSESSION_ONTOLOGY ]->EnumOf(
				//
				// Create node.
				//
				$_SESSION[ 'NODES' ][ $id ]
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewEnumerationNode(
						$_SESSION[ 'TERMS' ][ $id ]
							//
							// Create term.
							//
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
								$param[ 'code' ],		// Local identifier.
								$namespace,				// Namespace.
								$param[ 'label' ],		// Label or name.
								$param[ 'descr' ],		// Description or definition.
								kDEFAULT_LANGUAGE ) ),	// Language.
				$trait );								// Object vertex node.
	
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - $id [".$_SESSION[ 'NODES' ][ $id ]."]\n" );
		}

		//
		// Set type enumerations.
		//
		$ns_id = implode(
					kTOKEN_NAMESPACE_SEPARATOR,
					array( kONTOLOGY_ISO, kONTOLOGY_ISO_639, kONTOLOGY_ISO_639_3_type ) );
		$namespace = $_SESSION[ 'TERMS' ][ $ns_id ];
		$trait = $_SESSION[ 'NODES' ][ $ns_id ];
		$params = array(
			array( 'code' => 'L',
				   'label' => "Living",
				   'descr' => "A language is listed as living when there are people still living who learned it as a first language." ),
			array( 'code' => 'E',
				   'label' => "Extinct",
				   'descr' => "Language that are no longer living." ),
			array( 'code' => 'A',
				   'label' => "Ancient",
				   'descr' => "A language went extinct in ancient times (e.g. more than a millennium ago)." ),
			array( 'code' => 'H',
				   'label' => "Historic",
				   'descr' => "A language considered to be distinct from any modern languages that are descended from it; for instance, Old English and Middle English." ),
			array( 'code' => 'C',
				   'label' => "Constructed",
				   'descr' => "A constructed (or artificial) language." ),
			array( 'code' => 'G',
				   'label' => "Genetic",
				   'descr' => "In linguistics, genetic relationship is the usual term for the relationship which exists between languages that are members of the same language family, mixed languages, pidgins and creole languages constitute special genetic types of languages." ) );
		
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

	} // LoadISO639Enums.

	 
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

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
		$term = new COntologyTerm();
		$term->LID( kONTOLOGY_ISO );
		$term->Label( kDEFAULT_LANGUAGE, 'International Organization for Standardization' );
		$term->Label( 'fr', 'Organisation internationale de normalisation' );
		$term->Label( 'ru', 'Международная организация по стандартизации' );
		$term->Description( kDEFAULT_LANGUAGE, 'Collection of industrial and commercial standards and codes.' );
		$term->Insert( $_SESSION[ kSESSION_ONTOLOGY ]->Connection() );
		$id = $term->GID();
		$_SESSION[ 'TERMS' ][ $id ] = $term;
		
		//
		// Create ISO node.
		//
		$node = $_SESSION[ kSESSION_ONTOLOGY ]->NewRootNode( $term );
		$_SESSION[ 'NODES' ][ $id ] = $node;

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
				   'label' => "International Standard of codes for the representation of names of countries and their subdivisions",
				   'descr' => "The purpose of ISO 3166 is to define codes for the names of countries, dependent territories, special areas of geographical interest, and their principal subdivisions (e.g., provinces or states)." ),
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
								kDEFAULT_LANGUAGE ) ),	// Language.
				$root );
			
			//
			// Save references.
			//
			$id = $term->GID();
			$_SESSION[ 'NODES' ][ $id ] = $node;
			$_SESSION[ 'TERMS' ][ $id ] = $term;
	
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - $id [".$_SESSION[ 'NODES' ][ $id ]."]\n" );
		}

		//
		// Set ISO 15924 trait..
		//
		$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
			$node
				= $_SESSION[ kSESSION_ONTOLOGY ]->NewScaleNode(
					$term
						= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
							kONTOLOGY_ISO_15924,	// Local identifier.
							$namespace,				// Namespace.
							"Codes for the representation of names of scripts",
							"ISO 15924 provides a code for the presentation of names of scripts. The codes were devised for use in terminology, lexicography, bibliography and linguistics, but they may be used for any application requiring the expression of scripts in coded form. ISO 15924 also includes guidance on the use of script codes in some of these applications.",
							kDEFAULT_LANGUAGE ),	// Language.
					kTYPE_ENUM ),					// Node data type.
			$root );
		
		//
		// Save references.
		//
		$id = $term->GID();
		$_SESSION[ 'NODES' ][ $id ] = $node;
		$_SESSION[ 'TERMS' ][ $id ] = $term;

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
		$ns_id = implode( kTOKEN_NAMESPACE_SEPARATOR,
						  array( kONTOLOGY_ISO, kONTOLOGY_ISO_639 ) );
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
			// Relate to category.
			//
			$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
				$node
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewScaleNode(
						$term
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
								$param[ 'code' ],		// Local identifier.
								$namespace,				// Namespace.
								$param[ 'label' ],		// Label or name.
								$param[ 'descr' ],		// Description or definition.
								kDEFAULT_LANGUAGE ),	// Language.
						kTYPE_ENUM ),					// Node data type.
				$category );							// Object vertex node.
			
			//
			// Save references.
			//
			$id = $term->GID();
			$_SESSION[ 'NODES' ][ $id ] = $node;
			$_SESSION[ 'TERMS' ][ $id ] = $term;
	
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
		$ns_id = implode( kTOKEN_NAMESPACE_SEPARATOR,
						  array( kONTOLOGY_ISO, kONTOLOGY_ISO_639 ) );
		$def_ns = $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm( '', NULL, TRUE );
		$namespace = $_SESSION[ 'TERMS' ][ $ns_id ];
		$category = $_SESSION[ 'NODES' ][ $ns_id ];
		$params = array(
			array( 'code' => kONTOLOGY_ISO_639_3_scope,
				   'type' => kTYPE_ENUM,
				   'label' => "Scope",
				   'descr' => "Scope of denotation for language identifiers." ),
			array( 'code' => kONTOLOGY_ISO_639_3_type,
				   'type' => kTYPE_ENUM_SET,
				   'label' => "Type",
				   'descr' => "Type of individual language." ),
			array( 'code' => kONTOLOGY_ISO_639_3_status,
				   'type' => kTYPE_STRING,
				   'label' => "Status",
				   'descr' => "Type of individual language." ),
			array( 'code' => kONTOLOGY_ISO_639_3_INVNAME,
				   'type' => kTYPE_LSTRING,
				   'label' => "Inverted name",
				   'descr' => "An \"inverted\" name is one that is altered from the usual English-language order by moving adjectival qualifiers to the end, after the main language name and separated by a comma." ) );
		
		//
		// Load predicate term.
		//
		$predicate
			= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
				substr( kPREDICATE_SUBCLASS_OF, 1 ),
				$def_ns,
				TRUE );
		
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
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewScaleNode(
						$term
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
								$param[ 'code' ],		// Local identifier.
								$namespace,				// Namespace.
								$param[ 'label' ],		// Label or name.
								$param[ 'descr' ],		// Description or definition.
								kDEFAULT_LANGUAGE ),	// Language.
						$param[ 'type' ] ),				// Node data type.
				$category );							// Object vertex node.
			
			//
			// Save references.
			//
			$id = $term->GID();
			$_SESSION[ 'NODES' ][ $id ] = $node;
			$_SESSION[ 'TERMS' ][ $id ] = $term;
		
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
					 .$_SESSION[ 'TAGS' ][ $id ][ kTAG_NID ]
					 .")\n" );
		
		} // Iterating first level parameters.

		//
		// Set scope enumerations.
		//
		$ns_id = implode( kTOKEN_NAMESPACE_SEPARATOR,
						  array( kONTOLOGY_ISO,
						  		 kONTOLOGY_ISO_639,
						  		 kONTOLOGY_ISO_639_3_scope ) );
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
			// Relate to category.
			//
			$_SESSION[ kSESSION_ONTOLOGY ]->EnumOf(
				$node
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewEnumerationNode(
						$term
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
								$param[ 'code' ],		// Local identifier.
								$namespace,				// Namespace.
								$param[ 'label' ],		// Label or name.
								$param[ 'descr' ],		// Description or definition.
								kDEFAULT_LANGUAGE ) ),	// Language.
				$trait );								// Object vertex node.
			
			//
			// Save references.
			//
			$id = $term->GID();
			$_SESSION[ 'NODES' ][ $id ] = $node;
			$_SESSION[ 'TERMS' ][ $id ] = $term;
	
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - $id [".$_SESSION[ 'NODES' ][ $id ]."]\n" );
		}

		//
		// Set type enumerations.
		//
		$ns_id = implode( kTOKEN_NAMESPACE_SEPARATOR,
						  array( kONTOLOGY_ISO,
						  		 kONTOLOGY_ISO_639,
						  		 kONTOLOGY_ISO_639_3_type ) );
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
			array( 'code' => 'S',
				   'label' => "Special",
				   'descr' => "Special language." ),
			array( 'code' => 'Genetic',
				   'label' => "Genetic",
				   'descr' => "In linguistics, genetic relationship is the usual term for the relationship which exists between languages that are members of the same language family, mixed languages, pidgins and creole languages constitute special genetic types of languages." ),
			array( 'code' => 'Genetic-like',
				   'label' => "Genetic-like",
				   'descr' => "Genetic-like language." ),
			array( 'code' => 'Geographic',
				   'label' => "Geographic",
				   'descr' => "Geographic language." ) );
		
		//
		// Load data.
		//
		foreach( $params as $param )
		{
			//
			// Relate to category.
			//
			$_SESSION[ kSESSION_ONTOLOGY ]->EnumOf(
				$node
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewEnumerationNode(
						$term
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
								$param[ 'code' ],		// Local identifier.
								$namespace,				// Namespace.
								$param[ 'label' ],		// Label or name.
								$param[ 'descr' ],		// Description or definition.
								kDEFAULT_LANGUAGE ) ),	// Language.
				$trait );
			
			//
			// Save references.
			//
			$id = $term->GID();
			$_SESSION[ 'NODES' ][ $id ] = $node;
			$_SESSION[ 'TERMS' ][ $id ] = $term;
	
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
		// Init local storage.
		//
		$ns_id = implode( kTOKEN_NAMESPACE_SEPARATOR,
						  array( kONTOLOGY_ISO,
						  		 kONTOLOGY_ISO_3166 ) );
		$def_ns = $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm( '', NULL, TRUE );
		$namespace = $_SESSION[ 'TERMS' ][ $ns_id ];
		$category = $_SESSION[ 'NODES' ][ $ns_id ];
		
		//
		// Load predicate term.
		//
		$predicate
			= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
				substr( kPREDICATE_SUBCLASS_OF, 1 ),
				$def_ns,
				TRUE );

		//
		// Set part 1 category.
		//
		$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
			$node
				= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
					$term
						= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
							kONTOLOGY_ISO_3166_1,	// Local identifier.
							$namespace,				// Namespace.
							"Part 1",				// Label or name.
							"Country codes, defines codes for the names of countries, dependent territories, and special areas of geographical interest.",
							kDEFAULT_LANGUAGE ) ),	// Language.
			$category );							// Object vertex node.
		
		//
		// Save references.
		//
		$id = $term->GID();
		$_SESSION[ 'NODES' ][ $id ] = $node;
		$_SESSION[ 'TERMS' ][ $id ] = $term;

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
				   'type' => kTYPE_ENUM,
				   'label' => "Alpha-2 code",
				   'descr' => "Two-letter country codes which are the most widely used of the three ISO 3166-1 subdivisions, and used most prominently for the Internet's country code top-level domains (with a few exceptions)." ),
			array( 'code' => kONTOLOGY_ISO_3166_1_ALPHA3,
				   'type' => kTYPE_ENUM,
				   'label' => "Alpha-3 code",
				   'descr' => "Three-letter country codes which allow a better visual association between the codes and the country names than the alpha-2 codes." ),
			array( 'code' => kONTOLOGY_ISO_3166_1_NUMERIC,
				   'type' => kTYPE_ENUM,
				   'label' => "Numeric code",
				   'descr' => "Three-digit country codes which are identical to those developed and maintained by the United Nations Statistics Division, with the advantage of script (writing system) independence, and hence useful for people or systems using non-Latin scripts." ),
			array( 'code' => kONTOLOGY_ISO_3166_1_COMMON_NAME,
				   'type' => kTYPE_LSTRING,
				   'label' => "Common name",
				   'descr' => "Country common name." ) );
		
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
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewScaleNode(
						$term
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
								$param[ 'code' ],		// Local identifier.
								$namespace,				// Namespace.
								$param[ 'label' ],		// Label or name.
								$param[ 'descr' ],		// Description or definition.
								kDEFAULT_LANGUAGE ),	// Language.
						$param[ 'type' ] ),				// Node data type.
				$category );							// Object vertex node.
			
			//
			// Save references.
			//
			$id = $term->GID();
			$_SESSION[ 'NODES' ][ $id ] = $node;
			$_SESSION[ 'TERMS' ][ $id ] = $term;
			
			//
			// Handle tag.
			//
			if( $param[ 'code' ] == kONTOLOGY_ISO_3166_1_COMMON_NAME )
			{
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
						 .$_SESSION[ 'TAGS' ][ $id ][ kTAG_NID ]
						 .")\n" );
			
			} // Taggable term.
			
			//
			// Handle non-taggable.
			//
			else
			{
				//
				// Inform.
				//
				if( kOPTION_VERBOSE )
					echo( "    - $id [".$_SESSION[ 'NODES' ][ $id ]."]\n" );
			
			} // Non taggable.
		}

		//
		// Init local storage.
		//
		$ns_id = implode( kTOKEN_NAMESPACE_SEPARATOR,
						  array( kONTOLOGY_ISO,
						  		 kONTOLOGY_ISO_3166 ) );
		$namespace = $_SESSION[ 'TERMS' ][ $ns_id ];
		$category = $_SESSION[ 'NODES' ][ $ns_id ];

		//
		// Set part 2 category.
		//
		$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
			$node
				= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
					$term
						= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
							kONTOLOGY_ISO_3166_2,	// Local identifier.
							$namespace,				// Namespace.
							"Part 2",				// Label or name.
							"Country subdivision code, defines codes for the names of the principal subdivisions (e.g., provinces or states) of all countries coded in ISO 3166-1.",
							kDEFAULT_LANGUAGE ) ),	// Language.
			$category );							// Object vertex node.
		
		//
		// Save references.
		//
		$id = $term->GID();
		$_SESSION[ 'NODES' ][ $id ] = $node;
		$_SESSION[ 'TERMS' ][ $id ] = $term;

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
			array( 'code' => kONTOLOGY_ISO_3166_2_TYPE,
				   'type' => kTYPE_STRING,
				   'label' => "Subdivision type",
				   'descr' => "Type or kind of the subdivision." ) );
		
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
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewScaleNode(
						$term
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
								$param[ 'code' ],		// Local identifier.
								$namespace,				// Namespace.
								$param[ 'label' ],		// Label or name.
								$param[ 'descr' ],		// Description or definition.
								kDEFAULT_LANGUAGE ),	// Language.
						$param[ 'type' ] ),				// Node data type.
				$category );							// Object vertex node.
			
			//
			// Save references.
			//
			$id = $term->GID();
			$_SESSION[ 'NODES' ][ $id ] = $node;
			$_SESSION[ 'TERMS' ][ $id ] = $term;
			
			//
			// Handle tag.
			//
			if( $param[ 'code' ] == kONTOLOGY_ISO_3166_2_TYPE )
			{
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
						 .$_SESSION[ 'TAGS' ][ $id ][ kTAG_NID ]
						 .")\n" );
			
			} // Taggable term.
			
			//
			// Handle non-taggable.
			//
			else
			{
				//
				// Inform.
				//
				if( kOPTION_VERBOSE )
					echo( "    - $id [".$_SESSION[ 'NODES' ][ $id ]."]\n" );
			
			} // Non taggable.
		}

		//
		// Init local storage.
		//
		$ns_id = implode( kTOKEN_NAMESPACE_SEPARATOR,
						  array( kONTOLOGY_ISO,
						  		 kONTOLOGY_ISO_3166 ) );
		$namespace = $_SESSION[ 'TERMS' ][ $ns_id ];
		$category = $_SESSION[ 'NODES' ][ $ns_id ];

		//
		// Set part 3 category.
		//
		$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
			$node
				= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
					$term
						= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
							kONTOLOGY_ISO_3166_3,	// Local identifier.
							$namespace,				// Namespace.
							"Part 3",				// Label or name.
							"Code for formerly used names of countries, defines codes for country names which have been deleted from ISO 3166-1 since its first publication in 1974.",
							kDEFAULT_LANGUAGE ) ),	// Language.
			$category );							// Object vertex node.
		
		//
		// Save references.
		//
		$id = $term->GID();
		$_SESSION[ 'NODES' ][ $id ] = $node;
		$_SESSION[ 'TERMS' ][ $id ] = $term;

		//
		// Inform.
		//
		if( kOPTION_VERBOSE )
			echo( "    - $id [".$_SESSION[ 'NODES' ][ $id ]."]\n" );

		//
		// Set part 3 traits.
		//
		$ns_id = $id;
		$namespace = $_SESSION[ 'TERMS' ][ $ns_id ];
		$category = $_SESSION[ 'NODES' ][ $ns_id ];
		$params = array(
			array( 'code' => kONTOLOGY_ISO_3166_3_ALPHA2,
				   'type' => kTYPE_ENUM,
				   'label' => "Alpha-2 code",
				   'descr' => "Former ISO 3166-1 two-letter country code." ),
			array( 'code' => kONTOLOGY_ISO_3166_3_ALPHA3,
				   'type' => kTYPE_ENUM,
				   'label' => "Alpha-3 code",
				   'descr' => "Former ISO 3166-1 three-letter country code." ),
			array( 'code' => kONTOLOGY_ISO_3166_3_ALPHA4,
				   'type' => kTYPE_ENUM,
				   'label' => "Alpha-4 code",
				   'descr' => "Four-letter country code. Each former country name in ISO 3166-3 is assigned a four-letter alphabetic code. The first two letters are the ISO 3166-1 alpha-2 code of the former country, while the last two letters are allocated according to the following rules: 1.) If the country changed its name, the new ISO 3166-1 alpha-2 code is used (e.g., Burma changed its name to Myanmar, whose new alpha-2 code is MM), or the special code AA is used if its alpha-2 code was not changed (e.g., Byelorussian SSR changed its name to Belarus, which has kept the same alpha-2 code). 2.) If the country merged into an existing country, the ISO 3166-1 alpha-2 code of this country is used (e.g., the German Democratic Republic merged into Germany, whose alpha-2 code is DE). 3.) If the country was divided into several parts, the special code HH is used to indicate that there is no single successor country (e.g., Czechoslovakia was divided into the Czech Republic and Slovakia), with the exception of Serbia and Montenegro, for which XX is used to avoid duplicate use of the same ISO 3166-3 code, as the alpha-2 code CS had twice been deleted from ISO 3166-1, the first time due to the split of Czechoslovakia and the second time due to the split of Serbia and Montenegro." ),
			array( 'code' => kONTOLOGY_ISO_3166_3_NUMERIC,
				   'type' => kTYPE_ENUM,
				   'label' => "Numeric code",
				   'descr' => "Former ISO 3166-1 three-digit country code." ),
			array( 'code' => kONTOLOGY_ISO_3166_3_DATE_WITHDRAWN,
				   'type' => kTYPE_STRING,
				   'label' => "Date withdrawn",
				   'descr' => "Date in which the standard was withdrawn." ) );
		
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
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewScaleNode(
						$term
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
								$param[ 'code' ],		// Local identifier.
								$namespace,				// Namespace.
								$param[ 'label' ],		// Label or name.
								$param[ 'descr' ],		// Description or definition.
								kDEFAULT_LANGUAGE ),	// Language.
						$param[ 'type' ] ),				// Node data type.
				$category );							// Object vertex node.
			
			//
			// Save references.
			//
			$id = $term->GID();
			$_SESSION[ 'NODES' ][ $id ] = $node;
			$_SESSION[ 'TERMS' ][ $id ] = $term;
			
			//
			// Handle tag.
			//
			if( $param[ 'code' ] == kONTOLOGY_ISO_3166_3_DATE_WITHDRAWN )
			{
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
						 .$_SESSION[ 'TAGS' ][ $id ][ kTAG_NID ]
						 .")\n" );
			
			} // Taggable term.
			
			//
			// Handle non-taggable.
			//
			else
			{
				//
				// Inform.
				//
				if( kOPTION_VERBOSE )
					echo( "    - $id [".$_SESSION[ 'NODES' ][ $id ]."]\n" );
			
			} // Non taggable.
		}

	} // LoadISO3166Categories.

	 
	/*===================================================================================
	 *	LoadISO4217Categories																*
	 *==================================================================================*/

	/**
	 * <h4>Load ISO 4217 categories</h4>
	 *
	 * This method will create the ISO 4217 category nodes and relate them to their
	 * standards.
	 */
	function LoadISO4217Categories()
	{
		//
		// Init local storage.
		//
		$ns_id = implode( kTOKEN_NAMESPACE_SEPARATOR,
						  array( kONTOLOGY_ISO,
						  		 kONTOLOGY_ISO_4217 ) );
		$namespace = $_SESSION[ 'TERMS' ][ $ns_id ];
		$category = $_SESSION[ 'NODES' ][ $ns_id ];

		//
		// Set active codes category.
		//
		$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
			$node
				= $_SESSION[ kSESSION_ONTOLOGY ]->NewScaleNode(
					$term
						= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
							kONTOLOGY_ISO_4217_A,	// Local identifier.
							$namespace,				// Namespace.
							"Active codes",			// Label or name.
							"Codes currently in use.",
							kDEFAULT_LANGUAGE ),	// Language.
					kTYPE_ENUM ),					// Node data type.
			$category );							// Object vertex node.
		
		//
		// Save references.
		//
		$id = $term->GID();
		$_SESSION[ 'NODES' ][ $id ] = $node;
		$_SESSION[ 'TERMS' ][ $id ] = $term;

		//
		// Inform.
		//
		if( kOPTION_VERBOSE )
			echo( "    - $id [".$_SESSION[ 'NODES' ][ $id ]."]\n" );

		//
		// Set historic codes category.
		//
		$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
			$node
				= $_SESSION[ kSESSION_ONTOLOGY ]->NewScaleNode(
					$term
						= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
							kONTOLOGY_ISO_4217_H,	// Local identifier.
							$namespace,				// Namespace.
							"Historic codes",		// Label or name.
							"Historical or obsolete codes.",
							kDEFAULT_LANGUAGE ),	// Language.
					kTYPE_ENUM ),					// Node data type.
			$category );							// Object vertex node.
		
		//
		// Save references.
		//
		$id = $term->GID();
		$_SESSION[ 'NODES' ][ $id ] = $node;
		$_SESSION[ 'TERMS' ][ $id ] = $term;

		//
		// Inform.
		//
		if( kOPTION_VERBOSE )
			echo( "    - $id [".$_SESSION[ 'NODES' ][ $id ]."]\n" );

		//
		// Set historic code traits.
		//
		$ns_id = $id;
		$namespace = $_SESSION[ 'TERMS' ][ $ns_id ];
		$category = $_SESSION[ 'NODES' ][ $ns_id ];
		$params = array(
			array( 'code' => kONTOLOGY_ISO_4217_H_DATE_WITHDRAWN,
				   'type' => kTYPE_STRING,
				   'label' => "Date withdrawn",
				   'descr' => "Date in which the standard was withdrawn." ) );
		
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
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewScaleNode(
						$term
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
								$param[ 'code' ],		// Local identifier.
								$namespace,				// Namespace.
								$param[ 'label' ],		// Label or name.
								$param[ 'descr' ],		// Description or definition.
								kDEFAULT_LANGUAGE ),	// Language.
						$param[ 'type' ] ),				// Node data type.
				$category );							// Object vertex node.
			
			//
			// Save references.
			//
			$id = $term->GID();
			$_SESSION[ 'NODES' ][ $id ] = $node;
			$_SESSION[ 'TERMS' ][ $id ] = $term;
			
			//
			// Handle tag.
			//
			if( $param[ 'code' ] == kONTOLOGY_ISO_4217_H_DATE_WITHDRAWN )
			{
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
						 .$_SESSION[ 'TAGS' ][ $id ][ kTAG_NID ]
						 .")\n" );
			
			} // Taggable term.
			
			//
			// Handle non-taggable.
			//
			else
			{
				//
				// Inform.
				//
				if( kOPTION_VERBOSE )
					echo( "    - $id [".$_SESSION[ 'NODES' ][ $id ]."]\n" );
			
			} // Non taggable.
		}

	} // LoadISO4217Categories.

?>

<?php

/**
 * Default ontologies load scripts.
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
 *								DefaultOntologies.php									*
 *																						*
 *======================================================================================*/

//
// Local includes.
//
require_once( 'DefaultOntologies.inc.php' );

		

/*=======================================================================================
 *																						*
 *										FUNCTIONS										*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	LoadDefaultNamespace															*
	 *==================================================================================*/

	/**
	 * <h4>Load default namespaces</h4>
	 *
	 * This method will create the default namespace.
	 *
	 * Note that the default namespace will be accessible via the zero offset in the terms
	 * session array.
	 */
	function LoadDefaultNamespace()
	{
		//
		// Create default namespace.
		//
		$_SESSION[ 'TERMS' ][ 0 ]
			= $_SESSION[ kSESSION_ONTOLOGY ]
				->NewTerm(
					"",
					NULL,
					"Default namespace",
					"This represents the default namespace term.",
					kDEFAULT_LANGUAGE );

		//
		// Inform.
		//
		if( kOPTION_VERBOSE )
			echo( "    - :".$_SESSION[ 'TERMS' ][ 0 ][ kOFFSET_GID ]."\n" );

	} // LoadDefaultNamespace.

	 
	/*===================================================================================
	 *	LoadDefaultOntology																*
	 *==================================================================================*/

	/**
	 * <h4>Load default ontology</h4>
	 *
	 * This method will create the default root node.
	 */
	function LoadDefaultOntology()
	{
		//
		// Create default ontology.
		//
		$code = kONTOLOGY_DEFAULT_ROOT;
		$id = kTOKEN_NAMESPACE_SEPARATOR.kONTOLOGY_DEFAULT_ROOT;
		$_SESSION[ 'NODES' ][ $id ]
			= $_SESSION[ kSESSION_ONTOLOGY ]->NewRootNode(
				$_SESSION[ 'TERMS' ][ $id ]
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
						$code,
						$_SESSION[ 'TERMS' ][ 0 ],
						"Default ontology",
						"The default ontology collects all attributes and properties used by the ontology elements themselves. This ontology serves as the building blocks of all other ontologies.",
						kDEFAULT_LANGUAGE ) );

		//
		// Inform.
		//
		if( kOPTION_VERBOSE )
			echo( "    - $id [".$_SESSION[ 'NODES' ][ $id ]."]\n" );

	} // LoadDefaultOntology.

	 
	/*===================================================================================
	 *	LoadDefaultCategories															*
	 *==================================================================================*/

	/**
	 * <h4>Load default categories</h4>
	 *
	 * This method will create the default category nodes and relate them to their roots.
	 */
	function LoadDefaultCategories()
	{
		//
		// Init local storage.
		//
		$namespace = $_SESSION[ 'TERMS' ][ 0 ];
		$root = $_SESSION[ 'NODES' ][ kTOKEN_NAMESPACE_SEPARATOR.kONTOLOGY_DEFAULT_ROOT ];
		$params = array(
			array( 'code' => kONTOLOGY_DEFAULT_ATTRIBUTES,
				   'label' => "Default attributes",
				   'descr' => "The predefined default attributes available to all." ),
			array( 'code' => kONTOLOGY_DEFAULT_TYPES,
				   'label' => "Default types",
				   'descr' => "The predefined default data types available to all." ),
			array( 'code' => kONTOLOGY_DEFAULT_PREDICATES,
				   'label' => "Default predicates",
				   'descr' => "The predefined default predicates available to all." ) );
		
		//
		// Load data.
		//
		foreach( $params as $param )
		{
			//
			// Set global identifier.
			//
			$id = kTOKEN_NAMESPACE_SEPARATOR.$param[ 'code' ];
			
			//
			// Relate to root.
			//
			$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
				$_SESSION[ 'NODES' ][ $id ]
					= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
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

	} // LoadDefaultCategories.

	 
	/*===================================================================================
	 *	LoadDefaultPredicates																*
	 *==================================================================================*/

	/**
	 * <h4>Load default predicates</h4>
	 *
	 * This method will create the default predicate nodes and relate them to their
	 * category.
	 */
	function LoadDefaultPredicates()
	{
		//
		// Init local storage.
		//
		$namespace = $_SESSION[ 'TERMS' ][ 0 ];
		$category = $_SESSION[ 'NODES' ]
							 [ kTOKEN_NAMESPACE_SEPARATOR.kONTOLOGY_DEFAULT_PREDICATES ];
		
		//
		// Create subclass predicate.
		//
		$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
			$_SESSION[ 'NODES' ][ kPREDICATE_SUBCLASS_OF ]
				= $_SESSION[ kSESSION_ONTOLOGY ]->NewEnumerationNode(
					$_SESSION[ 'TERMS' ][ kPREDICATE_SUBCLASS_OF ]
						= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
							substr( kPREDICATE_SUBCLASS_OF, 1 ),
							$namespace,
						   "Subclass-of",
						   "This tag identifies the SUBCLASS-OF predicate term local code, this predicate indicates that the subject of the relationship is a subclass of the object of the relationship, in other words, the subject is derived from the object.",
							kDEFAULT_LANGUAGE ) ),
			$category );
		
		//
		// Load data.
		//
		$params = array(
			array( 'code' => substr( kPREDICATE_METHOD_OF, 1 ),
				   'label' => "Method-of",
				   'descr' => "This tag identifies the METHOD-OF predicate term local code, this predicate relates method nodes with trait nodes or other method nodes, it indicates that the subject of the relationship is a method variation of the object of the relationship." ),
			array( 'code' => substr( kPREDICATE_SCALE_OF, 1 ),
				   'label' => "Scale-of",
				   'descr' => "This tag identifies the SCALE-OF predicate term local code, this predicate relates scale nodes with Method or trait nodes, it indicates that the subject of the relationship represents a scale or measure that is used by a trait or method node." ),
			array( 'code' => substr( kPREDICATE_ENUM_OF, 1 ),
				   'label' => "Enumeration-of",
				   'descr' => "This tag identifies the ENUM-OF predicate term local code, this predicate relates enumerated set elements or controlled vocabulary elements." ),
			array( 'code' => substr( kPREDICATE_PREFERRED, 1 ),
				   'label' => "Preferred to",
				   'descr' => "This tag identifies the PREFERRED predicate term local code, this predicate indicates that the object of the relationship is the preferred choice, in other words, if possible, one should use the object of the relationship in place of the subject." ),
			array( 'code' => substr( kPREDICATE_VALID, 1 ),
				   'label' => "Valid object",
				   'descr' => "This tag identifies the VALID predicate term local code, this predicate indicates that the object of the relationship is the valid choice, in other words, the subject of the relationship is obsolete or not valid, and one should use the object od the relationship in its place." ),
			array( 'code' => substr( kPREDICATE_XREF_EXACT, 1 ),
				   'label' => "Exact cross-reference",
				   'descr' => "This tag identifies the XREF-EXACT predicate term local code, this predicate indicates that the subject and the object of the relationship represent an exact cross-reference, in other words, both elements are interchangeable." ) );
		
		//
		// Load data.
		//
		foreach( $params as $param )
		{
			//
			// Set global identifier.
			//
			$id = kTOKEN_NAMESPACE_SEPARATOR.$param[ 'code' ];
			
			//
			// Relate to category.
			//
			$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
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
				$category );							// Object vertex node.
	
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - $id [".$_SESSION[ 'NODES' ][ $id ]."]\n" );
		}

	} // LoadDefaultPredicates.

	 
	/*===================================================================================
	 *	LoadDefaultAttributes															*
	 *==================================================================================*/

	/**
	 * <h4>Load default attributes</h4>
	 *
	 * This method will create the default attribute nodes and relate them to their
	 * category.
	 */
	function LoadDefaultAttributes()
	{
		//
		// Init local storage.
		//
		$namespace = $_SESSION[ 'TERMS' ][ 0 ];
		$category = $_SESSION[ 'NODES' ]
							 [ kTOKEN_NAMESPACE_SEPARATOR.kONTOLOGY_DEFAULT_ATTRIBUTES ];
		$params = array(
			array( 'code' => kONTOLOGY_DEFAULT_AUTHORS,
				   'type' => array( kTYPE_STRING, kTYPE_CARD_ARRAY ),
				   'label' => "Authors",
				   'descr' => "List of authors." ),
			array( 'code' => kONTOLOGY_DEFAULT_NOTES,
				   'type' => array( kTYPE_STRING, kTYPE_CARD_ARRAY ),
				   'label' => "Notes",
				   'descr' => "General notes." ),
			array( 'code' => kONTOLOGY_DEFAULT_ACKNOWLEDGMENTS,
				   'type' => kTYPE_STRING,
				   'label' => "Acknowledgments",
				   'descr' => "General acknowledgments." ),
			array( 'code' => kONTOLOGY_DEFAULT_BIBLIOGRAPHY,
				   'type' => array( kTYPE_STRING, kTYPE_CARD_ARRAY ),
				   'label' => "Bibliography",
				   'descr' => "List of bibliographic references." ),
			array( 'code' => kONTOLOGY_DEFAULT_EXAMPLES,
				   'type' => array( kTYPE_STRING, kTYPE_CARD_ARRAY ),
				   'label' => "Examples",
				   'descr' => "List of examples or templates." ) );
		
		//
		// Load data.
		//
		foreach( $params as $param )
		{
			//
			// Set global identifier.
			//
			$id = kTOKEN_NAMESPACE_SEPARATOR.$param[ 'code' ];
			
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

	} // LoadDefaultAttributes.

	 
	/*===================================================================================
	 *	LoadDefaultTypes																*
	 *==================================================================================*/

	/**
	 * <h4>Load default types</h4>
	 *
	 * This method will create the default data type nodes and relate them to their
	 * category.
	 */
	function LoadDefaultTypes()
	{
		//
		// Init local storage.
		//
		$namespace = $_SESSION[ 'TERMS' ][ 0 ];
		$category = $_SESSION[ 'NODES' ]
							 [ kTOKEN_NAMESPACE_SEPARATOR.kONTOLOGY_DEFAULT_TYPES ];
		$params = array(
			array( 'code' => substr( kTYPE_STRING, 1 ),
				   'label' => "String",
				   'descr' => "Primitive string data type." ),
			array( 'code' => substr( kTYPE_INT32, 1 ),
				   'label' => "32 bit integer",
				   'descr' => "32 bit signed integer type." ),
			array( 'code' => substr( kTYPE_INT64, 1 ),
				   'label' => "64 bit integer",
				   'descr' => "64 bit signed integer type." ),
			array( 'code' => substr( kTYPE_FLOAT, 1 ),
				   'label' => "Floating point",
				   'descr' => "Floating point data type." ),
			array( 'code' => substr( kTYPE_BOOLEAN, 1 ),
				   'label' => "Boolean",
				   'descr' => "The primitive boolean data type, it is assumed that it is provided as (y/n; Yes/No; 1/0; TRUE/FALSE) and will be converted to 1/0." ),
			array( 'code' => substr( kTYPE_BINARY, 1 ),
				   'label' => "Binary string",
				   'descr' => "The binary string data type, it differs from the {@link kTYPE_STRING} type only because it needs to be handled in a custom way to accomodate different databases." ),
			array( 'code' => substr( kTYPE_DATE, 1 ),
				   'label' => "Date",
				   'descr' => "A date represented as a YYYYMMDD string in which missing elements should be omitted. This means that if we don't know the day we can express that date as YYYYMM." ),
			array( 'code' => substr( kTYPE_TIME, 1 ),
				   'label' => "Time",
				   'descr' => "A time represented as a YYYY-MM-DD HH:MM:SS string in which you may not have missing elements." ),
			array( 'code' => substr( kTYPE_STAMP, 1 ),
				   'label' => "Time-stamp",
				   'descr' => "This data type should be used for native time-stamps." ),
			array( 'code' => substr( kTYPE_STRUCT, 1 ),
				   'label' => "Structure",
				   'descr' => "This data type refers to a structure, it implies that the offset to which it refers to is a container of other offsets that will hold the actual data." ) );
		
		//
		// Load data.
		//
		foreach( $params as $param )
		{
			//
			// Set global identifier.
			//
			$id = kTOKEN_NAMESPACE_SEPARATOR.$param[ 'code' ];
			
			//
			// Relate to category.
			//
			$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
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
				$category );							// Object vertex node.
	
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - $id [".$_SESSION[ 'NODES' ][ $id ]."]\n" );
		}

	} // LoadDefaultTypes.

?>

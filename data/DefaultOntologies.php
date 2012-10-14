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
	 *	LoadDefaultNamespaces															*
	 *==================================================================================*/

	/**
	 * <h4>Load default namespaces</h4>
	 *
	 * This method will create the default namespaces.
	 *
	 * Note that the default namespace will be accessible via the zero offset in the terms
	 * session array.
	 */
	function LoadDefaultNamespaces()
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

	} // LoadDefaultNamespaces.

	 
	/*===================================================================================
	 *	LoadDefaultOntologies															*
	 *==================================================================================*/

	/**
	 * <h4>Load default ontologies</h4>
	 *
	 * This method will create the default root nodes.
	 */
	function LoadDefaultOntologies()
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

	} // LoadDefaultOntologies.

	 
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
				   'descr' => "The predefined default data types available to all." ) );
		
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
			array( 'code' => substr( kTYPE_CODED_LIST, 1 ),
				   'label' => "Coded list",
				   'descr' => "This data type refers to a list of elements containing two items: a code an the data. No two elements mat share the same code and only one element may omit the code." ) );
		
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

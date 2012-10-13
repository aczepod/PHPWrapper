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
		// Create default attributes category.
		//
		$code = kONTOLOGY_DEFAULT_ATTRIBUTES;
		$id = kTOKEN_NAMESPACE_SEPARATOR.kONTOLOGY_DEFAULT_ATTRIBUTES;
		$_SESSION[ kSESSION_ONTOLOGY ]->SubclassOf(
			$_SESSION[ 'NODES' ][ $id ]
				= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
					$_SESSION[ 'TERMS' ][ $id ]
						= $_SESSION[ kSESSION_ONTOLOGY ]->NewTerm(
							$code,
							$_SESSION[ 'TERMS' ][ 0 ],
							"Default attributes",
							"The predefined default attributes available to all.",
							kDEFAULT_LANGUAGE ) ),
			$_SESSION[ 'NODES' ][ kTOKEN_NAMESPACE_SEPARATOR.kONTOLOGY_DEFAULT_ROOT ] );

		//
		// Inform.
		//
		if( kOPTION_VERBOSE )
			echo( "    - $id [".$_SESSION[ 'NODES' ][ $id ]."]\n" );

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

?>

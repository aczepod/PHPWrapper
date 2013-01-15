<?php

/**
 * <i>COntologyWrapper</i> class definition.
 *
 * This file contains the class definition of <b>COntologyWrapper</b> which overloads its
 * ancestor to implement an ontology wrapper.
 *
 *	@package	MyWrapper
 *	@subpackage	Wrappers
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 08/11/2011
 */

/*=======================================================================================
 *																						*
 *								COntologyWrapper.php									*
 *																						*
 *======================================================================================*/

/**
 * Terms.
 *
 * This includes the term class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntologyTerm.php" );

/**
 * Nodes.
 *
 * This includes the node class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntologyVertex.php" );

/**
 * Edges.
 *
 * This includes the edge class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntologyEdge.php" );

/**
 * Tags.
 *
 * This includes the tag class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntologyTag.php" );

/**
 * Ancestor.
 *
 * This include file contains the parent class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CDataWrapper.php" );

/**
 * Local definitions.
 *
 * This include file contains all local definitions to this class.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntologyWrapper.inc.php" );

/**
 * <h4>Ontology wrapper</h4>
 *
 * This class overloads its ancestor to implement the framework for providing services that
 * return data from an ontology. The class concentrates on high level services that return
 * aggregated elements taken from the term, node, edge and tag collections.
 *
 * The response parameter will always contain the following elements:
 *
 * <ul>
 *	<li><tt>kAPI_COLLECTION_ID</tt>: This offset tags the element that holds the list of
 *		identifiers of the requested items.
 *	<li><tt>kAPI_COLLECTION_TERM</tt>: This offset tags the element that holds the list
 *		of referenced predicate items
 *	<li><tt>kAPI_COLLECTION_NODE</tt>: This offset tags the element that holds the list
 *		of referenced vertex items
 *	<li><tt>kAPI_COLLECTION_EDGE</tt>: This offset tags the element that holds the list
 *		of referenced edge items
 *	<li><tt>kAPI_COLLECTION_TAG</tt>: This offset tags the element that holds the list
 *		of referenced tag items
 * </ul>
 *
 *	@package	MyWrapper
 *	@subpackage	Wrappers
 */
class COntologyWrapper extends CDataWrapper
{
	/**
	 * <b>Parameters list</b>
	 *
	 * This static data member holds the list of parameters known by the service, these will
	 * be decoded before the service will handle them.
	 *
	 * @var array
	 */
	 static $sParameterList = array( kAPI_LANGUAGE, kAPI_PREDICATE,
	 								 kAPI_RELATION, kAPI_SUBQUERY );

		

/*=======================================================================================
 *																						*
 *								PROTECTED PARSING INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_ParseRequest																	*
	 *==================================================================================*/

	/**
	 * Parse request.
	 *
	 * This method should be used to parse the request, check the request elements and make
	 * any necessary adjustments before the request is {@link _ValidateRequest()}.
	 *
	 * This is also where the relevant request elements will be logged to the relative
	 * response sections.
	 *
	 * The method is called by the constructor and should be overloaded to handle derived
	 * classes custom elements.
	 *
	 * @access protected
	 *
	 * @uses _ParseLanguage()
	 * @uses _ParsePredicate()
	 * @uses _ParseRelation()
	 * @uses _ParseSubquery()
	 */
	protected function _ParseRequest()
	{
		//
		// Call parent method.
		//
		parent::_ParseRequest();
		
		//
		// Handle parameters.
		//
		$this->_ParseLanguage();
		$this->_ParsePredicate();
		$this->_ParseRelation();
		$this->_ParseSubquery();
	
	} // _ParseRequest.

	 
	/*===================================================================================
	 *	_FormatRequest																	*
	 *==================================================================================*/

	/**
	 * Format request.
	 *
	 * This method should perform any needed formatting before the request will be handled.
	 *
	 * In this class we handle the parameters to be decoded
	 *
	 * @access protected
	 *
	 * @uses _FormatLanguage()
	 * @uses _FormatPredicate()
	 * @uses _FormatRelation()
	 * @uses _FormatSubquery()
	 */
	protected function _FormatRequest()
	{
		//
		// Call parent method.
		//
		parent::_FormatRequest();
		
		//
		// Handle parameters.
		//
		$this->_FormatLanguage();
		$this->_FormatPredicate();
		$this->_FormatRelation();
		$this->_FormatSubquery();
	
	} // _FormatRequest.

	 
	/*===================================================================================
	 *	_ValidateRequest																*
	 *==================================================================================*/

	/**
	 * Validate request.
	 *
	 * This method should check that the request is valid and that all required parameters
	 * have been sent.
	 *
	 * In this class we check the {@link kAPI_FORMAT} and {@link kAPI_OPERATION} codes
	 * (their presence is checked by the constructor.
	 *
	 * @access protected
	 *
	 * @uses _ValidateLanguage()
	 * @uses _ValidatePredicate()
	 * @uses _ValidateRelation()
	 * @uses _ValidateSubquery()
	 */
	protected function _ValidateRequest()
	{
		//
		// Call parent method.
		//
		parent::_ValidateRequest();
		
		//
		// Validate parameters.
		//
		$this->_ValidateLanguage();
		$this->_ValidatePredicate();
		$this->_ValidateRelation();
		$this->_ValidateSubquery();
	
	} // _ValidateRequest.

		

/*=======================================================================================
 *																						*
 *							PROTECTED INITIALISATION INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_InitParameters																	*
	 *==================================================================================*/

	/**
	 * Initialise parameters.
	 *
	 * This method is responsible for initialising the parameters of the request, in this
	 * class we decode all local parameters.
	 *
	 * @access protected
	 */
	protected function _InitParameters()
	{
		//
		// Call parent method.
		//
		parent::_InitParameters();
		
		//
		// Init local parameters.
		//
		foreach( self::$sParameterList as $param )
			$this->_DecodeParameter( $param );
	
	} // _InitParameters.

		

/*=======================================================================================
 *																						*
 *								PROTECTED PARSING UTILITIES								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_ParseOperation																	*
	 *==================================================================================*/

	/**
	 * Parse operation.
	 *
	 * We overload this method to perform the following customisations:
	 *
	 * <ul>
	 *	<li><li><i>Page limits enforcement</i>: If omitted, the page limits are set to the
	 *		default {@link kAPI_PAGE_LIMIT} value.
	 *	<li><li><i>Container name</i>: Depending on the operation, if omitted, the container
	 *		name will be set to its default value.
	 * </ul>
	 *
	 * @access protected
	 *
	 * @see kAPI_OPERATION
	 */
	protected function _ParseOperation()
	{
		//
		// Save operation in request mirror, if necessary.
		//
		parent::_ParseOperation();
	
		//
		// Normalise parameters.
		//
		switch( $_REQUEST[ kAPI_OPERATION ] )
		{
			case kAPI_OP_GetTerm:
				//
				// Set page limit.
				//
				if( ! array_key_exists( kAPI_PAGE_LIMIT, $_REQUEST ) )
					$_REQUEST[ kAPI_PAGE_LIMIT ] = kDEFAULT_LIMIT;
				
				//
				// Set terms container.
				//
				if( ! array_key_exists( kAPI_CONTAINER, $_REQUEST ) )
					$_REQUEST[ kAPI_CONTAINER ] = COntologyTerm::DefaultContainerName();

				break;

			case kAPI_OP_GetNode:
			case kAPI_OP_GetVertex:
				//
				// Set page limit.
				//
				if( ! array_key_exists( kAPI_PAGE_LIMIT, $_REQUEST ) )
					$_REQUEST[ kAPI_PAGE_LIMIT ] = kDEFAULT_LIMIT;
				
				//
				// Set vertex container.
				//
				if( ! array_key_exists( kAPI_CONTAINER, $_REQUEST ) )
					$_REQUEST[ kAPI_CONTAINER ] = COntologyNode::DefaultContainerName();

				break;
		}
	
	} // _ParseOperation.

	 
	/*===================================================================================
	 *	_ParseLanguage																	*
	 *==================================================================================*/

	/**
	 * Parse language.
	 *
	 * This method will copy the language parameter to the request block.
	 *
	 * @access protected
	 *
	 * @uses _OffsetManage()
	 *
	 * @see kAPI_LANGUAGE kAPI_REQUEST
	 */
	protected function _ParseLanguage()
	{
		//
		// Handle database.
		//
		if( array_key_exists( kAPI_LANGUAGE, $_REQUEST ) )
		{
			if( $this->offsetExists( kAPI_REQUEST ) )
				$this->_OffsetManage
					( kAPI_REQUEST, kAPI_LANGUAGE, $_REQUEST[ kAPI_LANGUAGE ] );
		}
	
	} // _ParseLanguage.

	 
	/*===================================================================================
	 *	_ParsePredicate																	*
	 *==================================================================================*/

	/**
	 * Parse container.
	 *
	 * This method will copy the predicate parameter to the request block.
	 *
	 * @access protected
	 *
	 * @uses _OffsetManage()
	 *
	 * @see kAPI_PREDICATE kAPI_REQUEST
	 */
	protected function _ParsePredicate()
	{
		//
		// Handle database.
		//
		if( array_key_exists( kAPI_PREDICATE, $_REQUEST ) )
		{
			if( $this->offsetExists( kAPI_REQUEST ) )
				$this->_OffsetManage
					( kAPI_REQUEST, kAPI_PREDICATE, $_REQUEST[ kAPI_PREDICATE ] );
		}
	
	} // _ParsePredicate.

	 
	/*===================================================================================
	 *	_ParseRelation																	*
	 *==================================================================================*/

	/**
	 * Parse query.
	 *
	 * This method will copy the relation to the request block.
	 *
	 * @access protected
	 *
	 * @uses _OffsetManage()
	 *
	 * @see kAPI_RELATION kAPI_REQUEST
	 */
	protected function _ParseRelation()
	{
		//
		// Handle query.
		//
		if( array_key_exists( kAPI_RELATION, $_REQUEST ) )
		{
			if( $this->offsetExists( kAPI_REQUEST ) )
				$this->_OffsetManage
					( kAPI_REQUEST, kAPI_RELATION, $_REQUEST[ kAPI_RELATION ] );
		}
	
	} // _ParseRelation.

	 
	/*===================================================================================
	 *	_ParseSubquery																	*
	 *==================================================================================*/

	/**
	 * Parse sub-query.
	 *
	 * This method will copy the sub-query to the request block.
	 *
	 * @access protected
	 *
	 * @uses _OffsetManage()
	 *
	 * @see kAPI_SUBQUERY kAPI_REQUEST
	 */
	protected function _ParseSubquery()
	{
		//
		// Handle query.
		//
		if( array_key_exists( kAPI_SUBQUERY, $_REQUEST ) )
		{
			if( $this->offsetExists( kAPI_REQUEST ) )
				$this->_OffsetManage
					( kAPI_REQUEST, kAPI_SUBQUERY, $_REQUEST[ kAPI_SUBQUERY ] );
		}
	
	} // _ParseSubquery.

		

/*=======================================================================================
 *																						*
 *							PROTECTED FORMATTING UTILITIES								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_FormatLanguage																	*
	 *==================================================================================*/

	/**
	 * Format language parameters.
	 *
	 * This method will format the provided language codes, if the language was provided as
	 * a scalar, it will be converted to an array.
	 *
	 * @access protected
	 *
	 * @see kAPI_LANGUAGE
	 */
	protected function _FormatLanguage()
	{
		//
		// Check parameter.
		//
		if( array_key_exists( kAPI_LANGUAGE, $_REQUEST ) )
		{
			//
			// Set to array.
			//
			if( ! is_array( $_REQUEST[ kAPI_LANGUAGE ] ) )
				$_REQUEST[ kAPI_LANGUAGE ] = array( $_REQUEST[ kAPI_LANGUAGE ] );
		}
	
	} // _FormatLanguage.

	 
	/*===================================================================================
	 *	_FormatPredicate																*
	 *==================================================================================*/

	/**
	 * Format language parameters.
	 *
	 * This method will format the provided predicate references, if the predicate was
	 * provided as a scalar, it will be converted to an array.
	 *
	 * @access protected
	 *
	 * @see kAPI_PREDICATE
	 */
	protected function _FormatPredicate()
	{
		//
		// Check parameter.
		//
		if( array_key_exists( kAPI_PREDICATE, $_REQUEST ) )
		{
			if( ! is_array( $_REQUEST[ kAPI_PREDICATE ] ) )
				$_REQUEST[ kAPI_PREDICATE ] = array( $_REQUEST[ kAPI_PREDICATE ] );
		}
	
	} // _FormatPredicate.

	 
	/*===================================================================================
	 *	_FormatRelation																	*
	 *==================================================================================*/

	/**
	 * Format language parameters.
	 *
	 * This method should format the provided relation sense code, in this class we do
	 * nothing.
	 *
	 * @access protected
	 *
	 * @see kAPI_RELATION
	 */
	protected function _FormatRelation()												   {}

	 
	/*===================================================================================
	 *	_FormatSubquery																	*
	 *==================================================================================*/

	/**
	 * Format sub-query.
	 *
	 * The main duty of this method is to format the provided sub-query. This parameter will be
	 * provided as a standard {@link CQuery} derived instance.
	 *
	 * In this class we do nothing, derived classes may overload this method to customise
	 * the structure before it gets validated.
	 *
	 * @access protected
	 *
	 * @see kAPI_SUBQUERY
	 */
	protected function _FormatSubquery()												   {}

		

/*=======================================================================================
 *																						*
 *							PROTECTED VALIDATION UTILITIES								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_ValidateOperation																*
	 *==================================================================================*/

	/**
	 * Validate request operation.
	 *
	 * This method can be used to check whether the provided {@link kAPI_OPERATION}
	 * parameter is valid, in this class we screen and check the dependencies of the
	 * following operations:
	 *
	 * <ul>
	 *	<li><tt>{@link kAPI_OP_GetTerm} and {@link kAPI_OP_GetNode}</tt>: The following are
	 *		checked:
	 *	 <ul>
	 *		<li><tt>{@link kAPI_FORMAT}</tt>: The encoding format is required.
	 *		<li><tt>{@link kAPI_DATABASE}</tt>: The database is required.
	 *		<li><tt>{@link kAPI_SUBQUERY}</tt>: The subquery is cleared.
	 *	 </ul>
	 *	<li><tt>{@link kAPI_OP_GetVertex}</tt>: The following are checked:
	 *	 <ul>
	 *		<li><tt>{@link kAPI_FORMAT}</tt>: The encoding format is required.
	 *		<li><tt>{@link kAPI_DATABASE}</tt>: The database is required.
	 *		<li><tt>{@link kAPI_SUBQUERY}</tt>: The subquery is cleared if the
	 *			{@link kAPI_RELATION} parameter is missing.
	 *	 </ul>
	 * </ul>
	 *
	 * @access protected
	 *
	 * @see kAPI_OP_COUNT
	 */
	protected function _ValidateOperation()
	{
		//
		// Check parameter.
		//
		switch( $parameter = $_REQUEST[ kAPI_OPERATION ] )
		{
			case kAPI_OP_GetTerm:
			case kAPI_OP_GetNode:
				//
				// Check for database.
				//
				if( ! array_key_exists( kAPI_DATABASE, $_REQUEST ) )
					throw new CException
						( "Missing database parameter",
						  kERROR_MISSING,
						  kSTATUS_ERROR,
						  array( 'Operation' => $parameter ) );					// !@! ==>
					
				//
				// Check for format.
				//
				if( ! array_key_exists( kAPI_FORMAT, $_REQUEST ) )
					throw new CException
						( "Missing format parameter",
						  kERROR_MISSING,
						  kSTATUS_ERROR,
						  array( 'Operation' => $parameter ) );					// !@! ==>
				
				//
				// Clear subquery.
				//
				if( array_key_exists( kAPI_SUBQUERY, $_REQUEST ) )
					unset( $_REQUEST[ kAPI_SUBQUERY ] );
				
				break;
			
			case kAPI_OP_GetVertex:
				//
				// Check for database.
				//
				if( ! array_key_exists( kAPI_DATABASE, $_REQUEST ) )
					throw new CException
						( "Missing database parameter",
						  kERROR_MISSING,
						  kSTATUS_ERROR,
						  array( 'Operation' => $parameter ) );					// !@! ==>
					
				//
				// Check for format.
				//
				if( ! array_key_exists( kAPI_FORMAT, $_REQUEST ) )
					throw new CException
						( "Missing format parameter",
						  kERROR_MISSING,
						  kSTATUS_ERROR,
						  array( 'Operation' => $parameter ) );					// !@! ==>
				
				//
				// Clear subquery.
				//
				if( ! array_key_exists( kAPI_RELATION, $_REQUEST ) )
				{
					if( array_key_exists( kAPI_SUBQUERY, $_REQUEST ) )
						unset( $_REQUEST[ kAPI_SUBQUERY ] );
				}
				
				break;
			
			//
			// Handle unknown operation.
			//
			default:
				parent::_ValidateOperation();
				break;
			
		} // Parsing parameter.
	
	} // _ValidateOperation.

	 
	/*===================================================================================
	 *	_ValidateQuery																	*
	 *==================================================================================*/

	/**
	 * Validate query parameters.
	 *
	 * In this class we handle the {@link kAPI_OP_GetTerm} and {@link kAPI_OP_GetNode}
	 * services: all references to the {@link kTAG_NAMESPACE} or {@link kTAG_TERM}
	 * attributes with type different than {@link kTYPE_kTYPE_BINARY_STRING} will be
	 * interpreted as the {@link kTAG_GID} of the term and converted to a term native
	 * identifier.
	 *
	 * @access protected
	 *
	 * @see kAPI_QUERY
	 */
	protected function _ValidateQuery()
	{
		//
		// Call parent method.
		//
		parent::_ValidateQuery();
	
		//
		// Check parameter and service.
		//
		if( array_key_exists( kAPI_QUERY, $_REQUEST ) )
		{
			//
			// Parse by operation.
			//
			switch( $_REQUEST[ kAPI_OPERATION ] )
			{
				case kAPI_OP_GetTerm:
				case kAPI_OP_GetNode:
					$this->_NormaliseTermReferences( $_REQUEST[ kAPI_QUERY ] );
					break;
			}
		}

	} // _ValidateQuery.

	 
	/*===================================================================================
	 *	_ValidateLanguage																*
	 *==================================================================================*/

	/**
	 * Validate language parameters.
	 *
	 * The duty of this method is to validate the language parameters, someday I will
	 * validate language codes, in this class we do nothing.
	 *
	 * @access protected
	 *
	 * @see kAPI_LANGUAGE
	 */
	protected function _ValidateLanguage()												   {}

	 
	/*===================================================================================
	 *	_ValidatePredicate																*
	 *==================================================================================*/

	/**
	 * Validate predicate parameters.
	 *
	 * The duty of this method is to validate the predicate parameters, in this class we
	 * resolve the predicate and replace the provided references with their native
	 * identifiers.
	 *
	 * @access protected
	 *
	 * @see kAPI_PREDICATE
	 */
	protected function _ValidatePredicate()
	{
		//
		// Check parameter.
		//
		if( array_key_exists( kAPI_PREDICATE, $_REQUEST ) )
		{
			//
			// Get container.
			//
			$container = COntologyTerm::DefaultContainer( $_REQUEST[ kAPI_DATABASE ] );
			
			//
			// Iterate predicate identifiers.
			//
			foreach( $_REQUEST[ kAPI_PREDICATE ] as $key => $value )
			{
				//
				// Unserialise predicate.
				//
				$container->UnserialiseObject( $value );
				
				//
				// Resolve predicate.
				//
				$predicate = COntologyTerm::Resolve( $container, $value );
				if( $predicate !== NULL )
					$_REQUEST[ kAPI_PREDICATE ][ $key ] = $predicate[ kTAG_NID ];
				else
					unset( $_REQUEST[ kAPI_PREDICATE ][ $key ] );
			
			} // Iterating provided predicates.
			
			//
			// Remove empty list.
			//
			if( ! count( $_REQUEST[ kAPI_PREDICATE ] ) )
				unset( $_REQUEST[ kAPI_PREDICATE ] );
		
		} // Provided predicate parameters.
	
	} // _ValidatePredicate.

	 
	/*===================================================================================
	 *	_ValidateRelation																*
	 *==================================================================================*/

	/**
	 * Validate relationship sense parameters.
	 *
	 * The duty of this method is to validate the relationship sense parameters, in this
	 * class we raise an exception if the relationship code is not recognised.
	 *
	 * @access protected
	 *
	 * @see kAPI_RELATION
	 */
	protected function _ValidateRelation()
	{
		//
		// Check parameter.
		//
		if( array_key_exists( kAPI_RELATION, $_REQUEST ) )
		{
			//
			// Check relationship code.
			//
			if( ! in_array
					( $_REQUEST[ kAPI_RELATION ],
					  array( kAPI_RELATION_IN, kAPI_RELATION_OUT, kAPI_RELATION_ALL ) ) )
				throw new CException
					( ("Unsupported relationship sense code ("
					  .$_REQUEST[ kAPI_RELATION ].")"),
					  kERROR_PARAMETER,
					  kSTATUS_ERROR );									// !@! ==>
		
		} // Provided predicate parameters.
	
	} // _ValidateRelation.

	 
	/*===================================================================================
	 *	_ValidateSubquery																*
	 *==================================================================================*/

	/**
	 * Validate sub-query parameters.
	 *
	 * The duty of this method is to validate the sub-query parameter, in this class we will
	 * unserialise eventual serialised data types and convert the query into a
	 * {@link CQuery} instance.
	 *
	 * @access protected
	 *
	 * @see kAPI_SUBQUERY
	 */
	protected function _ValidateSubquery()
	{
		//
		// Check parameter.
		//
		if( array_key_exists( kAPI_SUBQUERY, $_REQUEST ) )
		{
			//
			// Check query type.
			//
			if( is_array( $_REQUEST[ kAPI_SUBQUERY ] ) )
			{
				//
				// Check container.
				// If there it should already be a CContainer instance.
				//
				if( array_key_exists( kAPI_CONTAINER, $_REQUEST ) )
				{
					//
					// Unserialise standard data types.
					//
					$_REQUEST[ kAPI_CONTAINER ]
						->UnserialiseObject( $_REQUEST[ kAPI_SUBQUERY ] );
					
					//
					// Format and verify query.
					//
					$this->_VerifyQuery( $_REQUEST[ kAPI_SUBQUERY ],
										 $_REQUEST[ kAPI_CONTAINER ] );
				
				} // Provided container.
				
				else
					throw new CException
						( "Unable to format sub-query: missing container",
						  kERROR_MISSING,
						  kSTATUS_ERROR );										// !@! ==>
			
			} // Query is an array.
			
			else
				throw new CException
					( "Unable to format sub-query: invalid query data type",
					  kERROR_PARAMETER,
					  kSTATUS_ERROR,
					  array( 'Type' => gettype(
					  	$_REQUEST[ kAPI_SUBQUERY ] ) ) );						// !@! ==>
		
		} // Provided query parameter.
	
	} // _ValidateSubquery.

		

/*=======================================================================================
 *																						*
 *								PROTECTED HANDLER INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_HandleRequest																	*
	 *==================================================================================*/

	/**
	 * Handle request.
	 *
	 * This method will handle the request.
	 *
	 * @access protected
	 */
	protected function _HandleRequest()
	{
		//
		// Check operation.
		//
		if( array_key_exists( kAPI_OPERATION, $_REQUEST ) )
		{
			//
			// Parse by operation.
			//
			switch( $_REQUEST[ kAPI_OPERATION ] )
			{
				case kAPI_OP_GetTerm:
				case kAPI_OP_GetNode:
					$this->_Handle_GetOntologyElements();
					break;
	
				case kAPI_OP_GetVertex:
					$this->_Handle_GetVertex();
					break;
	
				default:
					parent::_HandleRequest();
					break;
			}
		
		} // Provided the request.
	
	} // _HandleRequest.

	 
	/*===================================================================================
	 *	_Handle_ListOp																	*
	 *==================================================================================*/

	/**
	 * Handle {@link kAPI_OP_HELP} operations request.
	 *
	 * This method will handle the locally supported operations.
	 *
	 * @param reference				$theList			Receives operations list.
	 *
	 * @access protected
	 */
	protected function _Handle_ListOp( &$theList )
	{
		//
		// Call parent method.
		//
		parent::_Handle_ListOp( $theList );

		//
		// Add kAPI_OP_GetTerm.
		//
		$theList[ kAPI_OP_GetTerm ]
			= 'Get terms by query: returns the list of terms that satisfy the provided query.';

		//
		// Add kAPI_OP_GetNode.
		//
		$theList[ kAPI_OP_GetNode ]
			= 'Get nodes by query: returns the list of nodes that satisfy the provided query.';

		//
		// Add kAPI_OP_GetVertex.
		//
		$theList[ kAPI_OP_GetVertex ]
			= 'Get vertex or related vertex by query: returns either the list of vertex that satisfy the provided query, or the list of vertex pointing to or pointed to by the vertex selected by the provided query.';
	
	} // _Handle_ListOp.

	 
	/*===================================================================================
	 *	_Handle_GetOntologyElements														*
	 *==================================================================================*/

	/**
	 * Retrieve ontology elements by query.
	 *
	 * This method will handle the following operations: {@link kAPI_OP_GetNerm} and
	 * {@link kAPI_OP_GetNode} operations, it will return respectively the terms and nodes
	 * that match the provided query, including related elements such as tags.
	 *
	 * @access protected
	 */
	protected function _Handle_GetOntologyElements()
	{
		//
		// Init local storage.
		//
		$query = $select = $sort = $start = $limit = NULL;
		
		//
		// Handle query.
		//
		if( array_key_exists( kAPI_QUERY, $_REQUEST ) )
			$query = $_REQUEST[ kAPI_QUERY ];
		
		//
		// Handle sort.
		//
		if( array_key_exists( kAPI_SORT, $_REQUEST ) )
			$sort = $_REQUEST[ kAPI_SORT ];
		
		//
		// Handle paging.
		//
		if( $this->offsetExists( kAPI_PAGING ) )
		{
			$start = $this->offsetGet( kAPI_PAGING )[ kAPI_PAGE_START ];
			$limit = $this->offsetGet( kAPI_PAGING )[ kAPI_PAGE_LIMIT ];
		}
		
		//
		// Get records.
		//
		$records
			= $_REQUEST[ kAPI_CONTAINER ]
				->Query( $query, $select, $sort, $start, $limit );
		
		//
		// Set affected count.
		//
		$this->_OffsetManage(
			kAPI_STATUS, kAPI_AFFECTED_COUNT, $records->count( FALSE ) );
		
		//
		// Handle page count.
		//
		if( $this->offsetExists( kAPI_PAGING ) )
		{
			$tmp = $this->offsetGet( kAPI_PAGING );
			$tmp[ kAPI_PAGE_COUNT ] = $records->count( TRUE );
			$this->offsetSet( kAPI_PAGING, $tmp );
		}
		
		//
		// Check count.
		//
		if( $records->count( FALSE ) )
		{
			//
			// Iterate recordset.
			//
			foreach( $records as $object )
			{
				//
				// Instantiate object.
				//
				$object = CPersistentObject::DocumentObject( $object );
				
				//
				// Load related data.
				//
				switch( $_REQUEST[ kAPI_OPERATION ] )
				{
					case kAPI_OP_GetTerm:
						$this->_ExportTerm( $results, $object );
						$results[ kAPI_COLLECTION_ID ][] = $object->offsetGet( kTAG_GID );
						break;
						
					case kAPI_OP_GetNode:
						$this->_ExportNode( $results, $object );
						$results[ kAPI_COLLECTION_ID ][] = $object->offsetGet( kTAG_NID );
						break;

					default:
						throw new CException
							( "Unsupported operation in service handler",
							  kERROR_PARAMETER,
							  kSTATUS_ERROR,
							  array( 'Operation'
							  			=> $_REQUEST[ kAPI_OPERATION ] ) );		// !@! ==>
				}
			
			} // Iterating found terms.
			
			//
			// Set results.
			//
			$this->offsetSet( kAPI_RESPONSE, $results );
		
			//
			// Handle language.
			//
			if( array_key_exists( kAPI_LANGUAGE, $_REQUEST ) )
				$this->_FilterLanguages( $_REQUEST[ kAPI_LANGUAGE ] );
		
		} // Found edges.
	
	} // _Handle_GetOntologyElements.

	 
	/*===================================================================================
	 *	_Handle_GetVertex																*
	 *==================================================================================*/

	/**
	 * Handle {@link kAPI_OP_GetVertex} request.
	 *
	 * This method will handle the {@link kAPI_OP_GetVertex} operation, which returns either
	 * the list of vertex satisfying the provided query, or the related vertices of the
	 * vertex selected by the provided query.
	 *
	 * If the {@link kAPI_RELATION} parameter is provided, it is assumed that you want the
	 * vertices related to the first vertex matched by the provided query, in that case the
	 * service will return a list of vertices that either point to the matched vertex,
	 * pointed to by the reference vertex, or both.
	 *
	 * If the latter parameter is provided, the service may optionally receive the
	 * {@link kAPI_SUBQUERY} parameter which represents a filter or query that will be
	 * applied to the related elements (not to the result of the {@link kAPI_QUERY} filter).
	 *
	 * If the {@link kAPI_RELATION} parameter is not provided, the service will return the
	 * vertices that match the provided query.
	 *
	 * If the query is omitted, the service will use the provided or default nodes
	 * container.
	 *
	 * @access protected
	 */
	protected function _Handle_GetVertex()
	{
		//
		// Init local storage.
		//
		$query = $select = $sort = $start = $limit = NULL;
		
		//
		// Handle query.
		//
		if( array_key_exists( kAPI_QUERY, $_REQUEST ) )
			$query = $_REQUEST[ kAPI_QUERY ];
		
		//
		// Handle select.
		//
		if( array_key_exists( kAPI_RELATION, $_REQUEST ) )
			$select = array( kTAG_NID );
		
		//
		// Handle sort.
		//
		if( array_key_exists( kAPI_RELATION, $_REQUEST ) )
			$sort = NULL;
		elseif( array_key_exists( kAPI_SORT, $_REQUEST ) )
			$sort = $_REQUEST[ kAPI_SORT ];
		
		//
		// Handle paging.
		//
		if( $this->offsetExists( kAPI_PAGING ) )
		{
			$start = $this->offsetGet( kAPI_PAGING )[ kAPI_PAGE_START ];
			$limit = $this->offsetGet( kAPI_PAGING )[ kAPI_PAGE_LIMIT ];
		}
		
		//
		// Get reference vertex(ices).
		//
		$vertex = ( array_key_exists( kAPI_RELATION, $_REQUEST ) )
				? $_REQUEST[ kAPI_CONTAINER ]
					->Query( $query, $select, $sort, $start, $limit, TRUE )
				: $_REQUEST[ kAPI_CONTAINER ]
					->Query( $query, $select, $sort, $start, $limit );
		
		//
		// Handle vertex relationships.
		//
		if( array_key_exists( kAPI_RELATION, $_REQUEST ) )
		{
			//
			// Handle reference vertex.
			//
			if( $vertex !== NULL )
			{
				//
				// Get related.
				//
				$results = $this->_GetVertexRelations( $vertex[ kTAG_NID ] );
				if( $results !== NULL )
					$this->offsetSet( kAPI_RESPONSE, $results );
			
			} // Found reference vertex.
		
		} // Provided relationship sense.
		
		//
		// Handle reference vertices.
		//
		else
		{
			//
			// Get vertex list.
			//
			$results = $this->_GetVertexFromNodes( $vertex );
			if( $results !== NULL )
				$this->offsetSet( kAPI_RESPONSE, $results );
		
		} // Handle vertex.
		
		//
		// Handle language.
		//
		if( array_key_exists( kAPI_LANGUAGE, $_REQUEST ) )
			$this->_FilterLanguages( $_REQUEST[ kAPI_LANGUAGE ] );
	
	} // _Handle_GetVertex.

		

/*=======================================================================================
 *																						*
 *								PROTECTED ONTOLOGY INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_ExportTerm																		*
	 *==================================================================================*/

	/**
	 * <h4>Export a predicate</h4>
	 *
	 * The main duty of this method is to normalise and merge the provided term's attributes
	 * and place this information in the related provided collection container.
	 *
	 * The method expects the following parameters:
	 *
	 * <ul>
	 *	<li><tt>&$theCollection</tt>: This parameter is a reference to an array that will
	 *		receive the object attributes, the array holds four lists that collect similar
	 *		objects, such as nodes, terms, edges and tags:
	 *	 <ul>
	 *		<li><tt>{@link kAPI_COLLECTION_ID}</tt>: This element is an array that holds the
	 *			identifiers list of the requested elements. This list holds the reference to
	 *			the object which is contained by the other elements of the collection, this
	 *			list refers to the elements requested by the service.
	 *		<li><tt>{@link kAPI_COLLECTION_TERM}</tt>: This element is an array that
	 *			holds the list of predicate terms referenced by all other objects in the
	 *			collection. The array keys will be the term's {@link kTAG_GID} and the value
	 *			will be the attributes of the term. The contents of this element are fed by
	 *			the {@link _BuildTerm()} protected method and the elements are provided by
	 *			this method.
	 *		<li><tt>{@link kAPI_COLLECTION_NODE}</tt>: This element is an array that holds
	 *			a list of node vertex. A vertex is the combination of the node attributes
	 *			merged with the referenced term attributes. The items of this list are
	 *			indexed by the node {@link kTAG_NID} and eventual term attributes are
	 *			overwritten by matching node attributes. The contents of this element are
	 *			fed by the {@link _BuildNode()} protected method.
	 *		<li><tt>{@link kAPI_COLLECTION_EDGE}</tt>: This element is an array that holds
	 *			a list of edges, the array keys will be the edge's {@link kTAG_GID} and the
	 *			value will be the edge's attributes. The contents of this element are fed by
	 *			the {@link _BuildEdge()} protected method.
	 *		<li><tt>{@link kAPI_COLLECTION_TAG}</tt>: This element is an array that holds
	 *			a list of tags, the array indexes will be the tag {@link kTAG_NID} and
	 *			the array values will be the tag {@link kTAG_PATH} and {@link kTAG_GID},
	 *			where the {@link kTAG_PATH} predicate references will be set to the term
	 *			{@link kTAG_GID}.
	 *	 </ul>
	 *	<li><tt>$theTerm</tt>: This parameter represents the vertex node full object; this
	 *		means that all attributes should be present, since this method will take care of
	 *		removing unwanted attributes. The parameter may represent a list of node objects
	 *		or references, a reference or an object:
	 *	 <ul>
	 *		<li><tt>array</tt>: Each element of the list will be fed to this method
	 *			recursively.
	 *		<li><tt>COntologyNode</tt>: The object will be used as is.
	 *		<li><i>other</i>: Any other type will be interpreted as a node reference.
	 *	 </ul>
	 *	<li><tt>$theAttributes</tt>: This optional parameter can be used to limit the
	 *		returned attributes to the list provided in this array.
	 *	<li><tt>$doTags</tt>: If this flag is <tt>TRUE</tt>, the method will load the tags;
	 *		if <tt>FALSE</tt> no tags will be loaded.
	 * </ul>
	 *
	 * The method will generate an array containing the merged attributes of the node and
	 * the referenced term, this array will be set in the {@link kAPI_COLLECTION_NODE} of
	 * the <tt>&$theCollection</tt> parameter with as index the node {@link kTAG_NID}
	 * that will ve added to the {@link kAPI_COLLECTION_ID} element of the collection.
	 *
	 * If a matching vertex already exists in the <tt>&$theCollection</tt> parameter, the
	 * method will do nothing.
	 *
	 * For more information please consult the {@link _BuildNode()} method reference, note
	 * that this method will remove the {@link kTAG_NID} attribute from the node, it
	 * will only use this information to index the node.
	 *
	 * The method will raise an exception if any element cannot be resolved.
	 *
	 * @param reference			   &$theCollection		Exported collection.
	 * @param mixed					$theTerm			Node identifier or list.
	 * @param boolean				$doTags				TRUE means load tags.
	 *
	 * @access protected
	 */
	protected function _ExportTerm( &$theCollection, $theTerm, $doTags = TRUE )
	{
		//
		// Init results structure.
		//
		if( ! is_array( $theCollection ) )
			$theCollection = array( kAPI_COLLECTION_ID => Array(),
									kAPI_COLLECTION_TERM => Array(),
									kAPI_COLLECTION_NODE => Array(),
									kAPI_COLLECTION_EDGE => Array(),
									kAPI_COLLECTION_TAG => Array() );
		
		//
		// Handle list.
		//
		if( is_array( $theTerm ) )
		{
			//
			// Iterate list.
			//
			foreach( $theTerm as $item )
				$this->_ExportTerm( $theCollection, $item, $doTags );
		
		} // Provided list.
		
		//
		// Handle object or reference.
		//
		else
		{
			//
			// Build term.
			//
			$theTerm = $this->_BuildTerm( $theTerm );
				
			//
			// Check if term is new.
			//
			$id = $theTerm[ kTAG_GID ];
			if( ! array_key_exists( $id, $theCollection[ kAPI_COLLECTION_TERM ] ) )
			{
				//
				// Reduce attributes.
				//
				if( array_key_exists( kAPI_SELECT, $_REQUEST ) )
				{
					//
					// Iterate vertex attributes.
					//
					foreach( $theTerm as $key => $value )
					{
						//
						// Remove excluded.
						//
						if( ! in_array( $key, $_REQUEST[ kAPI_SELECT ] ) )
							unset( $theTerm[ $key ] );
					
					} // Iterating term attributes.
				
				} // Provided selection.
				
				//
				// Save term.
				//
				CDataType::SerialiseObject( $theTerm );
				$theCollection[ kAPI_COLLECTION_TERM ][ $id ] = $theTerm;
				
				//
				// Get term tags.
				//
				if( $doTags )
					$this->_ExportTag( $theCollection, array_keys( $theTerm ) );
			
			} // New term.
		
		} // Provided object or reference. 
		
	} // _ExportTerm.
	
	
	/*===================================================================================
	 *	_ExportNode																		*
	 *==================================================================================*/

	/**
	 * <h4>Export a vertex</h4>
	 *
	 * The main duty of this method is to export a collection of vertex nodes into a series
	 * of collections each holding a class of data. The method will have to resolve eventual
	 * references and store the resolved data in their corresponding collection.
	 *
	 * The method expects the following parameters:
	 *
	 * <ul>
	 *	<li><tt>&$theCollection</tt>: This parameter is a reference to an array that will
	 *		receive the object attributes, the array holds four lists that collect objects
	 *		of the same class:
	 *	 <ul>
	 *		<li><tt>{@link kAPI_COLLECTION_ID}</tt>: This element is an array that holds the
	 *			identifiers list of the requested elements. Depending on what was requested,
	 *			this list will hold term, node, edge or tag identifiers.
	 *		<li><tt>{@link kAPI_COLLECTION_TERM}</tt>: This element is an array that holds
	 *			the list of terms referenced by all other objects in the collection. The
	 *			array keys will be the term's {@link kTAG_GID} and the value the term
	 *			attributes. The contents of this element are fed by the {@link _BuildTerm()}
	 *			protected method.
	 *		<li><tt>{@link kAPI_COLLECTION_NODE}</tt>: This element is an array that holds
	 *			a list of node vertex. A vertex is the combination of the node attributes
	 *			merged with the referenced term attributes. The items of this list are
	 *			indexed by the node {@link kTAG_NID} and eventual term attributes are
	 *			overwritten by matching node attributes. The contents of this element are
	 *			fed by the {@link _BuildNode()} protected method.
	 *		<li><tt>{@link kAPI_COLLECTION_EDGE}</tt>: This element is an array that holds
	 *			a list of edges, the array keys will be the edge's {@link kTAG_GID} and the
	 *			value will be the edge's attributes. The contents of this element are fed by
	 *			the {@link _BuildEdge()} protected method.
	 *		<li><tt>{@link kAPI_COLLECTION_TAG}</tt>: This element is an array that holds
	 *			a list of tags, the array indexes will be the tag {@link kTAG_NID} and
	 *			the array values will be the tag {@link kTAG_PATH} and {@link kTAG_GID},
	 *			where the {@link kTAG_PATH} predicate references will be set to the term
	 *			{@link kTAG_GID}.
	 *	 </ul>
	 *	<li><tt>$theNode</tt>: This parameter represents the vertex node full object; this
	 *		means that all attributes should be present, since this method will take care of
	 *		removing unwanted attributes. The parameter may represent a list of node objects
	 *		or references, a reference or an object:
	 *	 <ul>
	 *		<li><tt>array</tt>: Each element of the list will be fed to this method
	 *			recursively.
	 *		<li><tt>COntologyNode</tt>: The object will be used as is.
	 *		<li><i>other</i>: Any other type will be interpreted as a node reference.
	 *	 </ul>
	 *	<li><tt>$theAttributes</tt>: This optional parameter can be used to limit the
	 *		returned attributes to the list provided in this array.
	 *	<li><tt>$doTags</tt>: If this flag is <tt>TRUE</tt>, the method will load the tags;
	 *		if <tt>FALSE</tt> no tags will be loaded.
	 * </ul>
	 *
	 * The method will generate an array containing the merged attributes of the node and
	 * the referenced term, this array will be set in the {@link kAPI_COLLECTION_NODE} of
	 * the <tt>&$theCollection</tt> parameter with as index the node {@link kTAG_NID}
	 * that will ve added to the {@link kAPI_COLLECTION_ID} element of the collection.
	 *
	 * If a matching vertex already exists in the <tt>&$theCollection</tt> parameter, the
	 * method will do nothing.
	 *
	 * For more information please consult the {@link _BuildNode()} method reference, note
	 * that this method will remove the {@link kTAG_NID} attribute from the node, it
	 * will only use this information to index the node.
	 *
	 * The method will raise an exception if any element cannot be resolved.
	 *
	 * @param reference			   &$theCollection		Exported collection.
	 * @param mixed					$theNode			Node identifier or list.
	 * @param boolean				$doTags				TRUE means load tags.
	 *
	 * @access protected
	 */
	protected function _ExportNode( &$theCollection, $theNode, $doTags = TRUE )
	{
		//
		// Init results structure.
		//
		if( ! is_array( $theCollection ) )
			$theCollection = array( kAPI_COLLECTION_ID => Array(),
									kAPI_COLLECTION_TERM => Array(),
									kAPI_COLLECTION_NODE => Array(),
									kAPI_COLLECTION_EDGE => Array(),
									kAPI_COLLECTION_TAG => Array() );
		
		//
		// Handle list.
		//
		if( is_array( $theNode ) )
		{
			//
			// Iterate list.
			//
			foreach( $theNode as $item )
				$this->_ExportNode( $theCollection, $item, $doTags );
		
		} // Provided list.
		
		//
		// Handle object or reference.
		//
		else
		{
			//
			// Extract ID.
			//
			$id = ( ! ($theNode instanceof COntologyNode) )
				? $theNode
				: $theNode[ kTAG_NID ];
				
			//
			// Check if vertex is new,.
			//
			if( ! array_key_exists( $id, $theCollection[ kAPI_COLLECTION_NODE ] ) )
			{
				//
				// Build vertex.
				//
				$theNode = $this->_BuildNode( $theNode );
				
				//
				// Export term.
				//
				$this->_ExportTerm( $theCollection, $theNode[ kTAG_TERM ], $doTags );
				
				//
				// Reduce attributes.
				//
				if( array_key_exists( kAPI_SELECT, $_REQUEST ) )
				{
					//
					// Iterate vertex attributes.
					//
					foreach( $theNode as $key => $value )
					{
						//
						// Remove excluded.
						//
						if( ! in_array( $key, $_REQUEST[ kAPI_SELECT ] ) )
							unset( $theNode[ $key ] );
					
					} // Iterating vertex attributes.
				
				} // Provided selection.
				
				//
				// Save vertex.
				//
				CDataType::SerialiseObject( $theNode );
				$theCollection[ kAPI_COLLECTION_NODE ][ $id ] = $theNode;
				
				//
				// Get vertex tags.
				//
				if( $doTags )
					$this->_ExportTag( $theCollection, array_keys( $theNode ) );
			
			} // New vertex.
		
		} // Provided object or reference. 
		
	} // _ExportNode.

	 
	/*===================================================================================
	 *	_ExportEdge																		*
	 *==================================================================================*/

	/**
	 * <h4>Export an edge</h4>
	 *
	 * The main duty of this method is to normalise the edge's attributes and store the
	 * referenced vertex and predicates in the relative elements of the provided collection.
	 *
	 * The method expects the following parameters:
	 *
	 * <ul>
	 *	<li><tt>&$theCollection</tt>: This parameter is a reference to an array that will
	 *		receive the object attributes, the array holds four lists that collect similar
	 *		objects, such as nodes, terms, edges and tags:
	 *	 <ul>
	 *		<li><tt>{@link kAPI_COLLECTION_ID}</tt>: This element is an array that holds the
	 *			identifiers list of the requested elements. This element should be filled by
	 *			the caller, since its content depend on what operation is going on.
	 *		<li><tt>{@link kAPI_COLLECTION_TERM}</tt>: This element is an array that
	 *			holds the list of predicate terms referenced by all other objects in the
	 *			collection. The array keys will be the term's {@link kTAG_GID} and the value
	 *			will be the attributes of the term. The contents of this element are fed
	 *			with the {@link _BuildTerm()} protected method to which the edge predicates
	 *			will be provided.
	 *		<li><tt>{@link kAPI_COLLECTION_NODE}</tt>: This element is an array that holds
	 *			a list of node vertex. A vertex is the combination of the node attributes
	 *			merged with the referenced term attributes. The items of this list are
	 *			indexed by the node {@link kTAG_NID} and eventual term attributes are
	 *			overwritten by matching node attributes. The contents of this element are
	 *			fed by the {@link _BuildNode()} protected method to which both the object
	 *			and subject vertices will be provided.
	 *		<li><tt>{@link kAPI_COLLECTION_EDGE}</tt>: This element is an array that holds
	 *			a list of edges, the array keys will be the edge's {@link kTAG_GID} and the
	 *			value will be the edge's attributes. The contents of this element are fed by
	 *			the {@link _BuildEdge()} protected method.
	 *		<li><tt>{@link kAPI_COLLECTION_TAG}</tt>: This element is an array that holds
	 *			a list of tags, the array indexes will be the tag {@link kTAG_NID} and
	 *			the array values will be the tag {@link kTAG_PATH} and {@link kTAG_GID},
	 *			where the {@link kTAG_PATH} predicate references will be set to the term
	 *			{@link kTAG_GID}.
	 *	 </ul>
	 *	<li><tt>$theEdge</tt>: This parameter represents the edge object or a list of edges:
	 *	 <ul>
	 *		<li><tt>array</tt>: A list of edges.
	 *		<li><tt>{@link COntologyEdge}</tt>: The edge will be used as-is.
	 *	 </ul>
	 * </ul>
	 *
	 * The method will omit the {@link kTAG_UID} and {@link kTAG_CLASS} attributes, the
	 * {@link kTAG_PREDICATE} attribute will be set to the term's {@link kTAG_GID} attribute
	 * and the two vertex references will be left untouched. The resulting array will be
	 * set into the {@link kOFFSET_EXPORT_EDGE} element of the provided collection.
	 *
	 * The method will raise an exception if any element cannot be resolved.
	 *
	 * @param reference			   &$theCollection		Exported collection.
	 * @param mixed					$theEdge			Edge or edges list.
	 * @param boolean				$doTags				TRUE means load tags.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _ExportEdge( &$theCollection, $theEdge, $doTags = TRUE )
	{
		//
		// Init results structure.
		//
		if( ! is_array( $theCollection ) )
			$theCollection = array( kAPI_COLLECTION_ID => Array(),
									kAPI_COLLECTION_TERM => Array(),
									kAPI_COLLECTION_NODE => Array(),
									kAPI_COLLECTION_EDGE => Array(),
									kAPI_COLLECTION_TAG => Array() );
		
		//
		// Handle list.
		//
		if( is_array( $theEdge ) )
		{
			//
			// Iterate list.
			//
			foreach( $theEdge as $item )
				$this->_ExportEdge( $theCollection, $item );
		
		} // Provided list.
		
		//
		// Handle object or reference.
		// ... skipping non existing tags...
		//
		elseif( $theEdge instanceof COntologyEdge )
		{
			//
			// Check if edge is new.
			//
			$id = $theEdge->offsetGet( kTAG_GID );
			if( ! array_key_exists( $id, $theCollection[ kAPI_COLLECTION_EDGE ] ) )
			{
				//
				// Init local storage.
				//
				$export = Array();
				$exclude = array( kTAG_CLASS, kTAG_UID, kTAG_GID,
								  kTAG_SUBJECT, kTAG_PREDICATE, kTAG_OBJECT );
				
				//
				// Handle subject vertex reference.
				//
				$export[ kTAG_SUBJECT ] = $theEdge->offsetGet( kTAG_SUBJECT );
				$this->_ExportNode( $theCollection, $export[ kTAG_SUBJECT ], $doTags );
				
				//
				// Resolve predicate.
				//
				$predicate
					= COntologyTerm::Resolve(
						$_REQUEST[ kAPI_DATABASE ],
						$theEdge->offsetGet( kTAG_PREDICATE ), NULL, TRUE );
				
				//
				// Handle predicate term reference.
				//
				$export[ kTAG_PREDICATE ] = $predicate->offsetGet( kTAG_GID );
				$this->_ExportTerm( $theCollection, $predicate, $doTags );
				
				//
				// Handle object vertex reference.
				//
				$export[ kTAG_OBJECT ] = $theEdge->offsetGet( kTAG_OBJECT );
				$this->_ExportNode( $theCollection, $export[ kTAG_OBJECT ], $doTags );
				
				//
				// Copy attributes.
				//
				foreach( $theEdge as $key => $value )
				{
					//
					// Skip excluded.
					//
					if( ! in_array( $key, $exclude ) )
					{
						//
						// Handle included.
						//
						if( (! array_key_exists( kAPI_SELECT, $_REQUEST ))
						 || (! in_array( $key, $_REQUEST[ kAPI_SELECT ] )) ) 
							$export[ $key ] = $theEdge->offsetGet( $key );
					
					} // Not excluded.
				
				} // Iterating edge attributes.
				
				//
				// Save edge.
				//
				CDataType::SerialiseObject( $export );
				$theCollection[ kAPI_COLLECTION_EDGE ][ $id ] = $export;
				
				//
				// Get vertex tags.
				//
				if( $doTags )
					$this->_ExportTag( $theCollection, array_keys( $export ) );
			
			} // New edge.
		
		} // Provided tag object or reference. 

	} // _ExportEdge.
	
	
	/*===================================================================================
	 *	_ExportTag																		*
	 *==================================================================================*/

	/**
	 * <h4>Export a tag</h4>
	 *
	 * The main duty of this method is to normalise the tag's attributes and store the
	 * referenced predicates and vertices in the relative elements of the provided
	 * collection.
	 *
	 * The method expects the following parameters:
	 *
	 * <ul>
	 *	<li><tt>&$theCollection</tt>: This parameter is a reference to an array that will
	 *		receive the object attributes, the array holds four lists that collect similar
	 *		objects, such as nodes, terms, edges and tags:
	 *	 <ul>
	 *		<li><tt>{@link kAPI_COLLECTION_ID}</tt>: This element is an array that holds the
	 *			identifiers list of the requested elements. This element is ignored by this
	 *			method.
	 *		<li><tt>{@link kAPI_COLLECTION_TERM}</tt>: This element is an array that
	 *			holds the list of predicate terms referenced by all other objects in the
	 *			collection. The array keys will be the term's {@link kTAG_GID} and the value
	 *			will be the attributes of the term. The contents of this element are fed by
	 *			the {@link _BuildTerm()} protected method.
	 *		<li><tt>{@link kAPI_COLLECTION_NODE}</tt>: This element is an array that holds
	 *			a list of node vertex. A vertex is the combination of the node attributes
	 *			merged with the referenced term attributes. The items of this list are
	 *			indexed by the node {@link kTAG_NID} and eventual term attributes are
	 *			overwritten by matching node attributes. The contents of this element are
	 *			fed by the {@link _BuildNode()} protected method.
	 *		<li><tt>{@link kAPI_COLLECTION_EDGE}</tt>: This element is an array that holds
	 *			a list of edges, the array keys will be the edge's {@link kTAG_GID} and the
	 *			value will be the edge's attributes. The contents of this element are fed by
	 *			the {@link _BuildEdge()} protected method.
	 *		<li><tt>{@link kAPI_COLLECTION_TAG}</tt>: This element is an array that holds
	 *			a list of tags, the array indexes will be the tag {@link kTAG_NID} and
	 *			the array values will be the tag {@link kTAG_PATH} and {@link kTAG_GID},
	 *			where the {@link kTAG_PATH} predicate references will be set to the term
	 *			{@link kTAG_GID}. This method will fill this element.
	 *	 </ul>
	 *	<li><tt>$theTag</tt>: This parameter represents the tag identifier, object or a
	 *		list of tag identifiers:
	 *	 <ul>
	 *		<li><tt>array</tt>: A list of tag or node identifiers.
	 *		<li><tt>{@link COntologyTag}</tt>: The tag will be used as-is.
	 *		<li><i>other</i>: Any other type will be interpreted as a tag reference and
	 *			resolved with {@link ResolveTag()}.
	 *	 </ul>
	 *	<li><tt>$theAttributes</tt>: This optional parameter can be used to limit the
	 *		returned attributes to the list provided in this array.
	 * </ul>
	 *
	 * The method will generate an array containing the merged attributes of the tag and the
	 * exported attributes of the referenced nodes, generated by the {@link _ExportNode()}
	 * protected method. The method will exclude the {@link kTAG_NID}, {@link kTAG_UID},
	 * and {@link kTAG_CLASS} from the tag, but append all others
	 * to the merged node and term attributes. The predicate elements of the
	 * {@link KTAG_PATH} attribute will be set to the referenced term's {@link kTAG_GID}.
	 * The resulting array will be set in the {@link kOFFSET_EXPORT_TAG} element of the
	 * provided collection using the tag's {@link kTAG_NID} attribute as index.
	 *
	 * The method will raise an exception if any element cannot be resolved.
	 *
	 * @param reference			   &$theCollection		Exported collection.
	 * @param mixed					$theTag				Tag identifier or list.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _ExportTag( &$theCollection, $theTag )
	{
		//
		// Init results structure.
		//
		if( ! is_array( $theCollection ) )
			$theCollection = array( kAPI_COLLECTION_ID => Array(),
									kAPI_COLLECTION_TERM => Array(),
									kAPI_COLLECTION_NODE => Array(),
									kAPI_COLLECTION_EDGE => Array(),
									kAPI_COLLECTION_TAG => Array() );
		
		//
		// Handle list.
		//
		if( is_array( $theTag ) )
		{
			//
			// Iterate list.
			//
			foreach( $theTag as $item )
				$this->_ExportTag( $theCollection, $item );
		
		} // Provided list.
		
		//
		// Handle object or reference.
		// ... skipping non existing tags...
		//
		elseif( $theTag != kTAG_NID )
		{
			//
			// Resolve tag identifier.
			//
			$id = ( ! ($theTag instanceof COntologyTag) )
				? $theTag
				: $theTag[ kTAG_NID ];
				
			//
			// Check if tag is new.
			//
			if( ! array_key_exists( $id, $theCollection[ kAPI_COLLECTION_TAG ] ) )
			{
				//
				// Resolve tag.
				//
				if( ! ($theTag instanceof COntologyTag) )
					$theTag = COntologyTag::Resolve(
									$_REQUEST[ kAPI_DATABASE ], $theTag, TRUE );
				
				//
				// Init local storage.
				//
				$export = Array();
				$exclude = array( kTAG_PATH, kTAG_UID, kTAG_CLASS, kTAG_NID );
				
				//
				// Save path.
				//
				$path = $theTag->offsetGet( kTAG_PATH );
				
				//
				// Iterate path elements.
				//
				for( $i = 0; $i < count( $path ); $i++ )
				{
					//
					// Resolve path element.
					//
					$term
						= COntologyTerm::Resolve(
							$_REQUEST[ kAPI_DATABASE ], $path[ $i ], NULL, TRUE );
					
					//
					// Handle term reference.
					//
					$path[ $i ] = $term->offsetGet( kTAG_GID );
					$this->_ExportTerm( $theCollection, $term );
				
				} // Iterating path elements.
				
				//
				// Store path in export.
				//
				$export[ kTAG_PATH ] = $path;
				
				//
				// Copy attributes.
				//
				foreach( $theTag as $key => $value )
				{
					//
					// Set by default type.
					//
					if( $key == kTAG_TYPE )
						$export[ $key ] = $theTag->offsetGet( $key );
					
					//
					// Skip excluded.
					//
					elseif( ! in_array( $key, $exclude ) )
					{
						//
						// Handle included.
						//
						if( (! array_key_exists( kAPI_SELECT, $_REQUEST ))
						 || (! in_array( $key, $_REQUEST[ kAPI_SELECT ] )) ) 
							$export[ $key ] = $theTag->offsetGet( $key );
					
					} // Not excluded.
				
				} // Iterating tag attributes.
				
				//
				// Save tag.
				//
				CDataType::SerialiseObject( $export );
				$theCollection[ kAPI_COLLECTION_TAG ][ $id ] = $export;
			
			} // New tag.
		
		} // Provided tag object or reference. 

	} // _ExportTag.

	 
	/*===================================================================================
	 *	_BuildTerm																		*
	 *==================================================================================*/

	/**
	 * <h4>Build a term</h4>
	 *
	 * The main duty of this method is to resolve the provided term reference and return a
	 * single object that holds a merged selection of attributes.
	 *
	 * By default we include the {@link kTAG_LID}, {@link kTAG_GID} and the
	 * {@link kTAG_NAMESPACE} (resolved into the referenced {@link kTAG_GID}) from the
	 * current term.
	 *
	 * We omit the {@link kTAG_NID}, {@link kTAG_CLASS}, {@link kTERM_TERM}, 
	 * {@link kTERM_NAMESPACE_REFS} and {@link kTERM_NODES}.
	 *
	 * All other attributes will either be included from the current term, or, if the term
	 * is related to another term through its {@link kTERM_TERM} attribute, from that
	 * term.
	 *
	 * The method will raise an exception if any element cannot be resolved.
	 *
	 * @param mixed					$theTerm			Term reference or object.
	 *
	 * @access public
	 * @return array				Exported term.
	 */
	public function _BuildTerm( $theTerm )
	{
		//
		// Resolve term.
		//
		if( ! ($theTerm instanceof COntologyTerm) )
			$theTerm = COntologyTerm::Resolve(
							$_REQUEST[ kAPI_DATABASE ], $theTerm, NULL, TRUE );
		
		//
		// Init local storage.
		//
		$export = Array();
		
		//
		// Load default attributes.
		//
		$export[ kTAG_GID ] = $theTerm[ kTAG_GID ];
		$export[ kTAG_LID ] = $theTerm[ kTAG_LID ];
		
		//
		// Resolve namespace.
		//
		if( ( is_array( $theTerm )
		   && array_key_exists( kTAG_NAMESPACE, $theTerm ) )
		 || ( ($theTerm instanceof COntologyTerm)
		   && $theTerm->offsetExists( kTAG_NAMESPACE ) ) )
			$export[ kTAG_NAMESPACE ]
				= COntologyTerm::Resolve(
					$_REQUEST[ kAPI_DATABASE ], $theTerm[ kTAG_NAMESPACE ], NULL, TRUE )
						->offsetGet( kTAG_GID );
		
		//
		// Resolve term references, if necessary.
		//
		while( ( is_array( $theTerm )
			  && array_key_exists( kTAG_TERM, $theTerm ) )
			|| ( ($theTerm instanceof COntologyTerm)
			  && $theTerm->offsetExists( kTAG_TERM ) ) )
			$theTerm
				= COntologyTerm::Resolve(
					$_REQUEST[ kAPI_DATABASE ], $theTerm[ kTAG_TERM ], NULL, TRUE );
		
		//
		// Copy attributes.
		//
		foreach( $theTerm as $key => $value )
		{
			if( ! in_array( $key, array( kTAG_GID, kTAG_LID ) ) )
				$export[ $key ] = $value;
		}
		
		return $export;																// ==>

	} // _BuildTerm.

		
	/*===================================================================================
	 *	_BuildNode																		*
	 *==================================================================================*/

	/**
	 * <h4>Build a vertex</h4>
	 *
	 * The main duty of this method is to resolve the provided node's references and return
	 * a single object that merges all its term and node attributes.
	 *
	 * Since we use a document database to store the graph vertices index, it is better to
	 * store referenced data in the vertex object, so that it is easier to search.
	 *
	 * In this class we therefore return the object as-is, in derived classes we can use
	 * this method for other purposes.
	 *
	 * @param mixed					$theNode			Node object.
	 *
	 * @access public
	 * @return array				Vertex object.
	 */
	public function _BuildNode( $theNode )
	{
		//
		// Resolve node.
		//
		if( ! ($theNode instanceof COntologyNode) )
			$theNode = COntologyVertex::Resolve( $_REQUEST[ kAPI_DATABASE ],
												 $theNode, TRUE );
		
		//
		// Init local storage.
		//
		$export = Array();
		
		//
		// Load node attributes.
		//
		foreach( $theNode as $key => $value )
			$export[ $key ] = $value;
		
		return $export;																// ==>

	} // _BuildNode.

	 

/*=======================================================================================
 *																						*
 *								PROTECTED HANDLER UTILITIES								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_GetVertexFromNodes																*
	 *==================================================================================*/

	/**
	 * Get vertices from nodes.
	 *
	 * This method will return the list of vertices corresponding to the provided node
	 * container cursor. The method is called by {@link _Handle_GetVertex()} to perform the
	 * vertex list selection.
	 *
	 * The method expects a single parameter that represents the recordset of a query
	 * performed on the nodes container. The recordset elements should be complete.
	 *
	 * The method will return the results structure or <tt>NULL</tt> if the provided
	 * recordset is empty.
	 *
	 * <i>Note: the parameter is expected to be iterable and have a method,
	 * <tt>count()</tt>, that if provided <tt>FALSE</tt> should return the total number of
	 * affected elements and if provided <tt>TRUE</tt> should return the actual number of
	 * returned elements.</i>
	 *
	 * @param mixed				$theNodes			Nodes recordset.
	 *
	 * @access protected
	 * @return array|NULL
	 */
	protected function _GetVertexFromNodes( $theNodes )
	{
		//
		// Set affected count.
		//
		$this->_OffsetManage(
			kAPI_STATUS, kAPI_AFFECTED_COUNT, $theNodes->count( FALSE ) );
		
		//
		// Handle page count.
		//
		if( $this->offsetExists( kAPI_PAGING ) )
		{
			$tmp = $this->offsetGet( kAPI_PAGING );
			$tmp[ kAPI_PAGE_COUNT ] = $theNodes->count( TRUE );
			$this->offsetSet( kAPI_PAGING, $tmp );
		}
		
		//
		// Check count.
		//
		if( $theNodes->count( FALSE ) )
		{
			//
			// Iterate recordset.
			//
			foreach( $theNodes as $object )
			{
				//
				// Instantiate object.
				//
				$object = CPersistentObject::DocumentObject( $object );
				$id = $object->offsetGet( kTAG_NID );
				
				//
				// Build and store vertex identifier.
				//
				$this->_ExportNode( $results, $object );
				$results[ kAPI_COLLECTION_ID ][] = $id;
			}
			
			return $results;														// ==>
		
		} // Found edges.
		
		return NULL;																// ==>
	
	} // _GetVertexFromNodes.

	 
	/*===================================================================================
	 *	_GetVertexRelations																*
	 *==================================================================================*/

	/**
	 * Get vertex relationships.
	 *
	 * This method will return the list of relationships of the provided reference vertex.
	 * The method is called by {@link _Handle_GetVertex()} to perform the relationships
	 * selection.
	 *
	 * The method expects a single parameter that represents the reference vertex native
	 * identifier.
	 *
	 * The method will return the results structure or <tt>NULL</tt> if no relationships
	 * were found.
	 *
	 * @param integer				$theVertex			Reference vertex identifier.
	 *
	 * @access protected
	 * @return array|NULL
	 */
	protected function _GetVertexRelations( $theVertex )
	{
		//
		// Init local storage.
		//
		$container = COntologyEdge::DefaultContainer( $_REQUEST[ kAPI_DATABASE ] );
		$query = $container->NewQuery();
		if( array_key_exists( kAPI_SUBQUERY, $_REQUEST ) )
		{
			$subcontainer = COntologyNode::DefaultContainer( $_REQUEST[ kAPI_DATABASE ] );
			$subquery = $_REQUEST[ kAPI_SUBQUERY ];
		}

		//
		// Filter by predicate.
		//
		if( array_key_exists( kAPI_PREDICATE, $_REQUEST ) )
			$query->AppendStatement(
				CQueryStatement::Member(
					kTAG_PREDICATE, $_REQUEST[ kAPI_PREDICATE ], kTYPE_BINARY_STRING ) );
		
		//
		// Build query by sense.
		//
		switch( $_REQUEST[ kAPI_RELATION ] )
		{
			//
			// Incoming relationships.
			//
			case kAPI_RELATION_IN:
			
				//
				// Find incoming relationships.
				//
				$query->AppendStatement(
					CQueryStatement::Equals(
						kTAG_OBJECT, $theVertex ),
					kOPERATOR_AND );
				
				//
				// Select all related nodes.
				//
				if( array_key_exists( kAPI_SUBQUERY, $_REQUEST ) )
					$list
						= $container->Query(
							$query, NULL, NULL, NULL, NULL, kTAG_SUBJECT );
				
				break;
		
			case kAPI_RELATION_OUT:
			
				//
				// Find outgoing relationships.
				//
				$query->AppendStatement(
					CQueryStatement::Equals(
						kTAG_SUBJECT, $theVertex ),
					kOPERATOR_AND );
				
				//
				// Select all related nodes.
				//
				if( array_key_exists( kAPI_SUBQUERY, $_REQUEST ) )
					$list
						= $container->Query(
							$query, NULL, NULL, NULL, NULL, kTAG_OBJECT );
				
				break;
		
			case kAPI_RELATION_ALL:
			
				//
				// Find outgoing relationships.
				//
				$query->AppendStatement(
					CQueryStatement::Equals(
						kTAG_SUBJECT, $theVertex ),
					kOPERATOR_OR );
				
				//
				// Find incoming relationships.
				//
				$query->AppendStatement(
					CQueryStatement::Equals(
						kTAG_OBJECT, $theVertex ),
					kOPERATOR_OR );
				
				//
				// Handle filter.
				//
				if( array_key_exists( kAPI_SUBQUERY, $_REQUEST ) )
				{
					//
					// Select all related nodes.
					//
					$list
						= iterator_to_array(
							$container->Query(
								$query, array( kTAG_NID, kTAG_SUBJECT, kTAG_OBJECT ) ) );
					
					//
					// Collect distinct node identifiers.
					//
					foreach( array_keys( $list ) as $id )
					{
						foreach( $list[ $id ] as $key => $value )
						{
							if( $key == kTAG_NID )
								continue;									// =>
							if( $value != $theVertex )
								break;										// =>
						}
						
						$list[ $id ] = $value;
					}
				
					//
					// Compile unique list of nodes.
					//
					$list = array_values( array_unique( $list ) );
				
				} // Provided filter.
				
				break;
			
			default:
				throw new CException
					( "Invalid relation sense: should have been caught before",
					  kERROR_STATE,
					  kSTATUS_BUG,
					  array( 'Relation'
								=> $_REQUEST[ kAPI_RELATION ] ) );		// !@! ==>
		
		} // Parsing relationship sense.
		
		//
		// Handle filter.
		//
		if( array_key_exists( kAPI_SUBQUERY, $_REQUEST ) )
		{
			//
			// Add nodes selector to sub-query.
			//
			$subquery = new CQuery( $subquery );
			$subquery->AppendStatement(
				CQueryStatement::Member(
					kTAG_NID, $list ),
				kOPERATOR_AND );
		
			//
			// Filter nodes.
			//
			$list
				= array_keys(
					iterator_to_array(
						$subcontainer->Query(
							$subquery, array( kTAG_NID ) ) ) );
		
			//
			// Update main query.
			//
			switch( $_REQUEST[ kAPI_RELATION ] )
			{
				case kAPI_RELATION_IN:
				
					//
					// Find incoming relationships.
					//
					$query->AppendStatement(
						CQueryStatement::Member(
							kTAG_SUBJECT, $list ),
						kOPERATOR_AND );
				
					break;
		
				case kAPI_RELATION_OUT:
				
					//
					// Find outgoing relationships.
					//
					$query->AppendStatement(
						CQueryStatement::Member(
							kTAG_OBJECT, $list ),
						kOPERATOR_AND );
				
					break;
		
				case kAPI_RELATION_ALL:
				
					//
					// Create selection query.
					//
					$tmp = $container->NewQuery();
					
					//
					// Find outgoing relationships.
					//
					$tmp->AppendStatement(
						CQueryStatement::Member(
							kTAG_SUBJECT, $list ),
						kOPERATOR_OR );
						
					//
					// Find incoming relationships.
					//
					$tmp->AppendStatement(
						CQueryStatement::Member(
							kTAG_OBJECT, $list ),
						kOPERATOR_OR );
						
					//
					// Merge.
					//
					$query->AppendStatement( $tmp, kOPERATOR_AND );
				
					break;
		
			} // Parsing relationship sense.
		
		} // Provided filter.
		
		//
		// Handle paging.
		//
		if( $this->offsetExists( kAPI_PAGING ) )
		{
			$start = $this->offsetGet( kAPI_PAGING )[ kAPI_PAGE_START ];
			$limit = $this->offsetGet( kAPI_PAGING )[ kAPI_PAGE_LIMIT ];
		}
		else
			$start = $limit = NULL;
		
		//
		// Find related edges.
		//
		$cursor
			= $container
				->Query( $query, NULL, NULL, $start, $limit );

		//
		// Set affected count.
		//
		$this->_OffsetManage(
			kAPI_STATUS, kAPI_AFFECTED_COUNT, $cursor->count( FALSE ) );
		
		//
		// Handle page count.
		//
		if( $this->offsetExists( kAPI_PAGING ) )
		{
			$tmp = $this->offsetGet( kAPI_PAGING );
			$tmp[ kAPI_PAGE_COUNT ] = $cursor->count( TRUE );
			$this->offsetSet( kAPI_PAGING, $tmp );
		}
		
		//
		// Check count.
		//
		if( $cursor->count( FALSE ) )
		{
			//
			// Iterate edges.
			//
			foreach( $cursor as $object )
			{
				//
				// Instantiate object.
				//
				$object = CPersistentObject::DocumentObject( $object );
				
				//
				// Save vertex identifier.
				//
				switch( $_REQUEST[ kAPI_RELATION ] )
				{
					case kAPI_RELATION_IN:
						$vid = $object[ kTAG_SUBJECT ];
						break;
				
					case kAPI_RELATION_OUT:
						$vid = $object[ kTAG_OBJECT ];
						break;
				
					case kAPI_RELATION_ALL:
						$vid = ( $object[ kTAG_SUBJECT ] == $theVertex )
							 ? $object[ kTAG_OBJECT ]
							 : $object[ kTAG_SUBJECT ];
						break;
				
				} // Parsing relationship sense.
				
				//
				// Build and store vertex identifier.
				//
				$this->_ExportEdge( $results, $object );
				$results[ kAPI_COLLECTION_ID ][] = $vid;
			}
			
			return $results;														// ==>
		
		} // Found edges.
		
		return NULL;																// ==>
	
	} // _GetVertexRelations.

	 

/*=======================================================================================
 *																						*
 *								PROTECTED FILTER UTILITIES								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_FilterLanguages																*
	 *==================================================================================*/

	/**
	 * Select language elements.
	 *
	 * This method can be used to restrict the language string attributes, those of type
	 * {@link kTYPE_LSTRING}, to the list of provided languages.
	 *
	 * The method will operate exclusively on the current object's response,
	 * {@link kAPI_RESPONSE}, property: the method will iterate the term and node sections
	 * of the response and consider only those attributes od type {@link kTYPE_LSTRING}, if
	 * at least one language matches, the method will select only the matching languages; if
	 * no language matches, the method will leave the attribute untouched.
	 *
	 * @param array				$theLanguages		Languages list.
	 *
	 * @access protected
	 */
	protected function _FilterLanguages( $theLanguages )
	{
		//
		// Check parameter.
		//
		if( is_array( $theLanguages ) )
		{
			//
			// Save response.
			//
			$response = $this->offsetGet( kAPI_RESPONSE );
			if( is_array( $response ) )
			{
				//
				// Init local storage.
				//
				$tag_refs = & $response[ kAPI_COLLECTION_TAG ];
				
				//
				// Iterate result sections.
				//
				$sections = array( kAPI_COLLECTION_TERM, kAPI_COLLECTION_NODE );
				foreach( $sections as $section )
				{
					//
					// Check section.
					//
					if( array_key_exists( $section, $response ) )
					{
						//
						// Reference section.
						//
						$refS = & $response[ $section ];
						
						//
						// Iterate section elements.
						//
						$keys = array_keys( $response[ $section ] );
						foreach( $keys as $key )
						{
							//
							// Reference element.
							//
							$refE = & $refS[ $key ];
							
							//
							// Iterate element tags.
							//
							$tags = array_intersect( array_keys( $refE ),
													 array_keys( $tag_refs ) );
							foreach( $tags as $tag )
							{
								//
								// Check tag type.
								//
								if( array_key_exists( kTAG_TYPE,
													  $tag_refs[ $tag ] )
								 && in_array( kTYPE_LSTRING,
								 			  $tag_refs[ $tag ][ kTAG_TYPE ] ) )
								{
									//
									// Get intersecting languages.
									//
									$langs = array_intersect( $_REQUEST[ kAPI_LANGUAGE ],
															  array_keys( $refE[ $tag ] ) );
									if( count( $langs ) )
									{
										//
										// Iterate matching languages.
										//
										$new = Array();
										foreach( $langs as $lang )
											$new[ $lang ] = $refE[ $tag ][ $lang ];
									
										//
										// Replace attribute.
										//
										$refE[ $tag ] = $new;
									
									} // Languages match.
								
								} // Tag is language string.
							
							} // Iterating element tags.
						
						} // Iterating section elements.
			
					} // Section exists.
		
				} // Iterating sections.
			
				//
				// Update response.
				//
				$this->offsetSet( kAPI_RESPONSE, $response );
			
			} // Got a response.
			
		} // Parameter is an array.
	
	} // _FilterLanguages.

	 
	/*===================================================================================
	 *	_NormaliseTermReferences														*
	 *==================================================================================*/

	/**
	 * Filter namespace references.
	 *
	 * The duty of this method is to convert term references from {@link kTAG_GID} values to
	 * {@link kTAG_NID} values.
	 *
	 * The method will traverse the query structure and intercept the following
	 * {@link kOFFSET_QUERY_SUBJECT} instances:
	 *
	 * <ul>
	 *	<li><tt>{@link kTAG_NAMESPACE}</tt>: The namespace reference of the term.
	 *	<li><tt>{@link kTAG_TERM}</tt>: The term reference in the term or node.
	 *	<li><tt>{@link kTAG_PREDICATE}</tt>: The predicate reference in the edge.
	 *	<li><tt>{@link kTAG_UID}</tt>: Unique identifiers.
	 * </ul>
	 *
	 * Any of these clauses with {@link kOFFSET_QUERY_TYPE} {@link kTYPE_STRING} will be
	 * converted to term native identifiers using the static {@link COntologyTerm::_id()}
	 * method.
	 *
	 * @param reference		   &$theQuery			Query.
	 *
	 * @access protected
	 */
	protected function _NormaliseTermReferences( &$theQuery )
	{
		//
		// Check parameter.
		//
		if( is_array( $theQuery ) )
		{
			//
			// Init local storage.
			//
			$tags = array( kTAG_UID, kTAG_TERM, kTAG_PREDICATE, kTAG_NAMESPACE );
			
			//
			// Traverse the query.
			//
			foreach( $theQuery as $key => $value )
			{
				//
				// Handle array values.
				//
				if( is_array( $value ) )
				{
					//
					// Look for namespace clause.
					//
					if( array_key_exists( kOFFSET_QUERY_SUBJECT, $value )
					 && in_array( $value[ kOFFSET_QUERY_SUBJECT ], $tags ) )
					{
						//
						// Check text namespaces.
						//
						if( array_key_exists( kOFFSET_QUERY_TYPE, $value )
						 && ($value[ kOFFSET_QUERY_TYPE ] == kTYPE_STRING) )
						{
							//
							// Handle value.
							//
							if( array_key_exists( kOFFSET_QUERY_DATA, $value ) )
							{
								//
								// Handle list.
								//
								if( is_array( $value[ kOFFSET_QUERY_DATA ] ) )
								{
									$idxs = array_keys( $value[ kOFFSET_QUERY_DATA ] );
									foreach( $idxs as $idx )
										$theQuery[ $key ]
												 [ kOFFSET_QUERY_DATA ]
												 [ $idx ]
											= COntologyTerm::_id(
												$theQuery[ $key ]
														 [ kOFFSET_QUERY_DATA ]
														 [ $idx ],
												( array_key_exists(
													kAPI_CONTAINER, $_REQUEST ) )
												? $_REQUEST[ kAPI_CONTAINER ]
												: $_REQUEST[ kAPI_DATABASE ] );
							
								} // List of references.
							
								//
								// Handle scalar.
								//
								else
									$theQuery[ $key ]
											 [ kOFFSET_QUERY_DATA ]
										= COntologyTerm::_id(
											$theQuery[ $key ]
													 [ kOFFSET_QUERY_DATA ],
											( array_key_exists(
												kAPI_CONTAINER, $_REQUEST ) )
											? $_REQUEST[ kAPI_CONTAINER ]
											: $_REQUEST[ kAPI_DATABASE ] );
						
							} // Has data.
						
						} // Found text namespace reference.
					
					} // Found namespace clause.
					
					//
					// Recurse.
					//
					else
						$this->_NormaliseTermReferences( $theQuery[ $key ] );
				
				} // Possibly a clause.
				
			} // Traversing the query.
		
		} // Is an array.
	
	} // _NormaliseTermReferences.

	 

} // class COntologyWrapper.


?>

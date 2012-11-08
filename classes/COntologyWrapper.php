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
 *	Ontology wrapper.
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
 *	<li><tt>kAPI_COLLECTION_PREDICATE</tt>: This offset tags the element that holds the list
 *		of referenced predicate items
 *	<li><tt>kAPI_COLLECTION_VERTEX</tt>: This offset tags the element that holds the list
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
abstract class COntologyWrapper extends CDataWrapper
{
		

/*=======================================================================================
 *																						*
 *							PROTECTED FORMATTING UTILITIES								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_FormatContainer																	*
	 *==================================================================================*/

	/**
	 * Instantiate container.
	 *
	 * In this class we initialise the default container for specific operations.
	 *
	 * @access protected
	 *
	 * @see kAPI_CONTAINER
	 */
	protected function _FormatContainer()
	{
		//
		// Parse by operation.
		//
		switch( $_REQUEST[ kAPI_OPERATION ] )
		{
			case kAPI_OP_GetRootsByKind:
				//
				// Initialise container name.
				//
				if( ! array_key_exists( kAPI_CONTAINER, $_REQUEST ) )
					$_REQUEST[ kAPI_CONTAINER ] = kCONTAINER_NODE_NAME;
				break;
		
		} // Parsing by operation.
		
		//
		// Call parent method.
		//
		parent::_FormatContainer();
	
	} // _FormatContainer.

	 
	/*===================================================================================
	 *	_FormatQuery																	*
	 *==================================================================================*/

	/**
	 * Format paging parameters.
	 *
	 * This method will decode the provided query from JSON or PHP encoding and unserialise
	 * eventual query arguments encoded as {@link CDataType} derived instances.
	 *
	 * This method will first check if the parameter is not already an array or a
	 * {@link CQuery} derived instance, if it is, the method will do nothing.
	 *
	 * @access protected
	 *
	 * @see kAPI_QUERY
	 */
	protected function _FormatQuery()
	{
		//
		// Parse by operation.
		//
		switch( $_REQUEST[ kAPI_OPERATION ] )
		{
			case kAPI_OP_GetRootsByKind:
				//
				// Decode or initialise parameter.
				//
				if( array_key_exists( kAPI_QUERY, $_REQUEST ) )
					$this->_DecodeParameter( kAPI_QUERY );
				else
					$_REQUEST[ kAPI_QUERY ] = kKIND_NODE_ROOT;
				
				//
				// Normalise parameter.
				//
				if( ! is_array( $_REQUEST[ kAPI_QUERY ] ) )
					$_REQUEST[ kAPI_QUERY ] = array( $_REQUEST[ kAPI_QUERY ] );
				
				//
				// Build query.
				//
				$query = new CQuery();
				foreach( $_REQUEST[ kAPI_QUERY ] as $kind )
					$query->AppendStatement(
						new CQueryStatement(
							kTAG_KIND, kOPERATOR_EQUAL, kTYPE_STRING, $kind ),
						kOPERATOR_AND );
				
				//
				// Save query.
				//
				$_REQUEST[ kAPI_QUERY ] = $query;
					
				break;
				
			default:
				//
				// Let parent handle it.
				//
				parent::_FormatQuery();
				
				break;
		
		} // Parsing by operation.
	
	} // _FormatQuery.

		

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
	 *	<li><tt>{@link kAPI_OP_COUNT}</tt>: Return the count of a query, this operation
	 *		requires the following parameters:
	 *	 <ul>
	 *		<li><tt></tt>.
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
		switch( $_REQUEST[ kAPI_OPERATION ] )
		{
			//
			// Operation codes.
			//
			case kAPI_OP_GetRootsByKind:
				//
				// Check for database.
				//
				if( ! array_key_exists( kAPI_DATABASE, $_REQUEST ) )
					throw new CException
						( "Missing database parameter",
						  kERROR_MISSING,
						  kMESSAGE_TYPE_ERROR,
						  array( 'Operation' => $parameter ) );					// !@! ==>
				
				//
				// Check for container.
				//
				if( ! array_key_exists( kAPI_CONTAINER, $_REQUEST ) )
					throw new CException
						( "Missing container parameter",
						  kERROR_MISSING,
						  kMESSAGE_TYPE_ERROR,
						  array( 'Operation' => $parameter ) );					// !@! ==>
					
				//
				// Check for format.
				//
				if( ! array_key_exists( kAPI_FORMAT, $_REQUEST ) )
					throw new CException
						( "Missing format parameter",
						  kERROR_MISSING,
						  kMESSAGE_TYPE_ERROR,
						  array( 'Operation' => $parameter ) );					// !@! ==>
				
				//
				// Check for query.
				//
				if( ! array_key_exists( kAPI_QUERY, $_REQUEST ) )
					throw new CException
						( "Missing query list parameter",
						  kERROR_MISSING,
						  kMESSAGE_TYPE_ERROR,
						  array( 'Operation' => $parameter ) );					// !@! ==>
				
				break;
			
			//
			// Handle unknown operation.
			//
			default:
				parent::_ValidateOperation();
				break;
			
		} // Parsing parameter.
	
	} // _ValidateOperation.

		

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
				case kAPI_OP_GetRootsByKind:
					$this->_Handle_GetRootsByKind();
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
		// Add kAPI_OP_GetRootsByKind.
		//
		$theList[ kAPI_OP_GetRootsByKind ]
			= 'Get root vertex by kind: returns the list of vertex nodes of the provided kind.';
	
	} // _Handle_ListOp.

	 
	/*===================================================================================
	 *	_Handle_GetRootsByKind															*
	 *==================================================================================*/

	/**
	 * Handle {@link kAPI_OP_GetRootsByKind} request.
	 *
	 * This method will handle the {@link kAPI_OP_GetRootsByKind} operation, which returns
	 * the list of vertex nodes belonging to the provided kinds.
	 *
	 * @access protected
	 */
	protected function _Handle_GetRootsByKind()
	{
		//
		// Handle query.
		//
		$query = ( array_key_exists( kAPI_QUERY, $_REQUEST ) )
				? $_REQUEST[ kAPI_QUERY ]
				: Array();
		
		//
		// Handle fields.
		//
		$fields = ( array_key_exists( kAPI_SELECT, $_REQUEST ) )
				? $_REQUEST[ kAPI_SELECT ]
				: Array();
		
		//
		// Handle sort.
		//
		$sort = ( array_key_exists( kAPI_SORT, $_REQUEST ) )
			  ? $_REQUEST[ kAPI_SORT ]
			  : Array();
		
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
		// Query.
		//
		$cursor
			= $_REQUEST[ kAPI_CONTAINER ]
				->Query( $query, $fields, $sort, $start, $limit );
		
		//
		// Set affected count.
		//
		$this->_OffsetManage( kAPI_STATUS, kAPI_AFFECTED_COUNT, $cursor->count( FALSE ) );
		
		//
		// Handle page count.
		//
		if( $this->offsetExists( kAPI_PAGING ) )
			$this->offsetGet( kAPI_PAGING )[ kAPI_PAGE_COUNT ] = $cursor->count( TRUE );
		
		//
		// Check count.
		//
		if( $cursor->count( FALSE ) )
		{
			//
			// Init results structure.
			//
			$results = array( kAPI_COLLECTION_ID => Array(),
							  kAPI_COLLECTION_PREDICATE => Array(),
							  kAPI_COLLECTION_VERTEX => Array(),
							  kAPI_COLLECTION_EDGE => Array(),
							  kAPI_COLLECTION_TAG => Array() );
			
			//
			// Iterate vertex.
			//
			foreach( $cursor as $object )
			{
				
				//
				// Serialise object.
				//
				CDataType::SerialiseObject( $object );
				
				//
				// Save object.
				//
				$result[] = $object;
			
			} // Iterating found objects
			
			//
			// Set response.
			//
			$this->offsetSet( kAPI_RESPONSE, $result );
		
		} // Found something.
	
	} // _Handle_GetRootsByKind.

		

/*=======================================================================================
 *																						*
 *									PROTECTED UTILITIES									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_DecodeParameter																*
	 *==================================================================================*/

	/**
	 * Decode parameter.
	 *
	 * This method can be used to decode a parameter according to the provided format,
	 * {@link kTYPE_JSON} or {@link kTYPE_PHP}.
	 *
	 * The method will return the decoded parameter.
	 *
	 * @param string				$theParameter		Parameter offset.
	 *
	 * @access protected
	 * @return array
	 *
	 * @uses JsonDecode()
	 *
	 * @see kTYPE_JSON kTYPE_PHP
	 */
	protected function _DecodeParameter( $theParameter )
	{
		//
		// Check parameter.
		//
		if( array_key_exists( $theParameter, $_REQUEST ) )
		{
			//
			// Init local storage.
			//
			$encoded = $_REQUEST[ $theParameter ];
			$format = $_REQUEST[ kAPI_FORMAT ];
			
			//
			// Parse by format.
			//
			switch( $format )
			{
				case kTYPE_JSON:
					try
					{
						$_REQUEST[ $theParameter ] = JsonDecode( $encoded );
					}
					catch( Exception $error )
					{
						if( $error instanceof CException )
						{
							$error->Reference( 'Parameter', $theParameter );
							$error->Reference( 'Format', $format );
							$error->Reference( 'Data', $encoded );
						}
						
						throw $error;											// !@! ==>
					}
					
					break;

				case kTYPE_PHP:
					$decoded = @unserialize( $encoded );
					if( $decoded === FALSE )
						throw new CException
							( "Unable to handle request: invalid PHP serialised string",
							  kERROR_INVALID_STATE,
							  kMESSAGE_TYPE_ERROR,
							  array( 'Parameter' => $theParameter,
									 'Format' => $format,
									 'Data' => $encoded ) );					// !@! ==>
					
					//
					// Update request.
					//
					$_REQUEST[ $theParameter ] = $decoded;
					
					break;
				
				//
				// Catch bugs.
				//
				default:
					throw new CException
						( "Unsupported format (should have been caught before)",
						  kERROR_UNSUPPORTED,
						  kMESSAGE_TYPE_BUG,
						  array( 'Parameter' => kAPI_FORMAT,
								 'Format' => $format ) );						// !@! ==>
			
			} // Parsed format.
		
		} // Provided parameter.
	
	} // _DecodeParameter.

	 

} // class COntologyWrapper.


?>

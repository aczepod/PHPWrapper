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
 *	@version	1.00 07/11/2011
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
 * return data from an ontology. The class does not feature a concrete data store engine, so
 * it only concentrates in providing the framework for derived classes that implement
 * concrete data store instances, for this reason this class is abstract.
 *
 * This class implements high level services, that is, it will return data that is an
 * aggregation of various containers.
 *
 * These new functionalities require an additional set of parameters:
 *
 * <ul>
 *	<li><i>Category parameters</i>: These parameters refer to categories used to select
 *		specific elements:
 *	 <ul>
 *		<li><i>{@link kAPI_KIND}</i>: <i>Kind</i>, this parameter generally refers to the
 *			node kind, it is an array of elements that the selected nodes must match.
 *	 </ul>
 *	<li><i>Operations</i>: This class adds the following operations:
 *	 <ul>
 *		<li><i>{@link kAPI_OP_GetNodesByKind}</i>: <i>Get nodes by kind</i>, this operation
 *			will return a list of nodes that match the provided kind enumerations in the
 *			{@link kAPI_KIND} parameter. The operation expects the following parameters:
 *		 <ul>
 *			<li><i>{@link kAPI_FORMAT}</i>: Format, this parameter is required, since other
 *				non scalar parameters must be encoded.
 *			<li><i>{@link kAPI_DATABASE}</i>: Database, database to which the container
 *				belongs.
 *			<li><i>{@link kAPI_KIND}</i>: Kinds list (optional), the selection criteria.
 *			<li><i>{@link kAPI_SELECT}</i>: Select (optional), the list of fields to be
 *				returned.
 *			<li><i>{@link kAPI_PAGE_LIMIT}</i>:This parameter is required or enforced, it
 *				represents the maximum number of elements that the query should return, the
 *				default value is {@link kDEFAULT_LIMIT}.
 *		 </ul>
 *	 </ul>
 * </ul>
 *
 *	@package	MyWrapper
 *	@subpackage	Wrappers
 */
abstract class COntologyWrapper extends CDataWrapper
{
		

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
	 * In this class we handle the following parameters:
	 *
	 * <ul>
	 *	<li><tt>{@link kAPI_KIND}</tt>: We copy the kinds list to the request.
	 * </ul>
	 *
	 * @access protected
	 *
	 * @uses _ParseKinds()
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
		$this->_ParseKinds();
	
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
	 * @uses _FormatKinds()
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
		$this->_FormatKinds();
	
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
	 * @uses _ValidateKinds()
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
		$this->_ValidateKinds();
	
	} // _ValidateRequest.

		

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
	 * We overload this method to remove unnecessary parameter from the request, depending
	 * on the current operation:
	 *
	 * <ul>
	 *	<li><tt>{@link kAPI_OP_GetNodesByKind}</tt>: This operation requires that the page
	 *		limits be set, only a defined number of records should be returned by a service:
	 *		if the {@link kAPI_PAGE_LIMIT} parameter was not provided, this method will set
	 *		it to {@link kDEFAULT_LIMIT}.
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
		// Handle operation.
		//
		if( array_key_exists( kAPI_OPERATION, $_REQUEST ) )
		{
			//
			// Select unnecessary parameters.
			//
			switch( $_REQUEST[ kAPI_OPERATION ] )
			{
				case kAPI_OP_QUERY:
					if( ! array_key_exists( kAPI_PAGE_LIMIT, $_REQUEST ) )
						$_REQUEST[ kAPI_PAGE_LIMIT ] = kDEFAULT_LIMIT;
					break;
			}
		
		} // Provided operation.
	
	} // _ParseOperation.

	 
	/*===================================================================================
	 *	_ParseKinds																		*
	 *==================================================================================*/

	/**
	 * Parse kinds.
	 *
	 * This method will copy the query selection to the request block.
	 *
	 * @access protected
	 *
	 * @uses _OffsetManage()
	 *
	 * @see kAPI_KIND kAPI_REQUEST
	 */
	protected function _ParseKinds()
	{
		//
		// Handle query.
		//
		if( array_key_exists( kAPI_KIND, $_REQUEST ) )
		{
			if( $this->offsetExists( kAPI_REQUEST ) )
				$this->_OffsetManage
					( kAPI_REQUEST, kAPI_KIND, $_REQUEST[ kAPI_KIND ] );
		}
	
	} // _ParseKinds.

		

/*=======================================================================================
 *																						*
 *							PROTECTED FORMATTING UTILITIES								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_FormatKinds																	*
	 *==================================================================================*/

	/**
	 * Format selection parameters.
	 *
	 * This method will decode the provided selection from JSON or PHP encoding.
	 *
	 * @access protected
	 *
	 * @see kAPI_KIND
	 */
	protected function _FormatKinds()
	{
		//
		// Check parameter.
		//
		if( array_key_exists( kAPI_KIND, $_REQUEST ) )
			$this->_DecodeParameter( kAPI_KIND );
	
	} // _FormatKinds.

		

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
	 *		<li><tt>
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
			case kAPI_OP_GetNodesByKind:
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
				// Check for database.
				//
				if( ! array_key_exists( kAPI_DATABASE, $_REQUEST ) )
					throw new CException
						( "Missing database parameter",
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

		
	/*===================================================================================
	 *	_ValidateKinds																	*
	 *==================================================================================*/

	/**
	 * Validate selection kinds.
	 *
	 * The duty of this method is to validate the selection parameter, in this class we
	 * assume the value to be array, if a scalar is provided, we convert it to a string and
	 * create with it an array.
	 *
	 * If the resulting array is empty, we remove the request.
	 *
	 * @access protected
	 *
	 * @see kAPI_KIND
	 */
	protected function _ValidateKinds()
	{
		//
		// Check parameter.
		//
		if( array_key_exists( kAPI_KIND, $_REQUEST ) )
		{
			//
			// Convert to array.
			//
			if( ! is_array( $_REQUEST[ kAPI_KIND ] ) )
			{
				//
				// Handle non-empty string.
				//
				if( strlen( $_REQUEST[ kAPI_KIND ] ) )
					$_REQUEST[ kAPI_KIND ] = array( (string) $_REQUEST[ kAPI_KIND ] );
				
				//
				// Remove request.
				//
				else
					unset( $_REQUEST[ kAPI_KIND ] );
			}
		
		} // Provided query selection.
	
	} // _ValidateKinds.

		

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
		// Parse by operation.
		//
		switch( $op = $_REQUEST[ kAPI_OPERATION ] )
		{
			case kAPI_OP_GetNodesByKind:
				$this->_Handle_GetNodesByKind();
				break;

			default:
				parent::_HandleRequest();
				break;
		}
	
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
		// Add kAPI_OP_COUNT.
		//
		$theList[ kAPI_OP_GetNodesByKind ]
			= 'Get nodes by kind: returns the nodes matching a list of kind enumerations.';
	
	} // _Handle_ListOp.

	 
	/*===================================================================================
	 *	_Handle_GetNodesByKind															*
	 *==================================================================================*/

	/**
	 * Handle {@link kAPI_OP_GetNodesByKind} request.
	 *
	 * This method will handle the {@link kAPI_OP_GetNodesByKind} operation, which returns
	 * the nodes that match the provided list of node kinds.
	 *
	 * Since this class does not handle any specific data engine, we declare the method
	 * abstract and require concrete derived classes to implement it.
	 *
	 * @access protected
	 */
	abstract protected function _Handle_GetNodesByKind();

	 

} // class COntologyWrapper.


?>

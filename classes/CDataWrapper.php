<?php

/**
 * <i>CDataWrapper</i> class definition.
 *
 * This file contains the class definition of <b>CDataWrapper</b> which overloads its
 * ancestor to implement a data store wrapper.
 *
 *	@package	MyWrapper
 *	@subpackage	Wrappers
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 06/11/2011
 */

/*=======================================================================================
 *																						*
 *									CDataWrapper.php									*
 *																						*
 *======================================================================================*/

/**
 * Ancestor.
 *
 * This include file contains the parent class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CWrapper.php" );

/**
 * Queries.
 *
 * This include file contains the query class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CQuery.php" );

/**
 * Local definitions.
 *
 * This include file contains all local definitions to this class.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CDataWrapper.inc.php" );

/**
 * <h4>Data wrapper</h4>
 *
 * This class overloads its ancestor to implement the framework for providing services that
 * store and request data. The class does not feature a concrete data store engine, so it
 * only concentrates in providing the framework for derived classes that implement concrete
 * data store instances, for this reason this class is abstract.
 *
 * These new functionalities require an additional set of parameters:
 *
 * <ul>
 *	<li><i>Request parameters</i>: These parameters refer to the parameters that the service
 *		expects:
 *	 <ul>
 *		<li><i>{@link kAPI_SERVER}</i>: <i>Server</i>, this offset tag will be used to
 *			locate the service {@link CServer} object, concrete derived classes should
 *			instantiate this object in their {@link _InitResources()} method and store it in
 *			the <tt>$_REQUEST</tt> global array.
 *		<li><i>{@link kAPI_DATABASE}</i>: <i>Database</i>, this string parameter represents
 *			the name of the database which is a concrete instance of {@link CDatabase}.
 *		<li><i>{@link kAPI_CONTAINER}</i>: <i>Container</i>, this string parameter
 *			represents the name of the container within the provided database,it will be a
 *			concrete instance of {@link CContainer}.
 *		<li><i>{@link kAPI_PAGE_START}</i>: <i>Page start</i>, this integer parameter
 *			represents the start offset for paging, it is a zero-based index.
 *		<li><i>{@link kAPI_PAGE_LIMIT}</i>: <i>Page limit</i>, this integer parameter
 *			represents the maximum number of records to be returned.
 *		<li><i>{@link kAPI_QUERY}</i>: <i>Query</i>, this array parameter represents the
 *			data query, it should follow the rules of the {@link CQuery} class family.
 *		<li><i>{@link kAPI_SELECT}</i>: <i>Select</i>, this array parameter represents the
 *			query selection or fields list, it is constituted by an array of strings that
 *			indicate which fields should be returned by the query.
 *		<li><i>{@link kAPI_SORT}</i>: <i>Sort</i>, this array parameter represents the list
 *			of fields upon which to sort the results, the array element indexes represent
 *			the field references, the values are provided as numbers where negative values
 *			represent a descending sense and zero or positive values ascending.
 *	 </ul>
 *	<li><i>Response parameters</i>: These parameters refer to the parameters that the
 *		service is expected to return:
 *	 <ul>
 *		<li><i>{@link kAPI_PAGING}</i>: <i>Paging</i>, this offset is constituted by the
 *			list of parameters relating to paging:
 *		 <ul>
 *			<li><i>{@link kAPI_PAGE_START}</i>: Page start (input).
 *			<li><i>{@link kAPI_PAGE_LIMIT}</i>: Page limit (input).
 *			<li><i>{@link kAPI_PAGE_COUNT}</i>: Page count (output), the actual number of
 *				elements returned, which will be less or equal to the
 *				{@link kAPI_PAGE_LIMIT} parameter.
 *		 </ul>
 *		<li><i>{@link kAPI_STATUS}</i>: <i>Status</i>, this block features an additional
 *			element that is used by query requests:
 *		 <ul>
 *			<li><i>{@link kAPI_AFFECTED_COUNT}</i>: Affected count (output): the total
 *				number of elements affected by the operation.
 *		 </ul>
 *	 </ul>
 *	<li><i>Operations</i>: This class adds the following operations:
 *	 <ul>
 *		<li><i>{@link kAPI_OP_COUNT}</i>: <i>Count</i>, this operation will return the total
 *			number of elements that satisfy the provided {@link kAPI_QUERY}; if the latter
 *			is omitted, it is assumed that we want the total number of elements in the
 *			{@link kAPI_CONTAINER}. The operation expects the following parameters:
 *		 <ul>
 *			<li><i>{@link kAPI_FORMAT}</i>: Format, this parameter is required, since other
 *				non scalar parameters must be encoded.
 *			<li><i>{@link kAPI_DATABASE}</i>: Database, database to which the container
 *				belongs.
 *			<li><i>{@link kAPI_CONTAINER}</i>: Container, container in which to perform the
 *				query.
 *			<li><i>{@link kAPI_QUERY}</i>: Query (optional), the selection criteria.
 *		 </ul>
 *		<li><i>{@link kAPI_OP_GET}</i>: <i>Query</i>, this operation will return all
 *			records that satisfy the provided query. The operation expects the following
 *			parameters:
 *		 <ul>
 *			<li><i>{@link kAPI_FORMAT}</i>: Format, this parameter is required, since other
 *				non scalar parameters must be encoded.
 *			<li><i>{@link kAPI_DATABASE}</i>: Database, database to which the container
 *				belongs.
 *			<li><i>{@link kAPI_CONTAINER}</i>: Container, container in which to perform the
 *				query.
 *			<li><i>{@link kAPI_QUERY}</i>: Query (optional), the selection criteria.
 *			<li><i>{@link kAPI_SELECT}</i>: Select (optional), the list of fields to be
 *				returned.
 *			<li><i>{@link kAPI_SORT}</i>: Sort (optional), the list of sort elements and
 *				their sense.
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
class CDataWrapper extends CWrapper
{
	/**
	 * <b>Parameters list</b>
	 *
	 * This static data member holds the list of parameters known by the service, these will
	 * be decoded before the service will handle them.
	 *
	 * @var array
	 */
	 static $sParameterList = array( kAPI_DATABASE, kAPI_CONTAINER,
	 								 kAPI_PAGE_START, kAPI_PAGE_LIMIT,
	 								 kAPI_QUERY, kAPI_SELECT, kAPI_SORT );

		

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
	 * @uses _ParseDatabase()
	 * @uses _ParseContainer()
	 * @uses _ParsePaging()
	 * @uses _ParseQuery()
	 * @uses _ParseSelect()
	 * @uses _ParseSort()
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
		$this->_ParseDatabase();
		$this->_ParseContainer();
		$this->_ParsePaging();
		$this->_ParseQuery();
		$this->_ParseSelect();
		$this->_ParseSort();
	
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
	 * @uses _FormatDatabase()
	 * @uses _FormatContainer()
	 * @uses _FormatPaging()
	 * @uses _FormatQuery()
	 * @uses _FormatSelect()
	 * @uses _FormatSort()
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
		$this->_FormatDatabase();
		$this->_FormatContainer();
		$this->_FormatPaging();
		$this->_FormatQuery();
		$this->_FormatSelect();
		$this->_FormatSort();
	
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
	 * @uses _ValidateDatabase()
	 * @uses _ValidateContainer()
	 * @uses _ValidatePaging()
	 * @uses _ValidateQuery()
	 * @uses _ValidateSelect()
	 * @uses _ValidateSort()
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
		$this->_ValidateDatabase();
		$this->_ValidateContainer();
		$this->_ValidatePaging();
		$this->_ValidateQuery();
		$this->_ValidateSelect();
		$this->_ValidateSort();
	
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
	 * We overload this method to remove unnecessary parameter from the request, depending
	 * on the current operation:
	 *
	 * <ul>
	 *	<li><tt>{@link kAPI_OP_COUNT}</tt>: This operation does not handle fields selection
	 *		or sort orders, so we clear {@link kAPI_SELECT} and {@link kAPI_SORT}. We could
	 *		also clear the paging parameters, but we keep them in case clients implement an
	 *		automatic paging management.
	 *	<li><tt>{@link kAPI_OP_GET}</tt>: This operation requires that the page limits be
	 *		set, only a defined number of records should be returned by a service: if the
	 *		{@link kAPI_PAGE_LIMIT} parameter was not provided, this method will set it to
	 *		{@link kDEFAULT_LIMIT}.
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
			case kAPI_OP_COUNT:
				if( array_key_exists( kAPI_SELECT, $_REQUEST ) )
					unset( $_REQUEST[ kAPI_SELECT ] );

			case kAPI_OP_GET_ONE:
			case kAPI_OP_MATCH:
				if( array_key_exists( kAPI_SORT, $_REQUEST ) )
					unset( $_REQUEST[ kAPI_SORT ] );
				break;

			case kAPI_OP_GET:
				if( ! array_key_exists( kAPI_PAGE_LIMIT, $_REQUEST ) )
					$_REQUEST[ kAPI_PAGE_LIMIT ] = kDEFAULT_LIMIT;
				break;
		}
	
	} // _ParseOperation.

	 
	/*===================================================================================
	 *	_ParseDatabase																	*
	 *==================================================================================*/

	/**
	 * Parse database.
	 *
	 * This method will copy the database parameter to the request block.
	 *
	 * @access protected
	 *
	 * @uses _OffsetManage()
	 *
	 * @see kAPI_DATABASE kAPI_REQUEST
	 */
	protected function _ParseDatabase()
	{
		//
		// Handle database.
		//
		if( array_key_exists( kAPI_DATABASE, $_REQUEST ) )
		{
			if( $this->offsetExists( kAPI_REQUEST ) )
				$this->_OffsetManage
					( kAPI_REQUEST, kAPI_DATABASE, $_REQUEST[ kAPI_DATABASE ] );
		}
	
	} // _ParseDatabase.

	 
	/*===================================================================================
	 *	_ParseContainer																	*
	 *==================================================================================*/

	/**
	 * Parse container.
	 *
	 * This method will copy the container parameter to the request block.
	 *
	 * @access protected
	 *
	 * @uses _OffsetManage()
	 *
	 * @see kAPI_CONTAINER kAPI_REQUEST
	 */
	protected function _ParseContainer()
	{
		//
		// Handle database.
		//
		if( array_key_exists( kAPI_CONTAINER, $_REQUEST ) )
		{
			if( $this->offsetExists( kAPI_REQUEST ) )
				$this->_OffsetManage
					( kAPI_REQUEST, kAPI_CONTAINER, $_REQUEST[ kAPI_CONTAINER ] );
		}
	
	} // _ParseContainer.

	 
	/*===================================================================================
	 *	_ParsePaging																	*
	 *==================================================================================*/

	/**
	 * Parse paging parameters.
	 *
	 * This method will copy the paging parameters to the request block.
	 *
	 * @access protected
	 *
	 * @uses _OffsetManage()
	 *
	 * @see kAPI_PAGE_START kAPI_PAGE_LIMIT kAPI_REQUEST
	 */
	protected function _ParsePaging()
	{
		//
		// handle request mirror.
		//
		if( $this->offsetExists( kAPI_REQUEST ) )
		{
			//
			// Handle page start.
			//
			if( array_key_exists( kAPI_PAGE_START, $_REQUEST ) )
				$this->_OffsetManage
					( kAPI_REQUEST, kAPI_PAGE_START, $_REQUEST[ kAPI_PAGE_START ] );
		
			//
			// Handle page limit.
			//
			if( array_key_exists( kAPI_PAGE_LIMIT, $_REQUEST ) )
				$this->_OffsetManage
					( kAPI_REQUEST, kAPI_PAGE_LIMIT, $_REQUEST[ kAPI_PAGE_LIMIT ] );
		}
	
	} // _ParsePaging.

	 
	/*===================================================================================
	 *	_ParseQuery																		*
	 *==================================================================================*/

	/**
	 * Parse query.
	 *
	 * This method will copy the query to the request block.
	 *
	 * @access protected
	 *
	 * @uses _OffsetManage()
	 *
	 * @see kAPI_QUERY kAPI_REQUEST
	 */
	protected function _ParseQuery()
	{
		//
		// Handle query.
		//
		if( array_key_exists( kAPI_QUERY, $_REQUEST ) )
		{
			if( $this->offsetExists( kAPI_REQUEST ) )
				$this->_OffsetManage
					( kAPI_REQUEST, kAPI_QUERY, $_REQUEST[ kAPI_QUERY ] );
		}
	
	} // _ParseQuery.

	 
	/*===================================================================================
	 *	_ParseSelect																	*
	 *==================================================================================*/

	/**
	 * Parse selection.
	 *
	 * This method will copy the query selection to the request block.
	 *
	 * @access protected
	 *
	 * @uses _OffsetManage()
	 *
	 * @see kAPI_SELECT kAPI_REQUEST
	 */
	protected function _ParseSelect()
	{
		//
		// Handle query.
		//
		if( array_key_exists( kAPI_SELECT, $_REQUEST ) )
		{
			if( $this->offsetExists( kAPI_REQUEST ) )
				$this->_OffsetManage
					( kAPI_REQUEST, kAPI_SELECT, $_REQUEST[ kAPI_SELECT ] );
		}
	
	} // _ParseSelect.

	 
	/*===================================================================================
	 *	_ParseSort																		*
	 *==================================================================================*/

	/**
	 * Parse sort.
	 *
	 * This method will copy the query sort selection to the request block.
	 *
	 * @access protected
	 *
	 * @uses _OffsetManage()
	 *
	 * @see kAPI_SORT kAPI_REQUEST
	 */
	protected function _ParseSort()
	{
		//
		// Handle query.
		//
		if( array_key_exists( kAPI_SORT, $_REQUEST ) )
		{
			if( $this->offsetExists( kAPI_REQUEST ) )
				$this->_OffsetManage
					( kAPI_REQUEST, kAPI_SORT, $_REQUEST[ kAPI_SORT ] );
		}
	
	} // _ParseSort.

		

/*=======================================================================================
 *																						*
 *							PROTECTED FORMATTING UTILITIES								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_FormatDatabase																	*
	 *==================================================================================*/

	/**
	 * Instantiate database.
	 *
	 * This method will instantiate the {@link CDatabase} instance if the name was provided
	 * as parameter. If the {@link kAPI_SERVER} element is not set, the method will raise
	 * an exception.
	 *
	 * @access protected
	 *
	 * @see kAPI_DATABASE
	 */
	protected function _FormatDatabase()
	{
		//
		// Check parameter.
		//
		if( array_key_exists( kAPI_DATABASE, $_REQUEST ) )
		{
			//
			// Check server.
			//
			if( $this->_IsInited() )
			{
				//
				// Check server type.
				//
				if( $this->Connection() instanceof CServer )
					$_REQUEST[ kAPI_DATABASE ]
						= $this->Connection()
							->Database( $_REQUEST[ kAPI_DATABASE ] );
				
				else
					throw new CException
						( "Unable to instantiate database: invalid server type",
						  kERROR_STATE,
						  kSTATUS_ERROR );								// !@! ==>
			
			} // Has server.
			
			else
				throw new CException
					( "Unable to instantiate database: wrapper not initialised",
					  kERROR_STATE,
					  kSTATUS_ERROR );									// !@! ==>
		
		} // Provided database.
	
	} // _FormatDatabase.

	 
	/*===================================================================================
	 *	_FormatContainer																*
	 *==================================================================================*/

	/**
	 * Instantiate container.
	 *
	 * This method will instantiate the {@link CContainer} instance if the name was
	 * provided as parameter. If the {@link kAPI_DATABASE} element is not set, the method
	 * will raise an exception.
	 *
	 * @access protected
	 *
	 * @see kAPI_CONTAINER
	 */
	protected function _FormatContainer()
	{
		//
		// Check parameter.
		//
		if( array_key_exists( kAPI_CONTAINER, $_REQUEST ) )
		{
			//
			// Check database.
			//
			if( array_key_exists( kAPI_DATABASE, $_REQUEST ) )
			{
				//
				// Check server type.
				//
				if( $_REQUEST[ kAPI_DATABASE ] instanceof CDatabase )
					$_REQUEST[ kAPI_CONTAINER ]
						= $_REQUEST[ kAPI_DATABASE ]
							->Container( $_REQUEST[ kAPI_CONTAINER ] );
				
				else
					throw new CException
						( "Unable to instantiate container: invalid database type",
						  kERROR_STATE,
						  kSTATUS_ERROR );								// !@! ==>
			
			} // Has database.
			
			else
				throw new CException
					( "Unable to instantiate container: database is missing",
					  kERROR_STATE,
					  kSTATUS_ERROR );									// !@! ==>
		
		} // Provided container.
	
	} // _FormatContainer.

	 
	/*===================================================================================
	 *	_FormatPaging																	*
	 *==================================================================================*/

	/**
	 * Format paging parameters.
	 *
	 * This method will complete eventual missing paging parameters and fill the response
	 * {@link kAPI_PAGING} block with the provided paging options.
	 *
	 * @access protected
	 *
	 * @see kAPI_PAGING kAPI_PAGE_START kAPI_PAGE_LIMIT
	 */
	protected function _FormatPaging()
	{
		//
		// Check parameter.
		//
		if( array_key_exists( kAPI_PAGE_START, $_REQUEST )
		 || array_key_exists( kAPI_PAGE_LIMIT, $_REQUEST ) )
		{
			//
			// Set missing page start.
			//
			if( ! array_key_exists( kAPI_PAGE_START, $_REQUEST ) )
				$_REQUEST[ kAPI_PAGE_START ] = 0;
		
			//
			// Set missing page limit.
			//
			if( ! array_key_exists( kAPI_PAGE_LIMIT, $_REQUEST ) )
				$_REQUEST[ kAPI_PAGE_LIMIT ] = kDEFAULT_LIMIT;
			
			//
			// Init response block.
			//
			$this->offsetSet( kAPI_PAGING,
							  array( kAPI_PAGE_START => $_REQUEST[ kAPI_PAGE_START ],
									 kAPI_PAGE_LIMIT => $_REQUEST[ kAPI_PAGE_LIMIT ],
									 kAPI_PAGE_COUNT => 0 ) );
		
		} // Provided paging parameters.
	
	} // _FormatPaging.

	 
	/*===================================================================================
	 *	_FormatQuery																	*
	 *==================================================================================*/

	/**
	 * Format query.
	 *
	 * The main duty of this method is to format the provided query. This parameter will be
	 * provided as an array in which the first level element indexes can take the following
	 * values:
	 *
	 * <ul>
	 *	<li><i>Conditional Operator</i>: If any of {@link kOPERATOR_AND},
	 *		{@link kOPERATOR_OR}, {@link kOPERATOR_NAND} or {@link kOPERATOR_NOR} is found
	 *		as index, it means that the query is applied to the provided container.
	 *	<li><tt>integer</tt>: An integer index indicates that the provided query is a list
	 *		of queries for the container provided to the service.
	 *	<li><i>other</i>: Any other kind of data will be cast to a string and interpreted as
	 *		the container name.
	 * </ul>
	 *
	 * In this class we do nothing, derived classes may overload this method to customise
	 * the structure before it gets validated.
	 *
	 * @access protected
	 *
	 * @see kAPI_QUERY
	 */
	protected function _FormatQuery()													   {}

	 
	/*===================================================================================
	 *	_FormatSelect																	*
	 *==================================================================================*/

	/**
	 * Format selection parameters.
	 *
	 * This method will create an array from a scalar, if necessary.
	 *
	 * @access protected
	 *
	 * @see kAPI_SELECT
	 */
	protected function _FormatSelect()
	{
		//
		// Handle scalars.
		//
		if( array_key_exists( kAPI_SELECT, $_REQUEST )
		 && (! is_array( $_REQUEST[ kAPI_SELECT ] )) )
			$_REQUEST[ kAPI_SELECT ] = array( $_REQUEST[ kAPI_SELECT ] );
	
	} // _FormatSelect.

	 
	/*===================================================================================
	 *	_FormatSort																		*
	 *==================================================================================*/

	/**
	 * Format selection parameters.
	 *
	 * This method will create an array from a scalar, if necessary.
	 *
	 * @access protected
	 *
	 * @see kAPI_SORT
	 */
	protected function _FormatSort()
	{
		//
		// Handle scalars.
		//
		if( array_key_exists( kAPI_SORT, $_REQUEST )
		 && (! is_array( $_REQUEST[ kAPI_SORT ] )) )
			$_REQUEST[ kAPI_SORT ] = array( $_REQUEST[ kAPI_SORT ] );
	
	} // _FormatSort.

		

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
			case kAPI_OP_MATCH:
				//
				// Check for query.
				//
				if( ! array_key_exists( kAPI_QUERY, $_REQUEST ) )
					throw new CException
						( "Missing query list parameter",
						  kERROR_MISSING,
						  kSTATUS_ERROR,
						  array( 'Operation' => $parameter ) );					// !@! ==>
				
			case kAPI_OP_COUNT:
			case kAPI_OP_GET:
			case kAPI_OP_GET_ONE:
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
				// Check for container.
				//
				if( ! array_key_exists( kAPI_CONTAINER, $_REQUEST ) )
					throw new CException
						( "Missing container parameter",
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
	 *	_ValidateDatabase																*
	 *==================================================================================*/

	/**
	 * Validate database.
	 *
	 * This method should check if the database is valid, in this class we check if the
	 * database is an instance of {@link CDatabase}.
	 *
	 * In derived classes that implement concrete instances of {@link CDatabase}, you
	 * should override this method using the specific database.
	 *
	 * @access protected
	 *
	 * @see kAPI_DATABASE
	 */
	protected function _ValidateDatabase()
	{
		//
		// Check parameter.
		//
		if( array_key_exists( kAPI_DATABASE, $_REQUEST ) )
		{
			//
			// Check database.
			//
			if( ! ($_REQUEST[ kAPI_DATABASE ] instanceof CDatabase) )
				throw new CException
					( "Invalid database type: expecting an instance of CDatabase",
					  kERROR_STATE,
					  kSTATUS_ERROR );									// !@! ==>
		
		} // Provided database.
	
	} // _FormatDatabase.

	 
	/*===================================================================================
	 *	_ValidateContainer																*
	 *==================================================================================*/

	/**
	 * Validate container.
	 *
	 * This method should check if the container is valid, in this class we check if the
	 * container is an instance of {@link CContainer}.
	 *
	 * In derived classes that implement concrete instances of {@link CContainer}, you
	 * should override this method using the specific container.
	 *
	 * @access protected
	 *
	 * @see kAPI_CONTAINER
	 */
	protected function _ValidateContainer()
	{
		//
		// Check parameter.
		//
		if( array_key_exists( kAPI_CONTAINER, $_REQUEST ) )
		{
			//
			// Check container.
			//
			if( ! ($_REQUEST[ kAPI_CONTAINER ] instanceof CContainer) )
				throw new CException
					( "Invalid container type: expecting an instance of CContainer",
					  kERROR_STATE,
					  kSTATUS_ERROR );									// !@! ==>
		
		} // Provided container.
	
	} // _ValidateContainer.

	 
	/*===================================================================================
	 *	_ValidatePaging																	*
	 *==================================================================================*/

	/**
	 * Validate paging parameters.
	 *
	 * The duty of this method is to validate the paging parameters, in this class we
	 * ensure the {@link kAPI_PAGE_LIMIT} is not greater than the maximum allowed,
	 * {@link kDEFAULT_MAX_LIMIT}.
	 *
	 * @access protected
	 *
	 * @see kAPI_PAGING kAPI_PAGE_START kAPI_PAGE_LIMIT
	 */
	protected function _ValidatePaging()
	{
		//
		// Check parameter.
		//
		if( $this->offsetExists( kAPI_PAGING ) )
		{
			//
			// Check limit.
			//
			if( ($tmp = $this->offsetGet( kAPI_PAGING )[ kAPI_PAGE_LIMIT ])
					> kDEFAULT_MAX_LIMIT )
				throw new CException
					( ("Cannot satisfy request: exceeded ("
					  .$tmp.") maximum page limit of ".kDEFAULT_MAX_LIMIT),
					  kERROR_PARAMETER,
					  kSTATUS_ERROR );									// !@! ==>
		
		} // Provided paging parameters.
	
	} // _ValidatePaging.

	 
	/*===================================================================================
	 *	_ValidateQuery																	*
	 *==================================================================================*/

	/**
	 * Validate query parameters.
	 *
	 * The duty of this method is to validate the query parameter, in this class we will
	 * unserialise eventual serialised data types and convert the query or the queries into
	 * {@link CQuery} instances, this will be done by a container determined by the
	 * index data types of the provided query parameter array:
	 *
	 * <ul>
	 *	<li><i>Conditional Operator</i>: If any of {@link kOPERATOR_AND},
	 *		{@link kOPERATOR_OR}, {@link kOPERATOR_NAND} or {@link kOPERATOR_NOR} is found
	 *		as index, it means that the query is scalar and the provided container parameter
	 *		will be used to instantiate the {@link CQuery} instance.
	 *	<li><tt>integer</tt>: An integer index indicates that the query parameter is a list
	 *		of queries, each query will be cast to a {@link CQuery} instance by the provided
	 *		container parameter.
	 *	<li><i>other</i>: Any other kind of data will be cast to a string and interpreted as
	 *		the container name.
	 * </ul>
	 *
	 * @access protected
	 *
	 * @see kAPI_QUERY
	 */
	protected function _ValidateQuery()
	{
		//
		// Check parameter.
		//
		if( array_key_exists( kAPI_QUERY, $_REQUEST ) )
		{
			//
			// Check query type.
			//
			if( is_array( $_REQUEST[ kAPI_QUERY ] ) )
			{
				//
				// Reset array pointers.
				//
				reset( $_REQUEST[ kAPI_QUERY ] );
				
				//
				// Handle scalar query.
				//
				if( in_array( key( $_REQUEST[ kAPI_QUERY ] ),
							  array( kOPERATOR_AND, kOPERATOR_NAND,
									 kOPERATOR_OR, kOPERATOR_NOR ) ) )
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
							->UnserialiseObject( $_REQUEST[ kAPI_QUERY ] );
						
						//
						// Format and verify query.
						//
						$this->_VerifyQuery( $_REQUEST[ kAPI_QUERY ],
											 $_REQUEST[ kAPI_CONTAINER ] );
					
					} // Provided container.
					
					else
						throw new CException
							( "Unable to format query: missing container",
							  kERROR_MISSING,
							  kSTATUS_ERROR );							// !@! ==>
				
				} // Scalar query.
				
				//
				// Handle query lists.
				//
				else
				{
					//
					// Iterate queries.
					//
					$keys = array_keys( $_REQUEST[ kAPI_QUERY ] );
					foreach( $keys as $key )
					{
						//
						// Handle scalar query.
						//
						if( is_integer( $key ) )
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
									->UnserialiseObject( $_REQUEST[ kAPI_QUERY ][ $key ] );
								
								//
								// Format and verify query.
								//
								$this->_VerifyQuery( $_REQUEST[ kAPI_QUERY ][ $key ],
													 $_REQUEST[ kAPI_CONTAINER ] );
							
							} // Provided container.
							
							else
								throw new CException
									( "Unable to format query: missing container",
									  kERROR_MISSING,
									  kSTATUS_ERROR );					// !@! ==>
						
						} // Scalar query.
						
						//
						// Handle container list.
						//
						else
						{
							//
							// Check database.
							// If there it should already be a CContainer instance.
							//
							if( array_key_exists( kAPI_DATABASE, $_REQUEST ) )
							{
								//
								// Instantiate container.
								//
								$container = $_REQUEST[ kAPI_DATABASE ]->Container( $key );
							
								//
								// Unserialise standard data types.
								//
								$container
									->UnserialiseObject( 
										$_REQUEST[ kAPI_QUERY ][ $key ] );
								
								//
								// Format and verify query.
								//
								$this->_VerifyQuery( $_REQUEST[ kAPI_QUERY ][ $key ],
													 $_REQUEST[ kAPI_DATABASE ]
														->Container( $container ) );
							
							} // Provided database.
							
							else
								throw new CException
									( "Unable to format query: missing database",
									  kERROR_MISSING,
									  kSTATUS_ERROR );					// !@! ==>
						
						} // Container query.
					
					} // Iterating queries.
				
				} // Queries list.
			
			} // Query is an array.
			
			else
				throw new CException
					( "Unable to format query: invalid query data type",
					  kERROR_PARAMETER,
					  kSTATUS_ERROR,
					  array( 'Type' => gettype( $_REQUEST[ kAPI_QUERY ] ) ) );	// !@! ==>
		
		} // Provided query parameter.
	
	} // _ValidateQuery.

	 
	/*===================================================================================
	 *	_ValidateSelect																	*
	 *==================================================================================*/

	/**
	 * Validate selection parameters.
	 *
	 * The duty of this method is to validate the selection parameter, in this class we
	 * assume the value to be array, if a scalar is provided, we convert it to a string and
	 * create with it an array.
	 *
	 * If the resulting array is empty, we remove the request.
	 *
	 * @access protected
	 *
	 * @see kAPI_SELECT
	 */
	protected function _ValidateSelect()
	{
		//
		// Check parameter.
		//
		if( array_key_exists( kAPI_SELECT, $_REQUEST ) )
		{
			//
			// Convert to array.
			//
			if( ! is_array( $_REQUEST[ kAPI_SELECT ] ) )
			{
				//
				// Handle non-empty string.
				//
				if( strlen( $_REQUEST[ kAPI_SELECT ] ) )
					$_REQUEST[ kAPI_SELECT ] = array( (string) $_REQUEST[ kAPI_SELECT ] );
				
				//
				// Remove request.
				//
				else
					unset( $_REQUEST[ kAPI_SELECT ] );
			}
		
		} // Provided query selection.
	
	} // _ValidateSelect.

	 
	/*===================================================================================
	 *	_ValidateSort																	*
	 *==================================================================================*/

	/**
	 * Validate sort selection parameters.
	 *
	 * The duty of this method is to validate the sort selection parameters, in this class
	 * we assume the value to be array, if a scalar is provided, we convert it to a string
	 * and create with it an array.
	 *
	 * If the resulting array is empty, we remove the request.
	 *
	 * @access protected
	 *
	 * @see kAPI_SORT
	 */
	protected function _ValidateSort()
	{
		//
		// Check parameter.
		//
		if( array_key_exists( kAPI_SORT, $_REQUEST ) )
		{
			//
			// Convert to array.
			//
			if( ! is_array( $_REQUEST[ kAPI_SORT ] ) )
			{
				//
				// Handle non-empty string.
				//
				if( strlen( $_REQUEST[ kAPI_SORT ] ) )
					$_REQUEST[ kAPI_SORT ] = array( (string) $_REQUEST[ kAPI_SORT ] );
				
				//
				// Remove request.
				//
				else
					unset( $_REQUEST[ kAPI_SORT ] );
			}
		
		} // Provided query selection.
	
	} // _ValidateSort.

		

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
				case kAPI_OP_COUNT:
					$this->_Handle_Count();
					break;
	
				case kAPI_OP_GET:
					$this->_Handle_Get();
					break;
	
				case kAPI_OP_GET_ONE:
					$this->_Handle_GetOne();
					break;
	
				case kAPI_OP_MATCH:
					$this->_Handle_Match();
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
		// Add kAPI_OP_COUNT.
		//
		$theList[ kAPI_OP_COUNT ]
			= 'Count query: returns the count of the provided query.';

		//
		// Add kAPI_OP_GET.
		//
		$theList[ kAPI_OP_GET ]
			= 'Query: returns the list of elements that are matched by the provided query.';
	
	} // _Handle_ListOp.

	 
	/*===================================================================================
	 *	_Handle_Count																	*
	 *==================================================================================*/

	/**
	 * Handle {@link kAPI_OP_COUNT} request.
	 *
	 * This method will handle the {@link kAPI_OP_COUNT} operation, which returns the total
	 * count of a query in the {@link kAPI_AFFECTED_COUNT} field of the status.
	 *
	 * @access protected
	 */
	protected function _Handle_Count()
	{
		//
		// Get query.
		//
		$query = ( array_key_exists( kAPI_QUERY, $_REQUEST ) )
				? $_REQUEST[ kAPI_QUERY ]
				: NULL;
		
		//
		// Perform query.
		//
		$cursor = $_REQUEST[ kAPI_CONTAINER ]->Query( $query );
		
		//
		// Set count.
		//
		$this->_OffsetManage( kAPI_STATUS, kAPI_AFFECTED_COUNT, $cursor->count( FALSE ) );
	
	} // _Handle_Count.

	 
	/*===================================================================================
	 *	_Handle_Get																		*
	 *==================================================================================*/

	/**
	 * Handle {@link kAPI_OP_GET} request.
	 *
	 * This method will handle the {@link kAPI_OP_GET} operation, which returns the
	 * records that match the provided query..
	 *
	 * @access protected
	 */
	protected function _Handle_Get()
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
			// Collect results.
			//
			$results = Array();
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
	
	} // _Handle_Get.

	 
	/*===================================================================================
	 *	_Handle_GetOne																	*
	 *==================================================================================*/

	/**
	 * Handle {@link kAPI_OP_GET_ONE} request.
	 *
	 * This method will handle the {@link kAPI_OP_GET_ONE} operation, which returns the
	 * first record to satisfy a query.
	 *
	 * @access protected
	 */
	protected function _Handle_GetOne()
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
		// Query.
		//
		$object
			= $_REQUEST[ kAPI_CONTAINER ]
				->Query( $query, $fields, NULL, NULL, NULL, TRUE );
				
		//
		// Handle object.
		//
		if( $object !== NULL )
		{
			//
			// Set affected count.
			//
			$this->_OffsetManage( kAPI_STATUS, kAPI_AFFECTED_COUNT, 1 );
			
			//
			// Handle page count.
			//
			if( $this->offsetExists( kAPI_PAGING ) )
			{
				$tmp = $this->offsetGet( kAPI_PAGING );
				$tmp[ kAPI_PAGE_COUNT ] = 1;
				$this->offsetSet( kAPI_PAGING, $tmp );
			}
			
			//
			// Serialise object.
			//
			CDataType::SerialiseObject( $object );
			
			//
			// Save object in response.
			//
			$this->offsetSet( kAPI_RESPONSE, $object );
		
		} // Found object.
	
	} // _Handle_GetOne.

	 
	/*===================================================================================
	 *	_Handle_Match																	*
	 *==================================================================================*/

	/**
	 * Handle {@link kAPI_OP_MATCH} request.
	 *
	 * This method will handle the {@link kAPI_OP_MATCH} operation, which returns the first
	 * match of a series of queries.
	 *
	 * @access protected
	 */
	protected function _Handle_Match()
	{
		//
		// Handle fields.
		//
		$fields = ( array_key_exists( kAPI_SELECT, $_REQUEST ) )
				? $_REQUEST[ kAPI_SELECT ]
				: Array();
		
		//
		// Iterate queries.
		//
		foreach( $_REQUEST[ kAPI_QUERY ] as $query )
		{
			//
			// Query.
			//
			$object
				= $_REQUEST[ kAPI_CONTAINER ]
					->Query( $query, $fields, NULL, NULL, NULL, TRUE );
			
			//
			// Handle object.
			//
			if( $object !== NULL )
			{
				//
				// Set affected count.
				//
				$this->_OffsetManage( kAPI_STATUS, kAPI_AFFECTED_COUNT, 1 );
				
				//
				// Handle page count.
				//
				if( $this->offsetExists( kAPI_PAGING ) )
				{
					$tmp = $this->offsetGet( kAPI_PAGING );
					$tmp[ kAPI_PAGE_COUNT ] = 1;
					$this->offsetSet( kAPI_PAGING, $tmp );
				}
				
				//
				// Serialise object.
				//
				CDataType::SerialiseObject( $object );
				
				//
				// Save object in response.
				//
				$this->offsetSet( kAPI_RESPONSE, $object );
				
				break;														// =>
			
			} // Found object.
		
		} // Iterating queries.
	
	} // _Handle_Match.

		

/*=======================================================================================
 *																						*
 *									PROTECTED UTILITIES									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_VerifyQuery																	*
	 *==================================================================================*/

	/**
	 * Check and verify query.
	 *
	 * This method can ve used to verify a query, it will traverse the provided array until
	 * it finds a condition operator, in that case it will convert the array, if necessary,
	 * to a {@link CQuery} object and {@link CQuery::Validate()}.
	 *
	 * The method expects the {@link kAPI_CONTAINER} parameter to have been set.
	 *
	 * @param reference			   &$theQuery			Query structure.
	 * @param CContainer			$theContainer		Container object.
	 *
	 * @access protected
	 */
	protected function _VerifyQuery( &$theQuery, CContainer $theContainer )
	{
		//
		// Check query.
		//
		if( ! ($theQuery instanceof CQuery) )
		{
			//
			// Handle arrays.
			//
			if( is_array( $theQuery ) )
			{
				//
				// Check if it is a query.
				//
				if( in_array( key( $theQuery ),
							  array( kOPERATOR_AND, kOPERATOR_NAND,
							  		 kOPERATOR_OR, kOPERATOR_NOR ) ) )
				{
					//
					// Convert to query.
					//
					$theQuery = $theContainer->NewQuery( $theQuery );
					
					//
					// Validate query.
					//
					$theQuery->Validate();
					
				} // Found query.
				
				//
				// Handle query list.
				//
				else
				{
					//
					// Recurse array elements.
					//
					$keys = array_keys( $theQuery );
					foreach( $keys as $key )
						$this->_VerifyQuery( $theQuery[ $key ], $theContainer );
				
				} // Query list.
			
			} // Is array.
		
		} // Not yet a query.
	
	} // _VerifyQuery.

	 

} // class CDataWrapper.


?>

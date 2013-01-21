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
 *		<li><i>{@link kAPI_DISTINCT}</i>: <i>Distinct</i>, this string represents the
 *			property name of an object: if provided, all queries will no longer return the
 *			list of matching elements, but the list of distinct values of that property of
 *			the query selection.
 *		<li><i>{@link kAPI_OBJECT}</i>: <i>Object</i>, this array parameter represents the
 *			object that is to be inserted or updated in a container.
 *		<li><i>{@link kAPI_CLASS}</i>: <i>Class</i>, this string parameter represents the
 *			class of the {@link kAPI_OBJECT} object parameter, if provided, it is assumed
 *			that the object provided in the {@link kAPI_OBJECT} parameter is an instance of
 *			that class.
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
 *			<li><i>{@link kTERM_STATUS_IDENTIFIER}</i>: Object identifier (output): this
 *				parameter will contain the native identifier, {@link kTAG_NID}, of the newly
 *				created object when calling a {@link kAPI_OP_INSERT} operation. This is
 *				especially useful when that attribute is computed, rather than explicitly
 *				set beforehand.
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
 *			<li><i>{@link kAPI_PAGE_LIMIT}</i>:This parameter is required or enforced, it
 *		 </ul>
 *		<li><i>{@link kAPI_OP_RESOLVE}</i>: <i>Resolve</i>, this operation will return the
 *			object that matches the provided value. The operation expects the following
 *			parameters:
 *		 <ul>
 *			<li><i>{@link kAPI_FORMAT}</i>: This parameter is required to indicate how to
 *				encode the response.
 *			<li><i>{@link kAPI_DATABASE}</i>: This parameter is required to indicate the
 *				working database.
 *			<li><i>{@link kAPI_CONTAINER}</i>: This parameter is required to indicate the
 *				working container. Note that in some cases this parameter is not required,
 *				in particular, when providing the {@link kAPI_CLASS} parameter, the
 *				container might be implicit.
 *			<li><i>{@link kAPI_OBJECT}</i>: This parameter is required and contains the
 *				value to be matched.
 *			<li><i>{@link kAPI_CLASS}</i>: This parameter is required, it represents the
 *				class from which the <tt>Resolve()</tt> static method will be used.
 *		 </ul>
 *		<li><i>{@link kAPI_OP_INSERT}</i>: <i>Insert</i>, this operation will insert the
 *			provided object into the database or container. The operation expects the
 *			following parameters:
 *		 <ul>
 *			<li><i>{@link kAPI_FORMAT}</i>: This parameter is required to indicate how to
 *				encode the response.
 *			<li><i>{@link kAPI_DATABASE}</i>: This parameter is required to indicate the
 *				working database.
 *			<li><i>{@link kAPI_CONTAINER}</i>: This parameter is required to indicate the
 *				working container. Note that in some cases this parameter is not required,
 *				in particular, when providing the {@link kAPI_CLASS} parameter, the
 *				container might be implicit.
 *			<li><i>{@link kAPI_OBJECT}</i>: This parameter is required and contains an array
 *				or corresponding to the new record.
 *			<li><i>{@link kAPI_CLASS}</i>: If provided, this parameter indicates which
 *				instance the object should be; if not provided, the {@link kAPI_CONTAINER}
 *				parameter is required and the object will simply be added to the container.
 *		 </ul>
 *		<li><i>{@link kAPI_OP_DELETE}</i>: <i>Delete</i>, this operation will delete either
 *			a selection of objects matching a query or one object matching a value. The
 *			operation expects the following parameters:
 *		 <ul>
 *			<li><i>{@link kAPI_FORMAT}</i>: This parameter is required to indicate how to
 *				encode the response.
 *			<li><i>{@link kAPI_DATABASE}</i>: This parameter is required to indicate the
 *				working database.
 *			<li><i>{@link kAPI_CONTAINER}</i>: This parameter is required to indicate the
 *				working container. Note that in some cases this parameter is not required,
 *				in particular, when providing the {@link kAPI_CLASS} parameter, the
 *				container might be implicit.
 *			<li><i>{@link kAPI_QUERY}</i>: This parameter contains the query that selects
 *				the items to be deleted.
 *			<li><i>{@link kAPI_OBJECT}</i>: This parameter is required and contains the
 *				value by which the object will be identified, some classes feature a
 *				<i>Resolve()</i> method, in that case  this value will be handled by that
 *				method, if not, the value is assumed to be the object0s {@link kTAG_NID}. If
 *				this parameter is provided, the {@link kAPI_QUERY} parameter will be
 *				ignored.
 *			<li><i>{@link kAPI_CLASS}</i>: If provided, this parameter indicates to which
 *				class the object to be deleted belongs to; if not provided, the
 *				{@link kAPI_CONTAINER} parameter is required and the object is assumed to be
 *				the object's {@link kTAG_NID}. This parameter is ignored if the
 *				{@link kAPI_OBJECT} parameter is missing.
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
	 								 kAPI_QUERY, kAPI_SELECT, kAPI_SORT,
	 								 kAPI_DISTINCT, kAPI_CLASS, kAPI_OBJECT,
	 								 kAPI_CRITERIA );

		

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
	 * @uses _ParseClass()
	 * @uses _ParseDatabase()
	 * @uses _ParseContainer()
	 * @uses _ParsePaging()
	 * @uses _ParseQuery()
	 * @uses _ParseSelect()
	 * @uses _ParseSort()
	 * @uses _ParseDistinct()
	 * @uses _ParseObject()
	 * @uses _ParseCriteria()
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
		$this->_ParseClass();
		$this->_ParseDatabase();
		$this->_ParseContainer();
		$this->_ParsePaging();
		$this->_ParseQuery();
		$this->_ParseSelect();
		$this->_ParseSort();
		$this->_ParseDistinct();
		$this->_ParseObject();
		$this->_ParseCriteria();
	
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
	 * @uses _FormatClass()
	 * @uses _FormatDatabase()
	 * @uses _FormatContainer()
	 * @uses _FormatPaging()
	 * @uses _FormatQuery()
	 * @uses _FormatSelect()
	 * @uses _FormatSort()
	 * @uses _FormatDistinct()
	 * @uses _FormatObject()
	 * @uses _FormatCriteria()
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
		$this->_FormatClass();
		$this->_FormatDatabase();
		$this->_FormatContainer();
		$this->_FormatPaging();
		$this->_FormatQuery();
		$this->_FormatSelect();
		$this->_FormatSort();
		$this->_FormatDistinct();
		$this->_FormatObject();
		$this->_FormatCriteria();
	
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
	 * @uses _ValidateClass()
	 * @uses _ValidateDatabase()
	 * @uses _ValidateContainer()
	 * @uses _ValidatePaging()
	 * @uses _ValidateQuery()
	 * @uses _ValidateSelect()
	 * @uses _ValidateSort()
	 * @uses _ValidateDistinct()
	 * @uses _ValidateObject()
	 * @uses _ValidateCriteria()
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
		$this->_ValidateClass();
		$this->_ValidateDatabase();
		$this->_ValidateContainer();
		$this->_ValidatePaging();
		$this->_ValidateQuery();
		$this->_ValidateSelect();
		$this->_ValidateSort();
		$this->_ValidateDistinct();
		$this->_ValidateObject();
		$this->_ValidateCriteria();
	
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
	 * We overload this method to remove unnecessary parameters from the request, depending
	 * on the current operation.
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
			//
			// COUNT service.
			//
			case kAPI_OP_COUNT:
				//
				// Remove unnecessary parameters.
				//
				$list = array( kAPI_PAGE_START, kAPI_PAGE_LIMIT,
							   kAPI_OBJECT, kAPI_SORT, kAPI_CLASS );
				foreach( $list as $element )
				{
					if( array_key_exists( $element, $_REQUEST ) )
						unset( $_REQUEST[ $element ] );
				}
				break;
				
			case kAPI_OP_GET:
				//
				// Remove unnecessary parameters.
				//
				$list = array( kAPI_OBJECT, kAPI_CLASS );
				foreach( $list as $element )
				{
					if( array_key_exists( $element, $_REQUEST ) )
						unset( $_REQUEST[ $element ] );
				}
				break;
				
			case kAPI_OP_GET_ONE:
				//
				// Remove unnecessary parameters.
				//
				$list = array( kAPI_PAGE_START, kAPI_PAGE_LIMIT,
							   kAPI_OBJECT, kAPI_SORT, kAPI_DISTINCT,
							   kAPI_CLASS );
				foreach( $list as $element )
				{
					if( array_key_exists( $element, $_REQUEST ) )
						unset( $_REQUEST[ $element ] );
				}
				break;
				
			case kAPI_OP_RESOLVE:
				//
				// Remove unnecessary parameters.
				//
				$list = array( kAPI_PAGE_START, kAPI_PAGE_LIMIT,
							   kAPI_QUERY, kAPI_SORT, kAPI_DISTINCT );
				foreach( $list as $element )
				{
					if( array_key_exists( $element, $_REQUEST ) )
						unset( $_REQUEST[ $element ] );
				}
				break;
				
			case kAPI_OP_INSERT:
				//
				// Remove unnecessary parameters.
				//
				$list = array( kAPI_PAGE_START, kAPI_PAGE_LIMIT,
							   kAPI_QUERY, kAPI_SELECT, kAPI_SORT, kAPI_DISTINCT );
				foreach( $list as $element )
				{
					if( array_key_exists( $element, $_REQUEST ) )
						unset( $_REQUEST[ $element ] );
				}
				break;
				
			case kAPI_OP_MODIFY:
				//
				// Remove unnecessary parameters.
				//
				$list = array( kAPI_PAGE_START, kAPI_PAGE_LIMIT,
							   kAPI_SELECT, kAPI_SORT, kAPI_DISTINCT );
				foreach( $list as $element )
				{
					if( array_key_exists( $element, $_REQUEST ) )
						unset( $_REQUEST[ $element ] );
				}
				break;
				
			case kAPI_OP_DELETE:
				//
				// Remove unnecessary parameters.
				//
				$list = array( kAPI_PAGE_START, kAPI_PAGE_LIMIT,
							   kAPI_SELECT, kAPI_SORT, kAPI_DISTINCT );
				foreach( $list as $element )
				{
					if( array_key_exists( $element, $_REQUEST ) )
						unset( $_REQUEST[ $element ] );
				}
				break;
		}
	
	} // _ParseOperation.

	 
	/*===================================================================================
	 *	_ParseClass																		*
	 *==================================================================================*/

	/**
	 * Parse object.
	 *
	 * This method will copy the class to the request block.
	 *
	 * @access protected
	 *
	 * @uses _OffsetManage()
	 *
	 * @see kAPI_CLASS kAPI_REQUEST
	 */
	protected function _ParseClass()
	{
		//
		// Handle query.
		//
		if( array_key_exists( kAPI_CLASS, $_REQUEST ) )
		{
			if( $this->offsetExists( kAPI_REQUEST ) )
				$this->_OffsetManage
					( kAPI_REQUEST, kAPI_CLASS, $_REQUEST[ kAPI_CLASS ] );
		}
	
	} // _ParseClass.

	 
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
		// Handle paging.
		//
		if( array_key_exists( kAPI_PAGE_START, $_REQUEST )
		 || array_key_exists( kAPI_PAGE_LIMIT, $_REQUEST ) )
		{
			//
			// Handle page start.
			//
			if( array_key_exists( kAPI_PAGE_START, $_REQUEST ) )
			{
				if( $this->offsetExists( kAPI_REQUEST ) )
					$this->_OffsetManage
						( kAPI_REQUEST, kAPI_PAGE_START, $_REQUEST[ kAPI_PAGE_START ] );
			}
	
			//
			// Handle page limit.
			//
			if( array_key_exists( kAPI_PAGE_LIMIT, $_REQUEST ) )
			{
				if( $this->offsetExists( kAPI_REQUEST ) )
					$this->_OffsetManage
						( kAPI_REQUEST, kAPI_PAGE_LIMIT, $_REQUEST[ kAPI_PAGE_LIMIT ] );
			}
		
		} // Provided paging parameters.
		
		//
		// Enforce page limit.
		//
		else
		{
			switch( $_REQUEST[ kAPI_OPERATION ] )
			{
				case kAPI_OP_GET:
					$_REQUEST[ kAPI_PAGE_START ] = 0;
					break;
			}
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

	 
	/*===================================================================================
	 *	_ParseDistinct																	*
	 *==================================================================================*/

	/**
	 * Parse distinct.
	 *
	 * This method will copy the distinct values property name to the request block.
	 *
	 * @access protected
	 *
	 * @uses _OffsetManage()
	 *
	 * @see kAPI_DISTINCT kAPI_REQUEST
	 */
	protected function _ParseDistinct()
	{
		//
		// Handle query.
		//
		if( array_key_exists( kAPI_DISTINCT, $_REQUEST ) )
		{
			if( $this->offsetExists( kAPI_REQUEST ) )
				$this->_OffsetManage
					( kAPI_REQUEST, kAPI_DISTINCT, $_REQUEST[ kAPI_DISTINCT ] );
		}
	
	} // _ParseDistinct.

	 
	/*===================================================================================
	 *	_ParseObject																	*
	 *==================================================================================*/

	/**
	 * Parse object.
	 *
	 * This method will copy the object to the request block.
	 *
	 * @access protected
	 *
	 * @uses _OffsetManage()
	 *
	 * @see kAPI_OBJECT kAPI_REQUEST
	 */
	protected function _ParseObject()
	{
		//
		// Handle query.
		//
		if( array_key_exists( kAPI_OBJECT, $_REQUEST ) )
		{
			if( $this->offsetExists( kAPI_REQUEST ) )
				$this->_OffsetManage
					( kAPI_REQUEST, kAPI_OBJECT, $_REQUEST[ kAPI_OBJECT ] );
		}
	
	} // _ParseObject.

	 
	/*===================================================================================
	 *	_ParseCriteria																	*
	 *==================================================================================*/

	/**
	 * Parse object.
	 *
	 * This method will copy the criteria to the request block.
	 *
	 * @access protected
	 *
	 * @uses _OffsetManage()
	 *
	 * @see kAPI_CRITERIA kAPI_REQUEST
	 */
	protected function _ParseCriteria()
	{
		//
		// Handle query.
		//
		if( array_key_exists( kAPI_CRITERIA, $_REQUEST ) )
		{
			if( $this->offsetExists( kAPI_REQUEST ) )
				$this->_OffsetManage
					( kAPI_REQUEST, kAPI_CRITERIA, $_REQUEST[ kAPI_CRITERIA ] );
		}
	
	} // _ParseCriteria.

		

/*=======================================================================================
 *																						*
 *							PROTECTED FORMATTING UTILITIES								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_FormatClass																	*
	 *==================================================================================*/

	/**
	 * Format class parameter.
	 *
	 * This method will first check if the class is available, then, if the container is
	 * missing, it will set its name with the eventual
	 * {@link CPersistentDocument::DefaultContainerName()} method.
	 *
	 * @access protected
	 *
	 * @see kAPI_CLASS
	 */
	protected function _FormatClass()
	{
		//
		// Check parameter.
		//
		if( array_key_exists( kAPI_CLASS, $_REQUEST ) )
		{
			//
			// Check if class exists.
			//
			if( class_exists( $_REQUEST[ kAPI_CLASS ] ) )
			{
				//
				// Check if class is persistent.
				//
				if( is_subclass_of( $_REQUEST[ kAPI_CLASS ], 'CPersistentDocument' ) )
				{
					//
					// Handle default container.
					//
					if( ! array_key_exists( kAPI_CONTAINER, $_REQUEST ) )
					{
						//
						// Get name.
						//
						$name = $_REQUEST[ kAPI_CLASS ]::DefaultContainerName();
						if( $name !== NULL )
							$_REQUEST[ kAPI_CONTAINER ] = $name;
					
					} // Missing container.
				
				} // Supports default container names.
			
			} // Valid class.
			
			else
				throw new CException
					( "Unsupported class",
					  kERROR_PARAMETER,
					  kSTATUS_ERROR,
					  array( 'Class' => gettype( $_REQUEST[ kAPI_CLASS ] ) ) );	// !@! ==>
		
		} // Provided query selection.
	
	} // _FormatClass.

	 
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

	 
	/*===================================================================================
	 *	_FormatDistinct																	*
	 *==================================================================================*/

	/**
	 * Format distinct values property parameter.
	 *
	 * In this class we do not format it.
	 *
	 * @access protected
	 *
	 * @see kAPI_DISTINCT
	 */
	protected function _FormatDistinct()												   {}

	 
	/*===================================================================================
	 *	_FormatObject																	*
	 *==================================================================================*/

	/**
	 * Format object parameter.
	 *
	 * This method does nothing in this class.
	 *
	 * @access protected
	 *
	 * @see kAPI_OBJECT
	 */
	protected function _FormatObject()													   {}

	 
	/*===================================================================================
	 *	_FormatCriteria																	*
	 *==================================================================================*/

	/**
	 * Format modification criteria parameter.
	 *
	 * This method does nothing in this class.
	 *
	 * @access protected
	 *
	 * @see kAPI_CRITERIA
	 */
	protected function _FormatCriteria()												   {}

		

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
		switch( $parameter = $_REQUEST[ kAPI_OPERATION ] )
		{
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
			
			case kAPI_OP_MODIFY:
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
					
				//
				// Check for criteria.
				//
				if( ! array_key_exists( kAPI_CRITERIA, $_REQUEST ) )
					throw new CException
						( "Missing modification criteria parameter",
						  kERROR_MISSING,
						  kSTATUS_ERROR,
						  array( 'Operation' => $parameter ) );					// !@! ==>
				
				break;
			
			//
			// Insert operations.
			//
			case kAPI_OP_INSERT:
				//
				// Check for object.
				//
				if( ! array_key_exists( kAPI_OBJECT, $_REQUEST ) )
					throw new CException
						( "Missing object parameter",
						  kERROR_MISSING,
						  kSTATUS_ERROR,
						  array( 'Operation' => $parameter ) );					// !@! ==>
				
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
				
				break;
			
			//
			// Delete operations.
			//
			case kAPI_OP_DELETE:
				//
				// Handle query.
				//
				if( array_key_exists( kAPI_QUERY, $_REQUEST ) )
				{
					//
					// Remove class.
					//
					if( array_key_exists( kAPI_CLASS, $_REQUEST ) )
						unset( $_REQUEST[ kAPI_CLASS ] );
				
					//
					// Remove object.
					//
					if( array_key_exists( kAPI_OBJECT, $_REQUEST ) )
						unset( $_REQUEST[ kAPI_OBJECT ] );
				
				} // Delete selection.
				
				//
				// Delete object.
				//
				else
				{
					//
					// Handle delete container.
					//
					if( (! array_key_exists( kAPI_CLASS, $_REQUEST ))
					 && (! array_key_exists( kAPI_OBJECT, $_REQUEST )) )
					{
						//
						// Check for container.
						//
						if( ! array_key_exists( kAPI_CONTAINER, $_REQUEST ) )
							throw new CException
								( "Missing container parameter",
								  kERROR_MISSING,
								  kSTATUS_ERROR,
								  array( 'Operation' => $parameter ) );			// !@! ==>
					
					} // Clear container.
					
					//
					// Check object.
					//
					elseif( array_key_exists( kAPI_CLASS, $_REQUEST ) )
					{
						//
						// Check class.
						//
						if( ! array_key_exists( kAPI_OBJECT, $_REQUEST ) )
							throw new CException
								( "Missing object parameter",
								  kERROR_MISSING,
								  kSTATUS_ERROR,
								  array( 'Operation' => $parameter ) );			// !@! ==>
					
					} // Provided class.
					
					//
					// Check class.
					//
					elseif( array_key_exists( kAPI_OBJECT, $_REQUEST ) )
					{
						//
						// Check class.
						//
						if( ! array_key_exists( kAPI_CLASS, $_REQUEST ) )
							throw new CException
								( "Missing class parameter",
								  kERROR_MISSING,
								  kSTATUS_ERROR,
								  array( 'Operation' => $parameter ) );			// !@! ==>
					
					} // Provided object.
				
				} // Delete object.
				
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
				
				break;
			
			//
			// Resolve operations.
			//
			case kAPI_OP_RESOLVE:
				//
				// Check class.
				//
				if( ! array_key_exists( kAPI_CLASS, $_REQUEST ) )
					throw new CException
						( "Missing class parameter",
						  kERROR_MISSING,
						  kSTATUS_ERROR,
						  array( 'Operation' => $parameter ) );			// !@! ==>
				
				//
				// Check object.
				//
				if( ! array_key_exists( kAPI_OBJECT, $_REQUEST ) )
					throw new CException
						( "Missing object parameter",
						  kERROR_MISSING,
						  kSTATUS_ERROR,
						  array( 'Operation' => $parameter ) );			// !@! ==>
			
				//
				// Check database.
				//
				if( ! array_key_exists( kAPI_DATABASE, $_REQUEST ) )
					throw new CException
						( "Missing database parameter",
						  kERROR_MISSING,
						  kSTATUS_ERROR,
						  array( 'Operation' => $parameter ) );					// !@! ==>
					
				//
				// Check format.
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
	 *	_ValidateClass																	*
	 *==================================================================================*/

	/**
	 * Validate class parameter.
	 *
	 * The duty of this method is to validate the class parameter, in this class we have
	 * already checked if the class is known to the system and set the eventual missing
	 * container, in derived classes this method could be used to check whether the class
	 * is of the correct type.
	 *
	 * @access protected
	 *
	 * @see kAPI_CLASS
	 */
	protected function _ValidateClass()													   {}

	 
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
				// Validate query.
				//
				$this->_ValidateQueries( $_REQUEST[ kAPI_QUERY ] );
			
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
					$_REQUEST[ kAPI_SELECT ]
						= array( (string) $_REQUEST[ kAPI_SELECT ] );
				
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

	 
	/*===================================================================================
	 *	_ValidateDistinct																*
	 *==================================================================================*/

	/**
	 * Validate distinct values property parameter.
	 *
	 * The duty of this method is to validate the distinct value property parameter, in this
	 * class we check whether the parameter is a string or an array of non-empty strings.
	 *
	 * If the result is empty we remove the parameter.
	 *
	 * @access protected
	 *
	 * @see kAPI_DISTINCT
	 */
	protected function _ValidateDistinct()
	{
		//
		// Check parameter.
		//
		if( array_key_exists( kAPI_DISTINCT, $_REQUEST ) )
		{
			//
			// Handle array.
			//
			if( is_array( $_REQUEST[ kAPI_DISTINCT ] ) )
			{
				//
				// Remove empty strings.
				//
				$list = Array();
				foreach( $_REQUEST[ kAPI_DISTINCT ] as $string )
				{
					if( strlen( $string ) )
						$list[] = (string) $string;
				}
				
				//
				// Update parameter.
				//
				if( count( $list ) )
					$_REQUEST[ kAPI_DISTINCT ] = $list;
				else
					unset( $_REQUEST[ kAPI_DISTINCT ] );
			
			} // List of distinct keys.
			
			//
			// Handle string.
			//
			elseif( ! strlen( $_REQUEST[ kAPI_DISTINCT ] ) )
				unset( $_REQUEST[ kAPI_DISTINCT ] );
		
		} // Provided distinct values property.
	
	} // _ValidateDistinct.

	 
	/*===================================================================================
	 *	_ValidateObject																	*
	 *==================================================================================*/

	/**
	 * Validate object parameter.
	 *
	 * The duty of this method is to validate the object parameter, in this class we assert
	 * the value to be an array, and we instantiate the correct class if the provided.
	 *
	 * @access protected
	 *
	 * @see kAPI_OBJECT
	 */
	protected function _ValidateObject()
	{
		//
		// Check parameter.
		//
		if( array_key_exists( kAPI_OBJECT, $_REQUEST ) )
		{
			//
			// Parse by operation.
			//
			switch( $_REQUEST[ kAPI_OPERATION ] )
			{
				//
				// Writing requires an object:
				// we assume an array does it.
				//
				case kAPI_OP_INSERT:
					//
					// Check object type.
					//
					if( ! is_array( $_REQUEST[ kAPI_OBJECT ] ) )
						throw new CException
							( "Unable to format object: "
							."invalid object data type for current operation",
							  kERROR_PARAMETER,
							  kSTATUS_ERROR,
							  array( 'Operation' => $_REQUEST[ kAPI_OPERATION ],
									 'Type' => gettype(
									 			$_REQUEST[ kAPI_OBJECT ] ) ) );	// !@! ==>
					
					//
					// Unserialise standard data types.
					//
					$_REQUEST[ kAPI_CONTAINER ]
						->UnserialiseObject( $_REQUEST[ kAPI_OBJECT ] );
		
					//
					// Instantiate correct object.
					//
					if( array_key_exists( kAPI_CLASS, $_REQUEST ) )
						$_REQUEST[ kAPI_OBJECT ]
							= new $_REQUEST[ kAPI_CLASS ](
								$_REQUEST[ kAPI_OBJECT ] );
								
					break;
					
				//
				// Resolve object.
				//
				case kAPI_OP_RESOLVE:
				case kAPI_OP_DELETE:
					//
					// Handle object delete.
					//
					if( array_key_exists( kAPI_OBJECT, $_REQUEST ) )
					{
						//
						// Unserialise standard data types.
						//
						$_REQUEST[ kAPI_CONTAINER ]
							->UnserialiseObject( $_REQUEST[ kAPI_OBJECT ] );
					
						//
						// Resolve object.
						//
						$_REQUEST[ kAPI_OBJECT ]
							= $_REQUEST[ kAPI_CLASS ]::Resolve(
								$_REQUEST[ kAPI_CONTAINER ], $_REQUEST[ kAPI_OBJECT ] );
					
					} // Object delete.
								
					break;
			}
		
		} // Provided object.
	
	} // _ValidateObject.

	 
	/*===================================================================================
	 *	_ValidateCriteria																*
	 *==================================================================================*/

	/**
	 * Validate modification criteria parameter.
	 *
	 * In this class we unserialise the eventual serialised values of the modification
	 * criteria.
	 *
	 * @access protected
	 *
	 * @see kAPI_CRITERIA
	 */
	protected function _ValidateCriteria()
	{
		//
		// Unserialise standard data types.
		//
		if( array_key_exists( kAPI_CRITERIA, $_REQUEST ) )
			$_REQUEST[ kAPI_CONTAINER ]
				->UnserialiseObject( $_REQUEST[ kAPI_CRITERIA ] );
	
	} // _ValidateCriteria.

		

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
	
				case kAPI_OP_RESOLVE:
					$this->_Handle_Resolve();
					break;
	
				case kAPI_OP_INSERT:
					$this->_Handle_Insert();
					break;
	
				case kAPI_OP_MODIFY:
					$this->_Handle_Modify();
					break;
	
				case kAPI_OP_DELETE:
					$this->_Handle_Delete();
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

		//
		// Add kAPI_OP_GET_ONE.
		//
		$theList[ kAPI_OP_GET_ONE ]
			= 'Query: returns the first element that matches the provided query.';

		//
		// Add kAPI_OP_INSERT.
		//
		$theList[ kAPI_OP_INSERT ]
			= 'New user: inserts the provided user into the provided database';
	
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
		// Handle distinct values.
		//
		if( array_key_exists( kAPI_DISTINCT, $_REQUEST ) )
			$this->_HandleQuery( $_REQUEST[ kAPI_DISTINCT ], TRUE );
		
		//
		// Handle query count.
		//
		else
			$this->_HandleQuery( NULL, TRUE );
	
	} // _Handle_Count.

	 
	/*===================================================================================
	 *	_Handle_Get																		*
	 *==================================================================================*/

	/**
	 * Handle {@link kAPI_OP_GET} request.
	 *
	 * This method will handle the {@link kAPI_OP_GET} operation, which returns the
	 * records that match the provided query.
	 *
	 * @access protected
	 */
	protected function _Handle_Get()
	{
		//
		// Handle distinct values.
		//
		if( array_key_exists( kAPI_DISTINCT, $_REQUEST ) )
			$cursor = $this->_HandleQuery( $_REQUEST[ kAPI_DISTINCT ] );
		
		//
		// Handle query count.
		//
		else
			$cursor = $this->_HandleQuery();
		
		//
		// Handle result.
		//
		if( $cursor !== NULL )
		{
			//
			// Handle distinct values list (not object).
			//
			if( is_array( $cursor ) )
			{
				//
				// Set result.
				//
				if( count( $cursor ) )
				{
					//
					// Serialise values.
					//
					CDataType::SerialiseObject( $cursor );
					
					//
					// Set result.
					//
					$this->offsetSet( kAPI_RESPONSE, $cursor );
				
				} // Matched.
			
			} // Distinct values list.
			
			//
			// Handle cursor.
			//
			elseif( $cursor->count( FALSE ) )
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
					$results[] = $object;
			
				} // Iterating found objects
			
				//
				// Set response.
				//
				$this->offsetSet( kAPI_RESPONSE, $results );
			
			} // Cursor with matched elements.
		
		} // Has a result.
	
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
		// Make query, get affected and page counts.
		//
		$cursor = $this->_HandleQuery( TRUE );
		
		//
		// Handle result.
		//
		if( $cursor !== NULL )
		{
			//
			// Serialise object.
			//
			CDataType::SerialiseObject( $cursor );
			
			//
			// Save object in response.
			//
			$this->offsetSet( kAPI_RESPONSE, $cursor );
		
		} // Has a result.
	
	} // _Handle_GetOne.

	 
	/*===================================================================================
	 *	_Handle_Resolve																	*
	 *==================================================================================*/

	/**
	 * Handle {@link kAPI_OP_RESOLVE} request.
	 *
	 * This method will handle the {@link kAPI_OP_RESOLVE} operation, which resolves an
	 * object provided a reference value.
	 *
	 * @access protected
	 */
	protected function _Handle_Resolve()
	{
		//
		// Handle found.
		//
		if( $_REQUEST[ kAPI_OBJECT ] instanceof CPersistentObject )
		{
			//
			// Set affected count.
			//
			$this->_OffsetManage( kAPI_STATUS, kAPI_AFFECTED_COUNT, 1 );
			
			//
			// Save object in response.
			//
			$this->offsetSet( kAPI_RESPONSE, $_REQUEST[ kAPI_OBJECT ] );
		
		} // Found.
		
		//
		// Handle not found.
		//
		else
			$this->_OffsetManage( kAPI_STATUS, kAPI_AFFECTED_COUNT, 0 );
	
	} // _Handle_Resolve.

	 
	/*===================================================================================
	 *	_Handle_Insert																	*
	 *==================================================================================*/

	/**
	 * Handle {@link kAPI_OP_INSERT} request.
	 *
	 * This method will handle the {@link kAPI_OP_INSERT} operation, which inserts the
	 * provided object as an instance of the provided class into the provided database or
	 * container.
	 *
	 * This service works in two different modes:
	 *
	 * <ul>
	 *	<li><i>{@link kAPI_CLASS} provided</i>: In this case we let the object handle the
	 *		operation, which will trigger all automatic procedures for that specific class.
	 *	<li><i>{@link kAPI_CLASS} not provided</i>: In this case we simply add the provided
	 *		document to the provided container as-is.
	 * </ul>
	 *
	 * @access protected
	 */
	protected function _Handle_Insert()
	{
		//
		// Handle object.
		//
		if( $_REQUEST[ kAPI_OBJECT ] instanceof CPersistentObject )
			$identifier = ( array_key_exists( kAPI_CONTAINER, $_REQUEST ) )
						? $_REQUEST[ kAPI_OBJECT ]->Insert( $_REQUEST[ kAPI_CONTAINER ] )
						: $_REQUEST[ kAPI_OBJECT ]->Insert( $_REQUEST[ kAPI_DATABASE ] );
		
		//
		// Handle document.
		//
		else
			$identifier
				= $_REQUEST[ kAPI_CONTAINER ]
					->ManageObject(
						$_REQUEST[ kAPI_OBJECT ], NULL, kFLAG_PERSIST_INSERT );
		
		//
		// Serialise object.
		//
		CDataType::SerialiseObject( $identifier );
		
		//
		// Set object identifier.
		//
		$this->_OffsetManage( kAPI_STATUS, kTERM_STATUS_IDENTIFIER, $identifier );
	
	} // _Handle_Insert.

	 
	/*===================================================================================
	 *	_Handle_Modify																	*
	 *==================================================================================*/

	/**
	 * Handle {@link kAPI_OP_MODIFY} request.
	 *
	 * This method will handle the {@link kAPI_OP_MODIFY} operation, which modifies the
	 * attributes of the selection made by the provided query.
	 *
	 * The service returns either a zero status or an error if any of the modifications
	 * failed; all the modifications up to the failing one are valid.
	 *
	 * @access protected
	 */
	protected function _Handle_Modify()
	{
		//
		// Iterate modification attributes.
		//
		foreach( $_REQUEST[ kAPI_CRITERIA ] as $attribute => $criteria )
		{
			//
			// Iterate modification criteria.
			//
			foreach( $criteria as $operator => $value )
			{
				//
				// Set modification flags.
				//
				switch( $operator )
				{
					case kAPI_MODIFY_REPLACE:
						$flags = kFLAG_PERSIST_MODIFY;
						break;

					case kAPI_MODIFY_INCREMENT:
						$flags = kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_INCREMENT;
						break;

					case kAPI_MODIFY_APPEND:
						$flags = kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_APPEND;
						break;

					case kAPI_MODIFY_ADDSET:
						$flags = kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_ADDSET;
						break;

					case kAPI_MODIFY_POP:
						$flags = kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_POP;
						break;

					case kAPI_MODIFY_PULL:
						$flags = kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_PULL;
						break;
				}
				
				//
				// Perform modification.
				//
				$object = array( $attribute => $value );
				$status
					= $_REQUEST[ kAPI_CONTAINER ]
						->ManageObject( $object, $_REQUEST[ kAPI_QUERY ], $flags );
			
			} // Iterating criteria.
		
		} // Iterating attributes.
	
	} // _Handle_Modify.

	 
	/*===================================================================================
	 *	_Handle_Delete																	*
	 *==================================================================================*/

	/**
	 * Handle {@link kAPI_OP_DELETE} request.
	 *
	 * This method will handle the {@link kAPI_OP_DELETE} operation, which deletes objects
	 * matching the provided query or value.
	 *
	 * @access protected
	 */
	protected function _Handle_Delete()
	{
		//
		// Handle object delete.
		//
		if( array_key_exists( kAPI_OBJECT, $_REQUEST ) )
		{
			//
			// Perform delete.
			//
			if( $_REQUEST[ kAPI_OBJECT ] instanceof CPersistentObject )
				$status = ( array_key_exists( kAPI_CONTAINER, $_REQUEST ) )
						? $_REQUEST[ kAPI_OBJECT ]->Delete( $_REQUEST[ kAPI_CONTAINER ] )
						: $_REQUEST[ kAPI_OBJECT ]->Delete( $_REQUEST[ kAPI_DATABASE ] );
			else
				$status = FALSE;
			
			//
			// Set result.
			//
			$count = ( $status )
				   ? 1
				   : 0;
		
		} // Provided matching value.
		
		//
		// Handle selection delete.
		//
		else
		{
			//
			// Handle query.
			//
			$query = ( array_key_exists( kAPI_QUERY, $_REQUEST ) )
					? $_REQUEST[ kAPI_QUERY ]
					: NULL;
		
			//
			// Query.
			//
			$count
				= $_REQUEST[ kAPI_CONTAINER ]
					->Remove( $query );
			if( $count === NULL )
				$count = 0;
		
		} // Provided matching query.
	
		//
		// Set affected count.
		//
		$this->_OffsetManage( kAPI_STATUS, kAPI_AFFECTED_COUNT, $count );
	
	} // _Handle_Delete.

		

/*=======================================================================================
 *																						*
 *									PROTECTED UTILITIES									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_HandleQuery																	*
	 *==================================================================================*/

	/**
	 * Perform the current query.
	 *
	 * This method will execute the query provided in {@link kAPI_QUERY}, selecting the
	 * fields provided in {@link kAPI_SELECT}, sorted by the fields provided in
	 * {@link kAPI_SORT}, starting at the page provided in {@link kAPI_PAGE_START}, counting
	 * the number of records provided in {@link kAPI_PAGE_LIMIT}.
	 *
	 * The method expects two parameters:
	 *
	 * <ul>
	 *	<li><tt>$theResult</tt>: This parameter indicates the kind of query, it can take the
	 *		following values:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Return the selection cursor (default).
	 *		<li><tt>TRUE</tt>: Return first matched record or <tt>NULL</tt> if there were
	 *			no matches.
	 *		<li><i>other</i>: Any other value will be interpreted as a field identifier: in
	 *			this case the method will return an array containing the distinct values of
	 *			the provided field identifier.
	 *	 </ul>
	 *	<li><tt>$isCount</tt>: This boolean parameter indicates whether or not the query is
	 *		intended for a count operation: <tt>TRUE</tt> means that the method will not
	 *		return any result, except for the count information in the response parameters.
	 *	<li><tt>$doCount</tt>: This boolean parameter indicates whether or not the query
	 *		should update the count and paging values of the request, if the parameter is
	 *		<tt>TRUE</tt>, the default value, the query is considered as the final operation
	 *		and all count and paging parameters will be updated accordingly; if the
	 *		parameter is <tt>FALSE</tt>, the method will only perform the query and return
	 *		the result.
	 * </ul>
	 *
	 * The method will traverse query lists until a match is found and it expects the
	 * {@link kAPI_DATABASE} parameter to be set.
	 *
	 * @param mixed					$theResult			Result type.
	 * @param boolean				$isCount			COUNT result.
	 * @param boolean				$doCount			Do paging counters.
	 *
	 * @access protected
	 * @return mixed
	 */
	protected function _HandleQuery( $theResult = NULL, $isCount = FALSE, $doCount = TRUE )
	{
		//
		// Handle query.
		//
		$query = ( array_key_exists( kAPI_QUERY, $_REQUEST ) )
				? $_REQUEST[ kAPI_QUERY ]
				: NULL;
		
		//
		// Handle fields.
		//
		$fields = ( array_key_exists( kAPI_SELECT, $_REQUEST ) )
				? $_REQUEST[ kAPI_SELECT ]
				: NULL;
		
		//
		// Handle sort.
		//
		$sort = ( array_key_exists( kAPI_SORT, $_REQUEST ) )
			  ? $_REQUEST[ kAPI_SORT ]
			  : NULL;
		
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
		// Assume query list.
		// A scalar query is either a CQuery derived object or NULL.
		//
		$match = FALSE;
		if( ! is_array( $query ) )
			$query = array( $query );
		else
			$match = TRUE;
		
		//
		// Iterate query list.
		//
		foreach( $query as $key => $value )
		{
			//
			// Set container.
			//
			$container = ( is_int( $key ) )
					   ? $_REQUEST[ kAPI_CONTAINER ]
					   : $_REQUEST[ kAPI_DATABASE ]->Container( $key );
			
			//
			// Perform query.
			//
			$result
				= $_REQUEST[ kAPI_CONTAINER ]
					->Query( $value, $fields, $sort, $start, $limit, $theResult );
		
			//
			// Handle GET.
			//
			if( ($theResult === NULL)
			 && $result->count( FALSE ) )
			{
				//
				// Return matched query index.
				//
				if( $match )
					$this->_OffsetManage( kAPI_STATUS, kAPI_QUERY_MATCH, $key );
			
				break;														// =>
			
			} // Matched query.
			
			//
			// Handle GET-ONE.
			//
			elseif( ($theResult === TRUE)
				 && ($result !== NULL) )
			{
				//
				// Return matched query index.
				//
				if( $match )
					$this->_OffsetManage( kAPI_STATUS, kAPI_QUERY_MATCH, $key );
			
				break;														// =>
			
			} // Matched query.
			
			//
			// Handle distinct keys list.
			//
			elseif( is_array( $theResult ) )
			{
				//
				// Iterate results.
				//
				$matched = FALSE;
				foreach( $result as $item )
				{
					//
					// Handle non-empty.
					//
					if( count( $item ) )
					{
						//
						// Return matched query index.
						//
						if( $match )
							$this->_OffsetManage( kAPI_STATUS, kAPI_QUERY_MATCH, $key );
						
						//
						// Set flag.
						//
						$matched = TRUE;
			
						break;												// =>
					
					} // Matched query.
				
				} // Iterating distinct value keys.
				
				//
				// Exit loop.
				//
				if( $matched )
					break;													// =>
			
			} // Distinct value keys.
			
			//
			// Handle distinct key values.
			//
			elseif( ($theResult !== NULL)
				 && ($theResult !== TRUE)
				 && (! is_array( $theResult ))
				 && count( $result ) )
			{
				//
				// Return matched query index.
				//
				if( $match )
					$this->_OffsetManage( kAPI_STATUS, kAPI_QUERY_MATCH, $key );
			
				break;														// =>
			
			} // Distinct value key.
		
		} // Iterating queries.
		
		//
		// Handle cursor.
		//
		if( $theResult === NULL )
		{
			//
			// Handle counts.
			//
			if( $doCount )
			{
				//
				// Set effective count.
				//
				$this->_OffsetManage(
					kAPI_STATUS, kAPI_AFFECTED_COUNT, $result->count( FALSE ) );
			
				//
				// Set page count.
				//
				if( $this->offsetExists( kAPI_PAGING ) )
				{
					$tmp = $this->offsetGet( kAPI_PAGING );
					$tmp[ kAPI_PAGE_COUNT ] = $result->count( TRUE );
					$this->offsetSet( kAPI_PAGING, $tmp );
				}
			
			} // Final operation.
			
			//
			// Handle count.
			//
			if( $isCount )
				return $result->count( FALSE );										// ==>
		
		} // Received cursor.
		
		//
		// Handle object or values list.
		//
		else
		{
			//
			// Get count.
			//
			if( $theResult === TRUE )
				$count = (int) ( $result !== NULL );
			elseif( $theResult === NULL )
			{
				$count = Array();
				foreach( $result as $key => $value )
					$count[ $key ] = count( $value );
			}
			elseif( is_array( $theResult ) )
			{
				$count = Array();
				foreach( $result as $distinct => $value )
					$count[ $distinct ] = count( $value );
			}
			else
				$count = count( $result );
			
			//
			// Set effective count.
			//
			if( $doCount )
				$this->_OffsetManage( kAPI_STATUS, kAPI_AFFECTED_COUNT, $count );
			
			//
			// Handle single object.
			//
			if( $theResult === TRUE )
			{
				//
				// Set paging.
				//
				if( $doCount )
				{
					if( $this->offsetExists( kAPI_PAGING ) )
					{
						$tmp = $this->offsetGet( kAPI_PAGING );
						$tmp[ kAPI_PAGE_COUNT ] = $count;
						$this->offsetSet( kAPI_PAGING, $tmp );
					}
				}
			}
			
			//
			// Handle distinct.
			//
			else
			{
				//
				// Handle distinct keys.
				//
				if( ! is_array( $theResult ) )
				{
					//
					// Slice results.
					//
					$result = array_slice( $result, $start, $limit );
			
					//
					// Set page count.
					//
					if( $doCount )
					{
						if( $this->offsetExists( kAPI_PAGING ) )
						{
							$tmp = $this->offsetGet( kAPI_PAGING );
							$tmp[ kAPI_PAGE_COUNT ] = count( $result );
							$this->offsetSet( kAPI_PAGING, $tmp );
						}
					}
				
				} // Distinct values.
				
				//
				// Handle distinct values.
				//
				else
				{
					//
					// Iterate results.
					//
					foreach( array_keys( $result ) as $key )
					{
						//
						// Slice results.
						//
						$result[ $key ] = array_slice( $result[ $key ], $start, $limit );
			
						//
						// Set page count.
						//
						$count[ $key ] = count( $result[ $key ] );
					
					} // Iterating results.
			
					//
					// Set page count.
					//
					if( $doCount )
					{
						if( $this->offsetExists( kAPI_PAGING ) )
						{
							$tmp = $this->offsetGet( kAPI_PAGING );
							$tmp[ kAPI_PAGE_COUNT ] = $count;
							$this->offsetSet( kAPI_PAGING, $tmp );
						}
					}
				
				} // Distinct keys.
			
			} // Distinct.
			
			//
			// Handle count.
			//
			if( $isCount )
				return $count;														// ==>
		
		} // Not a cursor.
		
		return $result;																// ==>
	
	} // _HandleQuery.

	 
	/*===================================================================================
	 *	_ValidateQueries																*
	 *==================================================================================*/

	/**
	 * Validate query parameters.
	 *
	 * The duty of this method is to verify the provided query and to convert it into a
	 * native query object. The provided query may be of three kinds:
	 *
	 * <ul>
	 *	<li><i>Scalar query</i>: A single query.
	 *	<li><i>Query list</i>: A list of queries.
	 *	<li><i>Container query list</i>: A list of queries each using a different container.
	 * </ul>
	 *
	 * The method will traverse the provided structure until it finds a single query with
	 * which it will perform the following steps:
	 *
	 * <ul>
	 *	<li><i>Instantiate query</i>: The query will be instantiated as a native
	 *		{@link CQuery} derived instance.
	 *	<li><i>Validate query</i>: The structural integrity of the query will be validated
	 *		({@link CQuery::Validate()).
	 *	<li><i>Unserialise query</i>: All data elements in the query which need to be
	 *		converted to the native container format will be unserialised.
	 * </ul>
	 *
	 * Depending on the query kind, the method expects the following service parameters to
	 * be provided:
	 *
	 * <ul>
	 *	<li><i>Scalar query</i>: The {@link kAPI_CONTAINER} must be set.
	 *	<li><i>Query list</i>: The {@link kAPI_CONTAINER} must be set.
	 *	<li><i>Container query list</i>: The {@link kAPI_DATABASE} must be set.
	 * </ul>
	 *
	 * @param reference			   &$theQuery			Query structure.
	 *
	 * @access protected
	 *
	 * @see kAPI_QUERY
	 */
	protected function _ValidateQueries( &$theQuery )
	{
		//
		// Check query type.
		//
		if( is_array( $theQuery ) )
		{
			//
			// Reset array pointers.
			//
			reset( $theQuery );
			
			//
			// Handle scalar query.
			//
			$key = (string) key( $theQuery );
			$ops = array( kOPERATOR_OR, kOPERATOR_NOR, kOPERATOR_AND, kOPERATOR_NAND );
			if( in_array( $key, $ops ) )
			{
				//
				// Check container.
				// If there it should already be a CContainer instance.
				//
				if( array_key_exists( kAPI_CONTAINER, $_REQUEST ) )
					$this->_VerifyQuery( $theQuery, $_REQUEST[ kAPI_CONTAINER ] );
				
				else
					throw new CException
						( "Unable to format query: missing container",
						  kERROR_MISSING,
						  kSTATUS_ERROR );										// !@! ==>
			
			} // Scalar query.
			
			//
			// Handle query lists.
			//
			else
			{
				//
				// Iterate queries.
				//
				$keys = array_keys( $theQuery );
				foreach( $keys as $key )
				{
					//
					// Handle query.
					//
					if( is_integer( $key ) )
						$this->_ValidateQueries( $theQuery[ $key ] );
					
					//
					// Handle container query.
					//
					else
					{
						//
						// Check database.
						// If there it should already be a CDatabase instance.
						//
						if( array_key_exists( kAPI_DATABASE, $_REQUEST ) )
							$this->_VerifyQuery(
								$theQuery[ $key ],
								$_REQUEST[ kAPI_DATABASE ]->Container( $key ) );
				
						else
							throw new CException
								( "Unable to format query: missing database",
								  kERROR_MISSING,
								  kSTATUS_ERROR );								// !@! ==>
					
					} // Container query.
				
				} // Iterating queries.
			
			} // Queries list.
		
		} // Query is an array.
		
		else
			throw new CException
				( "Unable to format query: invalid query data type",
				  kERROR_PARAMETER,
				  kSTATUS_ERROR,
				  array( 'Type' => gettype( $theQuery ) ) );		// !@! ==>
	
	} // _ValidateQueries.

	 
	/*===================================================================================
	 *	_VerifyQuery																	*
	 *==================================================================================*/

	/**
	 * Check and verify query.
	 *
	 * This method can ve used to verify a query, it expects the provided query parameter
	 * to be a single query and it will perform the following actions on it:
	 *
	 * <ul>
	 *	<li><i>Instantiate query</i>: The provided array query will be instantiated as a
	 *		native {@link CQuery} derived instance ({@link CContainer::NewQuery()}).
	 *	<li><i>Validate query</i>: The structural integrity of the query will be validated
	 *		({@link CQuery::Validate()).
	 *	<li><i>Unserialise query</i>: All data elements in the query which need to be
	 *		converted to the native container format will be unserialised
	 *		({@link CContainer::UnserialiseObject()}).
	 * </ul>
	 *
	 * @param reference			   &$theQuery			Query structure.
	 * @param CContainer			$theContainer		Container object.
	 *
	 * @access protected
	 */
	protected function _VerifyQuery( &$theQuery, CContainer $theContainer )
	{
		//
		// Skip if already converted.
		//
		if( ! ($theQuery instanceof CQuery) )
		{
			//
			// Handle arrays.
			//
			if( is_array( $theQuery ) )
			{
				//
				// Convert to query.
				//
				$theQuery = $theContainer->NewQuery( $theQuery );
				
				//
				// Validate query.
				//
				$theQuery->Validate();
			
				//
				// Unserialise custom data types.
				//
				$theContainer->UnserialiseObject( $theQuery );
			
			} // Is array.
		
		} // Not yet a query.
	
	} // _VerifyQuery.

	 

} // class CDataWrapper.


?>

<?php

/**
 * <i>CMongoDataWrapper</i> class definition.
 *
 * This file contains the class definition of <b>CMongoDataWrapper</b> which overloads its
 * ancestor to implement a Mongo based data store wrapper.
 *
 *	@package	MyWrapper
 *	@subpackage	Wrappers
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 07/11/2011
 */

/*=======================================================================================
 *																						*
 *									CMongoDataWrapper.php								*
 *																						*
 *======================================================================================*/

/**
 * Ancestor.
 *
 * This include file contains the parent class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CDataWrapper.php" );

/**
 * Queries.
 *
 * This include file contains the query class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CMongoQuery.php" );

/**
 *	Mongo data wrapper.
 *
 * This class overloads its ancestor by implementing a Mongo based wrapper, it does so by
 * instantiating Mongo specific resources which comply to the framework implemented in the
 * parent class.
 *
 *	@package	MyWrapper
 *	@subpackage	Wrappers
 */
class CMongoDataWrapper extends CDataWrapper
{
		

/*=======================================================================================
 *																						*
 *							PROTECTED INITIALISATION INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_InitResources																	*
	 *==================================================================================*/

	/**
	 * Initialise resources.
	 *
	 * In this class we initialise the server object by instantiating a {@link CMongoServer}
	 * object, this means that databases will be {@link CMongoDatabase} instances and
	 * containers {@link CMongoConatiner} instances.
	 *
	 * @access protected
	 *
	 * @see kAPI_SERVER
	 */
	protected function _InitResources()
	{
		//
		// Instantiate server.
		//
		$_REQUEST[ kAPI_SERVER ] = new CMongoServer( kDEFAULT_SERVER );
	
	} // _InitResources.

		

/*=======================================================================================
 *																						*
 *							PROTECTED VALIDATION UTILITIES								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_ValidateDatabase																*
	 *==================================================================================*/

	/**
	 * Validate database.
	 *
	 * In this class we override the inherited method to assert {@link CMongoDatabase}.
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
			if( ! ($_REQUEST[ kAPI_DATABASE ] instanceof CMongoDatabase) )
				throw new CException
					( "Invalid database type: expecting an instance of CMongoDatabase",
					  kERROR_STATE,
					  kMESSAGE_TYPE_ERROR );									// !@! ==>
		
		} // Provided database.
	
	} // _FormatDatabase.

	 
	/*===================================================================================
	 *	_ValidateContainer																*
	 *==================================================================================*/

	/**
	 * Validate container.
	 *
	 * In this class we override the inherited method to assert {@link CMongoContainer}.
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
			if( ! ($_REQUEST[ kAPI_CONTAINER ] instanceof CMongoContainer) )
				throw new CException
					( "Invalid container type: expecting an instance of CMongoContainer",
					  kERROR_STATE,
					  kMESSAGE_TYPE_ERROR );									// !@! ==>
		
		} // Provided container.
	
	} // _ValidateContainer.

	 
	/*===================================================================================
	 *	_ValidateQuery																	*
	 *==================================================================================*/

	/**
	 * Validate query parameters.
	 *
	 * In this class we convert the validated query into the custom Mongo format.
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
			// Validate query object.
			//
			parent::_ValidateQuery();
			
			//
			// Check if still there.
			//
			if( array_key_exists( kAPI_QUERY, $_REQUEST ) )
			{
				//
				// Convert to Mongo query.
				//
				$_REQUEST[ kAPI_QUERY ]
					= $_REQUEST[ kAPI_QUERY ]
						->Export( $_REQUEST[ kAPI_CONTAINER ] );
			
			} // Query parameters not empty.
		
		} // Provided query parameters.
	
	} // _ValidateQuery.

	 
	/*===================================================================================
	 *	_ValidateSort																	*
	 *==================================================================================*/

	/**
	 * Validate selection parameters.
	 *
	 * In this class we call the parent method, if there is stil a parameter we convert the
	 * array to meet Mongo query standards: we scan all elements of the list and set
	 * negative values to <tt>-1</tt>, positive values to <tt>1</tt> and all non integer
	 * values to <tt>1</tt>.
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
			// Validate parameter.
			//
			parent::_ValidateSort();
			
			//
			// Check if still there.
			//
			if( array_key_exists( kAPI_SORT, $_REQUEST ) )
			{
				//
				// Iterate parameter.
				//
				$keys = array_keys( $_REQUEST[ kAPI_SORT ] );
				foreach( $keys as $key )
				{
					//
					// Normalise sense indicator.
					//
					if( is_numeric( $_REQUEST[ kAPI_SORT ][ $key ] ) )
					{
						if( $_REQUEST[ kAPI_SORT ][ $key ] > 0 )
							$_REQUEST[ kAPI_SORT ][ $key ] = 1;
						elseif( $_REQUEST[ kAPI_SORT ][ $key ] < 0 )
							$_REQUEST[ kAPI_SORT ][ $key ] = -1;
						else
							$_REQUEST[ kAPI_SORT ][ $key ] = 1;
					}
					else
						$_REQUEST[ kAPI_SORT ][ $key ] = 1;
				}
			
			} // Query sort selection not empty.
		
		} // Provided query sort selection.
	
	} // _ValidateSort.

		

/*=======================================================================================
 *																						*
 *								PROTECTED HANDLER INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_Handle_Count																	*
	 *==================================================================================*/

	/**
	 * Handle {@link kAPI_OP_COUNT} request.
	 *
	 * This method will perform the query and return the count in the
	 * {@link kAPI_AFFECTED_COUNT} status field.
	 *
	 * @access protected
	 */
	protected function _Handle_Count()
	{
		//
		// Query.
		//
		$cursor = ( array_key_exists( kAPI_QUERY, $_REQUEST ) )
				? $_REQUEST[ kAPI_CONTAINER ]->Connection()->find( $_REQUEST[ kAPI_QUERY ] )
				: $_REQUEST[ kAPI_CONTAINER ]->Connection()->find();
		
		//
		// Return count.
		//
		$this->_OffsetManage( kAPI_STATUS, kAPI_AFFECTED_COUNT, $cursor->count( FALSE ) );
	
	} // _Handle_Count.

	 
	/*===================================================================================
	 *	_Handle_Query																	*
	 *==================================================================================*/

	/**
	 * Handle {@link kAPI_OP_QUERY} request.
	 *
	 * This method will perform the query and return the elements that match the selection
	 * criteria.
	 *
	 * @access protected
	 */
	protected function _Handle_Query()
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
		// Get cursor.
		//
		$cursor = $_REQUEST[ kAPI_CONTAINER ]->Connection()->find( $query, $fields );
		
		//
		// Set total count.
		//
		$count = $cursor->count( FALSE );
		$this->_OffsetManage( kAPI_STATUS, kAPI_AFFECTED_COUNT, $count );
		
		//
		// Check count.
		//
		if( $count )
		{
			//
			// Sort results.
			//
			if( $sort )
				$cursor->sort( $sort );
			
			//
			// Set paging.
			//
			if( $this->offsetExists( kAPI_PAGING ) )
			{
				//
				// Set paging.
				//
				$paging = $this->offsetGet( kAPI_PAGING );
				$start = ( array_key_exists( kAPI_PAGE_START, $paging ) )
					   ? (int) $paging[ kAPI_PAGE_START ]
					   : 0;
				$limit = ( array_key_exists( kAPI_PAGE_LIMIT, $paging ) )
					   ? (int) $paging[ kAPI_PAGE_LIMIT ]
					   : 0;
				
				//
				// Position at start.
				//
				if( $start )
					$cursor->skip( $start );
				
				//
				// Set limit.
				//
				if( $limit )
					$cursor->limit( $limit );
				
				//
				// Set page count.
				//
				$pcount = $cursor->count( TRUE );
				
				//
				// Update actual count.
				//
				$this->_OffsetManage( kAPI_PAGING, kAPI_PAGE_COUNT, $pcount );
			
			} // Provided paging options.
			
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
	
	} // _Handle_Query.

	 

} // class CMongoDataWrapper.


?>

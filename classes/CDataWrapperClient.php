<?php

/**
 * <i>CDataWrapperClient</i> class definition.
 *
 * This file contains the class definition of <b>CDataWrapperClient</b> which represents a
 * web-service data wrapper client.
 *
 *	@package	MyWrapper
 *	@subpackage	Wrappers
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 31/03/2012
 */

/*=======================================================================================
 *																						*
 *								CDataWrapperClient.php									*
 *																						*
 *======================================================================================*/

/**
 * Ancestor.
 *
 * This include file contains the parent class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CWrapperClient.php" );

/**
 * Server definitions.
 *
 * This include file contains all definitions of the server object.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CDataWrapper.php" );

/**
 * <h4>Wrapper client</h4>
 *
 * This class represents a web-services wrapper client, it facilitates the job of requesting
 * information from servers derived from the {@link CDataWrapper} class.
 *
 * This class supports the following properties:
 *
 * <ul>
 *	<li><i>{@link Database()}</i>: This element represents the web-service database name,
 *		it is stored in the in the {@link kAPI_DATABASE} offset.
 *	<li><i>{@link Container()}</i>: This element represents the web-service container name,
 *		it is stored in the {@link kAPI_CONTAINER} offset.
 *	<li><i>{@link PageStart()}</i>: This element represents the web-service page start, it
 *		is stored in the {@link kAPI_PAGE_START} offset.
 *	<li><i>{@link PageLimit()}</i>: This element represents the web-service page limit, it
 *		is stored in the {@link kAPI_PAGE_LIMIT} offset.
 *	<li><i>{@link Query()}</i>: This element represents the web-service query, it is stored
 *		in the {@link kAPI_QUERY} offset.
 *	<li><i>{@link Select()}</i>: This element represents the web-service select fields, it
 *		is stored in the {@link kAPI_SELECT} offset.
 *	<li><i>{@link Sort()}</i>: This element represents the web-service sort fields, it
 *		is stored in the {@link kAPI_SORT} offset.
 * </ul>
 *
 * The class recognises the following operations ({@link Operation()}):
 *
 * <ul>
 *	<li><tt>{@link kAPI_OP_COUNT}</tt>: This service returns the total number of elements
 *		affected by the provided query. The service expects the following parameters:
 *	 <ul>
 *		<li><tt>{@link Format()}</tt>: The data encoding type ({@link kAPI_FORMAT}).
 *		<li><tt>{@link Database()}</tt>: The data encoding type ({@link kAPI_DATABASE}).
 *		<li><tt>{@link Container()}</tt>: The data encoding type ({@link kAPI_CONTAINER}).
 *		<li><tt>{@link Query()}</tt>: The query ({@link kAPI_QUERY}).
 *			<i>If this parameter is omitted, it is assumed that the operation will involve
 *			all container elements</i>.
 *	 </ul>
 *	<li><tt>{@link kAPI_OP_GET}</tt>: This service returns the elements that match the
 *		provided query. The service expects the following parameters:
 *	 <ul>
 *		<li><tt>{@link Format()}</tt>: The data encoding type ({@link kAPI_FORMAT}).
 *		<li><tt>{@link Database()}</tt>: The data encoding type ({@link kAPI_DATABASE}).
 *		<li><tt>{@link Container()}</tt>: The data encoding type ({@link kAPI_CONTAINER}).
 *		<li><tt>{@link Query()}</tt>: The query ({@link kAPI_QUERY}).
 *			<i>If this parameter is omitted, it is assumed that the operation will involve
 *			all container elements</i>.
 *		<li><tt>{@link Select()}</tt>: The list of requested attributes
 *			({@link kAPI_SELECT}). <i>If this parameter is omitted, it is assumed that all
 *			attributes are returned</i>.
 *		<li><tt>{@link Sort()}</tt>: The list of requested sort attributes
 *			({@link kAPI_SORT}). <i>If this parameter is omitted, it is assumed that the
 *			elements are returned in the order they were found</i>.
 *		<li><tt>{@link PageLimit()}</tt>: The maximum number of elements to be returned
 *			({@link kAPI_PAGE_LIMIT}). <i>If this parameter is not provided, the service
 *			will enforce the {@link kDEFAULT_LIMIT} value.
 *	 </ul>
 *	<li><tt>{@link kAPI_OP_GET_ONE}</tt>: This service returns the first element that matches
 *		the provided query. The service expects the following parameters:
 *	 <ul>
 *		<li><tt>{@link Format()}</tt>: The data encoding type ({@link kAPI_FORMAT}).
 *		<li><tt>{@link Database()}</tt>: The data encoding type ({@link kAPI_DATABASE}).
 *		<li><tt>{@link Container()}</tt>: The data encoding type ({@link kAPI_CONTAINER}).
 *		<li><tt>{@link Query()}</tt>: The query ({@link kAPI_QUERY}).
 *			<i>If this parameter is omitted, it is assumed that the operation will involve
 *			all container elements</i>.
 *		<li><tt>{@link Select()}</tt>: The list of requested attributes
 *			({@link kAPI_SELECT}). <i>If this parameter is omitted, it is assumed that all
 *			attributes are returned</i>.
 *	 </ul>
 *	<li><tt>{@link kAPI_OP_MATCH}</tt>: This service returns the first element that matches
 *		the provided list of queries. The service expects the following parameters:
 *	 <ul>
 *		<li><tt>{@link Format()}</tt>: The data encoding type ({@link kAPI_FORMAT}).
 *		<li><tt>{@link Database()}</tt>: The data encoding type ({@link kAPI_DATABASE}).
 *		<li><tt>{@link Container()}</tt>: The data encoding type ({@link kAPI_CONTAINER}).
 *		<li><tt>{@link Query()}</tt>: The query ({@link kAPI_QUERY}).
 *			<i>If this parameter is omitted, it is assumed that the operation will involve
 *			all container elements</i>.
 *		<li><tt>{@link Select()}</tt>: The list of requested attributes
 *			({@link kAPI_SELECT}). <i>If this parameter is omitted, it is assumed that all
 *			attributes are returned</i>.
 *	 </ul>
 * </ul>
 *
 *	@package	MyWrapper
 *	@subpackage	Wrappers
 */
class CDataWrapperClient extends CWrapperClient
{
		

/*=======================================================================================
 *																						*
 *								PUBLIC MEMBER INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Operation																		*
	 *==================================================================================*/

	/**
	 * Manage operation.
	 *
	 * We {@link CWrapperClient::Operation() overload} this method to add the following
	 * allowed operations:
	 *
	 * <ul>
	 *	<li><i>{@link kAPI_OP_COUNT}</i>: COUNT web-service operation, used to
	 *		return the total number of elements satisfying a query.
	 *	<li><i>{@link kAPI_OP_MATCH}</i>: This operation is equivalent to a
	 *		read query, except that it will try to match one {@link kAPI_DATA_QUERY query}
	 *		clause at the time and will return a result on the first match.
	 *	<li><i>{@link kAPI_OP_GET kAPI_OP_GET}</i>: GET web-service operation, used to
	 *		retrieve objects from the data store.
	 *	<li><i>{@link kAPI_OP_SET kAPI_OP_SET}</i>: SET web-service operation, used to
	 *		insert or update objects in the data store.
	 *	<li><i>{@link kAPI_OP_UPDATE kAPI_OP_UPDATE}</i>: UPDATE web-service operation, used
	 *		to update existing objects in the data store.
	 *	<li><i>{@link kAPI_OP_INSERT kAPI_OP_INSERT}</i>: INSERT web-service operation, used
	 *		to insert new objects in the data store.
	 *	<li><i>{@link kAPI_OP_BATCH_INSERT kAPI_OP_BATCH_INSERT}</i>: This service is
	 *		equivalent to the {@link kAPI_OP_INSERT kAPI_OP_INSERT} command, except that in
	 *		this case you provide a list ov objects to insert.
	 *	<li><i>{@link kAPI_OP_MODIFY kAPI_OP_MODIFY}</i>: MODIFY web-service operation, used
	 *		to modify partial contents of objects in the data store.
	 *	<li><i>{@link kAPI_OP_DEL kAPI_OP_DEL}</i>: DELETE web-service operation, used to
	 *		delete objects from the data store.
	 * </ul>
	 *
	 * @param string				$theValue			Value or operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access public
	 * @return mixed
	 *
	 * @throws {@link CException CException}
	 *
	 * @uses CAttribute::ManageOffset()
	 *
	 * @see kAPI_OPERATION
	 * @see kAPI_OP_HELP kAPI_OP_PING
	 */
	public function Operation( $theValue = NULL, $getOld = FALSE )
	{
		//
		// Check operation.
		//
		if( ($theValue !== NULL)
		 && ($theValue !== FALSE) )
		{
			switch( $theValue )
			{
				case kAPI_OP_COUNT:
				case kAPI_OP_GET:
				case kAPI_OP_GET_ONE:
				case kAPI_OP_MATCH:
					return ManageOffset(
						$this, kAPI_OPERATION, $theValue, $getOld );				// ==>
			}
		}
		
		return parent::Operation( $theValue, $getOld );								// ==>

	} // Operation.

	 
	/*===================================================================================
	 *	Database																		*
	 *==================================================================================*/

	/**
	 * Manage database name.
	 *
	 * This method can be used to manage the {@link kAPI_DATABASE} offset, it accepts a
	 * parameter which represents the database name or the requested operation, depending on
	 * its value:
	 *
	 * <ul>
	 *	<li><i>NULL</i>: Return the current value.
	 *	<li><i>FALSE</i>: Delete the current value.
	 *	<li><i>other</i>: Set the value with the provided parameter.
	 * </ul>
	 *
	 * The second parameter is a boolean which if <i>TRUE</i> will return the <i>old</i>
	 * value when replacing values; if <i>FALSE</i>, it will return the currently set value.
	 *
	 * @param string				$theValue			Value or operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access public
	 * @return mixed
	 *
	 * @uses ManageOffset()
	 *
	 * @see kAPI_DATABASE
	 */
	public function Database( $theValue = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kAPI_DATABASE, $theValue, $getOld );			// ==>

	} // Database.

	 
	/*===================================================================================
	 *	Container																		*
	 *==================================================================================*/

	/**
	 * Manage container name.
	 *
	 * This method can be used to manage the {@link kAPI_CONTAINER} offset, it accepts a
	 * parameter which represents the container name or the requested operation, depending on
	 * its value:
	 *
	 * <ul>
	 *	<li><i>NULL</i>: Return the current value.
	 *	<li><i>FALSE</i>: Delete the current value.
	 *	<li><i>other</i>: Set the value with the provided parameter.
	 * </ul>
	 *
	 * The second parameter is a boolean which if <i>TRUE</i> will return the <i>old</i>
	 * value when replacing values; if <i>FALSE</i>, it will return the currently set value.
	 *
	 * @param string				$theValue			Value or operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access public
	 * @return mixed
	 *
	 * @uses ManageOffset()
	 *
	 * @see kAPI_CONTAINER
	 */
	public function Container( $theValue = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kAPI_CONTAINER, $theValue, $getOld );			// ==>

	} // Container.

	 
	/*===================================================================================
	 *	PageStart																		*
	 *==================================================================================*/

	/**
	 * Manage page start.
	 *
	 * This method can be used to manage the {@link kAPI_PAGE_START} offset, it accepts a
	 * parameter which represents the starting page from which the service should return
	 * data, or the requested operation, depending on its value:
	 *
	 * <ul>
	 *	<li><i>NULL</i>: Return the current value.
	 *	<li><i>FALSE</i>: Delete the current value.
	 *	<li><i>other</i>: Set the value with the provided parameter, in this case the value
	 *		is expected to be and will be casted to an integer.
	 * </ul>
	 *
	 * The second parameter is a boolean which if <i>TRUE</i> will return the <i>old</i>
	 * value when replacing values; if <i>FALSE</i>, it will return the currently set value.
	 *
	 * @param string				$theValue			Value or operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access public
	 * @return mixed
	 *
	 * @uses ManageOffset()
	 *
	 * @see kAPI_PAGE_START
	 */
	public function PageStart( $theValue = NULL, $getOld = FALSE )
	{
		//
		// Check operation.
		//
		if( ($theValue !== NULL)
		 && ($theValue !== FALSE) )
			$theValue = (integer) $theValue;
		
		return ManageOffset( $this, kAPI_PAGE_START, $theValue, $getOld );			// ==>

	} // PageStart.

	 
	/*===================================================================================
	 *	PageLimit																		*
	 *==================================================================================*/

	/**
	 * Manage page limit.
	 *
	 * This method can be used to manage the {@link kAPI_PAGE_LIMIT} offset, it accepts a
	 * parameter which represents the maximum number of elements to be returned by the
	 * service, or the requested operation, depending on its value:
	 *
	 * <ul>
	 *	<li><i>NULL</i>: Return the current value.
	 *	<li><i>FALSE</i>: Delete the current value.
	 *	<li><i>other</i>: Set the value with the provided parameter, in this case the value
	 *		is expected to be and will be casted to an integer.
	 * </ul>
	 *
	 * The second parameter is a boolean which if <i>TRUE</i> will return the <i>old</i>
	 * value when replacing values; if <i>FALSE</i>, it will return the currently set value.
	 *
	 * @param string				$theValue			Value or operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access public
	 * @return mixed
	 *
	 * @uses ManageOffset()
	 *
	 * @see kAPI_PAGE_LIMIT
	 */
	public function PageLimit( $theValue = NULL, $getOld = FALSE )
	{
		//
		// Check operation.
		//
		if( ($theValue !== NULL)
		 && ($theValue !== FALSE) )
			$theValue = (integer) $theValue;
		
		return ManageOffset( $this, kAPI_PAGE_LIMIT, $theValue, $getOld );			// ==>

	} // PageLimit.

	 
	/*===================================================================================
	 *	Query																			*
	 *==================================================================================*/

	/**
	 * Manage query.
	 *
	 * This method can be used to manage the {@link kAPI_QUERY} offset, it accepts a
	 * parameter which represents the service requested query, or the requested operation,
	 * depending on its value:
	 *
	 * <ul>
	 *	<li><i>NULL</i>: Return the current value.
	 *	<li><i>FALSE</i>: Delete the current value.
	 *	<li><i>other</i>: Set the value with the provided parameter, in this case the value
	 *		is expected to be:
	 *	 <ul>
	 *		<li><tt>array</tt> or <tt>ArrayObject<tt>: The provided array will be cast to a
	 *			{@link CQuery} object and verified.
	 *		<li><tt>{@link CQuery}</tt>: The provided array will be verified.
	 *		<li><i>other</i>: The method will raise an exception.
	 *	 </ul>
	 * </ul>
	 *
	 * The second parameter is a boolean which if <i>TRUE</i> will return the <i>old</i>
	 * value when replacing values; if <i>FALSE</i>, it will return the currently set value.
	 *
	 * @param string				$theValue			Value or operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access public
	 * @return mixed
	 *
	 * @throws Exception
	 *
	 * @uses ManageOffset()
	 *
	 * @see kAPI_QUERY
	 */
	public function Query( $theValue = NULL, $getOld = FALSE )
	{
		//
		// Check operation.
		//
		if( ($theValue !== NULL)
		 && ($theValue !== FALSE) )
		{
			//
			// Parse by operation.
			//
			switch( $this->Operation() )
			{
				case kAPI_OP_MATCH:
					//
					// Cast to array.
					//
					if( $theValue instanceof ArrayObject )
						$theValue = $theValue->getArrayCopy();
					elseif( ! is_array( $theValue ) )
					{
						$type = ( is_object( $theValue ) )
							  ? get_class( $theValue )
							  : gettype( $theValue );
						throw new Exception( "Unsupported query list type [$type]",
											 kERROR_PARAMETER );				// !@! ==>
					}
					
					//
					// Cast to queries.
					//
					foreach( $theValue as $key => $query )
					{
						//
						// Cast to query.
						//
						if( ! ($query instanceof CQuery) )
						{
							if( is_array( $query ) )
								$query = new CQuery( $query );
							elseif( $query instanceof ArrayObject )
								$query = new CQuery( $query->getArrayCopy() );
							else
							{
								$type = ( is_object( $query ) )
									  ? get_class( $query )
									  : gettype( $query );
								throw new Exception( "Unsupported query type [$type]",
													 kERROR_PARAMETER );		// !@! ==>
							}
						}
						
						//
						// Update query.
						//
						$theValue[ $key ] = $query;
					}
					break;
				
				default:
					//
					// Cast to query.
					//
					if( ! ($theValue instanceof CQuery) )
					{
						if( is_array( $theValue ) )
							$theValue = new CQuery( $theValue );
						elseif( $theValue instanceof ArrayObject )
							$theValue = new CQuery( $theValue->getArrayCopy() );
						
						else
						{
							$type = ( is_object( $theValue ) )
								  ? get_class( $theValue )
								  : gettype( $theValue );
							throw new Exception( "Unsupported query type [$type]",
												 kERROR_PARAMETER );			// !@! ==>
						}
					}
					break;
			}
		}
		
		return ManageOffset( $this, kAPI_QUERY, $theValue, $getOld );				// ==>

	} // Query.

	 
	/*===================================================================================
	 *	Select																			*
	 *==================================================================================*/

	/**
	 * Manage select fields.
	 *
	 * This method can be used to manage the {@link kAPI_SELECT} offset, it accepts a
	 * parameter which represents the list of requested attributes, or the requested
	 * operation, depending on its value:
	 *
	 * <ul>
	 *	<li><i>NULL</i>: Return the current value.
	 *	<li><i>FALSE</i>: Delete the current value.
	 *	<li><i>other</i>: Set the value with the provided parameter, in this case the value
	 *		is expected to be:
	 *	 <ul>
	 *		<li><tt>array</tt> or <tt>ArrayObject<tt>: The provided parameter will become
	 *			the new list.
	 *		<li><i>other</i>: The method will assume the parameter is a string and it will
	 *			add it to the current list or create a list if it doesn't exist.
	 *	 </ul>
	 * </ul>
	 *
	 * The second parameter is a boolean which if <i>TRUE</i> will return the <i>old</i>
	 * value when replacing values; if <i>FALSE</i>, it will return the currently set value.
	 *
	 * @param string				$theValue			Value or operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access public
	 * @return mixed
	 *
	 * @uses _ManageListOffset()
	 *
	 * @see kAPI_SELECT
	 */
	public function Select( $theValue = NULL, $getOld = FALSE )
	{
		return $this->_ManageListOffset( kAPI_SELECT, $theValue, $getOld );			// ==>

	} // Select.

	 
	/*===================================================================================
	 *	Sort																			*
	 *==================================================================================*/

	/**
	 * Manage sort fields.
	 *
	 * This method can be used to manage the {@link kAPI_SORT} offset, the managed value is
	 * an array in which the key represents the attribute name and the value is an integer
	 * which determines the sort order: positive means ascending, negative means descending;
	 * zero is ignored.
	 *
	 * <ul>
	 *	<li><tt>$theField</tt>: The field name or list:
	 *	 <ul>
	 *		<li><tt>array</tt>: If you provide an array in this field, the method will
	 *			assume you are providing a full list, in this case the method will set the
	 *			offset with that value, <i>without checking its contents</i>.
	 *		<li><tt>NULL</tt>: Selects all fields.
	 *		<li><i>other</i>: Any other value will be interpreted as the field name.
	 *	 </ul>
	 *	<li><tt>$theOrder</tt>: The the sort order:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Return the sort order of the provided field. If the provided
	 *			field is an array, this parameter will be ignored; if the provided field is
	 *			a scalar, the method will return the element matching the provided field; if
	 *			the provided field is <tt>NULL</tt>, the method will return the full list.
	 *		<li><tt>FALSE</tt>: Delete the element matching the provided field: if the
	 *			provided field is an array, this parameter will be ignored; if the provided
	 *			field is a scalar, the method will delete the element matching the provided
	 *			field; if the provided field is <tt>NULL</tt>, the method will return the
	 *			full list.
	 *		<li><tt>integer</tt>: Set the sort order, negative values mean descending;
	 *			positive values mean ascending. If the provided field is an array, this
	 *			parameter will be ignored; if the provided field is a scalar, the method
	 *			will set the element matching the provided field; if the provided field is
	 *			<tt>NULL</tt>, the method will set all the elements of the list to the
	 *			provided sort order.
	 *		<li><tt>zero</tt>: If the parameter evaluates to zero, the operation will do
	 *			nothing.
	 *		<li><i>other</i>: Any other type will be cast to an integer.
	 *	 </ul>
	 *	<li><tt>$getOld</tt>: This parameter is a boolean which if <i>TRUE</i> will return
	 *		the <i>old</i> value when replacing values; if <i>FALSE</i>, it will return the
	 *		currently set value.
	 * </ul>
	 *
	 * @param string				$theField			Field name or fields list.
	 * @param mixed					$theOrder			Sort order or operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access public
	 * @return mixed
	 *
	 * @uses ManageOffset()
	 *
	 * @see kAPI_SORT
	 */
	public function Sort( $theField = NULL, $theOrder = NULL, $getOld = FALSE )
	{
		//
		// Handle arrays.
		//
		if( is_array( $theField ) )
			return ManageOffset( $this, kAPI_SORT, $theField, $getOld );			// ==>
		
		//
		// Get current list.
		//
		$save = $this->offsetGet( kAPI_SORT );
		
		//
		// Normalise target field.
		//
		if( $theField !== NULL )
			$theField = (string) $theField;
		
		//
		// Handle retrieve.
		//
		if( $theOrder === NULL )
		{
			//
			// Return full list or handle empty list.
			//
			if( ($save === NULL)
			 || ($theField === NULL) )
				return NULL;														// ==>
			
			//
			// Match field.
			//
			if( array_key_exists( $theField, $save ) )
				return $save[ $theField ];											// ==>
			
			return NULL;															// ==>
		
		} // Retrieve.
		
		//
		// Handle delete.
		//
		if( $theOrder === FALSE )
		{
			//
			// Handle empty list.
			//
			if( $save === NULL )
				return NULL;														// ==>
			
			//
			// Delete whole list.
			//
			if( $theField === NULL )
				return ManageOffset( $this, kAPI_SORT, FALSE, $getOld );			// ==>
			
			//
			// Match field.
			//
			if( array_key_exists( $theField, $save ) )
			{
				//
				// Save order.
				//
				$tmp = $save[ $theField ];
				
				//
				// Delete order.
				//
				unset( $save[ $theField ] );
				if( ! count( $save ) )
					$this->offsetUnset( kAPI_SORT );
				
				if( $getOld )
					return $tmp;													// ==>
			
			} // Matched field.
			
			return NULL;															// ==>
		
		} // Delete.
		
		//
		// Cast order.
		//
		$theOrder = (integer) $theOrder;
		if( ! $theOrder )
			return $save;															// ==>
		
		//
		// Set all fields to provided sort order.
		//
		if( $theField === NULL )
		{
			//
			// Set new value.
			//
			$new = array_fill_keys( array_keys( $save ), $theOrder );
			
			ManageOffset( $this, kAPI_SORT, $new, $getOld );						// ==>
		
		} // Set all fields.
		
		return ManageIndexedOffset(
					$this, kAPI_SORT, $theField, $theOrder, $getOld );				// ==>

	} // Sort.

		

/*=======================================================================================
 *																						*
 *									PUBLID QUERY INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	AddQueryStatement																*
	 *==================================================================================*/

	/**
	 * Add a query statement.
	 *
	 * This method can be used to add a query statement to the current query, it expects the
	 * query to be a scalar query with thew container provided in the service parameters.
	 *
	 * The method expects the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theCondition</tt>: The {@link kOPERATOR_AND}, {@link kOPERATOR_NAND},
	 *		{@link kOPERATOR_OR} or {@link kOPERATOR_NOR} operator (see the
	 *		{@link Operators.inc.php} source).
	 *	<li><tt>$theSubject</tt>: The subject or attribute of the query, it will be the
	 *		tag {@link kOFFSET_NID} (see the {@link Operators.inc.php} source).
	 *	<li><tt>$theOperator</tt>: The statement operator or operation.
	 *	<li><tt>$theObject</tt>: The object or value of the statement, this parameter may be
	 *		omitted of the operator does not require it.
	 *	<li><tt>$theType</tt>: The data type of the statement object (see the
	 *		{@link Types.inc.php} source).
	 * </ul>
	 *
	 * The query attribute will be set as a {@link CQuery} object and converted to an
	 * array before being sent to the server.
	 *
	 * Note that this method should only be used if the {@link kAPI_QUERY} property of the
	 * object refers to a single query: if the attribute should refer to a list of
	 * queries, you should use the {@link AddQueryListStatement()} method.
	 *
	 * @param string				$theCondition		Statement condition.
	 * @param mixed					$theSubject			Statement subject.
	 * @param string				$theOperator		Statement operator.
	 * @param mixed					$theObject			Statement object.
	 * @param string				$theType			Statement object data type.
	 *
	 * @access public
	 *
	 * @throws Exception
	 *
	 * @see kAPI_QUERY
	 */
	public function AddQueryStatement( $theCondition,
									   $theSubject, $theOperator, $theObject = NULL,
																  $theType = NULL )
	{
		//
		// Create query.
		//
		if( ! $this->offsetExists( kAPI_QUERY ) )
			$this->offsetSet( kAPI_QUERY, new CQuery() );
		
		//
		// Create statement.
		//
		$statement = $this-> _QueryStatement( $theSubject, $theOperator, $theObject,
											  $theType );
		
		//
		// Append statement.
		//
		$this->offsetGet( kAPI_QUERY )->AppendStatement( $statement, $theCondition );
	
	} // AddQueryStatement.

	 
	/*===================================================================================
	 *	AddQueryListStatement															*
	 *==================================================================================*/

	/**
	 * Add a query list statement.
	 *
	 * This method is similar to the {@link AddQueryStatement()} method as it adds a query
	 * statement to a query, except that the current {@link Query()} is a list of
	 * {@link CQuery} objects. This kind of structure is used by the {@link kAPI_OP_MATCH}
	 * operation to return the first match of a series of queries and by other operations in
	 * which the array element index represents the container name ({@link Container()}).
	 *
	 * The method expects the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theIndex</tt>: This parameter represents the list index to the query to
	 *		which the statement is to be appended. This parameter may either represent a
	 *		generic index, or it may represent the container name to which the query
	 *		applies.
	 *	<li><tt>$theCondition</tt>: The {@link kOPERATOR_AND}, {@link kOPERATOR_NAND},
	 *		{@link kOPERATOR_OR} or {@link kOPERATOR_NOR} operator (see the
	 *		{@link Operators.inc.php} source).
	 *	<li><tt>$theSubject</tt>: The subject or attribute of the query, it will be the
	 *		tag {@link kOFFSET_NID} (see the {@link Operators.inc.php} source).
	 *	<li><tt>$theOperator</tt>: The statement operator or operation.
	 *	<li><tt>$theObject</tt>: The object or value of the statement, this parameter may be
	 *		omitted of the operator does not require it.
	 *	<li><tt>$theType</tt>: The data type of the statement object (see the
	 *		{@link Types.inc.php} source).
	 * </ul>
	 *
	 * Each element of the queries list will be a {@link CQuery} object and converted to an
	 * array before being sent to the server.
	 *
	 * Note that this method should only be used if the {@link kAPI_QUERY} property of the
	 * object refers to a list of queries: if the attribute should refer to a scalar query,
	 * you should use the {@link AddQueryStatement()} method.
	 *
	 * @param string				$theIndex			Query index.
	 * @param string				$theCondition		Statement condition.
	 * @param mixed					$theSubject			Statement subject.
	 * @param string				$theOperator		Statement operator.
	 * @param mixed					$theObject			Statement object.
	 * @param string				$theType			Statement object data type.
	 *
	 * @access public
	 *
	 * @throws Exception
	 *
	 * @see kAPI_QUERY
	 */
	public function AddQueryListStatement( $theIndex,
										   $theCondition,
										   $theSubject, $theOperator, $theObject = NULL,
																	  $theType = NULL )
	{
		//
		// Normalise index.
		//
		$theIndex = (string) $theIndex;
		
		//
		// Create query list.
		//
		if( ! $this->offsetExists( kAPI_QUERY ) )
			$this->offsetSet( kAPI_QUERY, Array() );
		
		//
		// Create statement.
		//
		$statement = $this-> _QueryStatement( $theSubject, $theOperator, $theObject,
											  $theType );
		
		//
		// Create query.
		//
		$list = $this->offsetGet( kAPI_QUERY );
		if( ! array_key_exists( $theIndex, $list ) )
			$list[ $theIndex ] = new CQuery();
		
		//
		// Append statement.
		//
		$list[ $theIndex ]->AppendStatement( $statement, $theCondition );
		
		//
		// Update offset.
		//
		$this->offsetSet( kAPI_QUERY, $list );
	
	} // AddQueryListStatement.

		

/*=======================================================================================
 *																						*
 *									PROTECTED INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_CheckDependencies																*
	 *==================================================================================*/

	/**
	 * Check operation dependencies.
	 *
	 * This method can be used to assert whether the required parameters are present
	 * depending on the requested operation.
	 *
	 * @param string				$theOperation		Requested operation.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _CheckDependencies( $theOperation )
	{
		//
		// Parse by operation.
		//
		switch( $theOperation )
		{
			case kAPI_OP_COUNT:
			case kAPI_OP_GET_ONE:
			case kAPI_OP_MATCH:
				if( ! $this->offsetExists( kAPI_DATABASE ) )
					throw new Exception
							( "Unable to run service: missing database parameter",
							  kERROR_STATE );									// !@! ==>
				if( ! $this->offsetExists( kAPI_CONTAINER ) )
					throw new Exception
							( "Unable to run service: missing container parameter",
							  kERROR_STATE );									// !@! ==>
			
			case kAPI_OP_GET:
				if( ! $this->offsetExists( kAPI_PAGE_LIMIT ) )
					$this->PageLimit( kDEFAULT_LIMIT );
				if( ! $this->offsetExists( kAPI_FORMAT ) )
					throw new Exception
							( "Unable to run service: missing format parameter",
							  kERROR_STATE );									// !@! ==>
				break;
			
			default:
				parent::_CheckDependencies( $theOperation );
				break;
		}
	
	} // _CheckDependencies.

	 
	/*===================================================================================
	 *	_NormaliseParameters															*
	 *==================================================================================*/

	/**
	 * Normalise parameters.
	 *
	 * This method can be used to normalise parameters before they get encoded.
	 *
	 * In this class we set the request time stamp if the current value is not an float.
	 *
	 * In derived classes you should call first the parent method, then handle the local
	 * parameters.
	 *
	 * @access protected
	 */
	protected function _NormaliseParameters()
	{
		//
		// Call parent method.
		//
		parent::_NormaliseParameters();
		
		//
		// Convert query to array.
		//
		if( $this->offsetExists( kAPI_QUERY ) )
		{
			$query = $this->Query();
			switch( $this->Operation() )
			{
				case kAPI_OP_MATCH:
					foreach( $query as $key => $value )
					{
						if( $value instanceof ArrayObject )
							$query[ $key ] = $value->getArrayCopy();
					}
					$this->offsetSet( kAPI_QUERY, $query );
					break;
					
				default:
					if( $query instanceof ArrayObject )
						$this->offsetSet( kAPI_QUERY, $query->getArrayCopy() );
					break;
			}
		}
	
	} // _NormaliseParameters.

	 
	/*===================================================================================
	 *	_EncodeParameters																*
	 *==================================================================================*/

	/**
	 * Encode parameters.
	 *
	 * This method can be used to encode parameters before they get sent to the service.
	 *
	 * We overload this method to handle the local parameters.
	 *
	 * @param reference			   &$theParameters		List of parameters.
	 * @param string				$theEncoding		Encoding code.
	 *
	 * @access protected
	 */
	protected function _EncodeParameters( &$theParameters, $theEncoding )
	{
		//
		// Call parent method.
		//
		parent::_EncodeParameters( $theParameters, $theEncoding );
		
		//
		// Parse by encoding.
		//
		switch( $theEncoding )
		{
			case kTYPE_PHP:
				foreach( CDataWrapper::$sParameterList as $key )
				{
					if( array_key_exists( $key, $theParameters ) )
						$theParameters[ $key ]
							= serialize( $theParameters[ $key ] );
				}
				break;

			case kTYPE_JSON:
				foreach( CDataWrapper::$sParameterList as $key )
				{
					if( array_key_exists( $key, $theParameters ) )
						$theParameters[ $key ]
							= JsonEncode( $theParameters[ $key ] );
				}
				break;
		}
	
	} // _EncodeParameters.

	 
	/*===================================================================================
	 *	_QueryStatement																	*
	 *==================================================================================*/

	/**
	 * Return a query statement.
	 *
	 * This method can be used to retrieve a query statement given the provided parameters,
	 * see the {@link AddQueryStatement()} method for an explanation of the parameters.
	 *
	 * @param mixed					$theSubject			Statement subject.
	 * @param string				$theOperator		Statement operator.
	 * @param mixed					$theObject			Statement object.
	 * @param string				$theType			Statement object data type.
	 *
	 * @access protected
	 * @return array
	 */
	protected function _QueryStatement( $theSubject, $theOperator, $theObject = NULL,
																   $theType = NULL )
	{
		//
		// Check object.
		//
		if( $theObject === NULL )
		{
			switch( $theOperator )
			{
				case kOPERATOR_NULL:
				case kOPERATOR_NOT_NULL:
				case kOPERATOR_DISABLED:
					break;
				
				default:
					throw new Exception( "Missing statement object or value",
										 kERROR_MISSING );						// !@! ==>
			}
		
		} // Omitted object.
		
		//
		// Parse by operator.
		//
		switch( $theOperator )
		{
			case kOPERATOR_EQUAL:
				return CQueryStatement::Equals
							( $theSubject, $theObject, $theType );					// ==>
			
			case kOPERATOR_EQUAL_NOT:
				return CQueryStatement::NotEquals
							( $theSubject, $theObject, $theType );					// ==>
			
			case kOPERATOR_LIKE:
				return CQueryStatement::Like( $theSubject, $theObject );			// ==>
			
			case kOPERATOR_LIKE_NOT:
				return CQueryStatement::NotLike( $theSubject, $theObject );			// ==>
			
			case kOPERATOR_PREFIX:
				return CQueryStatement::Prefix( $theSubject, $theObject );			// ==>
			
			case kOPERATOR_PREFIX_NOCASE:
				return CQueryStatement::PrefixNoCase( $theSubject, $theObject );	// ==>
			
			case kOPERATOR_CONTAINS:
				return CQueryStatement::Contains( $theSubject, $theObject );		// ==>
			
			case kOPERATOR_CONTAINS_NOCASE:
				return CQueryStatement::ContainsNoCase( $theSubject, $theObject );	// ==>
			
			case kOPERATOR_SUFFIX:
				return CQueryStatement::Suffix( $theSubject, $theObject );			// ==>
			
			case kOPERATOR_SUFFIX_NOCASE:
				return CQueryStatement::SuffixNoCase( $theSubject, $theObject );	// ==>
			
			case kOPERATOR_REGEX:
				return CQueryStatement::Regex( $theSubject, $theObject );			// ==>
			
			case kOPERATOR_LESS:
				return CQueryStatement::Less( $theSubject, $theObject, $theType );	// ==>
			
			case kOPERATOR_LESS_EQUAL:
				return CQueryStatement::LessEqual
							( $theSubject, $theObject, $theType );					// ==>
			
			case kOPERATOR_GREAT:
				return CQueryStatement::Great( $theSubject, $theObject, $theType );	// ==>
			
			case kOPERATOR_GREAT_EQUAL:
				return CQueryStatement::GreatEqual
							( $theSubject, $theObject, $theType );					// ==>
			
			case kOPERATOR_IRANGE:
				return CQueryStatement::RangeInclusive
							( $theSubject,
							  $theObject[ 0 ], $theObject[ 1 ],
							  $theType );											// ==>
			
			case kOPERATOR_ERANGE:
				return CQueryStatement::RangeExclusive
							( $theSubject,
							  $theObject[ 0 ], $theObject[ 1 ],
							  $theType );											// ==>
			
			case kOPERATOR_NULL:
				return CQueryStatement::Missing( $theSubject );						// ==>
			
			case kOPERATOR_NOT_NULL:
				return CQueryStatement::Exists( $theSubject );						// ==>
			
			case kOPERATOR_IN:
				return CQueryStatement::Member
							( $theSubject, $theObject, $theType );					// ==>
			
			case kOPERATOR_NI:
				return CQueryStatement::NotMember
							( $theSubject, $theObject, $theType );					// ==>
			
			case kOPERATOR_ALL:
				return CQueryStatement::All( $theSubject, $theObject, $theType );	// ==>
			
			case kOPERATOR_NALL:
				return CQueryStatement::NotAll
							( $theSubject, $theObject, $theType );					// ==>
			
			case kOPERATOR_EX:
				return CQueryStatement::Expression( $theSubject, $theObject );		// ==>
			
			default:
				throw new Exception( "Unsupported operator",
									 kERROR_PARAMETER );						// !@! ==>
		}
	
	} // _QueryStatement.

	 

} // class CDataWrapperClient.


?>

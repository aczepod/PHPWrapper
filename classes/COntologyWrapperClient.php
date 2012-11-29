<?php

/**
 * <i>COntologyWrapperClient</i> class definition.
 *
 * This file contains the class definition of <b>COntologyWrapperClient</b> which represents
 * a web-service ontology wrapper client.
 *
 *	@package	MyWrapper
 *	@subpackage	Wrappers
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 15/11/2012
 */

/*=======================================================================================
 *																						*
 *								COntologyWrapperClient.php								*
 *																						*
 *======================================================================================*/

/**
 * Ancestor.
 *
 * This include file contains the parent class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CDataWrapperClient.php" );

/**
 * Server definitions.
 *
 * This include file contains all definitions of the server object.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntologyWrapper.php" );

/**
 * <h4>Ontology wrapper client</h4>
 *
 * This class represents a web-services ontology wrapper client, it facilitates the job of
 * requesting information from servers derived from the {@link COntologyWrapper} class.
 *
 * This class supports the following properties:
 *
 * <ul>
 *	<li><i>{@link Language()}</i>: This element represents the web-service language code,
 *		it is stored in the in the {@link kAPI_LANGUAGE} offset.
 *	<li><i>{@link Predicate()}</i>: This element represents the web-service predicate
 *		reference, it is stored in the {@link kAPI_PREDICATE} offset.
 *	<li><i>{@link Relations()}</i>: This element represents the web-service relations sense
 *		code, it is stored in the {@link kAPI_RELATION} offset.
 * </ul>
 *
 * The class recognises the following operations ({@link Operation()}):
 *
 * <ul>
 *	<li><tt>{@link kAPI_OP_GetVertex}</tt>: This service will first select the list of
 *		vertices matching the provided query, if the {@link kAPI_RELATION} parameter is
 *		provided, the service will use the first found vertex and return the list of
 *		vertices related to that vertex, depending on the value of the {@link kAPI_RELATION}
 *		parameter:
 *	 <ul>
 *		<li><tt>{@link kAPI_RELATION_IN}</tt>: Return all vertices that point to the vertex.
 *		<li><tt>{@link kAPI_RELATION_OUT}</tt>: Return all vertices to which the vertex
 *			points to.
 *		<li><tt>{@link kAPI_RELATION_ALL}</tt>: Return all vertices related to the vertex.
 *	 </ul>
 *		If the {@link kAPI_RELATION} parameter is missing, the service will return the
 *		matched list of vertices.
 * </ul>
 *
 *	@package	MyWrapper
 *	@subpackage	Wrappers
 */
class COntologyWrapperClient extends CDataWrapperClient
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
	 *	<li><i>{@link kAPI_OP_GetVertex}</i>: Return a selection of vertices, or the related
	 *		vertices of the selected vertex.
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
	 * @see kAPI_OP_GetVertex
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
				case kAPI_OP_GetVertex:
					return ManageOffset(
						$this, kAPI_OPERATION, $theValue, $getOld );				// ==>
			}
		}
		
		return parent::Operation( $theValue, $getOld );								// ==>

	} // Operation.

	 
	/*===================================================================================
	 *	Query																			*
	 *==================================================================================*/

	/**
	 * Manage query.
	 *
	 * We overload this method to allow setting the query directly with the vertex
	 * identifier, if the method argument is an integer, we assume the value is a node
	 * native identifier and we set the query to match it.
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
				case kAPI_OP_GetVertex:
					//
					// Handle integers.
					//
					if( is_integer( $theValue ) )
					{
						//
						// Save current query.
						//
						$query = $this->offsetGet( kAPI_QUERY );
						if( $query === NULL )
							$query = new CQuery();
						elseif( ! ($query instanceof CQuery) )
							$query = new CQuery( $query );
						
						//
						// Add reference to it.
						//
						$query->AppendStatement(
							CQueryStatement::Equals(
								kTAG_NID, $theValue ),
							kOPERATOR_AND );
						
						//
						// Use modified query.
						//
						$theValue = $query;
					}
					break;
			}
		}
		
		return ManageOffset( $this, kAPI_QUERY, $theValue, $getOld );				// ==>

	} // Query.

	 
	/*===================================================================================
	 *	Language																		*
	 *==================================================================================*/

	/**
	 * Manage language code(s).
	 *
	 * This method can be used to manage the {@link kAPI_LANGUAGE} offset, it accepts a
	 * parameter which represents the list of language codes in which {@link kTYPE_LSTRING}
	 * attributes are set, or the requested operation, depending on its value:
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
	 * @see kAPI_LANGUAGE
	 */
	public function Language( $theValue = NULL, $getOld = FALSE )
	{
		return $this->_ManageListOffset( kAPI_LANGUAGE, $theValue, $getOld );		// ==>

	} // Language.

	 
	/*===================================================================================
	 *	Predicate																		*
	 *==================================================================================*/

	/**
	 * Manage predicate(s) selector.
	 *
	 * This method can be used to manage the {@link kAPI_PREDICATE} offset, it accepts a
	 * parameter which represents the list of predicate references, or the requested
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
	 * @see kAPI_PREDICATE
	 */
	public function Predicate( $theValue = NULL, $getOld = FALSE )
	{
		return $this->_ManageListOffset( kAPI_PREDICATE, $theValue, $getOld );		// ==>

	} // Predicate.

	 
	/*===================================================================================
	 *	Relations																		*
	 *==================================================================================*/

	/**
	 * Manage relationships sense.
	 *
	 * This method can be used to manage the {@link kAPI_RELATION} offset, it accepts a
	 * parameter which represents the relationships sense, or the requested operation,
	 * depending on its value:
	 *
	 * <ul>
	 *	<li><tt>NULL</tt>: Return the current value.
	 *	<li><tt>FALSE</tt>: Delete the current value.
	 *	<li><tt>{@link kAPI_RELATION_IN}</tt>: Incoming relationships.
	 *	<li><tt>{@link kAPI_RELATION_OUT}</tt>: Outgoing relationships.
	 *	<li><tt>{@link kAPI_RELATION_ALL}</tt>: Incoming and outgoing relationships.
	 *	<li><i>other</i>: The method will raise an exception.
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
	 * @see kAPI_RELATION
	 */
	public function Relations( $theValue = NULL, $getOld = FALSE )
	{
		//
		// Check operation.
		//
		if( ($theValue !== NULL)
		 && ($theValue !== FALSE) )
		{
			switch( $theValue = (string) $theValue )
			{
				case kAPI_RELATION_IN:
				case kAPI_RELATION_OUT:
				case kAPI_RELATION_ALL:
					break;
				
				default:
					throw new CException( "Unsupported relationship sense",
										  kERROR_UNSUPPORTED,
										  kSTATUS_ERROR,
										  array( 'Code' => $theValue ) );		// !@! ==>
			}
		}
		
		return ManageOffset( $this, kAPI_RELATION, $theValue, $getOld );			// ==>

	} // Relations.

		

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
			case kAPI_OP_GetVertex:
				if( ! $this->offsetExists( kAPI_DATABASE ) )
					throw new Exception
							( "Unable to run service: missing database parameter",
							  kERROR_STATE );									// !@! ==>
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
		// Convert language to array.
		//
		if( $this->offsetExists( kAPI_LANGUAGE ) )
		{
			if( ! is_array( $this->offsetGet( kAPI_LANGUAGE ) ) )
				$this->offsetSet( kAPI_LANGUAGE, array( kAPI_LANGUAGE ) );
		}
		
		//
		// Convert predicate to array.
		//
		if( $this->offsetExists( kAPI_PREDICATE ) )
		{
			if( ! is_array( $this->offsetGet( kAPI_PREDICATE ) ) )
				$this->offsetSet( kAPI_PREDICATE, array( kAPI_PREDICATE ) );
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
				foreach( COntologyWrapper::$sParameterList as $key )
				{
					if( array_key_exists( $key, $theParameters ) )
						$theParameters[ $key ]
							= serialize( $theParameters[ $key ] );
				}
				break;

			case kTYPE_JSON:
				foreach( COntologyWrapper::$sParameterList as $key )
				{
					if( array_key_exists( $key, $theParameters ) )
						$theParameters[ $key ]
							= JsonEncode( $theParameters[ $key ] );
				}
				break;
		}
	
	} // _EncodeParameters.

	 

} // class COntologyWrapperClient.


?>

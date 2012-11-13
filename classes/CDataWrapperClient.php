<?php

/**
 * <i>CDataWrapperClient</i> class definition.
 *
 * This file contains the class definition of <b>CDataWrapperClient</b> which represents a
 * web-service wrapper client.
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
 *	Wrapper client.
 *
 * This class represents a web-services wrapper client, it facilitates the job of requesting
 * information from servers derived from the {@link CWrapper CWrapper} class.
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
				case kAPI_OP_MATCH:
				case kAPI_OP_GET:
				case kAPI_OP_SET:
				case kAPI_OP_UPDATE:
				case kAPI_OP_INSERT:
				case kAPI_OP_BATCH_INSERT:
				case kAPI_OP_MODIFY:
				case kAPI_OP_DEL:
					break;
				
				default:
					return parent::Operation( $theValue, $getOld );					// ==>
			}
		}
		
		return CAttribute::ManageOffset
				( $this, kAPI_OPERATION, $theValue, $getOld );						// ==>

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
	 *	Operation																		*
	 *==================================================================================*/

	/**
	 * Manage operation.
	 *
	 * This method can be used to manage the {@link kAPI_OPERATION operation}, it accepts a
	 * parameter which represents either the web-service operation code or this method
	 * operation, depending on its value:
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
	 * This method will check whether the provided operation is supported, if this is not
	 * the case, it will raise an exception. Derived classes should first check their
	 * specific operations, if not matched, they should pass the parameter to the parent
	 * method. In this class we support the following operations:
	 *
	 * <ul>
	 *	<li><i>{@link kAPI_OP_HELP kAPI_OP_HELP}</i>: HELP web-service operation, which
	 *		returns the list of supported operations and options.
	 *	<li><i>{@link kAPI_OP_PING kAPI_OP_PING}</i>: PING web-service operation, which
	 *		returns a status response.
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
	 * @uses ManageOffset()
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
				case kAPI_OP_HELP:
				case kAPI_OP_PING:
					break;
				
				default:
					throw new CException( "Unsupported operation",
										  kERROR_UNSUPPORTED,
										  kMESSAGE_TYPE_ERROR,
										  array( 'Operation' => $theValue ) );	// !@! ==>
			}
		}
		
		return ManageOffset( $this, kAPI_OPERATION, $theValue, $getOld );			// ==>

	} // Operation.

	 
	/*===================================================================================
	 *	Format																			*
	 *==================================================================================*/

	/**
	 * Manage format.
	 *
	 * This method can be used to manage the {@link kAPI_FORMAT format} in which both the
	 * parameters are sent and the response is returned from the web-service. It accepts a
	 * parameter which represents either the web-service format code or this method
	 * operation, depending on its value:
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
	 * This method will check whether the provided format is supported, if this is not
	 * the case, it will raise an exception. Derived classes should first check their
	 * specific operations, if not matched, they should pass the parameter to the parent
	 * method. In this class we support the following operations:
	 *
	 * <ul>
	 *	<li><i>{@link kTYPE_PHP}</i>: Parameters and response will be serialized.
	 *	<li><i>{@link kTYPE_XML}</i>: Parameters and response will be encoded in XML.
	 *	<li><i>{@link kTYPE_JSON}</i>: Parameters and response will be encoded in JSON.
	 *	<li><i>{@link kTYPE_META}</i>: This data type can be used to
	 *		return service metadata, the {@link Execute() request} will return headers
	 *		metadata for troubleshooting, rather than the response from the web-service.
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
	 * @uses ManageOffset()
	 *
	 * @see kAPI_FORMAT
	 * @see kAPI_OP_HELP kAPI_OP_PING
	 */
	public function Format( $theValue = NULL, $getOld = FALSE )
	{
		//
		// Check operation.
		//
		if( ($theValue !== NULL)
		 && ($theValue !== FALSE) )
		{
			switch( $theValue )
			{
				case kTYPE_PHP:
				case kTYPE_JSON:
				case kTYPE_META:
					break;
				
				case kTYPE_XML:
				default:
					throw new CException( "Unsupported format",
										  kERROR_UNSUPPORTED,
										  kMESSAGE_TYPE_ERROR,
										  array( 'Format' => $theValue ) );		// !@! ==>
			}
		}
		
		return ManageOffset( $this, kAPI_FORMAT, $theValue, $getOld );				// ==>

	} // Format.

	 
	/*===================================================================================
	 *	Stamp																			*
	 *==================================================================================*/

	/**
	 * Time-stamp switch.
	 *
	 * This method can be used to turn on or off the time-stamp section in the web-service
	 * response, the method accepts a single parameter that if resolves to <i>TRUE</i> it
	 * will turn on this option, if not it will turn it off.
	 *
	 * The second parameter is a boolean which if <i>TRUE</i> will return the <i>old</i>
	 * value when replacing values; if <i>FALSE</i>, it will return the currently set value.
	 *
	 * @param boolean				$theValue			TRUE or FALSE.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access public
	 * @return mixed
	 *
	 * @uses ManageOffset()
	 *
	 * @see kAPI_STAMP_REQUEST
	 */
	public function Stamp( $theValue = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kAPI_STAMP_REQUEST, $theValue, $getOld );		// ==>

	} // Stamp.

	 
	/*===================================================================================
	 *	LogRequest																		*
	 *==================================================================================*/

	/**
	 * Log request switch.
	 *
	 * This method can be used to turn on or off the request section in the web-service
	 * response, the method accepts a single parameter that if resolves to <i>TRUE</i> it
	 * will turn on this option, if not it will turn it off.
	 *
	 * The second parameter is a boolean which if <i>TRUE</i> will return the <i>old</i>
	 * value when replacing values; if <i>FALSE</i>, it will return the currently set value.
	 *
	 * @param boolean				$theValue			TRUE or FALSE.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access public
	 * @return mixed
	 *
	 * @uses ManageOffset()
	 *
	 * @see kAPI_LOG_REQUEST
	 */
	public function LogRequest( $theValue = NULL, $getOld = FALSE )
	{
		//
		// Normalise value.
		//
		$theValue = ( $theValue ) ? TRUE : FALSE;
		
		return ManageOffset( $this, kAPI_LOG_REQUEST, $theValue, $getOld );			// ==>

	} // LogRequest.

	 
	/*===================================================================================
	 *	LogTrace																		*
	 *==================================================================================*/

	/**
	 * Log trace switch.
	 *
	 * This method can be used to turn on or off the trace in the event an exception is
	 * raised, the method accepts a single parameter that if resolves to <i>TRUE</i> it will
	 * turn on this option, if not it will turn it off.
	 *
	 * The second parameter is a boolean which if <i>TRUE</i> will return the <i>old</i>
	 * value when replacing values; if <i>FALSE</i>, it will return the currently set value.
	 *
	 * @param boolean				$theValue			TRUE or FALSE.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access public
	 * @return mixed
	 *
	 * @uses ManageOffset()
	 *
	 * @see kAPI_LOG_TRACE
	 */
	public function LogTrace( $theValue = NULL, $getOld = FALSE )
	{
		//
		// Normalise value.
		//
		$theValue = ( $theValue ) ? TRUE : FALSE;
		
		return ManageOffset( $this, kAPI_LOG_TRACE, $theValue, $getOld );			// ==>

	} // LogTrace.

		

/*=======================================================================================
 *																						*
 *								PUBLIC ARRAY ACCESS INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	offsetSet																		*
	 *==================================================================================*/

	/**
	 * Set a value for a given offset.
	 *
	 * We overload this method to manage the {@link _IsInited() inited}
	 * {@link kFLAG_STATE_INITED status}: this is set if {@link kAPI_URL URL},
	 * {@link kAPI_OPERATION operation} and {@link kAPI_FORMAT format} are all set.
	 *
	 * @param string				$theOffset			Offset.
	 * @param string|NULL			$theValue			Value to set at offset.
	 *
	 * @access public
	 */
	public function offsetSet( $theOffset, $theValue )
	{
		//
		// Call parent method.
		//
		parent::offsetSet( $theOffset, $theValue );
		
		//
		// Set inited flag.
		//
		if( $theValue !== NULL )
			$this->_IsInited( $this->offsetExists( kAPI_URL ) &&
							  $this->offsetExists( kAPI_FORMAT ) &&
							  $this->offsetExists( kAPI_OPERATION ) );
	
	} // offsetSet.

	 
	/*===================================================================================
	 *	offsetUnset																		*
	 *==================================================================================*/

	/**
	 * Reset a value for a given offset.
	 *
	 * We overload this method to manage the {@link _IsInited() inited}
	 * {@link kFLAG_STATE_INITED status}: this is set if {@link kAPI_URL URL},
	 * {@link kAPI_OPERATION operation} and {@link kAPI_FORMAT format} are all set.
	 *
	 * @param string				$theOffset			Offset.
	 *
	 * @access public
	 */
	public function offsetUnset( $theOffset )
	{
		//
		// Call parent method.
		//
		parent::offsetUnset( $theOffset );
		
		//
		// Set inited flag.
		//
		$this->_IsInited( $this->offsetExists( kAPI_URL ) &&
						  $this->offsetExists( kAPI_FORMAT ) &&
						  $this->offsetExists( kAPI_OPERATION ) );
	
	} // offsetUnset.

		

/*=======================================================================================
 *																						*
 *								PUBLIC REQUEST INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Execute																			*
	 *==================================================================================*/

	/**
	 * Send an HTTP request.
	 *
	 * This method can be used to sent an <i>HTTP</i> request using the current contents of
	 * the object and return a response.
	 *
	 * @param string				$theMode			Request mode, POST or GET
	 *
	 * @access public
	 * @return mixed
	 *
	 * @throws {@link CException CException}
	 */
	public function Execute( $theMode = 'POST' )
	{
		//
		// Check if inited.
		//
		if( ! $this->_IsInited() )
			throw new CException
					( "Unable to execute request: object not initialised",
					  kERROR_STATE,
					  kMESSAGE_TYPE_ERROR,
					  array( 'Object' => $this ) );								// !@! ==>
	
		//
		// Copy parameters.
		//
		$params = $this->getArrayCopy();
		
		//
		// Extract URL.
		//
		$url = $params[ kAPI_URL ];
		unset( $params[ kAPI_URL ] );
		
		//
		// Extract format.
		//
		$format = $params[ kAPI_FORMAT ];
		
		//
		// Set time-stamp.
		// We overwrite the curent value to get the current time.
		//
		if( $this->offsetExists( kAPI_STAMP_REQUEST ) )
			$this->offsetSet( kAPI_STAMP_REQUEST, gettimeofday( TRUE ) );
		
		//
		// Format parameters.
		//
		foreach( $params as $key => $value )
		{
			if( is_array( $value )
			 || ($value instanceof ArrayObject) )
			{
				switch( $this->Format() )
				{
					case kTYPE_PHP:
						$params[ $key ] = serialize( $value );
						break;

					case kTYPE_JSON:
						$params[ $key ] = JsonEncode( $value );
						break;
				}
			}
		}
		
		return self::Request( $url, $params, $theMode, $format );					// ==>
	
	} // Execute.

		

/*=======================================================================================
 *																						*
 *								STATIC REQUEST INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Request																			*
	 *==================================================================================*/

	/**
	 * Send a HTTP request.
	 *
	 * This method can be used to sent an <i>HTTP</i> request via <i>GET</i> or <i>POST</i>.
	 *
	 * The method accepts the following parameters:
	 *
	 * <ul>
	 *	<li><b>$theUrl</b>: The request URL.
	 *	<li><b>$theParams</b>: An array of key/value parameters for the request.
	 *	<li><b>$theMode</b>: The request mode:
	 *	 <ul>
	 *		<li><tt>GET</tt>: GET, default.
	 *		<li><tt>POST</tt>: POST.
	 *		<li><i>{@link kTYPE_META}</i>: Metadata: if you provide this format, the method
	 *			will return the metadata of the operation for troubleshooting purposes.
	 *	 </ul>
	 *	<li><b>$theFormat</b>: The request format:
	 *	 <ul>
	 *		<li><tt>{@link kTYPE_PHP}</tt>: PHP.
	 *		<li><tt>{@link kTYPE_JSON}</tt>: JSON.
	 *		<li><i>other</i>: Metadata: the method will return the metadata of the operation
	 *			for troubleshooting purposes.
	 *	 </ul>
	 * </ul>
	 *
	 * @param string				$theUrl				Request URL.
	 * @param mixed					$theParams			Request parameters.
	 * @param string				$theMode			Request mode.
	 * @param string				$theFormat			Response format.
	 *
	 * @static
	 * @return mixed
	 *
	 * @throws {@link CException CException}
	 */
	static function Request( $theUrl, $theParams = NULL,
									  $theMode = 'POST',
									  $theFormat = kTYPE_JSON )
	{
		//
		// Check mode.
		//
		switch( $tmp = strtoupper( $theMode ) )
		{
			case 'GET':
			case 'POST':
				$theMode = $tmp;
				break;
			
			default:
				throw new CException( "Unsupported HTTP mode",
									  kERROR_UNSUPPORTED,
									  kMESSAGE_TYPE_ERROR,
									  array( 'Mode' => $theMode ) );			// !@! ==>
		}
		
		//
		// Build context parameters.
		//
		$cxp = array( 'http' => array( 'method' => $theMode,
									   'ignore_errors' => TRUE ) );
		
		//
		// Set parameters.
		//
		if( $theParams !== NULL )
		{
			//
			// Format parameters.
			//
			$theParams = http_build_query( $theParams );
			
			//
			// Handle mode.
			//
			if( $theMode == 'POST' )
				$cxp[ 'http' ][ 'content' ] = $theParams;
			else
				$theUrl .= ('?'.$theParams);
		}
		
		//
		// Create context.
		//
		$context = stream_context_create( $cxp );
		
		//
		// Open stream.
		//
		$fp = @fopen( $theUrl, 'rb', FALSE, $context );
		if( ! $fp )
			throw new CException( "Unable to open [$theMode] [$theUrl]",
								  kERROR_STATE,
								  kMESSAGE_TYPE_ERROR,
								  array( 'Mode' => $theMode,
								  		 'URL' => $theUrl ) );					// !@! ==>
		
		//
		// Get stream metadata.
		// This can be used to troubleshoot the operation:
		// by displating the metadata you can see the HTTP response header
		// across all redirects.
		//
		if( $theFormat == kTYPE_META )
		{
			$meta = stream_get_meta_data( $fp );
			fclose( $fp );
			return $meta;															// ==>
		}
		
		//
		// Read stream.
		//
		$result = stream_get_contents( $fp );
		
		//
		// Close stream.
		//
		fclose( $fp );
		
		//
		// Format response.
		//
		switch( $theFormat )
		{
			case kTYPE_JSON:
				return JsonDecode( $result );								// ==>
			
			case kTYPE_PHP:
				return unserialize( $result );										// ==>
		}
		
		return $result;																// ==>
	
	} // Request.

	 

} // class CDataWrapperClient.


?>

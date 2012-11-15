<?php

/**
 * <i>CWrapperClient</i> class definition.
 *
 * This file contains the class definition of <b>CWrapperClient</b> which represents a
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
 *									CWrapperClient.php									*
 *																						*
 *======================================================================================*/

/**
 * Server definitions.
 *
 * This include file contains all definitions of the server object.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CWrapper.php" );

/**
 * <h4>Wrapper client</h4>
 *
 * This class represents a web-services wrapper client, it facilitates the job of requesting
 * information from servers derived from the {@link CWrapper} class.
 *
 * This class supports the following properties:
 *
 * <ul>
 *	<li><i>{@link Operation()}</i>: This element represents the web-service requested
 *		operation, it is stored in the {@link kAPI_OPERATION} offset.
 *	<li><i>{@link Format()}</i>: This element represents the web-service parameters and
 *		response format, it is stored in the {@link kAPI_FORMAT} offset.
 *	<li><i>{@link Stamp()}</i>: This element represents a switch to turn on and off timing
 *		information from the web service, it is stored in the {@link kAPI_STAMP_REQUEST}
 *		offset.
 *	<li><i>Log {@link LogRequest()}</i>: This element represents a switch to turn onand off
 *		logging the request: if on, the request will be returned by the web-service, it is
 *		stored in the {@link kAPI_LOG_REQUEST} offset.
 *	<li><i>Log {@link LogTrace()}</i>: This element represents a switch to turn on and off
 *		tracing exceptions: if on, any exception will also hold a trace, it is stored in the
 *		{@link kAPI_LOG_TRACE} offset.
 * </ul>
 *
 * The class recognises the following operations ({@link Operation()}):
 *
 * <ul>
 *	<li><tt>{@link kAPI_OP_HELP}</tt>: This service returns the list of supported operations
 *		and options. The service expects the following parameters:
 *	 <ul>
 *		<li><tt>{@link Format()}</tt>: The data encoding type ({@link kAPI_FORMAT}).
 *	 </ul>
 *	<li><tt>{@link kAPI_OP_PING}</tt>: This service returns a status response. The service
 *		expects the following parameters:
 *	 <ul>
 *		<li><tt>{@link Format()}</tt>: The data encoding type ({@link kAPI_FORMAT}).
 *	 </ul>
 * </ul>
 *
 * Objects of this class require at least the {@link Connection()}, {@link Operation()} and
 * {@link Format()} to be set if they expect to have an {@link _IsInited()} status, which is
 * necessary to send requests to web-services.
 *
 *	@package	MyWrapper
 *	@subpackage	Wrappers
 */
class CWrapperClient extends CConnection
{
		

/*=======================================================================================
 *																						*
 *										MAGIC											*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	__toString																		*
	 *==================================================================================*/

	/**
	 * <h4>Return connection name</h4>
	 *
	 * This method should return the current client's name, in this class we return the
	 * client's URL ({@link Connection()}.
	 *
	 * @access public
	 * @return string				The client name.
	 */
	public function __toString()							{	return $this->Connection();	}

		

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
	 * @throws {@link CException}
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
		// Check dependencies.
		//
		if( ($op = $this->Operation()) !== NULL )
			$this->_CheckDependencies( $op );
		
		//
		// Normalise parameters.
		//
		$this->_NormaliseParameters();
	
		//
		// Init local storage.
		//
		$params = $this->getArrayCopy();
		$url = $this->Connection();
		$format = $params[ kAPI_FORMAT ];
		
		//
		// Encode parameters.
		//
		$this->_EncodeParameters( $params, $this->Format() );
		
		return static::Request( $url, $params, $theMode, $format );					// ==>
	
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
		


/*=======================================================================================
 *																						*
 *								PROTECTED STATUS INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_Ready																			*
	 *==================================================================================*/

	/**
	 * <h4>Determine if the object is ready</h4>
	 *
	 * In this class we tie the {@link _IsInited()} status to the presence or absence of the
	 * {@link kAPI_OPERATION} and {@link kAPI_FORMAT} parameters.
	 *
	 * @access protected
	 * @return boolean				<tt>TRUE</tt> means {@link _IsInited( <tt>TRUE</tt> ).
	 *
	 * @uses _Ready()
	 */
	protected function _Ready()
	{
		//
		// Check parent.
		//
		if( parent::_Ready() )
			return ( $this->offsetExists( kAPI_FORMAT )
				  && $this->offsetExists( kAPI_OPERATION ) );						// ==>
		
		return FALSE;																// ==>
	
	} // _Ready.

		

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
			case kAPI_OP_HELP:
			case kAPI_OP_PING:
				if( ! $this->offsetExists( kAPI_FORMAT ) )
					throw new Exception
							( "Unable to run service: missing format parameter",
							  kERROR_STATE );									// !@! ==>
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
		// Set time-stamp.
		//
		if( $this->offsetExists( kAPI_STAMP_REQUEST )
		 && (! is_float( $this->offsetGet( kAPI_STAMP_REQUEST ) )) )
			$this->offsetSet( kAPI_STAMP_REQUEST, gettimeofday( TRUE ) );
	
	} // _NormaliseParameters.

	 
	/*===================================================================================
	 *	_EncodeParameters																*
	 *==================================================================================*/

	/**
	 * Encode parameters.
	 *
	 * This method can be used to encode parameters before they get sent to the service.
	 *
	 * The method expects one parameter to be a reference to the list of parameter that will
	 * be sent and the other to be the format in which the parameters myst be encoded. This
	 * value is assumed to be an array.
	 *
	 * If the provided encoding is not recognised by the method, the parameters will be left
	 * untouched; in derived classes you should first call the parent method and then handle
	 * the local parameters.
	 *
	 * @param reference			   &$theParameters		List of parameters.
	 * @param string				$theEncoding		Encoding code.
	 *
	 * @access protected
	 */
	protected function _EncodeParameters( &$theParameters, $theEncoding )
	{
		//
		// Parse by encoding.
		//
		switch( $theEncoding )
		{
			case kTYPE_PHP:
				foreach( CWrapper::$sParameterList as $key )
				{
					if( array_key_exists( $key, $theParameters ) )
						$theParameters[ $key ]
							= serialize( $theParameters[ $key ] );
				}
				break;

			case kTYPE_JSON:
				foreach( CWrapper::$sParameterList as $key )
				{
					if( array_key_exists( $key, $theParameters ) )
						$theParameters[ $key ]
							= JsonEncode( $theParameters[ $key ] );
				}
				break;
		}
	
	} // _EncodeParameters.

		

/*=======================================================================================
 *																						*
 *									PROTECTED UTILITIES									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_ManageListOffset																*
	 *==================================================================================*/

	/**
	 * Manage a list offset.
	 *
	 * This method is similar to the {@link ManageOffset()} function, except that it is
	 * assumed that the offset must contain an array: if you provide an array as the
	 * value, the method will behave as {@link ManageOffset()}; if you provide a scalar,
	 * the method will convert it to a string and add it to the existing array if it doesn't
	 * exist already, or create a new list with it. It is not possible to retrieve or delete
	 * single elements of the list, only add.
	 *
	 * @param string				$theOffset			Offset to be managed.
	 * @param mixed					$theValue			New value or operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access protected
	 * @return array
	 *
	 * @throws Exception
	 */
	protected function _ManageListOffset( $theOffset, $theValue = NULL, $getOld = FALSE )
	{
		//
		// Check operation.
		//
		if( ($theValue !== NULL)
		 && ($theValue !== FALSE) )
		{
			//
			// Cast parameter.
			//
			if( $theValue instanceof ArrayObject )
				$theValue = $theValue->getArrayCopy();
			
			//
			// Add to list.
			//
			if( ! is_array( $theValue ) )
			{
				//
				// Convert to string.
				//
				$theValue = (string) $theValue;
				
				//
				// Handle existing list.
				//
				if( $this->offsetExists( $theOffset ) )
				{
					//
					// Handle new element.
					//
					$list = $this->offsetGet( $theOffset );
					if( ! in_array( $theValue, $list ) )
					{
						$list[] = $theValue;
						$theValue = $list;
					}
					
					//
					// Handle existing element.
					//
					else
						$theValue = NULL;
				}
				
				//
				// Create new list.
				//
				else
					$theValue = array( $theValue );
			}
		}
		
		return ManageOffset( $this, $theOffset, $theValue, $getOld );				// ==>
	
	} // _ManageListOffset.

	 

} // class CWrapperClient.


?>

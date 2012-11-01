<?php

/**
 * <i>CWrapper</i> class definition.
 *
 * This file contains the class definition of <b>CWrapper</b> which represents a web-service
 * wrapper server.
 *
 *	@package	MyWrapper
 *	@subpackage	Wrappers
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 03/06/2011
 *				2.00 22/02/2012
 */

/*=======================================================================================
 *																						*
 *										CWrapper.php									*
 *																						*
 *======================================================================================*/

/**
 * Types.
 *
 * This include file contains all data type definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_DEFINE."/Types.inc.php" );

/**
 * Global attributes.
 *
 * This include file contains common offset definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_DEFINE."/Attributes.inc.php" );

/**
 * Status.
 *
 * This include file contains all status type definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_DEFINE."/Status.inc.php" );

/**
 * Parsers.
 *
 * This include file contains all parser functions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_FUNCTION."/parsing.php" );

/**
 * Exceptions.
 *
 * This include file contains the {@link CException} class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CException.php" );

/**
 * Ancestor.
 *
 * This include file contains the parent class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CStatusDocument.php" );

/**
 * Local definitions.
 *
 * This include file contains all local definitions to this class.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CWrapper.inc.php" );

/**
 *	Wrapper.
 *
 * This class represents a web-services wrapper server, it is the ancestor of web-service
 * classes in this library.
 *
 * Wrappers are objects that respond to standard web calls and receive parameters in both
 * <i>GET</i> and <i>POST</i> parameters, the main two parameters handled by this class are:
 *
 * <ul>
 *	<li><i>{@link kAPI_FORMAT}</i> (required): The data format of the response,it will be
 *		returned as:
 *	 <ul>
 *		<li><i>{@link kTYPE_PHP}</i>: A PHP-serialised string.
 *		<li><i>{@link kTYPE_JSON}</i>: A JSON-serialised string.
 *	 </ul>
 *	<li><i>{@link kAPI_OPERATION}</i> (required): The requested operation, each class will
 *		implement specialised handlers, this class only implements the following two
 *		operations:
 *	 <ul>
 *		<li><i>{@link kAPI_OP_HELP}</i>: A <i>LIST-OP</i> command, this command will return
 *			in the {@link kAPI_RESPONSE} section the list of supported operations as an
 *			array structured as follows:
 *		 <ul>
 *			<li><i>index</i>: The index will be the operation code.
 *			<li><i>value</i>: The value will be the operation description.
 *		 </ul>
 *		<li><i>{@link kAPI_OP_PING}</i>: A <i>PING</i> command, this can be used to check if
 *			a service is alive.
 *	 </ul>
 * </ul>
 *
 * If both the above parameters are present, the service will return an array constituted by
 * the following three sections:
 *
 * <ul>
 *	<li><i>{@link kAPI_STATUS}</i>: <i>Operation status</i>.
 *		This section is returned by default and will inform on the status of the requested
 *		operation. It consists of an array containing the following elements:
 *	 <ul>
 *		<li><i>{@link kOFFSET_SEVERITY}</i>: <i>Response status</i>.
 *			This element will be returned by default regardless of the operation outcome.
 *			This corresponds to the severity of the response and it can take the following
 *			values:
 *		 <ul>
 *			<li><i>{@link kMESSAGE_TYPE_IDLE}</i>: This is the status of the web-service
 *				before any operation has been executed, or when the operation was
 *				successful; this is the response of a successful {@link kAPI_OP_PING}
 *				request.
 *			<li><i>{@link kMESSAGE_TYPE_NOTICE}</i>: The operation was successful and a
 *				notice message was returned.
 *			<li><i>{@link kMESSAGE_TYPE_MESSAGE}</i>: The operation was successful and a
 *				message was returned.
 *			<li><i>{@link kMESSAGE_TYPE_WARNING}</i>: The operation was successful but a
 *				warning was raised.
 *			<li><i>{@link kMESSAGE_TYPE_ERROR}</i>: The operation failed because of an
 *				error.
 *			<li><i>{@link kMESSAGE_TYPE_FATAL}</i>: The operation failed because of a fatal
 *				error, this will generally mean that the web-service is not operational.
 *			<li><i>{@link kMESSAGE_TYPE_BUG}</i>: The operation failed because of a bug, the
 *				developers should be informed of this kind of errors.
 *		 </ul>
 *		<li><i>{@link kOFFSET_CODE}</i>: <i>Status code</i>.
 *			This element will be returned by default regardless of the operation outcome.
 *			It corresponds to the error code; {@link kERROR_OK} means no error.
 *		<li><i>{@link kOFFSET_MESSAGE}</i>: <i>Status message</i>.
 *			The response message from the operation, this element is used to return
 *			informative messages or to return error messages when the service fails. It will
 *			generally be formatted as an array structured as follows:
 *		 <ul>
 *			<li><i>{@link kOFFSET_LANGUAGE}</i>: The language ISO 639 2
 *				character code in which the message is expressed in.
 *			<li><i>{@link kOFFSET_STRING}</i>: The actual message data contents.
 *		 </ul>
 *		<li><i>{@link kAPI_AFFECTED_COUNT}</i>: <i>Record count</i>.
 *			The total number of elements affected by the operation. This tag will only be
 *			used by derived classes returning data elements.
 *		<li><i>{@link kOFFSET_NOTES}</i>: <i>Attachments</i>.
 *				A list of key/value pairs containing information relevant to the operation
 *				response. For instance, if a series of parameters are required and were not
 *				provided, this could list them.
 *	 </ul>
 *	<li><i>{@link kAPI_REQUEST}</i>: <i>Service request</i>.
 *		This section will return the actual request provided to the service, this can be
 *		used for debugging purposes and will only occur if the optional
 *		{@link kAPI_LOG_REQUEST} parameter has been set to 1.
 *	<li><i>{@link kAPI_STAMP}</i>: <i>Timers</i>.
 *		This section holds timing information, it will be returned only if you provide the
 *		time of day [<i>gettimeofday( TRUE )</i>] in the
 *		{@link kAPI_STAMP_REQUEST} parameter. This section is structured as follows:
 *	 <ul>
 *		<li><i>{@link kAPI_STAMP_REQUEST}</i>: Request time stamp, the time in which the request
 *			was sent; this is the same value sent by the caller in the
 *			{@link kAPI_STAMP_REQUEST} parameter.
 *		<li><i>{@link kAPI_STAMP_PARSE}</i>: Parse time stamp, the time in which the service
 *			finished parsing the request.
 *		<li><i>{@link kAPI_STAMP_SENT}</i>: Response time stamp, the time in which the
 *			response was sent.
 *	 </ul>
 *	<li><i>{@link kAPI_RESPONSE}</i>: Response, this section will hold the operation
 *		response, in this class we only respond to {@link kAPI_OP_HELP} list requests.
 * </ul>
 *
 * Besides the {@link kAPI_FORMAT} and {@link kAPI_OPERATION} parameters described in the
 * first section, we have three other optional parameters that can be used to receive
 * specific information sections in the response:
 *
 * <ul>
 *	<li><i>{@link kAPI_LOG_REQUEST}</i>: Log the request, if the value of this parameter
 *		is 1, the response will contain the received request in the
 *		{@link kAPI_REQUEST} section.
 *	<li><i>{@link kAPI_LOG_TRACE}</i>: Trace exceptions, if the value of this parameter
 *		is 1, in the case of an error that triggered an exception, the error response will
 *		also include the call trace.
 *	<li><i>{@link kAPI_STAMP_REQUEST}</i>: This parameter should hold the timestamp
 *		[<i>gettimeofday( TRUE )</i>] in which the client has sent the request, if provided,
 *		the service will return the timing information in the {@link kAPI_STAMP}
 *		section.
 * </ul>
 *
 * The parameters are expected either in <i>GET</i> or <i>POST</i>.
 *
 * If either the {@link kAPI_FORMAT} or the {@link kAPI_OPERATION} parameters are omitted
 * from the request, the service will return an empty response; this is to prevent
 * unnecessary traffic.
 *
 * Instances of this class can be considered server objects, and can be implemented with
 * this simple code snippet:
 *
 * <code>
 * $server = new CWrapper();
 * $server->HandleRequest();
 * </code>
 *
 * An example of this class implementation can be found in the
 * {@link Wrapper.php} source file.
 *
 *	@package	MyWrapper
 *	@subpackage	Wrappers
 */
class CWrapper extends CStatusDocument
{
	/**
	 * Reception time-stamp.
	 *
	 * This data member holds the request reception time stamp.
	 *
	 * @var integer
	 */
	 protected $mReceivedStamp = NULL;

		

/*=======================================================================================
 *																						*
 *										MAGIC											*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	__construct																		*
	 *==================================================================================*/

	/**
	 * Instantiate class.
	 *
	 * The constructor will set-up the environment and parse the request.
	 * The workflow is as follows:
	 *
	 * <ul>
	 *	<li><i>Check required elements</i>: The method will check if all required elements
	 *		of the request are there, only if this is the case will the constructor init the
	 *		service.
	 *	<li><i>{@link _InitStatus()}</i>: The response status will be initialised to the
	 *		{@link kMESSAGE_TYPE_IDLE} state.
	 *	<li><i>{@link _InitOptions()}</i>: Service options will be initialised.
	 *	<li><i>{@link _InitResources()}</i>: Eventual resources are initialised.
	 *	<li><i>{@link _ParseRequest()}</i>: The request is parsed.
	 *	<li><i>{@link _FormatRequest()}</i>: The request is normalised if necessary.
	 *	<li><i>{@link _ValidateRequest()}</i>: The request is validated.
	 * </ul>
	 *
	 * This protected interface should be overloaded by derived classes to implement custom
	 * services.
	 *
	 * @access public
	 *
	 * @uses _InitStatus()
	 * @uses _InitOptions()
	 * @uses _InitResources()
	 * @uses _ParseRequest()
	 * @uses _FormatRequest()
	 * @uses _ValidateRequest()
	 * @uses _Exception2Status()
	 * @uses _EncodeResponse()
	 */
	public function __construct()
	{
		//
		// Check dependencies.
		//
		if( isset( $_REQUEST )									// Has request
		 && count( $_REQUEST )									// and request not empty
		 && array_key_exists( kAPI_FORMAT, $_REQUEST )			// and has formst
		 && array_key_exists( kAPI_OPERATION, $_REQUEST ) )		// and has operation.
		{
			//
			// Set reception time.
			//
			$this->mReceivedStamp = gettimeofday( TRUE );
			
			//
			// TRY BLOCK
			//
			try
			{
				//
				// Instantiate object.
				//
				parent::__construct();
			
				//
				// Initialise service.
				//
				$this->_InitStatus();
				$this->_InitOptions();
				$this->_InitResources();
				
				//
				// Parse and validate request.
				//
				$this->_ParseRequest();
				$this->_FormatRequest();
				$this->_ValidateRequest();
					
				//
				// Set parsed timer.
				//
				if( $this->offsetExists( kAPI_STAMP ) )
					$this->_OffsetManage
						( kAPI_STAMP, kAPI_STAMP_PARSE, gettimeofday( TRUE ) );
				
				//
				// Set inited status.
				//
				$this->_IsInited( TRUE );
			}
			
			//
			// CATCH BLOCK
			//
			catch( Exception $error )
			{
				//
				// Load exception in status.
				//
				$this->_Exception2Status( $error );
				
				//
				// Return result.
				// Note the exit: if I put echo, the constructor will raise an exception
				// and when I call HandleRequest() another exception is raised, which gives
				// us two unconnected JSONs.
				//
				exit( $this->_EncodeResponse() );									// ==>
			}
		
		} // Has required elements.

	} // Constructor.

		

/*=======================================================================================
 *																						*
 *							PUBLIC REQUEST HANDLER INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	HandleRequest																	*
	 *==================================================================================*/

	/**
	 * Handle the request.
	 *
	 * This method will handle the request.
	 *
	 * Note that we only run the method if the object is {@link _IsInited()}, if this
	 * is not the case, the method will do nothing.
	 *
	 * @access public
	 *
	 * @uses _HandleRequest()
	 * @uses _Exception2Status()
	 * @uses _EncodeResponse()
	 */
	public function HandleRequest()
	{
		//
		// Check object status.
		//
		if( $this->_isInited() )
		{
			//
			// TRY BLOCK
			//
			try
			{
				//
				// Perform request.
				//
				$this->_HandleRequest();
			}
			
			//
			// CATCH BLOCK
			//
			catch( Exception $error )
			{
				//
				// Load exception in status.
				//
				$this->_Exception2Status( $error );
			}
		
			//
			// Set sent timer.
			//
			if( $this->offsetExists( kAPI_STAMP ) )
				$this->_OffsetManage( kAPI_STAMP,
									  kAPI_STAMP_SENT,
									  gettimeofday( TRUE ) );
			
			//
			// Return result.
			//
			echo( $this->_EncodeResponse() );
		
		} // Object is inited.
	
	} // HandleRequest.

		

/*=======================================================================================
 *																						*
 *							PROTECTED INITIALISATION INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_InitStatus																		*
	 *==================================================================================*/

	/**
	 * Initialise status.
	 *
	 * This method is responsible for initialising the {@link kAPI_STATUS}
	 * section, derived classes may overload this method if they need to handle other
	 * states.
	 *
	 * In this class we set the status to {@link kMESSAGE_TYPE_IDLE} and reset the
	 * status {@link kOFFSET_CODE}.
	 *
	 * @access protected
	 *
	 * @see kAPI_STATUS
	 */
	protected function _InitStatus()
	{
		//
		// Init local storage.
		//
		$status = Array();
		
		//
		// Set state.
		//
		$status[ kOFFSET_SEVERITY ] = kMESSAGE_TYPE_IDLE;
		
		//
		// Set idle status code.
		//
		$status[ kOFFSET_CODE ] = 0;
		
		//
		// Copy status to object.
		//
		$this->offsetSet( kAPI_STATUS, $status );
	
	//
	// In derived classes.
	//
	//	//
	//	// Call parent method.
	//	//
	//	parent::_InitStatus();
	//
	//	//
	//	// Set custom status elements.
	//	//
	//	...
	//
	
	} // _InitStatus.

	 
	/*===================================================================================
	 *	_InitOptions																	*
	 *==================================================================================*/

	/**
	 * Initialise options.
	 *
	 * This method is responsible for parsing and setting all default and provided options,
	 * derived classes should overload this method to handle custom options.
	 *
	 * In this class we initialise the {@link kAPI_REQUEST} and
	 * {@link kAPI_STAMP} sections if required.
	 *
	 * @access protected
	 *
	 * @see kAPI_REQUEST kAPI_STAMP
	 */
	protected function _InitOptions()
	{
		//
		// Check request log option.
		//
		if( array_key_exists( kAPI_LOG_REQUEST, $_REQUEST )
		 && $_REQUEST[ kAPI_LOG_REQUEST ] )
			$this->offsetSet( kAPI_REQUEST, Array() );
	
		//
		// Check timing option.
		//
		if( array_key_exists( kAPI_STAMP_REQUEST, $_REQUEST ) )
			$this->offsetSet( kAPI_STAMP, Array() );
	
	//
	// In derived classes.
	//
	//	//
	//	// Call parent method.
	//	//
	//	parent::_InitOptions();
	//
	//	//
	//	// Set custom options.
	//	//
	//	...
	//
	
	} // _InitOptions.

	 
	/*===================================================================================
	 *	_InitResources																	*
	 *==================================================================================*/

	/**
	 * Initialise resources.
	 *
	 * In derived classes this should be the method that initialises the data store
	 * resources, in this class we have no resources.
	 *
	 * @access protected
	 */
	protected function _InitResources()														{}

		

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
	 * In this class we handle the {@link kAPI_FORMAT}, {@link kAPI_OPERATION} and
	 * {@link kAPI_STAMP} elements.
	 *
	 * @access protected
	 *
	 * @uses _ParseFormat()
	 * @uses _ParseOperation()
	 * @uses _ParseTiming()
	 */
	protected function _ParseRequest()
	{
		//
		// Parse request parameters.
		//
		$this->_ParseFormat();
		$this->_ParseOperation();
		$this->_ParseTiming();
	
	//
	// In derived classes.
	//
	//	//
	//	// Call parent method.
	//	//
	//	parent::_ParseRequest();
	//
	//	//
	//	// Parse custom parameters.
	//	//
	//	...
	//
	
	} // _ParseRequest.

	 
	/*===================================================================================
	 *	_FormatRequest																	*
	 *==================================================================================*/

	/**
	 * Format request.
	 *
	 * This method should perform any needed formatting before the request will be handled.
	 *
	 * In this class we do nothing.
	 *
	 * @access protected
	 */
	protected function _FormatRequest()	
	{
	//
	// In derived classes.
	//
	//	//
	//	// Call parent method.
	//	//
	//	parent::_FormatRequest();
	//
	//	//
	//	// Format custom parameters.
	//	//
	//	...
	//
	
	} // _FormatRequest.

	 
	/*===================================================================================
	 *	_ValidateRequest																*
	 *==================================================================================*/

	/**
	 * Validate request.
	 *
	 * This method should check that the request is valid and that all required parameters
	 * have been received.
	 *
	 * In this class we check the {@link kAPI_FORMAT} and {@link kAPI_OPERATION} codes
	 * (their presence is checked by the constructor.
	 *
	 * @access protected
	 *
	 * @uses _ValidateFormat()
	 * @uses _ValidateOperation()
	 */
	protected function _ValidateRequest()
	{
		//
		// Validate parameters.
		//
		$this->_ValidateFormat();
		$this->_ValidateOperation();
	
	//
	// In derived classes.
	//
	//	//
	//	// Call parent method.
	//	//
	//	parent::_ValidateRequest();
	//
	//	//
	//	// Validate custom parameters.
	//	//
	//	...
	//
	
	} // _ValidateRequest.

		

/*=======================================================================================
 *																						*
 *								PROTECTED PARSING UTILITIES								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_ParseFormat																	*
	 *==================================================================================*/

	/**
	 * Parse format.
	 *
	 * This method will parse the request format.
	 *
	 * @access protected
	 *
	 * @see kAPI_REQUEST kAPI_FORMAT
	 */
	protected function _ParseFormat()
	{
		//
		// Note: the web service exits if either the format or the operation are missing.
		//
		
		//
		// Log format to request.
		//
		if( $this->offsetExists( kAPI_REQUEST ) )
			$this->_OffsetManage
				( kAPI_REQUEST, kAPI_FORMAT, $_REQUEST[ kAPI_FORMAT ] );
	
	} // _ParseFormat.

	 
	/*===================================================================================
	 *	_ParseOperation																	*
	 *==================================================================================*/

	/**
	 * Parse operation.
	 *
	 * This method will parse the request operation.
	 *
	 * @access protected
	 *
	 * @see kAPI_REQUEST kAPI_OPERATION
	 */
	protected function _ParseOperation()
	{
		//
		// Note: the web service exits if either the format or the operation are missing.
		//
		
		//
		// Log operation to request.
		//
		if( $this->offsetExists( kAPI_REQUEST ) )
			$this->_OffsetManage
				( kAPI_REQUEST, kAPI_OPERATION, $_REQUEST[ kAPI_OPERATION ] );
	
	} // _ParseOperation.

	 
	/*===================================================================================
	 *	_ParseTiming																	*
	 *==================================================================================*/

	/**
	 * Parse timing.
	 *
	 * This method will parse the request timers.
	 *
	 * @access protected
	 *
	 * @see kAPI_REQUEST kAPI_STAMP_REQUEST
	 */
	protected function _ParseTiming()
	{
		//
		// Note: the kAPI_STAMP offset was created by _InitOptions().
		//
		
		//
		// Handle timing.
		//
		if( $this->offsetExists( kAPI_STAMP ) )
		{
			//
			// Log request time to request.
			//
			if( $this->offsetExists( kAPI_REQUEST ) )
				$this->_OffsetManage
					( kAPI_REQUEST, kAPI_STAMP_REQUEST, $_REQUEST[ kAPI_STAMP_REQUEST ] );
			
			//
			// Init timers block.
			//
			$options = Array();
			$options[ kAPI_STAMP_REQUEST ] = $_REQUEST[ kAPI_STAMP_REQUEST ];
			$options[ kAPI_STAMP_REC ] = $this->mReceivedStamp;
			$this->offsetSet( kAPI_STAMP, $options );
		
		} // Log timers.
	
	} // _ParseTiming.

		

/*=======================================================================================
 *																						*
 *							PROTECTED VALIDATION UTILITIES								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_ValidateFormat																	*
	 *==================================================================================*/

	/**
	 * Validate request format.
	 *
	 * This method can be used to check whether the provided {@link kAPI_FORMAT}
	 * parameter is valid.
	 *
	 * @access protected
	 *
	 * @see kTYPE_PHP kTYPE_JSON
	 */
	protected function _ValidateFormat()
	{
		//
		// Check parameter.
		//
		switch( $_REQUEST[ kAPI_FORMAT ] )
		{
			//
			// Valid formats.
			//
			case kTYPE_PHP:
			case kTYPE_JSON:
				break;
			
			//
			// Handle unknown formats.
			//
			default:
				throw new CException
					( "Unsupported format",
					  kERROR_UNSUPPORTED,
					  kMESSAGE_TYPE_WARNING,
					  array( 'Parameter' => kAPI_FORMAT,
							 'Value' => $_REQUEST[ kAPI_FORMAT ] ) );			// !@! ==>
			
		} // Parsing parameter.
	
	//
	// In derived classes.
	//
	//	//
	//	// Check parameter.
	//	//
	//	switch( $theParameter )
	//	{
	//		case [custom]:
	//			Handle it here.
	//			break;
	//
	//		default:
	//			parent::_ValidateFormat();
	//			break;
	//	}
	//
	
	} // _ValidateFormat.

	 
	/*===================================================================================
	 *	_ValidateOperation																*
	 *==================================================================================*/

	/**
	 * Validate request operation.
	 *
	 * This method can be used to check whether the provided
	 * {@link kAPI_OPERATION} parameter is valid.
	 *
	 * @access protected
	 *
	 * @see kAPI_OP_HELP kAPI_OP_PING
	 */
	protected function _ValidateOperation()
	{
		//
		// Check parameter.
		//
		switch( $_REQUEST[ kAPI_OPERATION ] )
		{
			//
			// Valid formats.
			//
			case kAPI_OP_HELP:
			case kAPI_OP_PING:
				break;
			
			//
			// Handle unknown operation.
			//
			default:
				throw new CException
					( "Unsupported operation",
					  kERROR_UNSUPPORTED,
					  kMESSAGE_TYPE_WARNING,
					  array( 'Parameter' => kAPI_OPERATION,
							 'Value' => $_REQUEST[ kAPI_OPERATION ] ) );		// !@! ==>
			
		} // Parsing parameter.
	
	//
	// In derived classes.
	//
	//	//
	//	// Check parameter.
	//	//
	//	switch( $theParameter )
	//	{
	//		case [custom]:
	//			Handle it here.
	//			break;
	//
	//		default:
	//			parent::_ValidateFormat( $theParameter );
	//			break;
	//	}
	//
	
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
	 *
	 * @uses _Handle_ListOp()
	 *
	 * @see kAPI_OP_HELP kAPI_OP_PING
	 */
	protected function _HandleRequest()
	{
		//
		// Parse by operation.
		//
		switch( $op = $_REQUEST[ kAPI_OPERATION ] )
		{
			case kAPI_OP_HELP:
				$list = Array();
				$this->_Handle_ListOp( $list );
				if( count( $list ) )
					$this->offsetSet( kAPI_RESPONSE, $list );
				break;

			case kAPI_OP_PING:
				$this->_Handle_Ping();
				break;

			default:
				throw new CException
					( "Unable to handle request: operation not implemented",
					  kERROR_NOT_IMPLEMENTED,
					  kMESSAGE_TYPE_WARNING,
					  array( 'Operation' => $op ) );							// !@! ==>
		}
	
	} // _HandleRequest.

	 
	/*===================================================================================
	 *	_Handle_ListOp																	*
	 *==================================================================================*/

	/**
	 * Handle {@link kAPI_OP_HELP} operations request.
	 *
	 * This method will handle the {@link kAPI_OP_HELP} request, which
	 * should return the list of supported operations.
	 *
	 * @param reference				$theList			Receives operations list.
	 *
	 * @access protected
	 */
	protected function _Handle_ListOp( &$theList )
	{
		//
		// Add kAPI_OP_HELP.
		//
		$theList[ kAPI_OP_HELP ]
			= 'List operations: returns the list of supported operations.';
	
		//
		// Add kAPI_OP_PING.
		//
		$theList[ kAPI_OP_PING ]
			= 'A PING command, this can be used to check if a service is alive.';
	
	} // _Handle_ListOp.

		
	/*===================================================================================
	 *	_Handle_Ping																	*
	 *==================================================================================*/

	/**
	 * Handle {@link kAPI_OP_PING} request.
	 *
	 * This method will handle the {@link kAPI_OP_PING} request, which can be used to check
	 * if a service is alive.
	 *
	 * The ping request will return by default the {@link kAPI_STATUS} block.
	 *
	 * @access protected
	 */
	protected function _Handle_Ping()	{}

		

/*=======================================================================================
 *																						*
 *							PROTECTED OFFSET ACCESSOR INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_OffsetManage																	*
	 *==================================================================================*/

	/**
	 * Manage offset.
	 *
	 * This method can be used to manage elements within offsets, in other words, it can be
	 * used to manage elements within an offset:
	 *
	 * <ul>
	 *	<li><b>$theBlock</b>: The main offset.
	 *	<li><b>$theElement</b>: The offset within the main offset.
	 *	<li><b>$theValue</b>: The new value or the operation:
	 *	 <ul>
	 *		<li><i>NULL</i>: Retrieve the element in the block.
	 *		<li><i>FALSE</i>: Delete the element from the block.
	 *		<li><i>other</i>: All other data types are interpreted as a new element.
	 *	 </ul>
	 * </ul>
	 *
	 * @param string				$theBlock			Object block.
	 * @param string				$theElement			Object block element.
	 * @param mixed					$theValue			Element value.
	 *
	 * @access protected
	 */
	protected function _OffsetManage( $theBlock, $theElement, $theValue = NULL )
	{
		//
		// Get paging options.
		//
		$block = $this->offsetGet( $theBlock );
		
		//
		// Return current value.
		//
		if( $theValue === NULL )
		{
			//
			// Check paging block.
			//
			if( $block !== NULL )
				return ( array_key_exists( $theElement, $block ) )
					 ? $block[ $theElement ]										// ==>
					 : NULL;														// ==>
			
			return NULL;															// ==>
		
		} // Return current value.
		
		//
		// Delete current value.
		//
		if( $theValue === FALSE )
		{
			//
			// Check paging block.
			//
			if( $block !== NULL )
			{
				//
				// Check start tag.
				//
				if( array_key_exists( $theElement, $block ) )
				{
					//
					// Save value.
					//
					$save = $block[ $theElement ];
					
					//
					// Unset value.
					//
					unset( $block[ $theElement ] );
					
					//
					// Clear paging block.
					//
					if( ! count( $block ) )
						$this->offsetUnset( $theBlock );
					
					//
					// Replace paging options.
					//
					else
						$this->offsetSet( $theBlock, $block );
					
					return $save;													// ==>
				
				} // Has tag.
				
				return NULL;														// ==>
			
			} // Has paging block.
			
			return NULL;															// ==>
		
		} // Delete current value.
		
		//
		// Create value.
		//
		if( $block === NULL )
		{
			//
			// Create block.
			//
			$this->offsetSet( $theBlock, array( $theElement => $theValue ) );
			
			return NULL;															// ==>
		
		} // New paging block.
		
		//
		// Save value.
		//
		$save = ( array_key_exists( $theElement, $block ) )
			  ? $block[ $theElement ]
			  : NULL;

		//
		// Set value.
		//
		$block[ $theElement ] = $theValue;
		
		//
		// Replace paging options.
		//
		$this->offsetSet( $theBlock, $block );
		
		return $save;																// ==>
	
	} // _OffsetManage.

		

/*=======================================================================================
 *																						*
 *							PROTECTED FORMATTING INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_Exception2Status																*
	 *==================================================================================*/

	/**
	 * Set status from exception.
	 *
	 * This method can be used to set the service status according to an exception:
	 *
	 * <ul>
	 *	<li><i>{@link CException::Severity()}</i>: This value will be set as the status
	 *		{@link kOFFSET_SEVERITY}.
	 *	<li><i>{@link Exception::getCode()}</i>: This value will be set as the status
	 *		{@link kOFFSET_CODE}.
	 *	<li><i>{@link Exception::getMessage()}</i>: This value will be set in the status
	 *		{@link kOFFSET_MESSAGE} field as a language block.
	 *	<li><i>{@link Exception::getFile()}</i>: This value will be set in the status
	 *		{@link kOFFSET_NOTES}.
	 *	<li><i>{@link Exception::getLine()}</i>: This value will be set in the status
	 *		{@link kOFFSET_NOTES}.
	 *	<li><i>{@link Exception::getTrace()}</i>: This value will be set in the status
	 *		{@link kOFFSET_NOTES}.
	 *	<li><i>{@link CException::Reference()}</i>: These valuew will be set in the status
	 *		{@link kOFFSET_NOTES}.
	 * </ul>
	 *
	 * @param Exception				$theException		Exception.
	 *
	 * @access protected
	 */
	protected function _Exception2Status( Exception $theException )
	{
		//
		// Init status.
		//
		$status = Array();
		
		//
		// Set exception code.
		//
		if( ($tmp = $theException->getCode()) !== NULL )
			$status[ kOFFSET_CODE ] = $tmp;
		
		//
		// Set exception message.
		//
		if( ($tmp = $theException->getMessage()) !== NULL )
			$status[ kOFFSET_MESSAGE ]
				= array( array( kOFFSET_LANGUAGE => kDEFAULT_LANGUAGE,
								kOFFSET_STRING => $tmp ) );
		
		//
		// Set exception trace.
		//
		if( array_key_exists( kAPI_LOG_TRACE, $_REQUEST )
		 && $_REQUEST[ kAPI_LOG_TRACE ] )
		{
			//
			// Get trace parameters.
			//
			$file = $theException->getFile();
			$line = $theException->getLine();
			$trace = $theException->getTrace();
			
			//
			// Check trace parameters.
			//
			if( ($file !== NULL)
			 || ($line !== NULL)
			 || ($trace !== NULL) )
			{
				$status[ kOFFSET_NOTES ] = Array();
				if( $file !== NULL )
					$status[ kOFFSET_NOTES ][ 'File' ] = $file;
				if( $line !== NULL )
					$status[ kOFFSET_NOTES ][ 'Line' ] = $line;
				if( $trace !== NULL )
					$status[ kOFFSET_NOTES ][ 'Trace' ] = $trace;
			
			} // Has trace elements.
		
		} // Log exception trace.
		
		//
		// Handle custom exception fields.
		//
		if( $theException instanceof CException )
		{
			if( ($tmp = $theException->Severity()) !== NULL )
				$status[ kOFFSET_SEVERITY ] = $tmp;
			if( $tmp = $theException->Reference() )
			{
				if( ! array_key_exists( kOFFSET_NOTES, $status ) )
					$status[ kOFFSET_NOTES ] = Array();
				if( $references = $theException->Reference() )
				{
					foreach( $references as $key => $value )
						$status[ kOFFSET_NOTES ][ $key ] = $value;
				}
			}
		
		} // Custom exception.
		
		//
		// Set status.
		//
		$this->offsetSet( kAPI_STATUS, $status );
	
	} // _Exception2Status.

	 
	/*===================================================================================
	 *	_EncodeResponse																	*
	 *==================================================================================*/

	/**
	 * Encode response.
	 *
	 * This method will return the encoded response string.
	 *
	 * @access protected
	 * @return string|NULL
	 */
	protected function _EncodeResponse()
	{
		//
		// Determine format.
		//
		$format = ( array_key_exists( kAPI_FORMAT, $_REQUEST ) )
				? $_REQUEST[ kAPI_FORMAT ]
				: kTYPE_JSON;
		
		//
		// Parse by format.
		//
		switch( $format )
		{
			case kTYPE_PHP:
				return serialize( $this->getArrayCopy() );							// ==>

			case kTYPE_JSON:
				try
				{
					return JsonEncode( $this->getArrayCopy() );						// ==>
				}
				catch( Exception $error )
				{
					if( $error instanceof CException )
						$error->Reference( 'Response', $this->getArrayCopy() );
					
					throw $error;												// !@! ==>
				}
		}
		
		return NULL;																// ==>
	
	} // _EncodeResponse.

	 

} // class CWrapper.


?>

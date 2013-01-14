<?php

/**
 * <i>CPortalWrapper</i> class definition.
 *
 * This file contains the class definition of <b>CPortalWrapper</b> which overloads its
 * ancestor to implement a generic portal wrapper.
 *
 *	@package	MyWrapper
 *	@subpackage	Wrappers
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 14/12/2012
 */

/*=======================================================================================
 *																						*
 *									CPortalWrapper.php									*
 *																						*
 *======================================================================================*/

/**
 * Ancestor.
 *
 * This include file contains the parent class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntologyWrapper.php" );

/**
 * Local definitions.
 *
 * This include file contains all local definitions to this class.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CPortalWrapper.inc.php" );

/**
 * <h4>Portal wrapper</h4>
 *
 * This class overloads its ancestor to implement a series of general purpose frameworks.
 *
 * The class adds the following set of parameters:
 *
 * <ul>
 *	<li><i>Request parameters</i>: These parameters refer to the parameters that the service
 *		expects:
 *	 <ul>
 *		<li><i>{@link kAPI_CREDENTIALS}</i>: <i>Credentials</i>, this offset tag will be
 *			used to provide login or operation credentials, the parameter is expected to be
 *			an array whose structure depends on the operation.
 *	 </ul>
 *	<li><i>Operations</i>: This class adds the following operations:
 *	 <ul>
 *		<li><i>{@link kAPI_OP_Login}</i>: <i>Login</i>, this operation will return the user
 *			record corresponding to the provided {@link kAPI_CREDENTIALS} credentials
 *			parameter. The operation expects the following parameters:
 *		 <ul>
 *			<li><i>{@link kAPI_FORMAT}</i>: This parameter is required to indicate how to
 *				encode the response.
 *			<li><i>{@link kAPI_DATABASE}</i>: This parameter is required to indicate the
 *				working database.
 *			<li><i>{@link kAPI_CONTAINER}</i>: This optional parameter is used to indicate
 *				the working container in case of a non-standard configuration.
 *			<li><i>{@link kAPI_CREDENTIALS}</i>: This parameter is required for validating
 *				the user:
 *			 <ul>
 *				<li><tt>{@link kAPI_CREDENTIALS_CODE}</tt>: User code.
 *				<li><tt>{@link kAPI_CREDENTIALS_PASS}</tt>: User password.
 *			 </ul>
 *				Note that these parameters may grow in derived classes, this represents the
 *				bare minimum.
 *		 </ul>
 *		<li><i>{@link kAPI_OP_NewUser}</i>: <i>New user</i>, this operation will create a
 *			new user, it expects a set of attributes representing the new user's properties.
 *		 <ul>
 *			<li><i>{@link kAPI_FORMAT}</i>: This parameter is required to indicate how to
 *				encode the response.
 *			<li><i>{@link kAPI_DATABASE}</i>: This parameter is required to indicate the
 *				working database.
 *			<li><i>{@link kAPI_OBJECT}</i>: This parameter should contain the attributes of
 *				the new user.
 *		 </ul>
 *	 </ul>
 * </ul>
 *
 *	@package	MyWrapper
 *	@subpackage	Wrappers
 */
class CPortalWrapper extends COntologyWrapper
{
	/**
	 * <b>Parameters list</b>
	 *
	 * This static data member holds the list of parameters known by the service, these will
	 * be decoded before the service will handle them.
	 *
	 * @var array
	 */
	 static $sParameterList = array( kAPI_CREDENTIALS );

		

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
	 * @uses _ParseCredentials()
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
		$this->_ParseCredentials();
	
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
	 * @uses _FormatCredentials()
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
		$this->_FormatCredentials();
	
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
	 * @uses _ValidateCredentials()
	 * @uses _ValidateNewUser()
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
		$this->_ValidateCredentials();
		$this->_ValidateNewUser();
	
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
	 * We overload this method to perform the following customisations:
	 *
	 * <ul>
	 *	<li><tt>{@link kAPI_OP_Login}</tt>: This operation implies that the container be the
	 *		default users container.
	 *	<li><tt>{@link kAPI_OP_NewUser}</tt>: Same as above.
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
			case kAPI_OP_Login:
			case kAPI_OP_NewUser:
				//
				// Set users container.
				//
				if( ! array_key_exists( kAPI_CONTAINER, $_REQUEST ) )
					$_REQUEST[ kAPI_CONTAINER ] = CUser::DefaultContainerName();

				break;
		}
	
	} // _ParseOperation.

	 
	/*===================================================================================
	 *	_ParseCredentials																*
	 *==================================================================================*/

	/**
	 * Parse credentials.
	 *
	 * This method will copy the credentials parameter to the request block.
	 *
	 * @access protected
	 *
	 * @uses _OffsetManage()
	 *
	 * @see kAPI_CREDENTIALS kAPI_REQUEST
	 */
	protected function _ParseCredentials()
	{
		//
		// Handle database.
		//
		if( array_key_exists( kAPI_CREDENTIALS, $_REQUEST ) )
		{
			if( $this->offsetExists( kAPI_REQUEST ) )
				$this->_OffsetManage
					( kAPI_REQUEST, kAPI_CREDENTIALS, $_REQUEST[ kAPI_CREDENTIALS ] );
		}
	
	} // _ParseCredentials.

		

/*=======================================================================================
 *																						*
 *							PROTECTED FORMATTING UTILITIES								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_FormatCredentials																*
	 *==================================================================================*/

	/**
	 * Format credentials parameters.
	 *
	 * This method should format the provided credentials, in this class we do nothing.
	 *
	 * @access protected
	 *
	 * @see kAPI_CREDENTIALS
	 */
	protected function _FormatCredentials()												   {}

		

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
		switch( $parameter = $_REQUEST[ kAPI_OPERATION ] )
		{
			case kAPI_OP_Login:
				//
				// Check for credentials.
				//
				if( ! array_key_exists( kAPI_CREDENTIALS, $_REQUEST ) )
					throw new CException
						( "Missing credentials parameter",
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
			
			case kAPI_OP_NewUser:
				//
				// Check for user object.
				//
				if( ! array_key_exists( kAPI_OBJECT, $_REQUEST ) )
					throw new CException
						( "Missing user attributes parameter",
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
	 *	_ValidateCredentials															*
	 *==================================================================================*/

	/**
	 * Validate credentials parameters.
	 *
	 * The duty of this method is to validate the credentials parameter, in this class we
	 * perform checks according to the operation:
	 *
	 * <ul>
	 *	<li><tt>{@link kAPI_OP_Login}</tt>: We ensure that the
	 *		<tt>code</tt> and <tt>pass</tt> elements are in the array.
	 * </ul>
	 *
	 * @access protected
	 *
	 * @see kAPI_CREDENTIALS
	 */
	protected function _ValidateCredentials()
	{
		//
		// Handle credentials.
		//
		if( array_key_exists( kAPI_CREDENTIALS, $_REQUEST ) )
		{
			//
			// Check parameter.
			//
			if( is_array( $_REQUEST[ kAPI_CREDENTIALS ] ) )
			{
				//
				// Parse by operation.
				//
				switch( $_REQUEST[ kAPI_OPERATION ] )
				{
					case kAPI_OP_Login:
						if( ! array_key_exists( kAPI_CREDENTIALS_CODE,
												$_REQUEST[ kAPI_CREDENTIALS ] ) )
							throw new CException
								( "Unable to login: missing user code",
								  kERROR_PARAMETER,
								  kSTATUS_ERROR );								// !@! ==>
						if( ! array_key_exists( kAPI_CREDENTIALS_PASS,
												$_REQUEST[ kAPI_CREDENTIALS ] ) )
							throw new CException
								( "Unable to login: missing user password",
								  kERROR_PARAMETER,
								  kSTATUS_ERROR );								// !@! ==>
						break;
				}
		
			} // Correct type.
		
			else
				throw new CException
					( "Unable to login: invalid credentials data type",
					  kERROR_PARAMETER,
					  kSTATUS_ERROR,
					  array( 'Type'
						=> gettype( $_REQUEST[ kAPI_CREDENTIALS ] ) ) );		// !@! ==>
		
		} // Provided credentials.
	
	} // _ValidateCredentials.

	 
	/*===================================================================================
	 *	_ValidateNewUser																*
	 *==================================================================================*/

	/**
	 * Validate new user.
	 *
	 * The duty of this method is to validate the provided user attributes, found in the
	 * {@link kAPI_OBJECT} parameter, the method will do so by creating a {@link CUser}
	 * object and adding the provided attributes to it.
	 *
	 * @access protected
	 *
	 * @see kAPI_OBJECT
	 */
	protected function _ValidateNewUser()
	{
		//
		// Handle user attributes.
		//
		if( array_key_exists( kAPI_OBJECT, $_REQUEST ) )
		{
			//
			// Create new user.
			//
			$user = new CUser();
		
			//
			// Iterate attributes.
			//
			foreach( $_REQUEST[ kAPI_OBJECT ] as $tag => $value )
			{
				//
				// Parse known tags.
				//
				switch( $tag )
				{
					case kTAG_USER_NAME:
						$user->Name( $value );
						break;
			
					case kTAG_USER_CODE:
						$user->Code( $value );
						break;
			
					case kTAG_USER_PASS:
						$user->Pass( $value );
						break;
			
					case kTAG_USER_MAIL:
						$user->Mail( $value );
						break;
			
					case kTAG_USER_ROLE:
						if( ! is_array( $value ) )
							$value = array( $value );
						foreach( $value as $item )
							$user->Role( $item, TRUE );
						break;
			
					case kTAG_USER_PROFILE:
						if( ! is_array( $value ) )
							$value = array( $value );
						foreach( $value as $item )
							$user->Profile( $item, TRUE );
						break;
			
					case kTAG_USER_DOMAIN:
						if( ! is_array( $value ) )
							$value = array( $value );
						foreach( $value as $item )
							$user->Domain( $item, TRUE );
						break;
			
					case kTAG_USER_MANAGER:
						$user->Manager( $value );
						break;
				
					default:
						$user[ $tag ] = $value;
						break;
			
				} // Parsed attribute tag.
		
			} // Iterating user attributes.
		
			//
			// Save user.
			//
			$_REQUEST[ kAPI_OBJECT ] = $user;
		
		} // Provided user attributes.
	
	} // _ValidateNewUser.

		

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
				case kAPI_OP_Login:
					$this->_Handle_Login();
					break;
	
				case kAPI_OP_NewUser:
					$this->_Handle_NewUser();
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
		// Add kAPI_OP_Login.
		//
		$theList[ kAPI_OP_Login ]
			= 'User login: returns the user record upon successful login.';

		//
		// Add kAPI_OP_Login.
		//
		$theList[ kAPI_OP_NewUser ]
			= 'New user: creates a new user with the provided properties.';
	
	} // _Handle_ListOp.

	 
	/*===================================================================================
	 *	_Handle_Login																	*
	 *==================================================================================*/

	/**
	 * Handle {@link kAPI_OP_Login} request.
	 *
	 * This method will handle the {@link kAPI_OP_Login} operation, which returns the user
	 * record upon successful login.
	 *
	 * The method will use the {@link kAPI_CREDENTIALS} parameter
	 * {@link kAPI_CREDENTIALS_CODE} element as the user ID and the
	 * {@link kAPI_CREDENTIALS_PASS} element as the password.
	 *
	 * If the the operation succeeds, the method will return the found user in the response.
	 *
	 * @access protected
	 */
	protected function _Handle_Login()
	{
		//
		// Unserialise standard data types.
		//
		$_REQUEST[ kAPI_CONTAINER ]
			->UnserialiseObject( $_REQUEST[ kAPI_CREDENTIALS ] );
		
		//
		// Locate user.
		//
		$query = $_REQUEST[ kAPI_CONTAINER ]->NewQuery();
		$query->AppendStatement(
			CQueryStatement::Equals(
				kTAG_USER_CODE, $_REQUEST[ kAPI_CREDENTIALS ][ kAPI_CREDENTIALS_CODE ] ),
			kOPERATOR_AND );
		$query->AppendStatement(
			CQueryStatement::Equals(
				kTAG_USER_PASS, $_REQUEST[ kAPI_CREDENTIALS ][ kAPI_CREDENTIALS_PASS ] ),
			kOPERATOR_AND );
		$object
			= $_REQUEST[ kAPI_CONTAINER ]
				->Query( $query, NULL, NULL, NULL, NULL, TRUE );
				
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
		
		//
		// Handle unknown user.
		//
		else
		{
			//
			// Set affected count.
			//
			$this->_OffsetManage( kAPI_STATUS, kAPI_AFFECTED_COUNT, 0 );
			
			//
			// Handle page count.
			//
			if( $this->offsetExists( kAPI_PAGING ) )
			{
				$tmp = $this->offsetGet( kAPI_PAGING );
				$tmp[ kAPI_PAGE_COUNT ] = 0;
				$this->offsetSet( kAPI_PAGING, $tmp );
			}
		
		} // Object not found.
	
	} // _Handle_Login.

	 
	/*===================================================================================
	 *	_Handle_NewUser																	*
	 *==================================================================================*/

	/**
	 * Handle {@link kAPI_OP_Login} request.
	 *
	 * This method will handle the {@link kAPI_OP_Login} operation, which returns the user
	 * record upon successful login.
	 *
	 * The method will use the {@link kAPI_CREDENTIALS} parameter
	 * {@link kAPI_CREDENTIALS_CODE} element as the user ID and the
	 * {@link kAPI_CREDENTIALS_PASS} element as the password.
	 *
	 * If the the operation succeeds, the method will return the found user in the response.
	 *
	 * @access protected
	 */
	protected function _Handle_NewUser()
	{
		//
		// Commit user.
		//
		$identifier = $_REQUEST[ kAPI_OBJECT ]->Insert( $_REQUEST[ kAPI_CONTAINER ] );

		//
		// Serialise object.
		//
		CDataType::SerialiseObject( $identifier );
		
		//
		// Set object identifier.
		//
		$this->_OffsetManage( kAPI_STATUS, kTERM_STATUS_IDENTIFIER, $identifier );
	
		//
		// Set affected count.
		//
		$this->_OffsetManage( kAPI_STATUS, kAPI_AFFECTED_COUNT, 1 );
	
	} // _Handle_NewUser.

	 

} // class CPortalWrapper.


?>

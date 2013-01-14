<?php

/**
 * <i>CPortalWrapperClient</i> class definition.
 *
 * This file contains the class definition of <b>CPortalWrapperClient</b> which represents a
 * web-service portal wrapper client.
 *
 *	@package	MyWrapper
 *	@subpackage	Wrappers
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 14/12/2012
 */

/*=======================================================================================
 *																						*
 *								CPortalWrapperClient.php								*
 *																						*
 *======================================================================================*/

/**
 * Ancestor.
 *
 * This include file contains the parent class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntologyWrapperClient.php" );

/**
 * Server definitions.
 *
 * This include file contains all definitions of the server object.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CPortalWrapper.php" );

/**
 * <h4>Portal wrapper client</h4>
 *
 * This class represents a web-services wrapper client, it facilitates the job of requesting
 * information from servers derived from the {@link COntologyWrapper} class.
 *
 * This class supports the following properties:
 *
 * <ul>
 *	<li><i>{@link Credentials()}</i>: This element represents the web-service login
 *		credentials, it is stored in the in the {@link kAPI_CREDENTIALS} offset.
 * </ul>
 *
 * The class recognises the following operations ({@link Operation()}):
 *
 * <ul>
 *	<li><tt>{@link kAPI_OP_Login}</tt>: This service returns the the user corresponding to
 *		the provided credentials. The service expects the following parameters:
 *	 <ul>
 *		<li><i>{@link kAPI_FORMAT}</i>: This parameter is required to indicate how to encode
 *			the response.
 *		<li><i>{@link kAPI_DATABASE}</i>: This parameter is required to indicate the working
 *			database.
 *		<li><i>{@link kAPI_CONTAINER}</i>: This optional parameter is used to indicate the
 *			working container in case of a non-standard configuration.
 *		<li><i>{@link kAPI_CREDENTIALS}</i>: This parameter is required for validating the
 *			user:
 *		 <ul>
 *			<li><tt>{@link kAPI_CREDENTIALS_CODE}</tt>: User code.
 *			<li><tt>{@link kAPI_CREDENTIALS_PASS}</tt>: User password.
 *		 </ul>
 *	 </ul>
 *	<li><tt>{@link kAPI_OP_NewUser}</tt>: This service inserts the provided user into the
 *		database, the service expects the following parameters:
 *	 <ul>
 *		<li><i>{@link kAPI_FORMAT}</i>: This parameter is required to indicate how to
 *			encode the response.
 *		<li><i>{@link kAPI_DATABASE}</i>: This parameter is required to indicate the working
 *			database.
 *		<li><i>{@link kAPI_OBJECT}</i>: This parameter is required and contains an array
 *			corresponding to the new user attributes.
 *	 </ul>
 * </ul>
 *
 *	@package	MyWrapper
 *	@subpackage	Wrappers
 */
class CPortalWrapperClient extends COntologyWrapperClient
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
	 *	<li><i>{@link kAPI_OP_Login}</i>: LOGIN web-service operation, used to
	 *		return validate user credentials.
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
				case kAPI_OP_Login:
				case kAPI_OP_NewUser:
					return ManageOffset(
						$this, kAPI_OPERATION, $theValue, $getOld );				// ==>
			}
		}
		
		return parent::Operation( $theValue, $getOld );								// ==>

	} // Operation.

	 
	/*===================================================================================
	 *	Credentials																		*
	 *==================================================================================*/

	/**
	 * Manage user credentials.
	 *
	 * This method can be used to manage the {@link kAPI_CREDENTIALS} offset, it accepts the
	 * following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theKey</tt>: This string represents the element key.
	 *	<li><tt>$theValue</tt>: This parameter represents the element value or operation:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Return the the value at the provided key.
	 *		<li><tt>FALSE</tt>: Delete the value at the provided key.
	 *		<li><i>other</i>: Any other type will replace or set the value at the provided
	 *			key.
	 *	 </ul>
	 *	<li><tt>$getOld</tt>: Determines what the method will return:
	 *	 <ul>
	 *		<li><tt>TRUE</tt>: Return the value of the offset <i>before</i> it was
	 *			eventually modified.
	 *		<li><tt>FALSE</tt>: Return the value of the offset <i>after</i> it was
	 *			eventually modified.
	 *	 </ul>
	 * </ul>
	 *
	 * @param string				$theKey				Element key.
	 * @param mixed					$theValue			Value or operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access public
	 * @return mixed
	 *
	 * @uses ManageIndexedOffset()
	 *
	 * @see kAPI_CREDENTIALS
	 */
	public function Credentials( $theKey, $theValue = NULL, $getOld = FALSE )
	{
		return ManageIndexedOffset(
					$this, kAPI_CREDENTIALS, $theKey, $theValue, $getOld );			// ==>

	} // Credentials.

		

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
			case kAPI_OP_Login:
				//
				// Database is required.
				//
				if( ! $this->offsetExists( kAPI_DATABASE ) )
					throw new Exception
							( "Unable to run service: missing database parameter",
							  kERROR_STATE );									// !@! ==>

				//
				// Format is required.
				//
				if( ! $this->offsetExists( kAPI_FORMAT ) )
					throw new Exception
							( "Unable to run service: missing format parameter",
							  kERROR_STATE );									// !@! ==>

				//
				// Credentials are required.
				//
				if( ! $this->offsetExists( kAPI_CREDENTIALS ) )
					throw new Exception
							( "Unable to run service: missing credentials parameter",
							  kERROR_STATE );									// !@! ==>

				break;
			
			case kAPI_OP_NewUser:
				//
				// Database is required.
				//
				if( ! $this->offsetExists( kAPI_DATABASE ) )
					throw new Exception
							( "Unable to run service: missing database parameter",
							  kERROR_STATE );									// !@! ==>

				//
				// Format is required.
				//
				if( ! $this->offsetExists( kAPI_FORMAT ) )
					throw new Exception
							( "Unable to run service: missing format parameter",
							  kERROR_STATE );									// !@! ==>

				//
				// Object are required.
				//
				if( ! $this->offsetExists( kAPI_OBJECT ) )
					throw new Exception
							( "Unable to run service: missing user attributes parameter",
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
	 * In this class we set the default container name for login.
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
		// Parse by operation.
		//
		switch( $this->Operation() )
		{
			case kAPI_OP_Login:
				if( $this->Container() === NULL )
					$this->Container( CUser::DefaultContainerName() );
				break;
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
				foreach( CPortalWrapper::$sParameterList as $key )
				{
					if( array_key_exists( $key, $theParameters ) )
						$theParameters[ $key ]
							= serialize( $theParameters[ $key ] );
				}
				break;

			case kTYPE_JSON:
				foreach( CPortalWrapper::$sParameterList as $key )
				{
					if( array_key_exists( $key, $theParameters ) )
						$theParameters[ $key ]
							= JsonEncode( $theParameters[ $key ] );
				}
				break;
		}
	
	} // _EncodeParameters.

	 

} // class CPortalWrapperClient.


?>

<?php

/**
 * <i>CUser</i> class definition.
 *
 * This file contains the class definition of <b>CUser</b> which represents the ancestor of
 * all user classes.
 *
 *	@package	MyWrapper
 *	@subpackage	Objects
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 12/12/2012
 */

/*=======================================================================================
 *																						*
 *										CUser.php										*
 *																						*
 *======================================================================================*/

/**
 * Local definitions.
 *
 * This include file contains local definitions.
 */
require_once( "CUser.inc.php" );

/**
 * Tokens.
 *
 * This include file contains all default token definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_DEFINE."/Tokens.inc.php" );

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CPersistentObject.php" );

/**
 * <h4>User object ancestor</h4>
 *
 * A default user contains the following attributes:
 *
 * <ul>
 *	<li><i>User name</i>: The user full name, <tt>{@link Name()}</tt> or the
 *		<tt>{@link kTAG_USER_NAME}</tt> tag, is a string that represents the full user name.
 *		In this class we make no distinction between first and last names.
 *	<li><i>User code</i>: The user code, <tt>{@link Code()}</tt> or the
 *		<tt>{@link kTAG_USER_CODE}</tt> tag, is a string that represents the user code or
 *		identifier. This string must be unique among all users, it represents the user's
 *		global identifier and it will be used as the user's native identifier.
 *	<li><i>User password</i>: The user password, <tt>{@link Pass()}</tt> or the
 *		<tt>{@link kTAG_USER_PASS}</tt> tag, is a string that represents the user password:
 *		along with the user code, it represents the login credentials.
 *	<li><i>User mail</i>: The user e-mail, <tt>{@link Mail()}</tt> or the
 *		<tt>{@link kTAG_USER_MAIL}</tt> tag, is a string that represents the user e-mail
 *		address, it could generally be used to initialise the user code.
 *	<li><i>User role</i>: The user role, <tt>{@link Role()}</tt> or the
 *		<tt>{@link kTAG_USER_ROLE}</tt> tag, is a string that represents the user role or
 *		credentials, it is a system dependent element that provides the host system with the
 *		necessary information to provide the user the correct privileges.
 *	<li><i>User profile</i>: The user profile, <tt>{@link Profile()}</tt> or the
 *		<tt>{@link kTAG_USER_PROFILE}</tt> tag, is a set of elements that list the
 *		capabilities or credentials of the user. The role is specific to the hosting
 *		system, while the profile is specific to this library.
 *	<li><i>User manager</i>: The user manager, <tt>{@link Manager()}</tt> or the
 *		<tt>{@link kTAG_USER_MANAGER}</tt> tag, is a reference to the user that has the
 *		rights and responsibility of managing the user. It will be generally the one who
 *		created the user, who can revoke privileges or delete the user.
 * </ul>
 *
 * The native identifier of the user, {@link kTAG_NID}, is equivalent to the user code, in
 * derived classes the native identifier may change.
 *
 * Once the object has been committed, the user code will be locked, since it is used to
 * generate the unique identifier.
 *
 * The object will have its {@link _IsInited()} status set if the name, code, password and
 * mail are also set.
 *
 *	@package	MyWrapper
 *	@subpackage	Objects
 */
class CUser extends CPersistentObject
{
	/**
	 * <b>Manager user object</b>
	 *
	 * This data member holds the eventual manager user object when requested.
	 *
	 * @var CUser
	 */
	 protected $mManager = NULL;

		

/*=======================================================================================
 *																						*
 *								PUBLIC MEMBER INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Name																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage user name</h4>
	 *
	 * The <i>name</i>, {@link kTAG_USER_NAME}, holds the full name of the user.
	 *
	 * The method accepts a parameter which represents either the name or the requested
	 * operation, depending on its value:
	 *
	 * <ul>
	 *	<li><tt>NULL</tt>: Return the current value.
	 *	<li><tt>FALSE</tt>: Delete the current value.
	 *	<li><i>other</i>: Set the value with the provided parameter.
	 * </ul>
	 *
	 * The second parameter is a boolean which if <tt>TRUE</tt> will return the <i>old</i>
	 * value when replacing containers; if <tt>FALSE</tt>, it will return the currently set
	 * value.
	 *
	 * @param mixed					$theValue			Value or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> value.
	 *
	 * @uses ManageOffset()
	 *
	 * @see kTAG_USER_NAME
	 */
	public function Name( $theValue = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kTAG_USER_NAME, $theValue, $getOld );			// ==>

	} // Name.

		
	/*===================================================================================
	 *	Code																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage user code</h4>
	 *
	 * The <i>code</i>, {@link kTAG_USER_CODE}, holds the code of the user. This data
	 * represents the user native identifier. Once the object has been committed, this
	 * attribute will be locked.
	 *
	 * The method accepts a parameter which represents either the name or the requested
	 * operation, depending on its value:
	 *
	 * <ul>
	 *	<li><tt>NULL</tt>: Return the current value.
	 *	<li><tt>FALSE</tt>: Delete the current value.
	 *	<li><i>other</i>: Set the value with the provided parameter.
	 * </ul>
	 *
	 * The second parameter is a boolean which if <tt>TRUE</tt> will return the <i>old</i>
	 * value when replacing containers; if <tt>FALSE</tt>, it will return the currently set
	 * value.
	 *
	 * @param mixed					$theValue			Value or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> value.
	 *
	 * @uses ManageOffset()
	 *
	 * @see kTAG_USER_CODE
	 */
	public function Code( $theValue = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kTAG_USER_CODE, $theValue, $getOld );			// ==>

	} // Code.

		
	/*===================================================================================
	 *	Pass																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage user password</h4>
	 *
	 * The <i>password</i>, {@link kTAG_USER_PASS}, holds the password of the user. This data
	 * along with the user code is used as the login credentials.
	 *
	 * The method accepts a parameter which represents either the name or the requested
	 * operation, depending on its value:
	 *
	 * <ul>
	 *	<li><tt>NULL</tt>: Return the current value.
	 *	<li><tt>FALSE</tt>: Delete the current value.
	 *	<li><i>other</i>: Set the value with the provided parameter.
	 * </ul>
	 *
	 * The second parameter is a boolean which if <tt>TRUE</tt> will return the <i>old</i>
	 * value when replacing containers; if <tt>FALSE</tt>, it will return the currently set
	 * value.
	 *
	 * @param mixed					$theValue			Value or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> value.
	 *
	 * @uses ManageOffset()
	 *
	 * @see kTAG_USER_PASS
	 */
	public function Pass( $theValue = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kTAG_USER_PASS, $theValue, $getOld );			// ==>

	} // Pass.

		
	/*===================================================================================
	 *	Mail																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage user mail</h4>
	 *
	 * The <i>mail</i>, {@link kTAG_USER_MAIL}, holds the user e-mail address.
	 *
	 * The method accepts a parameter which represents either the name or the requested
	 * operation, depending on its value:
	 *
	 * <ul>
	 *	<li><tt>NULL</tt>: Return the current value.
	 *	<li><tt>FALSE</tt>: Delete the current value.
	 *	<li><i>other</i>: Set the value with the provided parameter.
	 * </ul>
	 *
	 * The second parameter is a boolean which if <tt>TRUE</tt> will return the <i>old</i>
	 * value when replacing containers; if <tt>FALSE</tt>, it will return the currently set
	 * value.
	 *
	 * @param mixed					$theValue			Value or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> value.
	 *
	 * @uses ManageOffset()
	 *
	 * @see kTAG_USER_MAIL
	 */
	public function Mail( $theValue = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kTAG_USER_MAIL, $theValue, $getOld );			// ==>

	} // Mail.

		
	/*===================================================================================
	 *	Role																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage user roles</h4>
	 *
	 * The <i>role</i>, {@link kTAG_USER_ROLE}, holds the list of roles of the user
	 * according to the hosting system. It is a string that identifies the user role
	 * specific to the hosting operating system or framework.
	 *
	 * <ul>
	 *	<li><tt>$theValue</tt>: Depending on the next parameter, this may either refer to
	 *		the value to be set or to the index of the element to be retrieved or deleted:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: This value indicates that we want to operate on all elements,
	 *			which means, in practical terms, that we either want to retrieve or delete
	 *			the full list. If the operation parameter resolves to <tt>TRUE</tt>, the
	 *			method will default to retrieving the current list and no new element will
	 *			be added.
	 *		<li><tt>array</tt>: An array indicates that we want to operate on a list of
	 *			values and that other parameters may also be provided as lists. Note that
	 *			{@link ArrayObject} instances are not considered here as arrays.
	 *		<li><i>other</i>: Any other type represents either the new value to be added or
	 *			the index to the value to be returned or deleted.
	 *	 </ul>
	 *	<li><tt>$theOperation</tt>: This parameter represents the operation to be performed
	 *		whose scope depends on the value of the previous parameter:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Return the element or full list.
	 *		<li><tt>FALSE</tt>: Delete the element or full list.
	 *		<li><tt>array</tt>: This type is only considered if the <tt>$theValue</tt>
	 *			parameter is provided as an array: the method will be called for each
	 *			element of the <tt>$theValue</tt> parameter matched with the corresponding
	 *			element of this parameter, which also means that both both parameters must
	 *			share the same count.
	 *		<li><i>other</i>: Add the <tt>$theValue</tt> value to the list. If you provided
	 *			<tt>NULL</tt> in the previous parameter, the operation will be reset to
	 *			<tt>NULL</tt>.
	 *	 </ul>
	 *	<li><tt>$getOld</tt>: Determines what the method will return:
	 *	 <ul>
	 *		<li><tt>TRUE</tt>: Return the value <i>before</i> it was eventually modified.
	 *		<li><tt>FALSE</tt>: Return the value <i>after</i> it was eventually modified.
	 *	 </ul>
	 * </ul>
	 *
	 * @param mixed					$theValue			Value or index.
	 * @param mixed					$theOperation		Operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> value.
	 *
	 * @uses ManageObjectSetOffset()
	 *
	 * @see kTAG_USER_ROLE
	 */
	public function Role( $theValue = NULL, $theOperation = NULL, $getOld = FALSE )
	{
		return ManageObjectSetOffset
			( $this, kTAG_USER_ROLE, $theValue, $theOperation, $getOld );			// ==>

	} // Role.

		
	/*===================================================================================
	 *	Profile																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage user profile set</h4>
	 *
	 * The profile set, {@link kTAG_USER_PROFILE}, holds a list of unique values that
	 * represent the different privileges and capabilities of the user. This information is
	 * not specific to the hosting system, but rather to the library that manages users.
	 *
	 * This offset collects the list of these qualifications in an enumerated set that can
	 * be managed with the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theValue</tt>: Depending on the next parameter, this may either refer to
	 *		the value to be set or to the index of the element to be retrieved or deleted:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: This value indicates that we want to operate on all elements,
	 *			which means, in practical terms, that we either want to retrieve or delete
	 *			the full list. If the operation parameter resolves to <tt>TRUE</tt>, the
	 *			method will default to retrieving the current list and no new element will
	 *			be added.
	 *		<li><tt>array</tt>: An array indicates that we want to operate on a list of
	 *			values and that other parameters may also be provided as lists. Note that
	 *			{@link ArrayObject} instances are not considered here as arrays.
	 *		<li><i>other</i>: Any other type represents either the new value to be added or
	 *			the index to the value to be returned or deleted.
	 *	 </ul>
	 *	<li><tt>$theOperation</tt>: This parameter represents the operation to be performed
	 *		whose scope depends on the value of the previous parameter:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Return the element or full list.
	 *		<li><tt>FALSE</tt>: Delete the element or full list.
	 *		<li><tt>array</tt>: This type is only considered if the <tt>$theValue</tt>
	 *			parameter is provided as an array: the method will be called for each
	 *			element of the <tt>$theValue</tt> parameter matched with the corresponding
	 *			element of this parameter, which also means that both both parameters must
	 *			share the same count.
	 *		<li><i>other</i>: Add the <tt>$theValue</tt> value to the list. If you provided
	 *			<tt>NULL</tt> in the previous parameter, the operation will be reset to
	 *			<tt>NULL</tt>.
	 *	 </ul>
	 *	<li><tt>$getOld</tt>: Determines what the method will return:
	 *	 <ul>
	 *		<li><tt>TRUE</tt>: Return the value <i>before</i> it was eventually modified.
	 *		<li><tt>FALSE</tt>: Return the value <i>after</i> it was eventually modified.
	 *	 </ul>
	 * </ul>
	 *
	 * @param mixed					$theValue			Value or index.
	 * @param mixed					$theOperation		Operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> kind.
	 *
	 * @uses ManageObjectSetOffset()
	 *
	 * @see kTAG_USER_PROFILE
	 */
	public function Profile( $theValue = NULL, $theOperation = NULL, $getOld = FALSE )
	{
		return ManageObjectSetOffset
			( $this, kTAG_USER_PROFILE, $theValue, $theOperation, $getOld );		// ==>

	} // Profile.

		
	/*===================================================================================
	 *	Domain																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage user domains</h4>
	 *
	 * The user domain, {@link kTAG_USER_DOMAIN}, holds a list of unique values that
	 * represent the different domains in which the current user is registered.
	 *
	 * This offset collects the list of these domains in an enumerated set that can be
	 * managed with the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theValue</tt>: Depending on the next parameter, this may either refer to
	 *		the value to be set or to the index of the element to be retrieved or deleted:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: This value indicates that we want to operate on all elements,
	 *			which means, in practical terms, that we either want to retrieve or delete
	 *			the full list. If the operation parameter resolves to <tt>TRUE</tt>, the
	 *			method will default to retrieving the current list and no new element will
	 *			be added.
	 *		<li><tt>array</tt>: An array indicates that we want to operate on a list of
	 *			values and that other parameters may also be provided as lists. Note that
	 *			{@link ArrayObject} instances are not considered here as arrays.
	 *		<li><i>other</i>: Any other type represents either the new value to be added or
	 *			the index to the value to be returned or deleted.
	 *	 </ul>
	 *	<li><tt>$theOperation</tt>: This parameter represents the operation to be performed
	 *		whose scope depends on the value of the previous parameter:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Return the element or full list.
	 *		<li><tt>FALSE</tt>: Delete the element or full list.
	 *		<li><tt>array</tt>: This type is only considered if the <tt>$theValue</tt>
	 *			parameter is provided as an array: the method will be called for each
	 *			element of the <tt>$theValue</tt> parameter matched with the corresponding
	 *			element of this parameter, which also means that both both parameters must
	 *			share the same count.
	 *		<li><i>other</i>: Add the <tt>$theValue</tt> value to the list. If you provided
	 *			<tt>NULL</tt> in the previous parameter, the operation will be reset to
	 *			<tt>NULL</tt>.
	 *	 </ul>
	 *	<li><tt>$getOld</tt>: Determines what the method will return:
	 *	 <ul>
	 *		<li><tt>TRUE</tt>: Return the value <i>before</i> it was eventually modified.
	 *		<li><tt>FALSE</tt>: Return the value <i>after</i> it was eventually modified.
	 *	 </ul>
	 * </ul>
	 *
	 * @param mixed					$theValue			Value or index.
	 * @param mixed					$theOperation		Operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> domain.
	 *
	 * @uses ManageObjectSetOffset()
	 *
	 * @see kTAG_USER_DOMAIN
	 */
	public function Domain( $theValue = NULL, $theOperation = NULL, $getOld = FALSE )
	{
		return ManageObjectSetOffset
			( $this, kTAG_USER_DOMAIN, $theValue, $theOperation, $getOld );			// ==>

	} // Domain.

		
	/*===================================================================================
	 *	Manager																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage user manager</h4>
	 *
	 * The <i>mamager</i>, {@link kTAG_USER_MANAGER}, holds the reference to another user
	 * who has the responsibility and task of managing the current user. In general this
	 * will refer to the user that created the current user and that can revoke privileges or
	 * delete the user.
	 *
	 * The method accepts a parameter which represents either the code of the user's manager
	 * or the requested operation, depending on its value:
	 *
	 * <ul>
	 *	<li><tt>NULL</tt>: Return the current value.
	 *	<li><tt>FALSE</tt>: Delete the current value.
	 *	<li><i>other</i>: Set the value with the provided parameter.
	 * </ul>
	 *
	 * The second parameter is a boolean which if <tt>TRUE</tt> will return the <i>old</i>
	 * value when replacing containers; if <tt>FALSE</tt>, it will return the currently set
	 * value.
	 *
	 * @param mixed					$theValue			Value or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> value.
	 *
	 * @uses ManageOffset()
	 *
	 * @see kTAG_USER_MANAGER
	 */
	public function Manager( $theValue = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kTAG_USER_MANAGER, $theValue, $getOld );		// ==>

	} // Manager.

		

/*=======================================================================================
 *																						*
 *							PUBLIC RELATED MEMBER INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	LoadManager																		*
	 *==================================================================================*/

	/**
	 * <h4>Load manager object</h4>
	 *
	 * This method will return the current manager object: if the term is not set, the
	 * method will return <tt>NULL</tt>; if the manager cannot be found, the method will
	 * raise an exception.
	 *
	 * The object will also be loaded in a data member that can function as a cache.
	 *
	 * The method features two parameters: the first refers to the container in which the
	 * manager is stored, the second is a boolean flag that determines whether the object
	 * is to be read, or if the cached copy can be used.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param boolean				$doReload			Reload if <tt>TRUE</tt>.
	 *
	 * @access public
	 * @return COntologyTerm		Manager object or <tt>NULL</tt>.
	 *
	 * @throws Exception
	 *
	 * @uses NewObject()
	 *
	 * @see kTAG_USER_MANAGER
	 */
	public function LoadManager( CConnection $theConnection, $doReload = FALSE )
	{
		//
		// Check offset.
		//
		if( $this->offsetExists( kTAG_USER_MANAGER ) )
		{
			//
			// Refresh cache.
			// Uncommitted managers are cached by default.
			//
			if( $doReload						// Reload,
			 || ($this->mManager === NULL) )	// or not cached.
			{
				//
				// Handle manager object.
				//
				$manager = $this->offsetGet( kTAG_USER_MANAGER );
				if( $manager instanceof CUser )
					return $manager;												// ==>
				
				//
				// Load manager object.
				//
				$this->mManager
					= $this->NewObject
						( static::ResolveClassContainer( $theConnection, TRUE ),
						  $manager );
			
			} // Reload or empty cache.
			
			//
			// Handle not found.
			//
			if( $this->mManager === NULL )
				throw new Exception
					( "Manager not found",
					  kERROR_STATE );											// !@! ==>
		
		} // Has manager.
		
		return $this->mManager;														// ==>

	} // LoadManager.

		

/*=======================================================================================
 *																						*
 *								STATIC CONTAINER INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	DefaultContainerName															*
	 *==================================================================================*/

	/**
	 * <h4>Return the default users container name</h4>
	 *
	 * This class uses the {@link kCONTAINER_USER_NAME} default name.
	 *
	 * @static
	 * @return string				The default container name.
	 *
	 * @throws Exception
	 *
	 * @see kCONTAINER_USER_NAME
	 */
	static function DefaultContainerName()				{	return kCONTAINER_USER_NAME;	}

		

/*=======================================================================================
 *																						*
 *								STATIC RESOLUTION INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Resolve																			*
	 *==================================================================================*/

	/**
	 * <h4>Resolve a user</h4>
	 *
	 * This method can be used to locate a user given the attributes that comprise its
	 * identifier.
	 *
	 * The method accepts the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theConnection</tt>: This parameter represents the connection from which the
	 *		terms container must be resolved. If this parameter cannot be correctly
	 *		determined, the method will raise an exception.
	 *	<li><tt>$theIdentifier</tt>: In this class by default the native identifier is the
	 *		user code, we assume this parameter is that string.
	 *	<li><tt>$doThrow</tt>: If <tt>TRUE</tt>, any failure to resolve the term or its
	 *			namespace, will raise an exception.
	 * </ul>
	 *
	 * The method will return the found user, <tt>NULL</tt> if not found, or raise an
	 * exception if the last parameter is <tt>TRUE</tt>.
	 *
	 * <b>Note: do not provide an array containing the object in the identifier parameter,
	 * or you will get unexpected results.</b>
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param mixed					$theIdentifier		User identifier or user reference.
	 * @param boolean				$doThrow			If <tt>TRUE</tt> raise an exception.
	 *
	 * @static
	 * @return CUser				Matched user or <tt>NULL</tt>.
	 *
	 * @throws Exception
	 */
	static function Resolve( CConnection $theConnection, $theIdentifier, $doThrow = FALSE )
	{
		//
		// Check identifier.
		//
		if( $theIdentifier !== NULL )
		{
			//
			// Use provided object global identifier.
			//
			if( $theIdentifier instanceof CUser )
			{
				//
				// Use global identifier.
				//
				if( $theIdentifier->offsetExists( kTAG_GID ) )
					$theIdentifier = $theIdentifier->GID();
				
				//
				// Use code.
				//
				elseif( $theIdentifier->offsetExists( kTAG_USER_CODE ) )
					$theIdentifier = $theIdentifier->Code();
				
				else
				{
					if( $doThrow )
						throw new Exception
							( "Missing user identifier",
							  kERROR_PARAMETER );								// !@! ==>
					
					return NULL;													// ==>
				
				} // Unresolved identifier.
			
				//
				// Build term native identifier.
				//
				$theIdentifier = static::_id( $theIdentifier, $theConnection );
			
			} // Provided object global identifier.
			
			//
			// Try native identifier.
			//
			$user = static::NewObject( $theConnection, $theIdentifier );
			if( $user !== NULL )
				return $user;														// ==>
			
			//
			// Raise exception if missing.
			//
			if( $doThrow )
				throw new Exception
					( "User not found",
					  kERROR_NOT_FOUND );										// !@! ==>
			
			return NULL;															// ==>
		
		} // Provided identifier.
		
		throw new Exception
			( "Missing user reference",
			  kERROR_PARAMETER );												// !@! ==>

	} // Resolve.
		


/*=======================================================================================
 *																						*
 *							PROTECTED IDENTIFICATION INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_index																			*
	 *==================================================================================*/

	/**
	 * <h4>Return the object's global unique identifier</h4>
	 *
	 * User identifiers are constituted by the user code, this mathod will simply return it.
	 *
	 * In derived classes this can be overloaded.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param bitfield				$theModifiers		Commit options.
	 *
	 * @access protected
	 * @return string|NULL			The object's global unique identifier.
	 *
	 * @see kTAG_LID kTAG_NAMESPACE kTOKEN_NAMESPACE_SEPARATOR
	 */
	protected function _index( CConnection $theConnection, $theModifiers )
	{
		return $this->Code();														// ==>
	
	} // _index.
		


/*=======================================================================================
 *																						*
 *								PROTECTED OFFSET INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_Preset																			*
	 *==================================================================================*/

	/**
	 * <h4>Handle offset before setting it</h4>
	 *
	 * In this class we prevent the modification of the user code if the object has its
	 * {@link _IsCommitted()} status set. This is because the code represents the user
	 * native identifier.
	 *
	 * We also ensure that the provided profile is an array.
	 *
	 * @param reference			   &$theOffset			Offset.
	 * @param reference			   &$theValue			Value to set at offset.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 *
	 * @uses _IsCommitted()
	 *
	 * @see kTAG_USER_CODE kTAG_USER_PROFILE
	 */
	protected function _Preset( &$theOffset, &$theValue )
	{
		//
		// Intercept namespace and local identifier.
		//
		$offsets = array( kTAG_USER_CODE );
		if( $this->_IsCommitted()
		 && in_array( $theOffset, $offsets ) )
			throw new Exception
				( "You cannot modify the [$theOffset] offset: "
				 ."the object is committed",
				  kERROR_LOCKED );												// !@! ==>
		
		//
		// Check profile type.
		//
		$offsets = array( kTAG_USER_PROFILE );
		if( in_array( $theOffset, $offsets )
		 && ($theValue !== NULL)
		 && (! is_array( $theValue )) )
			throw new Exception
				( "You cannot set the [$theOffset] offset: "
				 ."invalid value, expecting an array",
				  kERROR_PARAMETER );											// !@! ==>
		
		//
		// Call parent method.
		//
		parent::_Preset( $theOffset, $theValue );
	
	} // _Preset.

	 
	/*===================================================================================
	 *	_Preunset																		*
	 *==================================================================================*/

	/**
	 * <h4>Handle offset before unsetting it</h4>
	 *
	 * In this class we prevent the modification of the user code if the object has its
	 * {@link _IsCommitted()} status set. This is because the code represents the user
	 * native identifier.
	 *
	 * @param reference			   &$theOffset			Offset.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 *
	 * @uses _IsCommitted()
	 *
	 * @see kTAG_USER_CODE
	 */
	protected function _Preunset( &$theOffset )
	{
		//
		// Intercept namespace and local identifier.
		//
		$offsets = array( kTAG_USER_CODE );
		if( $this->_IsCommitted()
		 && in_array( $theOffset, $offsets ) )
			throw new Exception
				( "You cannot modify the [$theOffset] offset: "
				 ."the object is committed",
				  kERROR_LOCKED );												// !@! ==>
		
		//
		// Call parent method.
		//
		parent::_Preunset( $theOffset );
	
	} // _Preunset.
		


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
	 * {@link kTAG_LID} offset.
	 *
	 * @access protected
	 * @return boolean				<tt>TRUE</tt> means {@link _IsInited( <tt>TRUE</tt> ).
	 *
	 * @uses _Ready()
	 *
	 * @see kTAG_LID
	 */
	protected function _Ready()
	{
		//
		// Check parent.
		//
		if( parent::_Ready() )
			return ( $this->offsetExists( kTAG_USER_NAME )	&&
					 $this->offsetExists( kTAG_USER_CODE )	&&
					 $this->offsetExists( kTAG_USER_PASS )	&&
					 $this->offsetExists( kTAG_USER_MAIL ) );						// ==>
		
		return FALSE;																// ==>
	
	} // _Ready.
		


/*=======================================================================================
 *																						*
 *							PROTECTED PRE-COMMIT INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_PrecommitRelated																*
	 *==================================================================================*/

	/**
	 * <h4>Handle embedded or related objects before committing</h4>
	 *
	 * In this class we commit the eventual manager user provided as an object or load
	 * the manager if provided as an identifier.
	 *
	 * @param reference			   &$theConnection		Server, database or container.
	 * @param reference			   &$theModifiers		Commit options.
	 *
	 * @access protected
	 * @return mixed
	 */
	protected function _PrecommitRelated( &$theConnection, &$theModifiers )
	{
		//
		// Call parent method.
		//
		$status = parent::_PrecommitRelated( $theConnection, $theModifiers );
		if( $status !== NULL )
			return $status;															// ==>
		
		//
		// Not deleting.
		//
		if( ! ($theModifiers & kFLAG_PERSIST_DELETE) )
		{
			//
			// Handle manager object.
			// Note that we let _Preset() method take care of the specific class.
			//
			if( $this->offsetExists( kTAG_USER_MANAGER ) )
			{
				//
				// Get term.
				//
				$manager = $this->offsetGet( kTAG_USER_MANAGER );
				if( $manager instanceof CUser )
				{
					//
					// Commit.
					// Note that we insert, to ensure the object is new.
					//
					$manager->Insert(
						static::ResolveClassContainer( $theConnection, TRUE ) );
					
					//
					// Cache it.
					//
					$this->mManager = $manager;
					
					//
					// Set identifier in manager offset.
					//
					$this->offsetSet( kTAG_USER_MANAGER,
									  $manager->offsetGet( kTAG_NID ) );
					
				} // Term is object.
				
				//
				// Handle manager identifier.
				//
				else
					$this->LoadManager( $theConnection, TRUE );
			
			} // Has a manager reference.
		
		} // Not deleting.
		
		return NULL;																// ==>
	
	} // _PrecommitRelated.
		


/*=======================================================================================
 *																						*
 *							PROTECTED POST-COMMIT INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_PostcommitCleanup																*
	 *==================================================================================*/

	/**
	 * <h4>Cleanup the object after committing</h4>
	 *
	 * In this class we reset the manager object cache, we set the data member to
	 * <tt>NULL</tt>, so that next time one wants to retrieve the manager object, it will
	 * have to be refreshed and its references actualised.
	 *
	 * @param reference			   &$theConnection		Server, database or container.
	 * @param reference			   &$theModifiers		Commit options.
	 *
	 * @access protected
	 */
	protected function _PostcommitCleanup( &$theConnection, &$theModifiers )
	{
		//
		// Call parent method.
		//
		parent::_PostcommitCleanup( $theConnection, $theModifiers );
		
		//
		// Reset manager cache.
		//
		$this->mManager = NULL;
	
	} // _PostcommitCleanup.

	 

} // class CUser.


?>

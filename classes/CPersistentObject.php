<?php

/**
 * <i>CPersistentObject</i> class definition.
 *
 * This file contains the class definition of <b>CPersistentObject</b> which represents
 * the ancestor of all persistent object classes.
 *
 *	@package	MyWrapper
 *	@subpackage	Persistence
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 04/09/2012
 */

/*=======================================================================================
 *																						*
 *								CPersistentObject.php									*
 *																						*
 *======================================================================================*/

/**
 * Local definitions.
 *
 * This include file contains common offset definitions.
 */
require_once( "CPersistentObject.inc.php" );

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CPersistentDocument.php" );

/**
 * <h3>Persistent object ancestor</h3>
 *
 * This <i>abstract</i> class extends its {@link CPersistentDocument} ancestor to implement
 * an identification interface that governs how objects derived from this class are
 * identified within their container.
 *
 * The object is uniquely identified by a string, the <i>global unique identifier</i>, this
 * string is generally a combination of the object's attributes and once set, it should not
 * change. The string is composed by a protected method, {@link _index()}, and set into a
 * predefined offset, {@link kOFFSET_GID}.
 *
 * This value will be used to generate the <i>native unique identifier</i>,
 * {@link kOFFSET_NID}, which represents the object's primary key within the container in
 * which it is stored. The value is obtained by feeding the {@link kOFFSET_GID} to a static
 * method, {@link _id()}, whose function is to transform the provided value into one
 * optimised as a primary key. The method is static so that any global identifier can be
 * converted into a native one.
 *
 * Once the object has been committed, these identifiers are locked by the {@link _Preset()}
 * and {@link _Preunset()} methods to prevent invalidating object references.
 *
 * The class features a predefined offset, {@link kOFFSET_CLASS}, that receives the class
 * name of the object: this value will be used by the static {@link NewObject()} method to
 * instantiate the correct object.
 *
 * All objects derived from this class should implement the {@link __toString()} method, by
 * default this class returns the global identifier, {@link kOFFSET_GID}. Derived classes
 * may change this behaviour, in particular when the class does not feature the global
 * identifier: the important thing is to be able to cast an object to a string.
 *
 * Finally, the class features member accessor methods for the default offsets:
 *
 * <ul>
 *	<li>{@link GID()}: This method manages the global unique identifier,
 *		{@link kOFFSET_GID}.
 *	<li>{@link ClassName()}: This method manages the object's class name,
 *		{@link kOFFSET_CLASS}.
 * </ul>
 *
 *	@package	MyWrapper
 *	@subpackage	Persistence
 */
class CPersistentObject extends CPersistentDocument
{
		

/*=======================================================================================
 *																						*
 *											MAGIC										*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	__toString																		*
	 *==================================================================================*/

	/**
	 * <h4>Return object name</h4>
	 *
	 * This method should return the current object's name which should represent the unique
	 * identifier of the object.
	 *
	 * By default we return the value of the {@link kOFFSET_GID} offset, if this offset is
	 * missing, the method will return <tt>NULL</tt>, which will result in a fatal error.
	 * This behaviour is intentional, since in this case the returned value is not correct
	 * and because this method cannot throw exceptions.
	 *
	 * @access public
	 * @return string				The connection name.
	 */
	public function __toString()
	{
		//
		// Check global identifier.
		//
		if( $this->offsetExists( kOFFSET_GID ) )
			return $this->offsetGet( kOFFSET_GID );									// ==>
		
		//
		// Yes, I know...
		//
		return NULL;																// ==>
	
	} // __toString.

		

/*=======================================================================================
 *																						*
 *								PUBLIC MEMBER INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	GID																				*
	 *==================================================================================*/

	/**
	 * <h4>Manage global unique identifier</h4>
	 *
	 * The <i>global unique identifier</i>, {@link kOFFSET_GID}, holds a string which
	 * represents the object's unique identifier, this value is hashed or used as-is to
	 * serve as the native unique identifier, {@link kOFFSET_NID}. The global identifier
	 * is usually a computed value extracted from a series of offsets of the object.
	 *
	 * The method accepts a parameter which represents either the identifier or the
	 * requested operation, depending on its value:
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
	 * Note that when the object has the {@link _IsCommitted()} status this offset will be
	 * locked and an exception will be raised.
	 *
	 * @param mixed					$theValue			Native identifier or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> native container.
	 *
	 * @uses ManageOffset()
	 *
	 * @see kOFFSET_GID
	 */
	public function GID( $theValue = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kOFFSET_GID, $theValue, $getOld );				// ==>

	} // GID.

	 
	/*===================================================================================
	 *	CLassName																		*
	 *==================================================================================*/

	/**
	 * <h4>Manage global unique identifier</h4>
	 *
	 * The <i>class name</i>, {@link kOFFSET_CLASS}, holds a string which is the class
	 * name of the object that first stored the object in the container. This value will
	 * be used by the static {@link NewObject()} method to restore the object from the
	 * container.
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
	 * Note that when the object has the {@link _IsCommitted()} status this offset will be
	 * locked and in many other classes this offset may not be writable.
	 *
	 * @param mixed					$theValue			Persistent container or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> native container.
	 *
	 * @uses ManageOffset()
	 *
	 * @see kOFFSET_CLASS
	 */
	public function CLassName( $theValue = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kOFFSET_CLASS, $theValue, $getOld );			// ==>

	} // CLassName.

		

/*=======================================================================================
 *																						*
 *								STATIC PERSISTENCE INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	NewObject																		*
	 *==================================================================================*/

	/**
	 * <h4>Instantiate an object from a container</h4>
	 *
	 * We override this method to handle the {@link kOFFSET_CLASS} offset: if found in the
	 * retrieved object, it will be used to instantiate the correct class. If the offset is
	 * missing, the method will instantiate the calling class.
	 *
	 * The method expects two parameters:
	 *
	 * <ul>
	 *	<li><tt>$theConnection</tt>: The container in which the object should be stored.
	 *		This parameter should be a concrete instance of of {@link CContainer}, or a
	 *		concrete instance of {@link CServer} or {@link CDatabase}, if the current class
	 *		has implemented the container resolve interface with {@link DefaultDatabase} and
	 *		{@link DefaultContainer()}.
	 *	<li><tt>$theIdentifier</tt>: The key of the object in the container, by default the
	 *		{@link kOFFSET_NID} offset.
	 * </ul>
	 *
	 * If the object could not be located, the method will return <tt>NULL</tt>.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param mixed					$theIdentifier		Identifier.
	 *
	 * @static
	 * @return mixed				The retrieved object.
	 */
	static function NewObject( CConnection $theConnection, $theIdentifier )
	{
		//
		// Init local storage.
		//
		$object = array( kOFFSET_NID => $theIdentifier );
		
		//
		// Retrieve object.
		//
		if( static::ResolveContainer( $theConnection, TRUE )->ManageObject( $object ) )
		{
			//
			// Handle custom class.
			//
			if( array_key_exists( kOFFSET_CLASS, $object ) )
			{
				//
				// Save class name.
				//
				$class = $object[ kOFFSET_CLASS ];
				
				//
				// Instantiate class.
				//
				$object = new $class( $object );
			
			} // Custom class.
			
			//
			// Handle default class.
			//
			else
				$object = new static( $object );
			
			//
			// Post-commit.
			// Note that default modifiers mean read.
			//
			if( $object instanceof CPersistentDocument )
				$object->_Postcommit( $theConnection );
			
			return $object;															// ==>
		
		} // Located.
		
		return NULL;																// ==>
	
	} // NewObject.
		


/*=======================================================================================
 *																						*
 *								STATIC PERSISTENCE INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_id																				*
	 *==================================================================================*/

	/**
	 * <h4>Generate the object's native unique identifier</h4>
	 *
	 * This method is used to generate the object's <i>native unique identifier</i>,
	 * {@link kOFFSET_NID}, from the string representing the object's <i>global unique
	 * identifier</i>, {@link kOFFSET_GID}.
	 *
	 * The first parameter of the method is a string, the second parameter can be a server
	 * or database which can be resolved into a container, or the container itself. This
	 * parameter can be used to process the first one: since the resulting value must be
	 * stored in a container, it should be the duty of the container itself to convert, for
	 * instance binary strings, to a suitable value.
	 *
	 * If the method receives <tt>NULL</tt> in the first parameter, this means that the
	 * object does not use the global identifier and it is the duty of the container to
	 * set the object's primary key, such as with autonumbers in SQL or missing <tt>_id</tt>
	 * in Mongo. In that case this method should not be called, see the {@link _Precommit()}
	 * method to see where it is used.
	 *
	 * In this class we do not process the identifier, so we simply return it.
	 *
	 * @param string				$theIdentifier		Global unique identifier.
	 * @param CConnection			$theConnection		Server, database or container.
	 *
	 * @static
	 * @return mixed				The object's native unique identifier.
	 */
	static function _id( $theIdentifier = NULL, CConnection $theConnection = NULL )
	{
		return $theIdentifier;														// ==>
	
	} // _id.
		


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
	 * This method should return the object's global unique identifier, this value is
	 * represented by a string which is generally extracted from selected attributes of the
	 * object and constitutes the unique key of the object.
	 *
	 * This string is stored in the {@link kOFFSET_GID} offset of the object and it is
	 * processed by the static {@link _id()} method to generate the object's native unique
	 * identifier, which is the native object's primary key stored in the
	 * {@link kOFFSET_NID} offset.
	 *
	 * This method is called by the {@link _Precommit()} method, to fill the
	 * {@link kOFFSET_GID} offset and the resulting value is fed to the {@link _id()} method
	 * to obtain the value that will be stored in the {@link kOFFSET_NID} offset. The
	 * inherited {@link Precommit()} method asserts whether the object {@link _IsInited()},
	 * before calling the local {@link _Precommit()} method, this to ensure that this method
	 * can safely use the object's attributes to generate the identifier. If you intend to
	 * use this method in other places, you should check if the object is initialised.
	 *
	 * If the object does not feature or use the global identifier, this method should
	 * return <tt>NULL</tt>, this will be an indication that the native identifier is filled
	 * in another place, or that the identifier is filled by the container.
	 *
	 * The method accepts the same parameters as the {@link Precommit()} method which passes
	 * them to this one. The first one should resolve into the container in which the object
	 * will be saved, this parameter can be useful when committing embedded objects which
	 * reside in different containers. The second parameter represents the operation options
	 * which can be useful to determine whether the object is being inserted, replaced or
	 * updated.
	 *
	 * In this class we do not have attributes that can be used to generate an identifier,
	 * so we let the container set the identifier, and return <tt>NULL</tt>.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param bitfield				$theModifiers		Commit options.
	 *
	 * @access protected
	 * @return string|NULL			The object's global unique identifier.
	 *
	 * @uses _index()
	 */
	protected function _index( CConnection $theConnection, $theModifiers )
	{
		return NULL;																// ==>
	
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
	 * In this class we prevent the modification of offsets that concur in the generation of
	 * the object's identifier if the object has its {@link _IsCommitted()} status set. This
	 * is because referenced objects must not change identifier.
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
	 * @see kOFFSET_NID kOFFSET_GID
	 */
	protected function _Preset( &$theOffset, &$theValue )
	{
		//
		// Intercept identifiers.
		//
		$offsets = array( kOFFSET_NID, kOFFSET_GID );
		if( $this->_IsCommitted()
		 && in_array( $theOffset, $offsets ) )
			throw new Exception
				( "You cannot modify the [$theOffset] offset: "
				 ."the object is committed",
				  kERROR_LOCKED );												// !@! ==>
		
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
	 * In this class we prevent the modification of offsets that concur in the generation of
	 * the object's identifier if the object has its {@link _IsCommitted()} status set. This
	 * is because referenced objects must not change identifier.
	 *
	 * @param reference			   &$theOffset			Offset.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 *
	 * @uses _IsCommitted()
	 *
	 * @see kOFFSET_NID kOFFSET_GID
	 */
	protected function _Preunset( &$theOffset )
	{
		//
		// Intercept identifiers.
		//
		$offsets = array( kOFFSET_NID, kOFFSET_GID );
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
 *							PROTECTED PERSISTENCE INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_Precommit																		*
	 *==================================================================================*/

	/**
	 * <h4>Prepare the object before committing</h4>
	 *
	 * In this class we overload this method to set the identification properties. We first
	 * call the parent method which will assert whether the object has the
	 * {@link _IsInited()} state set, then we perform the following operations:
	 *
	 * <ul>
	 *	<li><i>Insert</i> or <i>replace</i>:
	 *	 <ul>
	 *		<li><tt>{@link kOFFSET_GID}</tt>: We check whether this offset is present, if
	 *			not, we call the {@link _index()} method and if the result of that method is
	 *			not <tt>NULL</tt>, we set the offset with that value.
	 *		<li><tt>{@link kOFFSET_NID}</tt>: We check whether this offset is present, if
	 *			not, we check if the {@link kOFFSET_GID} offset is there: in that case we
	 *			feed the latter's value to the {@link _id()} method and set the result into
	 *			the {@link kOFFSET_NID} offset.
	 *	 </ul>
	 *	<li><i>Insert</i>, <i>replace</i> or <i>update</i>:
	 *	 <ul>
	 *		<li><tt>{@link kOFFSET_CLASS}</tt>: We set this offset with the current class
	 *			name.
	 *	 </ul>
	 * </ul>
	 *
	 * @param CConnection			$theConnection		Container.
	 * @param bitfield				$theModifiers		Commit options.
	 *
	 * @access protected
	 *
	 * @uses _id()
	 * @uses _index()
	 * @uses _ResolveContainer()
	 *
	 * @see kOFFSET_NID kOFFSET_GID kOFFSET_CLASS
	 */
	protected function _Precommit( CConnection $theConnection,
											   $theModifiers = kFLAG_DEFAULT )
	{
		//
		// Call parent method.
		// Raises exception if not inited.
		//
		parent::_Precommit( $theConnection, $theModifiers );
		
		//
		// Filter options.
		//
		$options = $theModifiers & kFLAG_PERSIST_MASK;
		
		//
		// Handle insert or replace.
		//
		if( ($options == kFLAG_PERSIST_INSERT)
		 || ($options == kFLAG_PERSIST_REPLACE) )
		{
			//
			// Set global identifier.
			//
			if( ! $this->offsetExists( kOFFSET_GID ) )
			{
				//
				// Generate global identifier.
				//
				$index = $this->_index( $theConnection, $theModifiers );
				if( $index !== NULL )
					$this->offsetSet( kOFFSET_GID, $index );
			
			} // Missing global identifier.
		
			//
			// Set native identifier.
			//
			if( ! $this->offsetExists( kOFFSET_NID ) )
			{
				//
				// Use global identifier.
				//
				if( $this->offsetExists( kOFFSET_GID ) )
					$this->offsetSet( kOFFSET_NID,
									  $this->_id( $this->offsetGet( kOFFSET_GID ),
												  $this->ResolveContainer( $theConnection,
																		   TRUE ) ) );
			
			} // Missing native identifier.
		
		} // Insert.
		
		//
		// Handle update.
		//
		if( $options == kFLAG_PERSIST_UPDATE )
		{
			//
			// Check native identifier.
			//
			if( ! $this->offsetExists( kOFFSET_NID ) )
				throw new Exception
					( "Unable to update object: "
					 ."the native identifier is missing",
					  kERROR_STATE );											// !@! ==>
		
		} // Update.
		
		//
		// Handle insert, replace or update.
		//
		if( ($options == kFLAG_PERSIST_INSERT)
		 || ($options == kFLAG_PERSIST_REPLACE)
		 || ($options == kFLAG_PERSIST_UPDATE) )
			$this->offsetSet( kOFFSET_CLASS, get_class( $this ) );
		
	} // _PreCommit.
		


/*=======================================================================================
 *																						*
 *							PROTECTED VALIDATION INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_AssertClass																	*
	 *==================================================================================*/

	/**
	 * <h4>Ensure the provided object is of the correct class</h4>
	 *
	 * This method can be used to check whether the provided value is of the correct class.
	 * the method will first check if the value corresponds to a base class,
	 * <tt>$theBaseClass</tt>, it will then check if the object is an instance of a
	 * derived class, <tt>$theDerivedClass</tt>.
	 *
	 * If the value is not an object of the base class, the method will return
	 * <tt>NULL</tt>, if the object is an instance of both the base and derived classes, the
	 * method will return <tt>TRUE</tt>; if the object is not an instance of the derived
	 * class: if the second parameter, <tt>$doThrow</tt>, is <tt>TRUE</tt>, the method will
	 * raise an exception, if not, it will return <tt>FALSE</tt>.
	 *
	 * If you omit the derived class, the test will return <tt>TRUE</tt>, if the value is an
	 * instance of the base class.
	 *
	 * @param reference				$theValue			Value to assert.
	 * @param string				$theBaseClass		Base class to test.
	 * @param string				$theDerivedClass	Derived class to test.
	 * @param boolean				$doThrow			If <tt>TRUE</tt> raise exception.
	 *
	 * @access protected
	 * @return mixed				<tt>TRUE</tt> correct object,; <tt>NULL</tt> bot an
	 *								object; <tt>FALSE</tt> not an object.
	 *
	 * @uses _id()
	 * @uses _index()
	 * @uses _ResolveContainer()
	 *
	 * @see kOFFSET_NID kOFFSET_GID kOFFSET_CLASS
	 */
	protected function _AssertClass( &$theValue, $theBaseClass, $theDerivedClass = NULL,
																$doThrow = FALSE )
	{
		//
		// Handle object.
		//
		if( $theValue instanceof $theBaseClass )
		{
			//
			// Handle derived class.
			//
			if( $theDerivedClass !== NULL )
			{
				//
				// Check derived class.
				//
				if( $theValue instanceof $theDerivedClass )
					return TRUE;													// ==>
				
				//
				// Raise exception.
				//
				if( $doThrow )
					throw new Exception
						( "The object value is not of the correct class",
						  kERROR_PARAMETER );									// !@! ==>
				
				return FALSE;														// ==>
			
			} // Provided derived class.
			
			return TRUE;															// ==>
			
		} // Object of base class.
		
		return NULL;																// ==>
		
	} // _AssertClass.

	 

} // class CPersistentObject.


?>

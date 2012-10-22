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
 * Tags.
 *
 * This includes the default tag definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_DEFINE."/Tags.inc.php" );

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
 * predefined offset, {@link kTAG_GID}.
 *
 * This value will be used to generate the <i>native unique identifier</i>,
 * {@link kOFFSET_NID}, which represents the object's primary key within the container in
 * which it is stored. The value is obtained by feeding the {@link kTAG_GID} to a static
 * method, {@link _id()}, whose function is to transform the provided value into one
 * optimised as a primary key. The method is static so that any global identifier can be
 * converted into a native one.
 *
 * Once the object has been committed, these identifiers are locked by the {@link _Preset()}
 * and {@link _Preunset()} methods to prevent invalidating object references.
 *
 * The class features a predefined offset, {@link kTAG_CLASS}, that receives the class
 * name of the object: this value will be used by the static {@link NewObject()} method to
 * instantiate the correct object.
 *
 * All objects derived from this class should implement the {@link __toString()} method, by
 * default this class returns the global identifier, {@link kTAG_GID}. Derived classes
 * may change this behaviour, in particular when the class does not feature the global
 * identifier: the important thing is to be able to cast an object to a string.
 *
 * Finally, the class features member accessor methods for the default offsets:
 *
 * <ul>
 *	<li>{@link GID()}: This method manages the global unique identifier,
 *		{@link kTAG_GID}.
 *	<li>{@link ClassName()}: This method manages the object's class name,
 *		{@link kTAG_CLASS}.
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
	 * By default we return the value of the {@link kTAG_GID} offset, if this offset is
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
		if( $this->offsetExists( kTAG_GID ) )
			return $this->offsetGet( kTAG_GID );									// ==>
		
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
	 * The <i>global unique identifier</i>, {@link kTAG_GID}, holds a string which
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
	 * @see kTAG_GID
	 */
	public function GID( $theValue = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kTAG_LID, $theValue, $getOld );					// ==>

	} // GID.

	 
	/*===================================================================================
	 *	CLassName																		*
	 *==================================================================================*/

	/**
	 * <h4>Manage global unique identifier</h4>
	 *
	 * The <i>class name</i>, {@link kTAG_CLASS}, holds a string which is the class
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
	 * @see kTAG_CLASS
	 */
	public function CLassName( $theValue = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kTAG_CLASS, $theValue, $getOld );				// ==>

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
	 * We override this method to handle the {@link kTAG_CLASS} offset: if found in the
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
			if( array_key_exists( kTAG_CLASS, $object ) )
			{
				//
				// Save class name.
				//
				$class = $object[ kTAG_CLASS ];
				
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

	 
	/*===================================================================================
	 *	DocumentObject																	*
	 *==================================================================================*/

	/**
	 * <h4>Instantiate an object from a document</h4>
	 *
	 * This method can be used to instantiate an object from an array. The method will
	 * attempt to locate the class name, {@link kTAG_CLASS}, if found, it will return an
	 * object of that class, if not, it will return the unchanged received document.
	 *
	 * If the class name was found, the resulting object will have its
	 * {@link _IsCommitted()} status set, so provide only data received from database
	 * queries.
	 *
	 * The method accepts arrays and ArrayObjects, any other type will raise an exception.
	 *
	 * @param mixed					$theDocument		Persistent object data.
	 *
	 * @static
	 * @return mixed				The document or an object.
	 */
	static function DocumentObject( $theDocument )
	{
		//
		// Check document.
		//
		if( $theDocument instanceof ArrayObject )
			$theDocument = $theDocument->getArrayCopy();
		elseif( ! is_array( $theDocument  ) )
			throw new Exception
				( "Invalid document type",
				  kERROR_PARAMETER );											// !@! ==>
		
		//
		// Handle object.
		//
		if( array_key_exists( kTAG_CLASS, $theDocument ) )
		{
			//
			// Instantiate object.
			//
			$class = $theDocument[ kTAG_CLASS ];
			$object = new $class( $theDocument );
			
			//
			// Mark as committed.
			//
			$object->_IsCommitted( TRUE );
			
			return $object;															// ==>
		
		} // Has class name.
		
		return $theDocument;														// ==>
	
	} // DocumentObject.
		


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
	 * identifier</i>, {@link kTAG_GID}.
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
	 * This string is stored in the {@link kTAG_GID} offset of the object and it is
	 * processed by the static {@link _id()} method to generate the object's native unique
	 * identifier, which is the native object's primary key stored in the
	 * {@link kOFFSET_NID} offset.
	 *
	 * This method is called by the {@link _Precommit()} method, to fill the
	 * {@link kTAG_GID} offset and the resulting value is fed to the {@link _id()} method
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
	 * @see kOFFSET_NID kTAG_GID
	 */
	protected function _Preset( &$theOffset, &$theValue )
	{
		//
		// Intercept identifiers.
		//
		$offsets = array( kOFFSET_NID, kTAG_GID );
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
	 * @see kOFFSET_NID kTAG_GID
	 */
	protected function _Preunset( &$theOffset )
	{
		//
		// Intercept identifiers.
		//
		$offsets = array( kOFFSET_NID, kTAG_GID );
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
 *							PROTECTED PRE-COMMIT INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_PrecommitValidate																*
	 *==================================================================================*/

	/**
	 * <h4>Validate the object before committing</h4>
	 *
	 * In this class we check if the current object has its native identifier,
	 * {@link kOFFSET_NID}, if the operation involves updating.
	 *
	 * @param reference			   &$theConnection		Server, database or container.
	 * @param reference			   &$theModifiers		Commit options.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 *
	 * @see kFLAG_PERSIST_MASK kFLAG_PERSIST_UPDATE kOFFSET_NID
	 */
	protected function _PrecommitValidate( &$theConnection, &$theModifiers )
	{
		//
		// Call parent method.
		//
		parent::_PrecommitValidate( $theConnection, $theModifiers );
		
		//
		// Handle update.
		//
		if( ($theModifiers & kFLAG_PERSIST_MASK) == kFLAG_PERSIST_UPDATE )
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
		
	} // _PrecommitValidate.

	 
	/*===================================================================================
	 *	_PrecommitRelated																*
	 *==================================================================================*/

	/**
	 * <h4>Handle embedded or related objects before committing</h4>
	 *
	 * In this class we have no related objects, but we use this method to set default
	 * values, such as the class name in {@link kTAG_CLASS} when inserting, replacing or
	 * updating.
	 *
	 * @param reference			   &$theConnection		Server, database or container.
	 * @param reference			   &$theModifiers		Commit options.
	 *
	 * @access protected
	 *
	 * @see kTAG_CLASS
	 * @see kFLAG_PERSIST_INSERT kFLAG_PERSIST_REPLACE kFLAG_PERSIST_UPDATE
	 */
	protected function _PrecommitRelated( &$theConnection, &$theModifiers )
	{
		//
		// Call parent method.
		//
		parent::_PrecommitRelated( $theConnection, $theModifiers );
		
		//
		// Set class name.
		//
		if( (($theModifiers & kFLAG_PERSIST_MASK) == kFLAG_PERSIST_INSERT)
		 || (($theModifiers & kFLAG_PERSIST_MASK) == kFLAG_PERSIST_REPLACE)
		 || (($theModifiers & kFLAG_PERSIST_MASK) == kFLAG_PERSIST_UPDATE) )
			$this->offsetSet( kTAG_CLASS, get_class( $this ) );
	
	} // _PrecommitRelated.

	 
	/*===================================================================================
	 *	_PrecommitIdentify																*
	 *==================================================================================*/

	/**
	 * <h4>Determine the identifiers before committing</h4>
	 *
	 * In this class this method is called only if the operation involves inserting or
	 * replacing.
	 *
	 * If the {@link kTAG_GID} offset is missing, we call the {@link _index()} method: if
	 * the result of that method is not <tt>NULL</tt>, we use it to set the
	 * {@link kTAG_GID} offset value, this only if the operation involves inserting or
	 * replacing.
	 *
	 * If the {@link kOFFSET_NID} offset is missing, we check if the {@link kTAG_GID}
	 * offset was set: in that case we use its value to feed the {@link _id()} method and
	 * the result is set in the {@link kOFFSET_NID} offset.
	 *
	 * This workflow implies that only if the {@link _index()} method returns a non
	 * <tt>NULL</tt> value, the {@link kTAG_GID} offset will be set in this method, and
	 * that if the {@link kTAG_GID} offset is missing the native identifier will not be
	 * touched.
	 *
	 * Note that this is the only place in which the {@link _index()} method is called.
	 *
	 * @param reference			   &$theConnection		Server, database or container.
	 * @param reference			   &$theModifiers		Commit options.
	 *
	 * @access protected
	 *
	 * @uses _id()
	 * @uses _index()
	 * @uses ResolveContainer()
	 *
	 * @see kTAG_GID kOFFSET_NID
	 * @see kFLAG_PERSIST_INSERT kFLAG_PERSIST_REPLACE
	 */
	protected function _PrecommitIdentify( &$theConnection, &$theModifiers )
	{
		//
		// Call parent method.
		//
		parent::_PrecommitValidate( $theConnection, $theModifiers );
		
		//
		// Handle insert or replace.
		//
		if( (($theModifiers & kFLAG_PERSIST_MASK) == kFLAG_PERSIST_INSERT)
		 || (($theModifiers & kFLAG_PERSIST_MASK) == kFLAG_PERSIST_REPLACE) )
		{
			//
			// Set global identifier.
			//
			if( ! $this->offsetExists( kTAG_GID ) )
			{
				//
				// Generate global identifier.
				//
				$index = $this->_index( $theConnection, $theModifiers );
				if( $index !== NULL )
					$this->offsetSet( kTAG_GID, $index );
			
			} // Missing global identifier.
		
			//
			// Set native identifier.
			//
			if( ! $this->offsetExists( kOFFSET_NID ) )
			{
				//
				// Use global identifier.
				//
				if( $this->offsetExists( kTAG_GID ) )
					$this->offsetSet( kOFFSET_NID,
									  $this->_id( $this->offsetGet( kTAG_GID ),
												  $this->ResolveContainer( $theConnection,
																		   TRUE ) ) );
			
			} // Missing native identifier.
		
		} // Insert or replace.
	
	} // _PrecommitIdentify.
		


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
	 * @throws Exception
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
		
		//
		// Handle missing derived class.
		//
		if( $theDerivedClass === NULL )
		{
			//
			// Raise exception
			//
			if( $doThrow )
				throw new Exception
					( "The object value is not of the correct class",
					  kERROR_PARAMETER );										// !@! ==>
			
			return FALSE;															// ==>
		
		} // Missing derived class.
		
		return NULL;																// ==>
		
	} // _AssertClass.

	 

} // class CPersistentObject.


?>

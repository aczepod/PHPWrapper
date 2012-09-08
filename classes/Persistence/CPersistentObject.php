<?php namespace MyWrapper\Persistence;

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
 * Container.
 *
 * This includes the containers ancestor class definitions.
 */
use \MyWrapper\Framework\CContainer;

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
use \MyWrapper\Persistence\CPersistentDocument;

/**
 * Local definitions.
 *
 * This includes the class local definitions.
 */
require_once( 'CPersistentObject.inc.php' );

/**
 * <h3>Persistent object ancestor</h3>
 *
 * This <i>abstract</i> class extends its {@link CPersistentDocument} ancestor to handle
 * predefined offsets and a specific identification workflow.
 *
 * This class implements an identification interface that governs how objects derived from
 * this class are identified within their container.
 *
 * The object is uniquely identified by a string, the <i>global unique identifier</i>, this
 * string is generally a combination of the object's attributes and once set, it should not
 * change. The string is determined by a protected method, {@link _index()}, and optionally
 * set into a predefined offset, {@link kOFFSET_GID}.
 *
 * This value is used by a static method, {@link _id()}, which processes or uses that value
 * as-is to set the object's <i>native unique identifier</i> in the {@link kOFFSET_NID}
 * offset. This static method can also be used to obtain the primary key of an object, given
 * the global identifier string. The method expects the container to which the object is
 * going to be committed as a parameter, to use its custom data conversion methods and
 * resolve eventual references.
 *
 * These identifiers are locked by the {@link _Preset()} and {@link _Preunset()} methods
 * to prevent invalidating references.
 *
 * Objects derived from this class store their class name in the {@link kOFFSET_CLASS}
 * offset, this will be used by the static {@link NewObject()} method to instantiate the
 * right object.
 *
 * The class implements the above workflow by overloading the {@link _Precommit()} method.
 *
 * Finally, the class features member accessor methods for the default offsets:
 *
 * <ul>
 *	<li>{@link NID()}: This method manages the native unique identifier,
 *		{@link kOFFSET_NID}.
 *	<li>{@link GID()}: This method manages the global unique identifier,
 *		{@link kOFFSET_GID}.
 *	<li>{@link ClassName()}: This method manages the object's class name,
 *		{@link kOFFSET_CLASS}.
 * </ul>
 *
 *	@package	MyWrapper
 *	@subpackage	Persistence
 */
class CPersistentObject extends \MyWrapper\Persistence\CPersistentDocument
{
		

/*=======================================================================================
 *																						*
 *								PUBLIC MEMBER INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	NID																				*
	 *==================================================================================*/

	/**
	 * <h4>Manage native unique identifier</h4>
	 *
	 * The <i>native unique identifier</i>, {@link kOFFSET_NID}, represents the primary key
	 * of the object in the native format of the container in which the object is stored.
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
	 * @see kOFFSET_NID
	 */
	public function NID( $theValue = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kOFFSET_NID, $theValue, $getOld );				// ==>

	} // NID.

	 
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
	 * missing, the method will instantiate this class.
	 *
	 * The method expects two parameters:
	 *
	 * <ul>
	 *	<li><tt>$theContainer</tt>: A concrete instance of the
	 *		{@link  MyWrapper\Framework\CContainer} class.
	 *	<li><tt>$theIdentifier</tt>: The key of the object in the container, by default the
	 *		{@link kOFFSET_NID} offset.
	 * </ul>
	 *
	 * If the object could not be located, the method will return <tt>NULL</tt>.
	 *
	 * @param CContainer			$theContainer		Container.
	 * @param mixed					$theIdentifier		Identifier.
	 *
	 * @static
	 * @return mixed				The retrieved object.
	 */
	static function NewObject( CContainer $theContainer,
										  $theIdentifier )
	{
		//
		// Init local storage.
		//
		$object = array( kOFFSET_NID => $theIdentifier );
		
		//
		// Retrieve object.
		//
		if( $theContainer->ManageObject( $object ) )
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
				$object = new self( $object );
			
			//
			// Post-commit.
			//
			if( $object instanceof CPersistentDocument )
				$object->_Postcommit( $theContainer );
			
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
	 * This method is used to generate the object's <i>native unique identifier</i> from the
	 * string representing the object's <i>global unique identifier</i>.
	 *
	 * The method expects a string as input and should either return it as-is, or hash it.
	 * This method will be used to set the {@link kOFFSET_NID} offset which represents the
	 * primary key of the object and can be used to generate a primary key given the global
	 * unique identifier of the object. The second parameter to this method is the container
	 * that will receive the object, this can be useful if it provides custom data
	 * conversion methods.
	 *
	 * Note that if the provided value is <tt>NULL</tt>, this means that it is the duty of
	 * the container to set the object's primary key, in this case this method cannot be
	 * used to generate a native identifier, since the object does not have a global
	 * identifier.
	 *
	 * In this class we use the global identifier as-is.
	 *
	 * @param string				$theIdentifier		Global unique identifier.
	 * @param CContainer			$theContainer		Container.
	 *
	 * @static
	 * @return mixed				The object's native unique identifier.
	 */
	static function _id( $theIdentifier = NULL, CContainer $theContainer = NULL )
	{
		return $theIdentifier;
	
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
	 * object and represents the unique key of the object.
	 *
	 * This string is stored in the {@link kOFFSET_GID} offset of the object and it is
	 * processed by the static {@link _id()} method resulting in the object's native unique
	 * identifier, which is the native object's primary key stored in the
	 * {@link kOFFSET_NID} offset.
	 *
	 * This method can return a meaningful value only if the object has all required
	 * properties, so, if the class features a global identifier, this method should first
	 * check is the object is {@link _IsInited()}, if that is not the case it should raise
	 * an exception.
	 *
	 * If this method returns <tt>NULL</tt>, it means that the native unique identifier is
	 * generated by the container that will store the object, in that case the
	 * {@link kOFFSET_GID} will not be used.
	 *
	 * This method is called at commit time, for this reason and to eventually resolve
	 * referenced objects, the method accepts the commit container and options.
	 *
	 * This class has no predefined attributes, so we let the container provide the
	 * identifier by returning <tt>NULL</tt>.
	 *
	 * @param CContainer			$theContainer		Container.
	 * @param bitfield				$theModifiers		Commit options.
	 *
	 * @access protected
	 * @return string|NULL			The object's global unique identifier.
	 *
	 * @uses _index()
	 */
	protected function _index( $theContainer, $theModifiers )
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
	 * @throws \Exception
	 *
	 * @uses _IsCommitted()
	 *
	 * @see kOFFSET_NID kOFFSET_GID kOFFSET_LID
	 */
	protected function _Preset( &$theOffset, &$theValue )
	{
		//
		// Intercept identifiers.
		//
		$offsets = array( kOFFSET_NID, kOFFSET_GID, kOFFSET_LID );
		if( $this->_IsCommitted()
		 && in_array( $theOffset, $offsets ) )
			throw new \Exception
				( "The object is committed, you cannot modify the [$theOffset] offset",
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
	 * @throws \Exception
	 *
	 * @uses _IsCommitted()
	 *
	 * @see kOFFSET_NID kOFFSET_GID kOFFSET_LID
	 */
	protected function _Preunset( &$theOffset )
	{
		//
		// Intercept identifiers.
		//
		$offsets = array( kOFFSET_NID, kOFFSET_GID, kOFFSET_LID );
		if( $this->_IsCommitted()
		 && in_array( $theOffset, $offsets ) )
			throw new \Exception
				( "The object is committed, you cannot modify the [$theOffset] offset",
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
	 * In this class we overload this method to set the following properties:
	 *
	 * <ul>
	 *	<li>{@link _IsInited()}: We check whether the object was initialised, if that is
	 *		not the case, the method will raise an exception.
	 *	<li>{@link kOFFSET_NID}: If missing and if the result of the {@link _index()} method
	 *		is not <tt>NULL</tt>, we set the native unique identifier by feeding the string
	 *		returned by {@link _index()} into the {@link _id()} method.
	 *	<li>{@link kOFFSET_GID}: If missing and if the result of the {@link _index()} method
	 *		is not <tt>NULL</tt>, we set the global unique identifier with the result of
	 *		{@link _index()}.
	 *	<li>{@link kOFFSET_CLASS}: If missing, we set this offset to the current class name.
	 *		Note that we do not set the class automatically, as a superclass may instantiate
	 *		safely a subclass.
	 * </ul>
	 *
	 * @param CContainer			$theContainer		Container.
	 * @param bitfield				$theModifiers		Commit options.
	 *
	 * @access protected
	 *
	 * @throws \Exception
	 *
	 * @uses _id()
	 * @uses _index()
	 *
	 * @see kOFFSET_NID kOFFSET_GID kOFFSET_CLASS
	 */
	protected function _Precommit( CContainer $theContainer,
											  $theModifiers = kFLAG_DEFAULT )
	{
		//
		// Call parent method.
		//
		parent::_Precommit( $theContainer, $theModifiers );
		
		//
		// Handle commits.
		//
		if( $theModifiers & kFLAG_PERSIST_WRITE_MASK )
		{
			//
			// Handle native identifier.
			//
			if( ! $this->offsetExists( kOFFSET_NID ) )
			{
				//
				// Generate global identifier.
				//
				$index = $this->_index( $theContainer, $theModifiers );
				
				//
				// Handle global identifier.
				//
				if( $index !== NULL )
				{
					//
					// Set global identifier.
					//
					$this->offsetSet( kOFFSET_GID, $index );
				
					//
					// Set native identifier.
					//
					$this->offsetSet( kOFFSET_NID, $this->_id( $index, $theContainer ) );
				
				} // Identifier is handled by object.
			
			} // Native identifier not set.
			
			//
			// Handle class.
			//
			if( ! $this->offsetExists( kOFFSET_CLASS ) )
				$this->offsetSet( kOFFSET_CLASS, get_class( $this ) );
		
		} // Insert, update, replace and modify (not used).
		
	} // _PreCommit.

	 

} // class CPersistentObject.


?>

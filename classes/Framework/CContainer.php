<?php namespace MyWrapper\Framework;

/**
 * <i>CContainer</i> class definition.
 *
 * This file contains the class definition of <b>CContainer</b> which represents the
 * ancestor of all container objects in this library.
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 03/09/2012
 */

/*=======================================================================================
 *																						*
 *									CContainer.php										*
 *																						*
 *======================================================================================*/

/**
 * Offsets.
 *
 * This include file contains all default offset definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_DEFINE."/Offsets.inc.php" );

/**
 * Accessors.
 *
 * This include file contains all accessor function definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_FUNCTION."/accessors.php" );

/**
 * <h3>Persistent objects data store ancestor</h3>
 *
 * This <i>abstract</i> class is the ancestor of all container classes in this library, it
 * implements the interface and workflow that all concrete derived classes should implement.
 *
 * The public interface declares the following main operations:
 *
 * <ul>
 *	<li>{@link SetObject()}: This method will <i>insert</i>, <i>update</i>, <i>modify</i> or
 *		<i>delete</i> objects from the current container. This method operates one object at
 *		the time and it is mainly used by persistent objects for persisting in containers.
 *	<li><i>{@link GetObject()}</i>: This method will <i>load</i> an object from the current
 *		container.
 * </ul>
 *
 * The class does not implement a concrete data store, derived classes must implement
 * specific storage actions.
 *
 * The class inherits from {@link CStatusDocument} in order to manage its own status and the
 * one of the provided persistent objects.
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 */
abstract class CContainer extends CStatusDocument
{
	/**
	 * Persistent data store.
	 *
	 * This data member holds the native persistent store.
	 *
	 * @var mixed
	 */
	 protected $mContainer = NULL;

		

/*=======================================================================================
 *																						*
 *											MAGIC										*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	__construct																		*
	 *==================================================================================*/

	/**
	 * <h4>Instantiate class</h4>
	 *
	 * You instantiate the class with a native data store, the method expects a single
	 * parameter that will be handled specifically by specialised derived classes.
	 *
	 * Derived classes should overload this method if a default value is possible; to check
	 * for specific container types they should rather overload the member accessor method.
	 *
	 * @param mixed					$theContainer		Native object store.
	 *
	 * @access public
	 *
	 * @uses Container()
	 */
	public function __construct( $theContainer = NULL )
	{
		//
		// Handle native container.
		//
		if( $theContainer !== NULL )
			$this->Container( $theContainer );
		
	} // Constructor.

	 
	/*===================================================================================
	 *	__toString																		*
	 *==================================================================================*/

	/**
	 * <h4>Return container name</h4>
	 *
	 * This method should return the current container's name.
	 *
	 * All derived concrete classes should implement this method, all containers must be
	 * able to return a name.
	 *
	 * @access public
	 * @return string				The container name.
	 */
	abstract public function __toString();

		

/*=======================================================================================
 *																						*
 *								PUBLIC MEMBER INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Container																		*
	 *==================================================================================*/

	/**
	 * <h4>Manage persistent container</h4>
	 *
	 * This method can be used to manage the persistent container, it accepts a single
	 * parameter which represents either the container or the requested operation,
	 * depending on its value:
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
	 * In derived classes you should overload this method to check if the provided container
	 * is of the correct type, in this class we accept anything.
	 *
	 * This class is considered initialised ({@link _IsInited()}) when this member has been
	 * set.
	 *
	 * @param mixed					$theValue			Persistent container or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> native container.
	 *
	 * @uses _IsInited()
	 * @uses ManageProperty()
	 */
	public function Container( $theValue = NULL, $getOld = FALSE )
	{
		//
		// Handle data member.
		//
		$save = ManageProperty( $this->mContainer, $theValue, $getOld );
		
		//
		// Handle status.
		//
		if( $theValue !== NULL )
			$this->_IsInited( $this->mContainer !== NULL );
		
		return $save;																// ==>

	} // Container.

		

/*=======================================================================================
 *																						*
 *								PUBLIC PERSISTENCE INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	ManageObject																	*
	 *==================================================================================*/

	/**
	 * <h4>Manage an object from the container</h4>
	 *
	 * This method can be used to manage a single object in the container, it can
	 * <i>insert</i>, <i>update</i>, <i>replace</i>, <i>modify</i>, <i>retrieve</i> and
	 * <i>delete</i> an object from the current container by providing the object and/or
	 * its local unique identifier ({@link kTAG_LID}).
	 *
	 * This method expects three parameters:
	 *
	 * <ul>
	 *	<li><tt>$theObject</tt>: The object or the data to be modified.
	 *	<li><tt>$theIdentifier</tt>: The local unique identifier ({@link kTAG_LID}) of the
	 *		object. If the value is <i>NULL</i>, it means that it is the duty of the current
	 *		container to set the value, this will generally be the case when inserting
	 *		objects; in all other cases the parameter is required.
	 *	<li><tt>$theModifiers</tt>: This parameter represents the operation options, it is a
	 *		bitfield where the following values apply:
	 *	 <ul>
	 *		<li>{@link kFLAG_PERSIST_INSERT}: The provided object will be inserted in the
	 *			container. It is assumed that no other element in the container shares
	 *			the same identifier, if not, the method should raise an exception.
	 *			In this case the <tt>$theObject</tt> represents the full object and
	 *			<tt>$theIdentifier</tt> represents the object unique identifier, or
	 *			<tt>NULL</tt>, if it is the duty of the container to create the identifier.
	 *			If the identifier was created by the container, it is the duty of this
	 *			method to set it into the provided object.
	 *			In this case the method should return the inserted object's native
	 *			identifier ({@link kTAG_LID}).
	 *		<li>{@link kFLAG_PERSIST_UPDATE}: The provided object will replace an
	 *			object existing in the container. In this case the method expects the
	 *			container to have an entry with the same key as the provided identifier,
	 *			if this is not the case the method should raise an exception.
	 *			In this case the <tt>$theObject</tt> represents the full object and
	 *			<tt>$theIdentifier</tt> represents the object unique identifier.
	 *			In this case the method should return <tt>TRUE</tt> if the object was
	 *			updated and <tt>FALSE</tt> if the object was not found.
	 *		<li>{@link kFLAG_PERSIST_REPLACE}: The provided object will be inserted
	 *			if the identifier is missing or it doesn't match any entry in the container,
	 *			or it will update the object corresponding to the provided identifier. This
	 *			option represents the combination of the {@link kFLAG_PERSIST_INSERT} and
	 *			{@link kFLAG_PERSIST_UPDATE} operations.
	 *			In this case the <tt>$theObject</tt> represents the full object and
	 *			<tt>$theIdentifier</tt> represents the object unique identifier, or
	 *			<tt>NULL</tt>, if it is the duty of the container to create the identifier.
	 *			If the identifier was created by the container, it is the duty of this
	 *			method to set it into the provided object.
	 *			In this case the method should return the inserted object's native
	 *			identifier ({@link kTAG_LID}).
	 *		<li>{@link kFLAG_PERSIST_MODIFY}: This option can be used to apply modifications
	 *			to a subset of the object.
	 *			In this case, <tt>$theObject</tt> should contain the modification
	 *			<i>criteria</i> and <tt>$theIdentifier</tt> should contain the object's
	 *			unique identifier, if the object cannot be located in the container, the
	 *			method should not fail.
	 *			In this case the method should set the modified object in the referenced
	 *			parameter and return <tt>TRUE</tt> if the object was found and return
	 *			<tt>FALSE</tt> if the object was not found.
	 *		<li>{@link kFLAG_PERSIST_DELETE}: This option assumes you want to remove the
	 *			object from the container.
	 *			In this case the <tt>$theObject</tt> represents the full object and
	 *			<tt>$theIdentifier</tt> represents the object unique identifier, what
	 *			counts is that the object's unique identifier ({@link kTAG_LID}) is
	 *			provided. If the object is not found in the container, the method should
	 *			not fail.
	 *			In this case the method should return <tt>TRUE</tt> if the object was
	 *			deleted and <tt>FALSE</tt> if the object was not found.
	 *	 </ul>
	 *		If none of the above flags are set, it means that the caller wants to retrieve
	 *		the object identified by the {@link kTAG_LID} offset from the provided object
	 *		object or from the provided identifier. If found, the provided object will
	 *		receive the located object and the method will return <tt>TRUE</tt>; if not
	 *		found, the method will set the provided object to <tt>NULL</tt> and return
	 *		<tt>FALSE</tt>.
	 * </ul>
	 *
	 * The method should raise an exception if the operation was not successful and update
	 * the provided object with whatever data the operation will generate.
	 *
	 * The method will also raise an exception if the object is not yet initialised
	 * ({@link _IsInited()}), this happens when the object received the native container.
	 *
	 * This class is abstract, which means that derived classes must implement the specific
	 * functionality of specialised data stores, for this reason this method will only check
	 * if the current object is inited.
	 *
	 * @param reference			   &$theObject			Object.
	 * @param mixed					$theIdentifier		Identifier.
	 * @param bitfield				$theModifiers		Options.
	 *
	 * @access public
	 * @return mixed				The native operation status.
	 *
	 * @uses _IsInited()
	 *
	 * @see kFLAG_PERSIST_INSERT kFLAG_PERSIST_UPDATE kFLAG_PERSIST_MODIFY
	 * @see kFLAG_PERSIST_REPLACE kFLAG_PERSIST_MODIFY kFLAG_PERSIST_DELETE
	 */
	public function ManageObject( &$theObject,
								   $theIdentifier = NULL,
								   $theModifiers = kFLAG_DEFAULT )
	{
		//
		// Check if inited.
		//
		if( ! $this->_IsInited() )
			throw new \Exception
				( "The object is not initialised",
				  kERROR_STATE );												// !@! ==>
	
	} // ManageObject.

		

/*=======================================================================================
 *																						*
 *								PUBLIC CONVERSION INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	ConvertBinary																	*
	 *==================================================================================*/

	/**
	 * <h4>Convert a binary string</h4>
	 *
	 * This method should be used to convert a binary string to a format compatible with the
	 * current container.
	 *
	 * The first parameter represents the value to be encoded or decoded, the second boolean
	 * parameter represents the conversion direction: <tt>TRUE</tt> means convert for
	 * database, <tt>FALSE</tt> convert back to PHP.
	 *
	 * By default we convert the string to hexadecimal.
	 *
	 * @param mixed					$theValue			Binary value.
	 * @param boolean				$theSense			<tt>TRUE</tt> encode for database.
	 *
	 * @static
	 * @return mixed				The encoded or decoded binary string.
	 */
	static function ConvertBinary( $theValue, $theSense = TRUE )
	{
		if( $theSense )
			return bin2hex( $theValue );											// ==>
		
		return hex2bin( $theValue );												// ==>
	
	} // ConvertBinary.

		

/*=======================================================================================
 *																						*
 *								PROTECTED MEMBER INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	&_Container																		*
	 *==================================================================================*/

	/**
	 * <h4>Get container reference</h4>
	 *
	 * This method can be used to retrieve a reference to the native container member, this
	 * can be useful when the native {@link Container()} is not an object passed by
	 * reference.
	 *
	 * @access protected
	 * @return mixed
	 */
	protected function &_Container()						{	return $this->mContainer;	}

	 

} // class CContainer.


?>

<?php

/**
 * <i>CTerm</i> class definition.
 *
 * This file contains the class definition of <b>CTerm</b> which represents the ancestor of
 * all term classes.
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 05/09/2012
 */

/*=======================================================================================
 *																						*
 *										CTerm.php										*
 *																						*
 *======================================================================================*/

/**
 * Local definitions.
 *
 * This include file contains common offset definitions.
 */
require_once( "CTerm.inc.php" );

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
 * <h3>Term object ancestor</h3>
 *
 * A term can be compared to a word of a vocabulary, it is an elementary component that is
 * an abstract concept if considered by itself, but takes a precise meaning if related to
 * other terms, as a sequence of words that constitute a statement.
 *
 * Terms are identified by a string code which is the concatenation of two elements of the
 * object: the namespace, {@link kOFFSET_NAMESPACE}, which represents the group to which the
 * term belongs and the local identifier, {@link kOFFSET_LID}, which represents the unique
 * identifier of the term within its namespace. This code is set in the global identifier,
 * {@link kOFFSET_GID}, and formed by prefixing the namespace to the local identifier,
 * separated by the {@link kTOKEN_NAMESPACE_SEPARATOR} token. This means that both the
 * namespace and the local identifiers must be convertable to a string. If the object has no
 * namespace, the local identifier will become the object's global identifier.
 *
 * When the object is committed, {@link _IsCommitted()}, besides the the identifier offsets,
 * also the {@link kOFFSET_NAMESPACE} offset will be locked, since it is used to generate
 * the global identifier, {@link kOFFSET_GID}.
 *
 * The native unique identifier, {@link kOFFSET_NID}, is the binary md5 hash of the global
 * unique identifier, {@link kOFFSET_GID}, this to allow long codes.
 *
 * The object will have its {@link _IsInited()} status set if the local unique identifier,
 * {@link kOFFSET_LID}, is set, derived classes may add other required attributes.
 *
 * Finally, the class features member accessor methods for the default offsets:
 *
 * <ul>
 *	<li>{@link NS()}: This method manages the term's namespace, {@link kOFFSET_NAMESPACE}.
 *	<li>{@link LID()}: This method manages the local unique identifier,
 *		{@link kOFFSET_LID}.
 * </ul>
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 */
class CTerm extends CPersistentObject
{
		

/*=======================================================================================
 *																						*
 *								PUBLIC MEMBER INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	NS																				*
	 *==================================================================================*/

	/**
	 * <h4>Manage namespace native identifier</h4>
	 *
	 * The <i>namespace native identifier</i>, {@link kOFFSET_NAMESPACE}, holds the native
	 * identifier of the object that represents the term's namespace.
	 *
	 * The method accepts a parameter which represents either the namespace or the
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
	 * @see kOFFSET_NAMESPACE
	 */
	public function NS( $theValue = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kOFFSET_NAMESPACE, $theValue, $getOld );		// ==>

	} // NS.

	 
	/*===================================================================================
	 *	LID																				*
	 *==================================================================================*/

	/**
	 * <h4>Manage local unique identifier</h4>
	 *
	 * The <i>local unique identifier</i>, {@link kOFFSET_LID}, holds a string which
	 * represents the object's unique identifier within its namespace, this value is
	 * concatenated to the eventual's namespace's global identifier to form the term's
	 * global identifier. 
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
	 * @see kOFFSET_LID
	 */
	public function LID( $theValue = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kOFFSET_LID, $theValue, $getOld );				// ==>

	} // LID.

		

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
	 * We overload this method to hash the provided string.
	 *
	 * Since binary data is handled differently by each storage engine, we require the
	 * container parameter and raise an exception if not provided.
	 *
	 * We also raise an exception if the string is not provided, this is because this object
	 * primary key depends on the content of its attributes.
	 *
	 * @param string				$theIdentifier		Global unique identifier.
	 * @param CContainer			$theContainer		Container.
	 *
	 * @static
	 * @return mixed				The object's native unique identifier.
	 *
	 * @throws \Exception
	 */
	static function _id( $theIdentifier = NULL, CContainer $theContainer = NULL )
	{
		//
		// Handle identifier.
		//
		if( $theIdentifier === NULL )
			throw new \Exception
				( "Global unique identifier not provided",
				  kERROR_MISSING );												// !@! ==>
	
		//
		// Check container.
		//
		if( $theContainer === NULL )
			throw new \Exception
				( "The container is needed for encoding binary strings",
				  kERROR_MISSING );												// !@! ==>
		
		return $theContainer->ConvertBinary( md5( $theIdentifier, TRUE ) );			// ==>
	
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
	 * Term identifiers are constituted by the concatenation of the namespace and the local
	 * unique identifier of the current term separated by a
	 * {@link kTOKEN_NAMESPACE_SEPARATOR} token.
	 *
	 * If the term lacks a namespace, its local identifier will become its global
	 * identifier.
	 *
	 * Both the namespace and the local identifier will be converted to strings to compute
	 * the global identifier.
	 *
	 * Note that if the local identifier is missing we call the parent's method, although
	 * this is not possible since it is asserted elsewhere in the workflow.
	 *
	 * @param CContainer			$theContainer		Container.
	 * @param bitfield				$theModifiers		Commit options.
	 *
	 * @access protected
	 * @return string|NULL			The object's global unique identifier.
	 *
	 * @throws \Exception
	 *
	 * @uses _index()
	 */
	protected function _index( $theContainer, $theModifiers )
	{
		//
		// Get term local identifier.
		//
		if( $this->offsetExists( kOFFSET_LID ) )
		{
			//
			// Get code.
			//
			$code = (string) $this->offsetGet( kOFFSET_LID );
			
			//
			// Handle namespace.
			//
			if( $this->offsetExists( kOFFSET_NAMESPACE ) )
				return ((string) $this->offsetGet( kOFFSET_NAMESPACE ))
					  .kTOKEN_NAMESPACE_SEPARATOR
					  .$code;														// ==>
			
			return $code;															// ==>
		
		} // Has local identifier.
		
		return parent::_index( $theContainer, $theModifiers );						// ==>
	
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
	 * The {@link kOFFSET_NAMESPACE} and {@link kOFFSET_LID} are locked if the object was
	 * committed, {@link _IsCommitted()}.
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
		// Intercept namespace and local identifier.
		//
		$offsets = array( kOFFSET_NAMESPACE, kOFFSET_LID );
		if( $this->_IsCommitted()
		 && in_array( $theOffset, $offsets ) )
			throw new \Exception
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
	 * The {@link kOFFSET_NAMESPACE} and {@link kOFFSET_LID} are locked if the object was
	 * committed, {@link _IsCommitted()}.
	 *
	 * @param reference			   &$theOffset			Offset.
	 *
	 * @access protected
	 *
	 * @throws \Exception
	 *
	 * @uses _IsCommitted()
	 */
	protected function _Preunset( &$theOffset )
	{
		//
		// Intercept namespace and local identifier.
		//
		$offsets = array( kOFFSET_NAMESPACE, kOFFSET_LID );
		if( $this->_IsCommitted()
		 && in_array( $theOffset, $offsets ) )
			throw new \Exception
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
	 * {@link kOFFSET_LID} offset.
	 *
	 * @access protected
	 * @return boolean				<tt>TRUE</tt> means {@link _IsInited( <tt>TRUE</tt> ).
	 *
	 * @see kOFFSET_LID
	 */
	protected function _Ready()
	{
		//
		// Check parent.
		//
		if( parent::_Ready() )
			return $this->offsetExists( kOFFSET_LID );								// ==>
		
		return FALSE;																// ==>
	
	} // _Ready.

	 

} // class CTerm.


?>

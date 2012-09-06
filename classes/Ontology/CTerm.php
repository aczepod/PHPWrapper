<?php namespace MyWrapper\Ontology;

/**
 * <i>CTerm</i> class definition.
 *
 * This file contains the class definition of <b>CTerm</b> which represents the ancestor of
 * all persistent ontology term classes.
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
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
 * Tokens.
 *
 * This include file contains all default token definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_DEFINE."/Tokens.inc.php" );

/**
 * Accessors.
 *
 * This include file contains all accessor function definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_FUNCTION."/accessors.php" );

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
use \MyWrapper\Persistence\CPersistentObject;

/**
 * Containers.
 *
 * This includes the container class definitions.
 */
use \MyWrapper\Persistence\CContainer;

/**
 * <h3>Term object ancestor</h3>
 *
 * A term can be compared to a word of a vocabulary, it is an elementary component that is
 * an abstract concept if considered by itself, but takes a precise meaning if related to
 * other terms, as a sequence of words that constitute a statement.
 *
 * This class implements the core features that all terms share:
 *
 * <ul>
 *	<li>{@link kOFFSET_NAMESPACE}: This attribute contains the native unique identifier,
 *		{@link kOFFSET_NID}, of the term that represents the namespace of the current term.
 *	<li>{@link kOFFSET_LID}: This attribute contains the code that uniquely identifies the
 *		term within its namespace.
 * </ul>
 *
 * The global unique identifier, {@link kOFFSET_GID}, is the code by which the term is known
 * outside of this system, it is constituted by the concatenation of the {@link kOFFSET_GID}
 * of the namespace term, referred to by the {@link kOFFSET_NAMESPACE} offset, and the
 * local unique identifier, {@link kOFFSET_LID}, of the current term, both separated by the
 * {@link kTOKEN_NAMESPACE_SEPARATOR} token.
 *
 * If the term has no namespace, its {@link kOFFSET_GID} will be its {@link kOFFSET_LID}.
 *
 * The native unique identifier, {@link kOFFSET_NID}, is the binary md5 hash of the global
 * unique identifier, {@link kOFFSET_GID}, this to allow long codes.
 *
 * The object will have its {@link _IsInited()} status set if the local unique identifier,
 * {@link kOFFSET_LID}, is set, derived classes may add other required attributes.
 *
 *	@package	MyWrapper
 *	@subpackage	Persistence
 */
class CTerm extends \MyWrapper\Persistence\CPersistentObject
{
	/**
	 * <b>Namespace term</b>
	 *
	 * This data member holds the eventual namespace term object.
	 *
	 * @var CTerm
	 */
	 protected $mNamespace = NULL;

		

/*=======================================================================================
 *																						*
 *									PUBLIC MEMBER INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	NamespaceTerm																	*
	 *==================================================================================*/

	/**
	 * <h4>Manage the namespace property</h4>
	 *
	 * This method can be used to manage the namespace term object, it accepts a single
	 * parameter which represents either the object or the requested operation, depending on
	 * its value:
	 *
	 * <ul>
	 *	<li><tt>NULL</tt>: Return the current value.
	 *	<li><tt>FALSE</tt>: Delete the current value.
	 *	<li><i>other</i>: Set the value with the provided parameter.
	 * </ul>
	 *
	 * The second parameter is a boolean which if <tt>TRUE</tt> will return the <i>old</i>
	 * value when replacings; if <tt>FALSE</tt>, it will return the currently set value.
	 *
	 * Whenever the namespace is modified using this method, the corresponding
	 * {@link kOFFSET_NAMESPACE} offset will also be updated.
	 *
	 * If the object has its {@link _IsCommitted()} status set, it will not be possible to
	 * modify the value, this is because the namespace is integral part of the global
	 * unique identifier.
	 *
	 * @param mixed					$theValue			namespace object or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> namespace object.
	 *
	 * @throws \Exception
	 *
	 * @uses ManageProperty()
	 */
	public function NamespaceTerm( $theValue = NULL, $getOld = FALSE )
	{
		//
		// Init local storage.
		//
		$modifying = ( ($theValue !== NULL) && ($theValue !== FALSE) );
		
		//
		// Check parameter.
		//
		if( $modifying )
		{
			//
			// Check if it is committed.
			//
			if( $this->_IsCommitted() )
				throw new \Exception
					( "Cannot modify term namespace",
					  kERROR_LOCKED );											// !@! ==>
			
			//
			// Check namespace type.
			//
			if( ! ($theValue instanceof self) )
				throw new \Exception
					( "Invalid namespace object type",
					  kERROR_PARAMETER );										// !@! ==>
		
		} // Provided new value.
		
		//
		// Handle data member.
		//
		$save = ManageProperty( $this->mNamespace, $theValue, $getOld );
		
		//
		// Update offset.
		//
		if( $modifying )
			$this->offsetSet( kOFFSET_NAMESPACE,
							  ( ( $theValue !== FALSE )
							  	? $theValue->offsetGet( kOFFSET_NID )
							  	: NULL ) );
		
		return $save;																// ==>
	
	} // NamespaceTerm.
		


/*=======================================================================================
 *																						*
 *								PUBLIC ARRAY ACCESS INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	offsetSet																		*
	 *==================================================================================*/

	/**
	 * <h4>Set a value for a given offset</h4>
	 *
	 * We override this method to prevent changing the {@link kOFFSET_LID} and
	 * {@link kOFFSET_NAMESPACE} offsets if the object is in a {@link _IsCommitted()} state.
	 *
	 * @param string				$theOffset			Offset.
	 * @param mixed					$theValue			Value to set at offset.
	 *
	 * @access public
	 *
	 * @uses _IsDirty()
	 */
	public function offsetSet( $theOffset, $theValue )
	{
		//
		// Check object lock.
		//
		if( $this->_IsCommitted() )
		{
			//
			// Check offsets.
			//
			$offsets = array( kOFFSET_LID, kOFFSET_NAMESPACE );
			if( in_array( $theOffset, $offsets ) )
			{
				//
				// Check for changes.
				//
				if( $this->offsetGet( $theOffset ) !== $theValue )
					throw new \Exception
						( "The object is committed: cannot modify [$theOffset] offset",
						  kERROR_LOCKED );										// !@! ==>
			
			} // Offset matches.
		
		} // Object is persistent.
		
		//
		// Call parent method.
		//
		parent::offsetSet( $theOffset, $theValue );
	
	} // offsetSet.

	 
	/*===================================================================================
	 *	offsetUnset																		*
	 *==================================================================================*/

	/**
	 * <h4>Reset a value for a given offset</h4>
	 *
	 * We override this method to handle the dirty flag: when the value changes, we turn the
	 * {@link _IsDirty()} status flag on.
	 *
	 * @param string				$theOffset			Offset.
	 *
	 * @access public
	 *
	 * @uses _IsDirty()
	 */
	public function offsetUnset( $theOffset )
	{
		//
		// Check object lock.
		//
		if( $this->_IsCommitted() )
		{
			//
			// Check offsets.
			//
			$offsets = array( kOFFSET_LID, kOFFSET_NAMESPACE );
			if( in_array( $theOffset, $offsets ) )
			{
				//
				// Check for changes.
				//
				if( $this->offsetExists( $theOffset ) )
					throw new \Exception
						( "The object is committed: cannot modify [$theOffset] offset",
						  kERROR_LOCKED );										// !@! ==>
			
			} // Offset matches.
		
		} // Object is persistent.
		
		//
		// Call parent method.
		//
		parent::offsetUnset( $theOffset );
	
	} // offsetUnset.



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
				( "Terms hash their key: missing container for decoding",
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
	 * Term identifiers are constituted by the concatenation of the global unique identifier
	 * of the namespace term and the local unique identifier of the current term separated
	 * by a {@link kTOKEN_NAMESPACE_SEPARATOR} token.
	 *
	 * If the term lacks a namespace, its global identifier will be its local identifier.
	 *
	 * @access protected
	 * @return string|NULL			The object's global unique identifier.
	 *
	 * @uses _index()
	 */
	protected function _index()
	{
		//
		// Handle namespace.
		//
		$namespace = $this->NamespaceTerm();
		if( $namespace !== NULL )
			return $namespace->offsetGet( kOFFSET_GID )
				  .kTOKEN_NAMESPACE_SEPARATOR
				  .$this->offsetGet( kOFFSET_LID );									// ==>
		
		return $this->offsetGet( kOFFSET_LID );										// ==>
	
	} // _index.
		


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
	 * This method will return a boolean indicating whether all the required the elements
	 * managed by the current class are present, this value should then be set by the caller
	 * into the {@link _IsInited()} status.
	 *
	 * This method should be implemented in all inheritance levels in which the
	 * @link _IsInited()} status is affected.
	 *
	 * In this class we assume the object is {@link _IsInited()}, it is up to derived
	 * classes to prove the contrary.
	 *
	 * @access protected
	 * @return boolean				<tt>TRUE</tt> means {@link _IsInited( <tt>TRUE</tt> ).
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

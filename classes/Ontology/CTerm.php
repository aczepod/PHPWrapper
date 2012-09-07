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
 * Terms feature a namespace, {@link kOFFSET_NAMESPACE}, which contains the native unique
 * identifier, {@link kOFFSET_NID}, of the object that represents the namespace of the
 * current term. This namespace may be provided as a {@link kOFFSET_NID} or as a full
 * object in case it should be committed.
 *
 * The global unique identifier, {@link kOFFSET_GID}, is the code by which the term is known
 * outside of this system, it is constituted by the concatenation of the {@link kOFFSET_GID}
 * of the namespace referred to in the {@link kOFFSET_NAMESPACE} offset, and the local
 * unique identifier, {@link kOFFSET_LID}, of the current term, both separated by the
 * {@link kTOKEN_NAMESPACE_SEPARATOR} token.
 *
 * If the term has no namespace, its {@link kOFFSET_GID} will be its {@link kOFFSET_LID}.
 *
 * Terms must keep track of references, the {@link kOFFSET_REFS_NAMESPACE} offset contains
 * an integer counting the number of times the term was used as a namespace. The
 * {@link kOFFSET_REFS_NODE} offset is an array containing the list of nodes that reference
 * the current term. Finally, the {@link kOFFSET_REFS_TAG} offset is an array that collects
 * the list of tag identifiers that reference the term. These counters and reference
 * collections are automatically managed by the container, rather than by the object, so
 * their modification by this class is not allowed.
 *
 * When {@link _IsCommitted()}, besides the the identifier offsets, also the
 * {@link kOFFSET_NAMESPACE} offset will be locked, since it is used to generate the
 * {@link kOFFSET_GID}.
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
	 * This method will take care of getting the global identifier from the eventual
	 * namespace term and generate the current term global identifier.
	 *
	 * If the namespace was set in the form of an object, it will be converted back to its
	 * native identifier.
	 *
	 * This method does not assume the type of object that it may find in the namespace, it
	 * will first check if derives from {@link CPersistentObject}, in that case it will use
	 * its global identifier; any other type will be assumed to be the native identifier of
	 * the namespace. In the latter case the method will instantiate the object and use its
	 * global identifier.
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
		// Handle namespace.
		//
		if( $this->offsetExists( kOFFSET_NAMESPACE ) )
		{
			//
			// Get namespace.
			//
			$namespace = $this->offsetGet( kOFFSET_NAMESPACE );
			
			//
			// Handle object.
			//
			if( $namespace instanceof CPersistentObject )
			{
				//
				// Check global identifier.
				//
				if( ! $namespace->offsetExists( kOFFSET_GID ) )
					throw new \Exception
						( "Unable to generate term global identifier: "
						 ."namespace has no global identifier",
						  kERROR_STATE );										// !@! ==>
				
				//
				// Init global identifier.
				//
				$identifier = $namespace->offsetGet( kOFFSET_GID );
				
				//
				// Check namespace ID.
				//
				if( ! $namespace->offsetExists( kOFFSET_NID ) )
					throw new \Exception
						( "Unable to generate term global identifier: "
						 ."namespace has no native identifier",
						  kERROR_STATE );										// !@! ==>
				
				//
				// Replace namespace offset.
				//
				$this->offsetSet( kOFFSET_NAMESPACE, $namespace->offsetGet( kOFFSET_NID ) );
			
			} // Namespace object.
			
			//
			// Handle identifier.
			//
			else
			{
				//
				// Get namespace object.
				//
				$ok = $theContainer->ManageObject( $object, $namespace );
				if( ! $ok )
					throw new \Exception
						( "Unable to generate term global identifier: "
						 ."unresolved namespace object",
						  kERROR_STATE );										// !@! ==>
				
				//
				// Init global identifier.
				//
				$identifier = $object[ kOFFSET_GID ];
			
			} // Namespace identifier.
			
			return $identifier
				  .kTOKEN_NAMESPACE_SEPARATOR
				  .$this->offsetGet( kOFFSET_LID );									// ==>
		
		} // Has namespace.
		
		return $this->offsetGet( kOFFSET_LID );										// ==>
	
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
	 * In this class we prevent the modification of the {@link kOFFSET_NAMESPACE} offset if
	 * the object has its {@link _IsCommitted()} status set.
	 *
	 * @param reference			   &$theOffset			Offset.
	 * @param reference			   &$theValue			Value to set at offset.
	 *
	 * @access protected
	 *
	 * @throws \Exception
	 *
	 * @see kOFFSET_NID kOFFSET_GID kOFFSET_LID
	 */
	protected function _Preset( &$theOffset, &$theValue )
	{
		//
		// Intercept identifiers.
		//
		$offsets = array( kOFFSET_NAMESPACE,
						  kOFFSET_REFS_NAMESPACE, kOFFSET_REFS_NODE, kOFFSET_REFS_TAG );
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
	 * @uses _IsDirty()
	 */
	protected function _Preunset( &$theOffset )
	{
		//
		// Intercept identifiers.
		//
		$offsets = array( kOFFSET_NAMESPACE,
						  kOFFSET_REFS_NAMESPACE, kOFFSET_REFS_NODE, kOFFSET_REFS_TAG );
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
	 * In this class we check whether the eventual namespace was provided as an object, in
	 * that case we commit it and leave it as an object: the {@link _index()} method will
	 * take care of converting the offset to the namespace's identifier.
	 *
	 * @param CContainer			$theContainer		Container.
	 * @param bitfield				$theModifiers		Commit options.
	 *
	 * @access protected
	 */
	protected function _Precommit( CContainer $theContainer,
											  $theModifiers = kFLAG_DEFAULT )
	{
		//
		// Get namespace.
		//
		$namespace = $this->offsetGet( kOFFSET_NAMESPACE );
		
		//
		// Handle new namespace.
		//
		if( ($namespace instanceof CPersistentObject)
		 && (! $namespace->_IsCommitted()) )
			$namespace->Replace( $theContainer );
		
		//
		// Call parent method.
		//
		parent::_Precommit( $theContainer, $theModifiers );
		
	} // _PreCommit.

	 
	/*===================================================================================
	 *	_Postcommit																		*
	 *==================================================================================*/

	/**
	 * <h4>Prepare the object after committing</h4>
	 *
	 * In this class we increment the {@link kOFFSET_REFS_NAMESPACE} of the eventual
	 * namespace.
	 *
	 * @param CContainer			$theContainer		Container.
	 * @param bitfield				$theModifiers		Commit options.
	 *
	 * @access protected
	 */
	protected function _Postcommit( CContainer $theContainer,
											   $theModifiers = kFLAG_DEFAULT )
	{
		//
		// Check if not yet committed.
		//
		if( ! $this->_IsCommitted() )
		{
			//
			// Increment namespace reference counter.
			//
			if( $this->offsetExists( kOFFSET_NAMESPACE ) )
			{
				$offsets = array( kOFFSET_REFS_NAMESPACE => 1 );
				$theContainer->ManageObject
					(
						$offsets,
						$this->offsetGet( kOFFSET_NAMESPACE ),
						kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_INCREMENT
					);
			
			} // Has namespace.
		
		} // Not yet committed.
		
		//
		// Call parent method.
		//
		parent::_Postcommit( $theContainer, $theModifiers );
	
	} // _Postcommit.
		


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

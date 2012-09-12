<?php

/**
 * <i>CEdge</i> class definition.
 *
 * This file contains the class definition of <b>CEdge</b> which represents the ancestor of
 * all edge classes.
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 10/09/2012
 */

/*=======================================================================================
 *																						*
 *										CEdge.php										*
 *																						*
 *======================================================================================*/

/**
 * Local definitions.
 *
 * This include file contains common offset definitions.
 */
require_once( "CEdge.inc.php" );

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CPersistentObject.php" );

/**
 * <h3>Edge object ancestor</h3>
 *
 * An edge is an element of a tree or graph that connects two vertices through a predicate,
 * it represents a subject/predicate/object triplet in which the direction of the relation
 * is from the subject to the object.
 *
 * Objects of this class feature three main properties:
 *
 * <ul>
 *	<li>{@link kOFFSET_VERTEX_SUBJECT}: The subject vertex, or the origin of the
 *		relationship.
 *	<li>{@link kOFFSET_PREDICATE}: The predicate reference, or the type of relationship.
 *	<li>{@link kOFFSET_VERTEX_OBJECT}: The object vertex, or the destination of the
 *		relationship.
 * </ul>
 *
 * Objects of this class are {@link _Isinited()} if all three properties are set, the
 * nature of these elements is defined in derived classes.
 *
 * The unique identifier of instances of this class is the combination of the above three
 * elements, no two edges can connect the same vertices in the same direction and with the
 * same predicate. This value is computed and stored in the global identifier,
 * {@link kOFFSET_GID}, and its hash is stored in the unique identifier,
 * {@link kOFFSET_UID}.
 *
 * The class features member accessor methods for the default offsets:
 *
 * <ul>
 *	<li>{@link Subject()}: This method manages the subject vertex,
 *		{@link kOFFSET_VERTEX_SUBJECT}.
 *	<li>{@link Predicate()}: This method manages the edge's predicate,
 *		{@link kOFFSET_PREDICATE}.
 *	<li>{@link Object()}: This method manages the object vertex,
 *		{@link kOFFSET_VERTEX_OBJECT}.
 * </ul>
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 */
class CEdge extends CPersistentObject
{
		

/*=======================================================================================
 *																						*
 *								PUBLIC MEMBER INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Subject																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage edge subject</h4>
	 *
	 * This method can be used to manage the edge's subject vertex,
	 * {@link kOFFSET_VERTEX_SUBJECT}, which is a reference to an object that represents the
	 * origin of the relationship this edge represents.
	 *
	 * The method accepts a parameter which represents the vertex, or the requested
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
	 * locked and an exception will be raised.
	 *
	 * @param mixed					$theValue			Vertex or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> native container.
	 *
	 * @uses ManageOffset()
	 *
	 * @see kOFFSET_VERTEX_SUBJECT
	 */
	public function Subject( $theValue = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kOFFSET_VERTEX_SUBJECT, $theValue, $getOld );	// ==>

	} // Subject.

	 
	/*===================================================================================
	 *	Predicate																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage edge predicate</h4>
	 *
	 * This method can be used to manage the edge's predicate, {@link kOFFSET_PREDICATE},
	 * which is a reference to an object that represents the origin of the relationship this
	 * edge represents.
	 *
	 * The method accepts a parameter which represents the predicate, or the requested
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
	 * locked and an exception will be raised.
	 *
	 * @param mixed					$theValue			Predicate or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> native container.
	 *
	 * @uses ManageOffset()
	 *
	 * @see kOFFSET_PREDICATE
	 */
	public function Predicate( $theValue = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kOFFSET_PREDICATE, $theValue, $getOld );		// ==>

	} // Predicate.

	 
	/*===================================================================================
	 *	Object																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage edge object</h4>
	 *
	 * This method can be used to manage the edge's object vertex,
	 * {@link kOFFSET_VERTEX_OBJECT}, which is a reference to an object that represents the
	 * destination of the relationship this edge represents.
	 *
	 * The method accepts a parameter which represents the vertex, or the requested
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
	 * locked and an exception will be raised.
	 *
	 * @param mixed					$theValue			Vertex or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> native container.
	 *
	 * @uses ManageOffset()
	 *
	 * @see kOFFSET_VERTEX_OBJECT
	 */
	public function Object( $theValue = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kOFFSET_VERTEX_OBJECT, $theValue, $getOld );	// ==>

	} // Object.

		

/*=======================================================================================
 *																						*
 *								STATIC CONTAINER INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Container																		*
	 *==================================================================================*/

	/**
	 * <h4>Return the edges container</h4>
	 *
	 * This static method should be used to get the edges container, it expects a
	 * {@link CDatabase} derived object and will return a {@link CContainer} derived
	 * object.
	 *
	 * The container will be created or fetched from the provided database using the
	 * {@link kCONTAINER_EDGE_NAME} name.
	 *
	 * @param CDatabase				$theDatabase		Database object.
	 *
	 * @static
	 * @return CContainer			The nodes container.
	 */
	static function Container( CDatabase $theDatabase )
	{
		return $theDatabase->Container( kCONTAINER_EDGE_NAME );						// ==>
	
	} // Container.

		

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
	 * In this class we prevent the modification of the {@link kOFFSET_VERTEX_SUBJECT},
	 * {@link kOFFSET_PREDICATE} and {@link kOFFSET_VERTEX_OBJECT} offsets if the object is
	 * committed.
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
	 * @see kOFFSET_VERTEX_SUBJECT kOFFSET_PREDICATE kOFFSET_VERTEX_OBJECT
	 */
	protected function _Preset( &$theOffset, &$theValue )
	{
		//
		// Intercept identifiers.
		//
		$offsets = array( kOFFSET_VERTEX_SUBJECT,
						  kOFFSET_PREDICATE,
						  kOFFSET_VERTEX_OBJECT );
		if( $this->_IsCommitted()
		 && in_array( $theOffset, $offsets ) )
			throw new Exception
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
	 * In this class we prevent the modification of the {@link kOFFSET_VERTEX_SUBJECT},
	 * {@link kOFFSET_PREDICATE} and {@link kOFFSET_VERTEX_OBJECT} offsets if the object is
	 * committed.
	 *
	 * @param reference			   &$theOffset			Offset.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 *
	 * @uses _IsCommitted()
	 *
	 * @see kOFFSET_VERTEX_SUBJECT kOFFSET_PREDICATE kOFFSET_VERTEX_OBJECT
	 */
	protected function _Preunset( &$theOffset )
	{
		//
		// Intercept identifiers.
		//
		$offsets = array( kOFFSET_VERTEX_SUBJECT,
						  kOFFSET_PREDICATE,
						  kOFFSET_VERTEX_OBJECT );
		if( $this->_IsCommitted()
		 && in_array( $theOffset, $offsets ) )
			throw new Exception
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
	 * In this class we set the object's native identifier to a sequence number, we do this
	 * just before inserting the object: that is, if the object does not have the native
	 * identifier. The default sequence key for edges is {@link kSEQUENCE_KEY_EDGE}.
	 *
	 * We also generate the object's global identifier, {@link kOFFSET_GID}, by
	 * concatenating the global identifiers of the subject ({@link kOFFSET_VERTEX_SUBJECT}),
	 * predicate ({@link kOFFSET_PREDICATE}) and object ({@link kOFFSET_VERTEX_OBJECT})
	 * offsets, all separated by the {@link kTOKEN_INDEX_SEPARATOR} token. The resulting
	 * string will be hashed in {@link kOFFSET_UID} and used to identify duplicates.
	 *
	 * Note that we set the sequence as the last operation to allow eventual exceptions
	 * before issuing the sequence.
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
		// Call parent method.
		//
		parent::_Precommit( $theContainer, $theModifiers );
		
		//
		// Check identifier.
		//
		if( ! $this->offsetExists( kOFFSET_NID ) )
		{
			//
			// Set native identifier.
			//
			$this->offsetSet(
				kOFFSET_NID, $theContainer->NextSequence(
					kSEQUENCE_KEY_EDGE, TRUE ) );
			
			//
			// Init global identifier.
			//
			$identifier = Array();
			
			//
			// Get subject.
			//
			$object = $this->NewObject( $theContainer,
										$this->offsetGet( kOFFSET_VERTEX_SUBJECT ) );
			if( $object !== NULL )
				$identifier[] = $object[ kOFFSET_GID ];
			else
				throw new Exception
					( "Cannot commit edge: subject vertex not found",
					  kERROR_STATE );											// !@! ==>
			
			//
			// Get predicate.
			//
			$object = $this->NewObject( $theContainer,
										$this->offsetGet( kOFFSET_PREDICATE ) );
			if( $object !== NULL )
				$identifier[] = $object[ kOFFSET_GID ];
			else
				throw new Exception
					( "Cannot commit edge: predicate not found",
					  kERROR_STATE );											// !@! ==>
			
			//
			// Get object.
			//
			$object = $this->NewObject( $theContainer,
										$this->offsetGet( kOFFSET_VERTEX_OBJECT ) );
			if( $object !== NULL )
				$identifier[] = $object[ kOFFSET_GID ];
			else
				throw new Exception
					( "Cannot commit edge: object vertex not found",
					  kERROR_STATE );											// !@! ==>
			
			//
			// Set global identifier.
			//
			$id = implode( kTOKEN_INDEX_SEPARATOR, $identifier );
			$this->offsetSet( kOFFSET_GID, $id );
			
			//
			// Set unique identifier.
			//
			$this->offsetSet( kOFFSET_UID,
							  $theContainer->ConvertBinary( md5( $id, TRUE ) ) );
		
		} // Not yet committed.
		
	} // _PreCommit.
		


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
	 * {@link kOFFSET_VERTEX_SUBJECT}, {@link kOFFSET_PREDICATE} and
	 * {@link kOFFSET_VERTEX_OBJECT} offsets.
	 *
	 * @access protected
	 * @return boolean				<tt>TRUE</tt> means {@link _IsInited( <tt>TRUE</tt> ).
	 *
	 * @see kOFFSET_VERTEX_SUBJECT kOFFSET_PREDICATE kOFFSET_VERTEX_OBJECT
	 */
	protected function _Ready()
	{
		//
		// Check parent.
		//
		if( parent::_Ready() )
			return ( $this->offsetExists( kOFFSET_VERTEX_SUBJECT )
				  && $this->offsetExists( kOFFSET_PREDICATE )
				  && $this->offsetExists( kOFFSET_VERTEX_OBJECT ) );				// ==>
		
		return FALSE;																// ==>
	
	} // _Ready.

	 

} // class CEdge.


?>

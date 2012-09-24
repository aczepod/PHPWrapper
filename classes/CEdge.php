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
 * flows from the subject towards the object.
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
 * Objects of this class are {@link _IsInited()} if all three properties are set.
 *
 * The unique identifier of instances of this class is the combination of the above three
 * elements, no two edges can connect the same vertices in the same direction and with the
 * same predicate. This value is computed and stored in the global identifier,
 * {@link kOFFSET_GID}, because of this workflow, these three values must be convertable to
 * string.
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
	 *	Predicate																		*
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
 *							PROTECTED IDENTIFICATION INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_index																			*
	 *==================================================================================*/

	/**
	 * <h4>Return the object's global unique identifier</h4>
	 *
	 * The edge class defines the global identifier, {@link kOFFSET_GID}, as the
	 * concatenation of the subject, predicate and object offsets converted to string.
	 *
	 * In this method we check whether all three are present, or we raise an exception.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param bitfield				$theModifiers		Commit options.
	 *
	 * @throws Exception
	 *
	 * @access protected
	 * @return string|NULL			The object's global unique identifier.
	 *
	 * @see kOFFSET_VERTEX_SUBJECT kOFFSET_PREDICATE kOFFSET_VERTEX_OBJECT
	 * @see kTOKEN_INDEX_SEPARATOR
	 */
	protected function _index( CConnection $theConnection, $theModifiers )
	{
		//
		// Init global identifier.
		//
		$identifier = Array();
		
		//
		// Get subject.
		//
		$tmp = (string) $this->offsetGet( kOFFSET_VERTEX_SUBJECT );
		if( $tmp !== NULL )
			$identifier[] = $tmp;
		else
			throw new Exception
				( "Missing subject vertex",
				  kERROR_STATE );												// !@! ==>
		
		//
		// Get predicate.
		//
		$tmp = (string) $this->offsetGet( kOFFSET_PREDICATE );
		if( $tmp !== NULL )
			$identifier[] = $tmp;
		else
			throw new Exception
				( "Missing predicate",
				  kERROR_STATE );												// !@! ==>
		
		//
		// Get object.
		//
		$tmp = (string) $this->offsetGet( kOFFSET_VERTEX_OBJECT );
		if( $tmp !== NULL )
			$identifier[] = $tmp;
		else
			throw new Exception
				( "Missing object vertex",
				  kERROR_STATE );												// !@! ==>
		
		return implode( kTOKEN_INDEX_SEPARATOR, $identifier );						// ==>
	
	} // _index.
		


/*=======================================================================================
 *																						*
 *								PROTECTED OFFSET INTERFACE								*
 *																						*
 *======================================================================================*/


	 
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
		// Handle committed state.
		//
		if( $this->_IsCommitted() )
		{
			//
			// Load locked offsets.
			//
			$offsets = array( kOFFSET_VERTEX_SUBJECT,
							  kOFFSET_PREDICATE,
							  kOFFSET_VERTEX_OBJECT );
			
			//
			// Check offsets.
			//
			if( in_array( $theOffset, $offsets ) )
				throw new Exception
					( "You cannot delete the [$theOffset] offset: "
					 ."the object is committed",
					  kERROR_LOCKED );											// !@! ==>
		
		} // Object is committed.
		
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
	 * {@link kOFFSET_VERTEX_SUBJECT}, {@link kOFFSET_PREDICATE} and
	 * {@link kOFFSET_VERTEX_OBJECT} offsets.
	 *
	 * @access protected
	 * @return boolean				<tt>TRUE</tt> means {@link _IsInited( <tt>TRUE</tt> ).
	 *
	 * @uses _Ready()
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

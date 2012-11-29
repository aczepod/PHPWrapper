<?php

/**
 * <i>COntologyAliasNode</i> class definition.
 *
 * This file contains the class definition of <b>COntologyAliasNode</b> which represents an
 * alias of a {@link COntologyMasterVertex} instance.
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 27/09/2012
 */

/*=======================================================================================
 *																						*
 *									COntologyAliasNode.php								*
 *																						*
 *======================================================================================*/

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntologyNode.php" );

/**
 * <h4>Ontology alias node object</h4>
 *
 * Instances of this class hold an attribute, {@link kTAG_NODE}, which represents a
 * reference to an instance of the {@link COntologyMasterVertex}.
 *
 * They are a separate node which shares the same {@link kTAG_TERM} attribute as the node
 * they point to, but have a subset of the {@link kTAG_CATEGORY}, {@link kTAG_KIND} and
 * {@link kTAG_TYPE} attributes.
 *
 * These objects can be used as a view into the master graph formed by the
 * {@link COntologyMasterVertex} instances, nodes which do not have the {@link kTAG_NODE}
 * attribute.
 *
 * The main use of such objects is to create a separate graph using a subset of the master
 * graph elements, so that when navigating the elements, only a subset of the relationships
 * is displayed, in order to limit the scope of the graph to a specific category or realm.
 *
 * Whenever a new node is created, the class will make sure that an instance of
 * {@link COntologyMasterVertex} exists which points to the same term as the current object
 * and set the current node's {@link kTAG_NODE} attribute to point to it. This means that
 * all instances of this class refer to another node which represents their master node.
 *
 * When relating nodes from this class, also the related {@link COntologyMasterVertex}
 * instances will be related among each other, except that while nodes of this class may
 * reference the same term, master nodes may not.
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 */
class COntologyAliasNode extends COntologyNode
{
		

/*=======================================================================================
 *																						*
 *								PUBLIC MEMBER INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Node																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage node reference</h4>
	 *
	 * This method can be used to manage the master node reference, {@link kTAG_NODE}, the
	 * method accepts a parameter which represents either the node, or the requested
	 * operation, depending on its value:
	 *
	 * <ul>
	 *	<li><tt>NULL</tt>: Return the current value.
	 *	<li><tt>FALSE</tt>: Delete the current value.
	 *	<li><i>other</i>: Set the value with the provided parameter:
	 *	 <ul>
	 *		<li><tt>integer</tt>: This value will be interpreted as the node reference.
	 *		<li><tt>{@link COntologyNode}</tt>: This value will be interpreted as the node
	 *			object.
	 *		<li><i>other</i>: Any other value will raise an exception.
	 *	 </ul>
	 * </ul>
	 *
	 * The second parameter is a boolean which if <tt>TRUE</tt> will return the <i>old</i>
	 * value when replacing containers; if <tt>FALSE</tt>, it will return the currently set
	 * value.
	 *
	 * @param mixed					$theValue			Term or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> native container.
	 *
	 * @uses ManageOffset()
	 *
	 * @see kTAG_NODE
	 */
	public function Node( $theValue = NULL, $getOld = FALSE )
	{
		//
		// Handle provided value.
		//
		if( ($theValue !== NULL)
		 && ($theValue !== FALSE) )
		{
			//
			// Handle node object.
			//
			if( $theValue instanceof COntologyNode )
			{
				//
				// Check identifier.
				//
				if( ! $theValue->offsetExists( kTAG_NID ) )
					throw new Exception
						( "Provided node object is lacking its native identifier",
						  kERROR_PARAMETER );									// !@! ==>
				
				//
				// Use object reference.
				//
				$theValue = $theValue->NID();
			
			} // Node object.
			
			//
			// Check value.
			//
			if( ! is_integer( $theValue ) )
				throw new Exception
					( "Invalid node reference type",
					  kERROR_PARAMETER );										// !@! ==>
		
		} // New value.
		
		return ManageOffset( $this, kTAG_NODE, $theValue, $getOld );				// ==>

	} // Node.

	 

/*=======================================================================================
 *																						*
 *								PUBLIC OPERATIONS INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	RelateTo																		*
	 *==================================================================================*/

	/**
	 * <h4>Relate to node</h4>
	 *
	 * We overload this method to ensure that subject vertex of the relationship is related
	 * to a master node, the object vertex may be a master node.
	 *
	 * If both vertices are related to a master node, we create and commit a new relation
	 * with the same predicate between the related master nodes.
	 *
	 * We require the connection parameter since both subject and object vertices must be
	 * committed by this method, this also means that the edge will also be committed.
	 *
	 * @param mixed					$thePredicate		Predicate term object or reference.
	 * @param mixed					$theObject			Object node object or reference.
	 * @param CConnection			$theConnection		Server, database or container.
	 *
	 * @access public
	 * @return COntologyEdge		Edge object.
	 */
	public function RelateTo( $thePredicate, $theObject, $theConnection = NULL )
	{
		//
		// Check connection.
		//
		if( $theConnection instanceof CConnection )
		{
			//
			// Commit current object.
			//
			if( ! $this->_IsCommitted() )
				$this->Insert( $theConnection );
			
			//
			// Check if related.
			//
			if( $this->offsetExists( kTAG_NODE ) )
			{
				//
				// Resolve object.
				//
				if( ! ($theObject instanceof COntologyNode) )
					$theObject = $theObject->Resolve( $theConnection, $theObject, TRUE );
				elseif( ! $theObject->_IsCommitted() )
					$theObject->Insert( $theConnection );
				
				//
				// Relate aliases.
				//
				$edge = parent::RelateTo( $thePredicate, $theObject, $theConnection );
				
				//
				// Resolve subject master node.
				//
				$subject = $this->NewObject( $theConnection,
											 $this->offsetGet( kTAG_NODE ) );
				
				//
				// Resolve object master node.
				//
				if( $theObject->offsetExists( kTAG_NODE ) )
					$theObject = $this->NewObject( $theConnection,
												   $theObject->offsetGet( kTAG_NODE ) );
				
				//
				// Relate master nodes.
				//
				$subject->RelateTo( $thePredicate, $theObject, $theConnection );
				
				return $edge;														// ==>
			
			} // Subject is an alias.
		
			throw new Exception
				( "Missing subject vertex node reference",
				  kERROR_STATE );												// !@! ==>
		
		} // Provided connection.
		
		throw new Exception
			( "Missing connection parameter",
			  kERROR_MISSING );													// !@! ==>

	} // RelateTo.
		


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
	 * In this class we handle the master node: we check whether a master node related to
	 * the same term exists, if that is the case we set the current node's {@link kTAG_NODE}
	 * attribute, if that is not the case, we instantiate and insert the master node before
	 * setting its identifier in the current object's {@link kTAG_NODE} attribute.
	 *
	 * @param reference			   &$theConnection		Server, database or container.
	 * @param reference			   &$theModifiers		Commit options.
	 *
	 * @access protected
	 * @return mixed
	 *
	 * @uses LoadTerm()
	 *
	 * @see kTAG_TERM
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
		// Inserting or replacing.
		//
		if( (($theModifiers & kFLAG_PERSIST_MASK) == kFLAG_PERSIST_INSERT)
		 || (($theModifiers & kFLAG_PERSIST_MASK) == kFLAG_PERSIST_REPLACE) )
		{
			//
			// Create master node.
			//
			$node = new COntologyMasterVertex();
			$node->Term( $this->Term() );
			if( $this->offsetExists( kTAG_CATEGORY ) )
				$node->Category( $this->Category(), TRUE );
			if( $this->offsetExists( kTAG_KIND ) )
				$node->Kind( $this->Kind(), TRUE );
			if( $this->offsetExists( kTAG_TYPE ) )
				$node->Type( $this->Type(), TRUE );
			
			//
			// Insert and reference master node.
			//
			$this->offsetSet( kTAG_NODE, $node->Insert( $theConnection ) );
		
		} // Not deleting.
		
		return NULL;																// ==>
	
	} // _PrecommitRelated.
		


/*=======================================================================================
 *																						*
 *							PROTECTED POST-COMMIT INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_PostcommitRelated																*
	 *==================================================================================*/

	/**
	 * <h4>Update related objects after committing</h4>
	 *
	 * In this class we add the current node's identifier to the referenced master node if
	 * the current object is being inserted.
	 *
	 * @param reference			   &$theConnection		Server, database or container.
	 * @param reference			   &$theModifiers		Commit options.
	 *
	 * @access protected
	 *
	 * @uses _IsCommitted()
	 * @uses _ReferenceInNode()
	 *
	 * @see kFLAG_PERSIST_INSERT kFLAG_PERSIST_REPLACE
	 */
	protected function _PostcommitRelated( &$theConnection, &$theModifiers )
	{
		//
		// Call parent method.
		//
		parent::_PostcommitRelated( $theConnection, $theModifiers );
	
		//
		// Handle insert or replace.
		//
		if( (($theModifiers & kFLAG_PERSIST_MASK) == kFLAG_PERSIST_INSERT)
		 || (($theModifiers & kFLAG_PERSIST_MASK) == kFLAG_PERSIST_REPLACE) )
		{
			//
			// Check if not yet committed.
			//
			if( ! $this->_IsCommitted() )
				$this->_ReferenceInNode( $theConnection, TRUE );
		
		} // Insert or replace.
		
		//
		// Check if deleting.
		//
		elseif( $theModifiers & kFLAG_PERSIST_DELETE )
			$this->_ReferenceInNode( $theConnection, FALSE );
		
	} // _PostcommitRelated.

		

/*=======================================================================================
 *																						*
 *								PROTECTED REFERENCE INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_ReferenceInNode																*
	 *==================================================================================*/

	/**
	 * <h4>Add node reference to Master</h4>
	 *
	 * This method can be used to add or remove the current node's reference from the
	 * referenced master node, {@link kTAG_NODE}. This method should be used whenever
	 * committing a new node or deleting one: it will add the current node's native
	 * identifier to the set of alias node references of the node's master node when
	 * committing a new node; it will remove it when deleting the node.
	 *
	 * The last parameter is a boolean: if <tt>TRUE</tt> the method will add to the set; if
	 * <tt>FALSE</tt>, it will remove from the set.
	 *
	 * The method will return <tt>TRUE</tt> if the operation affected at least one object,
	 * <tt>FALSE</tt> if not, <tt>NULL</tt> if the node is not set and raise an exception if
	 * the operation failed.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param boolean				$doAdd				<tt>TRUE</tt> add reference.
	 *
	 * @access protected
	 * @return boolean				<tt>TRUE</tt> operation affected at least one object.
	 *
	 * @see kTAG_NODE kTAG_NODES
	 * @see kFLAG_PERSIST_MODIFY kFLAG_MODIFY_ADDSET kFLAG_MODIFY_PULL
	 */
	protected function _ReferenceInNode( CConnection $theConnection, $doAdd )
	{
		//
		// Check node.
		//
		if( $this->offsetExists( kTAG_NODE ) )
		{
			//
			// Set modification criteria.
			//
			$criteria = array( kTAG_NODES => $this->offsetGet( kTAG_NID ) );
			
			//
			// Handle add to set.
			//
			if( $doAdd )
				return COntologyNode::ResolveClassContainer( $theConnection, TRUE )
						->ManageObject
							(
								$criteria,
								$this->offsetGet( kTAG_NODE ),
								kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_ADDSET
							);														// ==>
			
			return COntologyNode::ResolveClassContainer( $theConnection, TRUE )
					->ManageObject
						(
							$criteria,
							$this->offsetGet( kTAG_NODE ),
							kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_PULL
						);															// ==>
		
		} // Object has node.
		
		return NULL;																// ==>
	
	} // _ReferenceInNode.

	 

} // class COntologyAliasNode.


?>

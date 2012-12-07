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
 * Master node.
 *
 * This includes the master node class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntologyMasterNode.php" );

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
 * When an instance of this class is related to another instance of this class, the same
 * relation will be automatically created between the master nodes referenced by the
 * {@link kTAG_NODE} attribute; this will not occur if an instance of this class is related
 * to a master node.
 *
 * When inserting or deleting nodes, this class will update the {@link kTAG_NODES} attribute
 * of the object referenced by the current object's {@link kTAG_NODE} attribute. The
 * referenced {@link kTAG_NODES} attribute is either the count or an array of object
 * {@link kTAG_NID} attributes, depending on the value of the
 * {@link kSWITCH_kTAG_ALIAS_NODES} flag:
 *	 <ul>
 *		<li><tt>0x2</tt>: <i>Keep count of references</i>. This means that the
 *			{@link kTAG_NODES} attribute will be a reference count.
 *		<li><tt>0x3</tt>: <i>Keep list of references</i>. This means that the
 *			{@link kTAG_NODES} attribute will be a list of references.
 *		<li><tt>0x0</tt> <i>or other</i>: <i>Don't handle this information</i>. This means
 *			that the {@link kTAG_NODES} attribute will not be handled.
 *	 </ul>
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
	 * In this class we handle referenced master nodes, {@link kTAG_NODE}: depending on the
	 * value of the {@link kSWITCH_kTAG_ALIAS_NODES} flag we do the following:
	 *
	 * <ul>
	 *	<li><tt>0x2</tt>: <i>Keep count of references</i>. This means that the
	 *		{@link kTAG_NODES} attribute of the master node referenced by the
	 *		{@link kTAG_NODE} attribute will be incremented when the object is inserted, or
	 *		decremented when deleted.
	 *	<li><tt>0x3</tt>: <i>Keep list of references</i>. This means that a reference to the
	 *		current object will be added to the {@link kTAG_NODES} attribute of the master
	 *		node referenced by {@link kTAG_NODE} attribute of the current object when the
	 *		latter is inserted, and removed when the object isdeleted.
	 *	<li><tt>0x0</tt> <i>or other</i>: <i>Don't handle this information</i>. This means
	 *		that the {@link kTAG_NODES} attribute will not be handled.
	 * </ul>
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
		// Check node reference.
		//
		if( $this->offsetExists( kTAG_NODE ) )
		{
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
					$this->_ReferenceInObject(
						COntologyTerm::ResolveContainer( $theConnection, TRUE ),
						kSWITCH_kTAG_ALIAS_NODES,
						$this->offsetGet( kTAG_NODE ),
						kTAG_NODES,
						1 );
			
			} // Insert or replace.
			
			//
			// Check if deleting.
			//
			elseif( $theModifiers & kFLAG_PERSIST_DELETE )
				$this->_ReferenceInObject(
					COntologyTerm::ResolveContainer( $theConnection, TRUE ),
					kSWITCH_kTAG_ALIAS_NODES,
					$this->offsetGet( kTAG_NODE ),
					kTAG_NODES,
					-1 );
		
		} // Has node reference.
		
	} // _PostcommitRelated.

	 

} // class COntologyAliasNode.


?>

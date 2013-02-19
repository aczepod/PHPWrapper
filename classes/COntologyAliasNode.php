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
 * {@link kTAG_NODE} attribute; this will not occur if an instance of this class is
 * related to a master node.
 *
 * When inserting or deleting nodes, this class will update the {@link kTAG_NODES} attribute
 * of the object referenced by the current object's {@link kTAG_NODE} attribute. The
 * referenced {@link kTAG_NODES} attribute is either the count or an array of object
 * {@link kTAG_NID} attributes, depending on the value of the
 * {@link kSWITCH_kTAG_ALIAS_NODES} flag:
 *
 * <ul>
 *	<li><tt>0x2</tt>: <i>Keep count of references</i>. This means that the
 *		{@link kTAG_NODES} attribute will be a reference count.
 *	<li><tt>0x3</tt>: <i>Keep list of references</i>. This means that the
 *		{@link kTAG_NODES} attribute will be a list of references.
 *	<li><tt>0x0</tt> <i>or other</i>: <i>Don't handle this information</i>. This means
 *		that the {@link kTAG_NODES} attribute will not be handled.
 * </ul>
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
	 * We overload this method to mirror relationships between alias nodes to their
	 * counterpart master nodes, this is governed by the <tt>$doPropagate</tt> switch.
	 *
	 * We first create the requested relationship, then we resolve both the subject and the
	 * object, if it is also an alias, and we relate them with the same predicate.
	 *
	 * This means that:
	 *
	 * <ul>
	 *	<li><i>ALIAS => MASTER</i>:
	 *	 <ul>
	 *		<li>ALIAS => MASTER
	 *		<li>ALIAS.MASTER => MASTER
	 *	 </ul>
	 *	<li><i>ALIAS => ALIAS</i>:
	 *	 <ul>
	 *		<li>ALIAS => ALIAS
	 *		<li>ALIAS.MASTER => ALIAS.MASTER
	 *	 </ul>
	 * </ul>
	 *
	 * We require the connection parameter here since both subject and object vertices must
	 * be committed by this method, this implies that the edge will also be committed.
	 *
	 * @param mixed					$thePredicate		Predicate term object or reference.
	 * @param mixed					$theObject			Object node object or reference.
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param boolean				$doPropagate		TRUE means relate masters.
	 *
	 * @access public
	 * @return COntologyEdge		Edge object.
	 */
	public function RelateTo( $thePredicate, $theObject, $theConnection = NULL,
														 $doPropagate = TRUE )
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
			// Check if alias.
			//
			if( $this->offsetExists( kTAG_NODE ) )
			{
				//
				// Resolve object.
				//
				if( ! ($theObject instanceof COntologyNode) )
					$theObject = self::NewObject( $theConnection, $theObject, TRUE );
				
				//
				// Commit object.
				//
				elseif( ! $theObject->_IsCommitted() )
					$theObject->Insert( $theConnection );
				
				//
				// Create requested relationship.
				//
				$edge
					= parent::RelateTo(
						$thePredicate, $theObject, $theConnection, $doPropagate );
				
				//
				// Relate masters.
				//
				if( $doPropagate )
				{
					//
					// Resolve subject master.
					//
					$subject = $this;
					while( ($id = $subject->offsetGet( kTAG_NODE )) !== NULL )
						$subject = self::NewObject( $theConnection, $id, TRUE );
				
					//
					// Resolve object master.
					//
					$object = $theObject;
					while( ($id = $object->offsetGet( kTAG_NODE )) !== NULL )
						$object = self::NewObject( $theConnection, $id, TRUE );
				
					//
					// Relate master nodes.
					// Notice that we are relating two master nodes,
					// which means that only that relationship will be instantiated.
					//
					$subject->RelateTo(
						$thePredicate, $object, $theConnection, $doPropagate );
				
				} // Propagate relationship.
				
				return $edge;														// ==>
			
			} // Subject is an alias.
		
			throw new Exception
				( "Missing master vertex node reference",
				  kERROR_STATE );												// !@! ==>
		
		} // Provided connection.
		
		throw new Exception
			( "Missing connection parameter",
			  kERROR_MISSING );													// !@! ==>

	} // RelateTo.

		

/*=======================================================================================
 *																						*
 *								STATIC RESOLUTION INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Resolve																			*
	 *==================================================================================*/

	/**
	 * <h4>Resolve a node</h4>
	 *
	 * In this class we add the persistent identifier, {@link kTAG_PID}, to the list of
	 * properties to be checked, with this option we return the first match by default.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param mixed					$theIdentifier		Node identifier or term reference.
	 * @param boolean				$doThrow			If <tt>TRUE</tt> raise an exception.
	 *
	 * @static
	 * @return COntologyNode		Matched node, found nodes or <tt>NULL</tt>.
	 *
	 * @throws Exception
	 */
	static function Resolve( CConnection $theConnection, $theIdentifier, $doThrow = FALSE )
	{
		//
		// Call parent method.
		//
		$result = parent::Resolve( $theConnection, $theIdentifier, FALSE );
		if( $result !== NULL )
			return $result;															// ==>
	
		//
		// Resolve container.
		//
		$container = static::ResolveClassContainer( $theConnection, TRUE );
		
		//
		// Make query.
		//
		$query = $container->NewQuery();
		$query->AppendStatement(
			CQueryStatement::Equals(
				kTAG_PID, $theIdentifier, kTYPE_STRING ) );
		
		//
		// Perform query.
		//
		$object = $container->Query( $query, NULL, NULL, NULL, NULL, TRUE );
		if( $object !== NULL )
			return CPersistentObject::DocumentObject( $object );					// ==>

		//
		// Raise exception.
		//
		if( $doThrow )
			throw new Exception
				( "Node not found",
				  kERROR_NOT_FOUND );										// !@! ==>
		
		return NULL;															// ==>

	} // Resolve.
		


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
	 * the same term exists, if that is the case we set the current node's
	 * {@link kTAG_NODE} attribute, if that is not the case, we instantiate and insert the
	 * master node before setting its identifier in the current object's
	 * {@link kTAG_NODE} attribute.
	 *
	 * Note that we do the above only if the {@link kTAG_NODE} offset is not yet set.
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
		// Inserting, replacing and node not yet set.
		//
		if( ( (($theModifiers & kFLAG_PERSIST_MASK) == kFLAG_PERSIST_INSERT)
		   || (($theModifiers & kFLAG_PERSIST_MASK) == kFLAG_PERSIST_REPLACE) )
		 && (! $this->offsetExists( kTAG_NODE )) )
		{
			//
			// Create master node.
			//
			$tags = array( kTAG_TERM, kTAG_CATEGORY, kTAG_KIND,
						   kTAG_TYPE, kTAG_INPUT, kTAG_EXAMPLES );
			$node = new COntologyMasterVertex();
			foreach( $tags as $tag )
			{
				if( $this->offsetExists( $tag ) )
					$node->offsetSet( $tag, $this->offsetGet( $tag ) );
			}
			
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
	 * In this class we handle referenced master nodes, {@link kTAG_NODE}: depending on
	 * the value of the {@link kSWITCH_kTAG_ALIAS_NODES} flag we do the following:
	 *
	 * <ul>
	 *	<li><tt>0x2</tt>: <i>Keep count of references</i>. This means that the
	 *		{@link kTAG_NODES} attribute of the master node referenced by the
	 *		{@link kTAG_NODE} attribute will be incremented when the object is inserted,
	 *		or decremented when deleted.
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

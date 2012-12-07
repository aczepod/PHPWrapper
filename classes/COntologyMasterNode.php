<?php

/**
 * <i>COntologyMasterNode</i> class definition.
 *
 * This file contains the class definition of <b>COntologyMasterNode</b> which represents a
 * node which uses its {@link kTAG_TERM} attribute as a unique identifier.
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 27/09/2012
 */

/*=======================================================================================
 *																						*
 *									COntologyMasterNode.php								*
 *																						*
 *======================================================================================*/

/**
 * Local definitions.
 *
 * This include file contains local definitions.
 */
require_once( "COntologyMasterNode.inc.php" );

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntologyNode.php" );

/**
 * <h4>Ontology master node object</h4>
 *
 * This class extends its {@link COntologyNode} parent by enforcing the following rule:
 * <i>There cannot be two nodes that share the same term</i>.
 *
 * Whenever a new node is instantiated, at commit time the system will check whether
 * another node of the same class, {@link kTAG_CLASS}, shares the same term,
 * {@link kTAG_TERM}: if that is the case the {@link kTAG_CATEGORY}, {@link kTAG_KIND} and
 * {@link kTAG_TYPE} of the current node will be appended to the corresponding attributes
 * of the referenced node which will become the current node; if that is not the case, the
 * class will behave as its parent and instantiate a new node.
 *
 * This class also overloads the {@link RelateTo()} method by ensuring that the object of
 * the relationship is an instance of this class, or an {@link COntologyAliasNode} which
 * points to an instance of this class.
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 */
class COntologyMasterNode extends COntologyNode
{
		

/*=======================================================================================
 *																						*
 *								PUBLIC MEMBER INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	NodeRefs																		*
	 *==================================================================================*/

	/**
	 * <h4>Manage node references</h4>
	 *
	 * The <i>node references</i>, {@link kTAG_NODES}, holds a list of identifiers of alias
	 * nodes that reference the current node.
	 *
	 * The method is read-only, because this value must be managed externally.
	 *
	 * @access public
	 * @return array				Nodes reference list.
	 *
	 * @see kTAG_NODES
	 */
	public function NodeRefs()
	{
		//
		// Handle reference count.
		//
		if( $this->offsetExists( kTAG_NODES ) )
			return $this->offsetGet( kTAG_NODES );									// ==>
		
		return Array();																// ==>

	} // NodeRefs.

		

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
	 * We overload the inherited method to ensure that both vertices of the relationship do
	 * not have node references, {@link kTAG_NODE}. If any do have such references, we use
	 * the referenced node instead of the current one.
	 *
	 * Both the current node and the object node will be committed if not already.
	 *
	 * Since this operation involves searching the database, we require the connection which
	 * will be used to commit the edge.
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
			// Commit subject.
			//
			if( ! $this->_IsCommitted() )
				$this->Insert( $theConnection );
			
			//
			// Dereference current object.
			//
			$subject = $this;
			
			//
			// Resolve subject master node.
			//
			$cache = array( $subject->offsetGet( kTAG_NID ) );
			while( $subject->offsetExists( kTAG_NODE ) )
			{
				//
				// Resolve node reference.
				//
				$subject = static::Resolve( $theConnection,
											$subject->offsetGet( kTAG_NODE ),
											TRUE );
				
				//
				// Handle recursion.
				//
				if( in_array( $subject->offsetGet( kTAG_NID ), $cache ) )
					break;													// =>
				
				//
				// Traverse.
				//
				$cache[] = $subject->offsetGet( kTAG_NID );
			}
			
			//
			// Double check reference.
			//
			if( $subject->offsetExists( kTAG_NODE ) )
				throw new Exception
					( "Subject vertex does not resolve into a master node",
					  kERROR_STATE );											// !@! ==>
			
			//
			// Resolve object.
			//
			if( ! ($theObject instanceof COntologyNode) )
				$theObject->Resolve( $theConnection, $theObject, TRUE );
			elseif( ! $theObject->_IsCommitted() )
				$theObject->Insert( $theConnection );
			
			//
			// Resolve object master node.
			//
			$cache = array( $theObject->offsetGet( kTAG_NID ) );
			while( $theObject->offsetExists( kTAG_NODE ) )
			{
				//
				// Resolve node reference.
				//
				$theObject = static::Resolve( $theConnection,
											  $theObject->offsetGet( kTAG_NODE ),
											  TRUE );
				
				//
				// Handle recursion.
				//
				if( in_array( $theObject->offsetGet( kTAG_NID ), $cache ) )
					break;													// =>
				
				//
				// Traverse.
				//
				$cache[] = $theObject->offsetGet( kTAG_NID );
			}
			
			//
			// Double check reference.
			//
			if( $theObject->offsetExists( kTAG_NODE ) )
				throw new Exception
					( "Object vertex does not resolve into a master node",
					  kERROR_STATE );											// !@! ==>
			
			//
			// Instantiate the edge
			//
			$edge = $this->_NewEdge();
			
			//
			// Set subject.
			//
			$edge->Subject( $subject );
			
			//
			// Set predicate.
			//
			$edge->Predicate( $thePredicate );
			
			//
			// Set object.
			//
			$edge->Object( $theObject );
			
			//
			// Insert.
			//
			$edge->Insert( $theConnection );
			
			return $edge;															// ==>
		
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
	 * We overload this method in this class by intercepting all cases in which the
	 * <tt>$theIdentifier</tt> is not an integer, or node reference: since no two nodes of
	 * this class can share the same term reference, we add a clause to the search query to
	 * exclude all node that have a {@link kTAG_NODE} attribute. We do this rather than use
	 * the object class, because we assume all nodes that have the {@link kTAG_NODE}
	 * attribute yo be aliases.
	 *
	 * Since terms become also a unique identifier, this method will return either an object
	 * or <tt>NULL</tt>.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param mixed					$theIdentifier		Node identifier or term reference.
	 * @param boolean				$doThrow			If <tt>TRUE</tt> raise an exception.
	 *
	 * @static
	 * @return COntologyMasterNode		Matched node, found nodes or <tt>NULL</tt>.
	 *
	 * @throws Exception
	 */
	static function Resolve( CConnection $theConnection, $theIdentifier, $doThrow = FALSE )
	{
		//
		// Check identifier.
		//
		if( $theIdentifier !== NULL )
		{
			//
			// Handle node identifier.
			//
			if( is_integer( $theIdentifier ) )
				return parent::Resolve( $theConnection, $theIdentifier, $doThrow );	// ==>
			
			//
			// Handle term.
			//
			if( (! ($theIdentifier instanceof COntologyTerm))
			 || (! $theIdentifier->_IsCommitted()) )
			{
				//
				// Resolve term.
				//
				$theIdentifier = COntologyTerm::Resolve( $theConnection, $theIdentifier );
				if( $theIdentifier === NULL )
				{
					if( ! $doThrow )
						return NULL;												// ==>
					
					throw new Exception
						( "Node not found: unresolved term",
						  kERROR_NOT_FOUND );									// !@! ==>
				
				} // Unresolved term.
			
			} // Provided term reference or uncommitted term.
			
			//
			// Use term native identifier.
			//
			$theIdentifier = $theIdentifier->offsetGet( kTAG_NID );
			
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
					kTAG_TERM, $theIdentifier, kTYPE_BINARY_STRING ) );
			$query->AppendStatement(
				CQueryStatement::Missing(
					kTAG_NODE ) );
			$node = $container->Query( $query, NULL, NULL, NULL, NULL, TRUE );
			if( $node !== NULL )
				return static::DocumentObject( $node );								// ==>

			//
			// Raise exception.
			//
			if( $doThrow )
				throw new Exception
					( "Node not found",
					  kERROR_NOT_FOUND );										// !@! ==>
			
			return NULL;															// ==>
			
		} // Provided local or global identifier.
		
		throw new Exception
			( "Missing node identifier or term",
			  kERROR_PARAMETER );												// !@! ==>

	} // Resolve.
		


/*=======================================================================================
 *																						*
 *							PROTECTED PRE-COMMIT INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_PrecommitIdentify																*
	 *==================================================================================*/

	/**
	 * <h4>Determine the identifiers before committing</h4>
	 *
	 * We overload this method to prevent creating two nodes that refer to the same term.
	 * We first check if there is another node that refers to the same term and that does
	 * point to another node: if we find one we add the {@link kTAG_CATEGORY},
	 * {@link kTAG_KIND} and {@link kTAG_TYPE} attributes to the found node and make it the
	 * current node; if no such node is found, we call the parent method.
	 *
	 * In the first case we return the found node identifier, this will stop the commit
	 * workflow.
	 *
	 * @param reference			   &$theConnection		Server, database or container.
	 * @param reference			   &$theModifiers		Commit options.
	 *
	 * @access protected
	 * @return mixed
	 *
	 * @see kTAG_NID kSEQUENCE_KEY_NODE
	 * @see kFLAG_PERSIST_INSERT kFLAG_PERSIST_REPLACE
	 */
	protected function _PrecommitIdentify( &$theConnection, &$theModifiers )
	{
		//
		// Handle insert or replace.
		//
		if( (($theModifiers & kFLAG_PERSIST_MASK) == kFLAG_PERSIST_INSERT)
		 || (($theModifiers & kFLAG_PERSIST_MASK) == kFLAG_PERSIST_REPLACE) )
		{
			//
			// Check term reference.
			//
			if( $this->offsetExists( kTAG_TERM ) )
			{
				//
				// Resolve master node from term.
				//
				$node = $this->Resolve( $theConnection, $this->Term() );
				if( $node !== NULL )
				{
					//
					// Save identifier.
					//
					$id = $node->NID();
					
					//
					// Set modification criteria.
					//
					$criteria = array();
					$attributes = array( kTAG_CATEGORY, kTAG_KIND, kTAG_TYPE );
					foreach( $attributes as $attribute )
					{
						if( $this->offsetExists( $attribute ) )
							$criteria[ $attribute ]
								= $this->offsetGet( $attribute );
					}
					
					//
					// Modify master node.
					//
					if( count( $criteria ) )
					{
						$container = $this->ResolveContainer( $theConnection, TRUE );
						$container->ManageObject(
							$criteria,
							$node->NID(),
							kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_ADDSET );
					}

					//
					// Resolve node again.
					//
					$node = self::Resolve( $theConnection, $id, TRUE );
					
					//
					// Get object properties.
					//
					$properties = $node->getArrayCopy();
					
					//
					// Replace object attributes.
					//
					$this->exchangeArray( $properties );
					
					//
					// Update current object status.
					//
					$op = kFLAG_PERSIST_INSERT;
					$this->_PostcommitStatus( $theConnection, $op );
					
					//
					// Handle graph node.
					//
					if( $theConnection->offsetExists( kOFFSET_GRAPH ) )
						$theConnection->offsetGet( kOFFSET_GRAPH )
							->SetNode(
								$theConnection->offsetGet( kOFFSET_GRAPH )
									->GetNode( $id, TRUE ),
								$this->_GraphNodeProperties( $properties ) );
					
					//
					// Cleanup before returning.
					//
					$this->_PostcommitCleanup( $theConnection, $op );
					
					return $this->NID();											// ==>
				
				} // Found master node.
			
			} // Has term reference.
		
		} // Insert or replace.
	
		//
		// Call parent method.
		//
		return parent::_PrecommitIdentify( $theConnection, $theModifiers );			// ==>
		
	} // _PrecommitIdentify.

	 

} // class COntologyMasterNode.


?>

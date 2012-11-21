<?php

/**
 * <i>CNeo4jGraph</i> class definition.
 *
 * This file contains the class definition of <b>CNeo4jGraph</b> which is a concrete
 * instance of the {@link CGraphContainer} class.
 *
 *	@package	MyWrapper
 *	@subpackage	Persistence
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 20/11/2012
 */

/*=======================================================================================
 *																						*
 *									CNeo4jGraph.php										*
 *																						*
 *======================================================================================*/

/**
 * Local definitions.
 *
 * This include file contains common offset definitions.
 */
require_once( "CNeo4jGraph.inc.php" );

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CGraphContainer.php" );

/**
 * <h4>Neo4j container</h4>
 *
 * This class wraps the {@link CGraphContainer} class around a Neo4j graph database client.
 *
 * The connection property will hold a Neo4j client.
 *
 *	@package	MyWrapper
 *	@subpackage	Persistence
 */
class CNeo4jGraph extends CGraphContainer
{
		

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
	 * You instantiate the class by providing a native connection, or the host and port.
	 * In the latter case the first parameter represents the host and the second the port.
	 *
	 * If you do not provide any parameter the default {@link kGRAPH_DEF_HOST} host and
	 * {@link kGRAPH_DEF_PORT} port.
	 *
	 * @param mixed					$theConnection		Native connection.
	 * @param mixed					$theOptions			Connection options.
	 *
	 * @access public
	 *
	 * @uses Connection()
	 */
	public function __construct( $theConnection = NULL, $theOptions = NULL )
	{
		//
		// Build new container.
		//
		if( ! ($theConnection instanceof Everyman\Neo4j\Client) )
		{
			//
			// Init host.
			//
			if( $theConnection === NULL )
				$theConnection = kGRAPH_DEF_HOST;
			
			//
			// Init port.
			//
			if( $theOptions === NULL )
				$theOptions = kGRAPH_DEF_PORT;
			
			//
			// Set connection name.
			//
			$this->offsetSet( kOFFSET_NAME, "neo4j://$theConnection:$theOptions" );
			
			//
			// Instantiate client.
			//
			$theConnection = new Everyman\Neo4j\Client( $theConnection, $theOptions );
		
		} // New container.
		
		//
		// Call parent method.
		//
		parent::__construct( $theConnection );
		
	} // Constructor.

	 
	/*===================================================================================
	 *	__toString																		*
	 *==================================================================================*/

	/**
	 * <h4>Return connection name</h4>
	 *
	 * This method should return the current connection's name.
	 *
	 * In this class we return the host and port names.
	 *
	 * @access public
	 * @return string				The connection name.
	 */
	public function __toString()			{	return $this->offsetGet( kOFFSET_NAME );	}

		

/*=======================================================================================
 *																						*
 *								PUBLIC MEMBER INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Connection																		*
	 *==================================================================================*/

	/**
	 * <h4>Manage native connection</h4>
	 *
	 * We overload this method to ensure that the provided container is a Neo4j client.
	 *
	 * @param mixed					$theValue			Persistent container or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> native container.
	 *
	 * @throws Exception
	 */
	public function Connection( $theValue = NULL, $getOld = FALSE )
	{
		//
		// Check new value.
		//
		if( ($theValue !== NULL)
		 && ($theValue !== FALSE) )
		{
			//
			// Check value type.
			//
			if( ! ($theValue instanceof Everyman\Neo4j\Client) )
				throw new Exception
					( "Invalid container type",
					  kERROR_PARAMETER );										// !@! ==>
		
		} // New value.
		
		return parent::Connection( $theValue, $getOld );							// ==>

	} // Connection.

		

/*=======================================================================================
 *																						*
 *							PUBLIC NODE MANAGEMENT INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	NewNode																			*
	 *==================================================================================*/

	/**
	 * <h4>Create a new node</h4>
	 *
	 * In this class we return a new Neo4j Node instance.
	 *
	 * @param array					$theProperties		Node properties.
	 *
	 * @access public
	 * @return mixed
	 */
	public function NewNode( $theProperties = NULL )
	{
		//
		// Check if object is ready.
		//
		if( $this->_isInited() )
		{
			//
			// Normalise properties.
			//
			if( $theProperties === NULL )
				$theProperties = Array();
			
			return $this->Connection()->makeNode( $theProperties );					// ==>
		
		} // Object is initialised.
		
		throw new Exception
			( "Unable to return new node: the container is not ready",
			  kERROR_STATE );													// !@! ==>
	
	} // NewNode.

	 
	/*===================================================================================
	 *	SetNode																			*
	 *==================================================================================*/

	/**
	 * <h4>Save a node</h4>
	 *
	 * In this class we check if the provided node is of the correct type, save it and
	 * return its identifier.
	 *
	 * @param mixed					$theNode			Node to be saved.
	 *
	 * @access public
	 * @return mixed
	 */
	public function SetNode( $theNode )
	{
		//
		// Check if object is ready.
		//
		if( $this->_isInited() )
		{
			//
			// Check node type.
			//
			if( ! ($theNode instanceof Everyman\Neo4j\Node) )
				throw new Exception
					( "Invalid node type",
					  kERROR_PARAMETER );										// !@! ==>
			
			//
			// Save node.
			//
			if( ! $this->Connection()->saveNode( $theNode ) )
				return FALSE;														// ==>
			
			return $theNode->getId();												// ==>
		
		} // Object is initialised.
		
		throw new Exception
			( "Unable to save node: the container is not ready",
			  kERROR_STATE );													// !@! ==>
	
	} // SetNode.

	 
	/*===================================================================================
	 *	GetNode																			*
	 *==================================================================================*/

	/**
	 * <h4>Get an existing node</h4>
	 *
	 * In this class we return the node corresponding to the provided identifier or
	 * <tt>NULL</tt>.
	 *
	 * @param mixed					$theIdentifier		Node identifier.
	 *
	 * @access public
	 * @return mixed
	 */
	public function GetNode( $theIdentifier )
	{
		//
		// Check if object is ready.
		//
		if( $this->_isInited() )
			return $this->Connection()->getNode( (integer) $theIdentifier, FALSE );	// ==>
		
		throw new Exception
			( "Unable to retrieve node: the container is not ready",
			  kERROR_STATE );													// !@! ==>
	
	} // GetNode.

	 
	/*===================================================================================
	 *	DelNode																			*
	 *==================================================================================*/

	/**
	 * <h4>Delete an existing node</h4>
	 *
	 * In this class we accept either the actual node, or the node identifier.
	 *
	 * @param mixed					$theIdentifier		Node identifier.
	 *
	 * @access public
	 * @return mixed
	 */
	public function DelNode( $theIdentifier )
	{
		//
		// Check if object is ready.
		//
		if( $this->_isInited() )
		{
			//
			// Handle node.
			//
			if( $theIdentifier instanceof Everyman\Neo4j\Node )
				return $this->Connection()->deleteNode( $theIdentifier );			// ==>
			
			//
			// Get node.
			//
			$node = $this->GetNode( $theIdentifier );
			if( $node instanceof Everyman\Neo4j\Node )
				return $this->Connection()->deleteNode( $node );					// ==>
			
			return NULL;															// ==>
		
		} // Object is initialised.
		
		throw new Exception
			( "Unable to delete node: the container is not ready",
			  kERROR_STATE );													// !@! ==>
	
	} // DelNode.

		

/*=======================================================================================
 *																						*
 *							PUBLIC EDGE MANAGEMENT INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	NewEdge																			*
	 *==================================================================================*/

	/**
	 * <h4>Create a new edge</h4>
	 *
	 * In this class we instantiate the relationship and set the subject and object nodes,
	 * we finally convert the provided predicate to a string.
	 *
	 * Both the subject and object nodes can be provided either as a node object or as a
	 * node identifier, the method will take care of fetching the referenced nodes. If any
	 * node is neither a node object or identifier, or if the referenced node cannot be
	 * found, the method will raise an exception.
	 *
	 * @param mixed					$theSubject			Subject node.
	 * @param array					$thePredicate		Edge predicate.
	 * @param mixed					$theObject			Object node.
	 * @param array					$theProperties		Edge properties.
	 *
	 * @access public
	 * @return mixed
	 */
	public function NewEdge( $theSubject, $thePredicate, $theObject, $theProperties = NULL )
	{
		//
		// Check if object is ready.
		//
		if( $this->_isInited() )
		{
			//
			// Normalise properties.
			//
			if( $theProperties === NULL )
				$theProperties = Array();
			
			//
			// Resolve subject.
			//
			if( ! ($theSubject instanceof Everyman\Neo4j\Node) )
			{
				//
				// Resolve node.
				//
				if( is_integer( $theSubject ) )
					$theSubject = $this->GetNode( $theSubject );
				
				else
					throw new Exception
						( "Invalid subject node type",
						  kERROR_PARAMETER );									// !@! ==>
				
				//
				// Check node.
				//
				if( ! ($theSubject instanceof Everyman\Neo4j\Node) )
					throw new Exception
						( "Subject node not found",
						  kERROR_NOT_FOUND );									// !@! ==>
			
			} // Not a node.
			
			//
			// Resolve object.
			//
			if( ! ($theObject instanceof Everyman\Neo4j\Node) )
			{
				//
				// Resolve node.
				//
				if( is_integer( $theObject ) )
					$theObject = $this->GetNode( $theObject );
				
				else
					throw new Exception
						( "Invalid object node type",
						  kERROR_PARAMETER );									// !@! ==>
				
				//
				// Check node.
				//
				if( ! ($theObject instanceof Everyman\Neo4j\Node) )
					throw new Exception
						( "Object node not found",
						  kERROR_NOT_FOUND );									// !@! ==>
			
			} // Not a node.
			
			//
			// Instantiate edge.
			//
			$edge = $this->Connection()->makeRelationship( $theProperties );
			
			//
			// Set subject.
			//
			$edge->setStartNode( $theSubject );
			
			//
			// Set object.
			//
			$edge->setEndNode( $theObject );
			
			//
			// Set predicate.
			//
			$edge->setType( (string) $thePredicate );
			
			return $edge;															// ==>
		
		} // Object is initialised.
		
		throw new Exception
			( "Unable to return new edge: the container is not ready",
			  kERROR_STATE );													// !@! ==>
	
	} // NewEdge.

	 
	/*===================================================================================
	 *	SetEdge																			*
	 *==================================================================================*/

	/**
	 * <h4>Save an edge</h4>
	 *
	 * In this class we save the provided edge.
	 *
	 * @param mixed					$theEdge			Edge to be saved.
	 *
	 * @access public
	 * @return mixed
	 */
	public function SetEdge( $theEdge )
	{
		//
		// Check if object is ready.
		//
		if( $this->_isInited() )
		{
			//
			// Check edge type.
			//
			if( ! ($theEdge instanceof Everyman\Neo4j\Relationship) )
				throw new Exception
					( "Invalid edge type",
					  kERROR_PARAMETER );										// !@! ==>
			
			//
			// Save node.
			//
			if( ! $this->Connection()->saveRelationship( $theEdge ) )
				return FALSE;														// ==>
			
			return $theEdge->getId();												// ==>
		
		} // Object is initialised.
		
		throw new Exception
			( "Unable to save edge: the container is not ready",
			  kERROR_STATE );													// !@! ==>
	
	} // SetEdge.

	 
	/*===================================================================================
	 *	GetEdge																			*
	 *==================================================================================*/

	/**
	 * <h4>Get an existing edge</h4>
	 *
	 * In this class we return the edge corresponding to the provided ID, or <tt>NULL</tt>.
	 *
	 * @param mixed					$theIdentifier		Edge identifier.
	 *
	 * @access public
	 * @return mixed
	 */
	public function GetEdge( $theIdentifier )
	{
		//
		// Check if object is ready.
		//
		if( $this->_isInited() )
			return $this->Connection()
						->getRelationship( (integer) $theIdentifier, FALSE );		// ==>
		
		throw new Exception
			( "Unable to retrieve edge: the container is not ready",
			  kERROR_STATE );													// !@! ==>
	
	} // GetEdge.

	 
	/*===================================================================================
	 *	DelEdge																			*
	 *==================================================================================*/

	/**
	 * <h4>Delete an existing edge</h4>
	 *
	 * This method should delete the provided edge from the current graph.
	 *
	 * The method should return <tt>TRUE</tt> if the operation was successful and
	 * <tt>NULL</tt> if the provided identifier is not resolved.
	 *
	 * @param mixed					$theIdentifier		Edge identifier.
	 *
	 * @access public
	 * @return mixed
	 */
	public function DelEdge( $theIdentifier )
	{
		//
		// Check if object is ready.
		//
		if( $this->_isInited() )
		{
			//
			// Handle edge.
			//
			if( $theIdentifier instanceof Everyman\Neo4j\Relationship )
				return $this->Connection()->deleteRelationship( $theIdentifier );	// ==>
			
			//
			// Get edge.
			//
			$edge = $this->GetEdge( $theIdentifier );
			if( $edge instanceof Everyman\Neo4j\Relationship )
				return $this->Connection()->deleteRelationship( $edge );			// ==>
			
			return NULL;															// ==>
		
		} // Object is initialised.
		
		throw new Exception
			( "Unable to delete edge: the container is not ready",
			  kERROR_STATE );													// !@! ==>
	
	} // DelEdge.

		

/*=======================================================================================
 *																						*
 *							PUBLIC STRUCTURE MANAGEMENT INTERFACE						*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	GetNodeEdges																	*
	 *==================================================================================*/

	/**
	 * <h4>Get node edges</h4>
	 *
	 * In this class we accept the following values:
	 *
	 * <ul>
	 *	<li><tt>$theNode</tt>: Either the node identifier or the node object.
	 *	<li><tt>$thePredicate</tt>: Either a predicate or a predicates list, the elements
	 *		can be of any type, provided they can be cast to a string.
	 *	<li><tt>$theSense</tt>: If this parameter is omitted, we set
	 *		{@link kTYPE_RELATION_ALL} as default.
	 * </ul>
	 *
	 * @param mixed					$theNode			Reference node.
	 * @param mixed					$thePredicate		Edge predicates filter.
	 * @param string				$theSense			Relationship sense.
	 *
	 * @access public
	 * @return mixed
	 */
	public function GetNodeEdges( $theNode, $thePredicate = NULL, $theSense = NULL )
	{
		//
		// Check if object is ready.
		//
		if( $this->_isInited() )
		{
			//
			// Resolve node.
			//
			if( ! ($theNode instanceof Everyman\Neo4j\Node) )
			{
				//
				// Resolve node.
				//
				if( is_integer( $theNode ) )
					$theNode = $this->GetNode( $theNode );
				
				else
					throw new Exception
						( "Invalid node type",
						  kERROR_PARAMETER );									// !@! ==>
				
				//
				// Check node.
				//
				if( ! ($theNode instanceof Everyman\Neo4j\Node) )
					throw new Exception
						( "Node not found",
						  kERROR_NOT_FOUND );									// !@! ==>
			
			} // Not a node.
			
			//
			// Normalise predicates.
			//
			if( $thePredicate === NULL )
				$thePredicate = Array();
			else
			{
				//
				// Normalise predicates list.
				//
				if( is_array( $thePredicate ) )
				{
					//
					// Iterate elements.
					//
					$keys = array_keys( $thePredicate );
					foreach( $keys as $Key )
						$thePredicate[ $key ] = (string) $thePredicate[ $key ];
				
				} // Predicates list.
				
				//
				// Normalise predicate.
				//
				else
					$thePredicate = (string) $thePredicate;
			
			} // Normalise predicates.
			
			//
			// Normalise sense.
			//
			switch( $theSense )
			{
				case kTYPE_RELATION_IN:
					$theSense = Everyman\Neo4j\Relationship::DirectionIn;
					break;

				case kTYPE_RELATION_OUT:
					$theSense = Everyman\Neo4j\Relationship::DirectionOut;
					break;

				case kTYPE_RELATION_ALL:
					$theSense = Everyman\Neo4j\Relationship::DirectionAll;
					break;
				
				default:
					if( $theSense !== NULL )
						throw new Exception
							( "Unsupported relationship sense",
							  kERROR_PARAMETER );								// !@! ==>
					break;
			
			} // Normalising sense.
			
			return $this->Connection()
						->getNodeRelationships(
							$theNode, $thePredicate, $theSense );					// ==>
		
		} // Object is initialised.
		
		throw new Exception
			( "Unable to get node edges: the container is not ready",
			  kERROR_STATE );													// !@! ==>
	
	} // GetNodeEdges.

	 

} // class CNeo4jGraph.


?>

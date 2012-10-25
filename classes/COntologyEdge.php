<?php

/**
 * <i>COntologyEdge</i> class definition.
 *
 * This file contains the class definition of <b>COntologyEdge</b> which represents the
 * ancestor of ontology edge classes.
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 14/09/2012
 */

/*=======================================================================================
 *																						*
 *									COntologyEdge.php									*
 *																						*
 *======================================================================================*/

/**
 * Local definitions.
 *
 * This include file contains common offset definitions.
 */
require_once( "COntologyEdge.inc.php" );

/**
 * Nodes.
 *
 * This includes the node class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntologyNode.php" );

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CEdge.php" );

/**
 * <h3>Ontology edge object ancestor</h3>
 *
 * This class extends its ancestor, {@link CEdge}, by asserting the {@link Subject()} and
 * {@link Object()} to be instances of {@link COntologyNode}, and the {@link Predicate} to
 * be an instance of {@link COntologyTerm}.
 *
 * This class overloads the native identification workflow by using a number sequence tagged
 * by {@link kSEQUENCE_KEY_EDGE}. The class also features a unique identifier,
 * {@link kTAG_UID}, which receives the hash of the global identifier, this will be
 * useful to identify duplicates.
 *
 * When adding vertices and predicates to the object, these can be provided as objects and
 * if these objects are not {@link _IsCommitted}, they will be stored before the current
 * edge object is committed.
 *
 * The class features an offset, {@link kTAG_REFS_TAG}, which represents the list of tags
 * that reference the current node. This offset is a set of tag identifiers implemented as
 * an array. The offset definition is borrowed from the {@link COntologyTerm} class, which
 * is required by this class because of its {@link kTAG_PREDICATE} offset. This offset is
 * managed by the tag class, this class locks the offset.
 *
 * The class also adds two enumerated sets that represent respectively the subject and the
 * object vertex kind. These attributes are used to determine the nature of the subject and
 * vertex nodes in terms of the current graph connection.
 *
 * The class implements the static method, {@link DefaultContainer()}, it will use the
 * {@link kCONTAINER_EDGE_NAME} constant. Note that when passing {@link CConnection} based
 * objects to the persisting methods of this class, you should provide preferably Database
 * instances, since this class may have to commit terms.
 *
 * The class features member accessor methods for the default offsets:
 *
 * <ul>
 *	<li>{@link LoadSubject()}: This method will return the referenced subject vertex
 *		{@link COntologyNode} object.
 *	<li>{@link LoadPredicate()}: This method will return the referenced predicate
 *		{@link COntologyTerm} object.
 *	<li>{@link LoadObject()}: This method will return the referenced object vertex
 *		{@link COntologyNode} object.
 * </ul>
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 */
class COntologyEdge extends CEdge
{
	/**
	 * <b>Subject node object</b>
	 *
	 * This data member holds the subject node object when requested.
	 *
	 * @var COntologyNode
	 */
	 protected $mSubject = NULL;

	/**
	 * <b>Predicate term object</b>
	 *
	 * This data member holds the predicate term object when requested.
	 *
	 * @var COntologyTerm
	 */
	 protected $mPredicate = NULL;

	/**
	 * <b>Object node object</b>
	 *
	 * This data member holds the object node object when requested.
	 *
	 * @var COntologyNode
	 */
	 protected $mObject = NULL;

		

/*=======================================================================================
 *																						*
 *							PUBLIC RELATED MEMBER INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	LoadSubject																		*
	 *==================================================================================*/

	/**
	 * <h4>Load subject node object</h4>
	 *
	 * This method will return the current subject node object: if the node is not set, the
	 * method will return <tt>NULL</tt>; if the node cannot be found, the method will raise
	 * an exception.
	 *
	 * The object will also be loaded in a data member that can function as a cache.
	 *
	 * The method features two parameters: the first refers to the container in which the
	 * node is stored, the second is a boolean flag that determines whether the object
	 * is to be read, or if the cached copy can be used.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param boolean				$doReload			Reload if <tt>TRUE</tt>.
	 *
	 * @access public
	 * @return COntologyNode		Node object or <tt>NULL</tt>.
	 *
	 * @throws Exception
	 *
	 * @uses NewObject()
	 *
	 * @see kTAG_VERTEX_SUBJECT
	 */
	public function LoadSubject( CConnection $theConnection, $doReload = FALSE )
	{
		//
		// Check offset.
		//
		if( $this->offsetExists( kTAG_VERTEX_SUBJECT ) )
		{
			//
			// Refresh cache.
			// Uncommitted nodes are cached by default.
			//
			if( $doReload						// Reload,
			 || ($this->mSubject === NULL) )	// or not cached.
			{
				//
				// Handle node object.
				//
				$node = $this->offsetGet( kTAG_VERTEX_SUBJECT );
				if( $node instanceof COntologyNode )
					return $node;													// ==>
				
				//
				// Load node object.
				//
				$this->mSubject
					= $this->NewObject
						( COntologyNode::ResolveClassContainer( $theConnection, TRUE ),
						  $node );
			
			} // Reload or empty cache.
			
			//
			// Handle not found.
			//
			if( $this->mSubject === NULL )
				throw new Exception
					( "Subject vertex node not found",
					  kERROR_STATE );											// !@! ==>
		
		} // Has term.
		
		return $this->mSubject;														// ==>

	} // LoadSubject.

	 
	/*===================================================================================
	 *	LoadPredicate																	*
	 *==================================================================================*/

	/**
	 * <h4>Load predicate term object</h4>
	 *
	 * This method will return the current predicate term object: if the term is not set,
	 * the method will return <tt>NULL</tt>; if the term cannot be found, the method will
	 * raise an exception.
	 *
	 * The object will also be loaded in a data member that can function as a cache.
	 *
	 * The method features two parameters: the first refers to the container in which the
	 * term is stored, the second is a boolean flag that determines whether the object
	 * is to be read, or if the cached copy can be used.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param boolean				$doReload			Reload if <tt>TRUE</tt>.
	 *
	 * @access public
	 * @return COntologyTerm		Term object or <tt>NULL</tt>.
	 *
	 * @throws Exception
	 *
	 * @uses NewObject()
	 *
	 * @see kTAG_PREDICATE
	 */
	public function LoadPredicate( CConnection $theConnection, $doReload = FALSE )
	{
		//
		// Check offset.
		//
		if( $this->offsetExists( kTAG_PREDICATE ) )
		{
			//
			// Refresh cache.
			// Uncommitted terms are cached by default.
			//
			if( $doReload						// Reload,
			 || ($this->mPredicate === NULL) )	// or not cached.
			{
				//
				// Handle term object.
				//
				$term = $this->offsetGet( kTAG_PREDICATE );
				if( $term instanceof COntologyTerm )
					return $term;													// ==>
				
				//
				// Load term object.
				//
				$this->mPredicate
					= $this->NewObject
						( COntologyTerm::ResolveClassContainer( $theConnection, TRUE ),
						  $term );
			
			} // Reload or empty cache.
			
			//
			// Handle not found.
			//
			if( $this->mPredicate === NULL )
				throw new Exception
					( "Predicate term not found",
					  kERROR_STATE );											// !@! ==>
		
		} // Has term.
		
		return $this->mPredicate;													// ==>

	} // LoadPredicate.

	 
	/*===================================================================================
	 *	LoadObject																		*
	 *==================================================================================*/

	/**
	 * <h4>Load object node object</h4>
	 *
	 * This method will return the current object node object: if the node is not set, the
	 * method will return <tt>NULL</tt>; if the node cannot be found, the method will raise
	 * an exception.
	 *
	 * The object will also be loaded in a data member that can function as a cache.
	 *
	 * The method features two parameters: the first refers to the container in which the
	 * node is stored, the second is a boolean flag that determines whether the object
	 * is to be read, or if the cached copy can be used.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param boolean				$doReload			Reload if <tt>TRUE</tt>.
	 *
	 * @access public
	 * @return COntologyNode		Node object or <tt>NULL</tt>.
	 *
	 * @throws Exception
	 *
	 * @uses NewObject()
	 *
	 * @see kTAG_VERTEX_OBJECT
	 */
	public function LoadObject( CConnection $theConnection, $doReload = FALSE )
	{
		//
		// Check offset.
		//
		if( $this->offsetExists( kTAG_VERTEX_OBJECT ) )
		{
			//
			// Refresh cache.
			// Uncommitted nodes are cached by default.
			//
			if( $doReload						// Reload,
			 || ($this->mObject === NULL) )	// or not cached.
			{
				//
				// Handle node object.
				//
				$node = $this->offsetGet( kTAG_VERTEX_OBJECT );
				if( $node instanceof COntologyNode )
					return $node;													// ==>
				
				//
				// Load node object.
				//
				$this->mObject
					= $this->NewObject
						( COntologyNode::ResolveClassContainer( $theConnection, TRUE ),
						  $node );
			
			} // Reload or empty cache.
			
			//
			// Handle not found.
			//
			if( $this->mObject === NULL )
				throw new Exception
					( "Object vertex node not found",
					  kERROR_STATE );											// !@! ==>
		
		} // Has term.
		
		return $this->mObject;														// ==>

	} // LoadObject.

		

/*=======================================================================================
 *																						*
 *								STATIC CONTAINER INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	DefaultContainer																*
	 *==================================================================================*/

	/**
	 * <h4>Return the edges container</h4>
	 *
	 * The container will be created or fetched from the provided database using the
	 * {@link kCONTAINER_EDGE_NAME} name.
	 *
	 * @param CDatabase				$theDatabase		Database object.
	 *
	 * @static
	 * @return CContainer			The edges container.
	 *
	 * @see kCONTAINER_EDGE_NAME
	 */
	static function DefaultContainer( CDatabase $theDatabase )
	{
		return $theDatabase->Container( kCONTAINER_EDGE_NAME );						// ==>
	
	} // DefaultContainer.

		

/*=======================================================================================
 *																						*
 *								STATIC RESOLUTION INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Resolve																			*
	 *==================================================================================*/

	/**
	 * <h4>Resolve an edge</h4>
	 *
	 * This method can be used to retrieve an existing edge by identifier.
	 *
	 * The method accepts the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theConnection</tt>: This parameter represents the connection from which the
	 *		nodes container must be resolved. If this parameter cannot be correctly
	 *		determined, the method will raise an exception.
	 *	<li><tt>$theIdentifier</tt>: This parameter represents the edge unique, global,
	 *		native identifier or object, depending on its type:
	 *	 <ul>
	 *		<li><tt>{@link COntologyEdge}</tt>: In this case the method will use the
	 *			provided edge's global identifier.
	 *		<li><tt>integer</tt>: In this case the method assumes that the parameter
	 *			represents the edge identifier: it will attempt to retrieve the edge, if it
	 *			is not found, the method will return <tt>NULL</tt>.
	 *		<li><i>other</i>: Any other type will be interpreted either as the edge's unique
	 *			identifier, or as the edges's global identifier: the method will return the
	 *			matching edge or <tt>NULL</tt>.
	 *	 </ul>
	 *	<li><tt>$doThrow</tt>: If <tt>TRUE</tt>, any failure to resolve the edge will raise
	 *		an exception.
	 * </ul>
	 *
	 * The method will return the found edge, <tt>NULL</tt> if not found, or raise an
	 * exception if the last parameter is <tt>TRUE</tt>.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param mixed					$theIdentifier		Edge reference.
	 * @param boolean				$doThrow			If <tt>TRUE</tt> raise an exception.
	 *
	 * @static
	 * @return COntologyEdge		Found edge or <tt>NULL</tt>.
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
			// Resolve container.
			//
			$container = COntologyEdge::ResolveClassContainer( $theConnection, TRUE );
			
			//
			// Handle edge native identifier.
			//
			if( is_integer( $theIdentifier ) )
			{
				//
				// Get edge.
				//
				$edge = COntologyEdge::NewObject( $theConnection, $theIdentifier );
				
				//
				// Handle missing node.
				//
				if( ($edge === NULL)
				 && $doThrow )
					throw new Exception
						( "Edge not found",
						  kERROR_NOT_FOUND );									// !@! ==>
				
				return $edge;														// ==>
			
			} // Provided edge identifier.
			
			//
			// Handle edge object.
			//
			if( $theIdentifier instanceof COntologyEdge )
				$theIdentifier = $theIdentifier->GID();
			
			//
			// Try unique identifier.
			//
			$query = $container->NewQuery();
			$query->AppendStatement(
				CQueryStatement::Equals(
					kTAG_UID, $theIdentifier, kTYPE_BINARY ) );
			$found = $container->Query( $query, NULL, TRUE );
			if( $found !== NULL )
				return $found;														// ==>
			
			//
			// Try global identifier.
			//
			$theIdentifier = md5( $theIdentifier, TRUE );
			$query = $container->NewQuery();
			$query->AppendStatement(
				CQueryStatement::Equals(
					kTAG_UID, $theIdentifier, kTYPE_BINARY ) );
			$found = $container->Query( $query, NULL, TRUE );
			if( $found !== NULL )
				return $found;														// ==>

			//
			// Raise exception.
			//
			if( $doThrow )
				throw new Exception
					( "Edge not found",
					  kERROR_NOT_FOUND );										// !@! ==>
			
			return NULL;															// ==>
			
		} // Provided local or global identifier.
		
		throw new Exception
			( "Missing edge reference",
			  kERROR_PARAMETER );												// !@! ==>

	} // Resolve.

		

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
	 * We override the parent method to handle the referenced objects: in this class the
	 * global identifier is the concatenation of the subject native identifier, the
	 * predicate global identifier and the object native identifier all separated by the
	 * {@link kTOKEN_INDEX_SEPARATOR} token.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param bitfield				$theModifiers		Commit options.
	 *
	 * @throws Exception
	 *
	 * @access protected
	 * @return string|NULL			The object's global unique identifier.
	 *
	 * @throws Exception
	 *
	 * @uses LoadSubject()
	 * @uses LoadPredicate()
	 * @uses LoadObject()
	 *
	 * @see kOFFSET_NID kTAG_GID kTOKEN_INDEX_SEPARATOR
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
		$tmp = $this->LoadSubject( $theConnection );
		if( $tmp !== NULL )
			$identifier[] = (string) $tmp[ kOFFSET_NID ];
		else
			throw new Exception
				( "Missing subject vertex",
				  kERROR_STATE );												// !@! ==>
		
		//
		// Get predicate.
		//
		$tmp = $this->LoadPredicate( $theConnection );
		if( $tmp !== NULL )
			$identifier[] = $tmp[ kTAG_GID ];
		else
			throw new Exception
				( "Missing predicate",
				  kERROR_STATE );												// !@! ==>
		
		//
		// Get object.
		//
		$tmp = $this->LoadObject( $theConnection );
		if( $tmp !== NULL )
			$identifier[] = (string) $tmp[ kOFFSET_NID ];
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
	 *	_Preset																			*
	 *==================================================================================*/

	/**
	 * <h4>Handle offset before setting it</h4>
	 *
	 * In this class we handle the subject, predicate and object offsets, if provided as
	 * objects we leave them unchanged only if not yet committed, if not, we convert them to
	 * their native identifiers.
	 *
	 * We also ensure that the provided objects are instances of the correct classes by
	 * asserting {@link CDocument} descendants.
	 *
	 * This method will lock the {@link kTAG_REFS_TAG} offset from any modification.
	 *
	 * @param reference			   &$theOffset			Offset.
	 * @param reference			   &$theValue			Value to set at offset.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 *
	 * @uses _IsCommitted()
	 * @uses _AssertClass()
	 *
	 * @see kTAG_REFS_TAG
	 * @see kTAG_PREDICATE kTAG_VERTEX_OBJECT kTAG_VERTEX_SUBJECT
	 */
	protected function _Preset( &$theOffset, &$theValue )
	{
		//
		// Intercept reference offsets.
		//
		if( $theOffset == kTAG_REFS_TAG )
			throw new Exception
				( "The [$theOffset] offset cannot be modified",
				  kERROR_LOCKED );												// !@! ==>
		
		//
		// Parse by offset.
		//
		switch( $theOffset )
		{
			case kTAG_PREDICATE:
	
				//
				// Lock term if object is committed.
				//
				if( $this->_IsCommitted() )
					throw new Exception
						( "You cannot modify the [$theOffset] offset: "
						 ."the object is committed",
						  kERROR_LOCKED );										// !@! ==>
				
				//
				// Check value type.
				//
				$ok = $this->_AssertClass( $theValue, 'CDocument', 'COntologyTerm' );
				
				//
				// Handle wrong object.
				//
				if( $ok === FALSE )
					throw new Exception
						( "Cannot set predicate: "
						 ."the object must be a term reference or object",
						  kERROR_PARAMETER );									// !@! ==>
				
				//
				// Handle right object.
				//
				if( $ok )
				{
					//
					// Use native identifier.
					//
					if( $theValue->_IsCommitted() )
					{
						//
						// Check native identifier.
						//
						if( $theValue->offsetExists( kOFFSET_NID ) )
							$theValue = $theValue->offsetGet( kOFFSET_NID );
						else
							throw new Exception
								( "Cannot set predicate: "
								 ."the object is missing its native identifier",
								  kERROR_PARAMETER );							// !@! ==>
					
					} // Object is committed.
					
					//
					// Copy to data member.
					//
					else
						$this->mPredicate = $theValue;
				
				} // Correct object class.
				
				break;

			case kTAG_VERTEX_OBJECT:
			case kTAG_VERTEX_SUBJECT:
			
				//
				// Lock node if object is committed.
				//
				if( $this->_IsCommitted() )
					throw new Exception
						( "You cannot modify the [$theOffset] offset: "
						 ."the object is committed",
						  kERROR_LOCKED );										// !@! ==>
				
				//
				// Check value type.
				//
				$ok = $this->_AssertClass( $theValue, 'CDocument', 'COntologyNode' );
				
				//
				// Handle wrong object.
				//
				if( $ok === FALSE )
				{
					if( $theOffset == kTAG_VERTEX_OBJECT )
						throw new Exception
							( "Cannot set object vertex: "
							 ."the object must be a node reference or object",
							  kERROR_PARAMETER );								// !@! ==>
					else
						throw new Exception
							( "Cannot set subject vertex: "
							 ."the object must be a node reference or object",
							  kERROR_PARAMETER );								// !@! ==>
				}
				
				//
				// Handle right object.
				//
				if( $ok )
				{
					//
					// Use native identifier.
					//
					if( $theValue->_IsCommitted() )
					{
						//
						// Check native identifier.
						//
						if( $theValue->offsetExists( kOFFSET_NID ) )
							$theValue = $theValue->offsetGet( kOFFSET_NID );
						else
						{
							if( $theOffset == kTAG_VERTEX_OBJECT )
								throw new Exception
									( "Cannot set object vertex: "
									 ."the object is missing its native identifier",
									  kERROR_PARAMETER );						// !@! ==>
							else
								throw new Exception
									( "Cannot set subject vertex: "
									 ."the object is missing its native identifier",
									  kERROR_PARAMETER );						// !@! ==>
						}
					
					} // Object is committed.
					
					//
					// Copy to data member.
					//
					else
					{
						if( $theOffset == kTAG_VERTEX_OBJECT )
							$this->mObject = $theValue;
						else
							$this->mSubject = $theValue;
					}
				
				} // Correct object class.
				
				break;
		
		} // Parsed by offset.
		
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
	 * In this class we prevent the modification of the subject, predicate and object
	 * offsets if the object is committed and of the {@link kTAG_REFS_TAG} offset in all
	 * cases.
	 *
	 * @param reference			   &$theOffset			Offset.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 *
	 * @uses _IsCommitted()
	 *
	 * @see kTAG_REFS_TAG
	 * @see kTAG_PREDICATE kTAG_VERTEX_OBJECT kTAG_VERTEX_SUBJECT
	 */
	protected function _Preunset( &$theOffset )
	{
		//
		// Intercept reference offsets.
		//
		if( $theOffset == kTAG_REFS_TAG )
			throw new Exception
				( "The [$theOffset] offset cannot be modified",
				  kERROR_LOCKED );												// !@! ==>
		
		//
		// Lock subject, predicate and object vertices if object is committed.
		//
		$offsets = array( kTAG_VERTEX_SUBJECT,
						  kTAG_PREDICATE,
						  kTAG_VERTEX_OBJECT );
		if( in_array( $theOffset, $offsets )
		 && $this->_IsCommitted() )
			throw new Exception
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
 *							PROTECTED PRE-COMMIT INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_PrecommitRelated																*
	 *==================================================================================*/

	/**
	 * <h4>Handle embedded or related objects before committing</h4>
	 *
	 * In this class we commit the eventual term provided as an uncommitted object and
	 * replace the offset with the term's native identifier, or load the term if provided
	 * as an identifier.
	 *
	 * @param reference			   &$theConnection		Server, database or container.
	 * @param reference			   &$theModifiers		Commit options.
	 *
	 * @access protected
	 *
	 * @uses LoadSubject()
	 * @uses LoadPredicate()
	 * @uses LoadObject()
	 *
	 * @see kTAG_PREDICATE kTAG_VERTEX_OBJECT kTAG_VERTEX_SUBJECT
	 */
	protected function _PrecommitRelated( &$theConnection, &$theModifiers )
	{
		//
		// Call parent method.
		//
		parent::_PrecommitRelated( $theConnection, $theModifiers );
		
		//
		// Not deleting.
		//
		if( ! ($theModifiers & kFLAG_PERSIST_DELETE) )
		{
			//
			// Handle subject vertice object.
			// Note that we let _Preset() method take care of the specific class.
			// Note that we do not check the object: it is required to be inited.
			//
			$object = $this->offsetGet( kTAG_VERTEX_SUBJECT );
			if( $object instanceof COntologyNode )
			{
				//
				// Commit.
				// Note that we insert, to ensure the object is new.
				//
				$object->Insert(
					COntologyNode::ResolveClassContainer(
						$theConnection, TRUE ) );
				
				//
				// Cache it.
				//
				$this->mSubject = $object;
				
				//
				// Set identifier in subject offset.
				//
				$this->offsetSet( kTAG_VERTEX_SUBJECT,
								  $this->mSubject->offsetGet( kOFFSET_NID ) );
				
			} // Subject is object.
			
			//
			// Handle subject identifier.
			//
			else
				$this->LoadSubject( $theConnection, TRUE );
		
			//
			// Handle predicate object.
			// Note that we let _Preset() method take care of the specific class.
			// Note that we do not check the object: it is required to be inited.
			//
			$object = $this->offsetGet( kTAG_PREDICATE );
			if( $object instanceof COntologyTerm )
			{
				//
				// Commit.
				// Note that we insert, to ensure the object is new.
				//
				$object->Insert(
					COntologyTerm::ResolveClassContainer(
						$theConnection, TRUE ) );
				
				//
				// Cache it.
				//
				$this->mPredicate = $object;
				
				//
				// Set identifier in predicate offset.
				//
				$this->offsetSet( kTAG_PREDICATE,
								  $this->mPredicate->offsetGet( kOFFSET_NID ) );
				
			} // Predicate is object.
			
			//
			// Handle predicate identifier.
			//
			else
				$this->LoadPredicate( $theConnection, TRUE );
		
			//
			// Handle object vertice object.
			// Note that we let _Preset() method take care of the specific class.
			// Note that we do not check the object: it is required to be inited.
			//
			$object = $this->offsetGet( kTAG_VERTEX_OBJECT );
			if( $object instanceof COntologyNode )
			{
				//
				// Commit.
				// Note that we insert, to ensure the object is new.
				//
				$object->Insert(
					COntologyNode::ResolveClassContainer(
						$theConnection, TRUE ) );
				
				//
				// Cache it.
				//
				$this->mObject = $object;
				
				//
				// Set identifier in object offset.
				//
				$this->offsetSet( kTAG_VERTEX_OBJECT,
								  $this->mObject->offsetGet( kOFFSET_NID ) );
				
			} // Object is object.
			
			//
			// Handle object identifier.
			//
			else
				$this->LoadObject( $theConnection, TRUE );
		
		} // Not deleting.
	
	} // _PrecommitRelated.

	 
	/*===================================================================================
	 *	_PrecommitIdentify																*
	 *==================================================================================*/

	/**
	 * <h4>Determine the identifiers before committing</h4>
	 *
	 * This method will use the result of the {@link _index()} method to set the global
	 * identifier, {@link kTAG_GID}; the same value will be hashed and constitute the
	 * unique identifier, {@link kTAG_UID}.
	 *
	 * Objects of this class are identified by a sequence number tagged
	 * {@link kSEQUENCE_KEY_EDGE}, this method will set the native identifier,
	 * {@link kOFFSET_NID}, with this value.
	 *
	 * The parent method will then be called, which will ignore the global and native
	 * identifiers, since they will have been set here.
	 *
	 * @param reference			   &$theConnection		Server, database or container.
	 * @param reference			   &$theModifiers		Commit options.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 *
	 * @see kSEQUENCE_KEY_EDGE
	 * @see kOFFSET_NID kTAG_GID kTAG_UID
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
			// Set global identifier.
			//
			if( ! $this->offsetExists( kTAG_GID ) )
			{
				//
				// Generate global identifier.
				//
				$index = $this->_index( $theConnection, $theModifiers );
				if( $index !== NULL )
				{
					//
					// Set global identifier.
					//
					$this->offsetSet( kTAG_GID, $index );
					
					//
					// Resolve container.
					//
					$container = self::ResolveContainer( $theConnection, TRUE );
					
					//
					// Generate unique identifier.
					//
					$uid = $container->ConvertValue( kTYPE_BINARY, md5( $index, TRUE ) );
					
					//
					// Check unique identifier.
					//
					if( $container->CheckObject( $uid, kTAG_UID ) )
						throw new Exception
							( "Duplicate object",
							  kERROR_COMMIT );												// !@! ==>
					
					//
					// Set unique identifier.
					//
					$this->offsetSet( kTAG_UID, $uid );
				
				} // Has global identifier.
			
			} // Missing global identifier.
		
			//
			// Set native identifier.
			//
			if( ! $this->offsetExists( kOFFSET_NID ) )
				$this->offsetSet(
					kOFFSET_NID,
					static::ResolveContainer(
						$theConnection, TRUE )
							->NextSequence( kSEQUENCE_KEY_EDGE, TRUE ) );
		
		} // Insert or replace.
	
		//
		// Call parent method.
		//
		parent::_PrecommitIdentify( $theConnection, $theModifiers );
		
	} // _PrecommitIdentify.
		


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
	 * In this class we add the current edge's identifier to the list of edge references,
	 * {@link kTAG_REFS_EDGE}, in the related subject and object vertives when inserting;
	 * we remove the element when deleting.
	 *
	 * @param reference			   &$theConnection		Server, database or container.
	 * @param reference			   &$theModifiers		Commit options.
	 *
	 * @access protected
	 *
	 * @uses _IsCommitted()
	 *
	 * @see kTAG_REFS_EDGE kTAG_VERTEX_SUBJECT kTAG_VERTEX_OBJECT
	 * @see kFLAG_PERSIST_INSERT kFLAG_PERSIST_REPLACE kFLAG_PERSIST_DELETE
	 * @see kFLAG_PERSIST_MODIFY kFLAG_MODIFY_ADDSET kFLAG_MODIFY_PULL
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
			{
				//
				// Add current edge reference to subject vertex referenced.
				//
				$this->_ReferenceInSubject( $theConnection, TRUE );
				
				//
				// Add current edge reference to object vertex referenced.
				//
				$this->_ReferenceInObject( $theConnection, TRUE );
				
			} // Not yet committed.
		
		} // Insert or replace.
		
		//
		// Check if deleting.
		//
		elseif( $theModifiers & kFLAG_PERSIST_DELETE )
		{
			//
			// Remove current edge reference from subject vertex referenced.
			//
			$this->_ReferenceInSubject( $theConnection, FALSE );
			
			//
			// Remove current edge reference from object vertex referenced.
			//
			$this->_ReferenceInObject( $theConnection, FALSE );
		
		} // Deleting.
		
	} // _PostcommitRelated.

	 
	/*===================================================================================
	 *	_PostcommitCleanup																*
	 *==================================================================================*/

	/**
	 * <h4>Cleanup the object after committing</h4>
	 *
	 * In this class we reset the term object cache, we set the data members to
	 * <tt>NULL</tt> so that next time one wants to retrieve related objects, the cache will
	 * have to be refreshed.
	 *
	 * @param reference			   &$theConnection		Server, database or container.
	 * @param reference			   &$theModifiers		Commit options.
	 *
	 * @access protected
	 */
	protected function _PostcommitCleanup( &$theConnection, &$theModifiers )
	{
		//
		// Call parent method.
		//
		parent::_PostcommitCleanup( $theConnection, $theModifiers );
		
		//
		// Reset objects cache.
		//
		$this->mSubject = $this->mPredicate = $this->mObject = NULL;
	
	} // _PostcommitCleanup.

		

/*=======================================================================================
 *																						*
 *								PROTECTED REFERENCE INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_ReferenceInSubject																*
	 *==================================================================================*/

	/**
	 * <h4>Add edge reference to subject vertex</h4>
	 *
	 * This method can be used to add or remove the current edge's reference,
	 * {@link kTAG_REFS_EDGE}, from the subject vertex node,
	 * {@link kTAG_VERTEX_SUBJECT}. This method should be used whenever committing a new
	 * edge or when deleting one: it will add the current edge's native identifier to the
	 * set of edge references of the edge's subject vertex when committing a new edge; it
	 * will remove it when deleting the edge.
	 *
	 * The last parameter is a boolean: if <tt>TRUE</tt> the method will add to the set; if
	 * <tt>FALSE</tt>, it will remove from the set.
	 *
	 * The method will return <tt>TRUE</tt> if the operation affected at least one object,
	 * <tt>FALSE</tt> if not, <tt>NULL</tt> if the subject vertex is not set and raise an
	 * exception if the operation failed.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param boolean				$doAdd				<tt>TRUE</tt> add reference.
	 *
	 * @access protected
	 * @return boolean				<tt>TRUE</tt> operation affected at least one object.
	 *
	 * @see kTAG_VERTEX_SUBJECT kTAG_REFS_EDGE
	 * @see kFLAG_PERSIST_MODIFY kFLAG_MODIFY_ADDSET kFLAG_MODIFY_PULL
	 */
	protected function _ReferenceInSubject( CConnection $theConnection, $doAdd )
	{
		//
		// Check subject vertex.
		//
		if( $this->offsetExists( kTAG_VERTEX_SUBJECT ) )
		{
			//
			// Set modification criteria.
			//
			$criteria = array( kTAG_REFS_EDGE => $this->offsetGet( kOFFSET_NID ) );
			
			//
			// Handle add to set.
			//
			if( $doAdd )
				return COntologyNode::ResolveClassContainer( $theConnection, TRUE )
						->ManageObject
							(
								$criteria,
								$this->offsetGet( kTAG_VERTEX_SUBJECT ),
								kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_ADDSET
							);														// ==>
			
			return COntologyNode::ResolveClassContainer( $theConnection, TRUE )
					->ManageObject
						(
							$criteria,
							$this->offsetGet( kTAG_VERTEX_SUBJECT ),
							kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_PULL
						);															// ==>
		
		} // Object has subject node.
		
		return NULL;																// ==>
	
	} // _ReferenceInSubject.

	 
	/*===================================================================================
	 *	_ReferenceInObject																*
	 *==================================================================================*/

	/**
	 * <h4>Add edge reference to object vertex</h4>
	 *
	 * This method can be used to add or remove the current edge's reference,
	 * {@link kTAG_REFS_EDGE}, from the object vertex node,
	 * {@link kTAG_VERTEX_OBJECT}. This method should be used whenever committing a new
	 * edge or when deleting one: it will add the current edge's native identifier to the
	 * set of edge references of the edge's object vertex when committing a new edge; it
	 * will remove it when deleting the edge.
	 *
	 * The last parameter is a boolean: if <tt>TRUE</tt> the method will add to the set; if
	 * <tt>FALSE</tt>, it will remove from the set.
	 *
	 * The method will return <tt>TRUE</tt> if the operation affected at least one object,
	 * <tt>FALSE</tt> if not, <tt>NULL</tt> if the object vertex is not set and raise an
	 * exception if the operation failed.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param boolean				$doAdd				<tt>TRUE</tt> add reference.
	 *
	 * @access protected
	 * @return boolean				<tt>TRUE</tt> operation affected at least one object.
	 *
	 * @see kTAG_VERTEX_OBJECT kTAG_REFS_EDGE
	 * @see kFLAG_PERSIST_MODIFY kFLAG_MODIFY_ADDSET kFLAG_MODIFY_PULL
	 */
	protected function _ReferenceInObject( CConnection $theConnection, $doAdd )
	{
		//
		// Check object vertex.
		//
		if( $this->offsetExists( kTAG_VERTEX_OBJECT ) )
		{
			//
			// Set modification criteria.
			//
			$criteria = array( kTAG_REFS_EDGE => $this->offsetGet( kOFFSET_NID ) );
			
			//
			// Handle add to set.
			//
			if( $doAdd )
				return COntologyNode::ResolveClassContainer( $theConnection, TRUE )
						->ManageObject
							(
								$criteria,
								$this->offsetGet( kTAG_VERTEX_OBJECT ),
								kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_ADDSET
							);														// ==>
			
			return COntologyNode::ResolveClassContainer( $theConnection, TRUE )
					->ManageObject
						(
							$criteria,
							$this->offsetGet( kTAG_VERTEX_OBJECT ),
							kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_PULL
						);															// ==>
		
		} // Object has object node.
		
		return NULL;																// ==>
	
	} // _ReferenceInObject.

	 

} // class COntologyEdge.


?>

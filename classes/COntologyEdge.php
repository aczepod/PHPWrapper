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
 * {@link kOFFSET_UID}, which receives the hash of the global identifier, this will be
 * useful to identify duplicates.
 *
 * When adding vertices and predicates to the object, these can be provided as objects and
 * if these objects are not {@link _IsCommitted}, they will be stored before the current
 * edge object is committed.
 *
 * The class features an offset, {@link kOFFSET_REFS_TAG}, which represents the list of tags
 * that reference the current node. This offset is a set of tag identifiers implemented as
 * an array. The offset definition is borrowed from the {@link COntologyTerm} class, which
 * is required by this class because of its {@link kOFFSET_PREDICATE} offset. This offset is
 * managed by the tag class, this class locks the offset.
 *
 * The class implements the static method, {@link DefaultContainer()}, it will use the
 * {@link kCONTAINER_EDGE_NAME} constant. Note that when passing {@link CConnection} based
 * objects to the persisting methods of this class, you should provide preferably Database
 * instances, since this class may have to commit terms.
 *
 * The class features member accessor methods for the default offsets:
 *
 * <ul>
 *	<li>{@link TagRefs()}: This method returns the node's tag references,
 *		{@link kOFFSET_REFS_TAG}.
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
 *								PUBLIC MEMBER INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	TagRefs																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage tag references</h4>
	 *
	 * The <i>tag references</i>, {@link kOFFSET_REFS_TAG}, holds a list of identifiers of
	 * tags that reference the node.
	 *
	 * The method is read-only, because this value must be managed externally.
	 *
	 * The {@link kOFFSET_REFS_TAG} offset tag is defined by the {@link COntologyTerm} class
	 * which is included in this class by default.
	 *
	 * @access public
	 * @return array				Tags reference list.
	 *
	 * @see kOFFSET_REFS_TAG
	 */
	public function TagRefs()
	{
		//
		// Handle reference count.
		//
		if( $this->offsetExists( kOFFSET_REFS_TAG ) )
			return $this->offsetGet( kOFFSET_REFS_TAG );							// ==>
		
		return Array();																// ==>

	} // TagRefs.

		

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
	 * @see kOFFSET_VERTEX_SUBJECT
	 */
	public function LoadSubject( CConnection $theConnection, $doReload = FALSE )
	{
		//
		// Check offset.
		//
		if( $this->offsetExists( kOFFSET_VERTEX_SUBJECT ) )
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
				$node = $this->offsetGet( kOFFSET_VERTEX_SUBJECT );
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
	 * @see kOFFSET_PREDICATE
	 */
	public function LoadPredicate( CConnection $theConnection, $doReload = FALSE )
	{
		//
		// Check offset.
		//
		if( $this->offsetExists( kOFFSET_PREDICATE ) )
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
				$term = $this->offsetGet( kOFFSET_PREDICATE );
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
	 * @see kOFFSET_VERTEX_OBJECT
	 */
	public function LoadObject( CConnection $theConnection, $doReload = FALSE )
	{
		//
		// Check offset.
		//
		if( $this->offsetExists( kOFFSET_VERTEX_OBJECT ) )
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
				$node = $this->offsetGet( kOFFSET_VERTEX_OBJECT );
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
	 * @see kOFFSET_NID kOFFSET_GID kTOKEN_INDEX_SEPARATOR
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
			$identifier[] = $tmp[ kOFFSET_GID ];
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
	 * This method will lock the {@link kOFFSET_REFS_TAG} offset from any modification.
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
	 * @see kOFFSET_REFS_TAG
	 * @see kOFFSET_PREDICATE kOFFSET_VERTEX_OBJECT kOFFSET_VERTEX_SUBJECT
	 */
	protected function _Preset( &$theOffset, &$theValue )
	{
		//
		// Intercept reference offsets.
		//
		if( $theOffset == kOFFSET_REFS_TAG )
			throw new Exception
				( "The [$theOffset] offset cannot be modified",
				  kERROR_LOCKED );												// !@! ==>
		
		//
		// Parse by offset.
		//
		switch( $theOffset )
		{
			case kOFFSET_PREDICATE:
	
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

			case kOFFSET_VERTEX_OBJECT:
			case kOFFSET_VERTEX_SUBJECT:
			
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
					if( $theOffset == kOFFSET_VERTEX_OBJECT )
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
							if( $theOffset == kOFFSET_VERTEX_OBJECT )
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
						if( $theOffset == kOFFSET_VERTEX_OBJECT )
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
	 * offsets if the object is committed and of the {@link kOFFSET_REFS_TAG} offset in all
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
	 * @see kOFFSET_REFS_TAG
	 * @see kOFFSET_PREDICATE kOFFSET_VERTEX_OBJECT kOFFSET_VERTEX_SUBJECT
	 */
	protected function _Preunset( &$theOffset )
	{
		//
		// Intercept reference offsets.
		//
		if( $theOffset == kOFFSET_REFS_TAG )
			throw new Exception
				( "The [$theOffset] offset cannot be modified",
				  kERROR_LOCKED );												// !@! ==>
		
		//
		// Lock subject, predicate and object vertices if object is committed.
		//
		$offsets = array( kOFFSET_VERTEX_SUBJECT,
						  kOFFSET_PREDICATE,
						  kOFFSET_VERTEX_OBJECT );
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
	 * @see kOFFSET_PREDICATE kOFFSET_VERTEX_OBJECT kOFFSET_VERTEX_SUBJECT
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
			$object = $this->offsetGet( kOFFSET_VERTEX_SUBJECT );
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
				$this->offsetSet( kOFFSET_VERTEX_SUBJECT,
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
			$object = $this->offsetGet( kOFFSET_PREDICATE );
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
				$this->offsetSet( kOFFSET_PREDICATE,
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
			$object = $this->offsetGet( kOFFSET_VERTEX_OBJECT );
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
				$this->offsetSet( kOFFSET_VERTEX_OBJECT,
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
	 * identifier, {@link kOFFSET_GID}; the same value will be hashed and constitute the
	 * unique identifier, {@link kOFFSET_UID}.
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
	 * @see kOFFSET_NID kOFFSET_GID kOFFSET_UID
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
			if( ! $this->offsetExists( kOFFSET_GID ) )
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
					$this->offsetSet( kOFFSET_GID, $index );
					
					//
					// Resolve container.
					//
					$container = self::ResolveContainer( $theConnection, TRUE );
					
					//
					// Generate unique identifier.
					//
					$uid = $container->ConvertBinary( md5( $index, TRUE ) );
					
					//
					// Check unique identifier.
					//
					if( $container->CheckObject( $uid, kOFFSET_UID ) )
						throw new Exception
							( "Duplicate object",
							  kERROR_COMMIT );												// !@! ==>
					
					//
					// Set unique identifier.
					//
					$this->offsetSet( kOFFSET_UID, $uid );
				
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
	 * {@link kOFFSET_REFS_EDGE}, in the related subject and object vertives when inserting;
	 * we remove the element when deleting.
	 *
	 * @param reference			   &$theConnection		Server, database or container.
	 * @param reference			   &$theModifiers		Commit options.
	 *
	 * @access protected
	 *
	 * @uses _IsCommitted()
	 *
	 * @see kOFFSET_REFS_EDGE kOFFSET_VERTEX_SUBJECT kOFFSET_VERTEX_OBJECT
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
				// Set modification criteria.
				//
				$mod = array( kOFFSET_REFS_EDGE => $this->offsetGet( kOFFSET_NID ) );
				
				//
				// Add current edge reference to subject vertex referenced.
				//
				$fields = $mod;
				COntologyNode::ResolveClassContainer( $theConnection, TRUE )
					->ManageObject
					(
						$fields,						// Because it will be overwritten.
						$this->offsetGet( kOFFSET_VERTEX_SUBJECT ),	// Subject identifier.
						kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_ADDSET		// Add to set.
					);
				
				//
				// Add current edge reference to object vertex referenced.
				//
				$fields = $mod;
				COntologyNode::ResolveClassContainer( $theConnection, TRUE )
					->ManageObject
					(
						$fields,						// Because it will be overwritten.
						$this->offsetGet( kOFFSET_VERTEX_OBJECT ),	// Object identifier.
						kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_ADDSET		// Add to set.
					);
				
			} // Not yet committed.
		
		} // Insert or replace.
		
		//
		// Check if deleting.
		//
		elseif( $theModifiers & kFLAG_PERSIST_DELETE )
		{
			//
			// Set fields array (will receive updated object).
			//
			$mod = array( kOFFSET_REFS_EDGE => $this->offsetGet( kOFFSET_NID ) );
			
			//
			// Remove current edge reference from subject vertex referenced.
			//
			$fields = $mod;
			COntologyNode::ResolveClassContainer( $theConnection, TRUE )
				->ManageObject
				(
					$fields,						// Because it will be overwritten.
					$this->offsetGet( kOFFSET_VERTEX_SUBJECT ),	// Subject identifier.
					kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_PULL		// Remove occurrences.
				);
			
			//
			// Remove current edge reference from object vertex referenced.
			//
			$fields = $mod;
			COntologyNode::ResolveClassContainer( $theConnection, TRUE )
				->ManageObject
				(
					$fields,						// Because it will be overwritten.
					$this->offsetGet( kOFFSET_VERTEX_OBJECT ),	// Object identifier.
					kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_PULL		// Remove occurrences.
				);
		
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

	 

} // class COntologyEdge.


?>
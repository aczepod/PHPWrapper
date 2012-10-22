<?php

/**
 * <i>COntologyTag</i> class definition.
 *
 * This file contains the class definition of <b>COntologyTag</b> which represents the
 * ancestor of ontology tag classes.
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 18/09/2012
 */

/*=======================================================================================
 *																						*
 *									COntologyTag.php									*
 *																						*
 *======================================================================================*/

/**
 * Local definitions.
 *
 * This include file contains common offset definitions.
 */
require_once( "COntologyTag.inc.php" );

/**
 * Edges.
 *
 * This includes the edge class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntologyEdge.php" );

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CTag.php" );

/**
 * <h3>Ontology tag object ancestor</h3>
 *
 * This class extends its ancestor, {@link CTag}, by asserting the type of objects passed to
 * the path, {@link kOFFSET_TAG_PATH}, and by using the native identifiers,
 * {@link kOFFSET_NID}, of the elements of the path in the {@link _index()} method.
 *
 * Odd elements of the path must refer to vertex elements of the graph, in this case
 * {@link COntologyNode} objects; even elements of the path must refer to predicates of the
 * graph, in this case {@link COntologyTerm} objects.
 *
 * The elements of the path offset, {@link kOFFSET_TAG_PATH}, will be the native identifier
 * of the path elements, while the global identifier, {@link kOFFSET_GID}, will receive the
 * global identifiers of the path element related {@link COntologyTerm} instances. This last
 * behaviour means that once a tag is saved, related terms, nodes and edges should not be
 * deleted.
 *
 * The class adds an offset, {@link kOFFSET_UID}, which stores the hashed version of the
 * global identifier and can be used to identify duplicate objects.
 *
 * Elements of the path can be provided as objects and those that are not yet committed will
 * be saved when the current tag is saved.
 *
 * Another action tags perform over nodes is the setting of the node {@link CNode::Kind()}:
 * the first element of the path is a trait node, {@link kKIND_NODE_TRAIT}, the last
 * element of the path is a scale node, {@link kKIND_NODE_SCALE}, and the eventual middle
 * elements are method nodes, {@link kKIND_NODE_METHOD}. Once the tag is committed, the
 * node's kind will be updated accordingly.
 *
 * When adding elements to the tag's path you must consistently follow these rules:
 *
 * <ul>
 *	<li>The first vertex of the path must represent the descriptor or main category of the
 *		tag, it will be qualified as {@link kKIND_NODE_TRAIT}.
 *	<li>The last vertex of the path must represent the data type of the tag and must have
 *		a {@link COntologyNode::Type()}, it will be qualified as {@link kKIND_NODE_SCALE}.
 *	<li>The eventual vertices between the first and the last one should represent variations
 *		or subclasses of the first vertex and will be marked as {@link kKIND_NODE_METHOD}.
 * </ul>
 *
 * Because of this rule, it is not guaranteed that tag paths are in sync with graph paths,
 * the predicate term glue is used as a discriminant to differentiate paths holding the same
 * vertices.
 *
 * The other effect of this is that it is not easy to match the path of a tag with the
 * original path in the graph that was used to constitute the tag, the only thing one can do
 * is ensure tags are constituted from elements following the ontology graph paths.
 *
 * This class prevents updating the full object once it has been inserted for the first
 * time. This behaviour is necessary because tags are referenced by many other objects, so
 * updating a full tag object is risky, since it may have been updated elsewhere: for this
 * reason the {@link Update()} and {@link Replace()} methods will raise an exception.
 *
 * Objects of this class use a sequence number as their native identifier tagged as
 * {@link kSEQUENCE_KEY_TAG} and feature a default container name
 * {@link kCONTAINER_TAG_NAME}.
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 */
class COntologyTag extends CTag
{
		

/*=======================================================================================
 *																						*
 *								PUBLIC MEMBER INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	PushItem																		*
	 *==================================================================================*/

	/**
	 * <h4>Append to path</h4>
	 *
	 * We overload the parent method to assert the provided elements:
	 *
	 * <ul>
	 *	<li>{@link COntologyNode}: Nodes must be provided as odd elements.
	 *	<li>{@link COntologyTerm}: Terms must be provided as even elements.
	 * </ul>
	 *
	 * @param mixed					$theValue			Value to append.
	 *
	 * @access public
	 * @return integer				Number of items in the list.
	 *
	 * @uses _AssertClass()
	 *
	 * @see kOFFSET_TAG_PATH
	 */
	public function PushItem( $theValue )
	{
		//
		// Check value.
		//
		if( $theValue !== NULL )
		{
			//
			// Handle objects.
			//
			if( $theValue instanceof CDocument )
			{
				//
				// Get element count.
				//
				$count = ( $this->offsetExists( kOFFSET_TAG_PATH ) )
					   ? count( $this->offsetGet( kOFFSET_TAG_PATH ) )
					   : 0;
				
				//
				// Check predicates.
				//
				if( $count % 2 )
				{
					//
					// Assert class.
					//
					$ok = $this->_AssertClass( $theValue, 'COntologyTerm' );
					
					//
					// Handle wrong object.
					//
					if( $ok === FALSE )
						throw new Exception
							( "Cannot set path element, expecting a predicate: "
							 ."the object must be a term reference or object",
							  kERROR_PARAMETER );								// !@! ==>
				
				} // Predicate.
				
				//
				// Check nodes.
				//
				else
				{
					//
					// Assert class.
					//
					$ok = $this->_AssertClass( $theValue, 'COntologyNode' );
					
					//
					// Handle wrong object.
					//
					if( $ok === FALSE )
						throw new Exception
							( "Cannot set path element, expecting a vertex: "
							 ."the object must be a node reference or object",
							  kERROR_PARAMETER );								// !@! ==>
				
				} // Vertex.
				
				//
				// Handle correct object.
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
								( "Cannot set path element: "
								 ."the object is missing its native identifier",
								  kERROR_PARAMETER );							// !@! ==>
					
					} // Object is committed.
				
				} // Correct object class.
			
			} // Provided an object.
		
		} // Provided non-null value.
		
		return parent::PushItem( $theValue );										// ==>

	} // PushItem.

	 
	/*===================================================================================
	 *	GetTraitNode																	*
	 *==================================================================================*/

	/**
	 * <h4>Return trait node</h4>
	 *
	 * This method will return the current tag's trait node, if present, or <tt>NULL</tt>.
	 *
	 * The trait node refers the ontology node that represents the type of descriptor the
	 * current tag annotates, by default it is the first vertex of the path.
	 *
	 * @access public
	 * @return mixed				First element of the path, or <tt>NULL</tt>.
	 *
	 * @see kOFFSET_TAG_PATH
	 * @see kKIND_NODE_TRAIT
	 */
	public function GetTraitNode()
	{
		//
		// Check path.
		//
		if( $this->offsetExists( kOFFSET_TAG_PATH ) )
			return $this[ kOFFSET_TAG_PATH ][ 0 ];									// ==>
		
		return NULL;																// ==>

	} // GetTraitNode.

	 
	/*===================================================================================
	 *	GetTraitTerm																	*
	 *==================================================================================*/

	/**
	 * <h4>Return trait term</h4>
	 *
	 * This method will return the current tag's trait term, if present, or <tt>NULL</tt>.
	 *
	 * The trait term refers the ontology term that represents the type of descriptor the
	 * current tag annotates, by default it is the term referred to by the first vertex of
	 * the path.
	 *
	 * @access public
	 * @return mixed				First element of the terms list, or <tt>NULL</tt>.
	 *
	 * @see kOFFSET_VERTEX_TERMS
	 * @see kKIND_NODE_TRAIT
	 */
	public function GetTraitTerm()
	{
		//
		// Check path.
		//
		if( $this->offsetExists( kOFFSET_VERTEX_TERMS ) )
			return $this[ kOFFSET_VERTEX_TERMS ][ 0 ];								// ==>
		
		return NULL;																// ==>

	} // GetTraitTerm.

	 
	/*===================================================================================
	 *	GetScaleNode																	*
	 *==================================================================================*/

	/**
	 * <h4>Return scale node</h4>
	 *
	 * This method will return the current tag's scale node, if present, or <tt>NULL</tt>.
	 *
	 * The scale node refers the ontology node that represents the data type of the item the
	 * current tag annotates, by default it is the last vertex of the path.
	 *
	 * Note that if the tag contains only one vertex, that will be both a trait and a scale.
	 *
	 * @access public
	 * @return mixed				Last element of the path, or <tt>NULL</tt>.
	 *
	 * @see kOFFSET_TAG_PATH
	 * @see kKIND_NODE_SCALE
	 */
	public function GetScaleNode()
	{
		//
		// Check path.
		//
		if( $this->offsetExists( kOFFSET_TAG_PATH ) )
			return $this[ kOFFSET_TAG_PATH ]
						[ count( $this[ kOFFSET_TAG_PATH ] ) - 1 ];					// ==>
		
		return NULL;																// ==>

	} // GetScaleNode.

	 
	/*===================================================================================
	 *	GetScaleTerm																	*
	 *==================================================================================*/

	/**
	 * <h4>Return scale term</h4>
	 *
	 * This method will return the current tag's scale term, if present, or <tt>NULL</tt>.
	 *
	 * The scale term refers the ontology term that represents the data type of the item the
	 * current tag annotates, by default it is the term referred to by last vertex of the
	 * path.
	 *
	 * Note that if the tag contains only one vertex, that will be both a trait and a scale.
	 *
	 * @access public
	 * @return mixed				Last element of the terms list, or <tt>NULL</tt>.
	 *
	 * @see kOFFSET_VERTEX_TERMS
	 * @see kKIND_NODE_SCALE
	 */
	public function GetScaleTerm()
	{
		//
		// Check path.
		//
		if( $this->offsetExists( kOFFSET_VERTEX_TERMS ) )
			return $this[ kOFFSET_VERTEX_TERMS ]
						[count( $this[ kOFFSET_VERTEX_TERMS ] ) - 1 ];				// ==>
		
		return NULL;																// ==>

	} // GetScaleTerm.

	 
	/*===================================================================================
	 *	GetMethodNodes																	*
	 *==================================================================================*/

	/**
	 * <h4>Return method nodes</h4>
	 *
	 * This method will return the current tag's list of method nodes, if present, or
	 * <tt>NULL</tt>.
	 *
	 * The method node refers the ontology node that represents a subclass or variation of
	 * the tag trait, it can be considered a pipeline of modifiers applied to the trait
	 * vertex. This kind of elements cannot be neither the first nor the last element of the
	 * path and can be found between the trait node, {@link GetTraitNode()}, an the scale
	 * node, {@link GetScaleNode()}.
	 *
	 * The method will return an array if at least one method is present.
	 *
	 * @access public
	 * @return mixed				List of method nodes, or <tt>NULL</tt>.
	 *
	 * @see kOFFSET_TAG_PATH
	 * @see kKIND_NODE_METHOD
	 */
	public function GetMethodNodes()
	{
		//
		// Check path.
		//
		if( $this->offsetExists( kOFFSET_TAG_PATH ) )
		{
			//
			// Check for methods.
			//
			if( ($count = count( $path = $this->offsetGet( kOFFSET_TAG_PATH ) )) > 3 )
			{
				//
				// Init local storage.
				//
				$list = Array();
				
				//
				// Load methods.
				//
				for( $i = 2; $i < ($count - 1); $i += 2 )
					$list[] = $path[ $i ];
				
				return $list;														// ==>
			
			} // Has methods.
		
		} // Has at least one element.
		
		return NULL;																// ==>

	} // GetMethodNodes.

	 
	/*===================================================================================
	 *	GetMethodTerms																	*
	 *==================================================================================*/

	/**
	 * <h4>Return method terms</h4>
	 *
	 * This method will return the current tag's list of method terms, if present, or
	 * <tt>NULL</tt>.
	 *
	 * The scale term refers the ontology term that represents the data type of the item the
	 * current tag annotates, by default it is the term referred to by last vertex of the
	 * path.
	 *
	 * The method term refers the ontology term that represents a subclass or variation of
	 * the tag trait, it can be considered a pipeline of modifiers applied to the trait
	 * vertex. This kind of elements cannot be neither the first nor the last element of the
	 * path and can be found between the trait term, {@link GetTraitTerm()}, an the scale
	 * term, {@link GetScaleTerm()}.
	 *
	 * The method will return an array if at least one method is present.
	 *
	 * @access public
	 * @return mixed				List of method nodes, or <tt>NULL</tt>.
	 *
	 * @see kOFFSET_VERTEX_TERMS
	 * @see kKIND_NODE_METHOD
	 */
	public function GetMethodTerms()
	{
		//
		// Check path.
		//
		if( $this->offsetExists( kOFFSET_VERTEX_TERMS ) )
		{
			//
			// Check for methods.
			//
			if( ($count = count( $path = $this->offsetGet( kOFFSET_VERTEX_TERMS ) )) > 2 )
			{
				//
				// Init local storage.
				//
				$list = Array();
				
				//
				// Load methods.
				//
				for( $i = 1; $i < ($count - 1); $i++ )
					$list[] = $path[ $i ];
				
				return $list;														// ==>
			
			} // Has methods.
		
		} // Has at least one element.
		
		return NULL;																// ==>

	} // GetMethodTerms.

		

/*=======================================================================================
 *																						*
 *								PUBLIC PERSISTENCE INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Update																			*
	 *==================================================================================*/

	/**
	 * <h4>Update the object in a container</h4>
	 *
	 * We overload this method to raise an exception: objects of this class can only be
	 * inserted, after this one can only modify their attributes using the modification
	 * interface provided by container objects.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 *
	 * @access public
	 *
	 * @throws Exception
	 */
	public function Update( CConnection $theConnection )
	{
		//
		// Check if necessary.
		//
		if( $this->_IsDirty()
		 || (! $this->_IsCommitted()) )
		{
			//
			// Object is locked.
			//
			throw new Exception
				( "This object can only be inserted and modified",
				  kERROR_LOCKED );												// !@! ==>
		
		} // Dirty or not yet committed.
	
	} // Update.

	 
	/*===================================================================================
	 *	Replace																			*
	 *==================================================================================*/

	/**
	 * <h4>Replace the object into a container</h4>
	 *
	 * We overload this method to raise an exception: objects of this class can only be
	 * inserted, after this one can only modify their attributes using the modification
	 * interface provided by container objects.
	 *
	 * In this class we prevent replacing a committed object and allow inserting a non
	 * committed object.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 *
	 * @access public
	 * @return mixed				The object's native identifier.
	 */
	public function Replace( CConnection $theConnection )
	{
		//
		// Check if necessary.
		//
		if( $this->_IsDirty()
		 || (! $this->_IsCommitted()) )
		{
			//
			// Check if the object is not committed.
			//
			if( ! $this->_IsCommitted() )
				return parent::Replace( $theConnection );							// ==>
			
			//
			// Object is locked.
			//
			throw new Exception
				( "This object can only be inserted and modified",
				  kERROR_LOCKED );												// !@! ==>
		
		} // Dirty or not yet committed.
		
		return NULL;																// ==>
	
	} // Replace.
		


/*=======================================================================================
 *																						*
 *								STATIC CONTAINER INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	DefaultContainer																*
	 *==================================================================================*/

	/**
	 * <h4>Return the tags container</h4>
	 *
	 * The container will be created or fetched from the provided database using the
	 * {@link kCONTAINER_TAG_NAME} name.
	 *
	 * @param CDatabase				$theDatabase		Database object.
	 *
	 * @static
	 * @return CContainer			The tags container.
	 *
	 * @see kCONTAINER_TAG_NAME
	 */
	static function DefaultContainer( CDatabase $theDatabase )
	{
		return $theDatabase->Container( kCONTAINER_TAG_NAME );						// ==>
	
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
	 * <h4>Resolve a tag</h4>
	 *
	 * This method can be used to retrieve an existing tag by identifier, or retrieve all
	 * tags matching a term.
	 *
	 * The method accepts the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theConnection</tt>: This parameter represents the connection from which the
	 *		tags container must be resolved. If this parameter cannot be correctly
	 *		determined, the method will raise an exception.
	 *	<li><tt>$theIdentifier</tt>: This parameter represents either the tag identifier
	 *		or the term reference, depending on its type:
	 *	 <ul>
	 *		<li><tt>integer</tt>: In this case the method assumes that the parameter
	 *			represents the tag identifier: it will attempt to retrieve the tag, if it
	 *			is not found, the method will return <tt>NULL</tt>.
	 *		<li><tt>{@link COntologyTerm}</tt>: In this case the method locate all tags
	 *			that refer to the provided term. If the term is not {@link _IsCommitted()},
	 *			the method will return <tt>NULL</tt>.
	 *		<li><i>other</i>: Any other type will be interpreted either the term's native
	 *			identifier, or as the term's global identifier: the method will return all
	 *			tags that refer to that term.
	 *	 </ul>
	 *	<li><tt>$doThrow</tt>: If <tt>TRUE</tt>, any failure to resolve the tag will raise
	 *		an exception.
	 * </ul>
	 *
	 * The method will return the found tag(s), <tt>NULL</tt> if not found, or raise an
	 * exception if the last parameter is <tt>TRUE</tt>.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param mixed					$theIdentifier		Node identifier or term reference.
	 * @param boolean				$doThrow			If <tt>TRUE</tt> raise an exception.
	 * @param boolean				$doTerm				If <tt>TRUE</tt> revert to term ref.
	 *
	 * @static
	 * @return COntologyTerm		Found tag or <tt>NULL</tt>.
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
			$container = COntologyTag::ResolveClassContainer( $theConnection, TRUE );
			
			//
			// Handle tag identifier.
			//
			if( is_integer( $theIdentifier ) )
			{
				//
				// Get node.
				//
				$tag = COntologyTag::NewObject( $theConnection, $theIdentifier );
				
				//
				// Handle missing tag.
				//
				if( ($tag === NULL)
				 && $doThrow )
					throw new Exception
						( "Tag not found",
						  kERROR_NOT_FOUND );									// !@! ==>
				
				return $tag;														// ==>
			
			} // Provided tag identifier.
						
			//
			// Handle term object.
			//
			if( $theIdentifier instanceof COntologyTerm )
			{
				//
				// Handle new term.
				//
				if( ! $theIdentifier->_IsCommitted() )
				{
					//
					// Raise exception.
					//
					if( $doThrow )
						throw new Exception
							( "Tag not found: term is not committed",
							  kERROR_NOT_FOUND );								// !@! ==>
					
					return NULL;													// ==>
				
				} // New term.
				
				//
				// Get term identifier.
				//
				$theIdentifier = $theIdentifier->offsetGet( kOFFSET_NID );
			
			} // Provided term object.
			
			//
			// Handle term reference.
			//
			else
			{
				//
				// Resolve term.
				//
				$term = COntologyTerm::Resolve( $theConnection, $theIdentifier, $doThrow );
				if( $term instanceof COntologyTerm )
					$theIdentifier = $term->offsetGet( kOFFSET_NID );
				else
				{
					//
					// Raise exception.
					//
					if( $doThrow )
						throw new Exception
							( "Tag not found: unresolved term reference [$theIdentifier]",
							  kERROR_NOT_FOUND );								// !@! ==>
					
					return NULL;													// ==>
				
				} // Unresolved term.
			
			} // Provided term reference.
			
			//
			// Make query.
			//
			$query = $container->NewQuery();
			$query->AppendStatement(
				CQueryStatement::Member(
					kOFFSET_VERTEX_TERMS, $theIdentifier, kTYPE_BINARY ) );
			$rs = $container->Query( $query );
			
			//
			// Handle found tags.
			//
			if( $rs->count() )
			{
				//
				// Return list of tags.
				//
				$list = Array();
				foreach( $rs as $document )
					$list[] = CPersistentObject::DocumentObject( $document );
				
				return $list;														// ==>
			
			} // Found at least one tag.

			//
			// Raise exception.
			//
			if( $doThrow )
				throw new Exception
					( "Tag not found",
					  kERROR_NOT_FOUND );										// !@! ==>
			
			return NULL;															// ==>
			
		} // Provided local or global identifier.
		
		throw new Exception
			( "Missing tag identifier or term",
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
	 * global identifier is the concatenation of all the referenced terms of the tag path,
	 * this method will take care of instantiating the necessary objects and building the
	 * global identifier.
	 *
	 * This method is called by the {@link _PrecommitIdentify()} and expects all elements of
	 * the path to be object native identifiers, so the method will resolve each element
	 * without checking if it is in the form of an object.
	 *
	 * This method is also responsible for loading the {@link kOFFSET_VERTEX_TERMS} offset:
	 * it will contain all the term native identifiers referred to by the tag's path vertex
	 * elements.
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
	 * @see kOFFSET_VERTEX_TERMS
	 * @see kOFFSET_TAG_PATH kTOKEN_INDEX_SEPARATOR
	 */
	protected function _index( CConnection $theConnection, $theModifiers )
	{
		//
		// Init local storage.
		//
		$identifier = $terms = Array();
		$path = $this->offsetGet( kOFFSET_TAG_PATH );
		
		//
		// Iterate path elements.
		//
		for( $i = 0; $i < count( $path ); $i++ )
		{
			//
			// Set identifier.
			//
			$id = $path[ $i ];
			
			//
			// Handle nodes.
			//
			if( ! ($i % 2) )
			{
				//
				// Load node.
				//
				$node = COntologyNode::NewObject(
						COntologyNode::ResolveClassContainer(
							$theConnection, TRUE ), $id );
				if( $node === NULL )
					throw new Exception
						( "Unable to commit tag: "
						 ."a path node cannot be found",
						  kERROR_STATE );										// !@! ==>
				
				//
				// Load term identifier.
				//
				$id = $node->Term();
			
			} // Node.
			
			//
			// Handle terms.
			//
			$term = COntologyTerm::NewObject(
						COntologyTerm::ResolveClassContainer(
							$theConnection, TRUE ), $id );
			
			//
			// Add term reference.
			//
			if( ! ($i % 2) )
				$terms[] = $term[ kOFFSET_NID ];
			
			//
			// Add identifier.
			//
			$identifier[] = $term[ kOFFSET_GID ];
		
		} // Iterating path elements.
		
		//
		// Set terms list offset.
		//
		if( count( $terms ) )
			$this->offsetSet( kOFFSET_VERTEX_TERMS, $terms );
		
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
	 *
	 * @see kOFFSET_TAG_PATH
	 */
	protected function _Preset( &$theOffset, &$theValue )
	{
		//
		// Lock path.
		//
		if( ($theOffset == kOFFSET_TAG_PATH)
		 && $this->_IsCommitted() )
			throw new Exception
				( "You cannot modify the [$theOffset] offset: "
				 ."the object is committed",
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
	 * @see kOFFSET_TAG_PATH
	 */
	protected function _Preunset( &$theOffset )
	{
		//
		// Lock path.
		//
		if( ($theOffset == kOFFSET_TAG_PATH)
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
	 * In this class we commit the eventual nodes and terms provided as an uncommitted
	 * objects and replace them with their native identifier.
	 *
	 * The method will also assert that the last node element of the path has a
	 * {@link CNode::Type()}, if that is not the case, the method will raise an exception.
	 *
	 * @param reference			   &$theConnection		Server, database or container.
	 * @param reference			   &$theModifiers		Commit options.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 *
	 * @uses _IsCommitted()
	 *
	 * @see kOFFSET_TAG_PATH
	 * @see kFLAG_PERSIST_INSERT kFLAG_PERSIST_REPLACE
	 */
	protected function _PrecommitRelated( &$theConnection, &$theModifiers )
	{
		//
		// Call parent method.
		//
		parent::_PrecommitRelated( $theConnection, $theModifiers );
		
		//
		// Handle new object.
		//
		if( ( (($theModifiers & kFLAG_PERSIST_MASK) == kFLAG_PERSIST_INSERT)
		   || (($theModifiers & kFLAG_PERSIST_MASK) == kFLAG_PERSIST_REPLACE) )
		 && (! $this->_IsCommitted()) )
		{
			//
			// Iterate path elements.
			//
			$path = $this->offsetGet( kOFFSET_TAG_PATH );
			for( $i = 0; $i < count( $path ); $i++ )
			{
				//
				// Handle object.
				//
				$item = $path[ $i ];
				if( $item instanceof CPersistentObject )
				{
					//
					// Commit term.
					//
					if( $i % 2 )
						$item->Insert(
							COntologyTerm::ResolveClassContainer(
								$theConnection, TRUE ) );
					
					//
					// Commit node.
					//
					else
					{
						//
						// Check if scale node has type.
						//
						if( ($i == (count( $path ) - 1))
						 && (! $item->offsetExists( kOFFSET_TYPE )) )
							throw new Exception
								( "Cannot commit tag: "
								 ."the scale node is missing its type.",
								  kERROR_STATE );								// !@! ==>
							
						//
						// Insert node.
						//
						$item->Insert(
							COntologyNode::ResolveClassContainer(
								$theConnection, TRUE ) );
					
					} // New node object.
					
					//
					// Replace object.
					//
					$path[ $i ] = $item->offsetGet( kOFFSET_NID );
				
				} // Item is object.
			
			} // Iterating path elements.
			
			//
			// Replace path.
			//
			$this->offsetSet( kOFFSET_TAG_PATH, $path );
		
		} // Insert or replace and not committed.
	
	} // _PrecommitRelated.

	 
	/*===================================================================================
	 *	_PrecommitIdentify																*
	 *==================================================================================*/

	/**
	 * <h4>Determine the identifiers before committing</h4>
	 *
	 * This method will use the result of the {@link _index()} method to set the global
	 * identifier, {@link kOFFSET_GID}; the same value will be hashed and constitute the
	 * unique identifier, {@link kOFFSET_UID}, while the native identifier,
	 * {@link kOFFSET_NID}, will be set by the sequence number {@link kSEQUENCE_KEY_TAG}.
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
	 * @uses _IsCommitted()
	 * @uses _index()
	 *
	 * @see kSEQUENCE_KEY_TAG
	 * @see kOFFSET_NID kOFFSET_GID kOFFSET_UID
	 * @see kFLAG_PERSIST_INSERT kFLAG_PERSIST_REPLACE
	 */
	protected function _PrecommitIdentify( &$theConnection, &$theModifiers )
	{
		//
		// Handle new object.
		//
		if( ( (($theModifiers & kFLAG_PERSIST_MASK) == kFLAG_PERSIST_INSERT)
		   || (($theModifiers & kFLAG_PERSIST_MASK) == kFLAG_PERSIST_REPLACE) )
		 && (! $this->_IsCommitted()) )
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
					$uid = $container->ConvertValue( kTYPE_BINARY, md5( $index, TRUE ) );
					
					//
					// Check unique identifier.
					//
					if( $container->CheckObject( $uid, kOFFSET_UID ) )
						throw new Exception
							( "Duplicate object",
							  kERROR_COMMIT );									// !@! ==>
					
					//
					// Set unique identifier.
					//
					$this->offsetSet( kOFFSET_UID, $uid );
				
				} // Supports global identifier.
			
			} // Missing global identifier.
		
			//
			// Set native identifier.
			//
			if( ! $this->offsetExists( kOFFSET_NID ) )
				$this->offsetSet(
					kOFFSET_NID,
					static::ResolveContainer(
						$theConnection, TRUE )
							->NextSequence( kSEQUENCE_KEY_TAG, TRUE ) );
		
		} // Insert or replace and not committed.
	
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
	 * The current tag will update related vertex object, {@link COntologyNode} instances
	 * and their relative {@link COntologyTerm} instances, both with the
	 * {@link kOFFSET_REFS_TAG} offset.
	 *
	 * When inserting a new tag, we add the tag reference, when deleting the tag we remove
	 * it.
	 *
	 * The method will also set the node {@link CNode::Kind()}s to {@link kKIND_NODE_TRAIT}
	 * for the first element of the path, to {@link kKIND_NODE_SCALE} for the last element
	 * and to {@link kKIND_NODE_METHOD} for the eventual in-between node elements.
	 *
	 * We only handle vertex elements, we do not refer predicate terms.
	 *
	 * @param reference			   &$theConnection		Server, database or container.
	 * @param reference			   &$theModifiers		Commit options.
	 *
	 * @access protected
	 *
	 * @uses _IsCommitted()
	 *
	 * @see kOFFSET_REFS_TAG
	 * @see kFLAG_PERSIST_INSERT kFLAG_PERSIST_REPLACE kFLAG_PERSIST_DELETE
	 * @see kFLAG_PERSIST_MODIFY kFLAG_MODIFY_ADDSET kFLAG_MODIFY_PULL
	 * @see kKIND_NODE_TRAIT kKIND_NODE_METHOD kKIND_NODE_SCALE
	 */
	protected function _PostcommitRelated( &$theConnection, &$theModifiers )
	{
		//
		// Call parent method.
		//
		parent::_PostcommitRelated( $theConnection, $theModifiers );
	
		//
		// Handle new object.
		//
		if( ( ( (($theModifiers & kFLAG_PERSIST_MASK) == kFLAG_PERSIST_INSERT)
			 || (($theModifiers & kFLAG_PERSIST_MASK) == kFLAG_PERSIST_REPLACE) )
		   && (! $this->_IsCommitted()) )
		 || ($theModifiers & kFLAG_PERSIST_DELETE) )
		{
			//
			// Set modification criteria.
			//
			$mod = array( kOFFSET_REFS_TAG => $this->offsetGet( kOFFSET_NID ) );
			
			//
			// Iterate path elements.
			//
			$path = $this->offsetGet( kOFFSET_TAG_PATH );
			for( $i = 0; $i < count( $path ); $i += 2 )
			{
				//
				// Set operation.
				//
				$operation = ! ($theModifiers & kFLAG_PERSIST_DELETE);
				
				//
				// Load node.
				//
				$node = COntologyNode::NewObject(
						COntologyNode::ResolveClassContainer(
							$theConnection, TRUE ), $path[ $i ] );
				
				//
				// Set node trait kind.
				//
				if( $i == 0 )
					$this->_SetTraitNode( $theConnection, $path[ $i ] );
				
				//
				// Set node nethod kind.
				//
				if( $i								// Not first
				 && ($i < (count( $path ) - 1)) )	// and not last.
					$this->_SetMethodNode( $theConnection, $path[ $i ] );
				
				//
				// Set node scale kind.
				//
				if( $i == (count( $path ) - 1) )
					$this->_SetScaleNode( $theConnection, $path[ $i ] );
				
				//
				// Reference in node.
				//
				$this->_ReferenceInNode( $theConnection, $path[ $i ], $operation );
				
				//
				// Reference in term.
				//
				$this->_ReferenceInTerm( $theConnection, $node->Term(), $operation );
			
			} // Iterating path elements.
		
		} // Insert or replace and not committed, or deleting.
		
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
	 * <h4>Add tag reference to node</h4>
	 *
	 * This method can be used to add or remove the current tag's reference,
	 * {@link kOFFSET_REFS_TAG}, from the provided node. This method should be used whenever
	 * committing a new tag or when deleting one: it will add the current tag's native
	 * identifier to the set of tag references of the provided node when committing a new
	 * tag; it will remove it when deleting the tag.
	 *
	 * The last parameter is a boolean: if <tt>TRUE</tt> the method will add to the set; if
	 * <tt>FALSE</tt>, it will remove from the set.
	 *
	 * The method will return <tt>TRUE</tt> if the operation affected at least one object,
	 * <tt>FALSE</tt> if not and raise an exception if the operation failed.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param mixed					$theNode			Node object or identifier.
	 * @param boolean				$doAdd				<tt>TRUE</tt> add reference.
	 *
	 * @access protected
	 * @return boolean				<tt>TRUE</tt> operation affected at least one object.
	 *
	 * @see kOFFSET_NID kOFFSET_REFS_TAG
	 * @see kFLAG_PERSIST_MODIFY kFLAG_MODIFY_ADDSET kFLAG_MODIFY_PULL
	 */
	protected function _ReferenceInNode( CConnection $theConnection, $theNode, $doAdd )
	{
		//
		// Set modification criteria.
		//
		$criteria = array( kOFFSET_REFS_TAG => $this->offsetGet( kOFFSET_NID ) );
		
		//
		// Handle add to set.
		//
		if( $doAdd )
			return COntologyNode::ResolveClassContainer( $theConnection, TRUE )
					->ManageObject
						(
							$criteria,
							$theNode,
							kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_ADDSET
						);														// ==>
		
		return COntologyNode::ResolveClassContainer( $theConnection, TRUE )
				->ManageObject
					(
						$criteria,
						$theNode,
						kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_PULL
					);															// ==>
	
	} // _ReferenceInNode.

	 
	/*===================================================================================
	 *	_ReferenceInTerm																*
	 *==================================================================================*/

	/**
	 * <h4>Add tag reference to term</h4>
	 *
	 * This method can be used to add or remove the current tag's reference,
	 * {@link kOFFSET_REFS_TAG}, from the provided term. This method should be used whenever
	 * committing a new tag or when deleting one: it will add the current tag's native
	 * identifier to the set of tag references of the provided term when committing a new
	 * tag; it will remove it when deleting the tag.
	 *
	 * The last parameter is a boolean: if <tt>TRUE</tt> the method will add to the set; if
	 * <tt>FALSE</tt>, it will remove from the set.
	 *
	 * The method will return <tt>TRUE</tt> if the operation affected at least one object,
	 * <tt>FALSE</tt> if not and raise an exception if the operation failed.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param mixed					$theTerm			Term object or identifier.
	 * @param boolean				$doAdd				<tt>TRUE</tt> add reference.
	 *
	 * @access protected
	 * @return boolean				<tt>TRUE</tt> operation affected at least one object.
	 *
	 * @see kOFFSET_NID kOFFSET_REFS_TAG
	 * @see kFLAG_PERSIST_MODIFY kFLAG_MODIFY_ADDSET kFLAG_MODIFY_PULL
	 */
	protected function _ReferenceInTerm( CConnection $theConnection, $theTerm, $doAdd )
	{
		//
		// Set modification criteria.
		//
		$criteria = array( kOFFSET_REFS_TAG => $this->offsetGet( kOFFSET_NID ) );
		
		//
		// Handle add to set.
		//
		if( $doAdd )
			return COntologyTerm::ResolveClassContainer( $theConnection, TRUE )
					->ManageObject
						(
							$criteria,
							$theTerm,
							kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_ADDSET
						);														// ==>
		
		return COntologyTerm::ResolveClassContainer( $theConnection, TRUE )
				->ManageObject
					(
						$criteria,
						$theTerm,
						kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_PULL
					);															// ==>
	
	} // _ReferenceInTerm.

		

/*=======================================================================================
 *																						*
 *							PROTECTED NODE QUALIFICATION INTERFACE						*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_SetTraitNode																	*
	 *==================================================================================*/

	/**
	 * <h4>Set node's kind to trait</h4>
	 *
	 * This method will set the provided node's kind to {@link kKIND_NODE_TRAIT}.
	 *
	 * The method will return <tt>TRUE</tt> if the operation affected at least one object,
	 * <tt>FALSE</tt> if not and raise an exception if the operation failed.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param mixed					$theNode			Node object or identifier.
	 *
	 * @access protected
	 * @return boolean				<tt>TRUE</tt> operation affected at least one object.
	 *
	 * @see kOFFSET_KIND kKIND_NODE_TRAIT
	 * @see kFLAG_PERSIST_MODIFY kFLAG_MODIFY_ADDSET
	 */
	protected function _SetTraitNode( CConnection $theConnection, $theNode )
	{
		//
		// Set modification criteria.
		//
		$criteria = array( kOFFSET_KIND => kKIND_NODE_TRAIT );
		
		//
		// Add to kind set.
		//
		return COntologyNode::ResolveClassContainer( $theConnection, TRUE )
				->ManageObject
					(
						$criteria,
						$theNode,
						kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_ADDSET
					);																// ==>
	
	} // _SetTraitNode.

	 
	/*===================================================================================
	 *	_SetMethodNode																	*
	 *==================================================================================*/

	/**
	 * <h4>Set node's kind to method</h4>
	 *
	 * This method will set the provided node's kind to {@link kKIND_NODE_METHOD}.
	 *
	 * The method will return <tt>TRUE</tt> if the operation affected at least one object,
	 * <tt>FALSE</tt> if not and raise an exception if the operation failed.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param mixed					$theNode			Node object or identifier.
	 *
	 * @access protected
	 * @return boolean				<tt>TRUE</tt> operation affected at least one object.
	 *
	 * @see kOFFSET_KIND kKIND_NODE_METHOD
	 * @see kFLAG_PERSIST_MODIFY kFLAG_MODIFY_ADDSET
	 */
	protected function _SetMethodNode( CConnection $theConnection, $theNode )
	{
		//
		// Set modification criteria.
		//
		$criteria = array( kOFFSET_KIND => kKIND_NODE_METHOD );
		
		//
		// Add to kind set.
		//
		return COntologyNode::ResolveClassContainer( $theConnection, TRUE )
				->ManageObject
					(
						$criteria,
						$theNode,
						kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_ADDSET
					);																// ==>
	
	} // _SetMethodNode.

	 
	/*===================================================================================
	 *	_SetScaleNode																	*
	 *==================================================================================*/

	/**
	 * <h4>Set node's kind to scale</h4>
	 *
	 * This method will set the provided node's kind to {@link kKIND_NODE_SCALE}.
	 *
	 * The method will return <tt>TRUE</tt> if the operation affected at least one object,
	 * <tt>FALSE</tt> if not and raise an exception if the operation failed.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param mixed					$theNode			Node object or identifier.
	 *
	 * @access protected
	 * @return boolean				<tt>TRUE</tt> operation affected at least one object.
	 *
	 * @see kOFFSET_KIND kKIND_NODE_SCALE
	 * @see kFLAG_PERSIST_MODIFY kFLAG_MODIFY_ADDSET
	 */
	protected function _SetScaleNode( CConnection $theConnection, $theNode )
	{
		//
		// Set modification criteria.
		//
		$criteria = array( kOFFSET_KIND => kKIND_NODE_SCALE );
		
		//
		// Add to kind set.
		//
		return COntologyNode::ResolveClassContainer( $theConnection, TRUE )
				->ManageObject
					(
						$criteria,
						$theNode,
						kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_ADDSET
					);																// ==>
	
	} // _SetScaleNode.

	 

} // class COntologyTag.


?>

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
 * <h4>Ontology tag object ancestor</h4>
 *
 * This class extends its ancestor, {@link CTag}, by asserting the type of objects passed to
 * the path, {@link kTAG_PATH}, and by using term references as the elements of the
 * object's path and global identifier.
 *
 * <ul>
 *	<li><i>Path</i>: As in the parent class, this attribute collects graph vertices and the
 *		predicates that connect them. The odd elements are expected to be vertex nodes of
 *		graph and the even elements the predicate terms that connect them. In this class
 *		the vertices are represented by the {@link kTAG_TERM} reference of the vertex
 *		{@link COntologyNode} instances, while the predicates are represented by the
 *		{@link COntologyTerm} {@link kTAG_NID} of the predicate terms.
 *	<li><i>Global identifier</i>: The global identifier, {@link GID()}, in this class is
 *		represented by the concatenation of the {@link kTAG_GID} attributes of all the
 *		{@link COntologyTerm} instance references of the object's path,
 *		{@link kTAG_PATH}, separated by the {@link kTOKEN_INDEX_SEPARATOR} token.
 *	<li><i>Unique identifier</i>: The unique identifier, {@link kTAG_UID}, in this class is
 *		represented by the hash of the global identifier.
 * </ul>
 *
 * Elements of the path can be provided as committed objects, they must have their
 * {@link kTAG_NID} set. {@link COntologyNode} instances or references can only be
 * provided as odd elements, while {@link COntologyTerm} instances or references can be
 * provided as both odd or even elements. Note that nodes will always be resolved into the
 * terms they refer to, so <i>there there is no direct relationship between nodes and
 * tags</i>.
 *
 * This particular behaviour allows for different graph paths to share the same tag, which
 * allows duplicating ontologies for use as templates, or preventing duplicate data types
 * from being tagged differently. It also allows the same vertex elements to be treated
 * differently if their predicates differ.
 *
 * Objects of this class will almost always be created by providing a sequence of node
 * vertices and predicate terms, the {@link PushItem()} method will follow these rules: the
 * first element of the path is the feature vertex, if provided as an {@link COntologyNode}
 * instance, it must have its {@link COntologyNode::Kind()} set to {@link kKIND_FEATURE};
 * the last element of the path is the scale vertex, if provided as an {@link COntologyNode}
 * instance, it must have its {@link COntologyNode::Kind()} set to {@link kKIND_SCALE}.
 *
 * Whenever a tag is committed, the referenced terms will receive the tag
 * {@link kTAG_NID} in an attribute, depending on their position in the path: the first
 * path term will receive the tag reference in the {@link kTAG_FEATURES} attribute,
 * the terms which are neither the first nor the last in the path receive the reference in
 * {@link kTAG_METHODS} and the last term in {@link kTAG_SCALES}.
 *
 * This class prevents updating the full object once it has been inserted for the first
 * time. This behaviour is necessary because tags are referenced by many other objects, so
 * updating a full tag object is risky, since it may have been updated elsewhere: for this
 * reason the {@link Update()} and {@link Replace()} methods will raise an exception.
 *
 * Objects of this class use a sequence number as their native identifier,
 * {@link kTAG_NID}, tagged as {@link kSEQUENCE_KEY_TAG}.
 *
 * The class implements the static method, {@link DefaultContainer()}, which, given a
 * database, will return the default tag container; it will use the
 * {@link kCONTAINER_TAG_NAME} constant as the container name.
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
	 * We overload the parent method to implement the following rules:
	 *
	 * <ul>
	 *	<li>All elements of the path must be {@link COntologyTerm} instance references.
	 *	<li>Odd elements of the path are graph vertices and can be provided as
	 *		{@link COntologyNode} instances:
	 *	 <ul>
	 *		<li>{@link COntologyNode} instances will be converted into their
	 *			{@link kTAG_TERM} property.
	 *		<li><tt>Integer</tt> values will <i>not</i> be interpreted as node references,
	 *			since there is no way to resolve them.
	 *		<li>If the first element of the path is an {@link COntologyNode} instance, the
	 *			latter must have its {@link kTAG_KIND} attribute set to
	 *			{@link kKIND_FEATURE}.
	 *		<li>If the last element of the path is an {@link COntologyNode} instance, the
	 *			latter must have its {@link kTAG_KIND} attribute set to
	 *			{@link kKIND_SCALE}.
	 *	 </ul>
	 *	<li>{link COntologyTerm} instances will be accepted in any position.
	 *	<li>{link COntologyTerm} instances must have their {@link kTAG_NID} attribute.
	 *	<li>Any other data type will be interpreted as the term's {@link kTAG_NID} and
	 *		no verification will be performed.
	 * </ul>
	 *
	 * @param mixed					$theValue			Value to append.
	 *
	 * @access public
	 * @return integer				Number of items in the list.
	 *
	 * @uses _AssertClass()
	 *
	 * @see kTAG_PATH
	 */
	public function PushItem( $theValue )
	{
		//
		// Check value.
		//
		if( $theValue !== NULL )
		{
			//
			// Handle term object.
			//
			if( $theValue instanceof COntologyTerm )
			{
				//
				// Check if committed.
				//
				if( $theValue->_IsCommitted() )
				{
					//
					// Check native identifier.
					//
					if( $theValue->offsetExists( kTAG_NID ) )
						return parent::PushItem(
							$theValue->offsetGet( kTAG_NID ) );						// ==>
					
					throw new Exception
						( "Cannot set path element: "
						 ."the term is missing its native identifier",
						  kERROR_PARAMETER );									// !@! ==>
				
				} // Object is committed.
				
				throw new Exception
					( "Cannot set path element: "
					 ."the term object is not committed",
					  kERROR_PARAMETER );										// !@! ==>
			
			} // Provided term object.
			
			//
			// Get element count.
			//
			$count = ( $this->offsetExists( kTAG_PATH ) )
				   ? count( $this->offsetGet( kTAG_PATH ) )
				   : 0;
			
			//
			// Handle node.
			//
			if( $theValue instanceof COntologyNode )
			{
				//
				// Check if committed.
				//
				if( $theValue->_IsCommitted() )
				{
					//
					// Check vertex.
					//
					if( ! ($count % 2) )
					{
						//
						// Check term
						//
						if( $theValue->offsetExists( kTAG_TERM ) )
						{
							//
							// Check first.
							//
							if( ! $count )
							{
								//
								// Check feature.
								//
								if( $theValue->Kind( kKIND_FEATURE ) !== NULL )
									return parent::PushItem(
										$theValue->offsetGet( kTAG_TERM ) );		// ==>
								
								throw new Exception
									( "Cannot set path element, "
									 ."the the provided vertex is not a feature",
									  kERROR_PARAMETER );						// !@! ==>
							
							} // Feature node.
						
							//
							// Check last.
							//
							if( $count == (count( $this->offsetGet( kTAG_PATH ) ) - 1) )
							{
								//
								// Check scale.
								//
								if( $theValue->Kind( kKIND_SCALE ) !== NULL )
									return parent::PushItem(
										$theValue->offsetGet( kTAG_TERM ) );		// ==>
								
								throw new Exception
									( "Cannot set path element, "
									 ."the the provided vertex is not a scale",
									  kERROR_PARAMETER );						// !@! ==>
							
							} // Scale node.
							
							return parent::PushItem(
								$theValue->offsetGet( kTAG_TERM ) );				// ==>
						
						} // Has term reference.
						
						throw new Exception
							( "Cannot set path element, "
							 ."the node is missing its term reference",
							  kERROR_PARAMETER );								// !@! ==>
					
					} // Expecting a vertex.
					
					throw new Exception
						( "Cannot set path element, expecting a predicate: "
						 ."the object must be a term reference or object",
						  kERROR_PARAMETER );									// !@! ==>
				
				} // Object is committed.
				
				throw new Exception
					( "Cannot set path element: "
					 ."the node object is not committed",
					  kERROR_PARAMETER );										// !@! ==>
			
			} // Provided vertex object.
			
			else
				throw new Exception
					( "Cannot set path element: "
					 ."expecting a term or node object or a term reference",
					  kERROR_PARAMETER );										// !@! ==>
		
		} // Provided non-null value.
		
		return parent::PushItem( $theValue );										// ==>

	} // PushItem.

	 
	/*===================================================================================
	 *	GetFeatureVertex																*
	 *==================================================================================*/

	/**
	 * <h4>Return trait term</h4>
	 *
	 * This method will return the current tag's feature term, if present, or <tt>NULL</tt>.
	 *
	 * The feature vertex is the first element of the path, it refers the ontology term that
	 * represents the feature or trait the current object is tagging.
	 *
	 * @access public
	 * @return mixed				First element of the terms list, or <tt>NULL</tt>.
	 *
	 * @see kTAG_PATH
	 */
	public function GetFeatureVertex()
	{
		//
		// Check path.
		//
		if( $this->offsetExists( kTAG_PATH ) )
			return $this[ kTAG_PATH ][ 0 ];										// ==>
		
		return NULL;																// ==>

	} // GetFeatureVertex.

	 
	/*===================================================================================
	 *	GetMethodVertex																	*
	 *==================================================================================*/

	/**
	 * <h4>Return method terms</h4>
	 *
	 * This method will return the current tag's list of method terms, if present, or
	 * <tt>NULL</tt>.
	 *
	 * The method vertex is the any odd element of the path that is neither the first nor
	 * the last, it represents the pipeline of modifiers applied to the feature vertex.
	 *
	 * The method will return an array if at least one method is present.
	 *
	 * Note that there must be at least 5 elements in the path to have one method.
	 *
	 * @access public
	 * @return mixed				List of method nodes, or <tt>NULL</tt>.
	 *
	 * @see kTAG_PATH
	 */
	public function GetMethodVertex()
	{
		//
		// Check path.
		//
		if( $this->offsetExists( kTAG_PATH ) )
		{
			//
			// Check for methods.
			//
			if( ($count = count( $path = $this->offsetGet( kTAG_PATH ) )) >= 5 )
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
		
		} // Has path.
		
		return NULL;																// ==>

	} // GetMethodVertex.

	 
	/*===================================================================================
	 *	GetScaleVertex																	*
	 *==================================================================================*/

	/**
	 * <h4>Return scale term</h4>
	 *
	 * This method will return the current tag's scale term, if present, or <tt>NULL</tt>.
	 *
	 * The scale vertex is the last element of the path, it refers the ontology term that
	 * represents the scale or unit the current object is tagging.
	 *
	 * Note that if the tag contains only one vertex, that will be both a feature and a
	 * scale.
	 *
	 * @access public
	 * @return mixed				Last element of the terms list, or <tt>NULL</tt>.
	 *
	 * @see kTAG_PATH
	 */
	public function GetScaleVertex()
	{
		//
		// Check path.
		//
		if( $this->offsetExists( kTAG_PATH ) )
			return $this[ kTAG_PATH ]
						[count( $this[ kTAG_PATH ] ) - 1 ];						// ==>
		
		return NULL;																// ==>

	} // GetScaleVertex.

		

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
	 *		tags container must be resolved. Note that this method might need to resolve
	 *		the terms container, so provide at least a database.
	 *	<li><tt>$theIdentifier</tt>: This parameter represents the identifier to be
	 *		resolved:
	 *	 <ul>
	 *		<li><tt>integer</tt>: In this case the method assumes that the parameter
	 *			represents the tag identifier: it will attempt to retrieve the tag, if it
	 *			is not found, the method will return <tt>NULL</tt>.
	 *		<li><tt>array</tt>: In this case the method assumes the array is the tag path,
	 *			{@link kTAG_PATH}, it will attempt to convert it into the tag
	 *			{@link kTAG_UID} and locate it.
	 *		<li><i>other</i>: Any other type will be interpreted either the tag's unique
	 *			identifier, or as the tag's global identifier: the method will return the
	 *			matching tag or <tt>NULL</tt>.
	 *	 </ul>
	 *	<li><tt>$doThrow</tt>: If <tt>TRUE</tt>, any failure to resolve the tag will raise
	 *		an exception.
	 * </ul>
	 *
	 * The method will return an instance of this class, or <tt>NULL</tt>, if the identifier
	 * was not resolved.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param mixed					$theIdentifier		Identifier to be resolved.
	 * @param boolean				$doThrow			If <tt>TRUE</tt> raise an exception.
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
			$container = static::ResolveClassContainer( $theConnection, TRUE );
			
			//
			// Handle tag identifier.
			//
			if( is_integer( $theIdentifier ) )
			{
				//
				// Get object.
				//
				$tag = static::NewObject( $container, $theIdentifier );
				if( (! $doThrow)
				 || ($tag !== NULL) )
					return $tag;													// ==>
				
				throw new Exception
					( "Tag not found",
					  kERROR_NOT_FOUND );										// !@! ==>
			
			} // Provided tag identifier.
			
			//
			// Handle path.
			//
			if( is_array( $theIdentifier ) )
			{
				//
				// Iterate identifiers.
				//
				$list = Array();
				foreach( $theIdentifier as $element )
				{
					//
					// Resolve term.
					//
					$term = COntologyTerm::Resolve( $theConnection, $theIdentifier );
					if( $term === NULL )
					{
						if( ! $doThrow )
							return NULL;											// ==>
						
						throw new Exception
							( "Tag not found: unresolved term in path",
							  kERROR_NOT_FOUND );								// !@! ==>
					
					} // Unresolved term.
					
					//
					// Append identifier.
					//
					$list[] = $term[ kTAG_GID ];
				
				} // Iterating path.
				
				//
				// Generate unique identifier.
				//
				$theIdentifier = md5( implode( kTOKEN_INDEX_SEPARATOR, $list ), TRUE );
			
			} // Provided path.
			
			//
			// Try unique identifier.
			//
			$query = $container->NewQuery();
			$query->AppendStatement(
				CQueryStatement::Equals(
					kTAG_UID, $theIdentifier, kTYPE_BINARY_STRING ) );
			$tag = $container->Query( $query, NULL, NULL, NULL, NULL, TRUE );
			if( $tag === NULL )
			{
				//
				// Try global identifier.
				//
				$query = $container->NewQuery();
				$query->AppendStatement(
					CQueryStatement::Equals(
						kTAG_UID, md5( $theIdentifier, TRUE ), kTYPE_BINARY_STRING ) );
				$tag = $container->Query( $query, NULL, NULL, NULL, NULL, TRUE );
			
			} // Provided unique identifier doesn't match.
			
			//
			// Return result.
			//
			if( (! $doThrow)
			 || ($tag !== NULL) )
				return static::DocumentObject( $tag );								// ==>

			throw new Exception
				( "Tag not found",
				  kERROR_NOT_FOUND );											// !@! ==>
			
		} // Provided identifier.
		
		throw new Exception
			( "Missing tag identifier",
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
	 * the path to be object native identifiers.
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
	 * @see kTAG_PATH kTOKEN_INDEX_SEPARATOR
	 */
	protected function _index( CConnection $theConnection, $theModifiers )
	{
		//
		// Init local storage.
		//
		$identifier  = Array();
		$path = $this->offsetGet( kTAG_PATH );
		
		//
		// Iterate path elements.
		//
		for( $i = 0; $i < count( $path ); $i++ )
		{
			//
			// Resolve term.
			//
			$term = COntologyTerm::NewObject(
						COntologyTerm::ResolveClassContainer(
							$theConnection, TRUE ), $path[ $i ] );
			
			//
			// Add identifier.
			//
			$identifier[] = $term[ kTAG_GID ];
		
		} // Iterating path elements.
		
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
	 * In this class we lock the {@link kTAG_PATH} attribute if the object is
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
	 * @see kTAG_PATH
	 */
	protected function _Preset( &$theOffset, &$theValue )
	{
		//
		// Lock path.
		//
		if( ($theOffset == kTAG_PATH)
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
	 * In this class we lock the {@link kTAG_PATH} attribute if the object is
	 * committed and the {@link kTAG_UID} in all cases.
	 *
	 * @param reference			   &$theOffset			Offset.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 *
	 * @uses _IsCommitted()
	 *
	 * @see kTAG_PATH
	 */
	protected function _Preunset( &$theOffset )
	{
		//
		// Lock path.
		//
		if( ($theOffset == kTAG_PATH)
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
	 *	_PrecommitIdentify																*
	 *==================================================================================*/

	/**
	 * <h4>Determine the identifiers before committing</h4>
	 *
	 * This method will use the result of the {@link _index()} method to set the global
	 * identifier, {@link kTAG_GID}; the same value will be hashed and constitute the
	 * unique identifier, {@link kTAG_UID}, while the native identifier,
	 * {@link kTAG_NID}, will be set by the sequence number {@link kSEQUENCE_KEY_TAG}.
	 *
	 * The parent method will then be called, which will ignore the global and native
	 * identifiers, since they will have been set here.
	 *
	 * @param reference			   &$theConnection		Server, database or container.
	 * @param reference			   &$theModifiers		Commit options.
	 *
	 * @access protected
	 * @return mixed
	 *
	 * @throws Exception
	 *
	 * @uses _IsCommitted()
	 * @uses _index()
	 *
	 * @see kSEQUENCE_KEY_TAG
	 * @see kTAG_NID kTAG_GID kTAG_UID
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
					$container = static::ResolveContainer( $theConnection, TRUE );
					
					//
					// Generate unique identifier.
					//
					$uid = md5( $index, TRUE );
					
					//
					// Convert binary string to container native format.
					//
					$container->UnserialiseData( $uid, kTYPE_BINARY_STRING );
					
					//
					// Check unique identifier.
					//
					if( $container->CheckObject( $uid, kTAG_UID ) )
						throw new Exception
							( "Duplicate object",
							  kERROR_COMMIT );									// !@! ==>
					
					//
					// Set unique identifier.
					//
					$this->offsetSet( kTAG_UID, $uid );
				
				} // Supports global identifier.
			
			} // Missing global identifier.
		
			//
			// Set native identifier.
			//
			if( ! $this->offsetExists( kTAG_NID ) )
				$this->offsetSet(
					kTAG_NID,
					static::ResolveContainer(
						$theConnection, TRUE )
							->NextSequence( kSEQUENCE_KEY_TAG, TRUE ) );
		
		} // Insert or replace and not committed.
	
		//
		// Call parent method.
		//
		return parent::_PrecommitIdentify( $theConnection, $theModifiers );			// ==>
		
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
	 * In this class we reference this tag from terms related to nodes used as features,
	 * methods or scales. Depending on the value of the following flags:
	 *
	 * <ul>
	 *	<li><tt>{@link kSWITCH_kTAG_FEATURES}</tt>: <i>Feature node reference</i>. This
	 *		switch manages references to the current tag from terms referred by feature
	 *		nodes, or the first node in the path. The reference is in the
	 *		{@link kTAG_FEATURES} of the referenced term.
	 *	 <ul>
	 *		<li><tt>0x2</tt>: <i>Keep count of references</i>. This means that the
	 *			{@link kTAG_FEATURES} attribute of the term will be incremented when the
	 *			tag is inserted, or decremented when deleted.
	 *		<li><tt>0x3</tt>: <i>Keep list of references</i>. This means that a reference to
	 *			the current object will be added to the {@link kTAG_FEATURES} attribute of
	 *			the term when the current object is inserted, and removed when the object is
	 *			deleted.
	 *		<li><tt>0x0</tt> <i>or other</i>: <i>Don't handle this information</i>. This
	 *			means that the term's {@link kTAG_FEATURES} attribute will not be handled.
	 *	 </ul>
	 *	<li><tt>{@link kSWITCH_kTAG_METHODS}</tt>: <i>Method node reference</i>. This
	 *		switch manages references to the current tag from terms referred by method
	 *		nodes, or all nodes between the first and last nodes in the path. The reference
	 *		is in the {@link kSWITCH_kTAG_METHODS} of the referenced term.
	 *	 <ul>
	 *		<li><tt>0x2</tt>: <i>Keep count of references</i>. This means that the
	 *			{@link kSWITCH_kTAG_METHODS} attribute of the term will be incremented when
	 *			the tag is inserted, or decremented when deleted.
	 *		<li><tt>0x3</tt>: <i>Keep list of references</i>. This means that a reference to
	 *			the current object will be added to the {@link kSWITCH_kTAG_METHODS}
	 *			attribute of the term when the current object is inserted, and removed when
	 *			the object is deleted.
	 *		<li><tt>0x0</tt> <i>or other</i>: <i>Don't handle this information</i>. This
	 *			means that the term's {@link kSWITCH_kTAG_METHODS} attribute will not be
	 *			handled.
	 *	 </ul>
	 *	<li><tt>{@link kSWITCH_kTAG_SCALES}</tt>: <i>Scale node reference</i>. This
	 *		switch manages references to the current tag from terms referred by scale
	 *		nodes, or the last node in the path. The reference is in the
	 *		{@link kTAG_SCALES} of the referenced term.
	 *	 <ul>
	 *		<li><tt>0x2</tt>: <i>Keep count of references</i>. This means that the
	 *			{@link kTAG_SCALES} attribute of the term will be incremented when the
	 *			tag is inserted, or decremented when deleted.
	 *		<li><tt>0x3</tt>: <i>Keep list of references</i>. This means that a reference to
	 *			the current object will be added to the {@link kTAG_SCALES} attribute of
	 *			the term when the current object is inserted, and removed when the object is
	 *			deleted.
	 *		<li><tt>0x0</tt> <i>or other</i>: <i>Don't handle this information</i>. This
	 *			means that the term's {@link kTAG_SCALES} attribute will not be handled.
	 *	 </ul>
	 * </ul>
	 *
	 * Note that you should provide either a database connection or the <i>term</i>
	 * container to this method in order to make it work!
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
	 * @see kSWITCH_kTAG_FEATURES, kSWITCH_kTAG_METHODS, kSWITCH_kTAG_SCALES
	 * @see kTAG_FEATURES, kTAG_METHODS, kTAG_SCALES
	 * @see kFLAG_PERSIST_INSERT kFLAG_PERSIST_REPLACE kFLAG_PERSIST_DELETE
	 */
	protected function _PostcommitRelated( &$theConnection, &$theModifiers )
	{
		//
		// Call parent method.
		//
		parent::_PostcommitRelated( $theConnection, $theModifiers );
	
		//
		// Set operation.
		//
		$operation = ( ! ($theModifiers & kFLAG_PERSIST_DELETE) )
				   ? 1
				   : -1;
		
		//
		// Handle new object.
		//
		if( ( ( (($theModifiers & kFLAG_PERSIST_MASK) == kFLAG_PERSIST_INSERT)
			 || (($theModifiers & kFLAG_PERSIST_MASK) == kFLAG_PERSIST_REPLACE) )
		   && (! $this->_IsCommitted()) )
		 || ($theModifiers & kFLAG_PERSIST_DELETE) )
		{
			//
			// Iterate path elements.
			//
			$path = $this->offsetGet( kTAG_PATH );
			for( $i = 0; $i < count( $path ); $i += 2 )
			{
				//
				// Handle feature vertex.
				//
				if( $i == 0 )
					$this->_ReferenceInObject(
						COntologyTerm::ResolveContainer( $theConnection, TRUE ),
						kSWITCH_kTAG_FEATURES,
						$path[ $i ],
						kTAG_FEATURES,
						$operation );
				
				//
				// Handle scale vertex.
				//
				elseif( $i == (count( $path ) - 1) )
					$this->_ReferenceInObject(
						COntologyTerm::ResolveContainer( $theConnection, TRUE ),
						kSWITCH_kTAG_SCALES,
						$path[ $i ],
						kTAG_SCALES,
						$operation );
				
				//
				// Handle method vertex.
				//
				else
					$this->_ReferenceInObject(
						COntologyTerm::ResolveContainer( $theConnection, TRUE ),
						kSWITCH_kTAG_METHODS,
						$path[ $i ],
						kTAG_METHODS,
						$operation );
			
			} // Iterating path elements.
		
		} // Insert or replace and not committed, or deleting.
		
	} // _PostcommitRelated.

	 

} // class COntologyTag.


?>

<?php

/**
 * <i>COntologyNode</i> class definition.
 *
 * This file contains the class definition of <b>COntologyNode</b> which represents the
 * ancestor of ontology node classes.
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 10/09/2012
 */

/*=======================================================================================
 *																						*
 *									COntologyNode.php									*
 *																						*
 *======================================================================================*/

//
// Class includes.
//
use	Everyman\Neo4j\Client,
	Everyman\Neo4j\Transport,
	Everyman\Neo4j\Node,
	Everyman\Neo4j\Relationship;

/**
 * Local definitions.
 *
 * This include file contains common offset definitions.
 */
require_once( "COntologyNode.inc.php" );

/**
 * Terms.
 *
 * This includes the term class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntologyTerm.php" );

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CNode.php" );

/**
 * <h4>Ontology node object ancestor</h4>
 *
 * This class extends its ancestor, {@link CNode}, by asserting the {@link Term()} to be an
 * instance of {@link COntologyTerm} and by managing the {@link kTAG_REFS_NODE} offset
 * of the related {@link Term()}.
 *
 * The class does not handle global identifiers and objects cannot be uniquely identified
 * by its properties or attributes, it is the duty of the hosting container to provide the
 * {@link kOFFSET_NID} identifier, In this class we use sequences,
 * {@link CContainer::NextSequence()}, from a default container named after the default
 * {@link kCONTAINER_SEQUENCE_NAME} tag in the same database, this is to make referencing
 * nodes easier and to be compatible with most graph databases.
 *
 * In this class, the term, {@link kTAG_TERM}, is a reference to an instance of
 * {@link COntologyTerm}, meaning that the offset will contain the native identifier of the
 * term. The value may be provided as an uncommitted term object, in that case the term will
 * be committed before the current node is committed.
 *
 * Once the node has been committed, it will not be possible to modify the term,
 * {@link kTAG_TERM}. 
 *
 * When inserting a new node, the class will also make sure that the referenced term gets a
 * reference to the current node in its {@link kTAG_REFS_NODE} offset, this means that
 * once a node is committed, one cannot change its term reference.
 *
 * The class features an offset, {@link kTAG_REFS_TAG}, which represents the list of tags
 * that reference the current node. This offset is a set of tag identifiers implemented as
 * an array. The offset definition is borrowed from the {@link COntologyTerm} class, which
 * is required by this class because of its {@link kTAG_TERM} offset. This offset is
 * managed by the tag class, this class locks the offset.
 *
 * This class prevents updating the full object once it has been inserted for the first
 * time. This behaviour is necessary because nodes are referenced by many other objects, so
 * updating a full node object is risky, since it may have been updated elsewhere: for this
 * reason the {@link Update()} and {@link Replace()} methods will raise an exception.
 *
 * The class implements the static method, {@link DefaultContainer()}, it will use the
 * {@link kCONTAINER_NODE_NAME} constant. Note that when passing {@link CConnection} based
 * objects to the persisting methods of this class, you should provide preferably Database
 * instances, since this class may have to commit terms.
 *
 * The class features member accessor methods for the default offsets:
 *
 * <ul>
 *	<li>{@link TagRefs()}: This method returns the node's tag references,
 *		{@link kTAG_REFS_TAG}.
 *	<li>{@link LoadTerm()}: This method will return the referenced term object.
 * </ul>
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 */
class COntologyNode extends CNode
{
	/**
	 * <b>Term object</b>
	 *
	 * This data member holds the eventual term object when requested.
	 *
	 * @var COntologyTerm
	 */
	 protected $mTerm = NULL;

		

/*=======================================================================================
 *																						*
 *											MAGIC										*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	__toString																		*
	 *==================================================================================*/

	/**
	 * <h4>Return object name</h4>
	 *
	 * This method should return the current object's name which should represent the unique
	 * identifier of the object.
	 *
	 * By default we return the string representation of the term, {@link kTAG_TERM}.
	 *
	 * @access public
	 * @return string				The connection name.
	 */
	public function __toString()
	{
		//
		// Check native identifier.
		//
		if( $this->offsetExists( kOFFSET_NID ) )
			return (string) $this->offsetGet( kOFFSET_NID );						// ==>
		
		//
		// Yes, I know...
		//
		return NULL;																// ==>
	
	} // __toString.

		

/*=======================================================================================
 *																						*
 *								PUBLIC MEMBER INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Type																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage node type set</h4>
	 *
	 * In this class we overload the parent method to assert the kind of elements that can
	 * be set in the offset. The offset accepts two types of elements:
	 *
	 * <ul>
	 *	<li><i>Data type</i>: The set accepts one of the following primary data types:
	 *	 <ul>
	 *		<li><i>{@link kTYPE_STRING}</i>: String, we assume in UTF8 character set.
	 *		<li><i>{@link kTYPE_INT32}</i>: 32 bit signed integer.
	 *		<li><i>{@link kTYPE_INT64}</i>: 64 bit signed integer.
	 *		<li><i>{@link kTYPE_FLOAT}</i>: Floating point number.
	 *		<li><i>{@link kTYPE_BOOLEAN}</i>: An <tt>on</tt>/<tt>off</tt> switch.
	 *		<li><i>{@link kTYPE_BINARY}</i>: A binary string.
	 *		<li><i>{@link kTYPE_DATE}</i>: A date.
	 *		<li><i>{@link kTYPE_TIME}</i>: A date and time.
	 *		<li><i>{@link kTYPE_STAMP}</i>: A native timestamp.
	 *		<li><i>{@link kTYPE_STRUCT}</i>: A structure container.
	 *		<li><i>{@link kTYPE_ENUM}</i>: Enumerated scalar, this data type resolves by
	 *			default to a string and indicates that the node refers to a controlled
	 *			vocabulary scalar whose elements will be found related to the current node.
	 *		<li><i>{@link kTYPE_ENUM_SET}</i>: Enumerated set, this data type resolves by
	 *			default to a list of string elements and indicates that the node refers to
	 *			an enumerated set whose elements will be found related to the current node.
	 *	 </ul>
	 *		Only one of the above may be present in the list, when adding a new element, if
	 *		the offset already contains a data type, this will be replaced by the new one.
	 *	<li><i>Cardinality</i>: The set accepts one or more cardinality indicators from the
	 *		following set:
	 *	 <ul>
	 *		<li><i>{@link kTYPE_CARD_REQUIRED}</i>: Required, the element referred by the
	 *			current node is required and cannot be omitted; if this tag is missing, it
	 *			means that the element is optional.
	 *		<li><i>{@link kTYPE_CARD_ARRAY}</i>: Array, the element referred by the current
	 *			node is a list in which each element is of the data type indicated by the
	 *			previous set; if this tag is missing, it means that the element is a scalar.
	 *	 </ul>
	 * </ul>
	 *
	 * @param mixed					$theValue			Type or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> type.
	 */
	public function Type( $theValue = NULL, $theOperation = NULL, $getOld = FALSE )
	{
		//
		// Handle multiple parameters:
		//
		if( is_array( $theValue ) )
		{
			//
			// Init local storage.
			//
			$result = Array();
			$count = count( $theValue );
			$current = $this->offsetGet( kTAG_TYPE );
			
			//
			// Check operation.
			//
			if( is_array( $theOperation )
			 && (count( $theOperation ) != $count) )
				throw new Exception
						( "Values and operations counts do not match",
						  kERROR_PARAMETER );									// !@! ==>
			
			//
			// Iterate values.
			//
			foreach( $theValue as $index => $value )
			{
				//
				// Set operation.
				//
				$operation = ( is_array( $theOperation ) )
						   ? $theOperation[ $index ]
						   : $theOperation;
				
				//
				// Get result.
				//
				$result[] = parent::Type( $value, $operation, $getOld );
			
			} // Iterating list of values.
			
			return $result;															// ==>
		
		} // Multiple parameters.
		
		//
		// Check add operation.
		//
		if( ($theOperation !== NULL)
		 && ($theOperation !== FALSE) )
		{
			//
			// Check value.
			//
			switch( $theValue )
			{
				//
				// Handle data types.
				//
				case kTYPE_STRING:
				case kTYPE_INT32:
				case kTYPE_INT64:
				case kTYPE_FLOAT:
				case kTYPE_BOOLEAN:
				case kTYPE_ANY:

				case kTYPE_BINARY:
				case kTYPE_DATE:
				case kTYPE_TIME:
				case kTYPE_REGEX:
				
				case kTYPE_LSTRING:
				case kTYPE_STAMP:
				case kTYPE_STRUCT:
				
				case kTYPE_PHP:
				case kTYPE_JSON:
				case kTYPE_XML:
				case kTYPE_SVG:
				
				case kTYPE_MongoId:
				case kTYPE_MongoCode:
				
				case kTYPE_ENUM:
				case kTYPE_ENUM_SET:
					//
					// Remove eventual existing data type.
					//
					parent::Type( array( kTYPE_STRING, kTYPE_INT32,
										 kTYPE_INT64, kTYPE_FLOAT,
										 kTYPE_DATE, kTYPE_TIME,
										 kTYPE_STAMP, kTYPE_BOOLEAN,
										 kTYPE_BINARY, kTYPE_ENUM, kTYPE_ENUM_SET ),
								  FALSE );
			
				case kTYPE_CARD_REQUIRED:
				case kTYPE_CARD_ARRAY:
					break;
				
				default:
					throw new Exception
							( "Unsupported type",
							  kERROR_PARAMETER );								// !@! ==>
			
			} // Parsed value.
		
		} // Add operation.
		
		return parent::Type( $theValue, $theOperation, $getOld );					// ==>

	} // Type.

	 
	/*===================================================================================
	 *	TagRefs																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage tag references</h4>
	 *
	 * The <i>tag references</i>, {@link kTAG_REFS_TAG}, holds a list of identifiers of
	 * tags that reference the node.
	 *
	 * The method is read-only, because this value must be managed externally.
	 *
	 * The {@link kTAG_REFS_TAG} offset tag is defined by the {@link COntologyTerm} class
	 * which is included in this class by default.
	 *
	 * @access public
	 * @return array				Tags reference list.
	 *
	 * @see kTAG_REFS_TAG
	 */
	public function TagRefs()
	{
		//
		// Handle reference count.
		//
		if( $this->offsetExists( kTAG_REFS_TAG ) )
			return $this->offsetGet( kTAG_REFS_TAG );								// ==>
		
		return Array();																// ==>

	} // TagRefs.

		
	/*===================================================================================
	 *	EdgeRefs																		*
	 *==================================================================================*/

	/**
	 * <h4>Manage edge references</h4>
	 *
	 * The <i>edge references</i>, {@link kTAG_REFS_EDGE}, holds a list of identifiers of
	 * edges that reference the node.
	 *
	 * The method is read-only, because this value must be managed externally.
	 *
	 * @access public
	 * @return array				Edge reference list.
	 *
	 * @see kTAG_REFS_EDGE
	 */
	public function EdgeRefs()
	{
		//
		// Handle reference count.
		//
		if( $this->offsetExists( kTAG_REFS_EDGE ) )
			return $this->offsetGet( kTAG_REFS_EDGE );								// ==>
		
		return Array();																// ==>

	} // EdgeRefs.

		

/*=======================================================================================
 *																						*
 *							PUBLIC RELATED MEMBER INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	LoadTerm																		*
	 *==================================================================================*/

	/**
	 * <h4>Load term object</h4>
	 *
	 * This method will return the current term object: if the term is not set, the method
	 * will return <tt>NULL</tt>; if the term cannot be found, the method will raise an
	 * exception.
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
	 * @see kTAG_TERM
	 */
	public function LoadTerm( CConnection $theConnection, $doReload = FALSE )
	{
		//
		// Check offset.
		//
		if( $this->offsetExists( kTAG_TERM ) )
		{
			//
			// Refresh cache.
			// Uncommitted terms are cached by default.
			//
			if( $doReload					// Reload,
			 || ($this->mTerm === NULL) )	// or not cached.
			{
				//
				// Handle term object.
				//
				$term = $this->offsetGet( kTAG_TERM );
				if( $term instanceof COntologyTerm )
					return $term;													// ==>
				
				//
				// Load term object.
				//
				$this->mTerm
					= COntologyTerm::Resolve(
						COntologyTerm::ResolveClassContainer( $theConnection, TRUE ),
						$term,
						NULL,
						TRUE );
			
			} // Reload or empty cache.
			
			//
			// Handle not found.
			//
			if( $this->mTerm === NULL )
				throw new Exception
					( "Term not found",
					  kERROR_STATE );											// !@! ==>
		
		} // Has term.
		
		return $this->mTerm;														// ==>

	} // LoadTerm.

		

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
	 * This method will relate the current node to another and return a
	 * {@link COntologyEdge} object which represents a directed graph edge where the current
	 * node represents the subject of the relationship.
	 *
	 * The predicate and object vertex can be provided both as objects or as object
	 * identifiers.
	 *
	 * Note that the edge will not be committed, it is the responsibility of the caller to
	 * do so.
	 *
	 * @param mixed					$thePredicate		Predicate term object or reference.
	 * @param mixed					$theObject			Object node object or reference.
	 *
	 * @access public
	 * @return COntologyEdge		Edge object.
	 */
	public function RelateTo( $thePredicate, $theObject )
	{
		//
		// Instantiate edge.
		//
		$edge = new COntologyEdge();
		
		//
		// Set subject.
		//
		$edge->Subject( $this );
		
		//
		// Set predicate.
		//
		$edge->Predicate( $thePredicate );
		
		//
		// Set object.
		//
		$edge->Object( $theObject );
		
		return $edge;																// ==>

	} // RelateTo.

		

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
	 * <h4>Return the nodes container</h4>
	 *
	 * The container will be created or fetched from the provided database using the
	 * {@link kCONTAINER_NODE_NAME} name.
	 *
	 * @param CDatabase				$theDatabase		Database object.
	 *
	 * @static
	 * @return CContainer			The nodes container.
	 *
	 * @see kCONTAINER_NODE_NAME
	 */
	static function DefaultContainer( CDatabase $theDatabase )
	{
		return $theDatabase->Container( kCONTAINER_NODE_NAME );						// ==>
	
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
	 * <h4>Resolve a node</h4>
	 *
	 * This method can be used to retrieve an existing node by identifier, or retrieve all
	 * nodes matching a term.
	 *
	 * The method accepts the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theConnection</tt>: This parameter represents the connection from which the
	 *		nodes container must be resolved. If this parameter cannot be correctly
	 *		determined, the method will raise an exception.
	 *	<li><tt>$theIdentifier</tt>: This parameter represents either the node identifier
	 *		or the term reference, depending on its type:
	 *	 <ul>
	 *		<li><tt>integer</tt>: In this case the method assumes that the parameter
	 *			represents the node identifier: it will attempt to retrieve the node, if it
	 *			is not found, the method will return <tt>NULL</tt>.
	 *		<li><tt>{@link COntologyTerm}</tt>: In this case the method will locate all
	 *			nodes that refer to the provided term. If the term is {@link _IsCommitted()}
	 *			the method will use its native identifier; if not, it will use its global
	 *			identifier if available, or assume the term does not exist.
	 *		<li><i>other</i>: Any other type will be interpreted either the term's native
	 *			identifier, or as the term's global identifier: the method will return all
	 *			nodes that refer to that term.
	 *	 </ul>
	 *	<li><tt>$doThrow</tt>: If <tt>TRUE</tt>, any failure to resolve the node will raise
	 *		an exception.
	 * </ul>
	 *
	 * The method will return an object if provided a node identifier, or an array of
	 * objects if provided a term reference; if there is no match the method will return
	 * <tt>NULL</tt>, or raise an exception if the last parameter is <tt>TRUE</tt>.
	 *
	 * <b>Note: do not provide an array containing the object in the identifier parameter,
	 * or you will get unexpected results.</b>
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
		// Check identifier.
		//
		if( $theIdentifier !== NULL )
		{
			//
			// Handle node identifier.
			//
			if( is_integer( $theIdentifier ) )
			{
				//
				// Get node.
				//
				$node = static::NewObject( $theConnection, $theIdentifier );
				if( (! $doThrow)
				 || ($node !== NULL) )
					return $node;													// ==>
				
				throw new Exception
					( "Node not found",
					  kERROR_NOT_FOUND );										// !@! ==>
			
			} // Provided node identifier.
			
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
			$theIdentifier = $theIdentifier->offsetGet( kOFFSET_NID );
			
			//
			// Resolve container.
			//
			$container = COntologyNode::ResolveClassContainer( $theConnection, TRUE );
			
			//
			// Make query.
			//
			$query = $container->NewQuery();
			$query->AppendStatement(
				CQueryStatement::Equals(
					kTAG_TERM, $theIdentifier, kTYPE_BINARY ) );
			$rs = $container->Query( $query );
			if( $rs->count() )
			{
				//
				// Return list of nodes.
				//
				$list = Array();
				foreach( $rs as $document )
					$list[] = CPersistentObject::DocumentObject( $document );
				
				return $list;														// ==>
			
			} // Found at least one node.

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
 *								PROTECTED OFFSET INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_Preset																			*
	 *==================================================================================*/

	/**
	 * <h4>Handle offset before setting it</h4>
	 *
	 * In this class we handle the term offset, if provided as an object we leave it
	 * unchanged only if not yet committed, if not, we convert it to its native identifier.
	 * We also ensure the provided term object to be an instance of {@link COntologyTerm} by
	 * asserting {@link CDocument} descendants to be of that class.
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
	 * @see kTAG_TERM kTAG_REFS_TAG
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
		// Handle term.
		//
		if( $theOffset == kTAG_TERM )
		{
			//
			// Lock term if object is committed.
			//
			if( $this->_IsCommitted() )
				throw new Exception
					( "You cannot modify the [$theOffset] offset: "
					 ."the object is committed",
					  kERROR_LOCKED );											// !@! ==>
			
			//
			// Check value type.
			//
			$ok = $this->_AssertClass( $theValue, 'CDocument', 'COntologyTerm' );
			
			//
			// Handle wrong object.
			//
			if( $ok === FALSE )
				throw new Exception
					( "Cannot set term: "
					 ."the object must be a term reference or object",
					  kERROR_PARAMETER );										// !@! ==>
			
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
							( "Cannot set term: "
							 ."the object is missing its native identifier",
							  kERROR_PARAMETER );								// !@! ==>
				
				} // Term is committed.
				
				//
				// Copy to data member.
				//
				else
					$this->mTerm = $theValue;
			
			} // Correct object class.
		
		} // Provided term.
		
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
	 * In this class we prevent the modification of the {@link kTAG_TERM} offset if the
	 * object is committed and of the {@link kTAG_REFS_TAG} offset in all cases.
	 *
	 * @param reference			   &$theOffset			Offset.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 *
	 * @uses _IsCommitted()
	 *
	 * @see kTAG_REFS_TAG kTAG_TERM
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
		// Lock term if object is committed.
		//
		if( ($theOffset == kTAG_TERM)
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
	 * @uses LoadTerm()
	 *
	 * @see kTAG_TERM
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
			// Handle term object.
			// Note that we let _Preset() method take care of the specific class.
			// Note that we do not check for the term: it is required to be inited.
			//
			$term = $this->offsetGet( kTAG_TERM );
			if( $term instanceof COntologyTerm )
			{
				//
				// Commit.
				// Note that we insert, to ensure the object is new.
				//
				$term->Insert(
					COntologyTerm::ResolveClassContainer( $theConnection, TRUE ) );
				
				//
				// Cache it.
				//
				$this->mTerm = $term;
				
				//
				// Set identifier in term offset.
				//
				$this->offsetSet( kTAG_TERM, $term->offsetGet( kOFFSET_NID ) );
				
			} // Term is object.
			
			//
			// Handle term identifier.
			//
			else
				$this->LoadTerm( $theConnection, TRUE );
		
		} // Not deleting.
	
	} // _PrecommitRelated.

	 
	/*===================================================================================
	 *	_PrecommitIdentify																*
	 *==================================================================================*/

	/**
	 * <h4>Determine the identifiers before committing</h4>
	 *
	 * Objects of this class are identified by a sequence number tagged
	 * {@link kSEQUENCE_KEY_NODE}, this method will set the native identifier,
	 * {@link kOFFSET_NID}, with this value.
	 *
	 * The parent method will then be called, which will ignore the global identifier,
	 * {@link kTAG_GID}, since the {@link _index()} method returns <tt>NULL</tt> and
	 * also ignore the native identifier, {@link kOFFSET_NID}, since it will have been set
	 * here.
	 *
	 * @param reference			   &$theConnection		Server, database or container.
	 * @param reference			   &$theModifiers		Commit options.
	 *
	 * @access protected
	 *
	 * @see kOFFSET_NID kSEQUENCE_KEY_NODE
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
			// Set native identifier.
			//
			if( ! $this->offsetExists( kOFFSET_NID ) )
			{
				//
				// Create graph node.
				//
				if( kGRAPH_DB )
				{
					//
					// Connect.
					//
					if( (! isset( $_SESSION ))
					 || (! array_key_exists( 'neo4j', $_SESSION )) )
						$client = $_SESSION[ 'neo4j' ]
							= new Everyman\Neo4j\Client( 'localhost', 7474 );
					else
						$client = $_SESSION[ 'neo4j' ];
					
					//
					// Build node.
					//
					$node = new Node( $client );
					$node->setProperty( kTAG_TERM, $this->mTerm->GID() );
					if( $this->mTerm->offsetExists( kTAG_KIND ) )
						$node->setProperty( kTAG_KIND, $this->mTerm->Kind() );
					if( $this->mTerm->offsetExists( kTAG_TYPE ) )
						$node->setProperty( kTAG_TYPE, $this->mTerm->Type() );
					
					//
					// Save node.
					//
					$node->save();
					
					//
					// Use its ID.
					//
					$id = $node->getId();
				
				} // Use graph database.
				
				//
				// Get sequence number.
				//
				else
					$id = static::ResolveClassContainer(
							$theConnection, TRUE )
								->NextSequence( kSEQUENCE_KEY_NODE, TRUE );
				
				//
				// Set identifier.
				//
				$this->offsetSet( kOFFSET_NID, $id );
			
			} // Missing native identifier.
		
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
	 * In this class we add the current node's identifier to the list of node references,
	 * {@link kTAG_REFS_NODE}, in the related term when inserting; we remove the element
	 * when deleting.
	 *
	 * @param reference			   &$theConnection		Server, database or container.
	 * @param reference			   &$theModifiers		Commit options.
	 *
	 * @access protected
	 *
	 * @uses _IsCommitted()
	 * @uses _ReferenceInTerm()
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
				$this->_ReferenceInTerm( $theConnection, TRUE );
		
		} // Insert or replace.
		
		//
		// Check if deleting.
		//
		elseif( $theModifiers & kFLAG_PERSIST_DELETE )
			$this->_ReferenceInTerm( $theConnection, FALSE );
		
	} // _PostcommitRelated.

	 
	/*===================================================================================
	 *	_PostcommitCleanup																*
	 *==================================================================================*/

	/**
	 * <h4>Cleanup the object after committing</h4>
	 *
	 * In this class we reset the term object cache, we set the data member to <tt>NULL</tt>
	 * so that next time one wants to retrieve the term object, it will have to be refreshed
	 * and its references actualised.
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
		// Reset term cache.
		//
		$this->mTerm = NULL;
	
	} // _PostcommitCleanup.

		

/*=======================================================================================
 *																						*
 *								PROTECTED REFERENCE INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_ReferenceInTerm																*
	 *==================================================================================*/

	/**
	 * <h4>Add node reference to term</h4>
	 *
	 * This method can be used to add or remove the current node's reference from the
	 * referenced term, {@link kTAG_REFS_NODE}. This method should be used whenever
	 * committing a new node or deleting one: it will add the current node's native
	 * identifier to the set of node references of the node's term when committing a new
	 * node; it will remove it when deleting the node.
	 *
	 * The last parameter is a boolean: if <tt>TRUE</tt> the method will add to the set; if
	 * <tt>FALSE</tt>, it will remove from the set.
	 *
	 * The method will return <tt>TRUE</tt> if the operation affected at least one object,
	 * <tt>FALSE</tt> if not, <tt>NULL</tt> if the term is not set and raise an exception if
	 * the operation failed.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param boolean				$doAdd				<tt>TRUE</tt> add reference.
	 *
	 * @access protected
	 * @return boolean				<tt>TRUE</tt> operation affected at least one object.
	 *
	 * @see kTAG_TERM kTAG_REFS_NODE
	 * @see kFLAG_PERSIST_MODIFY kFLAG_MODIFY_ADDSET kFLAG_MODIFY_PULL
	 */
	protected function _ReferenceInTerm( CConnection $theConnection, $doAdd )
	{
		//
		// Check term.
		//
		if( $this->offsetExists( kTAG_TERM ) )
		{
			//
			// Set modification criteria.
			//
			$criteria = array( kTAG_REFS_NODE => $this->offsetGet( kOFFSET_NID ) );
			
			//
			// Handle add to set.
			//
			if( $doAdd )
				return COntologyTerm::ResolveClassContainer( $theConnection, TRUE )
						->ManageObject
							(
								$criteria,
								$this->offsetGet( kTAG_TERM ),
								kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_ADDSET
							);														// ==>
			
			return COntologyTerm::ResolveClassContainer( $theConnection, TRUE )
					->ManageObject
						(
							$criteria,
							$this->offsetGet( kTAG_TERM ),
							kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_PULL
						);															// ==>
		
		} // Object has term.
		
		return NULL;																// ==>
	
	} // _ReferenceInTerm.

	 

} // class COntologyNode.


?>

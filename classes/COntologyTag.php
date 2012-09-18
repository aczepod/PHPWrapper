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
 * Nodes.
 *
 * This includes the node class definitions.
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
 * This class extends its ancestor, {@link CTag}, by checking the type of objects passed to
 * its path, {@link kOFFSET_PATH} and by overriding the {@link _index()} method to extract
 * the global identifiers from the path elements.
 *
 * The tag's path must contain an odd number of elements in which the odd items must refer
 * to {@link COntologyNode} objects and the even elements must refer to
 * {@link COntologyTerm} objects. The global identifier of the object is composed of the
 * global identifier of all referenced terms in the path, that is, predicates provide their
 * own global identifier, nodes provide the global identifier of the referenced terms.
 *
 * Elements of the path can be provided as objects and those that are not yet committed will
 * be saved when the current tag is saved.
 *
 * The class adds an offset, {@link kOFFSET_UID}, which stores the hashed version of the
 * global identifier and can be used to identify duplicate objects.
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
	 * We overload the parent method to check the provided elements:
	 *
	 * <ul>
	 *	<li>If the element was provided as an object, we ensure that odd items are derived
	 *		from {@link COntologyNode} and even items from {@link COntologyTerm}.
	 *	<li>If the element was provided as an object, if not yet committed, we insert it as
	 *		is; if already committed, we use its native identifier.
	 * </ul>
	 *
	 * @param mixed					$theValue			Value to append.
	 *
	 * @access public
	 * @return integer				Number of items in the list.
	 *
	 * @uses _AssertClass()
	 *
	 * @see kOFFSET_PATH
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
				$count = ( $this->offsetExists( kOFFSET_PATH ) )
					   ? count( $this->offsetGet( kOFFSET_PATH ) )
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
							( "Cannot set path element, expecting a vertex: "
							 ."the object must be a node reference or object",
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
							( "Cannot set path element, expecting a predicate: "
							 ."the object must be a term reference or object",
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
	 * @see kOFFSET_PATH kTOKEN_INDEX_SEPARATOR
	 */
	protected function _index( CConnection $theConnection, $theModifiers )
	{
		//
		// Init local storage.
		//
		$identifier = Array();
		$path = $this->offsetGet( kOFFSET_PATH );
		
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
						COntologyTerm::ResolveClassContainer( $theConnection, TRUE ), $id );
			
			//
			// Add identifier.
			//
			$identifier[] = $term[ kOFFSET_GID ];
		
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
	 * @see kOFFSET_PATH
	 */
	protected function _Preset( &$theOffset, &$theValue )
	{
		//
		// Lock path.
		//
		if( ($theOffset == kOFFSET_PATH)
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
	 * @see kOFFSET_PATH
	 */
	protected function _Preunset( &$theOffset )
	{
		//
		// Lock path.
		//
		if( ($theOffset == kOFFSET_PATH)
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
	 * @param reference			   &$theConnection		Server, database or container.
	 * @param reference			   &$theModifiers		Commit options.
	 *
	 * @access protected
	 *
	 * @uses _IsCommitted()
	 *
	 * @see kOFFSET_PATH
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
			$path = $this->offsetGet( kOFFSET_PATH );
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
						$item->Insert(
							COntologyNode::ResolveClassContainer(
								$theConnection, TRUE ) );
					
					//
					// Replace object.
					//
					$path[ $i ] = $item->offsetGet( kOFFSET_NID );
				
				} // Item is object.
			
			} // Iterating path elements.
			
			//
			// Replace path.
			//
			$this->offsetSet( kOFFSET_PATH, $path );
		
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
			$path = $this->offsetGet( kOFFSET_PATH );
			for( $i = 0; $i < count( $path ); $i++ )
			{
				//
				// Handle node.
				//
				if( ! ($i % 2) )
				{
					//
					// Load node.
					//
					$node = COntologyNode::NewObject(
							COntologyNode::ResolveClassContainer(
								$theConnection, TRUE ), $path[ $i ] );
					
					//
					// Remove current tag reference from vertex term.
					//
					if( $theModifiers & kFLAG_PERSIST_DELETE )
					{
						//
						// Handle node.
						//
						$fields = $mod;
						COntologyNode::ResolveClassContainer( $theConnection, TRUE )
							->ManageObject
							(
								$fields,				// Because it will be overwritten.
								$path[ $i ],						// Node identifier.
								kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_PULL	// Remove.
							);
					
						//
						// Handle node term.
						//
						$fields = $mod;
						COntologyTerm::ResolveClassContainer( $theConnection, TRUE )
							->ManageObject
							(
								$fields,				// Because it will be overwritten.
								$node->Term(),						// Node term identifier.
								kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_PULL	// Remove.
							);
					
					} // Deleting.
					
					//
					// Add current tag reference to vertex term.
					//
					else
					{
						//
						// Handle node.
						//
						$fields = $mod;
						COntologyNode::ResolveClassContainer( $theConnection, TRUE )
							->ManageObject
							(
								$fields,				// Because it will be overwritten.
								$path[ $i ],						// Node identifier.
								kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_ADDSET	// Add.
							);
					
						//
						// Handle node term.
						//
						$fields = $mod;
						COntologyTerm::ResolveClassContainer( $theConnection, TRUE )
							->ManageObject
							(
								$fields,				// Because it will be overwritten.
								$node->Term(),						// Node term identifier.
								kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_ADDSET	// Add.
							);
					
					} // Inserting.
				
				} // Vertex.
			
			} // Iterating path elements.
		
		} // Insert or replace and not committed, or deleting.
		
	} // _PostcommitRelated.

	 

} // class COntologyTag.


?>

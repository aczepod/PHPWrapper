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
 * <h3>Ontology node object ancestor</h3>
 *
 * This class extends its ancestor, {@link CNode}, by asserting the {@link Term()} to be an
 * instance of {@link COntologyTerm} and by managing the {@link kOFFSET_REFS_NODE} offset
 * of the related {@link Term()}.
 *
 * The class does not handle global identifiers and objects cannot be uniquely identified
 * by its properties or attributes, it is the duty of the hosting container to provide the
 * {@link kOFFSET_NID} identifier, In this class we use sequences,
 * {@link CContainer::NextSequence()}, from a default container named after the default
 * {@link kCONTAINER_SEQUENCE_NAME} tag in the same database, this is to make referencing
 * nodes easier and to be compatible with most graph databases.
 *
 * In this class, the term, {@link kOFFSET_TERM}, is a reference to an instance of
 * {@link COntologyTerm}, meaning that the offset will contain the native identifier of the
 * term. The value may be provided as an uncommitted term object, in that case the term will
 * be committed before the current node is committed.
 *
 * Once the node has been committed, it will not be possible to modify the term,
 * {@link kOFFSET_TERM}. 
 *
 * When inserting a new node, the class will also make sure that the referenced term gets a
 * reference to the current node in its {@link kOFFSET_REFS_NODE} offset, this means that
 * once a node is committed, one cannot change its term reference.
 *
 * The class features an offset, {@link kOFFSET_REFS_TAG}, which represents the list of tags
 * that reference the current node. This offset is a set of tag identifiers implemented as
 * an array. The offset definition is borrowed from the {@link COntologyTerm} class, which
 * is required by this class because of its {@link kOFFSET_TERM} offset. This offset is
 * managed by the tag class, this class locks the offset.
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
 *		{@link kOFFSET_REFS_TAG}.
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
	 * @see kOFFSET_TERM
	 */
	public function LoadTerm( CConnection $theConnection, $doReload = FALSE )
	{
		//
		// Check offset.
		//
		if( $this->offsetExists( kOFFSET_TERM ) )
		{
			//
			// Refresh cache.
			// Uncommitted terms are cached by default.
			//
			if( $doReload						// Reload,
			 || ($this->mTerm === NULL) )	// or not cached.
			{
				//
				// Handle term object.
				//
				$term = $this->offsetGet( kOFFSET_TERM );
				if( $term instanceof COntologyTerm )
					return $term;													// ==>
				
				//
				// Load term object.
				//
				$this->mTerm
					= $this->NewObject
						( $this->ResolveTermContainer( $theConnection, TRUE ),
						  $term );
			
			} // Reload or empty cache.
			
			//
			// Handle not found.
			//
			if( $this->mTerm === NULL )
				throw new Exception
					( "Term not found",
					  kERROR_STATE );											// !@! ==>
		
		} // Has term.
		
		return $this->mTerm;													// ==>

	} // LoadTerm.

		

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
	 */
	static function DefaultContainer( CDatabase $theDatabase )
	{
		return $theDatabase->Container( kCONTAINER_NODE_NAME );						// ==>
	
	} // DefaultContainer.

	 
	/*===================================================================================
	 *	ResolveTermContainer															*
	 *==================================================================================*/

	/**
	 * <h4>Resolve term container</h4>
	 *
	 * This method should return the container used by terms, given a container used for
	 * nodes. For servers and databases, it will resolve the container using the term class
	 * static {@link ResolveContainer()} method, for containers, it will attempt to retrieve
	 * the database that instantiated the node container and feed it to the term's class
	 * {@link ResolveContainer()} method.
	 *
	 * If the method is unable to resolve the container it will raise an exception, if the
	 * second parameter is <tt>TRUE</tt>, or return <tt>NULL</tt>.
	 *
	 * The method will return an exception regardless of the value of the second parameter
	 * if the first parameter is neither a {@link CServer} or {@link CDatabase} derived
	 * instance.
	 *
	 * @param CConnection			$theConnection		Connection object.
	 * @param boolean				$doException		<tt>TRUE</tt> raise exception.
	 *
	 * @static
	 * @return mixed				{@link CContainer} or <tt>NULL</tt> if not found.
	 *
	 * @throws Exception
	 */
	static function ResolveTermContainer( CConnection $theConnection, $doException )
	{
		//
		// Handle containers.
		//
		if( $theConnection instanceof CContainer )
		{
			//
			// Get container's creator.
			//
			$database = $theConnection[ kOFFSET_PARENT ];
			if( $database !== NULL )
				return COntologyTerm::ResolveContainer( $database, $doException );	// ==>
			
			//
			// Raise exception.
			//
			if( $doException )
				throw new Exception
					( "The container is missing its database reference",
					  kERROR_PARAMETER );										// !@! ==>
			
			return NULL;															// ==>
		
		} // Provided container.
		
		return COntologyTerm::ResolveContainer( $theConnection, $doException );		// ==>
	
	} // ResolveTermContainer.

		

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
	 * @see kOFFSET_TERM kOFFSET_REFS_TAG
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
		// Handle term.
		//
		if( $theOffset == kOFFSET_TERM )
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
	 * In this class we prevent the modification of the {@link kOFFSET_TERM} offset if the
	 * object is committed and of the {@link kOFFSET_REFS_TAG} offset in all cases.
	 *
	 * @param reference			   &$theOffset			Offset.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 *
	 * @uses _IsCommitted()
	 *
	 * @see kOFFSET_TERM
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
		// Lock term if object is committed.
		//
		if( ($theOffset == kOFFSET_TERM)
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
			$term = $this->offsetGet( kOFFSET_TERM );
			if( $term instanceof COntologyTerm )
			{
				//
				// Commit.
				// Note that we insert, to ensure the object is new.
				//
				$term->Insert( $this->ResolveTermContainer( $theConnection, TRUE ) );
				
				//
				// Cache it.
				//
				$this->mTerm = $term;
				
				//
				// Set identifier in term offset.
				//
				$this->offsetSet( kOFFSET_TERM,
								  $term->offsetGet( kOFFSET_NID ) );
				
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
	 * {@link kOFFSET_GID}, since the {@link _index()} method returns <tt>NULL</tt> and
	 * also ignore the native identifier, {@link kOFFSET_NID}, since it will have been set
	 * here.
	 *
	 * @param reference			   &$theConnection		Server, database or container.
	 * @param reference			   &$theModifiers		Commit options.
	 *
	 * @access protected
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
				$this->offsetSet(
					kOFFSET_NID,
					$this->ResolveTermContainer(
						$theConnection, TRUE )
							->NextSequence( kSEQUENCE_KEY_NODE, TRUE ) );
		
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
	 * {@link kOFFSET_REFS_NODE}, in the related term when inserting; we remove the element
	 * when deleting.
	 *
	 * @param reference			   &$theConnection		Server, database or container.
	 * @param reference			   &$theModifiers		Commit options.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 *
	 * @uses _IsInited()
	 *
	 * @see kFLAG_PERSIST_WRITE_MASK
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
				// Set fields array (will receive updated object).
				//
				$fields = array( kOFFSET_REFS_NODE => $this->offsetGet( kOFFSET_NID ) );
				
				//
				// Add current node reference to term.
				//
				$this
					->ResolveTermContainer( $theConnection, TRUE )
					->ManageObject
					(
						$fields,						// Because it will be overwritten.
						$this->offsetGet( kOFFSET_TERM ),		// Term identifier.
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
			$fields = array( kOFFSET_REFS_NODE => $this->offsetGet( kOFFSET_NID ) );
			
			//
			// Remove current node reference from term.
			//
			$this
				->ResolveTermContainer( $theConnection, TRUE )
				->ManageObject
				(
					$fields,						// Because it will be overwritten.
					$this->offsetGet( kOFFSET_TERM ),		// Term identifier.
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

	 

} // class COntologyNode.


?>

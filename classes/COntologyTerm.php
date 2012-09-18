<?php

/**
 * <i>COntologyTerm</i> class definition.
 *
 * This file contains the class definition of <b>COntologyTerm</b> which represents the
 * ancestor of ontology term classes.
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 08/09/2012
 */

/*=======================================================================================
 *																						*
 *									COntologyTerm.php									*
 *																						*
 *======================================================================================*/

/**
 * Local definitions.
 *
 * This include file contains common offset definitions.
 */
require_once( "COntologyTerm.inc.php" );

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CTerm.php" );

/**
 * <h3>Ontology term object ancestor</h3>
 *
 * This class extends its ancestor, {@link CTerm}, by adding new rules and reference
 * management.
 *
 * In this class, the namespace, {@link kOFFSET_NAMESPACE}, is a reference to another object
 * derived from this class. This means that the offset will contain the native identifier of
 * the namespace term and that this namespace offset must reside in the same container as
 * the current term.
 *
 * The class features an offset, {@link kOFFSET_REFS_NAMESPACE}, that keeps a reference
 * count of how many times the current term has been referenced as namespace, that is, the
 * number of times this term was used as a namespace by other terms. This offset is updated
 * in the {@link _Postcommit()} method.
 *
 * The class features also two other offsets, {@link kOFFSET_REFS_NODE} and
 * {@link kOFFSET_REFS_TAG}, which collect respectively the list of node identifiers who
 * reference this term, and the list of tags that reference the term. These offsets are
 * managed by the referenced objects.
 *
 * The class implements the static method, {@link DefaultContainer()}, it will use the
 * {@link kCONTAINER_TERM_NAME} constant.
 *
 * The class features member accessor methods for the default offsets:
 *
 * <ul>
 *	<li>{@link NamespaceRefs()}: This method returns the term's namespace references,
 *		{@link kOFFSET_REFS_NAMESPACE}.
 *	<li>{@link NodeRefs()}: This method returns the term's node references,
 *		{@link kOFFSET_REFS_NODE}.
 *	<li>{@link TagRefs()}: This method returns the term's tag references,
 *		{@link kOFFSET_REFS_TAG}.
 *	<li>{@link LoadNamespace()}: This method will return the eventual namespace object
 *		pointed by {@link kOFFSET_NAMESPACE}.
 *		{@link kOFFSET_REFS_NAMESPACE}.
 * </ul>
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 */
class COntologyTerm extends CTerm
{
	/**
	 * <b>Namespace term object</b>
	 *
	 * This data member holds the eventual namespace term object when requested.
	 *
	 * @var COntologyTerm
	 */
	 protected $mNamespace = NULL;

		

/*=======================================================================================
 *																						*
 *								PUBLIC MEMBER INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	NamespaceRefs																	*
	 *==================================================================================*/

	/**
	 * <h4>Manage namespace references</h4>
	 *
	 * The <i>namespace references</i>, {@link kOFFSET_REFS_NAMESPACE}, holds an integer
	 * which represents the number of times the current term has been referenced as a
	 * namespace, that is, stored in the {@link kOFFSET_NAMESPACE} offset of another term.
	 *
	 * The method is read-only, because this value must be managed externally.
	 *
	 * @access public
	 * @return integer				Namespace reference count.
	 *
	 * @see kOFFSET_REFS_NAMESPACE
	 */
	public function NamespaceRefs()
	{
		//
		// Handle reference count.
		//
		if( $this->offsetExists( kOFFSET_REFS_NAMESPACE ) )
			return $this->offsetGet( kOFFSET_REFS_NAMESPACE );						// ==>
		
		return 0;																	// ==>

	} // NamespaceRefs.

	 
	/*===================================================================================
	 *	NodeRefs																		*
	 *==================================================================================*/

	/**
	 * <h4>Manage node references</h4>
	 *
	 * The <i>node references</i>, {@link kOFFSET_REFS_NODE}, holds a list of identifiers of
	 * nodes that reference the term.
	 *
	 * The method is read-only, because this value must be managed externally.
	 *
	 * @access public
	 * @return array				Nodes reference list.
	 *
	 * @see kOFFSET_REFS_NODE
	 */
	public function NodeRefs()
	{
		//
		// Handle reference count.
		//
		if( $this->offsetExists( kOFFSET_REFS_NODE ) )
			return $this->offsetGet( kOFFSET_REFS_NODE );							// ==>
		
		return Array();																// ==>

	} // NodeRefs.

	 
	/*===================================================================================
	 *	TagRefs																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage tag references</h4>
	 *
	 * The <i>tag references</i>, {@link kOFFSET_REFS_TAG}, holds a list of identifiers of
	 * tags that reference the term.
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
	 *	LoadNamespace																	*
	 *==================================================================================*/

	/**
	 * <h4>Load namespace object</h4>
	 *
	 * This method will return the current namespace term object: if the namespace is not
	 * set, the method will return <tt>NULL</tt>; if the namespace cannot be found, the
	 * method will raise an exception.
	 *
	 * The object will also be loaded in a data member that can function as a cache.
	 *
	 * The method features two parameters: the first refers to the container in which the
	 * namespace is stored, the second is a boolean flag that determines whether the object
	 * is to be read, or if the cached copy can be used.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param boolean				$doReload			Reload if <tt>TRUE</tt>.
	 *
	 * @access public
	 * @return COntologyTerm		Namespace object or <tt>NULL</tt>.
	 *
	 * @see kOFFSET_NAMESPACE
	 */
	public function LoadNamespace( CConnection $theConnection, $doReload = FALSE )
	{
		//
		// Check offset.
		//
		if( $this->offsetExists( kOFFSET_NAMESPACE ) )
		{
			//
			// Refresh cache.
			// Uncommitted namespaces are cached by default.
			//
			if( $doReload						// Reload,
			 || ($this->mNamespace === NULL) )	// or not cached.
			{
				//
				// Handle namespace object.
				//
				$namespace = $this->offsetGet( kOFFSET_NAMESPACE );
				if( $namespace instanceof self )
					return $namespace;												// ==>
				
				//
				// Load namespace object.
				//
				$this->mNamespace
					= $this->NewObject
						( $this->ResolveContainer( $theConnection, TRUE ),
						  $namespace );
			
			} // Reload or empty cache.
			
			//
			// Handle not found.
			//
			if( $this->mNamespace === NULL )
				throw new Exception
					( "Namespace not found",
					  kERROR_STATE );											// !@! ==>
		
		} // Has namespace.
		
		return $this->mNamespace;													// ==>

	} // LoadNamespace.

		

/*=======================================================================================
 *																						*
 *								STATIC CONTAINER INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	DefaultContainer																*
	 *==================================================================================*/

	/**
	 * <h4>Return the terms container</h4>
	 *
	 * The container will be created or fetched from the provided database using the
	 * {@link kCONTAINER_TERM_NAME} name.
	 *
	 * @param CDatabase				$theDatabase		Database object.
	 *
	 * @static
	 * @return CContainer			The terms container.
	 */
	static function DefaultContainer( CDatabase $theDatabase )
	{
		return $theDatabase->Container( kCONTAINER_TERM_NAME );						// ==>
	
	} // DefaultContainer.
		


/*=======================================================================================
 *																						*
 *								STATIC PERSISTENCE INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_id																				*
	 *==================================================================================*/

	/**
	 * <h4>Generate the object's native unique identifier</h4>
	 *
	 * We override this method to hash the native identifier.
	 *
	 * Since binary data is handled differently by each storage engine, we require the
	 * container parameter and raise an exception if not provided.
	 *
	 * We also raise an exception if the string is not provided, this is because this object
	 * primary key depends on the content of its attributes.
	 *
	 * @param string				$theIdentifier		Global unique identifier.
	 * @param CConnection			$theConnection		Server, database or container.
	 *
	 * @static
	 * @return mixed				The object's native unique identifier.
	 *
	 * @throws Exception
	 */
	static function _id( $theIdentifier = NULL, CConnection $theConnection = NULL )
	{
		//
		// Handle identifier.
		//
		if( $theIdentifier === NULL )
			throw new Exception
				( "Global unique identifier not provided",
				  kERROR_MISSING );												// !@! ==>
	
		//
		// Check container.
		//
		if( $theConnection === NULL )
			throw new Exception
				( "The container is needed for encoding binary strings",
				  kERROR_MISSING );												// !@! ==>
		
		return static::ResolveContainer( $theConnection, TRUE )
					 ->ConvertBinary( md5( $theIdentifier, TRUE ) );				// ==>
	
	} // _id.
		


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
	 * We override the inherited interface to handle the namespace global identifier: in
	 * this class the namespace is provided as a reference to another term object, this
	 * method needs to get the namespace's global identifier in order to generate the
	 * current term's global identifier.
	 *
	 * This method is called by the {@link CPersistentObject::_PrecommitIdentify()} method,
	 * at that point the namespace will have been loaded in the data member cache, so its
	 * global identifier will be available there.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param bitfield				$theModifiers		Commit options.
	 *
	 * @access protected
	 * @return string|NULL			The object's global unique identifier.
	 *
	 * @throws Exception
	 *
	 * @uses ResolveContainer()
	 */
	protected function _index( CConnection $theConnection, $theModifiers )
	{
		//
		// Handle namespace.
		//
		if( $this->offsetExists( kOFFSET_NAMESPACE ) )
			return $this->mNamespace->offsetGet( kOFFSET_GID )
				  .kTOKEN_NAMESPACE_SEPARATOR
				  .$this->offsetGet( kOFFSET_LID );									// ==>
		
		return $this->offsetGet( kOFFSET_LID );										// ==>
	
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
	 * In this class we prevent the modification of the three
	 * {@link kOFFSET_REFS_NAMESPACE}, {@link kOFFSET_REFS_NODE} and
	 * {@link kOFFSET_REFS_TAG} offsets in all cases, since they must be programmatically
	 * managed directly by the container and not through the object.
	 *
	 * We also handle the namespace offset, if provided as an object we leave it unchanged
	 * only if not yet committed, if not, we convert it to its native identifier. We also
	 * ensure the provided namespace object to be an instance of this class by asserting
	 * {@link CDocument} descendants to be of this class; any other type is assumed to be
	 * the namespace identifier.
	 *
	 * In this class the local identifier, {@link kOFFSET_LID}, is a string, in this method
	 * we cast the parameter to that type.
	 *
	 * @param reference			   &$theOffset			Offset.
	 * @param reference			   &$theValue			Value to set at offset.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 *
	 * @uses _AssertClass()
	 *
	 * @see kOFFSET_NAMESPACE kOFFSET_LID kOFFSET_NID
	 * @see kOFFSET_REFS_NAMESPACE kOFFSET_REFS_NODE kOFFSET_REFS_TAG
	 */
	protected function _Preset( &$theOffset, &$theValue )
	{
		//
		// Intercept reference offsets.
		//
		$offsets = array( kOFFSET_REFS_NAMESPACE, kOFFSET_REFS_NODE, kOFFSET_REFS_TAG );
		if( in_array( $theOffset, $offsets ) )
			throw new Exception
				( "The [$theOffset] offset cannot be modified",
				  kERROR_LOCKED );												// !@! ==>
		
		//
		// Cast local identifier.
		//
		if( ($theValue !== NULL )
		 && ($theOffset == kOFFSET_LID) )
			$theValue = (string) $theValue;
		
		//
		// Handle namespace.
		//
		if( $theOffset == kOFFSET_NAMESPACE )
		{
			//
			// Check value type.
			//
			$ok = $this->_AssertClass( $theValue, 'CDocument', __CLASS__ );
			
			//
			// Handle wrong object.
			//
			if( $ok === FALSE )
				throw new Exception
					( "Cannot set namespace: "
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
							( "Cannot set namespace: "
							 ."the object is missing its native identifier",
							  kERROR_PARAMETER );								// !@! ==>
				
				} // Namespace is committed.
				
				//
				// Copy to data member.
				//
				else
					$this->mNamespace = $theValue;
			
			} // Correct object class.
		
		} // Provided namespace.
		
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
	 * In this class we prevent the modification of the three
	 * {@link kOFFSET_REFS_NAMESPACE}, {@link kOFFSET_REFS_NODE} and
	 * {@link kOFFSET_REFS_TAG} offsets in all cases, since they must be programmatically
	 * managed directly by the container and not through the object.
	 *
	 * The parent class will take care of locking namespace and local identifier if the
	 * object is committed.
	 *
	 * @param reference			   &$theOffset			Offset.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 *
	 * @see kOFFSET_REFS_NAMESPACE kOFFSET_REFS_NODE kOFFSET_REFS_TAG
	 */
	protected function _Preunset( &$theOffset )
	{
		//
		// Intercept reference offsets.
		//
		$offsets = array( kOFFSET_REFS_NAMESPACE, kOFFSET_REFS_NODE, kOFFSET_REFS_TAG );
		if( in_array( $theOffset, $offsets ) )
			throw new Exception
				( "The [$theOffset] offset cannot be modified",
				  kERROR_LOCKED );												// !@! ==>
		
		//
		// Remove cached namespace.
		//
		if( $theOffset == kOFFSET_NAMESPACE )
			$this->mNamespace = NULL;
		
		//
		// Call parent method.
		// Will take care of kOFFSET_NAMESPACE and kOFFSET_NID.
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
	 * In this class we commit the eventual namespace term provided as an object or load
	 * the namespace if provided as an identifier.
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
			// Handle namespace.
			//
			if( $this->offsetExists( kOFFSET_NAMESPACE ) )
			{
				//
				// Handle namespace object.
				// Note that we let _Preset() method take care of the specific class.
				//
				$namespace = $this->offsetGet( kOFFSET_NAMESPACE );
				if( $namespace instanceof self )
				{
					//
					// Commit.
					// Note that we insert, to ensure the object is new.
					//
					$namespace->Insert( $theConnection );
					
					//
					// Cache it.
					//
					$this->mNamespace = $namespace;
					
					//
					// Set identifier in namespace.
					//
					$this->offsetSet( kOFFSET_NAMESPACE,
									  $namespace->offsetGet( kOFFSET_NID ) );
					
				} // Namespace is object.
				
				//
				// Handle namespace identifier.
				//
				else
					$this->LoadNamespace( $theConnection, TRUE );
			
			} // Has namespace.
		
		} // Not deleting.
	
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
	 * In this class we let the container increment the {@link kOFFSET_REFS_NAMESPACE} of
	 * the eventual namespace.
	 *
	 * @param reference			   &$theConnection		Server, database or container.
	 * @param reference			   &$theModifiers		Commit options.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 *
	 * @uses _IsCommitted()
	 * @uses _ReferenceNamespace()
	 *
	 * @see kOFFSET_NAMESPACE
	 * @see kFLAG_PERSIST_INSERT kFLAG_PERSIST_REPLACE kFLAG_PERSIST_DELETE
	 */
	protected function _PostcommitRelated( &$theConnection, &$theModifiers )
	{
		//
		// Call parent method.
		//
		parent::_PostcommitRelated( $theConnection, $theModifiers );
	
		//
		// Check namespace.
		//
		if( $this->offsetExists( kOFFSET_NAMESPACE ) )
		{
			//
			// Handle insert or replace.
			//
			if( (($theModifiers & kFLAG_PERSIST_MASK) == kFLAG_PERSIST_INSERT)
			 || (($theModifiers & kFLAG_PERSIST_MASK) == kFLAG_PERSIST_REPLACE) )
			{
				//
				// Handle uncommitted object.
				// Note that this status is set later.
				//
				if( ! $this->_IsCommitted() )
					$this->_ReferenceNamespace( $theConnection, 1 );
			
			} // Insert or replace.
			
			//
			// Check if deleting.
			//
			elseif( $theModifiers & kFLAG_PERSIST_DELETE )
				$this->_ReferenceNamespace( $theConnection, -1 );
		
		} // Has namespace.
		
	} // _PostcommitRelated.

	 
	/*===================================================================================
	 *	_PostcommitCleanup																*
	 *==================================================================================*/

	/**
	 * <h4>Cleanup the object after committing</h4>
	 *
	 * In this class we reset the namespace object cache, we set the data member to
	 * <tt>NULL</tt>, so that next time one wants to retrieve the namespace object, it will
	 * have to be refreshed and its references actualised.
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
		// Reset namespace cache.
		//
		$this->mNamespace = NULL;
	
	} // _PostcommitCleanup.

		

/*=======================================================================================
 *																						*
 *								PROTECTED REFERENCE INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_ReferenceNamespace																*
	 *==================================================================================*/

	/**
	 * <h4>Increment namespace term references</h4>
	 *
	 * This method can be used to increment the namespace reference count,
	 * {@link kOFFSET_REFS_NAMESPACE}, by providing a connection object and an increment
	 * delta.
	 *
	 * The method will return <tt>TRUE</tt> if the operation affected at least one object,
	 * <tt>FALSE</tt> if not, <tt>NULL</tt> if the current object has no namespace and raise
	 * an exception if the operation failed.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param integer				$theCount			Increment amount.
	 *
	 * @access protected
	 * @return mixed				<tt>TRUE</tt> operation affected at least one object.
	 *
	 * @uses ResolveContainer()
	 *
	 * @see kOFFSET_NAMESPACE kOFFSET_REFS_NAMESPACE
	 * @see kFLAG_PERSIST_MODIFY kFLAG_MODIFY_INCREMENT
	 */
	protected function _ReferenceNamespace( CConnection $theConnection, $theCount )
	{
		//
		// Check namespace.
		//
		if( $this->offsetExists( kOFFSET_NAMESPACE ) )
		{
			//
			// Set modification criteria.
			//
			$criteria = array( kOFFSET_REFS_NAMESPACE => (int) $theCount );
			
			//
			// Let container do the modification.
			//
			return $this
					->ResolveContainer( $theConnection, TRUE )
					->ManageObject
						(
							$criteria,
							$this->offsetGet( kOFFSET_NAMESPACE ),
							kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_INCREMENT
						);															// ==>
		
		} // Has namespace.
		
		return NULL;																// ==>
	
	} // _ReferenceNamespace.

	 

} // class COntologyTerm.


?>

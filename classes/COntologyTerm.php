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
 * In this class, the namespace, {@link kTAG_NAMESPACE}, is a reference to another object
 * derived from this class. This means that the offset will contain the native identifier of
 * the namespace term and that this namespace offset must reside in the same container as
 * the current term.
 *
 * The class features an offset, {@link kTAG_REFS_NAMESPACE}, that keeps a reference
 * count of how many times the current term has been referenced as namespace, that is, the
 * number of times this term was used as a namespace by other terms. This offset is updated
 * in the {@link _Postcommit()} method.
 *
 * The class features also two other offsets, {@link kTAG_REFS_NODE} and
 * {@link kTAG_REFS_TAG}, which collect respectively the list of node identifiers who
 * reference this term, and the list of tags that reference the term. These offsets are
 * managed by the referenced objects.
 *
 * This class prevents updating the full object once it has been inserted for the first
 * time. This behaviour is necessary because terms are referenced by many other objects, so
 * updating a full term object is risky, since it may have been updated elsewhere: for this
 * reason the {@link Update()} and {@link Replace()} methods will raise an exception.
 *
 * The class implements the static method, {@link DefaultContainer()}, it will use the
 * {@link kCONTAINER_TERM_NAME} constant.
 *
 * The class features member accessor methods for the default offsets:
 *
 * <ul>
 *	<li>{@link NamespaceRefs()}: This method returns the term's namespace references,
 *		{@link kTAG_REFS_NAMESPACE}.
 *	<li>{@link NodeRefs()}: This method returns the term's node references,
 *		{@link kTAG_REFS_NODE}.
 *	<li>{@link TagRefs()}: This method returns the term's tag references,
 *		{@link kTAG_REFS_TAG}.
 *	<li>{@link LoadNamespace()}: This method will return the eventual namespace object
 *		pointed by {@link kTAG_NAMESPACE}.
 *		{@link kTAG_REFS_NAMESPACE}.
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
	 *	NamespaceRefs																	*
	 *==================================================================================*/

	/**
	 * <h4>Manage namespace references</h4>
	 *
	 * The <i>namespace references</i>, {@link kTAG_REFS_NAMESPACE}, holds an integer
	 * which represents the number of times the current term has been referenced as a
	 * namespace, that is, stored in the {@link kTAG_NAMESPACE} offset of another term.
	 *
	 * The method is read-only, because this value must be managed externally.
	 *
	 * @access public
	 * @return integer				Namespace reference count.
	 *
	 * @see kTAG_REFS_NAMESPACE
	 */
	public function NamespaceRefs()
	{
		//
		// Handle reference count.
		//
		if( $this->offsetExists( kTAG_REFS_NAMESPACE ) )
			return $this->offsetGet( kTAG_REFS_NAMESPACE );							// ==>
		
		return 0;																	// ==>

	} // NamespaceRefs.

	 
	/*===================================================================================
	 *	NodeRefs																		*
	 *==================================================================================*/

	/**
	 * <h4>Manage node references</h4>
	 *
	 * The <i>node references</i>, {@link kTAG_REFS_NODE}, holds a list of identifiers of
	 * nodes that reference the term.
	 *
	 * The method is read-only, because this value must be managed externally.
	 *
	 * @access public
	 * @return array				Nodes reference list.
	 *
	 * @see kTAG_REFS_NODE
	 */
	public function NodeRefs()
	{
		//
		// Handle reference count.
		//
		if( $this->offsetExists( kTAG_REFS_NODE ) )
			return $this->offsetGet( kTAG_REFS_NODE );								// ==>
		
		return Array();																// ==>

	} // NodeRefs.

	 
	/*===================================================================================
	 *	TagRefs																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage tag references</h4>
	 *
	 * The <i>tag references</i>, {@link kTAG_REFS_TAG}, holds a list of identifiers of
	 * tags that reference the term.
	 *
	 * The method is read-only, because this value must be managed externally.
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
	 * @see kTAG_NAMESPACE
	 */
	public function LoadNamespace( CConnection $theConnection, $doReload = FALSE )
	{
		//
		// Check offset.
		//
		if( $this->offsetExists( kTAG_NAMESPACE ) )
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
				$namespace = $this->offsetGet( kTAG_NAMESPACE );
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
			if( $doReload						// Reload,
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
					= $this->NewObject
						( static::ResolveClassContainer( $theConnection, TRUE ),
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
		
		return $this->mTerm;														// ==>

	} // LoadTerm.

		

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
 *								STATIC MODIFICATION INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	HandleLabel																		*
	 *==================================================================================*/

	/**
	 * <h4>Modify label</h4>
	 *
	 * This method can be used to add or remove labels from a term, the method will not
	 * operate on the object directly, but rather let the container make the modification
	 * directly on the database.
	 *
	 * The method allows you to add or delete a specific label, it accepts the following
	 * parameters:
	 *
	 * <ul>
	 *	<li><tt>$theIdentifier</tt>: This parameter represents the term reference, it can be
	 *		provided as a term object, as the term native identifier or as the term global
	 *		identifier. If the term cannot be found, the method will raise an exception.
	 *	<li><tt>$theLanguage</tt>: Language code, <tt>NULL</tt> refers to the element
	 *		lacking the language code.
	 *	<li><tt>$theValue</tt>: The label string or the operation, depending on its value:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Return the string corresponding to the provided language.
	 *		<li><tt>FALSE</tt>: Delete the element corresponding to the provided language.
	 *		<li><i>other</i>: Any other value represents the label string that will be set
	 *			or replace the entry for the provided language.
	 *	 </ul>
	 * </ul>
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param mixed					$theIdentifier		Term reference.
	 * @param mixed					$theLanguage		Language code.
	 * @param mixed					$theValue			Label or operation.
	 *
	 * @static
	 * @return CContainer			The label.
	 */
	static function HandleLabel( CConnection $theConnection,
											 $theIdentifier,
											 $theLanguage = NULL, $theValue = NULL )
	{
		//
		// Check identifier.
		//
		if( $theIdentifier !== NULL )
		{
			//
			// Resolve term.
			//
			$theIdentifier = static::Resolve( $theConnection, $theIdentifier, NULL, TRUE );
			
			//
			// Handle label.
			//
			$status = $theIdentifier->Label( $theLanguage, $theValue );
			if( $theValue === NULL )
				return $status;														// ==>
			
			//
			// Here we know the label should be modified.
			//
			
			//
			// Resolve container.
			//
			$container = self::ResolveClassContainer( $theConnection, TRUE );
		
			//
			// Set modification criteria.
			//
			$mod = ( $theIdentifier->offsetExists( kTAG_LABEL ) )
				 ? array( kTAG_LABEL => $theIdentifier->offsetGet( kTAG_LABEL ) )
				 : array( kTAG_LABEL => NULL );
			
			//
			// Update object.
			//
			$container->ManageObject
							( $mod, $theIdentifier[ kOFFSET_NID ], kFLAG_PERSIST_MODIFY );
			
			return $mod;															// ==>

		} // Provided identifier.
		
		throw new Exception
			( "Missing term reference",
			  kERROR_PARAMETER );												// !@! ==>
	
	} // HandleLabel.

		

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
 *								STATIC RESOLUTION INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Resolve																			*
	 *==================================================================================*/

	/**
	 * <h4>Resolve a term</h4>
	 *
	 * This method can be used to locate a term given the attributes that comprise its
	 * identifier.
	 *
	 * The method accepts the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theConnection</tt>: This parameter represents the connection from which the
	 *		terms container must be resolved. If this parameter cannot be correctly
	 *		determined, the method will raise an exception.
	 *	<li><tt>$theIdentifier</tt>: This parameter can be the term native or global
	 *		identifier, if the namespace is not provided, or the local identifier if the
	 *		namespace is provided:
	 *	 <ul>
	 *		<li><i>Namespace provided:</i> The method will try to resolve the namespace and
	 *			combine the namespace global identifier with the provided local identifier
	 *			to locate the term.
	 *		<li><i>Namespace not provided:</i> If the namespace was not provided, the
	 *			method will perform the following queries in order:
	 *		 <ul>
	 *			<li><i>Native identifier:</i> The method will use the parameter as the
	 *				native identifier.
	 *			<li><i>Global identifier:</i> The method will use the term's
	 *				{@link COntologyTerm::_id()} method to convert the global identifier
	 *				into a native identifier.
	 *		 </ul>
	 *	 </ul>
	 *	<li><tt>$theNamespace</tt>: The term namespace:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: This indicates that either the term has no namespace, which
	 *			means that the first parameter must either be the native or global
	 *			identifier, or that the first parameter is all that is needed to locate the
	 *			term.
	 *		<li><tt>{@link COntologyTerm}</tt>: This type is expected to be the namespace
	 *			term object:
	 *		 <ul>
	 *			<li><i>Object is committed:</i> The method will use the namespace's global
	 *				identifier and concatenate it to the first parameter.
	 *			<li><i>Object is not committed:</i> The method will use the namespace's
	 *				global identifier; if that is missing, the method will either raise an
	 *				exception, or return <tt>NULL</tt>, depending on the third parameter.
	 *		 </ul>
	 *		<li><i>other</i>: Any other type is interpreted as the term native identifier;
	 *			if the namespace term cannot be found, the method will either raise an
	 *			exception, or return <tt>NULL</tt>, depending on the third parameter.
	 *	 </ul>
	 *	<li><tt>$doThrow</tt>: If <tt>TRUE</tt>, any failure to resolve the term or its
	 *			namespace, will raise an exception.
	 * </ul>
	 *
	 * The method will return the found term, <tt>NULL</tt> if not found, or raise an
	 * exception if the last parameter is <tt>TRUE</tt>.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param string				$theIdentifier		Term local identifier.
	 * @param mixed					$theNamespace		Namespace term reference.
	 * @param boolean				$doThrow			If <tt>TRUE</tt> raise an exception.
	 *
	 * @static
	 * @return COntologyTerm		Found term or <tt>NULL</tt>.
	 *
	 * @throws Exception
	 */
	static function Resolve( CConnection $theConnection, $theIdentifier,
										 $theNamespace = NULL, $doThrow = FALSE )
	{
		//
		// Check identifier.
		//
		if( $theIdentifier !== NULL )
		{
			//
			// Handle namespace.
			//
			if( $theNamespace !== NULL )
			{
				//
				// Locate namespace.
				//
				if( ! ($theNamespace instanceof CPersistentObject) )
				{
					//
					// Locate namespace.
					//
					$theNamespace = static::Resolve( $theConnection,
													 $theNamespace, NULL, $doThrow );
					if( $theNamespace === NULL )
						return NULL;												// ==>
				
				} // Provided namespace identifier.
			
				//
				// Handle missing namespace identifier.
				//
				if( ! $theNamespace->offsetExists( kTAG_GID ) )
				{
					if( $doThrow )
						throw new Exception
							( "Missing term namespace global identifier",
							  kERROR_PARAMETER );								// !@! ==>
					
					return NULL;													// ==>
				
				} // Missing namespace identifier.

				//
				// Build term identifier.
				//
				$id = static::_id( ($theNamespace->offsetGet( kTAG_GID )
										  .kTOKEN_NAMESPACE_SEPARATOR
										  .(string) $theIdentifier),
										  $theConnection );
				
				//
				// Locate term.
				//
				$term = static::NewObject( $theConnection, $id );
				if( $term !== NULL )
					return $term;													// ==>
				
				if( $doThrow )
					throw new Exception
						( "Term not found",
						  kERROR_NOT_FOUND );									// !@! ==>
				
				return NULL;														// ==>
			
			} // Provided namespace.
			
			//
			// Try native identifier.
			//
			$term = static::NewObject( $theConnection, $theIdentifier );
			if( $term !== NULL )
				return $term;														// ==>
			
			//
			// Try global identifier.
			//
			$term = static::NewObject( $theConnection,
									   static::_id( $theIdentifier, $theConnection ) );
			if( $term !== NULL )
				return $term;														// ==>
			
			if( $doThrow )
				throw new Exception
					( "Term not found",
					  kERROR_NOT_FOUND );										// !@! ==>
			
			return NULL;															// ==>
		
		} // Provided local or global identifier.
		
		throw new Exception
			( "Missing term reference",
			  kERROR_PARAMETER );													// !@! ==>

	} // Resolve.
		


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
					->ConvertValue( kTYPE_BINARY, md5( $theIdentifier, TRUE ) );	// ==>
	
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
		if( $this->offsetExists( kTAG_NAMESPACE ) )
			return $this->mNamespace->offsetGet( kTAG_GID )
				  .kTOKEN_NAMESPACE_SEPARATOR
				  .$this->offsetGet( kTAG_LID );									// ==>
		
		return $this->offsetGet( kTAG_LID );										// ==>
	
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
	 * {@link kTAG_REFS_NAMESPACE}, {@link kTAG_REFS_NODE} and
	 * {@link kTAG_REFS_TAG} offsets in all cases, since they must be programmatically
	 * managed directly by the container and not through the object.
	 *
	 * We also handle the namespace offset, if provided as an object we leave it unchanged
	 * only if not yet committed, if not, we convert it to its native identifier. We also
	 * ensure the provided namespace object to be an instance of this class by asserting
	 * {@link CDocument} descendants to be of this class; any other type is assumed to be
	 * the namespace identifier.
	 *
	 * In this class the local identifier, {@link kTAG_LID}, is a string, in this method we
	 * cast the parameter to that type.
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
	 * @see kTAG_NAMESPACE kTAG_LID kOFFSET_NID
	 * @see kTAG_REFS_NAMESPACE kTAG_REFS_NODE kTAG_REFS_TAG
	 */
	protected function _Preset( &$theOffset, &$theValue )
	{
		//
		// Intercept reference offsets.
		//
		$offsets = array( kTAG_REFS_NAMESPACE, kTAG_REFS_NODE, kTAG_REFS_TAG );
		if( in_array( $theOffset, $offsets ) )
			throw new Exception
				( "The [$theOffset] offset cannot be modified",
				  kERROR_LOCKED );												// !@! ==>
		
		//
		// Cast local identifier.
		//
		if( ($theValue !== NULL )
		 && ($theOffset == kTAG_LID) )
			$theValue = (string) $theValue;
		
		//
		// Handle namespace.
		//
		if( $theOffset == kTAG_NAMESPACE )
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
	 * In this class we prevent the modification of the three
	 * {@link kTAG_REFS_NAMESPACE}, {@link kTAG_REFS_NODE} and
	 * {@link kTAG_REFS_TAG} offsets in all cases, since they must be programmatically
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
	 * @see kTAG_REFS_NAMESPACE kTAG_REFS_NODE kTAG_REFS_TAG
	 */
	protected function _Preunset( &$theOffset )
	{
		//
		// Intercept reference offsets.
		//
		$offsets = array( kTAG_REFS_NAMESPACE, kTAG_REFS_NODE, kTAG_REFS_TAG );
		if( in_array( $theOffset, $offsets ) )
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
		// Remove cached namespace.
		//
		if( $theOffset == kTAG_NAMESPACE )
			$this->mNamespace = NULL;
		
		//
		// Call parent method.
		// Will take care of kTAG_NAMESPACE and kOFFSET_NID.
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
			if( $this->offsetExists( kTAG_NAMESPACE ) )
			{
				//
				// Handle namespace object.
				// Note that we let _Preset() method take care of the specific class.
				//
				$namespace = $this->offsetGet( kTAG_NAMESPACE );
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
					$this->offsetSet( kTAG_NAMESPACE,
									  $namespace->offsetGet( kOFFSET_NID ) );
					
				} // Namespace is object.
				
				//
				// Handle namespace identifier.
				//
				else
					$this->LoadNamespace( $theConnection, TRUE );
			
			} // Has namespace.
		
			//
			// Handle term object.
			// Note that we let _Preset() method take care of the specific class.
			//
			if( $this->offsetExists( kTAG_TERM ) )
			{
				//
				// Get term.
				//
				$term = $this->offsetGet( kTAG_TERM );
				if( $term instanceof COntologyTerm )
				{
					//
					// Commit.
					// Note that we insert, to ensure the object is new.
					//
					$term->Insert(
						static::ResolveClassContainer( $theConnection, TRUE ) );
					
					//
					// Cache it.
					//
					$this->mTerm = $term;
					
					//
					// Set identifier in term offset.
					//
					$this->offsetSet( kTAG_TERM,
									  $term->offsetGet( kOFFSET_NID ) );
					
				} // Term is object.
				
				//
				// Handle term identifier.
				//
				else
					$this->LoadTerm( $theConnection, TRUE );
			
			} // Has a term reference.
		
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
	 * In this class we let the container increment the {@link kTAG_REFS_NAMESPACE} of
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
	 * @see kTAG_NAMESPACE
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
		if( $this->offsetExists( kTAG_NAMESPACE ) )
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
	 * {@link kTAG_REFS_NAMESPACE}, by providing a connection object and an increment
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
	 * @see kTAG_NAMESPACE kTAG_REFS_NAMESPACE
	 * @see kFLAG_PERSIST_MODIFY kFLAG_MODIFY_INCREMENT
	 */
	protected function _ReferenceNamespace( CConnection $theConnection, $theCount )
	{
		//
		// Check namespace.
		//
		if( $this->offsetExists( kTAG_NAMESPACE ) )
		{
			//
			// Set modification criteria.
			//
			$criteria = array( kTAG_REFS_NAMESPACE => (int) $theCount );
			
			//
			// Let container do the modification.
			//
			return $this
					->ResolveContainer( $theConnection, TRUE )
					->ManageObject
						(
							$criteria,
							$this->offsetGet( kTAG_NAMESPACE ),
							kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_INCREMENT
						);															// ==>
		
		} // Has namespace.
		
		return NULL;																// ==>
	
	} // _ReferenceNamespace.

	 

} // class COntologyTerm.


?>

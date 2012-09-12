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
 * the current term. Namespaces can be provided as objects, provided that they have their
 * {@link _IsCommitted()} status set.
 *
 * The class features an offset, {@link kOFFSET_REFS_NAMESPACE}, that keeps a reference
 * count of how many times the current term has been referenced as namespace, that is, the
 * number of times this term was used as a namespace by other terms. This offset is updated
 * by the {@link _Postcommit()} method.
 *
 * The class features also two other offsets, {@link kOFFSET_REFS_NODE} and
 * {@link kOFFSET_REFS_TAG}, which collect respectively the list of node identifiers who
 * reference this term, and the list of tags that reference the term. These offsets are
 * managed by the referenced objects.
 *
 * The class implements the static method, {@link DefaultContainer()}, it will use the
 * {@link kCONTAINER_TERM_NAME} constant. You are encouraged to use this method rather than
 * instantiating the container by itself, since other classes rely on this method to access
 * terms.
 *
 * The class features member accessor methods for the default offsets:
 *
 * <ul>
 *	<li>{@link NamespaceRefs()}: This method returns the term's namespace references,
 *		{@link kOFFSET_REFS_NAMESPACE}.
 *	<li>{@link NodeRefs()}: This method returns the term's node references,
 *		{@link kOFFSET_REFS_NODE}.
 *	<li>{@link TagRefs()}: This method returns the term's namespace references,
 *		{@link kOFFSET_REFS_TAG}.
 * </ul>
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 */
class COntologyTerm extends CTerm
{
		

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
	 * The method is read-only, because this value must be managed internally.
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
	 * The method is read-only, because this value must be managed internally.
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
	 * The method is read-only, because this value must be managed internally.
	 *
	 * @access public
	 * @return array				Nodes reference list.
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
 *							PROTECTED IDENTIFICATION INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_index																			*
	 *==================================================================================*/

	/**
	 * <h4>Return the object's global unique identifier</h4>
	 *
	 * We override the inherited interface to handle namespaces provided as objects and
	 * namespaces provided as identifiers: in the first case we use its global identifier,
	 * since it is guaranteed that the namespace object was committed, to generate the
	 * current term's identifier and then convert the namespace to its native identifier, in
	 * the second case we need to load the namespace in order to use its global identifier.
	 *
	 * Note that if the local identifier is missing we call the parent's method, although
	 * this is not possible since it is asserted elsewhere in the workflow.
	 *
	 * @param CContainer			$theContainer		Container.
	 * @param bitfield				$theModifiers		Commit options.
	 *
	 * @access protected
	 * @return string|NULL			The object's global unique identifier.
	 *
	 * @throws Exception
	 *
	 * @uses _index()
	 */
	protected function _index( $theContainer, $theModifiers )
	{
		//
		// Get term local identifier.
		//
		if( $this->offsetExists( kOFFSET_LID ) )
		{
			//
			// Get code.
			//
			$code = (string) $this->offsetGet( kOFFSET_LID );
			
			//
			// Handle namespace.
			//
			if( $this->offsetExists( kOFFSET_NAMESPACE ) )
			{
				//
				// Get namespace.
				//
				$namespace = $this->offsetGet( kOFFSET_NAMESPACE );
				
				//
				// Handle identifier.
				//
				if( ! ($namespace instanceof CPersistentObject) )
				{
					//
					// Get namespace.
					//
					if( ! $theContainer->ManageObject
							( $ns, $namespace, array( kOFFSET_GID ) ) )
						throw new Exception
							( "Cannot commit object: "
							 ."the namespace cannot be found",
							  kERROR_STATE );									// !@! ==>
					
					//
					// Check global identifier.
					//
					if( ! array_key_exists( kOFFSET_GID, $ns ) )
						throw new Exception
							( "Cannot commit object: "
							 ."the namespace is missing its global identifier",
							  kERROR_STATE );									// !@! ==>
					
					//
					// Set global identifier.
					//
					$ns = $ns[ kOFFSET_GID ];
				
				} // As identifier.
				
				//
				// Handle object.
				//
				else
				{
					//
					// Save namespace global identifier.
					//
					$ns = (string) $namespace.
					
					//
					// Set offset to native identifier.
					//
					$this->offsetSet(
						kOFFSET_NAMESPACE,
						$namespace->offsetGet(
							kOFFSET_NID ) );
				
				} // As object.
				
				return $ns.kTOKEN_NAMESPACE_SEPARATOR.$code;						// ==>
			
			} // Has namespace.
			
			return $code;															// ==>
		
		} // Has local identifier.
		
		return parent::_index( $theContainer, $theModifiers );						// ==>
	
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
	 * {@link kOFFSET_REFS_TAG} offsets, since they must be programmatically set.
	 *
	 * We also handle the namespace offset, if provided as an object we leave it unchanged
	 * only if not yet committed, if not, we convert it to its native identifier. We also
	 * ensure the provided namespace object to be an instance of this class by asserting
	 * {@link CDocument} descendants to be of this class.
	 *
	 * @param reference			   &$theOffset			Offset.
	 * @param reference			   &$theValue			Value to set at offset.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 *
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
		// Handle namespace.
		//
		if( $theOffset == kOFFSET_NAMESPACE )
		{
			//
			// Handle object.
			//
			if( $theValue instanceof CPersistentDocument )
			{
				//
				// Assert it to be a term.
				//
				if( $theValue instanceof self )
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
								( "The namespace is missing its native identifier",
								  kERROR_PARAMETER );							// !@! ==>
					
					} // Namespace is committed.
				
				} // Provided as a term.
				
				else
					throw new Exception
						( "The namespace must be a term reference or object",
						  kERROR_PARAMETER );									// !@! ==>
			
			} // Provided as object.
		
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
	 * {@link kOFFSET_REFS_TAG} offsets, since they must be programmatically set.
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
		// Call parent method.
		//
		parent::_Preunset( $theOffset );
	
	} // _Preunset.
		


/*=======================================================================================
 *																						*
 *							PROTECTED PERSISTENCE INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_Precommit																		*
	 *==================================================================================*/

	/**
	 * <h4>Prepare the object before committing</h4>
	 *
	 * In this class we commit the eventual namespace term provided as an object and let
	 * the {@link _index()} method replace the offset with the namespace's native
	 * identifier.
	 *
	 * Note that if the provided namespace offset is not committed we ensure it is new by
	 * using the insert operation.
	 *
	 * @param CContainer			$theContainer		Container.
	 * @param bitfield				$theModifiers		Commit options.
	 *
	 * @access protected
	 */
	protected function _Precommit( CContainer $theContainer,
											  $theModifiers = kFLAG_DEFAULT )
	{
		//
		// Handle namespace.
		//
		if( $this->offsetExists( kOFFSET_NAMESPACE ) )
		{
			//
			// Get namespace.
			//
			$namespace = $this->offsetGet( kOFFSET_NAMESPACE );
		
			//
			// Commit it if object.
			// Note that we let _Preset() method take care of the specific class.
			// Note that we insert, to ensure the object is new.
			//
			if( ($namespace instanceof CPersistentObject)
			 && (! $namespace->_IsCommitted()) )
				$namespace->Insert( $theContainer );
		
		} // Has namespace.
		
		//
		// Call parent method.
		//
		parent::_Precommit( $theContainer, $theModifiers );
		
	} // _PreCommit.
		

	/*===================================================================================
	 *	_Postcommit																		*
	 *==================================================================================*/

	/**
	 * <h4>Prepare the object after committing</h4>
	 *
	 * In this class we increment the {@link kOFFSET_REFS_NAMESPACE} of the eventual
	 * namespace.
	 *
	 * @param CContainer			$theContainer		Container.
	 * @param bitfield				$theModifiers		Commit options.
	 *
	 * @access protected
	 */
	protected function _Postcommit( CContainer $theContainer,
											   $theModifiers = kFLAG_DEFAULT )
	{
		//
		// Check if not yet committed.
		// This actually means it was inserted...
		// This also is why we call this before the
		//
		if( ! $this->_IsCommitted() )
		{
			//
			// Increment namespace reference counter.
			//
			if( $this->offsetExists( kOFFSET_NAMESPACE ) )
			{
				$fields = array( kOFFSET_REFS_NAMESPACE => 1 );
				$theContainer->ManageObject
					(
						$fields,
						$this->offsetGet( kOFFSET_NAMESPACE ),
						kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_INCREMENT
					);
			}
		
		} // Not yet committed.
		
		//
		// Call parent method.
		//
		parent::_Postcommit( $theContainer, $theModifiers );
	
	} // _Postcommit.

	 

} // class COntologyTerm.


?>

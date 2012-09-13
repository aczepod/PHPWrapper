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
 * </ul>
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 */
class COntologyNode extends CNode
{
		

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
			// Lock offset if committed.
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
				
				} // term is committed.
			
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
		// Intercept namespace and local identifier.
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
 *							PROTECTED PERSISTENCE INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_Precommit																		*
	 *==================================================================================*/

	/**
	 * <h4>Prepare the object before committing</h4>
	 *
	 * In this class we commit the eventual term provided as an uncommitted object and
	 * replace the offset with the term's native identifier.
	 *
	 * Note that we need to get the terms container in order to commit the term, for this
	 * reason you should always instantiate containsers from a database, in that way it will
	 * be possible to get the container's database, {@link kOFFSET_PARENT}.
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
		// Handle term.
		//
		if( $this->offsetExists( kOFFSET_TERM ) )
		{
			//
			// Get term.
			//
			$term = $this->offsetGet( kOFFSET_TERM );
		
			//
			// Get term's container.
			//
			$database = $theContainer[ kOFFSET_PARENT ];
			if( $database !== NULL )
				$container = $class::DefaultContainer( $database );
			else
				throw new Exception
					( "The provided container is missing its database reference",
					  kERROR_PARAMETER );										// !@! ==>
			
			//
			// Handle term object.
			//
			if( $term instanceof CPersistentObject )
			{
				//
				// Commit term.
				//
				if( ! $term->_IsCommitted() )
					$term->Insert( $container );
				
				//
				// Set offset to native identifier.
				//
				$this->offsetSet(
					kOFFSET_TERM,
					$term->offsetGet(
						kOFFSET_NID ) );
			
			} // Term is object.
			
			//
			// Handle term identifier.
			//
			else
			{
				//
				// Check if term exists.
				//
				if( ! $container->CheckObject( $this->getOffset( kOFFSET_TERM ) ) )
					throw new Exception
						( "The node term cannot be found",
						  kERROR_PARAMETER );									// !@! ==>
			
			} // Term is identifier.
		
		} // Has term.
		
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
	 * In this class we add the reference of the current node 
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
		//
		if( ! $this->_IsCommitted() )
		{
			//
			// Add current node reference to term.
			//
			$mod = array( kOFFSET_REFS_NODE => $this->offsetGet( kOFFSET_NID ) );
			$theContainer->ManageObject
				(
					$mod,								// Because it will be overwritten.
					$this->offsetGet( kOFFSET_TERM ),		// Term identifier.
					kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_ADDSET	// Add to set.
				);
			
		} // Not yet committed.
		
		//
		// Check if deleting.
		//
		elseif( $theModifiers & kFLAG_PERSIST_DELETE )
		{
			//
			// Remove current node reference from term.
			//
			$mod = array( kOFFSET_REFS_NODE => $this->offsetGet( kOFFSET_NID ) );
			$theContainer->ManageObject
				(
					$mod,								// Because it will be overwritten.
					$this->offsetGet( kOFFSET_TERM ),		// Term identifier.
					kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_PULL	// Remove to occurrences.
				);
		
		} // Deleting.
		
		//
		// Call parent method.
		//
		parent::_Postcommit( $theContainer, $theModifiers );
	
	} // _Postcommit.

	 

} // class COntologyNode.


?>

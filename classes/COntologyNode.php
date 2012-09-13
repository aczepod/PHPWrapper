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
 * {@link COntologyTerm}, this means that the offset will contain the native identifier of
 * the term. The value may be provided as an uncommitted object, in that case the term will
 * be committed in the {@link _Precommit()} method.
 *
 * When inserting a new node, the class will also make sure that the referenced term gets a
 * reference to the current node in its {@link kOFFSET_REFS_NODE} offset.
 *
 * The class features a static method, {@link DefaultContainer()}, that can be used to
 * instantiate the default container for nodes, given a database. The method will use the
 * {@link kCONTAINER_NODE_NAME} constant as the container name. You are encouraged to use
 * this method rather than instantiating the container yourself, since other classes rely on
 * this method.
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 */
class COntologyNode extends CNode
{
		

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
	 * @param reference			   &$theOffset			Offset.
	 * @param reference			   &$theValue			Value to set at offset.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 *
	 * @see kOFFSET_TERM
	 */
	protected function _Preset( &$theOffset, &$theValue )
	{
		//
		// Handle term.
		//
		if( $theOffset == kOFFSET_TERM )
		{
			//
			// Handle object.
			//
			if( $theValue instanceof CPersistentDocument )
			{
				//
				// Assert it to be a term.
				//
				if( $theValue instanceof COntologyTerm )
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
								( "The term is missing its native identifier",
								  kERROR_PARAMETER );							// !@! ==>
					
					} // Namespace is committed.
				
				} // Provided as a term.
				
				else
					throw new Exception
						( "The term must be an ontology term reference or object",
						  kERROR_PARAMETER );									// !@! ==>
			
			} // Provided as object.
		
		} // Provided term.
		
		//
		// Call parent method.
		//
		parent::_Preset( $theOffset, $theValue );
	
	} // _Preset.
		


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

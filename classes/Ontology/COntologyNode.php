<?php namespace MyWrapper\Ontology;

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
 * Containers.
 *
 * This includes the container class definitions.
 */
use \MyWrapper\Framework\CContainer as CContainer;

/**
 * Terms.
 *
 * This includes the term class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/Ontology/COntologyTerm.php" );
use \MyWrapper\Ontology\COntologyTerm as COntologyTerm;

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/Framework/CNode.php" );
use \MyWrapper\Framework\CNode as CNode;

/**
 * <h3>Ontology node object ancestor</h3>
 *
 * This class extends its ancestor, {@link CNode}, by adding validation for term references:
 * all referenced terms must be in the form of {@link COntologyTerm} {@link kOFFSET_NID}
 * values.
 *
 * We also implement the reference count workflow for terms by incrementing and decrementing
 * the {@link kOFFSET_REFS_NODE} when inserting or deleting nodes.
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
	 *	Kind																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage node kind set</h4>
	 *
	 * We overload this method to check if the provided elements are {@link kOFFSET_NID} of
	 * {@link COntologyTerm}.
	 *
	 * @param mixed					$theValue			Value or index.
	 * @param mixed					$theOperation		Operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> native container.
	 */
	public function Kind( $theValue = NULL, $theOperation = NULL, $getOld = FALSE )
	{
		//
		// Intercept provided elements.
		//
		if( $theOperation
		 && ($theValue !== NULL) )
			$this->_CheckTermId( $theValue, TRUE );
		
		return ManageObjectSetOffset
			( $this, kOFFSET_KIND, $theValue, $theOperation, $getOld );				// ==>

	} // Kind.
		


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
	 * In this class we ensure that values arriving to the {@link kOFFSET_TERM} and
	 * {@link kOFFSET_TYPE} are the {@link kOFFSET_NID} of committed {@link COntologyTerm}.
	 *
	 * Note that this only means that we can intercept term objects and extract their ID.
	 *
	 * @param reference			   &$theOffset			Offset.
	 * @param reference			   &$theValue			Value to set at offset.
	 *
	 * @access protected
	 *
	 * @throws \Exception
	 *
	 * @see kOFFSET_NID kOFFSET_GID kOFFSET_LID
	 */
	protected function _Preset( &$theOffset, &$theValue )
	{
		//
		// Intercept identifiers.
		//
		$offsets = array( kOFFSET_TERM, kOFFSET_TYPE );
		if( in_array( $theOffset, $offsets ) )
			$this->_CheckTermId( $theValue, TRUE );
		
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
		//
		if( ! $this->_IsCommitted() )
		{
			//
			// Add current node reference to term.
			//
			if( $this->offsetExists( kOFFSET_NAMESPACE ) )
			{
				$offsets = array( kOFFSET_REFS_NAMESPACE => 1 );
				$theContainer->ManageObject
					(
						$offsets,
						$this->offsetGet( kOFFSET_NAMESPACE ),
						kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_INCREMENT
					);
			
			} // Has namespace.
		
		} // Not yet committed.
		
		//
		// Call parent method.
		//
		parent::_Postcommit( $theContainer, $theModifiers );
	
	} // _Postcommit.
		


/*=======================================================================================
 *																						*
 *									PROTECTED UTILITIES									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_CheckTermId																	*
	 *==================================================================================*/

	/**
	 * <h4>Ensure the provided parameter is a term identifier</h4>
	 *
	 * This method will check whether the provided value is suitable to be used as a term
	 * reference.
	 *
	 * A term reference should be the native identifier of a {@link COntologyTerm} instance,
	 * this can be ensured only if the provided value is an object of that class, in that
	 * case the identifier will replace the provided value; any other data type can only be
	 * assumed to be the identifier.
	 *
	 * The method will either raise an exception, if the second paraneter is <tt>TRUE</tt>,
	 * or return <tt>TRUE<tt> if the value passed the test and <tt>FALSE</tt> if not.
	 *
	 * @param reference			   &$theValue			Term reference.
	 * @param boolean				$doThrow			If <tt>TRUE</tt> throw exceptions.
	 *
	 * @access protected
	 * @return boolean
	 *
	 * @throws \Exception
	 */
	protected function _CheckTermId( &$theValue, $doThrow )
	{
		//
		// If object.
		//
		if( $theValue instanceof CPersistentObject )
		{
			//
			// Ensure it is a term.
			//
			if( $theValue instanceof COntologyTerm )
			{
				//
				// Check identifier.
				//
				if( $theValue->offsetExists( kOFFSET_NID ) )
					$theValue = $theValue->offsetGet( kOFFSET_NID );
				
				else
				{
					//
					// No exceptions.
					//
					if( ! $doThrow )
						return FALSE;												// ==>
					
					throw new \Exception
						( "The provided term is missing its identifier",
						  kERROR_PARAMETER );									// !@! ==>
				
				} // Not a term.
			
			} // Provided term.
			
			else
			{
				//
				// No exceptions.
				//
				if( ! $doThrow )
					return FALSE;													// ==>
				
				throw new \Exception
					( "The provided object must be a term",
					  kERROR_PARAMETER );										// !@! ==>
			
			} // Not a term.
		
		} // Provided object.
		
		return TRUE;																// ==>
	
	} // _CheckTermId.

	 

} // class COntologyNode.


?>

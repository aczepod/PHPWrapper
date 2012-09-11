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
 * Persistent object.
 *
 * This includes the container class definitions.
 */
use \MyWrapper\Persistence\CPersistentObject as CPersistentObject;

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
 * This class extends its ancestor, {@link CNode}, by ensuring that the node's term
 * reference, {@link kOFFSET_TERM}, is the identifier of a {@link COntologyTerm} object.
 *
 * When inserting a new node, the class will also make sure that the referenced term gets a
 * reference to the current node in its {@link kOFFSET_REFS_NODE} offset.
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 */
class COntologyNode extends CNode
{
		

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
		// Skip removals.
		//
		if( $theValue !== NULL )
		{
			//
			// Handle term reference.
			//
			if( $theOffset == kOFFSET_TERM )
				$this->_AssertObjectIdentifier( $theValue,
												'\MyWrapper\Ontology\COntologyTerm',
												TRUE );
		
		} // Setting a value.
		
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
					kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_PULL	// Remove to occurrances.
				);
		
		} // Deleting.
		
		//
		// Call parent method.
		//
		parent::_Postcommit( $theContainer, $theModifiers );
	
	} // _Postcommit.

	 

} // class COntologyNode.


?>

<?php namespace MyWrapper\Ontology;

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
 * Containers.
 *
 * This includes the container class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/Framework/CContainer.php" );
use \MyWrapper\Framework\CContainer as CContainer;

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/Framework/CTerm.php" );
use \MyWrapper\Framework\CTerm as CTerm;

/**
 * <h3>Ontology term object ancestor</h3>
 *
 * This class extends its ancestor, {@link CTerm}, by adding namespace reference counting
 * and namespace type control.
 *
 * The class features an offset, {@link kOFFSET_REFS_NAMESPACE}, that keeps a reference
 * count of how many times it has been referenced as namespace.
 *
 * The class features also two other offsets, {@link kOFFSET_REFS_NODE} and
 * {@link kOFFSET_REFS_TAG}, which collect respectively the list of node identifiers who
 * reference this term, and the list of tags that reference the term. The namespace
 * reference is managed by this class, the other two are managed by the node and tag
 * classes.
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
	 *	TagRefs																		*
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
		$offsets = array( kOFFSET_REFS_NAMESPACE, kOFFSET_REFS_NODE, kOFFSET_REFS_TAG );
		if( in_array( $theOffset, $offsets ) )
			throw new \Exception
				( "The [$theOffset] offset cannot be modified",
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
	 * In this class we prevent the modification of the three
	 * {@link kOFFSET_REFS_NAMESPACE}, {@link kOFFSET_REFS_NODE} and
	 * {@link kOFFSET_REFS_TAG} offsets, since they must be programmatically set.
	 *
	 * @param reference			   &$theOffset			Offset.
	 *
	 * @access protected
	 *
	 * @throws \Exception
	 *
	 * @uses _IsDirty()
	 */
	protected function _Preunset( &$theOffset )
	{
		//
		// Intercept identifiers.
		//
		$offsets = array( kOFFSET_REFS_NAMESPACE, kOFFSET_REFS_NODE, kOFFSET_REFS_TAG );
		if( in_array( $theOffset, $offsets ) )
			throw new \Exception
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
			// Increment namespace reference counter.
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

	 

} // class COntologyTerm.


?>

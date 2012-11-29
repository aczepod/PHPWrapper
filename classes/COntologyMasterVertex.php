<?php

/**
 * <i>COntologyMasterVertex</i> class definition.
 *
 * This file contains the class definition of <b>COntologyMasterVertex</b> which extends its
 * parent class to include attributes from the referenced term.
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 28/11/2012
 */

/*=======================================================================================
 *																						*
 *								COntologyMasterVertex.php								*
 *																						*
 *======================================================================================*/

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntologyMasterNode.php" );

/**
 * <h4>Ontology master vertex object</h4>
 *
 * This class extends the {@link COntologyMasterNode} class by including attributes of the
 * referenced {@link COntologyTerm} in the object. This will allow searching for master
 * nodes using term attributes without needing to do indirections.
 *
 * When inserting a new object, a selection of term attributes will first be copied to the
 * current object, then the node attributes will be copied, in case of conflicting
 * attributes it will be the node attribute that will overwrite the term attribute.
 *
 * We use the following term attributes: {@link kTAG_LID}, {@link kTAG_GID},
 * {@link kTAG_LABEL}, {@link kTAG_DESCRIPTION}, {@link kTAG_FEATURES} and
 * {@link kTAG_SCALES}. Compared to the {@link COntologyVertex} class, the two added
 * attributes allow referring to tags from the term, since the term is discriminating in
 * this class.
 *
 * All other functionalities are identical to the parent class.
 *
 * Note that this class should be implemented using PHP traits, this is a to-do.
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 */
class COntologyMasterVertex extends COntologyMasterNode
{
		

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
	 * We overload this method to compile the object's attributes, we first load the related
	 * term attributes, then we load the current node's attributes using the
	 * {@link _LoadTermAttributes()} method.
	 *
	 * This operation is done after calling the parent method and this method will do
	 * nothing when deleting.
	 *
	 * @param reference			   &$theConnection		Server, database or container.
	 * @param reference			   &$theModifiers		Commit options.
	 *
	 * @access protected
	 * @return mixed
	 *
	 * @uses LoadTerm()
	 *
	 * @see kTAG_TERM
	 */
	protected function _PrecommitRelated( &$theConnection, &$theModifiers )
	{
		//
		// Call parent method.
		//
		$status = parent::_PrecommitRelated( $theConnection, $theModifiers );
		if( $status !== NULL )
			return $status;															// ==>
		
		//
		// Not deleting.
		//
		if( ! ($theModifiers & kFLAG_PERSIST_DELETE) )
			$this->_LoadTermAttributes(
				array( kTAG_LID, kTAG_GID, kTAG_KIND,
					   kTAG_LABEL, kTAG_DESCRIPTION,
					   kTAG_FEATURES, kTAG_SCALES ) );
		
		return NULL;																// ==>
	
	} // _PrecommitRelated.

	 

} // class COntologyMasterVertex.


?>

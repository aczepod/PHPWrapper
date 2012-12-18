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
 * {@link kTAG_LABEL}, {@link kTAG_DEFINITION}, {@link kTAG_SYNONYMS}, {@link kTAG_FEATURES}
 * and {@link kTAG_SCALES}.
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
 *								PROTECTED REFERENCE INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_TermAttributes																	*
	 *==================================================================================*/

	/**
	 * <h4>List term attributes</h4>
	 *
	 * In this class we return:
	 *
	 * <ul>
	 *	<li><tt>{@link kTAG_LID}</tt>: The local identifier.
	 *	<li><tt>{@link kTAG_GID}</tt>: The global identifier.
	 *	<li><tt>{@link kTAG_LABEL}</tt>: The label.
	 *	<li><tt>{@link kTAG_DEFINITION}</tt>: The definition.
	 *	<li><tt>{@link kTAG_FEATURES}</tt>: The feature tag references.
	 *	<li><tt>{@link kTAG_SCALES}</tt>: The scale tag references.
	 * </ul>
	 *
	 * @access protected
	 * @return array
	 */
	protected function _TermAttributes()
	{
		return array( kTAG_LID, kTAG_GID,
					  kTAG_LABEL, kTAG_DEFINITION, kTAG_SYNONYMS,
					  kTAG_FEATURES, kTAG_SCALES );									// ==>
	
	} // _TermAttributes.

	 

} // class COntologyMasterVertex.


?>

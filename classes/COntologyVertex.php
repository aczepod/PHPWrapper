<?php

/**
 * <i>COntologyVertex</i> class definition.
 *
 * This file contains the class definition of <b>COntologyVertex</b> which represents the
 * ancestor of ontology node classes.
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 21/11/2012
 */

/*=======================================================================================
 *																						*
 *									COntologyVertex.php									*
 *																						*
 *======================================================================================*/

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntologyNode.php" );

/**
 * <h4>Ontology vertex object</h4>
 *
 * This class collects the {@link COntologyNode} attributes and the referenced
 * {@link COntologyTerm} attributes into a single object that has the same functionality as
 * this class ancestor, {@link COntologyNode}.
 *
 * When inserting a new object, this class will first load all the attributes of the
 * referenced {@link COntologyTerm}, then it will load the current node's attributes,
 * overwriting eventual matching attributes.
 *
 * The reason to have this class is be able to search nodes using term attributes without
 * needing to join the two containers.
 *
 * Because of this behaviour one should not update the object once it has been inserted,
 * rather, one should modify its attributes, since once the term and node properties are
 * mixed, it becomes difficult to discern to which term or node they belong.
 *
 * All other functionalities are identical to the parent class.
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 */
class COntologyVertex extends COntologyNode
{
		

/*=======================================================================================
 *																						*
 *							PROTECTED PRE-COMMIT INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_PrecommitIdentify																*
	 *==================================================================================*/

	/**
	 * <h4>Determine the identifier before committing</h4>
	 *
	 * We overload this method to compile the object's attributes, we first load the related
	 * term attributes, then we load the current node's attributes.
	 *
	 * We do not load the term's {@link kTAG_NAMESPACE} attribute.
	 *
	 * This operation is done before calling the parent method and this method will do
	 * nothing when deleting.
	 *
	 * @param reference			   &$theConnection		Server, database or container.
	 * @param reference			   &$theModifiers		Commit options.
	 *
	 * @access protected
	 *
	 * @see kOFFSET_NID kSEQUENCE_KEY_NODE
	 * @see kFLAG_PERSIST_INSERT kFLAG_PERSIST_REPLACE
	 */
	protected function _PrecommitIdentify( &$theConnection, &$theModifiers )
	{
		//
		// Handle insert or replace.
		//
		if( (($theModifiers & kFLAG_PERSIST_MASK) == kFLAG_PERSIST_INSERT)
		 || (($theModifiers & kFLAG_PERSIST_MASK) == kFLAG_PERSIST_REPLACE) )
		{
			//
			// Init local storage.
			//
			$properties = Array();
			$excluded = array( kOFFSET_NID, kTAG_NAMESPACE );
			
			//
			// Iterate term attributes.
			//
			foreach( $this->mTerm as $key => $value )
			{
				if( ! in_array( $key, $excluded ) )
					$properties[ $key ] = $value;
			}
			
			//
			// Iterate node attributes.
			//
			foreach( $this as $key => $value )
				$properties[ $key ] = $value;
			
			//
			// Replace attributes.
			//
			$this->exchangeArray( $properties );
		
		} // Insert or replace.
	
		//
		// Call parent method.
		//
		parent::_PrecommitIdentify( $theConnection, $theModifiers );
		
	} // _PrecommitIdentify.

	 

} // class COntologyVertex.


?>

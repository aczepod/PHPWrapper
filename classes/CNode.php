<?php

/**
 * <i>CNode</i> class definition.
 *
 * This file contains the class definition of <b>CNode</b> which represents the ancestor of
 * all node classes.
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 10/09/2012
 */

/*=======================================================================================
 *																						*
 *										CNode.php										*
 *																						*
 *======================================================================================*/

/**
 * Local definitions.
 *
 * This include file contains common offset definitions.
 */
require_once( "CNode.inc.php" );

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CPersistentObject.php" );

/**
 * <h3>Node object ancestor</h3>
 *
 * A node is an element of a tree or graph which is connected to other nodes through
 * edges, a node is a vertex of a relationship. This class concentrates in the core
 * features of the node, without taking into consideration the connections to other nodes.
 *
 * The node's main property is the term, {@link kOFFSET_TERM}, which defines the abstract
 * concept that the node represents: a term taken by itself is an abstract concept, when it
 * is referenced from a node which is related to other nodes through predicates, this term
 * takes a different meaning, it becomes a term in context. Terms are like vocabulary, taken
 * out of context they have a generalised meaning; put in context, they take a different
 * meaning depending in what position of a term chain they are positioned. In this class,
 * terms may hold any value.
 *
 * The node also features a {@link kOFFSET_KIND} property which is an enumerated set
 * describing the specific type, or the specific function of the node in its chain or
 * path.
 *
 * Finally, the class features the {@link kOFFSET_TYPE} property which defines the data type
 * of the node or the data unit it represents.
 *
 * This class does not feature attributes that can represent the unique identifier of the
 * object, this means that the container is responsible of providing the primary key of the
 * object.
 *
 * Nodes can be considered {@link _IsInited()} when they have the  {@link kOFFSET_TERM}
 * offset set. This and the other properties can be changed at any time, none are locked
 * once the object has been committed: it is the responsibility of the caller or of derived
 * classes to implement a locking rule.
 *
 * The class features member accessor methods for the default offsets:
 *
 * <ul>
 *	<li>{@link Term()}: This method manages the node's term, {@link kOFFSET_TERM}.
 *	<li>{@link Kind()}: This method manages the node's kind, {@link kOFFSET_KIND}.
 *	<li>{@link Type()}: This method manages the node's type, {@link kOFFSET_TYPE}.
 * </ul>
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 */
class CNode extends CPersistentObject
{
		

/*=======================================================================================
 *																						*
 *								PUBLIC MEMBER INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Term																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage node term</h4>
	 *
	 * This method can be used to manage the node's term, {@link kOFFSET_TERM}, which
	 * represents the node abstract term.
	 *
	 * The method accepts a parameter which represents either the term, or the requested
	 * operation, depending on its value:
	 *
	 * <ul>
	 *	<li><tt>NULL</tt>: Return the current value.
	 *	<li><tt>FALSE</tt>: Delete the current value.
	 *	<li><i>other</i>: Set the value with the provided parameter.
	 * </ul>
	 *
	 * The second parameter is a boolean which if <tt>TRUE</tt> will return the <i>old</i>
	 * value when replacing containers; if <tt>FALSE</tt>, it will return the currently set
	 * value.
	 *
	 * @param mixed					$theValue			Term or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> native container.
	 *
	 * @uses ManageOffset()
	 *
	 * @see kOFFSET_TERM
	 */
	public function Term( $theValue = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kOFFSET_TERM, $theValue, $getOld );				// ==>

	} // Term.

		
	/*===================================================================================
	 *	Kind																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage node kind set</h4>
	 *
	 * The node kind set, {@link kOFFSET_KIND}, holds a list of unique values that represent
	 * the different kinds or types associated with the current node. The type,
	 * {@link Type()}, of a node is a general qualification that applies to any class of
	 * object, such as a data type; the kind, instead, refers to a qualification specific to
	 * the current class of object.
	 *
	 * This offset collects the list of these qualifications in an enumerated set that can
	 * be managed with the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theValue</tt>: Depending on the next parameter, this may either refer to
	 *		the value to be set or to the index of the element to be retrieved or deleted:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: This value indicates that we want to operate on all elements,
	 *			which means, in practical terms, that we either want to retrieve or delete
	 *			the full list. If the operation parameter resolves to <tt>TRUE</tt>, the
	 *			method will default to retrieving the current list and no new element will
	 *			be added.
	 *		<li><tt>array</tt>: An array indicates that we want to operate on a list of
	 *			values and that other parameters may also be provided as lists. Note that
	 *			{@link ArrayObject} instances are not considered here as arrays.
	 *		<li><i>other</i>: Any other type represents either the new value to be added or
	 *			the index to the value to be returned or deleted.
	 *	 </ul>
	 *	<li><tt>$theOperation</tt>: This parameter represents the operation to be performed
	 *		whose scope depends on the value of the previous parameter:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Return the element or full list.
	 *		<li><tt>FALSE</tt>: Delete the element or full list.
	 *		<li><tt>array</tt>: This type is only considered if the <tt>$theValue</tt>
	 *			parameter is provided as an array: the method will be called for each
	 *			element of the <tt>$theValue</tt> parameter matched with the corresponding
	 *			element of this parameter, which also means that both both parameters must
	 *			share the same count.
	 *		<li><i>other</i>: Add the <tt>$theValue</tt> value to the list. If you provided
	 *			<tt>NULL</tt> in the previous parameter, the operation will be reset to
	 *			<tt>NULL</tt>.
	 *	 </ul>
	 *	<li><tt>$getOld</tt>: Determines what the method will return:
	 *	 <ul>
	 *		<li><tt>TRUE</tt>: Return the value <i>before</i> it was eventually modified.
	 *		<li><tt>FALSE</tt>: Return the value <i>after</i> it was eventually modified.
	 *	 </ul>
	 * </ul>
	 *
	 * @param mixed					$theValue			Value or index.
	 * @param mixed					$theOperation		Operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> native container.
	 *
	 * @uses ManageObjectSetOffset()
	 *
	 * @see kOFFSET_KIND
	 */
	public function Kind( $theValue = NULL, $theOperation = NULL, $getOld = FALSE )
	{
		return ManageObjectSetOffset
			( $this, kOFFSET_KIND, $theValue, $theOperation, $getOld );				// ==>

	} // Kind.

	 
	/*===================================================================================
	 *	Type																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage node type</h4>
	 *
	 * This method can be used to manage the node's type, {@link kOFFSET_TYPE}, which is an
	 * enumerated value that represents the data type or unit of the node.
	 *
	 * The method accepts a parameter which represents either the type, or the requested
	 * operation, depending on its value:
	 *
	 * <ul>
	 *	<li><tt>NULL</tt>: Return the current value.
	 *	<li><tt>FALSE</tt>: Delete the current value.
	 *	<li><i>other</i>: Set the value with the provided parameter.
	 * </ul>
	 *
	 * The second parameter is a boolean which if <tt>TRUE</tt> will return the <i>old</i>
	 * value when replacing containers; if <tt>FALSE</tt>, it will return the currently set
	 * value.
	 *
	 * @param mixed					$theValue			Type or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> native container.
	 *
	 * @uses ManageOffset()
	 *
	 * @see kOFFSET_TYPE
	 */
	public function Type( $theValue = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kOFFSET_TYPE, $theValue, $getOld );				// ==>

	} // Type.
		


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
	 * In this class we ensure that the {@link kOFFSET_KIND} offset is an array, ArrayObject
	 * instances are not counted as an array.
	 *
	 * @param reference			   &$theOffset			Offset.
	 * @param reference			   &$theValue			Value to set at offset.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 *
	 * @uses _IsCommitted()
	 *
	 * @see kOFFSET_TERM
	 */
	protected function _Preset( &$theOffset, &$theValue )
	{
		//
		// Ensure kind is array.
		//
		if( ($theOffset == kOFFSET_KIND)
		 && ($theValue !== NULL)
		 && (! is_array( $theValue )) )
			throw new Exception
				( "Invalid type for the [$theOffset] offset: "
				 ."it must be an array",
				  kERROR_PARAMETER );											// !@! ==>
		
		//
		// Call parent method.
		//
		parent::_Preset( $theOffset, $theValue );
	
	} // _Preset.
		


/*=======================================================================================
 *																						*
 *								PROTECTED STATUS INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_Ready																			*
	 *==================================================================================*/

	/**
	 * <h4>Determine if the object is ready</h4>
	 *
	 * In this class we tie the {@link _IsInited()} status to the presence or absence of the
	 * {@link kOFFSET_TERM} offset.
	 *
	 * @access protected
	 * @return boolean				<tt>TRUE</tt> means {@link _IsInited( <tt>TRUE</tt> ).
	 *
	 * @see kOFFSET_TERM
	 */
	protected function _Ready()
	{
		//
		// Check parent.
		//
		if( parent::_Ready() )
			return $this->offsetExists( kOFFSET_TERM );								// ==>
		
		return FALSE;																// ==>
	
	} // _Ready.

	 

} // class CNode.


?>

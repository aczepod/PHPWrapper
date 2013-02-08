<?php

/**
 * <i>TRepresentation</i> trait definition.
 *
 * This file contains the trait definition of <b>TRepresentation</b> which collects all
 * common representation accessor methods.
 *
 *	@package	MyWrapper
 *	@subpackage	Traits
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 24/01/2013
 */

/*=======================================================================================
 *																						*
 *									TRepresentation.php									*
 *																						*
 *======================================================================================*/

/**
 * Tags.
 *
 * This includes the default tag definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_DEFINE."/Tags.inc.php" );

/**
 * Inputs.
 *
 * This includes the default input definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_DEFINE."/Inputs.inc.php" );

/**
 * Accessors.
 *
 * This include file contains all accessor function definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_FUNCTION."/accessors.php" );

/**
 * <h4>Common representation members</h4>
 *
 * This trait implements a collection of accessor methods covering the set of qualification
 * attributes which determine the kind of control that should be used to display and modify
 * the property value, and the set of rules by which a value may be considered valid or not:
 *
 * <ul>
 *	<li><tt>{@link Input()}</tt>: The <i>input</i>, {@link kTAG_INPUT}, represents a set
 *		of values which list the suggested or preferred control types that should be used
 *		to display and modify an object property.
 *	<li><tt>{@link Pattern()}</tt>: The <i>pattern</i>, {@link kTAG_PATTERN}, represents a
 *		regular expression that can be used to validate the input of an attribute's value.
 *	<li><tt>{@link Length()}</tt>: The <i>length</i>, {@link kTAG_LENGTH}, represents the
 *		maximum number of characters a value may hold.
 *	<li><tt>{@link LowerBound()}</tt>: The <i>lower bound</i>, {@link kTAG_MIN_VAL},
 *		represents the lowest limit a range value may take.
 *	<li><tt>{@link UpperBound()}</tt>: The <i>upper bound</i>, {@link kTAG_MAX_VAL},
 *		represents the highest limit a range value may take.
 *	<li><tt>{@link Example()}</tt>: The <i>examples</i>, {@link kTAG_EXAMPLES}, represents
 *		a list of values that can be used as examples which follow a set of validation
 *		rules.
 * </ul>
 *
 *	@package	MyWrapper
 *	@subpackage	Traits
 */
trait TRepresentation
{
		

/*=======================================================================================
 *																						*
 *								PUBLIC MEMBER INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Input																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage node input type enumeration</h4>
	 *
	 * This method can be used to manage an attribute's's input type, {@link kTAG_INPUT},
	 * which is an enumerated value that represents the suggested or preferred input
	 * control type to be used in forms when modifying the value of the referenced property.
	 *
	 * The method accepts a parameter which represents either the input type or the
	 * requested operation, depending on its value::
	 *
	 * <ul>
	 *	<li><tt>NULL</tt>: Return the current value.
	 *	<li><tt>FALSE</tt>: Delete the current value.
	 *	<li><i>other</i>: Set the value with the provided parameter.
	 * </ul>
	 *
	 * @param mixed					$theValue			Native identifier or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return string				<i>New</i>, <i>old</i> value or <tt>NULL</tt>.
	 *
	 * @uses ManageOffset()
	 *
	 * @see kTAG_INPUT
	 */
	public function Input( $theValue = NULL, $theOperation = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kTAG_INPUT, $theValue, $getOld );				// ==>

	} // Input.

	 
	/*===================================================================================
	 *	Pattern																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage validation pattern</h4>
	 *
	 * The <i>validation pattern</i>, {@link kTAG_PATTERN}, holds a string which is the
	 * regular expression string that can be used to validate the value of the referenced
	 * property.
	 *
	 * The method accepts a parameter which represents either the identifier or the
	 * requested operation, depending on its value:
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
	 * @param mixed					$theValue			Native identifier or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return string				<i>New</i>, <i>old</i> value or <tt>NULL</tt>.
	 *
	 * @uses ManageOffset()
	 *
	 * @see kTAG_PATTERN
	 */
	public function Pattern( $theValue = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kTAG_PATTERN, $theValue, $getOld );				// ==>

	} // Pattern.

	 
	/*===================================================================================
	 *	Length																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage value length</h4>
	 *
	 * The <i>length limit</i>, {@link kTAG_LENGTH}, holds an integer value which indicates
	 * the maximum numer of characters that the value of the referenced property may take.
	 *
	 * This attribute is relevant only for nodes that are of the {@link kKIND_SCALE} kind,
	 * which represent the scale element of a {@link COntologyTag}.
	 *
	 * The method accepts a parameter which represents either the identifier or the
	 * requested operation, depending on its value:
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
	 * Note that when the object has the {@link _IsCommitted()} status this offset will be
	 * locked and an exception will be raised.
	 *
	 * @param mixed					$theValue			Native identifier or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return integer				<i>New</i>, <i>old</i> value or <tt>NULL</tt>.
	 *
	 * @uses ManageOffset()
	 *
	 * @see kTAG_LENGTH
	 */
	public function Length( $theValue = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kTAG_LENGTH, $theValue, $getOld );				// ==>

	} // Length.

	 
	/*===================================================================================
	 *	LowerBound																		*
	 *==================================================================================*/

	/**
	 * <h4>Manage lower bound</h4>
	 *
	 * The <i>lower bound</i>, {@link kTAG_MIN_VAL}, holds the lower bound of the range of
	 * values that the value of the referenced property may take. Any value below this one
	 * is considered invalid.
	 *
	 * This attribute is relevant only for nodes that are of the {@link kKIND_SCALE} kind,
	 * which represent the scale element of a {@link COntologyTag}.
	 *
	 * The method accepts a parameter which represents either the identifier or the
	 * requested operation, depending on its value:
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
	 * Note that when the object has the {@link _IsCommitted()} status this offset will be
	 * locked and an exception will be raised.
	 *
	 * @param mixed					$theValue			Native identifier or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i>, <i>old</i> value or <tt>NULL</tt>.
	 *
	 * @uses ManageOffset()
	 *
	 * @see kTAG_MIN_VAL
	 */
	public function LowerBound( $theValue = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kTAG_MIN_VAL, $theValue, $getOld );				// ==>

	} // LowerBound.

	 
	/*===================================================================================
	 *	UpperBound																		*
	 *==================================================================================*/

	/**
	 * <h4>Manage upper bound</h4>
	 *
	 * The <i>upper bound</i>, {@link kTAG_MAX_VAL}, holds the upper bound of the range of
	 * values that the value of the referenced property may take. Any value above this one
	 * is considered invalid.
	 *
	 * This attribute is relevant only for nodes that are of the {@link kKIND_SCALE} kind,
	 * which represent the scale element of a {@link COntologyTag}.
	 *
	 * The method accepts a parameter which represents either the identifier or the
	 * requested operation, depending on its value:
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
	 * Note that when the object has the {@link _IsCommitted()} status this offset will be
	 * locked and an exception will be raised.
	 *
	 * @param mixed					$theValue			Native identifier or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i>, <i>old</i> value or <tt>NULL</tt>.
	 *
	 * @uses ManageOffset()
	 *
	 * @see kTAG_MAX_VAL
	 */
	public function UpperBound( $theValue = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kTAG_MAX_VAL, $theValue, $getOld );				// ==>

	} // UpperBound.

	 
	/*===================================================================================
	 *	Example																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage examples</h4>
	 *
	 * The <i>examples</i>, {@link kTAG_EXAMPLES}, is a list of strings representing usage
	 * and examples of values following the current attribute's definition.
	 *
	 * This offset collects the list of examples in list that can be managed with the
	 * following parameters:
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
	 * @return string				<i>New</i>, <i>old</i> value or <tt>NULL</tt>.
	 *
	 * @uses ManageObjectSetOffset()
	 *
	 * @see kTAG_EXAMPLES
	 */
	public function Example( $theValue = NULL, $theOperation = NULL, $getOld = FALSE )
	{
		return ManageObjectSetOffset
			( $this, kTAG_SYNONYMS, $theValue, $theOperation, $getOld );			// ==>

	} // Example.

	 

} // trait TIdentification.


?>

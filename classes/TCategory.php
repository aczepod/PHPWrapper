<?php

/**
 * <i>TCategory</i> trait definition.
 *
 * This file contains the trait definition of <b>TCategory</b> which collects all common
 * category accessor methods.
 *
 *	@package	MyWrapper
 *	@subpackage	Traits
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 23/01/2013
 */

/*=======================================================================================
 *																						*
 *									TCategory.php										*
 *																						*
 *======================================================================================*/

/**
 * Tags.
 *
 * This includes the default tag definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_DEFINE."/Tags.inc.php" );

/**
 * Accessors.
 *
 * This include file contains all accessor function definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_FUNCTION."/accessors.php" );

/**
 * <h4>Common category members</h4>
 *
 * This trait implements a collection of accessor methods covering the common category
 * properties of persistent objects:
 *
 * <ul>
 *	<li><tt>{@link Category()}</tt>: The <i>categories</i>, {@link kTAG_CATEGORY},
 *		represent a set of values that constitute the category of the hosting object.
 *	<li><tt>{@link Kind()}</tt>: The <i>kinds</i>, {@link kTAG_KIND}, represent a set of
 *		enumerations that represent the kind of of the hosting object.
 *	<li><tt>{@link Type()}</tt>: The <i>types</i>, {@link kTAG_TYPE}, represent a set of
 *		enumerations that represent the type of of the hosting object.
 * </ul>
 *
 *	@package	MyWrapper
 *	@subpackage	Traits
 */
trait TCategory
{
		

/*=======================================================================================
 *																						*
 *								PUBLIC MEMBER INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Category																		*
	 *==================================================================================*/

	/**
	 * <h4>Manage categories</h4>
	 *
	 * The <i>category</i>, {@link kTAG_CATEGORY}, holds a set of strings which represent
	 * the categories or classification to which the object belongs to.
	 *
	 * The elements of this set may either be a controlled vocabulary or a series of
	 * colloquial language terms, no two elements of the set may be the same.
	 *
	 * This enumerated set is managed with the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theValue</tt>: Depending on the next parameter, this may either refer to
	 *		the value to be set or to the index of the element to be retrieved or deleted:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: This value indicates that we want to operate on all elements,
	 *			which means that we either want to retrieve or delete the full list. If the
	 *			operation parameter resolves to <tt>TRUE</tt>, the method will default to
	 *			retrieving the current list and no new element will be added; if the
	 *			operation parameter resolves to <tt>FALSE</tt>, the method will delete the
	 *			full list and the method will return the old list or <tt>NULL</tt>,
	 *			depending on the last parameter.
	 *		<li><tt>array</tt>: An array indicates that we want to operate on a list of
	 *			values and that other parameters may also be provided as lists. Note that
	 *			{@link ArrayObject} instances are not considered here as arrays.
	 *		<li><i>other</i>: Any other type represents either the new value to be added or
	 *			the index to the value to be retrieved or deleted.
	 *	 </ul>
	 *	<li><tt>$theOperation</tt>: This parameter represents the operation to be performed
	 *		whose scope depends on the value of the previous parameter:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Return the full list if the first parameter is <tt>NULL</tt>;
	 *			return the elements matching the provided list if the first parameter is an
	 *			array; return the element matching the string provided in the first
	 *			parameter.
	 *		<li><tt>FALSE</tt>: Delete the full list if the first parameter is
	 *			<tt>NULL</tt>; delete the elements matching the provided list if the first
	 *			parameter is an array; delete the element matching the string provided in
	 *			the first parameter.
	 *		<li><tt>array</tt>: This type is only considered if the first parameter is
	 *			provided also as an array: the method will iteratively be called with each
	 *			element of the first and second parameter and the result will be an array
	 *			containing the returned value of each iteration. This also means that both
	 *			the first and second parameters must share the same count.
	 *		<li><i>other</i>: Add the value of the first parameter to the set. If you
	 *			provided <tt>NULL</tt> in the first parameter, this parameter will also be
	 *			reset to <tt>NULL</tt>.
	 *	 </ul>
	 *	<li><tt>$getOld</tt>: Determines what the method will return:
	 *	 <ul>
	 *		<li><tt>TRUE</tt>: Return the value <i>before</i> it was eventually modified.
	 *		<li><tt>FALSE</tt>: Return the value <i>after</i> it was eventually modified.
	 *	 </ul>
	 * </ul>
	 *
	 * Note that, while this method allows the creation, modification and deletion of this
	 * property, the hosting object may prevent such actions in particular cases.
	 *
	 * @param mixed					$theValue			Value or element index.
	 * @param mixed					$theOperation		Operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access public
	 * @return string				<i>New</i>, <i>old</i> value or <tt>NULL</tt>.
	 *
	 * @uses ManageObjectSetOffset()
	 *
	 * @see kTAG_CATEGORY
	 */
	public function Category( $theValue = NULL, $theOperation = NULL, $getOld = FALSE )
	{
		return ManageObjectSetOffset
			( $this, kTAG_CATEGORY, $theValue, $theOperation, $getOld );			// ==>

	} // Category.

	 
	/*===================================================================================
	 *	Kind																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage kinds</h4>
	 *
	 * The <i>kind</i>, {@link kTAG_KIND}, holds a set of strings which represent
	 * the different kinds associated with the current object. This set of enumerations
	 * refer to the qualifications specific to the current class of the object.
	 *
	 * In other words: the kind tells you what a property is, the type tells you what a
	 * property holds.
	 *
	 * The elements of this set should belong to a controlled vocabulary set and consist of
	 * the global identifier, {@link kTAG_GID}, of a term.
	 *
	 * This enumerated set is managed with the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theValue</tt>: Depending on the next parameter, this may either refer to
	 *		the value to be set or to the index of the element to be retrieved or deleted:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: This value indicates that we want to operate on all elements,
	 *			which means that we either want to retrieve or delete the full list. If the
	 *			operation parameter resolves to <tt>TRUE</tt>, the method will default to
	 *			retrieving the current list and no new element will be added; if the
	 *			operation parameter resolves to <tt>FALSE</tt>, the method will delete the
	 *			full list and the method will return the old list or <tt>NULL</tt>,
	 *			depending on the last parameter.
	 *		<li><tt>array</tt>: An array indicates that we want to operate on a list of
	 *			values and that other parameters may also be provided as lists. Note that
	 *			{@link ArrayObject} instances are not considered here as arrays.
	 *		<li><i>other</i>: Any other type represents either the new value to be added or
	 *			the index to the value to be retrieved or deleted.
	 *	 </ul>
	 *	<li><tt>$theOperation</tt>: This parameter represents the operation to be performed
	 *		whose scope depends on the value of the previous parameter:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Return the full list if the first parameter is <tt>NULL</tt>;
	 *			return the elements matching the provided list if the first parameter is an
	 *			array; return the element matching the string provided in the first
	 *			parameter.
	 *		<li><tt>FALSE</tt>: Delete the full list if the first parameter is
	 *			<tt>NULL</tt>; delete the elements matching the provided list if the first
	 *			parameter is an array; delete the element matching the string provided in
	 *			the first parameter.
	 *		<li><tt>array</tt>: This type is only considered if the first parameter is
	 *			provided also as an array: the method will iteratively be called with each
	 *			element of the first and second parameter and the result will be an array
	 *			containing the returned value of each iteration. This also means that both
	 *			the first and second parameters must share the same count.
	 *		<li><i>other</i>: Add the value of the first parameter to the set. If you
	 *			provided <tt>NULL</tt> in the first parameter, this parameter will also be
	 *			reset to <tt>NULL</tt>.
	 *	 </ul>
	 *	<li><tt>$getOld</tt>: Determines what the method will return:
	 *	 <ul>
	 *		<li><tt>TRUE</tt>: Return the value <i>before</i> it was eventually modified.
	 *		<li><tt>FALSE</tt>: Return the value <i>after</i> it was eventually modified.
	 *	 </ul>
	 * </ul>
	 *
	 * Note that, while this method allows the creation, modification and deletion of this
	 * property, the hosting object may prevent such actions in particular cases.
	 *
	 * @param mixed					$theValue			Value or element index.
	 * @param mixed					$theOperation		Operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access public
	 * @return string				<i>New</i>, <i>old</i> value or <tt>NULL</tt>.
	 *
	 * @uses ManageObjectSetOffset()
	 *
	 * @see kTAG_KIND
	 */
	public function Kind( $theValue = NULL, $theOperation = NULL, $getOld = FALSE )
	{
		return ManageObjectSetOffset
			( $this, kTAG_KIND, $theValue, $theOperation, $getOld );				// ==>

	} // Kind.

	 
	/*===================================================================================
	 *	Type																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage types</h4>
	 *
	 * The <i>type</i>, {@link kTAG_TYPE}, holds a set of strings which represent
	 * the different types associated with the current object. This set of enumerations
	 * refer to the data or unit types specific to the contents of the curent object.
	 *
	 * In other words: the type tells you what a property holds, the kind tells you what a
	 * property is.
	 *
	 * The elements of this set should belong to a controlled vocabulary set and consist of
	 * the global identifier, {@link kTAG_GID}, of a term.
	 *
	 * This enumerated set is managed with the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theValue</tt>: Depending on the next parameter, this may either refer to
	 *		the value to be set or to the index of the element to be retrieved or deleted:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: This value indicates that we want to operate on all elements,
	 *			which means that we either want to retrieve or delete the full list. If the
	 *			operation parameter resolves to <tt>TRUE</tt>, the method will default to
	 *			retrieving the current list and no new element will be added; if the
	 *			operation parameter resolves to <tt>FALSE</tt>, the method will delete the
	 *			full list and the method will return the old list or <tt>NULL</tt>,
	 *			depending on the last parameter.
	 *		<li><tt>array</tt>: An array indicates that we want to operate on a list of
	 *			values and that other parameters may also be provided as lists. Note that
	 *			{@link ArrayObject} instances are not considered here as arrays.
	 *		<li><i>other</i>: Any other type represents either the new value to be added or
	 *			the index to the value to be retrieved or deleted.
	 *	 </ul>
	 *	<li><tt>$theOperation</tt>: This parameter represents the operation to be performed
	 *		whose scope depends on the value of the previous parameter:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Return the full list if the first parameter is <tt>NULL</tt>;
	 *			return the elements matching the provided list if the first parameter is an
	 *			array; return the element matching the string provided in the first
	 *			parameter.
	 *		<li><tt>FALSE</tt>: Delete the full list if the first parameter is
	 *			<tt>NULL</tt>; delete the elements matching the provided list if the first
	 *			parameter is an array; delete the element matching the string provided in
	 *			the first parameter.
	 *		<li><tt>array</tt>: This type is only considered if the first parameter is
	 *			provided also as an array: the method will iteratively be called with each
	 *			element of the first and second parameter and the result will be an array
	 *			containing the returned value of each iteration. This also means that both
	 *			the first and second parameters must share the same count.
	 *		<li><i>other</i>: Add the value of the first parameter to the set. If you
	 *			provided <tt>NULL</tt> in the first parameter, this parameter will also be
	 *			reset to <tt>NULL</tt>.
	 *	 </ul>
	 *	<li><tt>$getOld</tt>: Determines what the method will return:
	 *	 <ul>
	 *		<li><tt>TRUE</tt>: Return the value <i>before</i> it was eventually modified.
	 *		<li><tt>FALSE</tt>: Return the value <i>after</i> it was eventually modified.
	 *	 </ul>
	 * </ul>
	 *
	 * Note that, while this method allows the creation, modification and deletion of this
	 * property, the hosting object may prevent such actions in particular cases.
	 *
	 * @param mixed					$theValue			Value or element index.
	 * @param mixed					$theOperation		Operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access public
	 * @return string				<i>New</i>, <i>old</i> value or <tt>NULL</tt>.
	 *
	 * @uses ManageObjectSetOffset()
	 *
	 * @see kTAG_TYPE
	 */
	public function Type( $theValue = NULL, $theOperation = NULL, $getOld = FALSE )
	{
		return ManageObjectSetOffset
			( $this, kTAG_TYPE, $theValue, $theOperation, $getOld );				// ==>

	} // Type.

	 

} // trait TIdentification.


?>

<?php

/**
 * <i>TAuthorship</i> trait definition.
 *
 * This file contains the trait definition of <b>TAuthorship</b> which collects authorship,
 * acknowledgments, bibliography and notes accessor methods.
 *
 *	@package	MyWrapper
 *	@subpackage	Traits
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 05/02/2013
 */

/*=======================================================================================
 *																						*
 *									TAuthorship.php										*
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
 * <h4>Common authorship members</h4>
 *
 * This trait implements a collection of accessor methods covering the set of qualification
 * attributes which illustrate authorship and other general information:
 *
 * <ul>
 *	<li><tt>{@link Author()}</tt>: The <i>authors</i>, {@link kTAG_AUTHORS}, represents a
 *		list of author names.
 *	<li><tt>{@link Acknowledgments()}</tt>: The <i>acknowledgments</i>,
 *		{@link kTAG_ACKNOWLEDGMENTS}, is a string containing acknowledgments.
 *	<li><tt>{@link Bibliography()}</tt>: The <i>bibliography</i>, {@link kTAG_BIBLIOGRAPHY},
 *		is a string containing bibliographic references.
 *	<li><tt>{@link Notes()}</tt>: The <i>notes</i>, {@link kTAG_NOTES}, is an array of
 *		strings expressed in different languages.
 * </ul>
 *
 *	@package	MyWrapper
 *	@subpackage	Traits
 */
trait TAuthorship
{
		

/*=======================================================================================
 *																						*
 *								PUBLIC MEMBER INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Author																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage authors list</h4>
	 *
	 * This method can be used to manage a list of authors, {@link kTAG_AUTHORS}, as an
	 * strings that can contain author names.
	 *
	 * This offset collects the list of these inputs in an enumerated set that can be
	 * managed with the following parameters:
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
	 * @see kTAG_AUTHORS
	 */
	public function Author( $theValue = NULL, $theOperation = NULL, $getOld = FALSE )
	{
		return ManageObjectSetOffset
			( $this, kTAG_AUTHORS, $theValue, $theOperation, $getOld );				// ==>

	} // Author.

	 
	/*===================================================================================
	 *	Acknowledgments																	*
	 *==================================================================================*/

	/**
	 * <h4>Manage acknowledgments</h4>
	 *
	 * The <i>acknowledgments</i>, {@link kTAG_ACKNOWLEDGMENTS}, are represented by a string, the
	 * method accepts a parameter which represents either the acknowledgments or the requested
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
	 * @param mixed					$theValue			Native identifier or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return string				<i>New</i>, <i>old</i> value or <tt>NULL</tt>.
	 *
	 * @uses ManageOffset()
	 *
	 * @see kTAG_ACKNOWLEDGMENTS
	 */
	public function Acknowledgments( $theValue = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kTAG_ACKNOWLEDGMENTS, $theValue, $getOld );		// ==>

	} // Acknowledgments.

	 
	/*===================================================================================
	 *	Bibliography																	*
	 *==================================================================================*/

	/**
	 * <h4>Manage bibliography</h4>
	 *
	 * The <i>bibliography</i>, {@link kTAG_BIBLIOGRAPHY}, is represented by a string, the
	 * method accepts a parameter which represents either the bibliography or the requested
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
	 * @param mixed					$theValue			Native identifier or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return string				<i>New</i>, <i>old</i> value or <tt>NULL</tt>.
	 *
	 * @uses ManageOffset()
	 *
	 * @see kTAG_BIBLIOGRAPHY
	 */
	public function Bibliography( $theValue = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kTAG_BIBLIOGRAPHY, $theValue, $getOld );		// ==>

	} // Bibliography.

	 
	/*===================================================================================
	 *	Notes																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage notes</h4>
	 *
	 * The <i>notes</i>, {@link kTAG_NOTES}, are a list of strings expressed in different
	 * languages which represent general notes, no two elements may share the same language code.
	 *
	 * The method accepts the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theLanguage</tt>: Language code.
	 *	<li><tt>$theValue</tt>: The note string or the operation, depending on its value:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Return the string corresponding to the provided language.
	 *		<li><tt>FALSE</tt>: Delete the element corresponding to the provided language.
	 *		<li><i>other</i>: Any other value represents the description string that will be
	 *			set or replace the entry for the provided language.
	 *	 </ul>
	 *	<li><tt>$getOld</tt>: If <tt>TRUE</tt>, the method will return the description
	 *		string <i>before</i> it was eventually modified; if <tt>FALSE</tt>, the method
	 *		will return the value <i>after</i> eventual modifications.
	 * </ul>
	 *
	 * @param mixed					$theLanguage		Language code.
	 * @param mixed					$theValue			Description or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> description.
	 *
	 * @uses ManageIndexedOffset()
	 *
	 * @see kTAG_NOTES
	 */
	public function Notes( $theLanguage = NULL, $theValue = NULL, $getOld = FALSE )
	{
		return ManageIndexedOffset
				( $this, kTAG_NOTES, $theLanguage, $theValue, $getOld );			// ==>

	} // Notes.

	 

} // trait TAuthorship.


?>

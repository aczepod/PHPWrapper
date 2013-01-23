<?php

/*=======================================================================================
 *																						*
 *									Inputs.inc.php										*
 *																						*
 *======================================================================================*/
 
/**
 * Input type definitions.
 *
 * This file contains the term global identifiers of the default input type enumerations.
 *
 * Ontology tags have an attribute called <i>input</i> which represents the control type
 * that should be used in a form to manage the attribute's data:
 *
 * <ul>
 *	<li><tt>{@link kINPUT_TEXT}</tt>: Text. This represents a string field.
 *	<li><tt>{@link kINPUT_TEXTAREA}</tt>: Text. This represents a text area.
 *	<li><tt>{@link kINPUT_CHOICE}</tt>: Popup. This represents a single choice select combo.
 *	<li><tt>{@link kINPUT_MULTIPLE}</tt>: Combo. This represents a multiple choice select
 *		combo.
 *	<li><tt>{@link kINPUT_RADIO}</tt>: Radio group. This represents a single choice radio
 *		group.
 *	<li><tt>{@link kINPUT_CHECKBOX}</tt>: Checkbox group. This represents a multiple choice
 *		checkbox group.
 * </ul>
 *
 *	@package	MyWrapper
 *	@subpackage	Definitions
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 22/11/2012
 */

/*=======================================================================================
 *	DEFAULT INPUT TYPES																	*
 *======================================================================================*/

/**
 * Text field.
 *
 * This term represents a text field control, which allows input on one line with a defined
 * maximum length.
 *
 * Version 1: (kINPUT_TEXT)[:INPUT-TEXT]
 */
define( "kINPUT_TEXT",							':INPUT-TEXT' );

/**
 * Text area.
 *
 * This term represents a text area control, which allows input on several lines.
 *
 * Version 1: (kINPUT_TEXTAREA)[:INPUT-TEXTAREA]
 */
define( "kINPUT_TEXTAREA",						':INPUT-TEXTAREA' );

/**
 * Popup.
 *
 * This term represents a single select group which allows the choice of one item only.
 *
 * Version 1: (kINPUT_TEXTAREA)[:INPUT-TEXTAREA]
 */
define( "kINPUT_CHOICE",						':INPUT-CHOICE' );

/**
 * Combo.
 *
 * This term represents a multiple select group which allows the choice of one or more
 * items.
 *
 * Version 1: (kINPUT_MULTIPLE)[:INPUT-MULTIPLE]
 */
define( "kINPUT_MULTIPLE",						':INPUT-MULTIPLE' );

/**
 * Radio.
 *
 * This term represents a radio group of two controls which allows one of the two to be
 * on. By default this control must return the value of one of the two radios.
 *
 * Version 1: (kINPUT_RADIO)[:INPUT-RADIO]
 */
define( "kINPUT_RADIO",							':INPUT-RADIO' );

/**
 * Checkbox.
 *
 * This term represents a single checkbox control which can be either selected or not.
 * By default this control must either return a value or not.
 *
 * Version 1: (kINPUT_CHECKBOX)[:INPUT-CHECKBOX]
 */
define( "kINPUT_CHECKBOX",						':INPUT-CHECKBOX' );


?>

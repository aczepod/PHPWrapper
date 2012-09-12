<?php

/**
 * <i>CDocument</i> class definition.
 *
 * This file contains the class definition of <b>CDocument</b> which represents the
 * ancestor of document classes in this library.
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 02/09/2012
 */

/*=======================================================================================
 *																						*
 *									CDocument.php										*
 *																						*
 *======================================================================================*/

/**
 * Errors.
 *
 * This include file contains all error code definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_DEFINE."/Errors.inc.php" );

/**
 * <h3>Document object</h3>
 *
 * This class is the ancestor common to most classes in this library, it extends
 * {@link ArrayObject} to implement an object which represents a collection of key/value
 * attributes.
 *
 * The object implements the {@link ArrayAccess} interface in which the following rules
 * are enforced:
 *
 * <ul>
 *	<li>No offset may have the <tt>NULL</tt> value, setting an offset to that value is
 *		equivalent to removing the offset.
 *	<li>It is legal to retrieve a non-existant offset, a <tt>NULL</tt> value will be
 *		returned and no notice issued.
 *	<li>It is legal to delete a non-existant offset, no notice or warning will be issued.
 * </ul>
 *
 * The class implements an interface for member accessor methods that works in this way:
 *
 * <ul>
 *	<li>Accessor methods accept two parameters:
 *	 <ul>
 *		<li>The value or operation:
 *		 <ul>
 *			<li><tt>NULL</tt>: This value indicates that you want to <i>retrieve</i> the
 *				current value.
 *			<li><tt>FALSE</tt>: This value indicates that you want to <i>delete</i> the
 *				current value, note that this effectively prevents you from using that value
 *				as an attribute, use <tt>0</tt> or <tt>1</tt> instead.
 *			<li>other: Any other type is interpreted as the new value to be set.
 *		 </ul>
 *		<li><tt>$getOld</tt>: This boolean parameter is relevant when the attribute was
 *			modified or deleted: if set, the method will return the value <i>before</i> it
 *			was modified, if not, the method will return the value <i>after</i> it has
 *			been modified.
 *	 </ul>
 * </ul>
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 */
class CDocument extends ArrayObject
{
		

/*=======================================================================================
 *																						*
 *								PUBLIC ARRAY ACCESS INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	offsetGet																		*
	 *==================================================================================*/

	/**
	 * <h4>Return a value at a given offset</h4>
	 *
	 * This method should return the value corresponding to the provided offset.
	 *
	 * This method is overloaded to prevent notices from being triggered when seeking
	 * non-existing offsets.
	 *
	 * In this class no offset may have a <tt>NULL</tt> value, if this method returns a
	 * <tt>NULL</tt> value, it means that the offset doesn't exist.
	 *
	 * @param string				$theOffset			Offset.
	 *
	 * @access public
	 * @return mixed				Offset value.
	 */
	public function offsetGet( $theOffset )	{	return @parent::offsetGet( $theOffset );	}

	 
	/*===================================================================================
	 *	offsetSet																		*
	 *==================================================================================*/

	/**
	 * <h4>Set a value at a given offset</h4>
	 *
	 * This method should set the provided value corresponding to the provided offset.
	 *
	 * This method is overloaded to prevent setting <tt>NULL</tt> values: if this is the
	 * case, the method will unset the offset.
	 *
	 * @param string				$theOffset			Offset.
	 * @param mixed					$theValue			Value to set at offset.
	 *
	 * @access public
	 *
	 * @uses offsetUnset()
	 */
	public function offsetSet( $theOffset, $theValue )
	{
		//
		// Set value.
		//
		if( $theValue !== NULL )
			parent::offsetSet( $theOffset, $theValue );
		
		//
		// Delete offset.
		//
		else
			$this->offsetUnset( $theOffset );
	
	} // offsetSet.

	 
	/*===================================================================================
	 *	offsetUnset																		*
	 *==================================================================================*/

	/**
	 * <h4>Reset a value at a given offset</h4>
	 *
	 * This method should reset the value corresponding to the provided offset.
	 *
	 * We overload this method to prevent notices on non-existing offsets.
	 *
	 * @param string				$theOffset			Offset.
	 *
	 * @access public
	 */
	public function offsetUnset( $theOffset )	{	@parent::offsetUnset( $theOffset );		}

		

/*=======================================================================================
 *																						*
 *								PUBLIC ARRAY UTILITY INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	array_keys																		*
	 *==================================================================================*/

	/**
	 * <h4>Return object's offsets</h4>
	 *
	 * This method has the same function as the PHP function <tt>array_keys()</i>, it will
	 * return an array comprised of all object's offsets.
	 *
	 * @access public
	 * @return array				List of object offsets.
	 */
	public function array_keys()			{	return array_keys( $this->getArrayCopy() );	}

	 
	/*===================================================================================
	 *	array_values																	*
	 *==================================================================================*/

	/**
	 * <h4>Return object's offset values</h4>
	 *
	 * This method has the same function as the PHP function <tt>array_values()</i>, it
	 * will return an array comprised of all object's offset values.
	 *
	 * @access public
	 * @return array				List of object offset values.
	 */
	public function array_values()		{	return array_values( $this->getArrayCopy() );	}

	 

} // class CDocument.


?>

<?php namespace MyWrapper\Framework;

/**
 * <i>CContainer</i> class definition.
 *
 * This file contains the class definition of <b>CContainer</b> which represents the
 * ancestor of all container objects in this library.
 *
 *	@package	MyWrapper
 *	@subpackage	Persistence
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 03/09/2012
 */

/*=======================================================================================
 *																						*
 *									CContainer.php										*
 *																						*
 *======================================================================================*/

/**
 * Persistent document.
 *
 * This includes the ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/Persistence/CPersistentDocument.php" );
use \MyWrapper\Persistence\CPersistentDocument as CPersistentDocument;

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/Framework/CConnection.php" );
use \MyWrapper\Framework\CConnection as CConnection;

/**
 * <h3>Persistent objects data store ancestor</h3>
 *
 * This <i>abstract</i> class is the ancestor of all container classes in this library, it
 * implements the interface and workflow that all concrete derived classes should implement.
 *
 * A container object serves the purpose of storing and retrieving objects, in the same way
 * as a database table. The object holds a data member that represents a native container
 * from a database.
 *
 * The public interface declares the following main operations:
 *
 * <ul>
 *	<li>{@link ManageObject()}: This method will <i>insert</i>, <i>update</i>,
 *		<i>modify</i>, <i>delete</i> and <i>load</i> an object from the current container.
 *		This method operates one object at the time and it is mainly used by persistent
 *		objects for persisting in containers.
 *	<li>{@link ConvertBinary()}: This method will convert a binary string to a format
 *		compatible with the current data store.
 *		container.
 * </ul>
 *
 * The class does not implement a concrete data store, derived classes must implement
 * specific storage actions.
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 */
abstract class CContainer extends CConnection
{
		

/*=======================================================================================
 *																						*
 *								PUBLIC CONNECTION INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	ManageObject																	*
	 *==================================================================================*/

	/**
	 * <h4>Manage an object from the container</h4>
	 *
	 * This method can be used to manage a single object in the container, it can
	 * <i>insert</i>, <i>update</i>, <i>replace</i>, <i>modify</i>, <i>retrieve</i> and
	 * <i>delete</i> an object from the current container by providing the object and/or
	 * its native unique identifier ({@link kOFFSET_NID}).
	 *
	 * This method expects three parameters:
	 *
	 * <ul>
	 *	<li><tt>$theObject</tt>: The object or the data to be modified.
	 *	<li><tt>$theIdentifier</tt>: The native unique identifier ({@link kOFFSET_NID}) of
	 *		the object. If the value is <i>NULL</i>, it means that it is the duty of the
	 *		current container to set the value, this will generally be the case when
	 *		inserting objects; in all other cases the parameter is required.
	 *	<li><tt>$theModifiers</tt>: This parameter represents the operation options, it is a
	 *		bitfield where the following values apply:
	 *	 <ul>
	 *		<li>{@link kFLAG_PERSIST_INSERT}: The provided object will be inserted in the
	 *			container. It is assumed that no other element in the container shares
	 *			the same identifier, if not, the method should raise an exception.
	 *			In this case the <tt>$theObject</tt> represents the full object and
	 *			<tt>$theIdentifier</tt> represents the object unique identifier, or
	 *			<tt>NULL</tt>, if it is the duty of the container to create the identifier.
	 *			If the identifier was created by the container, it is the duty of this
	 *			method to set it into the provided object.
	 *			In this case the method should return the inserted object's native
	 *			identifier ({@link kOFFSET_NID}).
	 *		<li>{@link kFLAG_PERSIST_UPDATE}: The provided object will replace an
	 *			object existing in the container.
	 *			In this case the <tt>$theObject</tt> represents the full object and
	 *			<tt>$theIdentifier</tt> represents the object unique identifier.
	 *			In this case the method should return <tt>TRUE</tt> if the object was
	 *			updated and <tt>FALSE</tt> if the object was not found.
	 *		<li>{@link kFLAG_PERSIST_REPLACE}: The provided object will be inserted
	 *			if the identifier is missing or it doesn't match any entry in the container,
	 *			or it will update the object corresponding to the provided identifier. This
	 *			option represents the combination of the {@link kFLAG_PERSIST_INSERT} and
	 *			{@link kFLAG_PERSIST_UPDATE} operations.
	 *			In this case the <tt>$theObject</tt> represents the full object and
	 *			<tt>$theIdentifier</tt> represents the object unique identifier, or
	 *			<tt>NULL</tt>, if it is the duty of the container to create the identifier.
	 *			If the identifier was created by the container, it is the duty of this
	 *			method to set it into the provided object.
	 *			In this case the method should return the inserted object's native
	 *			identifier ({@link kOFFSET_NID}).
	 *		<li>{@link kFLAG_PERSIST_MODIFY}: This option can be used to apply modifications
	 *			to a subset of the object.
	 *			In this case the parameters of this method have the following functions:
	 *		 <ul>
	 *			<li><tt>$theObject</tt>: This parameter will be an array of elements whose
	 *				<i>key</i> corresponds to the offset to be considered and the
	 *				<i>value</i> to the value that the operation will use.
	 *			<li><tt>$theIdentifier</tt>: This parameter keeps its original meaning, it
	 *				should contain the native identifier of the object to be modified.
	 *			<li><tt>$theModifiers</tt>: Another section of this bitfield will hold the
	 *				flags that determine what specific modification should be performed:
	 *			 <ul>
	 *				<li>{@link kFLAG_MODIFY_INCREMENT}: This flag indicates an increment or
	 *					decrement operation, the method will take the value corresponding
	 *					to the offset in <tt>$theObject</tt> parameter and add it to the
	 *					object identified by <tt>$theIdentifier</tt> in the container.
	 *					For instance, to increment by one the '<tt>A</tt>' offset of object
	 *					<tt>X</tt>, you would pass the <tt>array( 'A' => 1 )</tt> in
	 *					<tt>$theObject</tt>, <tt>X</tt> in <tt>$theIdentifier</tt> and set
	 *					the kFLAG_MODIFY_INCREMENT flag; to decrement by two you would
	 *					pass <tt>array( 'A' => -2 )</tt> in <tt>$theObject</tt>, with all
	 *					other parameters unchanged.
	 *					If the offset does not exist, it will be initialised with the
	 *					increment value.
	 *				<li>{@link kFLAG_MODIFY_APPEND}: This flag indicates that we want to
	 *					append a value to an existing array, the method will take the value
	 *					corresponding to the offset in <tt>$theObject</tt> and append it to
	 *					the offset in <tt>$theObject</tt> for the object identified by
	 *					<tt>$theIdentifier</tt> in the container.
	 *					For instance, to append the value '<tt>A</tt>' to the array in
	 *					offset '<tt>FIELD</tt>' for object <tt>X</tt>, you would pass the
	 *					<tt>array( 'FIELD' => 'A' )</tt> in <tt>$theObject</tt>,
	 *					<tt>X</tt> in <tt>$theIdentifier</tt> and set the
	 *					kFLAG_MODIFY_APPEND flag.
	 *					If the field does not exist, it will be created with an array
	 *					composed of the provided append value; if the field exists and its
	 *					value is not an array, an exception should be raised.
	 *				<li>{@link kFLAG_MODIFY_ADDSET}: This flag indicates that we want to
	 *					add a value to a set, this operation is equivalent to
	 *					{@link kFLAG_MODIFY_APPEND}, except that the value will be appended
	 *					only if it doesn't exist already in the receiving array.
	 *				<li>{@link kFLAG_MODIFY_POP}: This flag indicates that we want to remove
	 *					the first or last element from an array. The method will take the
	 *					value corresponding to the offset in <tt>$theObject</tt> and check
	 *					its sign: if positive, the method will remove the first element; if
	 *					negative it will remove the last.
	 *					For instance, to remove the first element in the '<tt>FIELD</tt>'
	 *					offset of object <tt>X</tt>, you would pass the
	 *					<tt>array( 'FIELD' => 1 )</tt> in <tt>$theObject</tt>, <tt>X</tt> in
	 *					<tt>$theIdentifier</tt> and set the kFLAG_MODIFY_POP flag in
	 *					<tt>$theModifiers</tt>; to remove the last element you would pass
	 *					<tt>array( 'FIELD' => -1 )</tt> in <tt>$theObject</tt>.
	 *					If the offset does not exist, the method should not fail; if the
	 *					offset is not an array, the method should raise an exception.
	 *				<li>{@link kFLAG_MODIFY_PULL}: This flag indicates that we want to
	 *					remove all occurrences of a value from an array.
	 *					For instance, to remove all occurrances of '<tt>A</tt>' from the
	 *					array contained in the '<tt>FIELD</tt>' offset of object <tt>X</tt>, 
	 *					you would pass <tt>array( 'FIELD' => 'A' )</tt> in
	 *					<tt>$theObject</tt>, <tt>X</tt> in <tt>$theIdentifier</tt> and set
	 *					the kFLAG_MODIFY_PULL flag in <tt>$theModifiers</tt>.
	 *					If the field exists and its value is not an array, an exception
	 *					should be raised.
	 *				<li>{@link kFLAG_MODIFY_MASK} <i>off</i>: If none of the above flags are
	 *					set, it means that the key/value pairs set in <tt>$theObject</tt>
	 *					represent offsets to be added or removed, depending on the value
	 *					part of the pair: if the value is <tt>NULL</tt>, it means that you
	 *					want to remove the offset; any other value will replace the existing
	 *					offset or be added to the object.
	 *			 </ul>
	 *		 </ul>
	 *			In this case the method will return the modified object in the
	 *			<tt>$theObject</tt> parameter, or raise an exception if the operation fails.
	 *		<li>{@link kFLAG_PERSIST_DELETE}: This option assumes you want to remove the
	 *			object from the container.
	 *			In this case the <tt>$theObject</tt> represents the full object and
	 *			<tt>$theIdentifier</tt> represents the object unique identifier, what
	 *			counts is that the object's unique identifier ({@link kOFFSET_NID}) is
	 *			provided. If the object is not found in the container, the method should
	 *			not fail.
	 *			In this case the method should return <tt>TRUE</tt> if the object was
	 *			deleted and <tt>FALSE</tt> if the object was not found.
	 *	 </ul>
	 *		If none of the above flags are set, it means that the caller wants to retrieve
	 *		the object identified by the {@link kOFFSET_NID} offset from the provided object
	 *		object or from the provided identifier. If found, the provided object will
	 *		receive the located object and the method will return <tt>TRUE</tt>; if not
	 *		found, the method will set the provided object to <tt>NULL</tt> and return
	 *		<tt>FALSE</tt>.
	 * </ul>
	 *
	 * The method should raise an exception if the operation was not successful and update
	 * the provided object with whatever data the operation will generate.
	 *
	 * The method will also raise an exception if the object is not yet initialised
	 * ({@link _IsInited()}), this happens when the object received the native container.
	 *
	 * This class is abstract, which means that derived classes must implement the specific
	 * functionality of specialised data stores, for this reason this method is declared
	 * abstract.
	 *
	 * @param reference			   &$theObject			Object.
	 * @param mixed					$theIdentifier		Identifier.
	 * @param bitfield				$theModifiers		Options.
	 *
	 * @access public
	 * @return mixed				The native operation status.
	 *
	 * @see kFLAG_PERSIST_INSERT kFLAG_PERSIST_UPDATE kFLAG_PERSIST_MODIFY
	 * @see kFLAG_PERSIST_REPLACE kFLAG_PERSIST_MODIFY kFLAG_PERSIST_DELETE
	 * @see kFLAG_MODIFY_INCREMENT kFLAG_MODIFY_APPEND kFLAG_MODIFY_ADDSET
	 * @see kFLAG_MODIFY_POP kFLAG_MODIFY_PULL kFLAG_MODIFY_MASK
	 */
	abstract public function ManageObject( &$theObject,
											$theIdentifier = NULL,
											$theModifiers = kFLAG_DEFAULT );

		

/*=======================================================================================
 *																						*
 *								PUBLIC CONVERSION INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	ConvertBinary																	*
	 *==================================================================================*/

	/**
	 * <h4>Convert a binary string</h4>
	 *
	 * This method should be used to convert a binary string to a format compatible with the
	 * current container.
	 *
	 * The first parameter represents the value to be encoded or decoded, the second boolean
	 * parameter represents the conversion direction: <tt>TRUE</tt> means convert for
	 * database, <tt>FALSE</tt> convert back to PHP.
	 *
	 * By default we convert the string to hexadecimal.
	 *
	 * @param mixed					$theValue			Binary value.
	 * @param boolean				$theSense			<tt>TRUE</tt> encode for database.
	 *
	 * @static
	 * @return mixed				The encoded or decoded binary string.
	 */
	static function ConvertBinary( $theValue, $theSense = TRUE )
	{
		if( $theSense )
			return bin2hex( $theValue );											// ==>
		
		return hex2bin( $theValue );												// ==>
	
	} // ConvertBinary.

	 

} // class CContainer.


?>

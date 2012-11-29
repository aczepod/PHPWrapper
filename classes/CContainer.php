<?php

/**
 * <i>CContainer</i> class definition.
 *
 * This file contains the class definition of <b>CContainer</b> which represents the
 * ancestor of all container objects in this library.
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
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
 * Local definitions.
 *
 * This include file contains common offset definitions.
 */
require_once( "CContainer.inc.php" );

/**
 * Data types.
 *
 * This includes the data type class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CDataType.php" );

/**
 * Query.
 *
 * This includes the query class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CQuery.php" );

/**
 * Documents.
 *
 * This includes the persistent documents class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CPersistentDocument.php" );

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CConnection.php" );

/**
 * <h4>Persistent objects data store ancestor</h4>
 *
 * This <i>abstract</i> class is the ancestor of all container classes in this library, it
 * implements the interface and workflow that all concrete derived classes should implement.
 *
 * A container object serves the purpose of storing and retrieving objects, in the same way
 * as a database table. The object holds a data member that represents a native container
 * from a database.
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
 *											MAGIC										*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	__destruct																		*
	 *==================================================================================*/

	/**
	 * <h4>Destructor</h4>
	 *
	 * We implement the destructor to get rid of the graph: the Neo4j PHP interface, for
	 * instance, has closures that cannot be serialised, so we need to reset the graph
	 * {@link kOFFSET_GRAPH} offset before destroying the object.
	 *
	 * @access public
	 */
	public function __destruct()
	{
		//
		// Reset graph.
		//
		if( $this->offsetExists( kOFFSET_GRAPH ) )
			$this->offsetUnset( kOFFSET_GRAPH );
		
	} // Destructor.

	

/*=======================================================================================
 *																						*
 *								PUBLIC CONNECTION INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Drop																			*
	 *==================================================================================*/

	/**
	 * <h4>Delete a container</h4>
	 *
	 * This method should be implemented by derived concrete instances.
	 *
	 * @access public
	 */
	abstract public function Drop();

	 
	/*===================================================================================
	 *	AddIndex																		*
	 *==================================================================================*/

	/**
	 * <h4>Add an index</h4>
	 *
	 * This method should be implemented by derived concrete instances.
	 *
	 * @param array					$theIndex			Key/Sort list.
	 * @param array					$theOptions			List of index options.
	 *
	 * @access public
	 */
	abstract public function AddIndex( $theIndex, $theOptions = Array() );

		

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
	 * its native unique identifier ({@link kTAG_NID}).
	 *
	 * This method expects three parameters:
	 *
	 * <ul>
	 *	<li><tt>$theObject</tt>: The object or the data to be modified.
	 *	<li><tt>$theIdentifier</tt>: The native unique identifier ({@link kTAG_NID}) of
	 *		the object. If the value is <i>NULL</i>, it means that it is the duty of the
	 *		current container to set the value, this will generally be the case when
	 *		inserting objects; in all other cases the parameter is required.
	 *	<li><tt>$theModifiers</tt>: This parameter represents the operation options, or the
	 *		list of offsets to be returned. If the parameter is not an array, it will be
	 *		interpreted as a bitfield where the following values apply:
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
	 *			identifier ({@link kTAG_NID}).
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
	 *			identifier ({@link kTAG_NID}).
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
	 *			counts is that the object's unique identifier ({@link kTAG_NID}) is
	 *			provided. If the object is not found in the container, the method should
	 *			not fail.
	 *			In this case the method should return <tt>TRUE</tt> if the object was
	 *			deleted and <tt>FALSE</tt> if the object was not found.
	 *	 </ul>
	 *		If none of the above flags are set, it means that the caller wants to retrieve
	 *		the object identified by the {@link kTAG_NID} offset from the provided object
	 *		or from the provided identifier. If found, the provided object will receive the
	 *		located object and the method will return <tt>TRUE</tt>; if not found, the
	 *		method will set the provided object to <tt>NULL</tt> and return <tt>FALSE</tt>.
	 *		If the parameter is an array, it implies that the requested operation is to
	 *		retrieve the object, the array will be interpreted as the list of object offsets
	 *		to be returned, the {@link kTAG_NID} offset is returned by default.
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
	 * @param mixed					$theModifiers		Options or offsets list.
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

	 
	/*===================================================================================
	 *	CheckObject																		*
	 *==================================================================================*/

	/**
	 * <h4>Check if object exists in container</h4>
	 *
	 * This method can be used to check if an object exists in the current container, the
	 * method expects an identifier and an optional offset, it will return <tt>TRUE</tt> if
	 * found and <tt>FALSE</tt> if not.
	 *
	 * @param mixed					$theIdentifier		Identifier.
	 * @param string				$theOffset			Offset.
	 *
	 * @access public
	 * @return boolean				<tt>TRUE</tt> exists.
	 */
	abstract public function CheckObject( $theIdentifier, $theOffset = NULL );

	 
	/*===================================================================================
	 *	Query																			*
	 *==================================================================================*/

	/**
	 * <h4>Perform a query</h4>
	 *
	 * This method can be used to perform a query on the container, it expects an instance
	 * of {@link CQuery} as the query, or <tt>NULL</tt>, to query the whole container and
	 * two optional parameters that represents the list of desired fields and the list of
	 * sort fields with sense.
	 *
	 * <ul>
	 *	<li><tt>$theQuery</tt>: The query expressed as an array or query object, if omitted,
	 *		it is assumed the query should cover the whole contents of the container.
	 *	<li><tt>$theFields</tt>: The list of fields to be returned, if omitted, it is
	 *		assumed all fields are to be returned.
	 *	<li><tt>$theSort</tt>: The query sort order provided as an array in which the key
	 *		represents the field name and he value a number that represents the sense:
	 *		negative numbers indicate descending order and positive numbers ascending order;
	 *		a value of zero will be skipped.
	 *	<li><tt>$theStart</tt>: The record number on which to start returning results (zero
	 *		based).
	 *	<li><tt>$theLimit</tt>: The maximum number of records to be returned.
	 *	<li><tt>$getFirst</tt>: If <tt>TRUE</tt>, the method should return the first matched
	 *		record or <tt>NULL</tt> if there were no matches.
	 * </ul>
	 *
	 * The method should return an object that represents a cursor into the query results,
	 * the object should be iterable and feature a method, <i>count</i>, that accepts a
	 * boolean parameter: if <tt>TRUE</tt> the method should return the actual number of
	 * elements available takinf into consideration paging parameters; if <tt>FALSE</tt>,
	 * the method should return the total affected elements count, that is, the total number
	 * of elements affected by the query regardless of paging parameters.
	 *
	 * @param array					$theQuery			Query.
	 * @param array					$theFields			Fields set.
	 * @param array					$theSort			Sort order.
	 * @param integer				$theStart			Page start.
	 * @param integer				$theLimit			Page limit.
	 * @param boolean				$getFirst			TRUE means return first.
	 *
	 * @access public
	 * @return object				Native recordset.
	 */
	abstract public function Query( $theQuery = NULL,
									$theFields = NULL, $theSort = NULL,
									$theStart = NULL, $theLimit = NULL,
									$getFirst = NULL );

		

/*=======================================================================================
 *																						*
 *								PUBLIC CONVERSION INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	UnserialiseObject																*
	 *==================================================================================*/

	/**
	 * Unserialise provided object.
	 *
	 * This method will convert concrete derived instances of {@link CDataType} or
	 * equivalent structures into native data types suitable to be stored in containers.
	 *
	 * This method will scan the provided object or structure and pass all instances derived
	 * from {@link CDataType} to another public {@link UnserialiseData()} method that will
	 * convert these objects into native data types that are compatible with the specific
	 * container type.
	 *
	 * The method will scan the provided structure and select all elements which are arrays,
	 * ArrayObjects or objects derived from {@link CDataType}, these elements will be sent
	 * to the {@link UnserialiseData()} method that will take care of converting these
	 * structures into native data types that are compatible with the specific container
	 * type.
	 *
	 * The method will perform the conversion directly into the provided reference and will
	 * use recursion to traverse the provided structures.
	 *
	 * Elements sent to the {@link UnserialiseData()} method are selected as follows:
	 *
	 * <ul>
	 *	<li><tt>{@link CDataType}</tt>: All instances derived from this class are  sent to
	 *		the {@link UnserialiseData()} method.
	 *	<li><tt>Array</tt> or <tt>ArrayObject</tt>: If the structure is composed of exactly
	 *		two offsets and these elements are {@link kTAG_CUSTOM_TYPE} and
	 *		{@link kTAG_CUSTOM_DATA}, it will be sent to the {@link UnserialiseData()}
	 *		method. If the above condition is not satisfied, the structure will be sent
	 *		recursively to this method.
	 * </ul>
	 *
	 * @param reference			   &$theObject			Object to encode.
	 *
	 * @access public
	 *
	 * @uses UnserialiseData()
	 *
	 * @see kTAG_CUSTOM_TYPE kTAG_CUSTOM_DATA
	 */
	public function UnserialiseObject( &$theObject )
	{
		//
		// Intercept structures.
		//
		if( is_array( $theObject )
		 || ($theObject instanceof ArrayObject) )
		{
			//
			// Traverse object.
			//
			foreach( $theObject as $key => $value )
			{
				//
				// Intercept standard data types.
				//
				if( $value instanceof CDataType )
				//
				// Note this ugly workflow:
				// I need to do this or else I get this
				// Notice: Indirect modification of overloaded element of MyClass
				// has no effect in /MySource.php
				// Which means that I cannot pass $theObject[ $key ] to UnserialiseData()
				// or I get the notice and the thing doesn't work.
				//
				{
					//
					// Copy data.
					//
					$save = $theObject[ $key ];
					
					//
					// Convert data.
					//
					$this->UnserialiseData( $save );
					
					//
					// Restore data.
					//
					$theObject[ $key ] = $save;
				}
					
				//
				// Intercept structs.
				//
				elseif( is_array( $value )
					 || ($value instanceof ArrayObject) )
				{
					//
					// Check required elements.
					//
					if( array_key_exists( kTAG_CUSTOM_TYPE, (array) $value )
					 && array_key_exists( kTAG_CUSTOM_DATA, (array) $value )
					 && (count( $value ) == 2) )
					//
					// Note this ugly workflow:
					// I need to do this or else I get this
					// Notice: Indirect modification of overloaded element of MyClass
					// has no effect in /MySource.php
					// Which means that I cannot pass $theObject[ $key ] to UnserialiseData()
					// or I get the notice and the thing doesn't work.
					//
					{
						//
						// Copy data.
						//
						$save = $theObject[ $key ];
						
						//
						// Convert data.
						//
						$this->UnserialiseData( $save );
						
						//
						// Restore data.
						//
						$theObject[ $key ] = $save;
					}
					
					//
					// Recurse.
					//
					else
					//
					// Note this ugly workflow:
					// I need to do this or else I get this
					// Notice: Indirect modification of overloaded element of MyClass
					// has no effect in /MySource.php
					// Which means that I cannot pass $theObject[ $key ] to UnserialiseData()
					// or I get the notice and the thing doesn't work.
					//
					{
						//
						// Copy data.
						//
						$save = $theObject[ $key ];
						
						//
						// Convert data.
						//
						$this->UnserialiseObject( $save );
						
						//
						// Restore data.
						//
						$theObject[ $key ] = $save;
					}
				
				} // Is a struct.
			
			} // Traversing object.
		
		} // Is a struct.
	
	} // UnserialiseObject.

	 
	/*===================================================================================
	 *	UnserialiseData																	*
	 *==================================================================================*/

	/**
	 * Unserialise provided data element.
	 *
	 * This method should convert the provided structure into a custom data type compatible
	 * with the current container.
	 *
	 * This method is called by a public {@link UnserialiseObject()} interface which
	 * traverses an object and provides this method with all elements that satisfy the
	 * following conditions:
	 *
	 * <ul>
	 *	<li><tt>{@link CDataType}</tt>: All instances derived from this class are sent to
	 *		this method.
	 *	<li><tt>Array</tt> or <tt>ArrayObject</tt>: If the structure is composed of exactly
	 *		two offsets and these elements are {@link kTAG_CUSTOM_TYPE} and
	 *		{@link kTAG_CUSTOM_DATA}, it will be sent to this method.
	 * </ul>
	 *
	 * The elements to be converted are provided by reference, which means that they have to
	 * be converted in place.
	 *
	 * This method can also be used in a different way: you can ask the method to convert
	 * the provided scalar to the corresponding custom type, for this you need to provide a
	 * scalar in the first parameter and a data type in the second.
	 *
	 * In this class we declare this class abstract, derived concrete classes must
	 * implement it.
	 *
	 * @param reference			   &$theElement			Element to encode.
	 * @param string				$theType			Data type.
	 *
	 * @access public
	 */
	abstract public function UnserialiseData( &$theElement, $theType = NULL );

		

/*=======================================================================================
 *																						*
 *								PUBLIC SEQUENCE INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	NextSequence																	*
	 *==================================================================================*/

	/**
	 * <h4>Return a sequence number</h4>
	 *
	 * This method should return a sequence number connected to the provided key. Each time
	 * this method is called, the sequence number is incremented, which means that you
	 * should only call it when you intend to use this number.
	 *
	 * The first parameter, <tt>$theKey</tt>, represents the key to the sequence, it will
	 * be the {@link kTAG_NID} of the record holding the sequence and the field holding
	 * the current number has the {@link kOFFSET_SEQUENCE} offset.
	 *
	 * The second parameter represents the container in which the sequence is stored:
	 *
	 * <ul>
	 *	<li><tt>string<tt>: The method should use the native container corresponding to the
	 *		provided string.
	 *	<li><tt>TRUE<tt>: The method should use the string stored in
	 *		{@link kCONTAINER_SEQUENCE_NAME}.
	 *	<li><tt>NULL<tt>: The method should use the current container.
	 * </ul>
	 *
	 * If the object is not {@link _Is Inited()}, the method should raise an exception.
	 *
	 * If the current object does not support sequences, this method should return
	 * <tt>NULL</tt>.
	 *
	 * This class is abstract and by default sequences are not supported.
	 *
	 * @param string				$theKey				Sequence key.
	 * @param mixed					$theContainer		Sequence container.
	 *
	 * @access public
	 * @return mixed				The sequence number or <tt>NULL</tt>.
	 *
	 * @throws Exception
	 */
	public function NextSequence( $theKey, $theContainer = NULL )		{	return NULL;	}

		

/*=======================================================================================
 *																						*
 *								STATIC QUERY INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	NewQuery																		*
	 *==================================================================================*/

	/**
	 * <h4>Return an empty query</h4>
	 *
	 * This method can be used to retrieve an empty query, the main utility of this method
	 * is to return a query object that is compatible with the current container.
	 *
	 * In this class we return an instance of the base {@link CQuery} class.
	 *
	 * @param mixed					$theQuery			Query data.
	 *
	 * @static
	 * @return CQuery				An empty query object.
	 */
	static function NewQuery( $theQuery = NULL )		{	return new CQuery( $theQuery );	}

	 

} // class CContainer.


?>

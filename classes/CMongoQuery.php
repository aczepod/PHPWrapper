<?php

/**
 * <i>CMongoQuery</i> class definition.
 *
 * This file contains the class definition of <b>CMongoQuery</b> which overloads its
 * ancestor to implement a Mongo query object.
 *
 *	@package	MyWrapper
 *	@subpackage	Persistence
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 19/09/2012
 */

/*=======================================================================================
 *																						*
 *									CMongoQuery.php										*
 *																						*
 *======================================================================================*/

/**
 * Mongo container.
 *
 * This include file contains the class definitions of the Mongo container.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CMongoContainer.php" );

/**
 * Ancestor.
 *
 * This include file contains the parent class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CQuery.php" );

/**
 * <h4>Mongo query</h4>
 *
 * This class extends its ancestor to implement a public method that will convert the
 * current object's query into a query suitable to be submitted to a Mongo database.
 *
 *	@package	MyWrapper
 *	@subpackage	Persistence
 */
class CMongoQuery extends CQuery
{
		

/*=======================================================================================
 *																						*
 *									PUBLIC EXPORT INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Export																			*
	 *==================================================================================*/

	/**
	 * <h4>Export query</h4>
	 *
	 * We overload the inherited method to generate Mongo specific queries.
	 *
	 * The method will first check if the provided container is a {@link CMongoContainer},
	 * it will then iterate all conditions and feed each to a protected method,
	 * {@link _ConvertCondition()}, that will take care of converting the query elements.
	 *
	 * @param CConnection			$theContainer		Query container.
	 *
	 * @access public
	 * @return array
	 *
	 * @throws Exception
	 */
	public function Export( CConnection $theContainer )
	{
		//
		// Check container.
		//
		if( ! $theContainer instanceof CMongoContainer )
			throw new Exception
				( "Unsupported container type",
				  kERROR_PARAMETER );											// !@! ==>

		//
		// Init local storage.
		//
		$query = Array();
		
		//
		// Traverse object.
		//
		foreach( $this as $condition => $statements )
			$this->_ConvertCondition( $query, $theContainer, $condition, $statements );
		
		return $query;																// ==>
	
	} // Export.

	 

/*=======================================================================================
 *																						*
 *								PROTECTED VALIDATION INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_ValidateCondition																*
	 *==================================================================================*/

	/**
	 * <h4>Validate condition</h4>
	 *
	 * This method expects a condition as its argument, it will check if it is a valid
	 * condition, then it will validate all condition statements.
	 *
	 * In this class we handle queries to Mongo databases, so the depth of the query
	 * conditions cannot go beyond 2 levels.
	 *
	 * We overload this method to prevent nesting OR conditions.
	 *
	 * @param string				$theCondition			Boolean condition.
	 * @param array					$theStatements			Statements list.
	 * @param integer				$theLevel				[PRIVATE] condition level.
	 *
	 * @access protected
	 */
	protected function _ValidateCondition( $theCondition, $theStatements, $theLevel )
	{
		//
		// Check level.
		//
		if( $theLevel > 2 )
			throw new Exception
				( "Invalid query: Mongo queries cannot have nested conditions",
				  kERROR_STATE );												// !@! ==>
		
		//
		// Call parent method.
		//
		parent::_ValidateCondition( $theCondition, $theStatements, $theLevel );
	
	} // _ValidateCondition.

	 

/*=======================================================================================
 *																						*
 *							PROTECTED QUERY CONVERSION INTERFACE						*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_ConvertCondition																*
	 *==================================================================================*/

	/**
	 * <h4>Convert condition</h4>
	 *
	 * This method will convert the provided condition block into a Mongo compatible
	 * condition block, it is called by the {@link Export()} method or called recursively to
	 * convert embedded conditions.
	 *
	 * The method expects the following parameters:
	 *
	 * <ul>
	 *	<li><tt>&$theQuery</tt>: Reference to an array that will receive the converted
	 *		condition.
	 *	<li><tt>$theContainer</tt>: Data container, must be derived from
	 *		{@link CMongoContainer}.
	 *	<li><tt>$theCondition</tt>: Boolean condition code.
	 *	<li><tt>$theStatements</tt>: List of condition statements.
	 * </ul>
	 *
	 * @param reference			   &$theQuery				Receives converted query.
	 * @param CMongoContainer		$theContainer			Query container.
	 * @param string				$theCondition			Boolean condition.
	 * @param array					$theStatements			Statements list.
	 *
	 * @access protected
	 */
	protected function _ConvertCondition( &$theQuery, $theContainer,
													  $theCondition,
													  $theStatements )
	{
		//
		// Check container.
		//
		if( ! $theContainer instanceof CMongoContainer )
			throw new Exception
					( "Unsupported container type",
					  kERROR_UNSUPPORTED );										// !@! ==>

		//
		// Create condition container.
		//
		switch( $theCondition )
		{
			//
			// OR: We add this clause.
			//
			case kOPERATOR_OR:
				$theQuery[ '$or' ] = Array();
				$query = & $theQuery[ '$or' ];
				break;
				
			//
			// NOR: We add this clause.
			//
			case kOPERATOR_NOR:
				$theQuery[ '$nor' ] = Array();
				$query = & $theQuery[ '$nor' ];
				break;
				
			//
			// AND: We add this clause.
			//
			case kOPERATOR_AND:
			case kOPERATOR_NAND:
				$theQuery[ '$and' ] = Array();
				$query = & $theQuery[ '$and' ];
				break;
			
			//
			// ERROR.
			//
			default:
				throw new Exception
						( "Unsupported condition [$theCondition]",
						  kERROR_UNSUPPORTED );									// !@! ==>
		
		} // Created condition container.
		
		//
		// Iterate statements.
		//
		foreach( $theStatements as $statement )
			$this->_ConvertStatement( $query, $theContainer, $theCondition, $statement );
	
	} // _ConvertCondition.

	 
	/*===================================================================================
	 *	_ConvertStatement																*
	 *==================================================================================*/

	/**
	 * <h4>Convert statement</h4>
	 *
	 * This method can be used to convert a condition statement to a Mongo compatible
	 * statement, it is called by the {@link _ConvertCondition()} method which feeds it each
	 * element of the condition block.
	 *
	 * The method expects the following parameters:
	 *
	 * <ul>
	 *	<li><tt>&$theQuery</tt>: Reference to an array that will receive the converted
	 *		statement.
	 *	<li><tt>$theContainer</tt>: Data container, must be derived from
	 *		{@link CMongoContainer} and we assume this check has been done by the caller.
	 *	<li><tt>$theCondition</tt>: Boolean condition code.
	 *	<li><tt>$theStatement</tt>: Statement or embedded condition.
	 * </ul>
	 *
	 * Note that this method will recursively call {@link _ConvertCondition()} if the
	 * current element of the provided statement is a condition code: this means that the
	 * element is a nested condition.
	 *
	 * @param reference			   &$theQuery				Receives converted statement.
	 * @param CMongoContainer		$theContainer			Query container.
	 * @param string				$theCondition			Boolean condition.
	 * @param array					$theStatement			Statement.
	 *
	 * @access protected
	 */
	protected function _ConvertStatement( &$theQuery, $theContainer,
													  $theCondition,
													  $theStatement )
	{
		//
		// Handle nested condition.
		//
		$condition = (string) key( $theStatement );
		$ops = array( kOPERATOR_OR, kOPERATOR_NOR, kOPERATOR_AND, kOPERATOR_NAND );
		if( in_array( $condition, $ops ) )
		{
			//
			// Create condition container.
			//
			$theQuery[] = Array();
			$statement = & $theQuery[ count( $theQuery ) - 1 ];
			
			//
			// Handle condition.
			//
			$this->_ConvertCondition
				( $statement, $theContainer, $condition, $theStatement[ $condition ] );
		
		} // Nested condition.
		
		//
		// Handle single statement.
		//
		else
		{
			//
			// Create and referencde statement container.
			//
			$theQuery[] = Array();
			$statement = & $theQuery[ count( $theQuery ) - 1 ];
			
			//
			// Save query data.
			//
			if( array_key_exists( kOFFSET_QUERY_DATA, $theStatement ) )
				$data = $theStatement[ kOFFSET_QUERY_DATA ];
			
			//
			// Save query data type.
			//
			if( array_key_exists( kOFFSET_QUERY_TYPE, $theStatement ) )
				$type = $theStatement[ kOFFSET_QUERY_TYPE ];
			
			//
			// Save query subject.
			//
			if( array_key_exists( kOFFSET_QUERY_SUBJECT, $theStatement ) )
				$subject = (string) $theStatement[ kOFFSET_QUERY_SUBJECT ];
			
			//
			// Normalise data by type.
			//
			if( isset( $type )
			 && isset( $data ) )
			{
				switch( $type )
				{
					case kTYPE_STRING:
						if( is_array( $data ) )
						{
							$keys = array_keys( $data );
							foreach( $keys as $key )
							{
								if( ! is_string( $data[ $key ] ) )
									$data[ $key ] = (string) $data[ $key ];
							}
						}
						else
						{
							if( ! is_string( $data ) )
								$data = (string) $data;
						}
						break;
						
					case kTYPE_INT:
					case kTYPE_INT32:
					case kTYPE_INT64:
						if( is_array( $data ) )
						{
							$keys = array_keys( $data );
							foreach( $keys as $key )
							{
								if( is_string( $data[ $key ] ) )
									$data[ $key ] = (int) $data[ $key ];
							}
						}
						else
						{
							if( is_string( $data ) )
								$data = (int) $data;
						}
						break;
						
					case kTYPE_FLOAT:
						if( is_array( $data ) )
						{
							$keys = array_keys( $data );
							foreach( $keys as $key )
							{
								if( is_string( $data[ $key ] ) )
									$data[ $key ] = (float) $data[ $key ];
							}
						}
						else
						{
							if( is_string( $data ) )
								$data = (float) $data;
						}
						break;

					case kTYPE_DATE_STRING:
					case kTYPE_TIME_STRING:
					case kTYPE_STAMP:
					case kTYPE_BOOLEAN:
					case kTYPE_BINARY_STRING:
					case kTYPE_MongoId:
					case kTYPE_MongoCode:
						break;
				}
			}
			
			//
			// Parse by operator.
			//
			switch( $operator = $theStatement[ kOFFSET_QUERY_OPERATOR ] )
			{
				//
				// EQUALS.
				//
				case kOPERATOR_EQUAL:
					$theContainer->UnserialiseData( $data, $type );
					$statement[ $subject ] = ( $theCondition == kOPERATOR_NAND )
										   ? array( '$ne' => $data )
										   : $data;
					break;
			
				//
				// NOT EQUALS.
				//
				case kOPERATOR_EQUAL_NOT:
					$theContainer->UnserialiseData( $data, $type );
					$statement[ $subject ] = ( $theCondition == kOPERATOR_NAND )
										   ? $data
										   : array( '$ne' => $data );
					break;
			
				//
				// LIKE.
				//
				case kOPERATOR_LIKE:
					$tmp = '/^'.$data.'$/i';
					$statement[ $subject ] = ( $theCondition == kOPERATOR_NAND )
										   ? array( '$not' => new MongoRegex( $tmp ) )
										   : new MongoRegex( $tmp );
					break;
			
				//
				// STARTS WITH.
				//
				case kOPERATOR_PREFIX:
				case kOPERATOR_PREFIX_NOCASE:
					$tmp = '/^'.$data.'/';
					if( $operator == kOPERATOR_PREFIX_NOCASE )
						$tmp .= 'i';
					$statement[ $subject ] = ( $theCondition == kOPERATOR_NAND )
										   ? array( '$not' => new MongoRegex( $tmp ) )
										   : new MongoRegex( $tmp );
					break;
			
				//
				// CONTAINS.
				//
				case kOPERATOR_CONTAINS:
				case kOPERATOR_CONTAINS_NOCASE:
					$tmp = '/'.$data.'/';
					if( $operator == kOPERATOR_CONTAINS_NOCASE )
						$tmp .= 'i';
					$statement[ $subject ] = ( $theCondition == kOPERATOR_NAND )
										   ? array( '$not' => new MongoRegex( $tmp ) )
										   : new MongoRegex( $tmp );
					break;
			
				//
				// ENDS WITH.
				//
				case kOPERATOR_SUFFIX:
				case kOPERATOR_SUFFIX_NOCASE:
					$tmp = '/'.$data.'$/';
					if( $operator == kOPERATOR_SUFFIX_NOCASE )
						$tmp .= 'i';
					$statement[ $subject ] = ( $theCondition == kOPERATOR_NAND )
										   ? array( '$not' => new MongoRegex( $tmp ) )
										   : new MongoRegex( $tmp );
					break;
			
				//
				// REGULAR EXPRESSION.
				//
				case kOPERATOR_REGEX:
					$statement[ $subject ] = ( $theCondition == kOPERATOR_NAND )
										   ? array( '$not' => new MongoRegex( $data ) )
										   : new MongoRegex( $data );
					break;
			
				//
				// LESS THAN.
				//
				case kOPERATOR_LESS:
					$theContainer->UnserialiseData( $data, $type );
					$statement[ $subject ] = ( $theCondition == kOPERATOR_NAND )
										   ? array( '$not' => array( '$lt' => $data ) )
										   : array( '$lt' => $data );
					break;
			
				//
				// LESS THAN OR EQUAL.
				//
				case kOPERATOR_LESS_EQUAL:
					$theContainer->UnserialiseData( $data, $type );
					$statement[ $subject ] = ( $theCondition == kOPERATOR_NAND )
										   ? array( '$not' => array( '$lte' => $data ) )
										   : array( '$lte' => $data );
					break;
			
				//
				// GREATER THAN.
				//
				case kOPERATOR_GREAT:
					$theContainer->UnserialiseData( $data, $type );
					$statement[ $subject ] = ( $theCondition == kOPERATOR_NAND )
										   ? array( '$not' => array( '$gt' => $data ) )
										   : array( '$gt' => $data );
					break;
			
				//
				// GREATER THAN OR EQUAL.
				//
				case kOPERATOR_GREAT_EQUAL:
					$theContainer->UnserialiseData( $data, $type );
					$statement[ $subject ] = ( $theCondition == kOPERATOR_NAND )
										   ? array( '$not' => array( '$gte' => $data ) )
										   : array( '$gte' => $data );
					break;
			
				//
				// RANGE INCLUSIVE.
				//
				case kOPERATOR_IRANGE:
					$list = $this->_OrderRange( $data,
												$theContainer,
												$theStatement[ kOFFSET_QUERY_TYPE ] );
					$statement[ $subject ]
						= ( $theCondition == kOPERATOR_NAND )
						? array( '$not' => array( '$gte' => array_shift( $list ),
												  '$lte' => array_shift( $list ) ) )
						: array( '$gte' => array_shift( $list ),
								 '$lte' => array_shift( $list ) );
					break;
			
				//
				// RANGE EXCLUSIVE.
				//
				case kOPERATOR_ERANGE:
					$list = $this->_OrderRange( $data,
												$theContainer,
												$theStatement[ kOFFSET_QUERY_TYPE ] );
					$statement[ $subject ]
						= ( $theCondition == kOPERATOR_NAND )
						? array( '$not' => array( '$gt' => array_shift( $list ),
												  '$lt' => array_shift( $list ) ) )
						: array( '$gt' => array_shift( $list ),
								 '$lt' => array_shift( $list ) );
					break;
			
				//
				// MISSING.
				//
				case kOPERATOR_NULL:
					$statement[ $subject ]
						= array( '$exists' => ( $theCondition == kOPERATOR_NAND ) );
					break;
			
				//
				// EXISTING.
				//
				case kOPERATOR_NOT_NULL:
					$statement[ $subject ]
						= array( '$exists' => ( $theCondition != kOPERATOR_NAND ) );
					break;
			
				//
				// IN.
				//
				case kOPERATOR_IN:
					$list = Array();
					foreach( $data as $element )
					{
						$theContainer->UnserialiseData( $element, $type );
						$list[] = $element;
					}
					$statement[ $subject ] = ( $theCondition == kOPERATOR_NAND )
										   ? array( '$not' => array( '$in' => $list ) )
										   : array( '$in' => $list );
					break;
			
				//
				// NOT IN.
				//
				case kOPERATOR_NI:
					$list = Array();
					foreach( $data as $element )
					{
						$theContainer->UnserialiseData( $element, $type );
						$list[] = $element;
					}
					$statement[ $subject ] = ( $theCondition == kOPERATOR_NAND )
										   ? array( '$not' => array( '$nin' => $list ) )
										   : array( '$nin' => $list );
					break;
			
				//
				// ALL.
				//
				case kOPERATOR_ALL:
					$list = Array();
					foreach( $data as $element )
					{
						$theContainer->UnserialiseData( $element, $type );
						$list[] = $element;
					}
					$statement[ $subject ] = ( $theCondition == kOPERATOR_NAND )
										   ? array( '$not' => array( '$all' => $list ) )
										   : array( '$all' => $list );
					break;
			
				//
				// DISABLED.
				//
				case kOPERATOR_DISABLED:
					break;
			
				//
				// UNSUPPORTED OPERATORS.
				//
				case kOPERATOR_NALL:
				case kOPERATOR_LIKE_NOT:
					throw new Exception
							( "Unsupported query operator",
							  kERROR_UNSUPPORTED );								// !@! ==>
				
				//
				// Catch unhandled operators.
				//
				default:
					throw new Exception
							( "Unsupported query operator (should have been catched)",
							  kERROR_UNSUPPORTED );								// !@! ==>
			
			} // Parsed operator.
		
		} // Single statement.
	
	} // _ConvertStatement.

	 

/*=======================================================================================
 *																						*
 *								PROTECTED QUERY UTILITIES								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_OrderRange																		*
	 *==================================================================================*/

	/**
	 * <h4>Order range elements</h4>
	 *
	 * This method will order the provided range elements, the method accepts an array of
	 * two elements which represent the range bounds and will return an array with the two
	 * provided elements sorted.
	 *
	 * The method accepts three parameters:
	 *
	 * <ul>
	 *	<li><tt>$theRange</tt>: An array containing two elements representing the range
	 *		bounds.
	 *	<li><tt>$theContainer</tt>: The {@link CMongoContainer} on which the query will be
	 *		executed.
	 *	<li><tt>$theType</tt>: The data type of the range elements.
	 * </ul>
	 *
	 * @param mixed					$theRange				Range elements.
	 * @param CMongoContainer		$theContainer			Query container.
	 * @param string				$theType				Elements data type.
	 *
	 * @access protected
	 * @return array
	 */
	protected function _OrderRange( $theRange, CMongoContainer $theContainer, $theType )
	{
		//
		// Normalise range.
		//
		if( is_array( $theRange )
		 || ($theRange instanceof ArrayObject) )
		{
			$list = array_values( (array) $theRange );
			if( count( $list ) == 1 )
				$list[] = $list[ 0 ];
		}
		else
			$list = array( $theRange, $theRange );
		
		//
		// Convert range elements.
		//
		foreach( $list as $key => $value )
		{
			$theContainer->UnserialiseData( $value );
			$list[ $key ] = $value;
		}
	
		//
		// Parse by data type.
		//
		$switch = FALSE;
		switch( $theType )
		{
			case kTYPE_INT32:
			case kTYPE_INT64:
				if( (double) (string) $list[ 0 ]
					> (double) (string) $list[ 1 ] )
					$switch = TRUE;
				break;
			
			case kTYPE_STAMP:
				$d1 = new CDataTypeStamp( $list[ 0 ] );
				$d2 = new CDataTypeStamp( $list[ 1 ] );
				if( $d1->value() > $d2->value() )
					$switch = TRUE;
				break;
			
			case kTYPE_MongoId:
				if( (string) $list[ 0 ] > (string) $list[ 1 ] )
					$switch = TRUE;
				break;
			
			default:
				if( $list[ 0 ] > $list[ 1 ] )
					$switch = TRUE;
				break;
		}
		
		//
		// Switch elements.
		//
		if( $switch )
		{
			$tmp = $list[ 0 ];
			$list[ 0 ] = $list[ 1 ];
			$list[ 1 ] = $tmp;
		}
		
		return $list;																// ==>
	
	} // _OrderRange.

	 

} // class CMongoQuery.


?>

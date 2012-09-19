<?php

/**
 * <i>CMongoQueryStatement</i> class definition.
 *
 * This file contains the class definition of <b>CMongoQueryStatement</b> which represents a
 * Mongo query statement object.
 *
 *	@package	MyWrapper
 *	@subpackage	Persistence
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 19/09/2012
*/

/*=======================================================================================
 *																						*
 *								CMongoQueryStatement.php								*
 *																						*
 *======================================================================================*/

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CQueryStatement.php" );

/**
 * <h3>Mongo query statement</h3>
 *
 * This class overloads its ancestor to add specific data type management for Mongo
 * databases.
 *
 *	@package	MyWrapper
 *	@subpackage	Persistence
 */
class CMongoQueryStatement extends CQueryStatement
{
		

/*=======================================================================================
 *																						*
 *								STATIC CONVERSION INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	HandleDataType																	*
	 *==================================================================================*/

	/**
	 * <h4>Infer data type</h4>
	 *
	 * We overload this method to handle specific Mongo data types:
	 *
	 * <ul>
	 *	<li><tt>{@link MongoDate}</tt>: Will return the {@link kTYPE_STAMP} type.
	 *	<li><tt>{@link MongoBinData}</tt>: Will return the {@link kTYPE_BINARY} type.
	 *	<li><tt>{@link MongoInt32}</tt>: Will return the {@link kTYPE_INT32} type.
	 *	<li><tt>{@link MongoInt64}</tt>: Will return the {@link kTYPE_INT64} type.
	 * </ul>
	 *
	 * @param reference			   &$theType				Data type.
	 * @param reference			   &$theValue				Data value.
	 *
	 * @static
	 */
	static function HandleDataType( &$theType, &$theValue )
	{
		//
		// Call parent method.
		//
		parent::HandleDataType( $theType, $theValue );
		
		//
		// Parse Mongo specific types.
		//
		if( $theValue instanceof MongoDate )
			$theType = kTYPE_STAMP;
		elseif( $theValue instanceof MongoBinData )
			$theType = kTYPE_BINARY;
		elseif( $theValue instanceof MongoInt32 )
			$theType = kTYPE_INT32;
		elseif( $theValue instanceof MongoInt64 )
			$theType = kTYPE_INT64;
		
		//
		// Convert according to data type.
		//
		switch( $theType )
		{
			case kTYPE_INT32:
				if( ! ($theValue instanceof MongoInt32) )
					$theValue = new MongoInt32( $theValue );
				break;
				
			case kTYPE_INT64:
				if( ! ($theValue instanceof MongoInt64) )
					$theValue = new MongoInt64( $theValue );
				break;
				
			case kTYPE_STAMP:
				if( is_string( $theValue ) )
					$theValue = new MongoDate( strtotime( $theValue ) );
				break;
		
		} // Checking data value.
	
	} // HandleDataType.

	 

} // class CQueryStatement.


?>

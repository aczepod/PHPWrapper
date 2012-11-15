<?php

/**
 * <h4>File utilities</h4>
 *
 * This file contains common file utilities used by the library.
 *
 *	@package	MyWrapper
 *	@subpackage	Functions
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 14/10/2012
 */

/*=======================================================================================
 *																						*
 *										file.php										*
 *																						*
 *======================================================================================*/

/**
 * Errors.
 *
 * This include file contains all error code definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_DEFINE."/Errors.inc.php" );



/*=======================================================================================
 *																						*
 *									DIRECTORY UTILITIES									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	DeleteFileDir																	*
	 *==================================================================================*/

	/**
	 * <h4>Delete a file or directory</h4>
	 *
	 * If provided with a file path this function will delete it; if provided with a
	 * directory path, it will recursively remove its contents and delete it also.
	 *
	 * @param string				$thePath			Directory path.
	 *
	 * @return string				JSON string.
	 */
	function DeleteFileDir( $thePath )
	{
		//
		// Handle file.
		//
		if( is_file( $thePath ) )
			@unlink( $thePath );
		
		//
		// Handle directory.
		//
		elseif( is_dir( $thePath ) )
		{
			//
			// Get directory iterator.
			//
			$iter = new DirectoryIterator( $thePath );
			foreach( $iter as $file )
			{
				if( ! $file->isDot() )
					DeleteFileDir( $file->getRealPath() );
			}
			
			//
			// Remove directory.
			//
			@rmdir( $thePath );
		
		} // Provided directory.
	
	} // DeleteFileDir.


?>

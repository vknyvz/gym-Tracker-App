<?php
/**
 * vkNgine3 Admin System
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the new BSD license.
 *
 * @category    core
 * @package     vkNgine3
 * @copyright   Copyright (c) 2011 Volkan Yavuz (http://www.vknyvz.com)
 */
class vkNgine_CsvGenerator 
{
	public function generateSheet($titles, $content, $filename = 'sheet.csv')
	{
		// output bit headers
		header("Cache-Control: cache, must-revalidate");   
		header("Pragma: public");
		header('Content-type: text/csv');
		header('Content-Disposition: attachment; filename="' . $filename . '"');

		// open file to write to 
		$fp = fopen('php://output', 'w');
		
		// write titles to csv file
		fputcsv($fp, $titles);
		
		// write content to csv file
		foreach ($content as $row) {
			fputcsv($fp, $row);
		}
		
		// spit out the file
		fclose($fp);
	}    
}
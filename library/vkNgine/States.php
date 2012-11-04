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
class vkNgine_States
{
	/**
	 * states data
	 * 
	 * @var array
	 */
	static $STATES = array (
		'AL' => 'ALABAMA',
		'AK' => 'ALASKA',
		'AS' => 'AMERICAN SAMOA',
		'AZ' => 'ARIZONA',
		'AR' => 'ARKANSAS',
		'CA' => 'CALIFORNIA',
		'CO' => 'COLORADO',
		'CT' => 'CONNECTICUT',
		'DE' => 'DELAWARE',
		'DC' => 'DISTRICT OF COLUMBIA',
		'FM' => 'FEDERATED STATES OF MICRONESIA',
		'FL' => 'Florida',
		'GA' => 'Georgia',
		'GU' => 'GUAM',
		'HI' => 'HAWAII',
		'ID' => 'IDAHO',
		'IL' => 'ILLINOIS',
		'IN' => 'INDIANA',
		'IA' => 'Iowa',
		'KS' => 'KANSAS',
		'KY' => 'KENTUCKY',
		'LA' => 'LOUISIANA',
		'ME' => 'MAINE',
		'MH' => 'MARSHALL ISLANDS',
		'MD' => 'MARYLAND',
		'MA' => 'MASSACHUSETTS',
		'MI' => 'MICHIGAN',
		'MN' => 'MINNESOTA',
		'MS' => 'MISSISSIPPI',
		'MO' => 'MISSOURI',
		'MT' => 'Montana',
		'NE' => 'NEBRASKA',
		'NV' => 'Nevada',
		'NH' => 'New HAMPSHIRE',
		'NJ' => 'New JERSEY',
		'NM' => 'New MEXICO',
		'NY' => 'New York',
		'NC' => 'NORTH CAROLINA',
		'ND' => 'NORTH DAKOTA',
		'MP' => 'NORTHERN MARIANA ISLANDS',
		'OH' => 'OHIO',
		'OK' => 'OKLAHOMA',
		'OR' => 'OREGON',
		'PW' => 'PALAU',
		'PA' => 'PENNSYLVANIA',
		'PR' => 'PUERTO RICO',
		'RI' => 'RHODE ISLAND',
		'SC' => 'SOUTH CAROLINA',
		'SD' => 'SOUTH DAKOTA',
		'TN' => 'TENNESSEE',
		'TX' => 'Texas',
		'UT' => 'Utah',
		'VT' => 'VERMONT',
		'VI' => 'VIRGIN ISLANDS',
		'VA' => 'VIRGINIA',
		'WA' => 'WASHINGTON',
		'WV' => 'WEST VIRGINIA',
		'WI' => 'WISCONSIN',
		'WY' => 'WYOMING',
		'AB' => 'Alberta',
		'BC' => 'British Columbia',
		'MB' => 'Manitoba',
		'NB' => 'New Brunswick',
		'NL' => 'Newfoundland & Labrador',
		'NT' => 'Northwest Territories',
		'NS' => 'Nova Scotia',
		'NU' => 'Nunavut',
		'ON' => 'Ontario', 
		'PE' => 'Prince Edward Island',
		'QC' => 'Quebec',
		'SK' => 'Saskatchewan',
		'YT' => 'Yukon',
		'Other' => 'Other than USA or Canada'
	);
	
	/**
	 * spit them out with first letter capital
	 * 
	 * @param string $str
	 * @return string
	 */
	static function ucwords($str)
	{
		return ucwords(mb_strtolower($str));
	}
	
	/**
	 * returns all states
	 * 
	 * @return multitype:
	 */
	static function getStates()
	{
		return array_map('vkNgine_States::ucwords', self::$STATES);
	}
}
?>
<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @license LGPL-3.0+
 */

namespace Contao;


/**
 * Front end content element "text".
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class Styleguide extends \ContentElement
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_styleguide';


	/**
	 * Generate the content element
	 */
	protected function compile()
	{
		// turn the hex-value into a r,g,b-value
		$hex2rgb = function($hex) {
			$hex = str_replace("#", "", $hex);

			if(strlen($hex) == 3) {
			  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
			  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
			  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
			} else {
			  $r = hexdec(substr($hex,0,2));
			  $g = hexdec(substr($hex,2,2));
			  $b = hexdec(substr($hex,4,2));
			}
			$rgb = array($r, $g, $b);
			return implode(",", $rgb); // returns the rgb values separated by commas
			//return $rgb; // returns an array with the rgb values
		};

		// turn the r,g,b-value into a hex-value
		$rgb2hex = function($rgb) {
			$hex = "#";
			$hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
			$hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
			$hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

			return $hex; // returns the hex value including the number sign (#)
		};

		// Get company table
		$companyData = Database::getInstance()->prepare("SELECT * FROM tl_companies WHERE id=?")->execute($this->company_select);

		// Add styleguide fields to the template
		$this->Template->company								= $companyData->company;

		// Get styleguide table
		$styleguideData = Database::getInstance()->prepare("SELECT * FROM tl_styleguides WHERE company=?")->execute($this->company_select);

		// Add styleguide fields to the template
		$this->Template->logoSingleSRC					= \FilesModel::findByUuid($styleguideData->logo);
		$this->Template->logoNegativeSingleSRC	= \FilesModel::findByUuid($styleguideData->logo_negative);

		$size																		= deserialize($styleguideData->size);
		if (is_numeric($size[2])) {
			$this->Template->picture							= false;
		} else {
			$this->Template->picture							= true;
		}
		$this->Template->size										= $size;
		$colors																	= deserialize($styleguideData->color);
		$colors 																= array_map($hex2rgb, $colors);
		$this->Template->colors									= $colors;
		$this->Template->types									= deserialize($styleguideData->type);

		// Add image to template
		//$this->addImageToTemplate($this->Template, $singleSRC);
	}
}

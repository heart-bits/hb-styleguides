<?php

/**
 * Contao Open Source CMS
 *
 * @copyright  Sascha Wustmann 2016
 * @package    hb-styleguides
 * @license    GNU/LGPL
 * @filesource
 */

/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_content']['palettes']['styleguide'] = '{type_legend},type,company_select;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';

// Fields
$GLOBALS['TL_DCA']['tl_content']['fields']['company_select'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['company_select'],
	'exclude' => true,
	'sql' => 'int(100) unsigned NULL',
	'foreignKey' => 'tl_companies.CONCAT(company," (",geocoderAddress,")")',
	'inputType'	=> 'select',
	'eval' => array('includeBlankOption' => true, 'tl_class'=>'w50 clr')
);

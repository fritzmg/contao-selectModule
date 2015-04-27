<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  MEN AT WORK 2012
 * @package    selectModule
 * @license    GNU/LGPL
 * @filesource
 */
class SelectModule extends Module
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'sm_default';

    /**
     * Display a wildcard in the back end
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE') {
            $objTemplate = new BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### SELECTMODULE ###';
            $objTemplate->title    = $this->headline;
            $objTemplate->id       = $this->id;
            $objTemplate->link     = $this->name;
            $objTemplate->href     = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        return parent::generate();
    }

    /**
     * Generate module
     */
    public function compile()
    {
        $strReturn = "";

        foreach (deserialize($this->sm_wizard) as $arrValue) {
            if ($GLOBALS["TL_LANGUAGE"] == $arrValue["language"]) {
                $arrType = explode('-', $arrValue["module"]);
                switch ($arrType[1]) {
                    case 'module':
                        $strReturn .= $this->getFrontendModule($arrType[0]);
                        break;
                    case 'form':
                        $strReturn .= $this->getForm($arrType[0]);
                        break;
                }
            }
        }

        $this->Template->searchable = ($this->sm_searchable == 1) ? true : false;
        $this->Template->content    = $strReturn;
    }

}

?>
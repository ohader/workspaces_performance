<?php
/***************************************************************
 * Copyright notice
 *
 * (c) 2012 Oliver Hader <oliver.hader@typo3.org>
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile GPL.txt and important notices to the license
 * from the author is found in LICENSE.txt distributed with these scripts.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * @author Oliver Hader <oliver.hader@typo3.org>
 * @package EXT:workspaces_performance
 */
class Tx_WorkspacesPerformance_Bootstrap {
	/**
	 * @return Tx_WorkspacesPerformance_Bootstrap
	 */
	public static function getInstance() {
		return t3lib_div::makeInstance('Tx_WorkspacesPerformance_Bootstrap');
	}

	/**
	 * Alternative dispatcher to modify Extbase behaviour.
	 *
	 * @param string $moduleSignature
	 * @return boolean FALSE since following dispatches shall take care
	**/
	public function callModule($moduleSignature) {
		if ($moduleSignature === 'web_WorkspacesWorkspaces') {
			$this->getObjectContainer()->registerImplementation(
				'Tx_Extbase_Configuration_BackendConfigurationManager',
				'Tx_WorkspacesPerformance_Configuration_BackendConfigurationManager'
			);
		}

		return FALSE;
	}

	/**
	 * Disables TypoScript parsing of Extbase in the backend.
	 */
	public function registerAlternativeModuleDispatcher() {
		if (empty($GLOBALS['TBE_MODULES']['_dispatcher'])) {
			$GLOBALS['TBE_MODULES']['_dispatcher'] = array();
		}

		array_unshift(
			$GLOBALS['TBE_MODULES']['_dispatcher'],
			'Tx_WorkspacesPerformance_Bootstrap'
		);
	}

	/**
	 * @return Tx_Extbase_Object_Container_Container
	 */
	protected function getObjectContainer() {
		return t3lib_div::makeInstance('Tx_Extbase_Object_Container_Container');
	}
}

?>
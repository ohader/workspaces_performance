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
class Tx_WorkspacesPerformance_Configuration_BackendConfigurationManager extends Tx_Extbase_Configuration_BackendConfigurationManager {
	/**
	 * Returns the TypoScript configuration found in config.tx_extbase
	 *
	 * @return array
	 */
	protected function getExtbaseConfiguration() {
		return $this->getStaticExtbaseConfiguration();
	}

	/**
	 * Ensures no TypoScript is parsed.
	 *
	 * @return array the raw TypoScript setup
	 */
	public function getTypoScriptSetup() {
		return array();
	}

	/**
	 * @return array
	 */
	protected function getStaticExtbaseConfiguration() {
		$fileName = t3lib_div::getFileAbsFileName('EXT:workspaces_performance/Resources/Configuration.php');
		$configuration = include $fileName;
		return $configuration;
	}
}
?>
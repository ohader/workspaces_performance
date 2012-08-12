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
class ux_tx_Workspaces_Service_GridData extends tx_Workspaces_Service_GridData implements t3lib_Singleton {
	/**
	 * @var array
	 */
	protected $configuration;

	/**
	 * Calculates the percentage of changes between two records.
	 *
	 * @param string $table
	 * @param array $diffRecordOne
	 * @param array $diffRecordTwo
	 * @return integer
	 */
	public function calculateChangePercentage($table, array $diffRecordOne, array $diffRecordTwo) {
		if (!$this->getConfigurationValue('enablePercentageCalculation')) {
			return 0;
		}

		return parent::calculateChangePercentage($table, $diffRecordOne, $diffRecordTwo);
	}

	/**
	 * @return array
	 */
	protected function getConfiguration() {
		if (!isset($this->configuration)) {
			$this->configuration = array();

			if (!empty($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['workspaces_performance'])) {
				$this->configuration = (array) unserialize(
					$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['workspaces_performance']
				);
			}
		}

		return $this->configuration;
	}

	/**
	 * @param string $name
	 * @return NULL|string
	 */
	protected function getConfigurationValue($name) {
		$value = NULL;
		$configuration = $this->getConfiguration();

		if (isset($configuration[$name])) {
			$value = $configuration[$name];
		}

		return $value;
	}
}

?>
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
class Tx_WorkspacesPerformance_Utility_WorkspaceUtility implements t3lib_Singleton {
	/**
	 * @var array
	 */
	protected $workspaces;

	/**
	 * @var array
	 */
	protected $recordViewUrls = array();

	/**
	 * @return Tx_WorkspacesPerformance_Utility_WorkspaceUtility
	 */
	public static function getInstance() {
		return t3lib_div::makeInstance('Tx_WorkspacesPerformance_Utility_WorkspaceUtility');
	}

	/**
	 * Find the title for the requested workspace.
	 *
	 * @param integer $workspaceId
	 * @return string
	 */
	public function getTitle($workspaceId) {
		$title = FALSE;

		switch ($workspaceId) {
			case tx_Workspaces_Service_Workspaces::LIVE_WORKSPACE_ID:
				$title = $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_misc.xml:shortcut_onlineWS');
				break;
			case tx_Workspaces_Service_Workspaces::DRAFT_WORKSPACE_ID:
				$title = $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_misc.xml:shortcut_offlineWS');
				break;
			default:
				$labelField = $GLOBALS['TCA']['sys_workspace']['ctrl']['label'];
				$workspace = $this->findById($workspaceId);
				if (is_array($workspace)) {
					$title = $workspace[$labelField];
				}
		}

		if ($title === FALSE) {
			throw new InvalidArgumentException('No such workspace defined');
		}

		return $title;
	}

	/**
	 * @param string $orderBy
	 * @return array
	 */
	public function findAll($orderBy = 'uid') {
		if (!isset($this->workspaces)) {
			$this->workspaces = $this->getDatabase()->exec_SELECTgetRows(
				'*',
				'sys_workspace',
				'pid=0' . t3lib_BEfunc::deleteClause('sys_workspace'),
				'',
				'',
				'',
				'uid'
			);

			if (!is_array($this->workspaces)) {
				$this->workspaces = array();
			}
		}

		$workspaces = $this->workspaces;

		if ($orderBy !== 'uid') {
			$workspaces = Tx_WorkspacesPerformance_Utility_SortUtility::getInstance()->sort(
				$workspaces,
				$orderBy
			);
		}

		return $workspaces;
	}

	/**
	 * @param integer $workspaceId
	 * @return array|NULL
	 */
	public function findById($workspaceId) {
		$workspace = NULL;
		$this->findAll();

		if (!empty($this->workspaces[$workspaceId])) {
			$workspace = $this->workspaces[$workspaceId];
		}

		return $workspace;
	}


	/**
	 * Generates a view link for a page.
	 *
	 * @param string $table
	 * @param integer $uid
	 * @param array $record
	 * @return string
	 */
	public function getRecordViewUrl($table, $uid, array $record = NULL) {
		$identifier = $table . ':' . $uid . ':' . md5(serialize($record));

		if (isset($this->recordViewUrls[$identifier])) {
			return $this->recordViewUrls[$identifier];
		}

		$this->recordViewUrls[$identifier] = '';

		if ($table == 'pages') {
			$this->recordViewUrls[$identifier] = t3lib_BEfunc::viewOnClick(t3lib_BEfunc::getLiveVersionIdOfRecord('pages', $uid));
		} elseif ($table == 'pages_language_overlay' || $table == 'tt_content') {
			$elementRecord = is_array($record) ? $record : t3lib_BEfunc::getLiveVersionOfRecord($table, $uid);
			$this->recordViewUrls[$identifier] = t3lib_BEfunc::viewOnClick($elementRecord['pid']);
		} elseif (!empty($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['workspaces']['viewSingleRecord'])) {
			$_params = array('table' => $table, 'uid' => $uid, 'record' => $record);
			$_funcRef = $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['workspaces']['viewSingleRecord'];
			$null = NULL;
			$this->recordViewUrls[$identifier] = t3lib_div::callUserFunction($_funcRef, $_params, $null);
		}

		return $this->recordViewUrls[$identifier];
	}

	/**
	 * @return t3lib_DB
	 */
	protected function getDatabase() {
		return $GLOBALS['TYPO3_DB'];
	}
}
?>

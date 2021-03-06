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
class Tx_WorkspacesPerformance_Utility_PageUtility implements t3lib_Singleton {
	/**
	 * Contains sub elements by permissionClause.
	 *
	 * @var array
	 */
	protected $pages = array();

	/**
	 * @var array
	 */
	protected $paths = array();

	/**
	 * @var string
	 */
	protected $fieldList;

	/**
	 * @return Tx_WorkspacesPerformance_Utility_PageUtility
	 */
	public static function getInstance() {
		return t3lib_div::makeInstance('Tx_WorkspacesPerformance_Utility_PageUtility');
	}

	/**
	 * Creates this object.
	 *
	 * Prior to TYPO3 4.7 the t3ver_swapmode field was available
	 * and will be set to the list of fields to be fetched.
	 *
	 * @see http://review.typo3.org/12552
	 */
	public function __construct() {
		$fieldList = 'uid,pid,tstamp,sorting,deleted,hidden,doktype,' .
			't3ver_oid,t3ver_id,t3ver_wsid,t3ver_label,t3ver_state,t3ver_stage,t3ver_count,t3ver_tstamp,t3ver_move_id,t3_origuid,' .
			'perms_userid,perms_groupid,perms_user,perms_group,perms_everybody';

		if ($this->getVersionInteger(TYPO3_version) < $this->getVersionInteger('4.7.0')) {
			$fieldList .= ',t3ver_swapmode';
		}

		$this->setFieldList($fieldList);
	}

	/**
	 * Sets the list of fields to be fetched.
	 *
	 * @param string $fieldList
	 */
	public function setFieldList($fieldList) {
		$this->fieldList = (string) $fieldList;
	}

	/**
	 * Gets the list of fields to be fetched.
	 *
	 * @return string
	 */
	public function getFieldList() {
		return $this->fieldList;
	}

	/**
	 * Gets list of pages in defined tree.
	 *
	 * @param integer $id
	 * @param integer $depth
	 * @param integer $begin
	 * @param string $permissionClause
	 * @return string
	 */
	public function getTreeList($id, $depth, $begin = 0, $permissionClause) {
		$depth = intval($depth);
		$begin = intval($begin);
		$id = intval($id);

		if ($begin == 0) {
			$treeList = $id;
		} else {
			$treeList = '';
		}

		if ($id && $depth > 0) {
			$pages = $this->findByPid($id, $permissionClause);

			foreach ($pages as $page) {
				if ($begin <= 0) {
					$treeList .= ',' . $page['uid'];
				}
				if ($depth > 1) {
					$treeList .= $this->getTreeList($page['uid'], $depth - 1, $begin - 1, $permissionClause);
				}
			}
		}

		return $treeList;
	}

	/**
	 * @param integer $id
	 * @param integer $segmentLength
	 * @return string
	 */
	public function getPath($id, $segmentLength = 1000) {
		if (!isset($this->paths[$id])) {
			$path = '/';

			foreach ($this->getRootline($id) as $page) {
				$path = '/' . t3lib_div::fixed_lgd_cs(strip_tags($page['title']), $segmentLength) . $path;
			}

			$this->paths[$id] = $path;
		}

		return $this->paths[$id];
	}

	/**
	 * @param integer $id
	 * @return array
	 */
	public function getRootline($id) {
		$rootline = array();

		while ($id) {
			$page = $this->findById($id);

			if ($page === NULL) {
				break;
			}

			$rootline[] = $page;
			$id = $page['pid'];
		}

		return $rootline;
	}

	/**
	 * @param integer $id
	 * @param string $permissionClause
	 * @return array|NULL
	 */
	public function findById($id, $permissionClause = '1=1') {
		$page = NULL;

		$this->findAll($permissionClause);
		if (!empty($this->pages[$permissionClause][$id])) {
			$page = $this->pages[$permissionClause][$id];
		}

		return $page;
	}

	/**
	 * @param integer $pid
	 * @param string $permissionClause
	 * @return array
	 */
	public function findByPid($pid, $permissionClause = '1=1') {
		$pages = array();

		foreach ($this->findAll($permissionClause) as $page) {
			if (isset($page['pid']) && intval($page['pid']) === $pid) {
				$pages[] = $page;
			}
		}

		return $pages;
	}

	/**
	 * @param string $permissionClause
	 * @return array
	 */
	protected function findAll($permissionClause = '1=1') {
		if (!isset($this->pages[$permissionClause])) {
			$this->pages[$permissionClause] = $this->getDatabase()->exec_SELECTgetRows(
				$this->getFieldList(),
				'pages',
				$permissionClause . t3lib_BEfunc::deleteClause('pages'),
				'',
				'',
				'',
				'uid'
			);

			if (!is_array($this->pages[$permissionClause])) {
				$this->pages[$permissionClause] = array();
			}
		}

		return $this->pages[$permissionClause];
	}

	/**
	 * Gets a version string as integer representation.
	 *
	 * @param string $versionString
	 * @return integer
	 */
	protected function getVersionInteger($versionString) {
		return t3lib_utility_VersionNumber::convertVersionNumberToInteger($versionString);
	}

	/**
	 * @return t3lib_DB
	 */
	protected function getDatabase() {
		return $GLOBALS['TYPO3_DB'];
	}
}
?>

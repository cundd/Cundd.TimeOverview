<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Daniel Corn <info@cundd.net>, cundd
 *  			
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Test case for class Tx_CunddTimeOverview_Domain_Model_Task.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Time Overview
 *
 * @author Daniel Corn <info@cundd.net>
 */
class Tx_CunddTimeOverview_Domain_Model_TaskTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_CunddTimeOverview_Domain_Model_Task
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_CunddTimeOverview_Domain_Model_Task();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getTitleReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTitleForStringSetsTitle() { 
		$this->fixture->setTitle('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTitle()
		);
	}
	
	/**
	 * @test
	 */
	public function getDescriptionReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setDescriptionForStringSetsDescription() { 
		$this->fixture->setDescription('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getDescription()
		);
	}
	
	/**
	 * @test
	 */
	public function getRecordsReturnsInitialValueForObjectStorageContainingTx_CunddTimeOverview_Domain_Model_Record() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getRecords()
		);
	}

	/**
	 * @test
	 */
	public function setRecordsForObjectStorageContainingTx_CunddTimeOverview_Domain_Model_RecordSetsRecords() { 
		$record = new Tx_CunddTimeOverview_Domain_Model_Record();
		$objectStorageHoldingExactlyOneRecords = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneRecords->attach($record);
		$this->fixture->setRecords($objectStorageHoldingExactlyOneRecords);

		$this->assertSame(
			$objectStorageHoldingExactlyOneRecords,
			$this->fixture->getRecords()
		);
	}
	
	/**
	 * @test
	 */
	public function addRecordToObjectStorageHoldingRecords() {
		$record = new Tx_CunddTimeOverview_Domain_Model_Record();
		$objectStorageHoldingExactlyOneRecord = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneRecord->attach($record);
		$this->fixture->addRecord($record);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneRecord,
			$this->fixture->getRecords()
		);
	}

	/**
	 * @test
	 */
	public function removeRecordFromObjectStorageHoldingRecords() {
		$record = new Tx_CunddTimeOverview_Domain_Model_Record();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($record);
		$localObjectStorage->detach($record);
		$this->fixture->addRecord($record);
		$this->fixture->removeRecord($record);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getRecords()
		);
	}
	
}
?>
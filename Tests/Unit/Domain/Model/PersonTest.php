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
 * Test case for class Tx_CunddTimeOverview_Domain_Model_Person.
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
class Tx_CunddTimeOverview_Domain_Model_PersonTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_CunddTimeOverview_Domain_Model_Person
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_CunddTimeOverview_Domain_Model_Person();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getUsernameReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setUsernameForStringSetsUsername() { 
		$this->fixture->setUsername('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getUsername()
		);
	}
	
	/**
	 * @test
	 */
	public function getPasswordReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setPasswordForStringSetsPassword() { 
		$this->fixture->setPassword('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getPassword()
		);
	}
	
	/**
	 * @test
	 */
	public function getFirstNameReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setFirstNameForStringSetsFirstName() { 
		$this->fixture->setFirstName('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getFirstName()
		);
	}
	
	/**
	 * @test
	 */
	public function getLastNameReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setLastNameForStringSetsLastName() { 
		$this->fixture->setLastName('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getLastName()
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
	
	/**
	 * @test
	 */
	public function getProjectsReturnsInitialValueForObjectStorageContainingTx_CunddTimeOverview_Domain_Model_Project() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getProjects()
		);
	}

	/**
	 * @test
	 */
	public function setProjectsForObjectStorageContainingTx_CunddTimeOverview_Domain_Model_ProjectSetsProjects() { 
		$project = new Tx_CunddTimeOverview_Domain_Model_Project();
		$objectStorageHoldingExactlyOneProjects = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneProjects->attach($project);
		$this->fixture->setProjects($objectStorageHoldingExactlyOneProjects);

		$this->assertSame(
			$objectStorageHoldingExactlyOneProjects,
			$this->fixture->getProjects()
		);
	}
	
	/**
	 * @test
	 */
	public function addProjectToObjectStorageHoldingProjects() {
		$project = new Tx_CunddTimeOverview_Domain_Model_Project();
		$objectStorageHoldingExactlyOneProject = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneProject->attach($project);
		$this->fixture->addProject($project);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneProject,
			$this->fixture->getProjects()
		);
	}

	/**
	 * @test
	 */
	public function removeProjectFromObjectStorageHoldingProjects() {
		$project = new Tx_CunddTimeOverview_Domain_Model_Project();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($project);
		$localObjectStorage->detach($project);
		$this->fixture->addProject($project);
		$this->fixture->removeProject($project);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getProjects()
		);
	}
	
	/**
	 * @test
	 */
	public function getSpecialRecordsReturnsInitialValueForObjectStorageContainingTx_CunddTimeOverview_Domain_Model_SpecialRecord() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getSpecialRecords()
		);
	}

	/**
	 * @test
	 */
	public function setSpecialRecordsForObjectStorageContainingTx_CunddTimeOverview_Domain_Model_SpecialRecordSetsSpecialRecords() { 
		$specialRecord = new Tx_CunddTimeOverview_Domain_Model_SpecialRecord();
		$objectStorageHoldingExactlyOneSpecialRecords = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneSpecialRecords->attach($specialRecord);
		$this->fixture->setSpecialRecords($objectStorageHoldingExactlyOneSpecialRecords);

		$this->assertSame(
			$objectStorageHoldingExactlyOneSpecialRecords,
			$this->fixture->getSpecialRecords()
		);
	}
	
	/**
	 * @test
	 */
	public function addSpecialRecordToObjectStorageHoldingSpecialRecords() {
		$specialRecord = new Tx_CunddTimeOverview_Domain_Model_SpecialRecord();
		$objectStorageHoldingExactlyOneSpecialRecord = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneSpecialRecord->attach($specialRecord);
		$this->fixture->addSpecialRecord($specialRecord);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneSpecialRecord,
			$this->fixture->getSpecialRecords()
		);
	}

	/**
	 * @test
	 */
	public function removeSpecialRecordFromObjectStorageHoldingSpecialRecords() {
		$specialRecord = new Tx_CunddTimeOverview_Domain_Model_SpecialRecord();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($specialRecord);
		$localObjectStorage->detach($specialRecord);
		$this->fixture->addSpecialRecord($specialRecord);
		$this->fixture->removeSpecialRecord($specialRecord);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getSpecialRecords()
		);
	}
	
}
?>
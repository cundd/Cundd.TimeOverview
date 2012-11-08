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
 * Test case for class Tx_CunddTimeOverview_Domain_Model_Record.
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
class Tx_CunddTimeOverview_Domain_Model_RecordTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_CunddTimeOverview_Domain_Model_Record
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_CunddTimeOverview_Domain_Model_Record();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getStartReturnsInitialValueForDateTime() { }

	/**
	 * @test
	 */
	public function setStartForDateTimeSetsStart() { }
	
	/**
	 * @test
	 */
	public function getEndReturnsInitialValueForDateTime() { }

	/**
	 * @test
	 */
	public function setEndForDateTimeSetsEnd() { }
	
	/**
	 * @test
	 */
	public function getCommentReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setCommentForStringSetsComment() { 
		$this->fixture->setComment('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getComment()
		);
	}
	
	/**
	 * @test
	 */
	public function getPersonReturnsInitialValueForTx_CunddTimeOverview_Domain_Model_Person() { }

	/**
	 * @test
	 */
	public function setPersonForTx_CunddTimeOverview_Domain_Model_PersonSetsPerson() { }
	
	/**
	 * @test
	 */
	public function getTaskReturnsInitialValueForTx_CunddTimeOverview_Domain_Model_Task() { }

	/**
	 * @test
	 */
	public function setTaskForTx_CunddTimeOverview_Domain_Model_TaskSetsTask() { }
	
}
?>
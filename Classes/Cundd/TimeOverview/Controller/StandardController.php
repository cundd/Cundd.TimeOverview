<?php
namespace Cundd\TimeOverview\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Cundd.TimeOverview".    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use \Cundd\TimeOverview\Domain\Model\Tasl as Task;

/**
 * Standard controller for the Cundd.TimeOverview package 
 *
 * @Flow\Scope("singleton")
 */
class StandardController extends \TYPO3\Flow\Mvc\Controller\ActionController {
	/**
	 * action list
	 *
	 * @return void
	 */
	public function indexAction() {
		$this->redirect('calendar', 'Record');
	}
}
?>
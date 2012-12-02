<?php
namespace Cundd\TimeOverview\Command;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Cundd.TimeOverview".    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Cundd\TimeOverview\Controller\RecordController;

/**
 * Import command controller for the Cundd.TimeOverview package
 *
 * @Flow\Scope("singleton")
 */
class ImportCommandController extends \TYPO3\Flow\Cli\CommandController {
	/**
	 * Record controller
	 *
	 * @Flow\Inject
	 * @var \Cundd\TimeOverview\Controller\RecordController
	 */
	protected $recordController;

	/**
	 * Import the given file
	 *
	 * @param string $file The file to import data from
	 * @return void
	 */
	public function importCommand($file) {
		if (!is_readable($file)) {
			\Iresults\Core\Iresults::say($file . ': No such file or directory', \Iresults\Core\Iresults\Core\Command\ColorInterface::RED);
			$this->sendAndExit(1);
		}
		$this->recordController->importFromFile($file);
	}

}

?>
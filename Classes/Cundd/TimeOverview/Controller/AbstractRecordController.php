<?php
namespace Cundd\TimeOverview\Controller;

ini_set('display_errors', TRUE);
/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Cundd.TimeOverview".    *
 *                                                                        *
 *                                                                        */
use TYPO3\Flow\Annotations as Flow;
use Cundd\TimeOverview\Domain\Model\Date as Date;
use Cundd\TimeOverview\Domain\Model\Record as Record;
use Cundd\TimeOverview\Domain\Model\SpecialRecord as SpecialRecord;
use Cundd\TimeOverview\Domain\Repository\RecordRepository as RecordRepository;
use Iresults\Core as Iresults;
use Iresults\Core\Nil;
use Iresults\Core\DateTime as DateTime;

set_time_limit(0);

/**
 * Standard controller for the Cundd.TimeOverview package
 *
 * @Flow\Scope("singleton")
 */
class AbstractRecordController extends \TYPO3\Flow\Mvc\Controller\ActionController {
	/**
	 * Better handle date inputs
	 *
	 * @return  void
	 */
	public function initializeAction() {
		$argument = '';
		if ($this->arguments->hasArgument('newSpecialRecord')) {
			$argument = 'newSpecialRecord';
		} else if ($this->arguments->hasArgument('specialRecord')) {
			$argument = 'specialRecord';
		} else if ($this->arguments->hasArgument('record')) {
			$argument = 'record';
		} else if ($this->arguments->hasArgument('newRecord')) {
			$argument = 'newRecord';
		} else {
			return;
		}

		$this->arguments[$argument]
			->getPropertyMappingConfiguration()
			->forProperty('start')
			->setTypeConverterOption('TYPO3\Flow\Property\TypeConverter\DateTimeConverter', \TYPO3\Flow\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'Y-m-d H:i');

		$this->arguments[$argument]
			->getPropertyMappingConfiguration()
			->forProperty('end')
			->setTypeConverterOption('TYPO3\Flow\Property\TypeConverter\DateTimeConverter', \TYPO3\Flow\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'Y-m-d H:i');
	}
}
?>
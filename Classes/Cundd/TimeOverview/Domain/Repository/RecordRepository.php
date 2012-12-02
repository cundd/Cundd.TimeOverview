<?php
namespace Cundd\TimeOverview\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Cundd.TimeOverview".    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * Standard controller for the Cundd.TimeOverview package
 *
 * @Flow\Scope("singleton")
 */
class RecordRepository extends \TYPO3\Flow\Persistence\Repository {
	/**
	 * The different calendar modes
	 */
	const CALENDAR_MODE = 'CALENDAR_MODE';

	/**
	 * Calendar mode to display a single year
	 */
	const CALENDAR_MODE_YEAR = 'CALENDAR_MODE_YEAR';

	/**
	 * Calendar mode to display a single month
	 */
	const CALENDAR_MODE_MONTH = 'CALENDAR_MODE_MONTH';

	/**
	 * Calendar mode to display a single week
	 */
	const CALENDAR_MODE_WEEK = 'CALENDAR_MODE_WEEK';

	/**
	 * Calendar mode to display a single day
	 */
	const CALENDAR_MODE_DAY = 'CALENDAR_MODE_DAY';

	/**
	 * Returns all records for the given calendar mode and date
	 *
	 * @param  string 		$calendarMode The calendar mode to display records of a single day, week, month or year
	 * @param  \DateTime 	$date         A date that lies within the calendar mode period
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 */
	public function findByCalendarModeAndDate($calendarMode, $date) {
		list($start, $end) = $this->getStartAndEndDateForCalenderModeAndDate($calendarMode, $date);
		return $this->findByStartDateBetweenStartAndEnd($start, $end);
	}

	/**
	 * Returns all records between the start and end date
	 *
	 * @param  \DateTime $start The start date
	 * @param  \DateTime $end   The end date
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface        The query result
	 */
	public function findByStartDateBetweenStartAndEnd($start, $end) {
		$query = $this->createQuery();

		$query->matching(
            $query->logicalAnd(
                $query->greaterThanOrEqual('start', $start), 	// The record's start must be bigger than the start date
                $query->lessThan('start', $end),	 			// The record's start must be lower than the end date
                $query->lessThan('end', $end) 					// The record's start must be lower than the end date
            )
        );

        $query->setOrderings(array(
            'start' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_ASCENDING)
        );

		      // ->matching($query->lessThanOrEqual('end', $start->getTimestamp())); 		// The record's start must be lower than the end date

		// \Iresults\Core\Iresults::pd(iterator_to_array($query->execute()));
		return $query->execute();

		// $query->lessThanOrEqual('end', $end);
		// return $query->matching($query->equals($propertyName, $arguments[0], $caseSensitive))->execute();


	}

	/**
	 * Returns if the record exists in the repository.
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Record   $record The record to look for
	 * @return boolean
	 */
	public function hasRecord($record) {
		$query = $this->createQuery();

		$query->matching(
            $query->logicalAnd(
                $query->equals('start', 	$record->getStart()),
                $query->equals('end', 		$record->getEnd()),
                $query->equals('task', 		$record->getTask())
            )
        );
		return $query->count() > 0 ? TRUE : FALSE;

		return $query->matching($query->equals($propertyName, $arguments[0], $caseSensitive))->count();

		$this->recordRepository->hasRecordWithTaskAndStartAndEndDate();
	}

	/**
	 * Returns the start and end date for the given calendar mode and date
	 *
	 * @param  string|CALENDAR_MODE 	$calendarMode The calendar mode to display records of a single day, week, month or year
	 * @param  \DateTime 				$date         A date that lies within the calendar mode period
	 * @return array</DateTime>			Returns an array containing the start and end date
	 */
	public function getStartAndEndDateForCalenderModeAndDate($calendarMode, $date) {
		$end = NULL;
		$start = NULL;
		$endDateString = '';
		$startDateString = '';

		switch ($calendarMode) {
			case self::CALENDAR_MODE_YEAR:
				$startDateString = $date->format('Y') . '-01-01 00:00:00 +0000';
				$endDateString = $date->format('Y') . '-12-31 23:59:59 +0000';
				break;

			case self::CALENDAR_MODE_MONTH:
				$startDateString = $date->format('Y-m') . '-01 00:00:00 +0000';
				$endDateString = $date->format('Y-m-t') . ' 23:59:59 +0000';
				break;

			case self::CALENDAR_MODE_WEEK:
				$startDateString = gmdate('Y-m-d', strtotime('monday this week', $date->getTimestamp())) . ' 00:00:00 +0000';
				$endDateString = gmdate('Y-m-d', strtotime('sunday this week', $date->getTimestamp())) . ' 23:59:59 +0000';
				break;

			case self::CALENDAR_MODE_DAY:
				$startDateString = $date->format('Y-m-d') . ' 00:00:00 +0000';
				$endDateString = $date->format('Y-m-d') . ' 23:59:59 +0000';
				break;

		}

		\Iresults\Core\Iresults::pd($date, $calendarMode, $date->format('Y'));

		$start = new \DateTime($startDateString);
		$end = new \DateTime($endDateString);

		\Iresults\Core\Iresults::pd($start, $startDateString);
		\Iresults\Core\Iresults::pd($end, $endDateString);
		return array($start, $end);
	}
}











?>
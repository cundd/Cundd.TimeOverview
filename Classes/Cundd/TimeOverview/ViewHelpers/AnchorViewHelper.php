<?php
namespace Cundd\TimeOverview\ViewHelpers;

/*                                                                        *
 * This script belongs to the FLOW3 package "Sandstorm.Plumber".          *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3          *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 */
class AnchorViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper {
	/**
	 * Dictionary of rendered dates
	 * @var array
	 */
	protected $renderedDates = array();

	/**
	 * Renders an anchor
	 * @param  \Cundd\TimeOverview\Domain\Model\Date $date
	 * @return string
	 */
	public function render(\Cundd\TimeOverview\Domain\Model\Date $date) {
		$link = '';
		$caption = '';
		$rawDate = $date->getDate();

		if (!isset($this->renderedDates[$rawDate->format('m')])) {
			$link = $rawDate->format('m');
			$caption = $rawDate->format('F');
			$this->renderedDates[$link] = TRUE;

		}
		if ($caption) {
			return sprintf('<a id="%s" title="%s">%s</a>', $link, $caption, $caption);
			return sprintf('<a id="%s" title="%s">%s</a>', $link, $caption, $caption);
		}
		return '';
	}
}
?>
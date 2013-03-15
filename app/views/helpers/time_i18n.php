<?php
App::import('Helper', 'Time');

class TimeI18nHelper extends TimeHelper {


	function nice($dateString = null, $userOffset = null) {
		if ($dateString != null) {
			$date = $this->fromString($dateString, $userOffset);
		} else {
			$date = time();
		}

		$ret = date(__("j \of F \of Y, H:i" , true), $date);

		$ret = __ia($ret);

		return $this->output(up($ret));
	}

	function niceShort($dateString = null, $userOffset = null, $time = false) {
		$date = $dateString ? $this->fromString($dateString, $userOffset) : time();

		$y = $this->isThisYear($date) ? "\of  Y" : "\of  Y";

		if($time){
			$timeFormat = ', H:i';
		} else {
			$timeFormat = '';
		}

		if ($this->isToday($date)){
			$ret = sprintf(__('TODAY',true) . '%s', date($timeFormat, $date)) . ', ' . $this->timeAgoInWords($date);
		} elseif ($this->wasYesterday($date)) {
			$ret = sprintf(__('YESTERDAY',true) . '%s', date($timeFormat, $date));
		//} elseif ($this->wasWithinLast('7 days',$date)) {
        //    $ret = $this->timeAgoInWords($date);
		} else {

            

            $timeFormat = ($timeFormat ? $timeFormat : '');
			$ret = date( __("j \of F {$y}{$timeFormat}" , true), $date);
            
		}

		$ret = __ia($ret);

		return $this->output(($ret));
	}


	function niceShortOn($dateString = null, $userOffset = null, $time = false) {
		$date = $dateString ? $this->fromString($dateString, $userOffset) : time();
		if ($this->isToday($date)){
			$ret = '';
		} elseif ($this->wasYesterday($date)) {
			$ret = '';
		} else {
			$ret = __('ElementCreatedOn', true);
		}

		return ($ret.' '.$this->niceShort($dateString, $userOffset, $time));
	}

	function timeAgoInWords($dateTime, $options = array()) {
		$userOffset = null;
		if (is_array($options) && isset($options['userOffset'])) {
			$userOffset = $options['userOffset'];
		}
		$now = time();
		if (!is_null($userOffset)) {
			$now = 	$this->convert(time(), $userOffset);
		}
		$inSeconds = $this->fromString($dateTime, $userOffset);
		$backwards = ($inSeconds > $now);

		$format = __('j/n/y',true);
		$end = '+1 month';

		if (is_array($options)) {
			if (isset($options['format'])) {
				$format = __($options['format'],true);
				unset($options['format']);
			}
			if (isset($options['end'])) {
				$end = $options['end'];
				unset($options['end']);
			}
		} else {
			$format = $options;
		}

		if ($backwards) {
			$futureTime = $inSeconds;
			$pastTime = $now;
		} else {
			$futureTime = $now;
			$pastTime = $inSeconds;
		}
		$diff = $futureTime - $pastTime;

		// If more than a week, then take into account the length of months
		if ($diff >= 604800) {
			$current = array();
			$date = array();

			list($future['H'], $future['i'], $future['s'], $future['d'], $future['m'], $future['Y']) = explode('/', date('H/i/s/d/m/Y', $futureTime));

			list($past['H'], $past['i'], $past['s'], $past['d'], $past['m'], $past['Y']) = explode('/', date('H/i/s/d/m/Y', $pastTime));
			$years = $months = $weeks = $days = $hours = $minutes = $seconds = 0;

			if ($future['Y'] == $past['Y'] && $future['m'] == $past['m']) {
				$months = 0;
				$years = 0;
			} else {
				if ($future['Y'] == $past['Y']) {
					$months = $future['m'] - $past['m'];
				} else {
					$years = $future['Y'] - $past['Y'];
					$months = $future['m'] + ((12 * $years) - $past['m']);

					if ($months >= 12) {
						$years = floor($months / 12);
						$months = $months - ($years * 12);
					}

					if ($future['m'] < $past['m'] && $future['Y'] - $past['Y'] == 1) {
						$years --;
					}
				}
			}

			if ($future['d'] >= $past['d']) {
				$days = $future['d'] - $past['d'];
			} else {
				$daysInPastMonth = date('t', $pastTime);
				$daysInFutureMonth = date('t', mktime(0, 0, 0, $future['m'] - 1, 1, $future['Y']));

				if (!$backwards) {
					$days = ($daysInPastMonth - $past['d']) + $future['d'];
				} else {
					$days = ($daysInFutureMonth - $past['d']) + $future['d'];
				}

				if ($future['m'] != $past['m']) {
					$months --;
				}
			}

			if ($months == 0 && $years >= 1 && $diff < ($years * 31536000)) {
				$months = 11;
				$years --;
			}

			if ($months >= 12) {
				$years = $years + 1;
				$months = $months - 12;
			}

			if ($days >= 7) {
				$weeks = floor($days / 7);
				$days = $days - ($weeks * 7);
			}
		} else {
			$years = $months = $weeks = 0;
			$days = floor($diff / 86400);

			$diff = $diff - ($days * 86400);

			$hours = floor($diff / 3600);
			$diff = $diff - ($hours * 3600);

			$minutes = floor($diff / 60);
			$diff = $diff - ($minutes * 60);
			$seconds = $diff;
		}
		$relativeDate = '';
		$diff = $futureTime - $pastTime;

		if ($diff > abs($now - $this->fromString($end))) {
			$relativeDate = sprintf(__('on',true) . ' ' . __('%s',true), date($format, $inSeconds));
		} else {
			if ($years > 0) {
				// years and months and days
				$relativeDate .= ($relativeDate ? ', ' : '') . $years . ' ' . __n('year', 'years', $years, true);
				$relativeDate .= $months > 0 ? ($relativeDate ? ', ' : '') . $months . ' ' . __n('month', 'months', $months, true) : '';
				$relativeDate .= $weeks > 0 ? ($relativeDate ? ', ' : '') . $weeks . ' ' . __n('week', 'weeks', $weeks, true) : '';
				$relativeDate .= $days > 0 ? ($relativeDate ? ', ' : '') . $days . ' ' . __n('day', 'days', $days, true) : '';
			} elseif (abs($months) > 0) {
				// months, weeks and days
				$relativeDate .= ($relativeDate ? ', ' : '') . $months . ' ' . __n('month', 'months', $months, true);
				$relativeDate .= $weeks > 0 ? ($relativeDate ? ', ' : '') . $weeks . ' ' . __n('week', 'weeks', $weeks, true) : '';
				$relativeDate .= $days > 0 ? ($relativeDate ? ', ' : '') . $days . ' ' . __n('day', 'days', $days, true) : '';
			} elseif (abs($weeks) > 0) {
				// weeks and days
				$relativeDate .= ($relativeDate ? ', ' : '') . $weeks . ' ' . __n('week', 'weeks', $weeks, true);
				$relativeDate .= $days > 0 ? ($relativeDate ? ', ' : '') . $days . ' ' . __n('day', 'days', $days, true) : '';
			} elseif (abs($days) > 0) {
				// days and hours
				$relativeDate .= ($relativeDate ? ', ' : '') . $days . ' ' . __n('day', 'days', $days, true);
				$relativeDate .= $hours > 0 ? ($relativeDate ? ', ' : '') . $hours . ' ' . __n('hour', 'hours', $hours, true) : '';
			} elseif (abs($hours) > 0) {
				// hours and minutes
				$relativeDate .= ($relativeDate ? ', ' : '') . $hours . ' ' . __n('hour', 'hours', $hours, true);
				$relativeDate .= $minutes > 0 ? ($relativeDate ? ', ' : '') . $minutes . ' ' . __n('minute', 'minutes', $minutes, true) : '';
			} elseif (abs($minutes) > 0) {
				// minutes only
				$relativeDate .= ($relativeDate ? ', ' : '') . $minutes . ' ' . __n('minute', 'minutes', $minutes, true);
			} else {
				// seconds only
				$relativeDate .= ($relativeDate ? ', ' : '') . $seconds . ' ' . __n('second', 'seconds', $seconds, true);
			}

			if (!$backwards) {
				$relativeDate = sprintf( __('%s', true) . ' ' . __('ago' , true) , $relativeDate);
			}
		}
		return $this->output(($relativeDate));
	}



	function isBetween($startDate, $endDate, $date = false){
		if(!$date){
			$date = date('Y-m-d');
		}
		$startDate = strtotime($startDate);
		$endDate = strtotime($endDate);
		$date = strtotime($date);
		return (($startDate <= $date) && ($endDate >= $date));
	}

	function WHSPRdate( $date , $format='l, d M Y' , $hour = false ) {
		$date = strtotime($date);

		$timeFormat = '' ;

		if ($this->isToday($date)){

			$ret = sprintf(__('TODAY',true) . '%s', date($timeFormat, $date));
		} elseif ($this->wasYesterday($date)) {

			$ret = sprintf(__('YESTERDAY',true) . ' %s', date($timeFormat, $date));
		} else {
			$timeFormat = ($timeFormat ? $timeFormat : $format);
			$ret = date( __( $timeFormat , true), $date);
			$ret .= $hour ? date( __( ', h:m' , true), $date) : '' ;
		}

		return $ret ;

	}






    

}
?>

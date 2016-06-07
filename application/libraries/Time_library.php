<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class  Time_library
	{
	    public function getCurMonthFirstDay($date) {
		    return date('Y-m-01', strtotime($date));
		}

		public function getCurMonthLastDay($date) {
		    return date('Y-m-d', strtotime(date('Y-m-01', strtotime($date)) . ' +1 month -1 day'));
		}

		public function getNextMonthFirstDay($date) {
		    return date('Y-m-d', strtotime(date('Y-m-01', strtotime($date)) . ' +1 month'));
		}

		public function get_time_array($start_day , $end_day)
		{
			$time_array = NULL;

			$start_time=strtotime($start_day);
			$end_time=strtotime($end_day);
			if($start_time>$end_time){$temp=$start_day;$start_day=$end_day;$end_day=$temp;}

			$time_count = strtotime($this->getCurMonthFirstDay($start_day));

			$first_time = strtotime($this->getCurMonthFirstDay($start_day));
			$last_time = strtotime($this->getNextMonthFirstDay($end_day));

			while($time_count<$last_time)
			{
				$time_temp = NULL;

				$time_temp['date'] = date('Y-m-d', $time_count);
				$time_temp['time_from'] = $time_count;
				$time_temp['time_till'] = strtotime($this->getNextMonthFirstDay($time_temp['date']));
				$time_temp['time_interval'] = $time_temp['time_till'] - $time_temp['time_from'];

				$time_array[] = $time_temp;

				$time_count = strtotime($this->getNextMonthFirstDay($time_temp['date']));
			}

			return $time_array;
		}
	}
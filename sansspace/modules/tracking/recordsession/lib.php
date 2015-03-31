<?php

//////////////////////////////////////////////////////////////////////////

function autoSessionScale($totallength)
{
	if($totallength <= 24*60*60)
		return 1;

	else if($totallength <= 3*24*60*60)
		return 2;

	else if($totallength <= 6*24*60*60)
		return 3;

	else if($totallength <= 10*24*60*60)
		return 4;

	else if($totallength <= 50*24*60*60)
		return 5;

	else if($totallength <= 250*24*60*60)
		return 6;

	else if($totallength <= 1000*24*60*60)
		return 7;

	return 8;
}

////////////////////////////////////////////////////////////////////////////

class SessionPlotArray
{
	public $items = array();

	public function addItem($i)
	{
		if(!$i || empty($i))
			$i = 'unknown';

		array_push($this->items, $i);
	}

	public function addArray($a, $field)
	{
		foreach($a as $i)
			$this->addItem($i[$field]);
	}

	public function getArrays()
	{
		$string = "[";
		foreach($this->items as $i)
		{
			if(is_string($i) && $i[0] != '[')
				$string .= "'$i', ";
			else
				$string .= "$i, ";
		}

		$string = rtrim($string, ', ');
		$string .= ']';

		return $string;
	}

	public function getObjects($field)
	{
		$string = "[";
		foreach($this->items as $i)
			$string .= "{{$field}: '$i'}, ";

		$string = rtrim($string, ', ');
		$string .= ']';

		return $string;
	}
};

// returns
//	datas [[..], ..]
//	series [..]
//	ticks [..]

function buildSessionTable($scale, $starttime, &$totallength, $groupby)
{
}




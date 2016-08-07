<?php

setParameterSetId("73234fd11dd641aca0981e63b2b6e5d4");

$mm = 1;
$inch = 25.4 * $mm;


$degree = 1;
$radian = 180/pi();




class hexKey {
	public $widthAcrossFlats;
	public $shortLegLength;
	public $longLegLength;
	public $bendRadius;
	public $nominalSize; //this is a string
	
	public function __construct(
		$widthAcrossFlats   = null,
		$nominalSize        = null,
		$bendRadius         = null,
		$shortLegLength     = null,
		$longLegLength      = null
	)
	{
		global $mm, $inch, $degree, $radian;
		// $this->XXX = (!is_null($XXX) ? $XXX :
			// defaultValueOfXXX //default value of $XXX
		// );	
		
		$defaultWidthAcrossFlats = 6 * $mm;
		$this->widthAcrossFlats = (!is_null($widthAcrossFlats) ? $widthAcrossFlats :
			$defaultWidthAcrossFlats //default value of $widthAcrossFlats
		);	
		
		$scaleFactor = $this->widthAcrossFlats / $defaultWidthAcrossFlats;
				
		$this->shortLegLength = (!is_null($shortLegLength) ? $shortLegLength :
			$scaleFactor * 40 * $mm //default value of $shortLegLength
		);	
		
		$this->longLegLength = (!is_null($longLegLength) ? $longLegLength :
			$scaleFactor * 100 * $mm //default value of $longLegLength
		);	
		
		$this->bendRadius = (!is_null($bendRadius) ? $bendRadius :
			$scaleFactor * 18 * $mm //default value of $bendRadius
		);	
		
		$this->nominalSize = (!is_null($nominalSize) ? $nominalSize :
			$this->nominalSize    = round($this->widthAcrossFlats/$mm, 1) . " mm" //default value of $nominalSize
		);	
	}
}

class hexKeyHolderSegment {
	public $hexKey;
	public $holsterHoleDiameter;
	public $extraVerticalSlotDepth;
	public $totalSlotDepth;
	public $embedmentY;
	public $embedmentZ;
	public $holderExtentX;
	public $funnelFilletRadius;
	public $textEngravingDepth;
	public $supportY;
	public $supportZ;
	public $overhangRadius;
	public $funnelDraftAngle;
	
	public function __construct(
		$hexKey                    = null, 
		$holsterHoleDiameter       = null,
		$extraVerticalSlotDepth    = null,
		$totalSlotDepth            = null,
		$embedmentY                = null,
		$embedmentZ                = null,
		$extentX                   = null,
		$funnelFilletRadius        = null,
		$textEngravingDepth        = null,
		$supportY                  = null,
		$supportZ                  = null,
		$overhangRadius            = null,
		$funnelDraftAngle          = null
	)
	{
		global $mm, $inch, $degree, $radian;
		$this->hexKey = (!is_null($hexKey) ? clone $hexKey :
			new hexKey() //default value of $hexKey		
		);	
		
		$defaultHexKey = new hexKey();
		$scaleFactor = $this->hexKey->widthAcrossFlats / $defaultHexKey->widthAcrossFlats;
		
		$this->holsterHoleDiameter = (!is_null($holsterHoleDiameter) ? $holsterHoleDiameter :
			$scaleFactor * 10 * $mm //default value of $holsterHoleDiameter
		);	
				
		$this->extraVerticalSlotDepth = (!is_null($extraVerticalSlotDepth) ? $extraVerticalSlotDepth :
			$scaleFactor * 2 * $mm //default value of $extraVerticalSlotDepth
		);	
				
		$this->totalSlotDepth = (!is_null($totalSlotDepth) ? $totalSlotDepth :
			$scaleFactor * 8 * $mm //default value of $totalSlotDepth
		);	
				
		$this->embedmentY = (!is_null($embedmentY) ? $embedmentY :
			$scaleFactor * 20 * $mm //default value of $embedmentY
		);	
				
		$this->embedmentZ = (!is_null($embedmentZ) ? $embedmentZ :
			$scaleFactor * 50 * $mm //default value of $embedmentZ
		);	
				
		$this->extentX = (!is_null($extentX) ? $extentX :
			$scaleFactor * 25 * $mm //default value of $extentX
		);	
				
		$this->funnelFilletRadius = (!is_null($funnelFilletRadius) ? $funnelFilletRadius : 
			0.95 * 1/2 * ($this->totalSlotDepth - $this->extraVerticalSlotDepth)  //default value of $funnelFilletRadius
		);	//we are guaranteed to be safe if we keep this less than 1/2 * (totalSlotDepth - extraVerticalSlotDepth);
			
		$this->textEngravingDepth = (!is_null($textEngravingDepth) ? $textEngravingDepth :
			0.4 * $mm //default value of $textEngravingDepth
		);
		
		$this->supportY = (!is_null($supportY) ? $supportY :
			$scaleFactor * 8 * $mm //default value of $supportY
		);	
		
		$this->supportZ = (!is_null($supportZ) ? $supportZ :
			$scaleFactor * 8 * $mm //default value of $supportZ
		);	
		
		$this->overhangRadius = (!is_null($overhangRadius) ? $overhangRadius :
			$scaleFactor * 5 * $mm //default value of $overhangRadius
		);		
		
		$this->funnelDraftAngle = (!is_null($funnelDraftAngle) ? $funnelDraftAngle :
			16 * $degree //default value of $funnelDraftAngle
		);	
		
		// $this->XXX = (!is_null($XXX) ? $XXX :
			// defaultValueOfXXX //default value of $XXX
		// );	

	}
	
}


$defaultHexKeyHolderSegment =  new hexKeyHolderSegment();
$hexKeyHolderSegment1 = new hexKeyHolderSegment(new hexKey(1 * $mm));
$hexKeyHolderSegment2 = new hexKeyHolderSegment(new hexKey(2 * $mm));
$hexKeyHolderSegment3 = new hexKeyHolderSegment(new hexKey(3 * $mm));
$hexKeyHolderSegment4 = new hexKeyHolderSegment(new hexKey(4 * $mm));
$hexKeyHolderSegment5 = new hexKeyHolderSegment(new hexKey(5 * $mm));

$hexKeyHolder->hexKeysIntervalX = 30 * $mm;
$hexKeyHolder->hexKeysCount = 7;
$hexKeyHolder->hexKeysSpanX = $hexKeyHolder->hexKeysIntervalX * ($hexKeyHolder->hexKeysCount - 1);

$hexKeyHolder->mountingSurfaceOffset = 20 * $mm;

?>
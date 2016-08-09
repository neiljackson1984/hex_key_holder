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
	public $extentX;
	public $funnelFilletRadius;
	public $textEngravingDepth;
	public $supportY;
	public $supportZ;
	public $overhangRadius;
	public $funnelDraftAngle;
	public $labelTextHeight;  //can't drive text height, so this requires manual updating between externalParameters and solidworks model.
	public $labelString;
	public $labelStrings;
	public $labelPositionZ;
	public $labelTextLineInterval;
	
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
		$funnelDraftAngle          = null,
		$labelTextHeight           = null,
		$labelTextLineInterval     = null,
		$labelString               = null,
		$labelStrings              = null,
		$labelPositionZ            = null
	)
	{
		global $mm, $inch, $degree, $radian;
		$this->hexKey = (!is_null($hexKey) ? clone $hexKey :
			new hexKey() //default value of $hexKey		
		);	
		
		$defaultHexKey = new hexKey();
		$scaleFactor = $this->hexKey->widthAcrossFlats / $defaultHexKey->widthAcrossFlats;
		
		$this->holsterHoleDiameter = (!is_null($holsterHoleDiameter) ? $holsterHoleDiameter :
			1.3 * $this->hexKey->widthAcrossFlats //default value of $holsterHoleDiameter
		);	
				
		$this->extraVerticalSlotDepth = (!is_null($extraVerticalSlotDepth) ? $extraVerticalSlotDepth :
			$scaleFactor * 2 * $mm //default value of $extraVerticalSlotDepth
		);	
				
		$this->totalSlotDepth = (!is_null($totalSlotDepth) ? $totalSlotDepth :
			$scaleFactor * 8 * $mm //default value of $totalSlotDepth
		);	
				

				
		$this->extentX = (!is_null($extentX) ? $extentX :
			$scaleFactor * 25 * $mm //default value of $extentX
		);	
				
		$this->funnelFilletRadius = (!is_null($funnelFilletRadius) ? $funnelFilletRadius : 
			0.95 * 1/2 * ($this->totalSlotDepth - $this->extraVerticalSlotDepth)  //default value of $funnelFilletRadius
		);	//we are guaranteed to be safe if we keep this less than 1/2 * (totalSlotDepth - extraVerticalSlotDepth);
			
		$this->textEngravingDepth = (!is_null($textEngravingDepth) ? $textEngravingDepth :
			0.6 * $mm //default value of $textEngravingDepth
		);
		
		$this->supportY = (!is_null($supportY) ? $supportY :
			//$scaleFactor * 8 * $mm //default value of $supportY
			$this->holsterHoleDiameter/2 + 3.8 * $mm // here, 4*$mm is the wall thickness
		);	
		
		$this->supportZ = (!is_null($supportZ) ? $supportZ :
			$this->supportY //default value of $supportZ
		);	
		
		$this->overhangRadius = (!is_null($overhangRadius) ? $overhangRadius :
			$scaleFactor * 5 * $mm //default value of $overhangRadius
		);		
		
		$this->embedmentY = (!is_null($embedmentY) ? $embedmentY :
			max(
				//$scaleFactor * 20 * $mm, //default value of $embedmentY,
				$this->hexKey->bendRadius + 3 * $mm,
				$this->supportY + $this->overhangRadius + 0.1 *$mm //the '0.1' is a hack to work around solidworks's dislike of zero-length geometry
			)
		);	
				
		$this->embedmentZ = (!is_null($embedmentZ) ? $embedmentZ :
			max(
				$scaleFactor * 50 * $mm, //default value of $embedmentZ
				$this->supportZ + $this->overhangRadius + 0.1 *$mm //the '0.1' is a hack to work around solidworks's dislike of zero-length geometry
			)
		);	
		

		
		$this->funnelDraftAngle = (!is_null($funnelDraftAngle) ? $funnelDraftAngle :
			16 * $degree //default value of $funnelDraftAngle
		);	
		
		//there is no dynamic updatng of the height of the solidworks sketch text -- this has to be updated manually in solidworks.
		$this->labelTextHeight = (!is_null($labelTextHeight) ? $labelTextHeight :
			5 * $mm //default value of $labelTextHeight
		);	
		
		// $this->labelString = (!is_null($labelString) ? $labelString :
			// //'<FONT color=D><FONT name="Verdana" size=6PTS>' . 
			// round($this->hexKey->widthAcrossFlats/$mm, 1) . "\n" . "mm"  //default value of $labelString
			// //'<FONT color=D><FONT name="Century Gothic" size=5PTS style=RB effect=RU>2016/06/28'
		// );	
		
		$this->labelString = (!is_null($labelString) ? $labelString :
			round($this->hexKey->widthAcrossFlats/$mm, 1) . "\n" . "mm"  //default value of $labelString
		);	
		
		//this is what we really want to do, once we fix the property importer to something reasonable with arrays in the json data.
		$this->labelStrings = (!is_null($labelStrings) ? $labelStrings :
			explode("\n", $this->labelString)  //default value of $labelStrings1
		);	
	
		// Use these codes in the Solidworks text entry field to get the lines of text for the label:
		// $PRP:"externalParameters.this.labelStrings[0]"
		// $PRP:"externalParameters.this.labelStrings[1]"
		

		// // // //$this->labelStyle = '"<FONT color=D><FONT name=""Century Gothic"" size=5PTS style=RB effect=RU>';
		// // // $this->labelStyle = '';
		// // // $this->labelScalingFactor = 3.12345;
		
		$this->labelPositionZ = (!is_null($labelPositionZ) ? $labelPositionZ :
			//$this->embedmentZ - 1/2 * ($this->embedmentZ - $this->overhangRadius - $this->supportZ) // default value of $labelPositionZ
			$this->supportZ + $this->overhangRadius  + 1.5 * $this->labelTextHeight  
		);	
		
		$this->labelTextLineInterval = (!is_null($labelTextLineInterval) ? $labelTextLineInterval :
			1.3 * $this->labelTextHeight //default value of $labelTextLineInterval
		);	
		
		// $this->XXX = (!is_null($XXX) ? $XXX :
			// defaultValueOfXXX //default value of $XXX
		// );	

	}
}

$defaultHexKeyHolderSegment =  new hexKeyHolderSegment();
$hexKeyHolderSegments = 
	[
		new hexKeyHolderSegment(new hexKey(1.5 * $mm)),
		new hexKeyHolderSegment(new hexKey(2 * $mm)),
		new hexKeyHolderSegment(new hexKey(2.5 * $mm)),
		new hexKeyHolderSegment(new hexKey(3 * $mm)),
		new hexKeyHolderSegment(new hexKey(3.5 * $mm)),
		new hexKeyHolderSegment(new hexKey(4 * $mm)),
		new hexKeyHolderSegment(new hexKey(4.5 * $mm)),
		new hexKeyHolderSegment(new hexKey(5 * $mm)),
		new hexKeyHolderSegment(new hexKey(5.5 * $mm)),
		new hexKeyHolderSegment(new hexKey(6 * $mm)),
		new hexKeyHolderSegment(new hexKey(7 * $mm)),
		new hexKeyHolderSegment(new hexKey(8 * $mm)),
		new hexKeyHolderSegment(new hexKey(9 * $mm)),
		new hexKeyHolderSegment(new hexKey(10 * $mm))

	];

$largestHexKeyHolderSegment = $hexKeyHolderSegments[count($hexKeyHolderSegments) - 1];
$smallestHexKeyHolderSegment = $hexKeyHolderSegments[0];

$hexKeyHolder->hexKeysIntervalX = 25 * $mm;
$hexKeyHolder->hexKeysCount = count($hexKeyHolderSegments);
$hexKeyHolder->hexKeysSpanX = $hexKeyHolder->hexKeysIntervalX * ($hexKeyHolder->hexKeysCount - 1);
$hexKeyHolder->mountHoles->clampingMeatThickness = 10 * $mm;
$hexKeyHolder->mountingSurfaceOffset = 
	max(
		$largestHexKeyHolderSegment->supportY,
		$hexKeyHolder->mountHoles->clampingMeatThickness - ($smallestHexKeyHolderSegment->supportY)
	)
	+ 1.3 * $mm; //a hack



$hexKeyHolder->mountHoles->screw->clearanceDiameter = 4 * $mm;
$hexKeyHolder->mountHoles->screw->headClearanceDiameter = 10 * $mm;
$hexKeyHolder->mountHoles->screw->counterSinkAngle = 90 * $degree;
$hexKeyHolder->mountHoles->positionZ = $largestHexKeyHolderSegment->supportZ + $largestHexKeyHolderSegment->overhangRadius + $hexKeyHolder->mountHoles->screw->headClearanceDiameter/2; 

$commonLabelPositionZ = $largestHexKeyHolderSegment->labelPositionZ;
$commonMinimumAllowedEmbedmentZ = // allows enough height for the land on which to engraved text.
	$commonLabelPositionZ + 
	((2 /*number of lines of text*/ ) -1) * $defaultHexKeyHolderSegment->labelTextLineInterval +
	+ 0.5 * $defaultHexKeyHolderSegment->labelTextHeight;
 
$commonExtentX = $hexKeyHolder->hexKeysIntervalX-2*$mm;
foreach($hexKeyHolderSegments as $hexKeyHolderSegment)
{
	$hexKeyHolderSegment->labelPositionZ = $commonLabelPositionZ;
	$hexKeyHolderSegment->embedmentZ = max($hexKeyHolderSegment->embedmentZ, $commonMinimumAllowedEmbedmentZ);
	$hexKeyHolderSegment->extentX = $commonExtentX;
}

$hexKeyHolder->maximumAllowedNumberOfSegments = 32; //This is the number of configurations I have made in the hexKeyHolderSegment.sldprt file (and the number of points I have put into the positioning sketch).  The process to make these configurations is and sketch points is manual, and the number of configs determines the maximum number of segments that we can have.

$hexKeyHolder->segmentPositions = [];
$arbitraryOffset = 100 * $mm; //we add this to keep all coordinates positive.
for($i = 0; $i < $hexKeyHolder->maximumAllowedNumberOfSegments; $i++)
{
	//$hexKeyHolder->segmentPositions[$i] = $i * $hexKeyHolder->hexKeysIntervalX + $arbitraryOffset;
	//$hexKeyHolder->segmentPositions[$i] = new stdclass;
	$hexKeyHolder->segmentPositions[$i]->x = $i * ($hexKeyHolder->hexKeysIntervalX) + $arbitraryOffset;
}

$hexKeyHolder->xMax = $hexKeyHolder->segmentPositions[count($hexKeyHolderSegments) - 1]->x + ($hexKeyHolderSegments[count($hexKeyHolderSegments) - 1]->extentX)/2;

{// set mount hole positions
	//the first mount hole will go halfway between the edges of the first and second segments
	$hexKeyHolder->mountHoles->positions[0]->x = 
		(
			$hexKeyHolder->segmentPositions[0    ]->x   + $hexKeyHolderSegments[0    ]->extentX/2
			+
			$hexKeyHolder->segmentPositions[0 + 1]->x   - $hexKeyHolderSegments[0 + 1]->extentX/2
		)/2 ;
		
	//the second mount hole will go halfway between the edges of the penultimate and last segments
	$hexKeyHolder->mountHoles->positions[1]->x = 
		(
			$hexKeyHolder->segmentPositions[count($hexKeyHolderSegments) - 2]->x   + $hexKeyHolderSegments[count($hexKeyHolderSegments) - 2]->extentX/2
			+
			$hexKeyHolder->segmentPositions[count($hexKeyHolderSegments) - 1]->x   - $hexKeyHolderSegments[count($hexKeyHolderSegments) - 1]->extentX/2
		)/2 ;
}


?>
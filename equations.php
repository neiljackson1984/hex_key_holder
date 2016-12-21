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
		
		if(!is_null($bendRadius))
		{
			$this->bendRadius = $bendRadius;
		} 
		else
		{ //set the default value for bendRadius.
			//$scaleFactor * 14.5 * $mm //default value of $bendRadius
			
			/**************************************************************	
			  |*    measured bend radii on real-world sample wrenches:
			  |*    -----------------------------------------------------
			  |*    |nominal width-across-flats (mm)
			  |*    |         |measured bend radius (mm)
			  |*    |         |         |ratio
			  |*    | 1.27    | 3.56    | 2.80
			  |*    | 2       | 5.59    | 2.80
			  |*    | 5       | 10.16   | 2.03
			  |*    | 6       | 11.43   | 1.91
			  |*    | 10      | >12.7   | >1.27
			  |**************************************************************
			*/
			
			$s0 = 1.27 * $mm;
			$ratio0 = 2.80;
			$s1 = 6 * $mm;
			$ratio1 = 1.91;
			if     ($this->widthAcrossFlats < $s0){$ratio = $ratio0;                                                                         }
			elseif ($this->widthAcrossFlats > $s1){$ratio = $ratio1;                                                                         }
			else                                  {$ratio = $ratio0 + ($this->widthAcrossFlats - $s0) * ($ratio1 - $ratio0)/($s1 - $s0);     }
			$ratio += 1/2;  //add a bit of a fudge factor.
			
			$this->bendRadius = $ratio * $this->widthAcrossFlats;
		}
		
		$this->nominalSize = (!is_null($nominalSize) ? $nominalSize :
			$this->nominalSize    = round($this->widthAcrossFlats/$mm, 1) . " mm" //default value of $nominalSize
		);	
	}
}

class hexKeyHolderSegment extends properties 
{
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
	public $funnelDraftAngle;
	public $labelTextHeights;  //can't drive text height, so this requires manual updating between externalParameters and solidworks model.
	public $labelString;
	public $reservedTextWidth;
	public $mountingSurfaceOffset;
	public $labelPositionZ;
	public $labelTextLineInterval;
	
	public function get_effectiveHolsterHoleDiameterAtTopOfFunnel() //accounts for the draft of the funel walls and the funnel fillet.
	{	
		global $radian;
		return 
			$this->holsterHoleDiameter
			+ 2*
			(
				($this->totalSlotDepth - $this->extraVerticalSlotDepth) * tan($this->funnelDraftAngle/$radian)
				+
				$this->funnelFilletRadius / tan(  (pi()/2 + ($this->funnelDraftAngle/$radian))/2    )
			);
	}
	
	public function get_minimumAllowedMountingSurfaceOffset()
	{
		global $mm;
		return 
			max(
				$this->effectiveHolsterHoleDiameterAtTopOfFunnel / 2 + 0.4 * $mm,
				$this->supportY
			);
	}	
	

	
	public function get_minimumAllowedExtentX()
	{
		global $mm;
		return 
			max(
				$this->effectiveHolsterHoleDiameterAtTopOfFunnel + 0.01 * $mm + 0.5 * $mm,
				$this->reservedTextWidth
			);
	}	
	
	public function get_overhangRadius()
	{
		global $mm;
		return 
			max(
				2 * $mm, 
				$this->hexKey->bendRadius - max($this->supportY, $this->supportZ)
			);
	}	
	
	public function get_labelStrings()
	{
		return explode("\n", $this->labelString);  //default value of $labelStrings1
	}
	
	public function __construct(
		$hexKey                    = null, 
		$labelString               = null,
		$labelTextHeights          = null,
		$reservedTextWidth         = null,
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
		$funnelDraftAngle          = null,
		$labelTextLineInterval     = null,
		$labelPositionZ            = null,
		$mountingSurfaceOffset     = null
	)
	{
		global $mm, $inch, $degree, $radian;
		$this->hexKey = (!is_null($hexKey) ? clone $hexKey :
			new hexKey() //default value of $hexKey		
		);	
		
		$defaultHexKey = new hexKey();
		//$scaleFactor = $this->hexKey->widthAcrossFlats / $defaultHexKey->widthAcrossFlats;
		
		$this->holsterHoleDiameter = (!is_null($holsterHoleDiameter) ? $holsterHoleDiameter :
			1.3 * $this->hexKey->widthAcrossFlats //default value of $holsterHoleDiameter
		);	
				
		$this->extraVerticalSlotDepth = (!is_null($extraVerticalSlotDepth) ? $extraVerticalSlotDepth :
			//default value of $extraVerticalSlotDepth
			max(
				1.9 * $mm,
				0.33 * $this->hexKey->widthAcrossFlats
			)
		);	
				
		$this->totalSlotDepth = (!is_null($totalSlotDepth) ? $totalSlotDepth :
			//default value of $totalSlotDepth
			$this->extraVerticalSlotDepth 
			+ $this->hexKey->widthAcrossFlats 
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
		
		
		$this->embedmentY = (!is_null($embedmentY) ? $embedmentY :
			max(
				//$scaleFactor * 20 * $mm, //default value of $embedmentY,
				$this->hexKey->bendRadius + 2.8 * $mm,
				$this->supportY + $this->overhangRadius + 0.1 *$mm //the '0.1' is a hack to work around solidworks's dislike of zero-length geometry
			)
		);	
				
		$this->embedmentZ = (!is_null($embedmentZ) ? $embedmentZ :
			max(
				//$scaleFactor * 50 * $mm, //default value of $embedmentZ
				//$this->hexKey->bendRadius  +  $this->hexKey->widthAcrossFlats * 5.2,
				$this->hexKey->bendRadius  +  $this->hexKey->widthAcrossFlats * 2,
				$this->supportZ + $this->overhangRadius + 0.1 *$mm //the '0.1' is a hack to work around solidworks's dislike of zero-length geometry
			)
		);	
		

		
		$this->funnelDraftAngle = (!is_null($funnelDraftAngle) ? $funnelDraftAngle :
			16 * $degree //default value of $funnelDraftAngle
		);	
		

		
		// $this->labelString = (!is_null($labelString) ? $labelString :
			// //'<FONT color=D><FONT name="Verdana" size=6PTS>' . 
			// round($this->hexKey->widthAcrossFlats/$mm, 1) . "\n" . "mm"  //default value of $labelString
			// //'<FONT color=D><FONT name="Century Gothic" size=5PTS style=RB effect=RU>2016/06/28'
		// );	
		
		$this->labelString = (!is_null($labelString) ? $labelString :
			round($this->hexKey->widthAcrossFlats/$mm, 1) . "\n" . "mm"  //default value of $labelString
		);

		//there is no dynamic updatng of the height of the solidworks sketch text -- this has to be updated manually in solidworks.
		// $this->labelTextHeight = (!is_null($labelTextHeight) ? $labelTextHeight :
			// 5 * $mm //default value of $labelTextHeight
		// );	

		// we allow each line of text to have potentially different height.
		// I will use equation-driven suppression to allow this textHeight value to have effect if it is one of the few 
		// values that I have manually set up in the suppression states.
		$this->labelTextHeights = (!is_null($labelTextHeights) ? $labelTextHeights :
			[5 * $mm, 5 * $mm] //default value of $labelTextHeights
		);	
		
		$this->reservedTextWidth = (!is_null($reservedTextWidth) ? $reservedTextWidth :
			//default value of $reservedTextWidth
			max(
				//$this->aaTester = array_map(
				// array_map(
					// function($x){
						// global $mm;
						// return 
							// 1.45 * $this->labelTextHeight * strlen($x)
							// + 2* 0.8 * $mm;
					// }, //this function returns some estimation of the width of the specified line of text.  It is crude because we are not necessarily using a fixed width font, but it should at least allow us to impose a maximum possibe width.
					// $this->labelStrings
				// ) 
				array_map(
					function($i){
						global $mm;
						return 
							1.45 * $this->labelTextHeights[$i] * strlen($this->labelStrings[$i])
							+ 2* 0.8 * $mm;
					}, //this function returns some estimation of the width of the specified line of text.  It is crude because we are not necessarily using a fixed width font, but it should at least allow us to impose a maximum possibe width.
					array_keys($this->labelStrings)
				) 
			) 
		);	
		
		// Use these codes in the Solidworks text entry field to get the lines of text for the label:
		// $PRP:"externalParameters.this.labelStrings[0]"
		// $PRP:"externalParameters.this.labelStrings[1]"

		// // // //$this->labelStyle = '"<FONT color=D><FONT name="Century Gothic" size=5PTS style=RB effect=RU>';
		// // // $this->labelStyle = '';
		// // // $this->labelScalingFactor = 3.12345;
		
		//<FONT color=D><FONT name="Times New Roman" size=10mm style=RB effect=RU>Ahoy There
		
		// Solidworks equations used to selectively seuppress text features based on textHeights:
		// "labelLine0-3mm_extrude"=Iif("externalParameters.this.labelTextHeights[0]"=3mm,"unsuppressed","suppressed")
		// "labelLine0-4mm_extrude"=Iif("externalParameters.this.labelTextHeights[0]"=4mm,"unsuppressed","suppressed")
		// "labelLine0-5mm_extrude"=Iif("externalParameters.this.labelTextHeights[0]"=5mm,"unsuppressed","suppressed")
		// "labelLine1-3mm_extrude"=Iif("externalParameters.this.labelTextHeights[1]"=3mm,"unsuppressed","suppressed")
		// "labelLine1-4mm_extrude"=Iif("externalParameters.this.labelTextHeights[1]"=4mm,"unsuppressed","suppressed")
		// "labelLine1-5mm_extrude"=Iif("externalParameters.this.labelTextHeights[1]"=5mm,"unsuppressed","suppressed")
		//  "labelLine0_folder" = "unsuppressed"
		//  "labelLine1_folder" = "unsuppressed"
		
		$this->labelPositionZ = (!is_null($labelPositionZ) ? $labelPositionZ :
			//$this->embedmentZ - 1/2 * ($this->embedmentZ - $this->overhangRadius - $this->supportZ) // default value of $labelPositionZ
			$this->supportZ + $this->overhangRadius  + 1.5 * $this->labelTextHeights[0]  
			
		);	
		
		$this->labelTextLineInterval = (!is_null($labelTextLineInterval) ? $labelTextLineInterval :
			1.3 * $this->labelTextHeights[1] //default value of $labelTextLineInterval
		);	
		
		$this->extentX = (!is_null($extentX) ? $extentX :
			$this->minimumAllowedExtentX //default value of $extentX
		);	
		
		$this->mountingSurfaceOffset = (!is_null($mountingSurfaceOffset) ? $mountingSurfaceOffset :
			$this->minimumAllowedMountingSurfaceOffset //default value of $mountingSurfaceOffset
		);	
		
		// $this->XXX = (!is_null($XXX) ? $XXX :
			// defaultValueOfXXX //default value of $XXX
		// );	

	}
}

$labelTextHeightsForImperialSegments = [4 * $mm, 5 * $mm];

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
		new hexKeyHolderSegment(new hexKey(10 * $mm)),
		
		new hexKeyHolderSegment(new hexKey(1/20 * $inch),  "1/20" . "\n" . "in"  , $labelTextHeightsForImperialSegments),
		new hexKeyHolderSegment(new hexKey(1/16 * $inch),  "1/16" . "\n" . "in"  , $labelTextHeightsForImperialSegments),
		new hexKeyHolderSegment(new hexKey(5/64 * $inch),  "5/64" . "\n" . "in"  , $labelTextHeightsForImperialSegments),
		new hexKeyHolderSegment(new hexKey(3/32 * $inch),  "3/32" . "\n" . "in"  , $labelTextHeightsForImperialSegments),
		new hexKeyHolderSegment(new hexKey(7/64 * $inch),  "7/64" . "\n" . "in"  , $labelTextHeightsForImperialSegments),
		new hexKeyHolderSegment(new hexKey(1/8  * $inch),  "1/8"  . "\n" . "in"  , $labelTextHeightsForImperialSegments),
		new hexKeyHolderSegment(new hexKey(9/64 * $inch),  "9/64" . "\n" . "in"  , $labelTextHeightsForImperialSegments),
		new hexKeyHolderSegment(new hexKey(5/32 * $inch),  "5/32" . "\n" . "in"  , $labelTextHeightsForImperialSegments),
		new hexKeyHolderSegment(new hexKey(3/16 * $inch),  "3/16" . "\n" . "in"  , $labelTextHeightsForImperialSegments),
		new hexKeyHolderSegment(new hexKey(7/32 * $inch),  "7/32" . "\n" . "in"  , $labelTextHeightsForImperialSegments),
		new hexKeyHolderSegment(new hexKey(1/4  * $inch),  "1/4"  . "\n" . "in"  , $labelTextHeightsForImperialSegments),
		new hexKeyHolderSegment(new hexKey(5/16 * $inch),  "5/16" . "\n" . "in"  , $labelTextHeightsForImperialSegments),
		new hexKeyHolderSegment(new hexKey(3/8  * $inch),  "3/8 " . "\n" . "in"  , $labelTextHeightsForImperialSegments)
	];


//The full complement of segments was too large to fit on the 3d printer bed, so 
// I broke it up into two batches.  (For each batch, you manually set the $batchNumber variable below (to either 0 or 1),
// then regenerate the model, which is a bit of a hack, but serves the immediate purpose.
$batchNumber = -1;
switch($batchNumber)
{
	case 0: //metric, smaller
		$hexKeyHolderSegments = array_slice($hexKeyHolderSegments, 0, 8);
	break;
	case 1: //metric, larger
		$hexKeyHolderSegments = array_slice($hexKeyHolderSegments, 8, 6);
	break;
	case 2: //metric, all
		$hexKeyHolderSegments = array_slice($hexKeyHolderSegments, 0, 14);
	break;
	case 3: //imperial, smaller
		$hexKeyHolderSegments = array_slice($hexKeyHolderSegments, 14, 7);
	break;
	case 4: //imperial, larger
		$hexKeyHolderSegments = array_slice($hexKeyHolderSegments, 21, 6);
	break;
	case 5: //imperial, all
		$hexKeyHolderSegments = array_slice($hexKeyHolderSegments, 14,13);
	break;
	default:
	break;
}


	
$largestHexKeyHolderSegment = $hexKeyHolderSegments[count($hexKeyHolderSegments) - 1];
$smallestHexKeyHolderSegment = $hexKeyHolderSegments[0];

//$hexKeyHolder->hexKeysIntervalX = 25 * $mm;
$hexKeyHolder->hexKeysCount = count($hexKeyHolderSegments);
//$hexKeyHolder->hexKeysSpanX = $hexKeyHolder->hexKeysIntervalX * ($hexKeyHolder->hexKeysCount - 1);
$hexKeyHolder->mountHoles->screw->clearanceDiameter = 5 * $mm;
$hexKeyHolder->mountHoles->screw->headClearanceDiameter = 9 * $mm;

$hexKeyHolder->mountHoles->clampingMeatThickness = 7 * $mm;


// $hexKeyHolder->mountingSurfaceOffset = 
	// max(
		// $largestHexKeyHolderSegment->minimumAllowedMountingSurfaceOffset,
		// $hexKeyHolder->mountHoles->clampingMeatThickness - $smallestHexKeyHolderSegment->supportY + 1 * $mm //The "+ 1 $mm" is a hack to ensure that the screw heads will be recessed by at least this much.
	// );

//an optional extra bit by which to increase the mountingSurfaceOffset of each segment.
//this is done in order to ensure that the smallest segment has enough thickness to acoomodate the required clamping meat for the mount screws.
$extraMountingSurfaceOffset = 
	max(
		0, //this "0" and the max() wrapper clamps the value computed below at zero. (doesn't let $extraMountingSurfaceOffset swing negative).
		(
			$hexKeyHolder->mountHoles->clampingMeatThickness + 1 * $mm //the "+ 1 * $mm" guarantees jus a bit of a recess for the screw head.
			-
			($smallestHexKeyHolderSegment->supportY + $smallestHexKeyHolderSegment->mountingSurfaceOffset) // this is the thicknessZ of the smallest hex key holder segment.
		)
	);



foreach($hexKeyHolderSegments as $hexKeyHolderSegment)
{
	//$hexKeyHolderSegment->labelPositionZ = $largestHexKeyHolderSegment->labelPositionZ;  //align all text labels vertically with one another.
	
	// allow enough height for the land on which to engraved text.
	$hexKeyHolderSegment->embedmentZ = 
		max($hexKeyHolderSegment->embedmentZ, 
			$hexKeyHolderSegment->labelPositionZ + 
			(count($hexKeyHolderSegment->labelStrings) /*number of lines of text*/ -1) * $hexKeyHolderSegment->labelTextLineInterval +
			+ 0.5 * $hexKeyHolderSegment->labelTextHeights[1]
		);

	//$hexKeyHolderSegment->extentX = $hexKeyHolder->hexKeysIntervalX-2*$mm;  //make all holderSEgments have uniform extentX.
	
	//this is a hack to hard code the reservedTextWidth, and have it be the same for all segments, rather than letting the text size and lenth determine reservedTextWidth.
	$hexKeyHolderSegment->reservedTextWidth = 
		2 * 1.45 * 5 * $mm
		+ 2* 1*$mm;
		
	$hexKeyHolderSegment->extentX = $hexKeyHolderSegment->get_minimumAllowedExtentX();
	
	//set all mountingSurfaceOffsets to be the same.
	// $hexKeyHolderSegment->mountingSurfaceOffset = 
		// max(
			// $largestHexKeyHolderSegment->minimumAllowedMountingSurfaceOffset,
			// $hexKeyHolder->mountHoles->clampingMeatThickness - $smallestHexKeyHolderSegment->supportY + 1 * $mm //The "+ 1 $mm" is a hack to ensure that the screw heads will be recessed by at least this much.
		// );
	
	
	$hexKeyHolderSegment->mountingSurfaceOffset += $extraMountingSurfaceOffset;

}

$hexKeyHolder->maximumAllowedNumberOfSegments = 32; //This is the number of configurations I have made in the hexKeyHolderSegment.sldprt file (and the number of points I have put into the positioning sketch).  The process to make these configurations is and sketch points is manual, and the number of configs determines the maximum number of segments that we can have.

$hexKeyHolder->segmentPositions = [];
$minimumAllowedHexKeyIntervalX = 20 * $mm; //chosen mainly for comfortable fingering.
$fingerWidth= 20 * $mm; 
$fingerComfortClearance = 1.9 * $mm;
$minimumAllowedInterSegmentGapX = 1 * $mm;
$hexKeyHolder->segmentPositions[0]->x = 100 * $mm ; //arbitrary, trying to keep all coordinates positive.
for($i = 1; $i < $hexKeyHolder->maximumAllowedNumberOfSegments; $i++)
{
	//$hexKeyHolder->segmentPositions[$i] = $i * $hexKeyHolder->hexKeysIntervalX + $arbitraryOffset;
	//$hexKeyHolder->segmentPositions[$i] = new stdclass;
	
	//$hexKeyHolder->segmentPositions[$i]->x = $i * ($hexKeyHolder->hexKeysIntervalX) + $arbitraryOffset;

	$previousHexKeyHolderSegment = ($i-1 < count($hexKeyHolderSegments) ? $hexKeyHolderSegments[$i-1] : $defaultHexKeyHolderSegment);
	$thisHexKeyHolderSegment     = ($i   < count($hexKeyHolderSegments) ? $hexKeyHolderSegments[$i  ] : $defaultHexKeyHolderSegment);
	
	$hexKeyHolder->segmentPositions[$i]->x = 
		$hexKeyHolder->segmentPositions[$i-1]->x 
		+ 
		max(
			  1/2 * $previousHexKeyHolderSegment->extentX + $minimumAllowedInterSegmentGapX + 1/2 * $thisHexKeyHolderSegment->extentX ,
			//$minimumAllowedHexKeyIntervalX
			$previousHexKeyHolderSegment->hexKey->widthAcrossFlats/2 + $fingerComfortClearance + $fingerWidth/2
		);
}

$hexKeyHolder->xMax = $hexKeyHolder->segmentPositions[count($hexKeyHolderSegments) - 1]->x + ($hexKeyHolderSegments[count($hexKeyHolderSegments) - 1]->extentX)/2;

// $hexKeyHolder->mountHoles->positionZ = 
	// //$largestHexKeyHolderSegment->supportZ + $largestHexKeyHolderSegment->overhangRadius + $hexKeyHolder->mountHoles->screw->headClearanceDiameter/2; 
	// 1/2 * (
		// $smallestHexKeyHolderSegment->embedmentZ
		// + $smallestHexKeyHolderSegment->supportZ + $smallestHexKeyHolderSegment->overhangRadius
	// );
$hexKeyHolder->mountHoles->positionZ = -15 * $mm; 
//I have decided to lock the value of $hexKeyHolder->mountHoles->positionZ, independent of 
// the wrench sizes, so that adjacent holders, with mount holes all drilled at the same level,
// will hold all the wrench ends at the same level.
 
	
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


$drillOutSizeGuide = "";
foreach($hexKeyHolderSegments as $hexKeyHolderSegment)
{
	$drillOutSizeGuide .= 
		str_replace("\n","",$hexKeyHolderSegment->labelString) . "    " . 
		//round(($hexKeyHolderSegment->holsterHoleDiameter / $inch) * 64 , 1) . "/64 inch" . "\n" . 
		round(($hexKeyHolderSegment->holsterHoleDiameter / $inch) , 3) . " inch holsterHoleDiameter" . "\n" . 
		"";
}
echo $drillOutSizeGuide;

?>
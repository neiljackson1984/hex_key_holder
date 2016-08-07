<?php

setParameterSetId("73234fd11dd641aca0981e63b2b6e5d4");

$mm = 1;
$inch = 25.4 * $mm;


$degree = 1;
$radian = 180/pi();

$defaultHexKey->widthAcrossFlats = 6 * $mm;
$defaultHexKey->shortLegLength = 40 * $mm;
$defaultHexKey->longLegLength = 100 * $mm;
$defaultHexKey->bendRadius = 18 * $mm;
$defaultHexKey->holsterHoleDiameter = 10 * $mm;
$defaultHexKey->extraVerticalSlotDepth = 2 * $mm;
$defaultHexKey->totalSlotDepth = 8 * $mm;
$defaultHexKey->embedmentY = 20 * $mm;
$defaultHexKey->embedmentZ = 50 * $mm;
$defaultHexKey->holderExtentX = 25 * $mm;
$defaultHexKey->funnelFilletRadius = 5 * $mm; //we are guaranteed to be safe if we keep this less than 1/2 * (totalSlotDepth - extraVerticalSlotDepth);

// $hexKeys = 
// [
	// clone $defaultHexKey,
	// clone $defaultHexKey,
	// clone $defaultHexKey,
	// clone $defaultHexKey
	
// ];

$hexKey1 = clone $defaultHexKey;
$hexKey2 = clone $defaultHexKey;
$hexKey3 = clone $defaultHexKey;
$hexKey4 = clone $defaultHexKey;
$hexKey5 = clone $defaultHexKey;

$hexKey1->widthAcrossFlats = 1 * $mm;
$hexKey2->widthAcrossFlats = 2 * $mm;
$hexKey3->widthAcrossFlats = 3 * $mm;
$hexKey4->widthAcrossFlats = 4 * $mm;
$hexKey5->widthAcrossFlats = 5 * $mm;

$hexKey1->shortLegLength = $hexKey1->widthAcrossFlats * ($defaultHexKey->shortLegLength / $defaultHexKey->widthAcrossFlats);
$hexKey2->shortLegLength = $hexKey2->widthAcrossFlats * ($defaultHexKey->shortLegLength / $defaultHexKey->widthAcrossFlats);
$hexKey3->shortLegLength = $hexKey3->widthAcrossFlats * ($defaultHexKey->shortLegLength / $defaultHexKey->widthAcrossFlats);
$hexKey4->shortLegLength = $hexKey4->widthAcrossFlats * ($defaultHexKey->shortLegLength / $defaultHexKey->widthAcrossFlats);
$hexKey5->shortLegLength = $hexKey5->widthAcrossFlats * ($defaultHexKey->shortLegLength / $defaultHexKey->widthAcrossFlats);

$hexKey1->longLegLength  = $hexKey1->widthAcrossFlats * ($defaultHexKey->longLegLength  / $defaultHexKey->widthAcrossFlats);
$hexKey2->longLegLength  = $hexKey2->widthAcrossFlats * ($defaultHexKey->longLegLength  / $defaultHexKey->widthAcrossFlats);
$hexKey3->longLegLength  = $hexKey3->widthAcrossFlats * ($defaultHexKey->longLegLength  / $defaultHexKey->widthAcrossFlats);
$hexKey4->longLegLength  = $hexKey4->widthAcrossFlats * ($defaultHexKey->longLegLength  / $defaultHexKey->widthAcrossFlats);
$hexKey5->longLegLength  = $hexKey5->widthAcrossFlats * ($defaultHexKey->longLegLength  / $defaultHexKey->widthAcrossFlats);

$hexKey1->bendRadius     = $hexKey1->widthAcrossFlats * ($defaultHexKey->bendRadius     / $defaultHexKey->widthAcrossFlats);
$hexKey2->bendRadius     = $hexKey2->widthAcrossFlats * ($defaultHexKey->bendRadius     / $defaultHexKey->widthAcrossFlats);
$hexKey3->bendRadius     = $hexKey3->widthAcrossFlats * ($defaultHexKey->bendRadius     / $defaultHexKey->widthAcrossFlats);
$hexKey4->bendRadius     = $hexKey4->widthAcrossFlats * ($defaultHexKey->bendRadius     / $defaultHexKey->widthAcrossFlats);
$hexKey5->bendRadius     = $hexKey5->widthAcrossFlats * ($defaultHexKey->bendRadius     / $defaultHexKey->widthAcrossFlats);




$hexKeyHolder->hexKeysIntervalX = 30 * $mm;
$hexKeyHolder->hexKeysCount = 7;
$hexKeyHolder->hexKeysSpanX = $hexKeyHolder->hexKeysIntervalX * ($hexKeyHolder->hexKeysCount - 1);

$hexKeyHolder->mountingSurfaceOffset = 20 * $mm;

?>
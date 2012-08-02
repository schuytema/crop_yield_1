<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['size_units'] = array(
    'acres'=>"acres",  
    'sq. miles'=>"sq. miles"
);

$config['application_product'] = array(
    'Ammonia'=>"Ammonia",  
    'Lime'=>"Lime"
);

$config['application_units'] = array(
    'lbs/acre'=>"lbs/acre",  
    'tons/acre'=>"tons/acre"
);

$config['yield_units'] = array(
    'bu/acre'=>"bu/acre",  
    'bu/sq. mile'=>"bu/sq. mile"
);

$config['weight_units'] = array(
    'lbs/bu'=>"lbs/bu"
);

$config['fertilizer_units'] = array(
    'gal/acre'=>"gal/acre",
    'lbs/acre'=>"lbs/acre",
    'tons/acre'=>"tons/acre"
);

$config['fertilizer_form'] = array(
    'liquid'=>"liquid",
    'granular'=>"granular",
    'gas/NH3/anhydrous'=>"gas/NH3/anhydrous",
    'manure'=>"manure"
);

$config['weather'] = array(
    'Rain'=>"Rain",
    'Hail'=>"Hail",
    'Flood'=>"Flood",
    'Tornado'=>"Tornado",
    'Winds'=>"Winds"
);

$config['chemical_units'] = array(
    'oz/acre'=>"oz/acre",
    'pt/acre'=>"pt/acre",
    'qt/acre'=>"qt/acre",
    'gal/acre'=>"gal/acre",
    'lbs/acre'=>"lbs/acre"
);

$config['planting_rate_units'] = array(
    'seeds/acre' => 'seeds/acre',
    'lbs/acre' => 'lbs/acre'
);

$config['planting_row_spacing_units'] = array(
    'in' => 'in',
    'cm' => 'cm'
);

$config['seed_depth_spacing_units'] = array(
    'in' => 'in',
    'cm' => 'cm'
);

$config['crop_type'] = array(
    'Corn' => 'Corn',
    'Soybean' => 'Soybean',
    'Corn/Bean Intercrop' => 'Corn/Bean Intercrop', 
    'Wheat' => 'Wheat',
    'Oats' => 'Oats',
    'Alfalfa' => 'Alfalfa',
    'Pennycress' => 'Pennycress'
);

$config['no_yes'] = array(
    'no'=>"no",
    'yes'=>"yes",
);

$config['no_yes_boolean'] = array(
    '0'=>"No",
    '1'=>"Yes",
);

$config['no_yes_bool'] = array(
    '0'=>"No",
    '1'=>"Yes",
);

$config['tillage_practice'] = array(
    'Conventional'=>"Conventional",
    'Conservation'=>"Conservation",
    'No-Till'=>"No-Till",
    'Strip-Till'=>"Strip-Till"
);

$config['drainage'] = array(
    '0'=>"0% - Swamp Land",
    '25'=>"25% - Poor",
    '50'=>"50% - Average",
    '75'=>"75% - Good",
    '100'=>"100% - Excellent"
);

$config['tillage_type'] = array(
    '0'=>"Select Tillage Type",
    'Chisel Plow'=>"Chisel Plow",
    'Disk Offset'=>"Disk Offset",
    'Disk Ripper'=>"Disk Ripper",
    'Disk Tandem'=>"Disk Tandem",
    'Field Cultivator'=>"Field Cultivator",
    'Flail Shredder'=>"Flail Shredder",
    'Harrow'=>"Harrow",
    'In Line Ripper'=>"In Line Ripper",
    'Moldboard Plow'=>"Moldboard Plow",
    'Mulch Tiller (Chisel Plow w/Disks)'=>"Mulch Tiller (Chisel Plow w/Disks)",
    'Rod Weeder'=>"Rod Weeder",
    'Rolling Packer'=>"Rolling Packer",
    'Rotary Hoe'=>"Rotary Hoe",
    'Row Crop Cultivator'=>"Row Crop Cultivator",
    'Seed Bed Conditioner'=>"Seed Bed Conditioner",
    'Seed Bed Finisher'=>"Seed Bed Finisher",
    'Strip Tillage'=>"Strip Tillage",
    'Other'=>"Other"
);

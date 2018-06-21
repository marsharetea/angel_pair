<?php
/**
* Purpose: A photographic mosaic generator
* Description: Gathers information about images and composes a photographic mosaic
*
* @version Date: 1. may 2009
* @author �an Kafol
* @access public
*/

debug('--- STARTING MOSAIC ---');

/*
 * Set system boundaries and error reporting
 */

error_reporting(E_ALL);
set_time_limit(0);
ini_set('memory_limit','3G');

/*
 * Some parameters...
 */

//how big is the 'pixel' or piece of the composed mosaic image
$piece_w = 256;
$piece_h = 256;

//smaller scale of the template in pixels (in large scale this is $mosaic_w*$piece_w)
$mosaic_w = 30;
$mosaic_h = 45;

//algorithm for the average pixel scan (1=arithmetic_mean,2=harmonic_mean,3=median,4=modal_score,5=resample(),6=resize)
$average_type = 1;
//override this setting if it's passed as an argument
// if(count($argv)>1) $average_type = intval($argv[1]);

//jpeg compression quality [0..100], where 100 is best quality
$quality = 1;

//Where are your images stored (will be scaned recursively for .jpg files)
$imgdir = "/Applications/XAMPP/xamppfiles/htdocs/angel_pair/imgg";

//Template image (will be resized to $mosaic_w x $mosaic_h)
$source_img = "3_5513245.jpg";

//Filename of the generated mosaic
$output_image = "mosaic_$average_type.jpg";

//Index cache filename
$cache_idx = "cachergb-$average_type.txt";

//Cache in case something crashes
$generated_idx = "composit-$source_img-$mosaic_w-$mosaic_h-$piece_w-$piece_h-$average_type.txt";

//Cache smaller pieces (useful if your images are as-is, and once it has cache, this really speeds things up)
$piece_cache = "pieces";

/*
 * Start processing!
 *
 * a brief explanation on how this works:
 * - Get all available images (their relative filenames) in the array
 * - Loop through the array of images, extract their 'average pixel' - a one-color representation of the whole image in a 4D array
 *		where the first three dimensions are the [R][G][B] colorspace and the fourth is the array of image filenames that represent
 *		the current RGB color. Cache the array to disk, as the scan is intensive and the array is easily reused for a new photographic mosaic
 * - When we have our available pixel colors and their image representation in the array, we can begin building our mosaic.
 *		We take our template image and shrink it way down, because every pixel in that template will be an image. Loop through pixels, find the
 *		best approximation to the pixel color we have in our RGB array (there is little probability, that we have the exact pixel), and paste
 *		the image to the coordinate in the large-scale mosaic relative to the pixel in the template
 */

debug("average type set to $average_type !");
debug('Getting available images...');
//recursively scan all images in the directory and save them in the array
$all_images = get_images($imgdir);
if(!$all_images) {
	debug("invalid directory");
	die;
}

//Read indexes from cache - check if images exists
$_rgb_indexes = uncache_var($cache_idx);
foreach($_rgb_indexes as $r=>$gb_idx) {
	foreach($gb_idx as $g=>$b_idx) {
		foreach($b_idx as $b=>$images) {
			foreach($images as $image) {
				if(file_exists($image)) {
					$rgb_indexes[$r][$g][$b][] = $image;
					$cached[$image] = true;
				} else {
					debug("!!! Indexed file [$image] does not exist anymore!");
				}
			}
		}
	}
}

//Index all images, and skip the ones that are cached, add the ones that are not cached (new)
debug('Indexing '.count($all_images).' images for average pixel...');
$bfin = $proctime = 1;
foreach($all_images as $i=>$image) {
	if(!isset($cached[$image]) || !$cached[$image]) {
		$proctime = microtime(true);

		$piece = generate_piece($image,$piece_w,$piece_h,$piece_cache,$quality);

		if(!$piece) {
			debug("something went wrong!");
			die;
		}

		list($r,$g,$b) = get_average_pixel($piece,$average_type);
		imagedestroy($piece);

		$rgb_indexes[$r][$g][$b][] = $image;
		$cached[$image] = true;
		$n_pix = count($rgb_indexes[$r][$g][$b]);

		cache_var($rgb_indexes,$cache_idx);

		$percent = $i/count($all_images);
		$proctime = microtime(true) - $proctime;
		$fin = percent($percent);
		$eta = duration(($proctime*(1-$percent)) / ($percent-$bfin));
		debug("INDEX $image [$fin%] [ETA: $eta] [avgpx($r,$g,$b)] [c: $n_pix]");
		$bfin = $percent;
		$bproctime = $proctime;
	}
}
cache_var($rgb_indexes,$cache_idx);


//Prepare the template and allocate the memory for the mosaic
debug('Preparing for composit...');
if(!file_exists($source_img)) {
	debug('template does not exist!');
	die;
}
$original = imagecreatefromjpeg($source_img);
$template = imagecreatetruecolor($mosaic_w,$mosaic_h);
imagecopyresampled($template,$original,0,0,0,0,$mosaic_w,$mosaic_h,imagesx($original),imagesy($original));
imagedestroy($original);

debug('Checking for cached composit...');
$gen_pieces = uncache_var($generated_idx);
if(count($gen_pieces)>0) {
	debug('Opening cached composit...');
	$mosaic = imagecreatefromjpeg($output_image);
	if(!$mosaic) {
		debug("corrupt index and/or dumped file! cleaning up...");
		if(file_exists($generated_idx)) unlink($generated_idx);
		debug("restart the composit! aborting...");
		die;
	}
} else {
	debug('Allocating memory for the new image...');
	$mosaic = imagecreatetruecolor($mosaic_w*$piece_w,$mosaic_h*$piece_h);
}

//Start putting photos on the image as they were pixels
debug('Generating composition ...');
$loops = 0;
for($i=0;$i<$mosaic_w;$i++) {
	for($j=0;$j<$mosaic_h;$j++) {
		//if this is a fix, skip pieces that are already generated
		if(isset($gen_pieces[$i][$j]) && $gen_pieces[$i][$j]) {
			debug("skipping pixel [$i][$j] ...");
			continue;
		}

		$proctime = microtime(true);

		list($r,$g,$b) = rgb(imagecolorat($template,$i,$j));

		//Find the best matching color
		foreach($rgb_indexes as $x1=>$xi) {
			foreach($xi as $y1=>$yi) {
				foreach($yi as $z1=>$zi) {
					$distance = distance($x1,$y1,$z1,$r,$g,$b);
					if(!isset($min_distance) || $distance<$min_distance) {
						$min_distance = $distance;
						$br = $x1;
						$bg = $y1;
						$bb = $z1;
					}
				}
			}
		}
		//This estimate is preety bad
		// $kbr = $kbg = $kbb = 999;
		// foreach($rgb_indexes as $red_index => $rest_indexes) if(abs($r-$red_index) < abs($r-$kbr)) $kbr = $red_index;
		// foreach($rgb_indexes[$kbr] as $green_index => $rest_indexes) if(abs($g-$green_index) < abs($g-$kbg)) $kbg = $green_index;
		// foreach($rgb_indexes[$kbr][$kbg] as $kblue_index => $images) if(abs($b-$kblue_index) < abs($b-$kbb)) $kbb = $kblue_index;
		// $prev_dist = distance($kbr,$kbg,$kbg,$r,$g,$b);


		//At these RGB coordinates, we have one or more images. Choose a random one.
		$best_match_pixels = $rgb_indexes[$br][$bg][$bb];
		$n_matching = count($best_match_pixels)-1;
		$r_match = rand(0,$n_matching);
		$best_match = $best_match_pixels[$r_match];
		$distincts[$best_match] = true;

		//Put the piece on the composit
		$piece = generate_piece($best_match,$piece_w,$piece_h,$piece_cache,$quality);
		$success = imagecopy($mosaic,$piece,$i*$piece_w,$j*$piece_h,0,0,$piece_w,$piece_h);
		imagedestroy($piece);

		//Print some statistical data on the screen
		$percent = ++$loops/($mosaic_w*$mosaic_h);
		$proctime = microtime(true) - $proctime;
		$eta = duration(($proctime*(1-$percent)) / ($percent-$bfin));
		$fin = percent($percent);
		$est = percent((distance(0,0,0,255,255,255)-$min_distance)/distance(0,0,0,255,255,255));
		$ests[] = $est; $r_match++; $n_matching++;
		debug("COMP [$fin%] [ETA: $eta] $est% match [$r_match/$n_matching] for ($r,$g,$b) to ($br,$bg,$bb) => $best_match");

		$bfin = $percent;
		$bproctime = $proctime;
		unset($min_distance);

		//Check if everything is successfull
		if($success) {
			$gen_pieces[$i][$j] = true;
		} else {
			debug("error in generating, chechk it out! dumping current composit...");
			cache_var($gen_pieces,$generated_idx);
			imagejpeg($mosaic,$output_image,$quality);
			debug("abort!");
			die;
		}
	}
}

//Mosaic is generated, output it to disk and exit
$distinct = count($distincts);
imagedestroy($template);
$est = arithmetic_mean($ests);
debug("Saving generated image to $output_image (composed from $loops images, $distinct distinct photos) $est% match overall...");
imagejpeg($mosaic,$output_image,$quality);
debug('Saved! Unallocating memory...');
imagedestroy($mosaic);
if(file_exists($generated_idx)) unlink($generated_idx);
debug('--- ALL DONE ---');

/*
 * Functions
 */

//Calculates Euclidian distance between two points in space (3-norm)
function distance($x1,$y1,$z1,$x2,$y2,$z2) {
	return pow(pow(abs($x1-$x2),3)+pow(abs($y1-$y2),3)+pow(abs($z1-$z2),3),1/3);
}

//Calculates Euclidian distance between two points in p-norm
function euclidian_distance($p1,$p2) {
	$distances = 0;
	$norm = (count($p1)+count($p2))/2;
	for($i=0;$i<$norm;$i++) $distances += pow(abs($p1[$i]-$p2[$i]),$norm);
	return pow($distances,1/$norm);
}

//Reads the variable from disk
function uncache_var($file) {
	if(!file_exists($file)) return array();
	$handle = fopen($file,'r');
	$contents = fread($handle, filesize($file));
	fclose($handle);
	return unserialize($contents);
}

//Saves the variable to disk
function cache_var($var,$file) {
	$fh = fopen($file,'w+');
	fwrite($fh,serialize($var));
	fclose($fh);
}

//Generates the 'block' or 'pixel' of the mosaic
function generate_piece($image,$piece_w,$piece_h,$cache=false,$quality=100) {
	$sha = sha1($image);
  $image2 = explode(".", $image);
	$cfn = $image2[0]."_1.jpg";

	//Check if cache of the piece exists
	if($cache && file_exists($cfn)) {
		return imagecreatefromjpeg($cfn);
	}

	$original = imagecreatefromjpeg($image);
	$original_min = min(imagesx($original),imagesy($original));

	//Take the center of crop
	$src_x = (imagesx($original)-$original_min)/2;
	$src_y = (imagesy($original)-$original_min)/2;

	//Shrink it down
	$piece = imagecreatetruecolor($piece_w,$piece_h);
	$success = imagecopyresampled($piece,$original,0,0,$src_x,$src_y,$piece_w,$piece_h,$original_min,$original_min);
	imagedestroy($original);

	//Cache it
	if($cache && $success) {
		if(!is_dir($cache)) mkdir($cache);
		imagejpeg($piece,$cfn,$quality);
	}

	return $success?$piece:false;
}

//Returns a one-color representation of an image
function get_average_pixel($im,$average_type) {
	$width = imagesx($im);
	$height = imagesy($im);
	switch($average_type) {
		case 1:
		case 2:
		case 3:
		case 4:
			$r = $g = $b = array();
			for($i=0;$i<$width;$i++) {
				for($j=0;$j<$height;$j++) {
					$rgb = rgb(imagecolorat($im, $i, $j));
					$r[] = $rgb[0];
					$g[] = $rgb[1];
					$b[] = $rgb[2];
				}
			}
			return array(px_avg($r,$average_type),px_avg($g,$average_type),px_avg($b,$average_type));
		case 5:
			$onepx = imagecreatetruecolor(1,1);
			imagecopyresampled($onepx,$im,0,0,0,0,1,1,$width,$height);
			$rgb = imagecolorat($onepx,0,0);
			imagedestroy($onepx);
			return rgb($rgb);
		case 6:
			$onepx = imagecreatetruecolor(1,1);
			imagecopyresized($onepx,$im,0,0,0,0,1,1,$width,$height);
			$rgb = imagecolorat($onepx,0,0);
			imagedestroy($onepx);
			return rgb($rgb);
	}
}

//Calculates the average of an array
function px_avg($a,$average_type) {
	switch($average_type) {
		case 1: return round(arithmetic_mean($a));
		case 2: return round(harmonic_mean($a));
		case 3: return round(median($a));
		case 4: return round(modal_score($a));
	}
}

// List all 'jpg' files in a directory, recursively
function get_images($folder) {
	$files = array();
	if(!is_dir($folder)) return false;
	if ($handle = opendir($folder)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != '.' && $file != '..') {
				if(strtolower(file_extension($file)) == 'jpg') {
					$files[] = "$folder/$file";
				}
				if(is_dir("$folder/$file")) {
					$recursive = get_images("$folder/$file");
					foreach($recursive as $rfile) $files[] = $rfile;
				}
			}
		}
		closedir($handle);
	}
	return $files;
}

// Get file extension
function file_extension($filename) {
		if (strpos($filename, "_1.jpg")) {
				return "none";
		}
    $filename2 = explode('.', $filename);
    return end($filename2);
}

//Average functions
function arithmetic_mean($a) {
	return array_sum($a)/count($a);
}
function geometric_mean($a) {
	$mul = 0.0;
	foreach($a as $i=>$n) $mul = (float) (($i == 0) ? $n : $mul*$n);
	return pow($mul,1/count($a));
}
function harmonic_mean($a) {
	$sum = 0;
	foreach($a as $n) $sum += ($n == 0) ? 0 : 1/$n;
	return (1/$sum)*count($a);
}
function median($a) {
	sort($a,SORT_NUMERIC);
	return (count($a)%2 == 0) ?
		$a[floor(count($a)/2)] :
		($a[count($a)/2] + $a[count($a)/2 - 1]) / 2;
}
function modal_score($a) {
	$quant = array();
	foreach($a as $n) {
		if(isset($quant[$n])) {
			$quant[$n]++;
		} else {
			$quant[$n] = 1;
		}
	}
	$max = 0;
	$mode = 0;
	foreach($quant as $key=>$n) {
		if($n>$max) {
			$max = $n;
			$mode = $key;
		}
	}
	return $mode;
}

//Returns array(R,G,B) of an (int) color (bit shift)
function rgb($rgb) {
	$r = ($rgb >> 16) & 0xFF;
	$g = ($rgb >> 8) & 0xFF;
	$b = $rgb & 0xFF;
	return array($r,$g,$b);
}

//Custom println() ;-)
function debug($msg) {
	print("[".udate("d.m.Y H:i:s.u")."] $msg\n");
}

//Custom date function ;) - for milliseconds
function udate($format, $utimestamp = null) {
	if (is_null($utimestamp)) $utimestamp = microtime(true);
	$timestamp = floor($utimestamp);
	$milliseconds = round(($utimestamp - $timestamp) * 1000000);
	return date(preg_replace('`(?<!\\\\)u`', $milliseconds, $format), $timestamp);
}

//Returns time span duration
function duration($seconds) {
	$days = floor($seconds/60/60/24);
	$hours = $seconds/60/60%24;
	$mins = $seconds/60%60;
	$secs = $seconds%60;

	$duration='';
	if($days>0) $duration .= "{$days}d";
	if($hours>0) $duration .= "{$hours}h";
	if($mins>0) $duration .= "{$mins}m";
	if($secs>0) $duration .= "{$secs}s";

	$duration = trim($duration);
	if($duration==null) $duration = 'n/a';

	return $duration;
}

//Returns percentage rounded to n decimal points
function percent($percent,$decimal=2) {
	return round($percent * 100 * pow(10,$decimal)) / pow(10,$decimal);
}
?>

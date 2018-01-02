<?php
	$imageDir = "img/";
	$imagePath = array("gb1.png", "gb2.png", "gb3.png", "gb4.png", "gb5.png", "gb7.png" );
	$w = 0;
	$h = 0;

	//6 cluster color
	$initColor = array(array(52, 152, 219),
                        array(192, 57, 43),
                        array(241, 196, 15),
                        array(46, 204, 113),
                        array(142, 68, 173),
                        array(211, 84, 0));

	function start($cluster){
	    GLOBAL $imageDir, $imagePath;    
	    preprocessingImage($imageDir, $imagePath, $cluster);
	}

	function preprocessingImage($imageDir, $imagePath, $cluster){
	    //get the feature space
	    $feature_space = array();
	    for($i=0 ; $i < count($imagePath) ; $i++){
	        $feature_space[$i] = convertColorSpace($imageDir.$imagePath[$i]);
	    }
	    $feature_space = transpose_data($feature_space);

	    //cluster the feature space. from 2d to 3d
	    $clustered_feature_space = hierarchicalClustering($feature_space, $cluster);

	    //make the image
	    createImage($clustered_feature_space);

	}

	function hierarchicalClustering($feature_space, $numberCluster){
	    $cluster = array(array(array()));

	    //turn feature space into cluster based feature space
	    $index_pos = count($feature_space[0]);
	    for($i=0;$i<count($feature_space);$i++){
	        $cluster[$i][0] = $feature_space[$i];
	        $cluster[$i][0][$index_pos] = $i;
	    }
	    

	    while (sizeof($cluster)>$numberCluster) {
	        $new_cluster=array(array());
	        $distance=9999999;
	        $closest_cluster=0;
	        //searching the shortest distance from a cluster to another cluster 
	        foreach ($cluster[0] as $data1) {

	            for ($j=1; $j < sizeof($cluster) ; $j++) { 
	                foreach ($cluster[$j] as $data2) {
	                    $new_distance=0;
	                    for ($k=0; $k < 6; $k++) { 
	                        $new_distance+=pow($data1[$k]-$data2[$k],2);
	                    }
	                    $new_distance=sqrt($new_distance);
	                    if($new_distance<$distance){
	                        $distance=$new_distance;
	                        $closest_cluster=$j;
	                    }
	                }       
	            }
	        }
	        //merging a cluster to the closest cluster
	        $cnt=0;
	        for ($i=1; $i < sizeof($cluster); $i++) { 
	            if($i!=$closest_cluster){
	                $new_cluster[$cnt]=$cluster[$i];
	                $cnt++;
	            }
	        }
	        array_push($new_cluster,array_merge($cluster[0],$cluster[$closest_cluster]));
	        
	        
	        unset($cluster);
	        $cluster=$new_cluster;
	        unset($new_cluster);
	        unset($clustered_index);
	    }
	    
	    return $cluster;
	}

	function convertColorSpace($im_path){
	    GLOBAL $w, $h;
	    $im = imagecreatefrompng($im_path);
	    $imgw = imagesx($im);
	    $imgh = imagesy($im);

	    $w = $imgw;
	    $h = $imgh;

	    $arr_color = array();
	    $pos = 0;
	    for($y=0 ; $y < $imgh ; $y++){
	        for($x=0 ; $x < $imgw ; $x++){
	            $grayscale = ImageColorAt($im, $x, $y);

	            $arr_color[$pos] = $grayscale & 0xFF;
	            $pos++;
	            
	        }
	    }

	    return $arr_color;
	}

	function createImage($clustered_fs){
	    GLOBAL $initColor, $w, $h;

	    $newImage = imagecreatetruecolor($w, $h);

	    $clustered_label = $array = array_fill(0,$w*$h, 0);

	    $index_pos = count($clustered_fs[0][0])-1;
	    for($i=0; $i<count($clustered_fs);$i++){
	        for($j = 0 ; $j < count($clustered_fs[$i]); $j++){
	            $clustered_label[$clustered_fs[$i][$j][$index_pos]] = $i;
	        }
	    }

	    $pos=0;
	    for($y=0 ; $y < $w ; $y++){
	        for($x=0 ; $x < $h ; $x++){
	            $label = $clustered_label[$pos];
	            $px_color = imagecolorallocate($newImage, $initColor[$label][0], $initColor[$label][1], $initColor[$label][2]);
	            imagesetpixel($newImage, round($x),round($y), $px_color);
	            $pos++;
	        }
	    }
	    imagepng($newImage, '6cluster.png');
	}

	function transpose_data($data){
	    $retData = array();
	    foreach ($data as $row => $columns) {
	      foreach ($columns as $row2 => $column2) {
	          $retData[$row2][$row] = $column2;
	      }
	    }
	    return $retData;
	}
?>
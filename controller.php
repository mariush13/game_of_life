<?php 

class GameOfLife {
	
    public $matrix;
    
	public function __construct($xajax) {
		$this->matrix = array();	
		$this->xajax=$xajax;
        $this->response = new xajaxResponse();
	}
	
	
	public function generate($x, $y, $fill) {
	    $this->x = $x;
		$this->y = $y;
		$this->fill = $fill;
		for ($i=0; $i < $this->x; $i++){
			for ($j=0; $j<$this->y; $j++){
				$this->matrix[$i][$j] = (rand(1,100) <= $this->fill);
			}
		}
		$this->saveToFile();
		$this->response->assign('matrix','innerHTML',$this->render(20,20));
	    return $this->response;
	}
	
	public function saveToFile() {
	    $h = fopen('matrix.txt','w');
	    fwrite($h,serialize($this->matrix));
	    fclose($h);  
	}
	
	public function openFromFile(){
	    $this->matrix = unserialize(file_get_contents('matrix.txt'));
	    $this->response->assign('matrix','innerHTML',$this->render(20,20));
	    return $this->response;
	    $this->x = sizeof($this->matrix);
	    $this->y = sizeof($this->matrix[0]);  
	}
	
	private function render($width, $height) {
	    $this->x = sizeof($this->matrix);
	    $this->y = sizeof($this->matrix[0]);  
		$content = '';
		for ($i=0; $i < $this->x; $i++){
			for ($j=0; $j<$this->y; $j++){
			$content .= '<div class="cell '.(($this->matrix[$i][$j])? 'true' : 'false').'" style="left: '.$i*$width.'px; top: '.$j*$height.'px; ">
			
			</div>';	
			}
		}		
		return $content;
	}
	
	private function getNeighbors($x, $y){
	$neighbors = array(
		((isset($this->matrix[$x-1][$y-1])) ? $this->matrix[$x-1][$y-1] : false),
		((isset($this->matrix[$x][$y-1])) ? $this->matrix[$x][$y-1] : false),
		((isset($this->matrix[$x+1][$y-1])) ? $this->matrix[$x+1][$y-1] : false),
		((isset($this->matrix[$x-1][$y])) ? $this->matrix[$x-1][$y] : false),
		((isset($this->matrix[$x+1][$y])) ? $this->matrix[$x+1][$y] : false),
		((isset($this->matrix[$x-1][$y+1])) ? $this->matrix[$x-1][$y+1] : false),
		((isset($this->matrix[$x][$y+1])) ? $this->matrix[$x][$y+1] : false),
		((isset($this->matrix[$x+1][$y+1])) ? $this->matrix[$x+1][$y+1] : false)
		);	
		$count = 0;
		foreach (array_values($neighbors) as $n){
			if ($n){ $count++; }
		}    
		return $count;
	}
	
	private function getState($x, $y){
		$neighbors = array(
		((isset($this->matrix[$x-1][$y-1])) ? $this->matrix[$x-1][$y-1] : false),
		((isset($this->matrix[$x][$y-1])) ? $this->matrix[$x][$y-1] : false),
		((isset($this->matrix[$x+1][$y-1])) ? $this->matrix[$x+1][$y-1] : false),
		((isset($this->matrix[$x-1][$y])) ? $this->matrix[$x-1][$y] : false),
		((isset($this->matrix[$x+1][$y])) ? $this->matrix[$x+1][$y] : false),
		((isset($this->matrix[$x-1][$y+1])) ? $this->matrix[$x-1][$y+1] : false),
		((isset($this->matrix[$x][$y+1])) ? $this->matrix[$x][$y+1] : false),
		((isset($this->matrix[$x+1][$y+1])) ? $this->matrix[$x+1][$y+1] : false)
		);	
		$count = 0;
		foreach (array_values($neighbors) as $n){
			if ($n){ $count++; }
		}
		
		// martwa komórka z 3 sąsiadami rodzi się
		if (!$this->matrix[$x][$y] && $count == 3){
		    return true;
		}
		
		// żywa komórka z 2 lub 3 sąsiadami pozostaje przy życiu
		if ($this->matrix[$x][$y] && in_array($count,array(2,3))){
		    return true;
		}
		
		// żywa komórka z mniej niż dwoma lub więcej niż 3 sąsiadami umiera
		if ($this->matrix[$x][$y] && in_array($count, array(0,1,4,5,6,7,8))){
		    return false;
		}
	}
	
	public function changeState(){
	    $this->openFromFile();
		for ($i=0; $i < $this->x; $i++){
			for ($j=0; $j<$this->y; $j++){
				$this->matrix[$i][$j] = $this->getState($i,$j);
					
			}	
	
		}
        $this->saveToFile();
		$this->response->assign('matrix','innerHTML',$this->render(20,20));
	    return $this->response;
	}	
	
}


?>
<?php 

class GameOfLife {
	
	public function __construct($x, $y, $fill){
		$this->x = $x;
		$this->y = $y;
		$this->fill = $fill;
		$this->matrix = array();	
	}
	
	public function generate(){
		for ($i=0; $i < $this->x; $i++){
			for ($j=0; $j<$this->y; $j++){
				$this->matrix[$i][$j] = (rand(1,100) <= $this->fill);
			}
		}
	}
	
	public function render($width, $height) {
		$content = '';
		for ($i=0; $i < $this->x; $i++){
			for ($j=0; $j<$this->y; $j++){
			$content .= '<div class="cell '.(($this->matrix[$i][$j])? 'true' : 'false').'" style="left: '.$i*$width.'px; top: '.$j*$height.'px; "></div>';	
			}
		}		
		return $content;
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
		
		
		if ($this->matrix[$x][$y]){
			if ($count==2 or $count == 3){
				return true;
			}else {
				return false;
			}
		}else {
			if ($count==3){
				return true;
			}else {
				return false;
			}
		}
	}
	
	public function changeState(){
		$this->newMatrix = array();
		for ($i=0; $i < $this->x; $i++){
			for ($j=0; $j<$this->y; $j++){
				$this->newMatrix[$i][$j] = $this->getState($i,$j);
					
			}	
	
		}
		$this->matrix[$i][$j]= $this->newMatrix;
		return $this->render(20,20);
	}	
	
}


?>
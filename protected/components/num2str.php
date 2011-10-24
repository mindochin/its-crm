<?php 
/***********************************************************
 Copyright (C) 2009 http://vladname.ru
 Name: num2str
 Description: Сумма прописью
 Author: http://php.spb.ru/php/propis.html
************************************************************/
class num2str
{
	var $_1_2=array('1'=>"одна ",'2'=>"две ");

	var $_1_19=array('1'=>"один ",'2'=>"два ",'3'=>"три ",'4'=>"четыре ",'5'=>"пять ",'6'=>"шесть ",'7'=>"семь ",
		'8'=>"восемь ",'9'=>"девять ",'10'=>"десять ",'11'=>"одиннацать ",'12'=>"двенадцать ",'13'=>"тринадцать ",
		'14'=>"четырнадцать ",'15'=>"пятнадцать ",'16'=>"шестнадцать ",'17'=>"семнадцать ",'18'=>"восемнадцать ",'19'=>"девятнадцать ");

	var $des=array('2'=>"двадцать ",'3'=>"тридцать ",'4'=>"сорок ",'5'=>"пятьдесят ",'6'=>"шестьдесят ",'7'=>"семьдесят ",
		'8'=>"восемьдесят ",'9'=>"девяносто ");

	var $hang=array('1'=>"сто ",'2'=>"двести ",'3'=>"триста ",'4'=>"четыреста ",'5'=>"пятьсот ",'6'=>"шестьсот ",
		'7'=>"семьсот ",'8'=>"восемьсот ",'9'=>"девятьсот ");
	var $namerub=array('1'=>"рубль ",'2'=>"рубля ",'3'=>"рублей ");
	var $nametho=array('1'=>"тысяча ",'2'=>"тысячи ",'3'=>"тысяч ");

	var $namemil=array('1'=>"миллион ",'2'=>"миллиона ",'3'=>"миллионов ");

	var $namemrd=array('1'=>"миллиард ",'2'=>"миллиарда ",'3'=>"миллиардов ");

	var $kopeek=array('1'=>"копейка ",'2'=>"копейки ",'3'=>"копеек ");


	private function _semantic($i,&$words,&$fem,$f)
	{
		$words="";
		$fl=0;
		if($i >= 100){
			$jkl = intval($i / 100);
			$words.=$this->hang[$jkl];
			$i%=100;
		}
		if($i >= 20){
			$jkl = intval($i / 10);
			$words.=$this->des[$jkl];
			$i%=10;
			$fl=1;
		}
		switch($i){
			case 1: $fem=1; break;
			case 2:
			case 3:
			case 4: $fem=2; break;
			default: $fem=3; break;
		}
		if( $i ){
			if( $i < 3 && $f > 0 ){
				if ( $f >= 2 ) {
					$words.=$this->_1_19[$i];
				}
				else {
					$words.=$this->_1_2[$i];
				}
			}
			else {
				$words.=$this->_1_19[$i];
			}
		}
	}


	public function convert($L)
	{
		$s="";//" "
		$s1=" ";
		$s2=" ";
		$kop=intval( ( $L*100 - intval( $L )*100 ));
		//$kop=intval(round(floatval($L)-intval($L),2)*100);
		$L=intval($L);
		if($L>=1000000000){
			$many=0;
			$this->_semantic(intval($L / 1000000000),$s1,$many,3);
			$s.=$s1.$this->namemrd[$many];
			$L%=1000000000;
		}

		if($L >= 1000000){
			$many=0;
			$this->_semantic(intval($L / 1000000),$s1,$many,2);
			$s.=$s1.$this->namemil[$many];
			$L%=1000000;
			if($L==0){
				$s.="рублей ";
			}
		}

		if($L >= 1000){
			$many=0;
			$this->_semantic(intval($L / 1000),$s1,$many,1);
			$s.=$s1.$this->nametho[$many];
			$L%=1000;
			if($L==0){
				$s.="рублей ";
			}
		}

		if($L != 0){
			$many=0;
			$this->_semantic($L,$s1,$many,0);
			$s.=$s1.$this->namerub[$many];
		}

		if($kop > 0){
			$many=0;
			$this->_semantic($kop,$s1,$many,1);
			$s.=$s1.$this->kopeek[$many];
		}
		else {
			$s.=" 00 копеек";
		}

		return $s;
	}
}
?>
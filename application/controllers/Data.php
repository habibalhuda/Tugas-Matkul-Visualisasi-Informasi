<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$jsonData='[{"nama":"I\/a","jumlah":"4"},{"nama" :"I\/b","jumlah":"11"},{"nama": "I\/c","jumlah":"52"},{"nama":"I\/d","jumlah":"21"},{"nama":"II\/a","jumlah":"187"},{"nama":"II\/b","jumlah":"83"},{"nama":"II\/c","jumlah":"391"},{"nama":"II\/d","jumlah":"228"},{"nama":"III\/a","jumlah":"442"},{"nama":"III\/b","jumlah":"946"},{"nama":"III\/c","jumlah":"476"},{"nama":"III\/d","jumlah":"589"},{"nama":"IV\/a":"jumlah":"1432"},{"nama":"IV\/b"."jumlah":"118"},{"nama":"IV\/c","jumlah":"41"},{"nama":"IV\/d","jumlah":"5"},{"nama":"IV\/e","jumlah":"3"}]';

 		$jsonData2='[{"tahun":"2010","val":0},{"tahun":"2011","val":0},{"tahun":"2012","val":0},{"tahun":"2013","val":0},{"tahun":"2014","val":0},{"tahun":"2015","val":0},{"tahun":"2016","val":52943.00},{"tahun":"2017","val":54760.00},{"tahun":"2018","val":0}]';

		 $jumlahPangkat=json_decode($jsonData);
 		$gafik_data=[];
 		foreach($jumlahPangkat as $row)
 		{
 			$dt=array($row->nama,intval($row->jumlah));
 			array_push($grafik_data, $dt);
 		}

		 $jsonData2Array=json_decode($jsonData2);

 		$grafik_data2=[];
 		foreach($jsonData2Array as $row)

 		{
 			$dt=array($row->tahun,intval($row->val));
 			array_push($grafik_data2, $dt);
 		}

	}


	

	function grafik()
	{
	
	
	$chartData=file_get_contents("assets/datapenjualan.json"); 
	
	
	$chartData=json_decode($chartData);
	
	$res=array();
	
	foreach($chartData as $row)
	{
	
		$dat=[$row->tahun,
		
		(double)$row->val];
		
		array_push($res, $dat);
	}

	
	
	//echo json_encode($res);
	$data['PieChartTitle']="jumlah penjualan pertahun produk Thrifting";
	$data['PieChartData']=json_encode($res);
	//var_dump($res);die();
	$this->load->view('grafik',$data);
	
	
	  
	
		/*munculin file json
		$chartData=file_get_contents("assets/datapenjualan.json"); 
		echo $chartData;*/






		//echo 'Geafik';

	/*	$chartData=file_get_contents('assets/datapenjualan.json');
		$chartData=json_decode($chartData);
		$res=array();
		foreach($chartData as $row)
		{
			$dat=[$row->tahun,(double)$row->val];
		}


		//echo $chartData;
		$data['PieChartData']=json_encode($res);
		$this->load->view('grafik',$data);*/
	
	}

	function salesChannel()
	{
		// piechart
		$source=file_get_contents("assets/codebeautify.json");
		$source=json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/','',$source),true);
		
		//$result=array();
		//var_dump($source);die();
		//echo json_encode($result);
		
		foreach($source as $row)
		{
			if(!isset($result[$row['salesChannel']]))
			{
				$result[$row['salesChannel']]=array($row['custId']);
			}else{
				array_push($result[$row['salesChannel']], $row['custId']);
			}
			
		}
		//echo json_encode($result);
		 $keys=array_keys($result);
			//var_dump($result);die();
		 $salesChannel=array();
		 foreach($keys as $row)
		 {
			$salesChannel[]=[$row,count($result[$row])];
		 }
		 $data['PieChartData']=json_encode($salesChannel);
		 $data['PieChartTitle']='Sales Channel Data';

		// $this->load->view('grafik',$data);
		//echo json_encode($data);

		//sales data
		$sales=[array('TANGGAL','UNIT SOLD 2022')];
		foreach($source as $row)
		{
			$year=date('Y',strtotime($row['dateSold']));
			$month=date('n',strtotime($row['dateSold']));
			if($year=='2022' && $month<8)
			{
				$dat=array($row['dateSold'],(double)$row['unitSold']);
				array_push($sales,$dat);

			}
			
		}
		
		$data['LineChartData']=json_encode($sales);
		$data['LineChartTitle']='Data Penjualan';
		
		//echo json_encode($sales);

		//view data
		//$this->load->view('grafik',$data);


		

		//SALES TOTAL PER MONTH
		$salesTotal	 =[['BULAN','TOTAL SOLD',['role' => 'style']]];
		$totalData = [];
		foreach($source as $row){

			
			$year = date('Y',strtotime($row["dateSold"]));
			$month = date('n',strtotime($row["dateSold"]));
			$totalData = [];
			if($year = "2022" ) {
			
				if(!isset($totalData[$month])) {
					 $totalData[$month] = [(double)$row["unitSold"]] ;
				
				}else {   
					array_push($totalData[$month],(double)$row["unitSold"]);
				}
			}
			//$months = array_keys($totalData);
			foreach(array_keys($totalData) as $row){
				$dat = [$row,array_sum($totalData[$row]),'color : gold'];
				array_push($salesTotal,$dat);
			}
			//echo json_encode($months);   
			$data['BarChartData'] = json_encode($salesTotal);
			$data['BarChartTitle'] = 'Penjualan perbulan 2022';
		}
		
		
		//echo json_encode($months);

		
	







		// Perbandingan penjualan 2021 dan 2022
		$salesTotal=[array('BULAN','TOTAL SOLD 2022','TOTAL SOLD 2021')];
		//var_dump($source);die();
		$totalData=array('2021'=>array(),'2022'=>array());
		//var_dump($totalData);die();

		//var_dump($year);die();
		foreach($source as $row)
		{
			$year=date('Y', strtotime($row['dateSold']));
			//var_dump($year);die();
			$month=date('n',strtotime($row['dateSold']));
			//var_dump($month);die();
		
			if($year=='2022')
			{
				
				if(!isset($totalData['2022'][$month]))
				{
			
					 $totalData['2022'][$month]=[(double)$row['unitSold']];
	
				}else{
					array_push($totalData['2022'][$month],(double)$row['unitSold']
					
				);

				}
			}
			if($year=='2021')
			{
				
				if(!isset($totalData['2021'][$month]))
				{
					$totalData['2021'][$month]=[(double)$row['unitSold']];
				}else{
					array_push($totalData['2021'][$month],(double)$row['unitSold']);
				}

			}
			
		}
		$month=array_keys($totalData['2022']);
		for($i=1; $i<= 12; $i++) {
				$dat22 = 0;
				$dat21 = 0;
				if(isset($totalData['2022'][$i])){$dat22=array_sum($totalData['2022'][$i]);}
				if(isset($totalData['2021'][$i])){$dat21=array_sum($totalData['2021'][$i]);}
				$dt = [$i,$dat22,$dat21];
				array_push($salesTotal,$dt);
		}
		//echo json_encode($salesTotal);
		//echo json_encode($salesTotal);
		$data['ColumnChartData']=json_encode($salesTotal);
			//var_dump($salesTotal);die();
		$data['ColumnChartTitle']='Perbandingan penjualan Tahun 2021 dan 2022';
		//view Data

		$this->load->view('grafik',$data);
	}
}
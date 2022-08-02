<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jsonsource extends CI_Controller {

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

       $jsonFile=file_get_contents("assets/codebeautify.json");
		//var_dump($jsonData);

	$jsonData=json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/','', $jsonFile), true);

		$res=array();
		$keysArray=array();
		foreach($jsonData as $row)
		{
			$custID=(int)$row['custId'];
			if($custID!=0)
			{
				if(!isset($res[$row['salesChannel']]))
				{
					$res[$row['salesChannel']]=array($row['custId']);
					array_push($keysArray,$row['salesChannel']);
				}else{
					array_push($res,[$row['salesChannel']], $row['custId']);
				}
			}
		}

		

		$data=array();
		//var_dump($data);die();
		foreach($keysArray as $row)

		{
			$data[]=array($row,count($res[$row]));

		}

	

		$title='Presentase Penjualan Produk Rip Curl';
		
		$data['grafik_data']=json_encode($data);
		//var_dump($data);die();
		$data['title']=$title;
		$this->load->view('data',$data);
    }


}
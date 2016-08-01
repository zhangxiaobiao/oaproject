<?php 

namespace Admin\Controller;

use Think\Controller;
class IpController extends Controller
{
	public function index()
	{
		$this->display();
	}
	public function getip()
	{
		$data = I('post.ip');
		$ip = new \Org\Net\IpLocation('qqwry.dat');
		$location = $ip->getlocation($data);
		$info = iconv('gbk','utf-8',$location['country'].$location['area']);
		echo json_encode($info);
		


	}
}
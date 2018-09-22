<?php
namespace app\index\controller\v2;
use \think\Controller;


/**
* 
*/
class Other extends Controller
{
	
	public function other_product_description()
	{
		return $this->fetch();
	}
	public function other_about_us()
	{
		return $this->fetch();
	}
}

?>
<?php
namespace  app\admin\controller\v1;
use  app\Models\Goods as GoodsModel;
use app\admin\controller\v1\Base;
use think\Validate;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/4
 * Time: 11:35
 */
class  Goods extends  Base{

    public  function add(){
        $this->isLogin();
        return view();
    }
    public function save(){
        $this->isLogin();
        $img = uploadImageOne('img');
        if($img['status']==0){
            $img = $img['message'];
        }else{
            $this->error($img['message']);
        }
        $data=\request()->post();
        /*将数据保存到数据库
         * */
        $data['img']=$img;
        $rule=[
            'name'=>'require',
            'img'=>'require',
            'weight'=>'require',
            'price'=>'require',
            'whe_price'=>'require',
            'batch_price'=>'require',
            'gen_price'=>'require',
            'flavor'=>'require'
        ];
        $msg=[
            'name.require'=>'产品名称必须填写',
            'img.require'=>'产品图片必须填写',
            'weight.require'=>'产品重量必须填写',
            'price.require'=>'产品零售价格必须填写',
            'whe_price.require'=>'产品批发价格必须填写',
            'batch_price.require'=>'产品混批价格必须填写',
            'gen_price.require'=>'产品总代价格必须填写',
            'flavor.require'=>'产品口味必须填写'
        ];
        $data=[
            'name'=>$data['name'],
            'img'=>$data['img'],
            'weight'=>$data['weight'],
            'price'=>$data['price'],
            'whe_price'=>$data['whe_price'],
            'batch_price'=>$data['batch_price'],
            'gen_price'=>$data['gen_price'],
            'flavor'=>$data['flavor']
        ];
        $validate=Validate::make($rule,$msg);
        $result=$validate->check($data,$rule);
        if(!$result){
            return $this->error($validate->getError());
        }
        $model=new GoodsModel;
        $re=$model->save($data);
        if($re){
            return $this->success('添加产品成功','/admin/v1/goods/lister');
        }else{
            return $this->error('添加产品失败','/admin/v1/goods/add');
        }
        return view();
    }


    /**
    * 商品列表
    */
    public  function lister (){
        $this->isLogin();
        $goods=GoodsModel::paginate(10);
        $count = GoodsModel::count();
        // dump($count);exit;
        $page=$goods->render();
        $this->assign('goods',$goods);
        $this->assign('page',$page);
        $this->assign('count',$count);
        return view();
    }


    public function edit(){
        $this->isLogin();
        /*编辑数据信息
         * */
        $id=\request()->get('id');
        $goods=GoodsModel::where('id',$id)->find();
//           dump($goods);exit;
        $this->assign('goods',$goods);
        return view();
    }


    public function update (){
        $this->isLogin();
        $id=\request()->get('id');
        $data=\request()->post();
//           dump($id);exit;
        $img = uploadImageOne('img');
        if($img['status']==0){
            $img = $img['message'];
        }else{
            $this->error($img['message']);
        }
        $data['img']=$img;
//           dump($data);exit;
        $rule=[
            'name'=>'require',
            'img'=>'require',
            'weight'=>'require',
            'price'=>'require',
            'whe_price'=>'require',
            'batch_price'=>'require',
            'gen_price'=>'require',
            'flavor'=>'require'
        ];
        $msg=[
            'name.require'=>'产品名称必须填写',
            'img.require'=>'产品图片必须填写',
            'weight.require'=>'产品重量必须填写',
            'price.require'=>'产品零售价格必须填写',
            'whe_price.require'=>'产品批发价格必须填写',
            'batch_price.require'=>'产品混批价格必须填写',
            'gen_price.require'=>'产品总代价格必须填写',
            'flavor.require'=>'产品口味必须填写'
        ];
        $data=[
            'name'=>$data['name'],
            'img'=>$data['img'],
            'weight'=>$data['weight'],
            'price'=>$data['price'],
            'whe_price'=>$data['whe_price'],
            'batch_price'=>$data['batch_price'],
            'gen_price'=>$data['gen_price'],
            'flavor'=>$data['flavor']
        ];
        $validate=Validate::make($rule,$msg);
        $result=$validate->check($data,$rule);
        if(!$result){
            return $this->error($validate->getError());
        }
        $model=new  GoodsModel;
        $re=$model->save($data,compact('id'));
        if($re){
            return $this->success('修改成功','/admin/v1/goods/lister');
        }else{
            return $this->error('修改失败','/admin/v1/goods/lister');
        }
        return view();
    }


    /*导出商品列表
     * */
    public  function excel(){
        $goods= \app\Models\Goods::all();
        foreach ($goods as $v){
            $v['name'] = $v['name'];
            $v['weight']=$v['weight'];
            $v['price']=$v['price'];
            $v['whe_price']=$v['whe_price'];
            $v['batch_price']=$v['batch_price'];
            $v['gen_price']=$v['gen_price'];
            $v['flavor']=$v['flavor'];
        }
        /* @实例化 */
        $excel = new \PHPExcel();

        $letter = array('A','B','C','D','E','F','G');
        //表头数组
        $tableheader = array('产品名称','产品净重(g)','零售价格(元)','批发价格(元)','混批价格','总代价格','口味');
        //填充表头信息
        for($i = 0;$i < count($tableheader);$i++) {
            $excel->getActiveSheet()->setTitle('商品列表')->setCellValue("$letter[$i]1","$tableheader[$i]");
        }
        foreach ($goods as $k=>$v){
            $arr[$k]['a']=$v['name'];
            $arr[$k]['b']=$v['weight'];
            $arr[$k]['c']=$v['price'];
            $arr[$k]['d']=$v['whe_price'];
            $arr[$k]['e']=$v['batch_price'];
            $arr[$k]['f']=$v['gen_price'];
            $arr[$k]['g']=$v['flavor'];
        }
        $arr=count($arr);
//      dump($arr);exit;
        //填充表格信息
        if ($arr) {
            for ($i = 2;$i <= count($arr) + 1;$i++) {
                $j = 0;
                foreach ($arr[$i-2] as $key=>$value){
                    $excel->getActiveSheet()->setCellValue("$letter[$j]$i","$value");
                    $j++;
                }
            }
        }
        $obwrite = \PHPExcel_IOFactory::createWriter($excel, 'Excel5');
//ob_end_clean();
//保存文件
//          $obwrite->save('mulit_sheet.xls');
        ob_end_clean();
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Content-Type:application/force-download');
        header('Content-Type:application/vnd.ms-execl');
        header('Content-Type:application/octet-stream');
        header('Content-Type:application/download');
        header("Content-Disposition:attachment;filename='商品列表.xls'");
        header('Content-Transfer-Encoding:binary');
        $obwrite->save('php://output');
        return view();
    }


    /**
     * 商品下架（删除商品）
     */
    public function lower(){
        $this->isLogin();
        $id=\request()->get('id');
        $goods = GoodsModel::where('id',$id)->delete();
        if($goods){
            return $this->success('下架产品成功','/admin/v1/goods/lister');
        }else{
            return $this->error('下架产品失败','/admin/v1/goods/lister');
        }
    }
}
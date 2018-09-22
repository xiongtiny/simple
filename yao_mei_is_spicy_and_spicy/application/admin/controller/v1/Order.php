<?php
namespace  app\admin\controller\v1;
use app\admin\controller\v1\Base;
use app\Models\Order as OrderModel;
use  app\Models\OrderGoods ;
use  app\Models\Goods;

/**
 * Created by PhpStorm.
 * User: yeduo
 * Date: 2018/5/14
 * Time: 11:48
 */
class  Order extends Base{
    /*订单列表
     * */
    public function orderlist(){
        $this->isLogin();
        $status=request()->post('status');
        $order_no=request()->post('order_no');
        $arrWhere[]= ['status','in',[2,3,4]];
        if(!empty($status)){
            $arrWhere=array();
            $arrWhere[] = ['status','=',$status];
        }
        if(!empty($order_no)){
            $arrWhere[] = ['order_no','=',$order_no];
        }
        $orders=OrderModel::where($arrWhere)->with('getUser')->order('create_time desc')->paginate('10');
        $count = OrderModel::where($arrWhere)->with('getUser')->count();
//        dump($orders);exit;
        $page=$orders->render();
        $this->assign('page',$page);
        $this->assign('orders',$orders);
        $this->assign('count',$count);
        return view();
    }
         /*订单详情
          * */
      public function OrderOper(){
             $this->isLogin();
             $order_no=request()->get('order_no');
            $orders=OrderModel::where('order_no',$order_no)->with('getPro')->with('getCity')->with('getArea')->with('getUser')->find();
//             dump($orders);exit;
            $goods= OrderGoods::where('order_no',$order_no)->with('getName')->select();
            $this->assign('arr',$goods);
            $this->assign('orders',$orders);
            return view();
      }
      //查看待审核数据
    public function review(){
          $this->isLogin();
        $order_no=\request()->get('order_no');
//        dump($id);die;
       $orderOper=OrderModel::Where('order_no', $order_no)->find();
       $status=$orderOper['status'];
        $orders=OrderModel::with('getPro')->with('getCity')->with('getArea')->with('getUser')->where('order_no', $order_no)->find();
//        dump($orders);exit;
        $goods= OrderGoods::where('order_no', $order_no)->with('getName')->select();
//        dump($goods);exit;
        $this->assign('arr',$goods);
        $this->assign('orders',$orders);
        $this->assign('status',$status);
          return view();
    }
      //审核待审状态的数据
    public function cheked(){
          $this->isLogin();
          $order_no=\request()->get('order_no');
          $status=\request()->post('status');
          if($status == 3){
            $order_red = 2;
          }else{
            $order_red = 3;
          }
          $re = new OrderModel;
          $res = $re->save([
            'status' => $status,'order_red'=>$order_red
          ],['order_no'=>$order_no]);
        if($res){
            return $this->success('修改成功','/admin/v1/order/orderlist');
        }else{
            return $this->error('修改失败','/admin/v1/order/orderlist');
        }
          return view();
    }

    // 取消订单
    public function  updateOrder(){
        $order_no=request()->get('order_no');
        $goods=OrderGoods::where('order_no',$order_no)->with('getName')->select();
        $this->assign('goods',$goods);
        return view();
    }
     public  function over(){
          $order_no=request()->get('order_no');
//          dump($order_no);exit;
          $model=new  OrderModel;
          $re=$model->save(['status'=>4,'order_red'=>3],['order_no'=>$order_no]);
          if($re){
                return $this->success('驳回成功');
          }else{
              return $this->error('驳回失败');
          }
          return view();
     }
     /*批量审核
      * */
     public function saveAll(){
          $order_nos=request()->post('order_no/a');
          $order = OrderModel::whereIn('order_no',$order_nos)->update(['status'=>3,'update_time'=>date('Y-m-d H:i:s',time() )]);
          if($order>0){
                 ajax_success(200,'审核成功');
          }else{
               ajax_error(400,'审核失败');
          }
     }
}

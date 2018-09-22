<?php
namespace  app\admin\controller\v1;
use app\admin\controller\v1\Base;
use app\Models\Order as OrderModel;
use  app\Models\OrderGoods ;

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
        $time=request()->post('time');
    dump($time);exit;
        $arrWhere = '';
        if(!empty($status)){
            $arrWhere[] = ['status','=',$status];
            $orders=OrderModel::where($arrWhere)->with('getUser')->paginate('5');
        }else{
             $orders=OrderModel::whereIn('status','2,3,4')->with('getUser')->paginate('5');
        }
        $page=$orders->render();
        $this->assign('page',$page);
        $this->assign('orders',$orders);

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
          $re = new OrderModel;
          $res = $re->save([
            'status' => $status
          ],['order_no'=>$order_no]);
        if($res){
            return $this->success('修改成功','/admin/v1/order/orderlist');
        }else{
            return $this->error('修改失败','/admin/v1/order/orderlist');
        }
          return view();
    }
}

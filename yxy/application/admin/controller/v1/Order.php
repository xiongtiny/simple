<?php
/**
 * Created by PhpStorm.
 * User: weilang
 * Date: 2018/4/12
 * Time: 15:00
 */

namespace app\admin\controller\v1;
use Request;
use app\model\Order as OrderModel;
use app\model\User;
use app\model\Course as CourseModel;
use app\model\Grade as GradeModel;
use app\model\Admin as AdminModel;
use app\model\Subject as SubjectModel;
use app\model\Season as SeasonModel;
use app\model\Charging as ChargingModel;
use app\model\Role as RoleModel;
use app\model\ClassHour;
class Order extends BaseController{


    /**
     *  订单--订单列表
     * @return string
     */
    public function index(){
        $this->method();
        $this->auth();
        $order_no=request()->get('order_no');
        $name=request()->get('name');
        $type=request()->get('type');
        $user_data = User::all();
        if(!empty($order_no)){

            $wheres[]=['order_no','like','%'.$order_no.'%'];
        }

        if(!empty($name)){
            $wheres[]=['user_name','eq',$name];
        }

        if(is_numeric($type)){
            $wheres[]=['status','eq',$type];
        }

        if(empty($wheres)){
                $list = OrderModel::order('id','desc')->paginate(10);
        }else{
             $list = OrderModel::order('id','desc')->where($wheres)->paginate(10);
        }


    	
        foreach ($list as $key => $value) {
            if(empty($value->course_id)){
                $course = ClassHour::where(['id'=>$value['class_hour_id']])->find();
            }else{
                $course = CourseModel::where(['id'=>$value['course_id']])->find();

            }
            $list[$key]['course'] = $course['name'];
            // $list[$key]['price'] = $course['price']-$value['reduce_price'];
            $list[$key]['activity_price'] = $course['activity_price'];
            $list[$key]['start_time'] = $course['start_time'];
        }
		// 获取分页显示
		$page = $list->render();
		// 模板变量赋值
		$this->assign('list', $list);
		$this->assign('page', $page);
        $this->assign('user_data', $user_data);
		// 渲染模板输出
		return $this->fetch();

    }


    /**
     *  订单--编辑
     * @return string
     */
    public function edit_order(){
        $this->auth();
        $data_post           = Request::post();
        if($data_post){
            $order = OrderModel::get($data_post['id']);
            $data_post['price'] = $data_post['price_old'] - $data_post['reduce_price'];
            $order-> save($data_post);
            if($order){
                 ajax_success($order,'修改成功');
            }else{
                ajax_error($order,'修改失败');
            }
        }else{
            $data_get = $_GET;
            $order = new OrderModel;
            $data = $order->where(['id'=>$data_get['id']])->find();
            $user_data = User::get($data['user_id']);
            $this->assign('data', $data);
            $this->assign('data_get', $data_get);
            $this->assign('user_data', $user_data);
            return $this->fetch();
        }    
    }


    /**
     *  订单--退款
     * @return string
     */
    public function order_refund(){
        $this->method();
        $this->auth();
        $id  = request()->get('id');
        if(!empty($id)){
            $order = OrderModel::get($id);
            $order->status     = 3;
            $order->update_time= date('Y-m-d H:i:s',time());
            if($order->save()){
                //写入退款表退款
                $refund = request()->post();
                if($refund){
                    
                }
            }
            
        }
        // 渲染模板输出
        return $this->fetch();
    }


        /**
     *  订单--编辑
     * @return string
     */
    public function order_list(){
        $this->auth();
        $id = $_GET['id'];
        $data = OrderModel::where(['user_id'=>$id])->select();
        foreach ($data as $key => $value) {
            $course = CourseModel::where(['id'=>$value['course_id']])->find();
            $data[$key]['course'] = $course['name'];
            $data[$key]['mode'] = $course['mode'];
            $data[$key]['type'] = $course['type'];
            $data[$key]['price'] = $course['price']-$value['reduce_price'];
            $data[$key]['reduce_price'] = $course['activity_price'] + $value['reduce_price'];
        }
        $user_data = User::get($id);
        $this->assign('data',$data);
        $this->assign('user_data',$user_data);
        $this->assign('id',$id);
        return $this->fetch();     
    }


    /**
     *  订单--详情
     * @return string
     */
    public function order_content(){
        $this->method();
        $this->auth();
        $id  = request()->get('id');
        $order = OrderModel::get($id);
        $course = CourseModel::get($order['course_id']);

        if(is_null($order->course_id)){
            $course = ClassHour::get($order['class_hour_id']);
        }

        $user_data = User::get($order['user_id']);
        // 渲染模板输出
        $this->assign('order',$order);

        $this->assign('course',$course);
        $this->assign('user_data',$user_data);
        return $this->fetch();
    }


    /**
     *  订单--退款页面
     * @return string
     */
    public function order_refund_content(){
        $this->method();
        $this->auth();
        $id  = request()->get('id');
        $order = OrderModel::get($id);
        $course = CourseModel::get($order['course_id']);
        $user_data = User::get($order['user_id']);
        // 渲染模板输出
        $this->assign('order',$order);
        $this->assign('course',$course);
        $this->assign('user_data',$user_data);
        return $this->fetch();
    }



    /**
     *  订单--退款
     * @return string
     */
    public function course_content(){
        $this->method();
        $this->auth();
        $id  = request()->get('id');
        $order=OrderModel::get($id);

//        $grades=GradeModel::order('listor','asc')->select();
//        $seasons=SeasonModel::order('listor','asc')->select();
//        $charging=ChargingModel::order('listor','asc')->select();
//        $subjects=SubjectModel::order('listor','asc')->select();
        return view('',compact('order'));
    }

}
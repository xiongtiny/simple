<?php

namespace app\admin\controller\v1;

use app\admin\controller\v1\Base;
use app\index\controller\v1\Team;
use app\Models\OrderGoods;
use  app\Models\User as UserModel;
use  app\Models\Goods;
use  app\Models\Special;
use think\Validate;

class  User extends Base
{
    /*用户列表
     * */
    public function userList()
    {
        $this->isLogin();
        $name = request()->post('name');
        $arrWhere = '';
        if (!empty($name)) {
            $arrWhere[] = ['name', '=', $name];
        }
        $users = UserModel::where($arrWhere)->with('getPro')->with('getCity')->with('getArea')->with('getRecName')->with('getGenName')->paginate('5');
        // dump($users);exit;
        $this->assign('users', $users);
        return view();
    }

    /*添加特价商品
     * */
    public function addSpecial()
    {
        $this->isLogin();
        $id = request()->get('id');
        $goods = Goods::all();
//         dump($goods);exit;
        $this->assign('id', $id);
        $this->assign('goods', $goods);
        return view();
    }

    public function specialSave()
    {
        $this->isLogin();
        $id = request()->get('id');
        $data = request()->post();
//       dump($data);exit;
        $rule = [
            'goods_id' => 'require',
            'price' => 'require'
        ];
        $msg = [
            'goods_id.require' => '名称必须填写',
            'price.require' => '价格必须填写'
        ];
        $data = [
            'goods_id' => $data['goods_id'],
            'price' => $data['price'],

        ];
        $validate = Validate::make($rule, $msg);
        $result = $validate->check($data, $rule);
        if (!$result) {
            return $this->error($validate->getError());
        }
        $model = new  Special;
        $re = $model->save(['user_id' => $id, 'goods_id' => $data['goods_id'], 'price' => $data['price']]);
//        dump($re);exit;
        if ($re) {
            return $this->success('添加成功', '/admin/v1/user/addSpecial');
        } else {
            return $this->error('添加失败', '/admin/v1/user/addSpecial');
        }
        return view();
    }

    //特价商品列表
    public function specialList()
    {
        $this->isLogin();
        $id = input('get.id');
//       dump($id);exit;
        //获取商品名
        $model = new Special;
        $specials = $model->where('user_id', $id)->with('getName')->with('getGoods')->paginate(2, false, ['query' => request()->param()]);;
//     dump($specials);exit;
        $this->assign('specials', $specials);
        return view();
    }

    //编辑特价商品
    public function editSpecial()
    {
        $this->isLogin();
        $id = request()->get('id');
        $specials = Special::where('id', $id)->with('getName')->with('getGoods')->find();
//      dump($specials);exit;
        $this->assign('specials', $specials);
        return view();
    }

    //保存修改的特价商品
    public function saveSpecial()
    {
        $this->isLogin();
        $id = request()->get('id');
//           dump($id);exit;
        $price = request()->post('price');
//            dump($data);exit;
        $model = new Special;
        $re = $model->where('id', $id)->update(['price' => $price]);
//             dump($re);exit;
        if ($re) {
            return $this->success('修改成功', '/admin/v1/user/specialList');
        } else {
            return $this->error('修改失败', '/admin/v1/user/specialList');
        }
        return view();
    }

    /*所属下级代理列表
     * */
    public function lowerRank()
    {
        $this->isLogin();
        $id = request()->get('id');
//           dump($id);exit;
        $lowerUsers = UserModel::where('rec_id', $id)->paginate('10');
//        dump($lowerUsers);exit;
        $this->assign('lowerUsers', $lowerUsers);
        return view();
    }
//      public  function delSpecial(){
//           $id=request()->get('id');
//           $special=Special::where('goods_id',$id)->find();
//           $re=$special->delete();
//           if($re){
//               return $this->success('删除成功','/admin/v1/user/specialList');
//           }else{
//               return $this->error('删除失败','/admin/v1/user/specialList');
//           }
//             return view();
//      }

    /*
     *
     * 导出数据列表
     * */
    public function excel()
    {
        $user = \app\Models\User::all();
//         dump($user);exit;
        foreach ($user as $v) {
            $v['name'] = $v['name'];
            $v['rec_name'] = \app\Models\User::where('id', $v['rec_id'])->value('name');
        }
        /* @实例化 */
        $excel = new \PHPExcel();

        $letter = array('A', 'B');
        //表头数组
        $tableheader = array('姓名', '推荐人');
        //填充表头信息
        for ($i = 0; $i < count($tableheader); $i++) {
            $excel->getActiveSheet()->setTitle('代理关系')->setCellValue("$letter[$i]1", "$tableheader[$i]");
        }
        $user = \app\Models\User::all();
        foreach ($user as $v) {
            $v['name'] = $v['name'];
            $v['rec_name'] = \app\Models\User::where('id', $v['rec_id'])->value('name');
        }
        foreach ($user as $k => $v) {
            $arr[$k]['a'] = $v['name'];
            $arr[$k]['b'] = $v['rec_name'];
        }
        //填充表格信息
        if ($arr) {
            for ($i = 2; $i <= count($arr) + 1; $i++) {
                $j = 0;
                foreach ($arr[$i - 2] as $key => $value) {
                    $excel->getActiveSheet()->setCellValue("$letter[$j]$i", "$value");
                    $j++;
                }
            }
        }

        //创建一个新的工作空间(sheet)
        $excel->createSheet();
        $excel->setactivesheetindex(1);


        //写入多行数据
        $letter = array('A', 'B', 'C');
        //表头数组
        $tableheader = array('姓名', '提成', '推荐人');
        //填充表头信息

        for ($i = 0; $i < count($tableheader); $i++) {
            $excel->getActiveSheet()->setTitle('返利明细')->setCellValue("$letter[$i]1", "$tableheader[$i]");
        }

        $user_id = \app\Models\Order::where('status', 3)->column('user_id');

        $users = \app\Models\User::whereIn('id', $user_id)->order('rec_id')->select();

        foreach ($users as $v) {
            $v->rec_rebate = $v->getOrder()->sum('rec_rebate');
            $v->rec_id = \app\Models\User::where('id', $v->rec_id)->value('name');
        }

        foreach ($users as $k => $v) {
            $arr1[$k]['a'] = $v['name'];
            $arr1[$k]['b'] = $v['rec_rebate'];
            $arr1[$k]['c'] = $v['rec_id'];
        }
        //填充表格信息
        if ($arr1) {
            for ($i = 2; $i <= count($arr1) + 1; $i++) {
                $j = 0;
                foreach ($arr1[$i - 2] as $key => $value) {
                    $excel->getActiveSheet()->setCellValue("$letter[$j]$i", "$value");
                    $j++;
                }
            }
        }

        //创建一个新的工作空间(sheet)
        $excel->createSheet();
        $excel->setactivesheetindex(2);

        //写入多行数据
        $letter = array('A', 'B', 'C');
        //表头数组
        $tableheader = array('姓名', '月返利总额', '结算明细');
        //填充表头信息
        for ($i = 0; $i < count($tableheader); $i++) {
            $excel->getActiveSheet()->setTitle('返利总和')->setCellValue("$letter[$i]1", "$tableheader[$i]");
        }
        $user_data = \app\Models\User::all();
        foreach ($user_data as $v) {
            $v['lower_level'] = \app\Models\User::where('rec_id', $v['id'])->column('id');
        }
        foreach ($user_data as $k => $v) {
            if (!empty($v['lower_level'])) {
                $v['price'] = \app\Models\Order::where('status', 3)->whereIn('user_id', $v['lower_level'])->sum('rec_rebate');
            } else {
                unset($user_data[$k]);
            }
        }
        $arr2 = [];
        foreach ($user_data as $k => $v) {
            $arr2[$k]['a'] = $v['name'];
            $arr2[$k]['b'] = $v['price'];
            $arr2[$k]['c'] = '';
        }

        //填充表格信息
        if ($arr2) {
            for ($i = 2; $i <= count($arr2) + 1; $i++) {
                $j = 0;
                foreach ($arr2[$i - 2] as $key => $value) {
                    $excel->getActiveSheet()->setCellValue("$letter[$j]$i", "$value");
                    $j++;
                }
            }
        }
        $obwrite = \PHPExcel_IOFactory::createWriter($excel, 'Excel5');
        ob_end_clean();
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Content-Type:application/force-download');
        header('Content-Type:application/vnd.ms-execl');
        header('Content-Type:application/octet-stream');
        header('Content-Type:application/download');
        header("Content-Disposition:attachment;filename='月返利排行表.xls'");
        header('Content-Transfer-Encoding:binary');
        $obwrite->save('php://output');

    }

    //下单接单--代理关系
    public function excel2()
    {
        /* @实例化 */
        $excel = new \PHPExcel();
        $letter = array('A', 'B');
        //表头数组
        $tableheader = array('姓名', '推荐人');
        //填充表头信息
        for ($i = 0; $i < count($tableheader); $i++) {
            $excel->getActiveSheet()->setTitle('代理关系')->setCellValue("$letter[$i]1", "$tableheader[$i]");
        }
        $user = \app\Models\User::all();
        foreach ($user as $v) {
            $v['name'] = $v['name'];
            $v['rec_name'] = \app\Models\User::where('id', $v['rec_id'])->value('name');
        }
        foreach ($user as $k => $v) {
            $arr[$k]['a'] = $v['name'];
            $arr[$k]['b'] = $v['rec_name'];
        }
        //填充表格信息
        if ($arr) {
            for ($i = 2; $i <= count($arr) + 1; $i++) {
                $j = 0;
                foreach ($arr[$i - 2] as $key => $value) {
                    $excel->getActiveSheet()->setCellValue("$letter[$j]$i", "$value");
                    $j++;
                }
            }
        }

        //创建一个新的工作空间(sheet)
        $excel->createSheet();
        $excel->setactivesheetindex(1);
//写入多行数据
        $letter = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
            'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
            'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM',
            'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');
        //表头数组
        $tableheader = array('订单号', '下单日期', '下单人', '介绍人', '结算', '订单信息', '豆干', '毛豆', '鱿鱼', '鸭掌', '凤爪', '鱼仔', '鸡尖', '鱼尾', '手撕鱼', '鱼排', '鱼嘴', '鸭脖', '田螺', '猪脆骨', '泥鳅', '猪耳', '牛板筋', '牛蹄筋', '牙签牛肉', '片牛肉', '板鸭', '鸭舌', '腐乳', '掌中宝', '魔芋', '藕片', '臭干子', '包数', '邮费', '收代理', '总利', '返利', '重量KG');
        $tableheader1 = array('', '', '', '', '', '混批', '7', '7', '11', '11', '11', '11', '11', '12', '12', '13', '13', '13', '13', '13', '13', '14', '16', '17', '19', '21', '41', '27', '7', '19', '7', '8', '8');
        $tableheader2 = array('', '', '', '', '', '一级', '8', '8', '12', '12', '12', '12', '12', '13', '13', '14', '14', '14', '14', '14', '14', '15', '17', '18', '20', '22', '43', '29', '8', '20', '8', '9', '9');
        $tableheader3 = array('', '', '', '', '', '总代', '6', '6', '10', '10', '10', '10', '10', '11', '11', '12', '12', '12', '12', '12', '12', '13', '15', '16', '18', '20', '37', '26', '6', '18', '6', '7', '7');

        for ($i = 0; $i < count($tableheader1); $i++) {
            $excel->getActiveSheet()->setTitle('返利明细')->setCellValue("$letter[$i]1", "$tableheader1[$i]");
            $excel->getActiveSheet()->getStyle("$letter[$i]1")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);//设置列宽度
        }
        for ($i = 0; $i < count($tableheader2); $i++) {
            $excel->getActiveSheet()->setCellValue("$letter[$i]2", "$tableheader2[$i]");
            $excel->getActiveSheet()->getStyle("$letter[$i]2")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
        for ($i = 0; $i < count($tableheader3); $i++) {
            $excel->getActiveSheet()->setCellValue("$letter[$i]3", "$tableheader3[$i]");
            $excel->getActiveSheet()->getStyle("$letter[$i]3")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
        for ($i = 0; $i < count($tableheader); $i++) {
            $excel->getActiveSheet()->setCellValue("$letter[$i]4", "$tableheader[$i]");
        }
        //查询数据
        $order_data = \app\Models\Order::where('status', 3)->with('getGoods')->select();
        foreach ($order_data as $k => $v) {
            foreach ($v['get_goods'] as $v1) {

            }
        }
//        foreach ($users as $k=>$v){
//            $arr1[$k]['a']=$v['name'];
//            $arr1[$k]['b']=$v['rec_rebate'];
//            $arr1[$k]['c']=$v['rec_id'];
//        }
//        //填充表格信息
//        if ($arr1) {
//            for ($i = 2;$i <= count($arr1) + 1;$i++) {
//                $j = 0;
//                foreach ($arr1[$i-2] as $key=>$value) {
//                    $excel->getActiveSheet()->setCellValue("$letter[$j]$i","$value");
//                    $j++;
//                }
//            }
//        }
        $obwrite = \PHPExcel_IOFactory::createWriter($excel, 'Excel5');
        ob_end_clean();
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Content-Type:application/force-download');
        header('Content-Type:application/vnd.ms-execl');
        header('Content-Type:application/octet-stream');
        header('Content-Type:application/download');
        header("Content-Disposition:attachment;filename='下单接单.xls'");
        header('Content-Transfer-Encoding:binary');
        $obwrite->save('php://output');

    }
}
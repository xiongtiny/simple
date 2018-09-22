
function check()
{   
if($('#name').val()=="")
{
	alert("请填写农场名称");
	return false;
}
if($('#province1').val()=="")
{
	alert("请填写所在城市");
	return false;
}
if($('#city1').val()=="")
{
	alert("请填写所在城市");
	return false;
}
if($('#district1').val()=="")
{
	alert("请填写所在城市");
	return false;
}
if($('#address').val()=="")
{
	alert("请填写详细地址");
	return false;
}
if($('#phone').val()=="")
{
	alert("请填写电话");
	return false;
}
if($('#number').val()=="")
{
	alert("请填写设备编号");
	return false;
}
if($('#area').val()=="")
{
	alert("请填写农场面积");
	return false;
}
if($('#price').val()=="")
{
	alert("请填写价格");
	return false;
}
 // var val=$('input:radio[name="protocol"]:checked').val();
 //            if(val==null){
 //                alert("请阅读相关协议");
 //                return false;
 //            }
 //            
var aaa = $("#protocol").prop("checked");
if(!aaa){
    alert("请阅读相关协议");
    return false;
 };
}
	function user_name()
	{
		console.log(data);
		window.location.href='/index.php/api/v1/user/user_edit1';
	}
	function user_edit()
	{
		console.log(data);
		window.location.href='/index.php/api/v1/user/user_edit1';
	}
	function user_lease1()
	{
		console.log(data);
		window.location.href='/index.php/api/v1/user/user_lease1';
	}
	function user_release1()
	{
		console.log(data);
		window.location.href='/index.php/api/v1/user/user_release1';
	}
	function feedback1()
	{
		console.log(data);
		window.location.href='/index.php/api/v1/user/feedback1';
	}
	function transaction_record1()
	{
		console.log(data);
		window.location.href='/index.php/api/v1/user/transaction_record1';
	}
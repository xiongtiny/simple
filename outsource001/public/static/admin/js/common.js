$(document).ready(function(){//刷新页面关闭所有dialog窗口
    var dialog_data = $("body").data();//当前打开dialog信息
    $.each(dialog_data, function(i, n){
        $.pdialog.close(i);
    });

    //输入框修改操作
    $('._edit_td').on('click',function(){
        var _self       = $(this);
        var _input_val  =  _self.find('input').val();

        _self.find('font').text('');
        _self.find('input').show();
        _self.find('input').val('').focus().val(_input_val);

        _self.find('input').on('blur',function(){
            var _self1      = $(this);
            //当前数值
            var _old_val    = _self1.attr('data-value');
            var _val        = _self1.val();

            if(_old_val == _val){
                _self1.siblings('font').text(_val);
                _self1.hide();
                return false;
            }
            var _action = _self1.attr('data-action') ? _self1.attr('data-action') : null;

            if(_action){
                alertMsg.confirm("您修改的资料未保存！", {
                    okCall: function(){
                        //获取表单地址 便于统一提交操作
                        var ajax_url = "http://"+document.domain + "/" +  _action + '&value=' + _val;
                        //插入指定input输入框 data-sort=xx 当前排序值（提交时比对）
                        $.getJSON(ajax_url, { _t: (new Date()).valueOf() }, function(json){
                            if(json.statusCode == 200){
                                _self1.siblings('font').text(_val);
                                _self1.hide();
                                _self1.attr('data-value', _val);
                                alertMsg.correct(json.message);
                            }else{
                                _self1.siblings('font').text(_old_val);
                                _self1.hide();
                                alertMsg.error(json.message);
                            }
                        });
                    },
                    cancelCall: function(){
                        _self1.siblings('font').text(_old_val);
                        _self1.hide();
                    }
                });
            }
        });
    });

    //点击链接修改
    $('._edit_td_change font[data-tips]').on('click',function(){
        var _self       = $(this).parents('td._edit_td_change');
        var _value      = _self.attr('data-value');

        var _action     = _self.attr('data-action') ? _self.attr('data-action') : null;

        var _tips_txt   = _self.find('[data-tips]').text();

        var _remove_edit = _self.attr('data-remove-edit');

        if(_action){
            alertMsg.confirm("您确定要"+_tips_txt+"吗？", {
                okCall: function(){
                    //获取表单地址 便于统一提交操作
                    var ajax_url = "http://"+document.domain + "/" + _action + '&value=' + _value;
                    $.getJSON(ajax_url, {_t: (new Date()).valueOf() }, function(json){
                        if(json.statusCode == 200){
                            var _values = _self.attr('data-value-arr');
                            var _value_arr = _values.split('|');
                            $.each( _value_arr, function(i, n){
                                var _n_arr = n.split('#');

                                if(_n_arr[0] == _value){
                                    _self.attr('data-value',_n_arr[1]);
                                    _self.html(json.data['html']);
                                    _self.css("color",_n_arr[3]);
                                }
                            });

                            if(_remove_edit == 1){
                                _self.removeClass('_edit_td_change');
                            }
                            alertMsg.correct(json.message);
                        }else{
                            alertMsg.error(json.message);
                        }
                    });
                }
            });
        }
    });

    //下拉框动态修改
    $('._select_td_change').on('change', function(){
        var _self   = $(this);
        var _action = _self.attr('data-action');
        var _val    = _self.val();

        var _tips_txt   = _self.find("option:selected").text();

        if(_action){
            alertMsg.confirm("您确定要"+_tips_txt+"吗？", {
                okCall: function(){
                    //获取表单地址 便于统一提交操作
                    var ajax_url = "http://"+document.domain + "/" + _action + '&value=' + _val;
                    $.getJSON(ajax_url, {_t: (new Date()).valueOf() }, function(json){
                        if(json.statusCode == 200){
                            alertMsg.correct(json.message);
                        }else{
                            alertMsg.error(json.message);
                        }
                    });
                }
            });
        }
    });


    $('._confirm_close_dialog').on('click', function(){
        alertMsg.confirm("确定要关闭当前弹窗吗？", {
            okCall: function(){
                $.pdialog.closeCurrent();
            }
        });
    });

    $('._close_dialog_reload').on('click', function(){

    });
});
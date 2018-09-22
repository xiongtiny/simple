/**
 * 获取表单json数组
 *
 * @param form
 * @returns {{}}
 */
function obj2json(form_obj){
    var o = {};

    $.each(form_obj, function () {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
}

/**
 * 字符串转数组
 *
 * @param str
 * @returns {Array}
 */
function str2arr(str, is_int) {
    var arr = [];

    if(typeof str == 'string'){
        var str_arr = str.split(',');

        for(var i in str_arr){
            arr.push((is_int ? parseInt(str_arr[i]) : str_arr[i]));
        }
    }

    return arr;
}

/**
 * json to string
 *
 * @param o
 * @returns {*}
 */
function obj2str(o) {
    var r = [];
    if(typeof o =="string") return "\""+o.replace(/([\'\"\\])/g,"\\$1").replace(/(\n)/g,"\\n").replace(/(\r)/g,"\\r").replace(/(\t)/g,"\\t")+"\"";
    if(typeof o == "object"){
        if(!o.sort){
            for(var i in o)
                r.push(i+":"+$.xy.obj2str(o[i]));
            if(!!document.all && !/^\n?function\s*toString\(\)\s*\{\n?\s*\[native code\]\n?\s*\}\n?\s*$/.test(o.toString)){
                r.push("toString:"+o.toString.toString());
            }
            r="{"+r.join()+"}"
        }else{
            for(var i =0;i<o.length;i++) {
                r.push($.xy.obj2str(o[i]));
            }
            r="["+r.join()+"]"
        }
        return r;
    }
    return o.toString();
}

/**
 * json 字符串转换
 *
 * @param data
 * @returns {*}
 */
function jsonEval(data) {
    try{
        if ($.type(data) == 'string'){
            return eval('(' + data + ')');
        }else{
            return data;
        }
    } catch (e){
        $.xy.debug('上传配置信息错误');
        return {};
    }
}

function getNowFormatDate() {
    var date = new Date();
    var seperator1 = "-";
    var seperator2 = ":";
    var month = date.getMonth() + 1;
    var strDate = date.getDate();
    if (month >= 1 && month <= 9) {
        month = "0" + month;
    }
    if (strDate >= 0 && strDate <= 9) {
        strDate = "0" + strDate;
    }

    var hours   = date.getHours();

    if (hours >= 0 && hours <= 9) {
        hours = "0" + hours;
    }

    var minutes = date.getMinutes();

    if (minutes >= 0 && minutes <= 9) {
        minutes = "0" + minutes;
    }

    var seconds = date.getSeconds();

    if (seconds >= 0 && seconds <= 9) {
        seconds = "0" + seconds;
    }
    var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate
        + " " + hours + seperator2 + minutes
        + seperator2 + seconds;
    return currentdate;
}

/**
 * http://www.uploadify.com/documentation/uploadify/onqueuecomplete/
 */
function uploadifyMyQueueComplete(queueData){

    var msg = "The total number of files uploaded: "+queueData.uploadsSuccessful+"<br/>"
        + "The total number of errors while uploading: "+queueData.uploadsErrored+"<br/>"
        + "The total number of bytes uploaded: "+queueData.queueBytesUploaded+"<br/>"
        + "The average speed of all uploaded files: "+queueData.averageSpeed;

    if (queueData.uploadsErrored) {
        console.log(msg);
    } else {
        console.log(msg);
    }
}
/**
 * http://www.uploadify.com/documentation/uploadify/onuploadsuccess/
 */
function uploadifyMySuccess(file, json, response){
    json    = eval("("+json+")");

    if(json.statusCode == 200){
        var node_id = json['data']['node_id'];
        var url     = json['data']['url'];
        if(node_id){
            $('input[name='+node_id+']').val(url);
            $('._'+node_id).attr('src', url);
        }
    }else{
        alertMsg.warn(json.message);
    }
}

function uploadifyMyError(file, errorCode, errorMsg) {

    alertMsg.warn(errorCode+"#"+errorMsg);
}
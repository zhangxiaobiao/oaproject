/**
 * Created by TTSB on 2016/7/7.
 */
/**
 * Created by TTSB on 2016/7/6.
 */
function createxhr() {
    try {
        return new XMLHttpRequest();
    } catch(e) {
        return new ActiveXObject('Microsoft.XMLHTTP');
    }
}
/**
 *
 * @param method         get/post 请求方式
 * @param url            请求的地址
 * @param content        name=zhangsan&age=10
 * @param responseType   text/json
 * callback
 */
function ajax(method, url, content, responseType, callback) {
    //1.创建对象
    var xhr = createxhr();
    //2.初始化
    if (method == 'get') {
        url = url + '?' + content;
        xhr.open('get', url);
        xhr.send(null);//3.发送请求
    } else {
        xhr.open('post', url);
        xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
        xhr.send(content);//3.发送请求
    }

    //4.对返回数据的处理
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            if (responseType == 'text') {

            } else {
                var obj = JSON.parse(xhr.responseText);
                callback(obj);
            }
        }
    }

}
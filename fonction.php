<?php

include_once("mysql.php");

//邮件发出功能
function sendMail($to,$title,$content){
    require_once("phpmailer/class.phpmailer.php"); 
    require_once("phpmailer/class.smtp.php");
    //Mailer核心类
    $mail = new PHPMailer();

    //是否启用smtp的debug进行调试 
    $mail->SMTPDebug = 1;

    //使用smtp鉴权方式发送邮件
    $mail->isSMTP();

    //smtp需要鉴权 这个必须是true
    $mail->SMTPAuth=true;

    //链接qq域名邮箱的服务器地址
    $mail->Host = 'smtp.gmail.com';

    //设置使用ssl加密方式登录鉴权
    $mail->SMTPSecure = 'ssl';

    //设置ssl连接smtp服务器的远程服务器端口号，以前的默认是25，但是现在新的好像已经不可用了 可选465或587
    $mail->Port = 465;

    //设置smtp的helo消息头 这个可有可无 内容任意
     //$mail->Helo = 'Hello smtp.126.com Server';

    //设置发件人的主机域 可有可无 默认为localhost 内容任意，建议使用你的域名
    $mail->Hostname = 'localhost';

    //设置发送的邮件的编码 可选GB2312 我喜欢utf-8 据说utf8在某些客户端收信下会乱码
    $mail->CharSet = 'UTF-8';

    //设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
    $mail->FromName = 'Mini job';

    //smtp登录的账号 
    $mail->Username ='srd0817@gmail.com';

    //smtp登录的密码 使用生成的授权码（就刚才叫你保存的最新的授权码）
    $mail->Password = 'nsly2022335';

    //设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
    $mail->From = 'srd0817@gmail.com';

    //邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
    $mail->isHTML(true); 

    //设置收件人邮箱地址 该方法有两个参数 第一个参数为收件人邮箱地址 第二参数为给该地址设置的昵称 不同的邮箱系统会自动进行处理变动 这里第二个参数的意义不大
    $mail->addAddress($to,'在线通知');

   

    //添加该邮件的主题
    $mail->Subject = $title;

    //添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
    $mail->Body = $content;

    //为该邮件添加附件 该方法也有两个参数 第一个参数为附件存放的目录（相对目录、或绝对目录均可） 第二参数为在邮件附件中该附件的名称
    // $mail->addAttachment('./d.jpg','mm.jpg');
    //同样该方法可以多次调用 上传多个附件
    // $mail->addAttachment('./Jlib-1.1.0.js','Jlib.js');

    $status = $mail->send();

    //简单的判断与提示信息
    if($status) {
        return true;
    }else{
        return false;
    }
}


//注册判断用户名函数 
function Check_Username($UserName){  
	$Max_UserName=16;
	$Min_UserName=4;	
	if(!preg_match('/^[\w\x80-\xff]{4,16}$/',$UserName))//正则表达式匹配检查 
	{ 	
		echo "用户名字符串检测不正确<br/>"; 
		return false; 
	}
	if (strlen($UserName)<$Min_UserName || strlen($UserName)>$Max_UserName) { 
		echo "用户名字长度检测不正确<br/>";
		return false;
	} 
	return true;
} 

//注册判断密码函数
function Check_Password($Password) { 
	$Max_Password=16;//密码最大长度 
	$Min_Password=4;//密码最短长度 
	if(!preg_match('/^[\w\x80-\xff]{4,16}$/',$Password)) {
		echo "密码字符串检测不正确<br/>"; 
		return false; 
		} 
	if(strlen($Password)<$Min_Password || strlen($Password)>$Max_Password) { 
	    echo "密码长度检测不正确<br/>"; 
		return false; 
		} 	
	return true; 
} 

//注册判断邮箱函数
function Check_Email($email) { 

	if(!preg_match('/^(\w)+(\.\w+)*@(\w)+((\.\w{2,3}){1,3})$/',$email)) { 
		echo "邮箱格式不正确<br/>";
		return false;
	} 
	return true;
} 

//注册判断两次密码
function Check_ConfirmPassword($Password,$ConfirmPassword) { 
	if($Password<>$ConfirmPassword) { 
		echo "两次密码输入不一致<br/>"; 
		return false; 
		} 
	else 
		return true; 
} 

//注册判断用户名，邮箱是否已存在
function Check_Exist($username,$email){
	my_config();
	$query="select * from client where username='$username' or email='$email'";
	$result=mysql_query($query); 
	$row=mysql_fetch_array($result); 
	while ($row) { 
		if ($row["username"]==$username) { 
			echo "用户名已存在<br/>";
			return false;
		} 
		if ($row["email"]==$email) { 
			echo "用户邮箱已经注册<br/>"; 
			return false;
		} 
	} 
	return true;
}


?>
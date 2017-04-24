<?php 
include_once ('mysql.php');
include_once('fonction.php');

$username1=$_POST["username"];
$password1=$_POST["password"];
$confirmpassword=$_POST["confirmPassword"];
$nom=$_POST["nom"];
$prenom=$_POST["prenom"];
$naissance=$_POST["naissance"];
$telephone=$_POST["telephone"];
$email1=$_POST["email"];
$adresse=$_POST["adresse"];
$postal=$_POST["postal"];
$ville=$_POST["ville"];
$pays=$_POST["pays"];
$desciption=$_POST["desciption"];

my_config();

if(Check_Username($username1) && Check_Password($password1) && Check_Email($email1) && Check_ConfirmPassword($password1,$confirmpassword) 
	&& Check_Exist($username1,$email1)){  //写入数据并发送邮件
		$password = md5($_POST['password']); //加密密码
		 
		

		$token = md5($username1.$password); //创建用于激活识别码

		$query="INSERT INTO client (nom,username,password,prenom,telephone,naissance,email,adresse,postal,ville,pays,desciption,niveau,token,status) VALUES 
		('$nom','$username1','$password1','$prenom','$telephone','$naissance','$email1','$adresse','$postal','$ville','$pays','$desciption',0,'$token',0)" ; 

		$result = mysql_query($query);

		if($result){
			echo'信息添加成功';
			if(mysql_insert_id()){   //写入成功，发邮件
				
				$smtpemailto = $email1;
				$emailsubject = "用户帐号激活";
				$emailbody = "亲爱的".$username1."：<br/>感谢您在我站注册了新帐号。<br/>请点击链接激活您的帐号。<br/><a href='http://localhost/active.php?token=".$token."'  target='blank'>
				http://localhost/active.php?token=".$token."</a><br/>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。<br/>如果此次激活请求非你本人所发，请忽略本邮件。<br/><p style='text-align:right'>-------- Mini Job 敬上(宋芮德测试)（那个激活网址你进不去的，别点了，在我本地上。。。。）</p>";
				$rs = sendMail($smtpemailto, $emailsubject, $emailbody);
				if($rs){
					echo '恭喜您，注册成功！<br/>请登录到您的邮箱及时激活您的帐号！';	
				}			
				else{
					echo '发送失败';	
				}
			}				
		} 
		else {
			echo '抱歉！添加数据失败：',mysql_error(),'<br />';
		}
}		
 else{
	 echo 'error:';
	  echo '点击此处 <a href="javascript:history.back(-1)">return </a> 重试';
 }
 ?>


	
	
	
	
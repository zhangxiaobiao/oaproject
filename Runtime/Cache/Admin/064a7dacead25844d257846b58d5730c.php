<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script type="text/javascript" src="/xiaozuxiangmu/Public/Admin/js/jquery.js"></script>
	<script type="text/javascript">
			$(function(){
				$('#ip').on('blur', function(){
					var ip = $(this).val();
					$.ajax({
						url: "<?php echo U('Ip/getIp');?>",
						type: 'post',
						data:'ip='+ip,
						dataType: 'json',
						success: function (data) {
							console.log(data);
							$('#addr').html(data);
						}
					});
				});
			});



	</script>
</head>
<body>
	ip：<input type="text" name="ip" id="ip">
<br>
物理地址：<span id="addr"></span>
</body>
</html>
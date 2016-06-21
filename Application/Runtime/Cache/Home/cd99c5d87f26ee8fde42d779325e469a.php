<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<title>reg模版</title>
		<meta charset="utf-8">
	</head>
	<body>
		reg模版<br/>
		<?php echo ($ttt); ?><br/>
		<?php echo ($arr["0"]); ?>----<?php echo ($arr[1]); ?><br/>
		<?php echo ($arr2["aa"]); ?>----<?php echo ($arr2[bb]); ?><br/>
		<?php echo ($data["0"]["cid"]); ?>--<?php echo ($data[0][name]); ?><br/>
		<?php echo ($menu->menuid); ?>--<?php echo ($menu->name); ?><br/>
		<?php echo ($_SERVER['HTTP_USER_AGENT']); ?><br/>
		<?php echo ($_GET['userName']); ?>--<?php echo ($_GET['userPass']); ?><br/>
		<?php echo ($host); ?><br/>
		<?php echo (md5($str)); ?><br/>
		<?php echo (substr($str,0,3)); ?>---<?php echo (substr($str,0,5)); ?><br/>
		<?php echo substr($str,0,4);?><br/>
		<?php echo ((isset($str) && ($str !== ""))?($str):"中国你好"); ?><br/>
		<?php echo ($i+$j); ?>~~<?php echo ($i-$j); ?>~~<?php echo ($i*$j); ?>~~<?php echo ($i/$j); ?>~~<?php echo ($i%$j); ?>~~<?php echo ($i++); ?>~~<?php echo ++$i;?><br/>
		<?php echo ($i < 4?"哈哈":"呵呵"); ?><br/>
		
		<table border="1" bordercolor="blue" width="100%" cellspacing="0">
			<tr>
				<td>编号</td>
				<td>名称</td>
				<td>类型</td>
				<td>状态</td>
				<td>创建时间</td>
				<td>开班时间</td>
				<td>结业时间</td>
				<td>班主任</td>
				<td>项目经理</td>
				<td>人数</td>
				<td>备注</td>
			</tr> 
				<!-- 第<?php echo ($i); ?>次循环-索引为<?php echo ($key); ?> 
			<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "$msg" ;else: foreach($__LIST__ as $key=>$class): $mod = ($i % 2 );++$i; if(($mod) == "0"): ?><tr style="background-color:gray;">
						<td><?php echo ($class["cid"]); ?></td>
						<td><?php echo ($class["name"]); ?></td>
						<td><?php echo ($class["classtype"]); ?></td>
						<td><?php echo ($class["status"]); ?></td>
						<td><?php echo ($class["createtime"]); ?></td>
						<td><?php echo ($class["begintime"]); ?></td>
						<td><?php echo ($class["endtime"]); ?></td>
						<td><?php echo ($class["headerid"]); ?></td>
						<td><?php echo ($class["managerid"]); ?></td>
						<td><?php echo ($class["stucount"]); ?></td>
						<td><?php echo ($class["remark"]); ?></td>
					</tr><?php endif; ?>
				<?php if(($mod) == "1"): ?><tr style="background-color:orange;">
						<td><?php echo ($class["cid"]); ?></td>
						<td><?php echo ($class["name"]); ?></td>
						<td><?php echo ($class["classtype"]); ?></td>
						<td><?php echo ($class["status"]); ?></td>
						<td><?php echo ($class["createtime"]); ?></td>
						<td><?php echo ($class["begintime"]); ?></td>
						<td><?php echo ($class["endtime"]); ?></td>
						<td><?php echo ($class["headerid"]); ?></td>
						<td><?php echo ($class["managerid"]); ?></td>
						<td><?php echo ($class["stucount"]); ?></td>
						<td><?php echo ($class["remark"]); ?></td>
					</tr><?php endif; endforeach; endif; else: echo "$msg" ;endif; ?>
			-->
			
			<?php if(is_array($data)): foreach($data as $i=>$class): if(($i%2) == "0"): ?><tr style="background-color:green;">
						<td><?php echo ($class["cid"]); ?></td>
						<td><?php echo ($class["name"]); ?></td>
						<td>
							<?php if($class["classtype"] == 1): ?>常规班
							<?php elseif($class["classtype"] == 2): ?>快速班
							<?php elseif($class["classtype"] == 3): ?>falsh班
							<?php else: ?>php班<?php endif; ?>
						</td>
						<td>
							<?php if($class["status"] == 1): ?>正常
							<?php elseif($class["status"] == 2): ?>被合并
							<?php elseif($class["status"] == 3): ?>已结业
							<?php else: ?>已废除<?php endif; ?>
						</td>
						<td><?php echo ($class["createtime"]); ?></td>
						<td><?php echo ($class["begintime"]); ?></td>
						<td><?php echo ($class["endtime"]); ?></td>
						<td><?php echo ($class["headerid"]); ?></td>
						<td><?php echo ($class["managerid"]); ?></td>
						<td><?php echo ($class["stucount"]); ?></td>
						<td><?php echo ($class["remark"]); ?></td>
					</tr><?php endif; ?>
				<?php if(($i%2) == "1"): ?><tr style="background-color:yellow;">
						<td><?php echo ($class["cid"]); ?></td>
						<td><?php echo ($class["name"]); ?></td>
						<td>
							<?php if($class["classtype"] == 1): ?>常规班
							<?php elseif($class["classtype"] == 2): ?>快速班
							<?php elseif($class["classtype"] == 3): ?>falsh班
							<?php else: ?>php班<?php endif; ?>
						</td>
						<td>
							<?php if($class["status"] == 1): ?>正常
							<?php elseif($class["status"] == 2): ?>被合并
							<?php elseif($class["status"] == 3): ?>已结业
							<?php else: ?>已废除<?php endif; ?>
							<!-- <?php if(($class["status"]) == "1"): ?>正常<?php endif; ?>
							<?php if(($class["status"]) == "2"): ?>被合并<?php endif; ?>
							<?php if(($class["status"]) == "3"): ?>已结业<?php endif; ?>
							<?php if(($class["status"]) == "4"): ?>已废除<?php endif; ?> -->
						</td>
						<td><?php echo ($class["createtime"]); ?></td>
						<td><?php echo ($class["begintime"]); ?></td>
						<td><?php echo ($class["endtime"]); ?></td>
						<td><?php echo ($class["headerid"]); ?></td>
						<td><?php echo ($class["managerid"]); ?></td>
						<td><?php echo ($class["stucount"]); ?></td>
						<td><?php echo ($class["remark"]); ?></td>
					</tr><?php endif; endforeach; endif; ?>
			
			
			<!-- <?php $__FOR_START_15861__=0;$__FOR_END_15861__=$arrayLength;for($i=$__FOR_START_15861__;$i < $__FOR_END_15861__;$i+=1){ ?><for start="$arrayLength-1" end="0" comparison="egt" step="-1" name="i">
				<?php if(($i%2) == "0"): ?><tr style="background-color:yellow;">
						<td><?php echo ($data["$i"]["cid"]); ?></td>
						<td><?php echo ($data[$i]["name"]); ?></td>
						<td><?php echo ($data["$i"]["classtype"]); ?></td>
						<td><?php echo ($data["$i"]["status"]); ?></td>
						<td><?php echo ($data["$i"]["createtime"]); ?></td>
						<td><?php echo ($data["$i"]["begintime"]); ?></td>
						<td><?php echo ($data["$i"]["endtime"]); ?></td>
						<td><?php echo ($data["$i"]["headerid"]); ?></td>
						<td><?php echo ($data["$i"]["managerid"]); ?></td>
						<td><?php echo ($data["$i"]["stucount"]); ?></td>
						<td><?php echo ($data["$i"]["remark"]); ?></td>
					</tr><?php endif; ?>
				<?php if(($i%2) == "1"): ?><tr style="background-color:green;">
						<td><?php echo ($data["$i"]["cid"]); ?></td>
						<td><?php echo ($data[$i]["name"]); ?></td>
						<td><?php echo ($data["$i"]["classtype"]); ?></td>
						<td><?php echo ($data["$i"]["status"]); ?></td>
						<td><?php echo ($data["$i"]["createtime"]); ?></td>
						<td><?php echo ($data["$i"]["begintime"]); ?></td>
						<td><?php echo ($data["$i"]["endtime"]); ?></td>
						<td><?php echo ($data["$i"]["headerid"]); ?></td>
						<td><?php echo ($data["$i"]["managerid"]); ?></td>
						<td><?php echo ($data["$i"]["stucount"]); ?></td>
						<td><?php echo ($data["$i"]["remark"]); ?></td>
					</tr><?php endif; } ?>
			-->
		</table>
		<?php echo ($j); ?>
		<?php switch($j): case "1": ?>你<?php break;?>
			<?php case "2": ?>我<?php break;?>
			<?php case "3": ?>他<?php break;?>
			<?php case "4": ?>你们<?php break;?>
			<?php case "5": ?>我们<?php break;?>
			<?php case "6": ?>他们<?php break;?>
			<default>其他</default><?php endswitch;?>
		<br/>
		<?php if($j < 6): ?>哈哈哈哈哈哈哈
		<?php else: ?>
			hehehehehe<?php endif; ?>
		
		
		
	</body>
</html>
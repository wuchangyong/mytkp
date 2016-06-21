<?php 
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>朗沃教学管理系统首页</title>
		<meta charset="utf-8">
		<link type="text/css" rel="stylesheet" href="Public/easyui/themes/bootstrap/easyui.css"/>
		<link type="text/css" rel="stylesheet" href="Public/easyui/themes/icon.css" />
		<script type="text/javascript" src="Public/easyui/jquery.min.js"></script>
		<script type="text/javascript" src="Public/easyui/jquery.easyui.min.js"></script>
		<script type="text/javascript" src="Public/easyui/locale/easyui-lang-zh_CN.js"></script>
		<style type="text/css">
        #top-left{
	        float: left;
        	height:90px;
        	width:300px;
        }
        #top-right{
	        float: right;
        	height:90px;
        	width:200px;
        }
        </style>
		<script type="text/javascript">
		function addTabs(url,name){
			if($('#tabs').tabs("exists",name)){
				//如果当前选项卡已存在，则直接选中它
				$("#tabs").tabs("select",name);
			}else{
				// 添加一个未选中状态的选项卡面板
				$('#tabs').tabs('add',{
					title: name,
					selected: true,
					closable: true,
					content: "<iframe name='"+name+"' src='"+url+"' width='100%' height='100%' frameborder='0' scrolling='no'></iframe>"
				});
			}
		}
		</script>
	</head>
	<body class="easyui-layout">   
        <div data-options="region:'north',split:true,iconCls:'icon-ok',collapsible:false" style="height:100px;">
        	<div id="top-left"></div>
        	<div id="top-right">
        		<p>
        			<?php 
        			if(array_key_exists("loginUser",$_SESSION)){
        			    echo "欢迎你，".$_SESSION["loginUser"][4];
        			}
        			?>
        		</p>
        	</div>
        </div>   
        
        <div data-options="region:'west',title:'菜单',split:true" style="width:200px;">
        	<ul id="tree" class="easyui-tree">   
                <?php 
                if(array_key_exists("secondMenu", $_SESSION)){
                    $secondMenu = $_SESSION["secondMenu"];
                    foreach($secondMenu as $menu2){
                        echo "<li>";
                        echo "<span>{$menu2[1]}</span>";
                        echo "<ul>";
                        foreach($menu2[5] as $menu3){
                            echo "<li><span><a href=\"javascript:addTabs('{$menu3[2]}','{$menu3[1]}');\">{$menu3[1]}</a></span></li>";
                        }
                        echo "</ul>";
                        echo "</li>";
                    }
                }
                ?>
            </ul> 
        </div>   
        
        <div data-options="region:'center'" style="padding:5px;background:#eee;">
        	<div id="tabs" class="easyui-tabs" data-options="fit:true">   
                <div title="欢迎">   
                    	欢迎你
                </div>   
            </div>
        </div>   
    </body> 
</html>
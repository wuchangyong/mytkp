<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<title>菜单管理界面</title>
		<meta charset="utf-8">
		<link type="text/css" rel="stylesheet" href="http://localhost:8000/mytkp/Public/easyui/themes/bootstrap/easyui.css"/>
		<link type="text/css" rel="stylesheet" href="http://localhost:8000/mytkp/Public/easyui/themes/icon.css" />
		<script type="text/javascript" src="http://localhost:8000/mytkp/Public/easyui/jquery.min.js"></script>
		<script type="text/javascript" src="http://localhost:8000/mytkp/Public/easyui/jquery.easyui.min.js"></script>
		<script type="text/javascript" src="http://localhost:8000/mytkp/Public/easyui/locale/easyui-lang-zh_CN.js"></script>
		<style type="text/css">
        #formtable{width:60%;margin:auto;margin-top:20px;}
        #formtable tr{height:40px;}
        .in{width:200px;}
        </style>
		<script type="text/javascript">
		$(function(){
			$('#win').window('close');  // close a window 
			$('#dg').datagrid({
			    striped:true,
			    method: "GET",
			    url:'http://localhost:8000/mytkp/index.php/Home/Menu/loadMenuByPage?pageNo=1&pageSize=10',
			    pagination:true,
			    rownumbers:true,
			    frozenColumns:[[
			        {field:'aaa',checkbox:true}
			    ]],
			    columns:[[
			        {field:'menuid',hidden:true},
			        {field:'name',title:'菜单名称',width:100,align:'center'},
			        {field:'url',title:'菜单地址',width:200,align:'center'},
			        {field:'parentName',title:'父级菜单ID',width:200,align:'center'},
			        {field:'isshow',title:'是否显示',width:200,align:'center',formatter:function(value){
						if(value == 1){
							return "显示";
						}else{
							return "不显示";
						}
				    }}
			    ]],
			    toolbar: [{
					iconCls: 'icon-add2',
					text: '添加',
					handler: function(){
						//每次打开窗口前加载1 2级菜单作为父级菜单下拉列表的选项
						$('#parentid').combobox({    
						    url:'http://localhost:8000/mytkp/index.php/Home/Menu/load12Menu',    
						    valueField:'menuid',    
						    textField:'name'   
						}); 
						$('#ff').form('reset');
						$('#parentid').combobox("setValue",-1);
						$('#win').window('open');  // open a window    
					}
				},'-',{
					iconCls: 'icon-delete',
					text: '删除',
					handler: function(){
						var selectedRows = $("#dg").datagrid("getSelections");
						if(selectedRows.length == 0){
							alert("请先选中行再删除！");
							return;
						}
						if(window.confirm("你真的想删除这些数据吗？")){
							var menuids = new Array();
							for(var i=0;i<selectedRows.length;i++){
								menuids.push(selectedRows[i].menuid);
							}
							$.post("http://localhost:8000/mytkp/index.php/Home/Menu/deleteMenus",{
								"menuids"    : menuids.join(",")
							},function(data){
								refreshData(1,10);
							},"text");
						}
					}
				},'-',{
					iconCls: 'icon-modify',
					text: '修改',
					handler: function(){
						var selectedRows = $("#dg").datagrid("getSelections");
						if(selectedRows.length == 0){
							alert("请先选中行再修改！");
							return;
						}
						if(selectedRows.length > 1){
							alert("你只能选中一行进行修改！");
							return;
						}
						//每次打开窗口前加载1 2级菜单作为父级菜单下拉列表的选项
						$('#parentid').combobox({    
						    url:'http://localhost:8000/mytkp/index.php/Home/Menu/load12Menu',    
						    valueField:'menuid',    
						    textField:'name'   
						});  
						$('#parentid').combobox("setValue",-1);
						$('#ff').form('reset');
						//获取当前选中的那一行数据
						var row = selectedRows[0];
						//回填数据
						$.getJSON("http://localhost:8000/mytkp/index.php/Home/Menu/loadMenuByID?menuid="+row.menuid,{},function(data){
							$("#menuid").val(row.menuid);
							$("#name").val(data.name);
							$("#url").val(data.url);
							$("#parentid").combobox("setValue",data.parentid);
							$("#isshow").combobox("setValue",data.isshow);
						});
						$('#win').window('open');  // open a window   
					}
				},'-',{
					iconCls: 'icon-refresh',
					text: '刷新',
					handler: function(){
						refreshData(1,10);
					}
				}]
			});

			//设置翻页功能
			var pager = $("#dg").datagrid("getPager");
			pager.pagination({
				onSelectPage:function(pageNumber, pageSize){
					refreshData(pageNumber,pageSize);
				}
			});
		});
		function saveOrUpdateMenu(){
			var menuid = $("#menuid").val();
			var name = $("#name").val();
			var url = $("#url").val();
			var parentid = $('#parentid').combo('getValue');
			var isshow = $("#isshow").combo("getValue");
			$.post("http://localhost:8000/mytkp/index.php/Home/Menu/saveOrUpdateMenu",{
				"menuid"	: menuid,
				"name"		: name,
				"url" 		: url,
				"parentid"  : parentid,
				"isshow"	: isshow
			},function(data){
				if(data == "insertok"){
					$.messager.alert('消息','菜单添加成功！','info',function(){
						refreshData(1,10);
						$('#win').window('close');  // close a window
					});
				}else if(data == "updateok"){
					$.messager.alert('消息','菜单修改成功！','info',function(){
						refreshData(1,10);
						$('#win').window('close');  // close a window
					});
				}
			},"text");
		}


		//刷新表格数据
		function refreshData(pageNumber,pageSize){
			$("#dg").datagrid('loading');
			$.getJSON("http://localhost:8000/mytkp/index.php/Home/Menu/loadMenuByPage?pageNo="+pageNumber+"&pageSize="+pageSize,{},function(result){
				$("#dg").datagrid('loadData',{
					rows: result.rows,
					total: result.total
				});
				var pager = $("#dg").datagrid("getPager");
				pager.pagination({
					pageSize:pageSize,
					pageNumber:pageNumber
				});
				$("#dg").datagrid('loaded');
			});
		}
		</script>
	</head>
	<body>
		<table id="dg"></table>
		<div id="win" class="easyui-window" title="添加菜单" style="width:600px;height:400px;"   
                data-options="iconCls:'icon-add2',modal:true,collapsible:false,minimizable:false,maximizable:false,resizable:false">   
            <form id="ff" method="post">
            	<input type="hidden" id="menuid"/>
            	<table id="formtable">
            		<tr>
            			<td align="right"><label for="name">菜单名称：</label></td>
            			<td><input class="easyui-validatebox in" type="text" id="name" name="name" data-options="required:true" placeholder="请输入菜单名称" /></td>
            		</tr>
            		<tr>
            			<td align="right"><label for="url">菜单URL：</label></td>
            			<td><input class="easyui-validatebox in" type="text" id="url" name="url" data-options="" placeholder="若添加非最低级菜单，此项可不填" /></td>
            		</tr>
            		<tr>
            			<td align="right"><label for="url">父级菜单：</label></td>
            			<td><select id="parentid" class="in" name="parentid"></select></td>
            		</tr>
            		<tr>
            			<td align="right"><label for="isshow">是否展示：</label></td>
            			<td>
            				<select id="isshow" class="easyui-combobox in" name="isshow">
            					<option value="1">展示</option>
            					<option value="0">不展示</option>
            				</select>
            			</td>
            		</tr>
            		<tr>
            			<td align="center" colspan="2">
            				<a id="btn" href="javascript:saveOrUpdateMenu();" class="easyui-linkbutton" data-options="iconCls:'icon-submit'">确认</a> 
            			</td>
            		</tr>
            	</table>   
            </form>  
        </div> 
	</body>
</html>
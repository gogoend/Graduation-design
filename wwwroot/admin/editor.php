<!doctype html>
<?php
session_start();
if(!isset($_SESSION['current_user'])){
	header('Location:sign_in.html');
}
?>
<html>
<head>
<meta charset="utf-8">
<title>H-Cube.ga可视化编辑器</title>
<style>
@font-face {
	font-family: JackieHan_FontIcon;
	src: url('../img/font_icon/hkj_icon.woff'), url('../img/font_icon/hkj_icon.ttf');
}
* {
	font-family: "微软雅黑", " 黑体", " 华文细黑", Microsoft YaHei UI, " 等线";
}
ul, li {
	/*ul 、li一定要初始化，否则会有很大间隙*/
	margin: 0px;
	padding: 0px;
}
.editor_container {
	margin: 0 auto;
}
.input-wrap {
	width: 70%;
	margin: 0px auto;
	min-width: 450px;
	max-width: 1000px;
}
.input_area {
	margin: 10px 5px;
	text-align: center;
}
.input_area input {
	width: 30%;
	margin: 5px;
	border: 0px;
	border-bottom: 1px solid rgba(0,0,0,1.00);
}
.visual_editor {
	margin: 0 auto;
	box-shadow: 5px 5px 20px rgba(128,128,128,0.7);
}
#visual_editor_control_btn_area {
	clear: both;
	display: block;
	margin: 0 auto;
	width: 100%;
	background: linear-gradient(rgba(244,244,244,1), rgba(200,200,200,1.00));
	height: 44px;
	user-select: none;
}
.visual_editor_display_area {
	display: block;
	margin: 0px auto;
	width: 100%;
}
.visual_editor_edit_content {
	display: block;
	box-sizing: border-box;
	margin: 0 auto;
	width: 100%;
	min-height: 300px;
	border-top: 1px rgba(128,128,128,1.00) solid;
	border-right: 0px rgba(0,84,138,1.00) solid;
	border-bottom: 0px rgba(0,84,138,1.00) solid;
	border-left: 0px rgba(0,84,138,1.00) solid;
	overflow: hidden;
	resize: vertical;
}
#visual_editor_control_btn_area ul {
	padding: 0px;
	margin: 5px;
}
.editor_toolbar_btn {
	display: inline-block;
	list-style: none;
	box-sizing: content-box;
	margin: 0px;
	float: left;
	transition: ease 0.2s all;
	cursor: pointer;
	line-height: 30px; /*行距设为与div高度一致*/
	text-align: center;
	border: 0px rgba(0,0,0,1.00) solid;
	padding: 2px;
	color: rgba(60,60,60,1.00);
}
.editor_text_btn {
	margin: 0px;
	float: left;
	transition: ease 0.2s all;
	cursor: pointer;
	line-height: 30px; /*行距设为与div高度一致*/
	text-align: center;
	border: 0px rgba(0,0,0,1.00) solid;
	padding: 2px;
	color: rgba(60,60,60,1.00)
}
.editor_toolbar_btn {
	width: 30px;
	height: 30px;
	font-size: 30px;
}
.editor_toolbar_btn:hover {
	box-shadow: 2px 2px 2px rgba(129,129,129,0.5);
	background: rgba(180,180,180,0.5);
	border-radius: 8px;
}
.editor_toolbar_btn:active {
	box-shadow: 2px 2px 2px rgba(129,129,129,0.5) inset;
	background: rgba(200,200,200,0);
}
.editor_left_btn_group {
	float: left;
}
.editor_right_btn_group {
	float: right;
}
.editor_bottom_btn_group {
	margin: 9px 0px;
	display: block;
	clear: both;
}
.editor_bottom_btn_group .editor_text_btn {
	display: block;
	color: white;
	padding: 1px 8px;
	margin: auto 3px auto 3px;
	background: rgba(60,60,60,1.00);
}
.editor_bottom_btn_group .editor_text_btn:hover {
	background: rgba(0,64,160,1.00);
	border-radius: 8px;
}
.font_icon {
	font-family: JackieHan_FontIcon;
}
.editor_separate_line {
	display: inline-block;
	width: 1px;
	height: 32px;
	vertical-align: middle;
	background: rgba(67,67,67,1.00);
	float: left;
	margin: 0px 2px;
}
.article_title_box {
	text-align: center;
	overflow: hidden;
	margin: 10px
}
.article_title_box input {
	width: 70%;
	height: 36px;
	text-align: center;
	font-size: 30px;
	border: 0px;
	border-bottom: 1px solid rgba(58,58,58,1.00);
}
.left_float {
	float: left;
}
.right_float {
	float: right;
}
.code_editor_edit_content {
	resize: vertical;
	display: block;
	margin: 0 auto;
	box-sizing: border-box;
	width: 100%;
	border: 0px;
	border-top: 1px solid;
	min-height: 300px;
}
.editor_msg {
	display: block;
	margin: 9px 10px;
	padding: 6px 0px;
	text-align: right;
	color: rgba(6,120,0,1.00);
	float: right;
}
.down_list {
	display: block;
	font-family: "微软雅黑", " 黑体", " 华文细黑", Microsoft YaHei UI, " 等线";
	font-size: 16px;
	width: 150px;
	background: rgba(244,244,244,1.00);
	box-shadow: 2px 2px 10px rgba(128,128,128,0.5);
	position: relative;
	top: -4px;
	left: -4px;
	padding: 5px;
	display: none;
	z-index: 0;
}
.down_list li {
	margin: 0px;
	padding: 0px 10px;
	list-style: none;
	text-align: left;
}
.btn_description {
	box-sizing: border-box;
	z-index: 1;
	position: absolute;
	font-size: 8px;
	text-align: center;
	background: rgba(23,23,23,0.9);
	color: white;
	margin: 0 auto;
	padding: 0px 10px;
	border-radius: 10px;
	display: none;
	cursor: default;
	pointer-events: none;
}
#btn_fontSize:hover .down_list {
}
.editor_toolbar_btn:hover .btn_description {
	display: block;
	white-space: nowrap
}
.down_list li:hover {
	background: rgba(37,37,37,1.00);
	color: white;
}
.article_lang {
	width: 100px;
}
.article_option_area {
	margin: 10px 20px 0px 0px;
	line-height: 30px;
}
.article_option_area section {
	display: inline-block;
	margin: 0px 3px
}
.article_bottom_tool {
	margin: 5px 10px;
	width: 100%;
}
.article_option_area select, .article_option_area input {
	height: 20px;
	margin: 2px;
	padding: 0;
	line-height: 20px;
	vertical-align: middle;
	width: auto;
}
.option_lable {
	width: 20%;
	min-width: 100px;
}
.options {
	width: 80%;
	max-width: 200px;
}
	
	.options input{
		width:40%;
		min-width: 270px
	}

</style>
</head>

<body style="margin: 0px">
<div class="editor_container">
  <div class="input-wrap">
    <form id="editor_form" action="article_publish_handler.php" method="post">
      <div class="input_area" >
        <div class="article_title_box">
          <input onBlur="checkTitle()" id="article_title" name="article_title" placeholder="在这里写下文章标题" type="text">
        </div>
        <input id="article_category" name="article_category" placeholder="文章分类" type="text" >
        <input id="article_second_category" name="article_second_category" placeholder="文章二级分类" type="text" >
        <input id="article_author" name="article_author" placeholder="文章作者" type="text" >
      </div>
      <div class="editor_area">
        <div class="visual_editor">
          <div id="visual_editor_control_btn_area">
            <ul class="editor_left_btn_group" id="editor_left_btn_group">
              <!--
      <li class="font_icon editor_toolbar_btn" id="btn_undo">U</li>
      <li class="font_icon editor_toolbar_btn" id="btn_redo">r</li>
      <li class="editor_separate_line "></li>
      <li class="font_icon editor_toolbar_btn" id="btn_paste">P</li>
      <li class="font_icon editor_toolbar_btn" id="btn_cut">X</li>
      <li class="font_icon editor_toolbar_btn" id="btn_copy">C</li>
      <li class="font_icon editor_toolbar_btn" id="btn_selectAll">S</li>
      <li class="editor_separate_line "></li>
      -->
              <li class="font_icon editor_toolbar_btn" id="btn_fontSize"> T
                <div class="btn_description">字体大小</div>
                <ul class="down_list">
                  <li>特大</li>
                  <li>大</li>
                  <li>中</li>
                  <li>小</li>
                  <li>特小</li>
                </ul>
              </li>
              <li class="font_icon editor_toolbar_btn" id="btn_bold">b
                <div class="btn_description">加粗</div>
              </li>
              <li class="font_icon editor_toolbar_btn" id="btn_italic">i
                <div class="btn_description">斜体</div>
              </li>
              <li class="font_icon editor_toolbar_btn" id="btn_underline">u
                <div class="btn_description">下划线</div>
              </li>
              <li class="editor_separate_line "></li>
              <li class="font_icon editor_toolbar_btn" id="btn_leftAlign">L
                <div class="btn_description">左对齐</div>
              </li>
              <li class="font_icon editor_toolbar_btn" id="btn_centerAlign">M
                <div class="btn_description">居中对齐</div>
              </li>
              <li class="font_icon editor_toolbar_btn" id="btn_rightAlign">R
                <div class="btn_description">右对齐</div>
              </li>
              <li class="editor_separate_line "></li>
              <li class="font_icon editor_toolbar_btn" id="btn_ul">V
                <div class="btn_description">无序列表</div>
              </li>
              <li class="font_icon editor_toolbar_btn" id="btn_ol">W
                <div class="btn_description">有序列表</div>
              </li>
              <li class="editor_separate_line "></li>
              <li class="font_icon editor_toolbar_btn" id="btn_cleanFormat">e
                <div class="btn_description">清除格式</div>
              </li>
            </ul>
            
            <!--  
       <div id="btn_quote">块引用</div>
        <div id="btn_hyperlink">超链接</div>
        <div id="btn_deleteHyperlink">取消超链接</div>
        <div id="btn_code">代码块</div>
        -->
            
            <ul class="editor_right_btn_group">
              <li class="font_icon editor_toolbar_btn" id="btn_empty">x
                <div class="btn_description" >清空并重置</div>
              </li>
              <li class="font_icon editor_toolbar_btn" id="btn_richTextMode" style="display: none">J
                <div class="btn_description" >可视化编辑</div>
              </li>
              <li class="font_icon editor_toolbar_btn" id="btn_codeMode">Z
                <div class="btn_description">纯文本编辑</div>
              </li>
            </ul>
          </div>
          <div class="visual_editor_display_area"> 
            <!--设置属性使得div中的内容可以编辑-->
            <iframe id="visual_editor_edit_content" class="visual_editor_edit_content" style="display: block"></iframe>
            <!--<iframe id="visual_editor_edit_content" contenteditable="true"></iframe>-->
            <textarea id="code_editor_edit_content" class="code_editor_edit_content" name="article_content_code" style="display: none"></textarea>
          </div>
        </div>
        <div class="article_option_area">
          <section>
            <input type="checkbox" name="if_top_article" id="if_top_article" value="top">
            <label>置顶文章</label>
          </section>
          <section>
            <input type="checkbox" name="if_favor_article"  id="if_favor_article" value="favor">
            <label>精选文章</label>
          </section>
          <section>
            <input type="checkbox" name="if_private_article" id="if_private_article" value="private">
            <label>不公开文章</label>
          </section>
          <section>
            <input type="checkbox" name="if_no_comment" id="if_no_comment" value="false">
            <label>禁止评论</label>
          </section>
        </div>
        <div class="article_option_area">
          <table width="100%">
            <tr>
              <td class="option_lable"><lable>文章语言</lable></td>
              <td class="options" ><select name="article_lang" class="article_lang" id="article_lang">
                  <option value="global">通用</option>
                  <option value="zh-cn">简体中文</option>
                  <option value="en-us">English</option>
                  <option value="zh-tw">正體中文</option>
                </select></td>
            </tr>
          </table>
        </div>
        <div class="article_option_area">
          <table width="100%">
            <tr>
              <td class="option_lable"><lable>文章许可方式</lable></td>
              <td class="options"><select name="article_licence" class="article_licence" id="article_licence" onChange="checkLicence()">
                  <option selected value="by-nc-sa40">署名-非商业性使用-相同方式共享 4.0 国际许可</option>
                  <option value="by-nc-nd40">署名-非商业性使用-禁止演绎 4.0 国际许可</option>
                  <option value="by-nc40">署名-非商业性使用 4.0 国际许可</option>
                  <option value="by-sa40">署名-相同方式共享 4.0 国际许可</option>
                  <option value="by-nd40">署名-禁止演绎 4.0 国际许可</option>
                  <option value="by40">署名 4.0 国际许可</option>
				  		  <option value="repost">转载自...</option>
                  <option value="copyright">禁止转载</option>
                </select>
                <input style="" id="article_from" name="article_from" placeholder="文章来源" type="text" ></td>
            </tr>
          </table>
        </div>
        <div class="editor_bottom_btn_group left_float" id="editor_bottom_btn_group">
          <div class="editor_text_btn" id="btn_saveRichText">保存</div>
          <div class="editor_text_btn" id="btn_publish">发布</div>
        </div>
        <div class="editor_msg" id="editor_msg" ></div>
      </div>
    </form>
  </div>
</div>

	<script src="../js/public.js"></script>
<script>
	//检查所有内容是否填写完整
	function checkAll(){
		if(checkTitle()&&checkArticleContent()){
			return true;
		}else{
			return false;
		}
	}
	//检查输入内容
	function checkTitle(){
			articleTitle=document.getElementById("article_title").value;
			articleTitleBox=document.getElementById("article_title");
			titleForCheck=articleTitle.replace(/\s+/,"");
			if (titleForCheck==''||titleForCheck==null){
				articleTitleBox.style.borderColor="#ff0000";
				return false;
			}else{
				articleTitleBox.style.borderColor="";
				return true;
			}
		}
	function checkArticleContent(){
		articleContent=document.getElementById("visual_editor_edit_content").contentWindow.document.getElementsByTagName("body")[0].innerHTML;
		filteredArticleContent=filterHtmlTag(articleContent,0);
		if(filteredArticleContent==""||filteredArticleContent==null){
			return false;
		}
		else {
			return true;
		}
	}

	//检查文章许可
	function checkLicence(){
		licence=document.getElementById("article_licence").value;
		from=document.getElementById("article_from");
		if(licence!="copyright"){
			from.style.display="";
		}else{
			from.style.display="none";
		}
			/*from.onblur=function(){
			if(licence=="repost"){
				if(from.value==""||from.value==null){
					from.style.borderColor="#ff0000";
					return false;
				}else{
					from.style.borderColor="";
					return true;
			}
			}else{
				from.style.borderColor="";
				return true;
			}
		}*/
	}
	
	
	
	
	//检查框架内的body是否为空，如果是空的，就检查本地存储中的内容是否为空，如果不是空的就把其中的内容写入框架内的body
	function ifEditableAreaEmpty(){
			if(!checkArticleContent()){
						if(localStorage.getItem("articleContent")){
							document.getElementById("visual_editor_edit_content").contentWindow.document.getElementsByTagName("body")[0].innerHTML=localStorage.getItem("articleContent");
							document.getElementById("code_editor_edit_content").value=localStorage.getItem("articleContent");
						}
					}
					articleTitle=document.getElementById("article_title").value;
					if(articleTitle==""||articleTitle==null){
						if(localStorage.getItem("articleTitle")){
							document.getElementById("article_title").value=localStorage.getItem("articleTitle");
							if(localStorage.getItem("articleInformation")){
								articleInformationStr=localStorage.getItem("articleInformation");
								articleInformation=JSON.parse(articleInformationStr);
								document.getElementById("article_category").value=articleInformation.articleCategory;
								document.getElementById("article_second_category").value=articleInformation.articleSecondCategory;
								document.getElementById("article_author").value=articleInformation.articleAuthor;
								document.getElementById("if_top_article").checked=articleInformation.articleIfTop;
								document.getElementById("if_favor_article").checked=articleInformation.articleIfFavor;
								document.getElementById("if_private_article").checked=articleInformation.articleIfPrivate;
								document.getElementById("if_no_comment").checked=articleInformation.articleIfNoComment;
								document.getElementById("article_lang").value=articleInformation.articleLang;
								document.getElementById("article_licence").value=articleInformation.articleLicence;
								document.getElementById("article_from").value=articleInformation.articleFrom;
							}
						}
					}
				}
	//清空编辑区域
	function emptyEditor(){
		    var message=confirm("您将清空编辑器及本地草稿箱中的所有内容，重置编辑器并创建新的文档。\n该操作不可撤销，您将丢失所有您当前已编辑的内容，是否继续？");
			if(message==true){
				//分别清空标题、可视化编辑器和代码编辑器中的内容，清除本地存储中的内容。
				/*document.getElementById("article_title").value="";
				document.getElementById("visual_editor_edit_content").contentWindow.document.getElementsByTagName("body")[0].innerHTML="";
				document.getElementById("editor_msg").innerHTML="";
				document.getElementById("code_editor_edit_content").value="";*/
				localStorage.removeItem("articleTitle");
				localStorage.removeItem("articleContent");
				localStorage.removeItem("articleInformation");
				self.location.reload();
				
				}
	}
	
	//保存标题的同时也保存文章的附加信息
	function saveTitle(){
		articleTitle=document.getElementById("article_title").value;
		if(articleTitle==null||articleTitle==""){
		}else{
			localStorage.setItem("articleTitle",articleTitle);
			saveArticleInformation();
		}
	}
	
	function saveArticleInformation(){
		articleCategory=document.getElementById("article_category").value;
		articleSecondCategory=document.getElementById("article_second_category").value;
		articleAuthor=document.getElementById("article_author").value;
		articleIfTop=document.getElementById("if_top_article").checked;
		articleIfFavor=document.getElementById("if_favor_article").checked;
		articleIfPrivate=document.getElementById("if_private_article").checked;
		articleIfNoComment=document.getElementById("if_no_comment").checked;
		articleLang=document.getElementById("article_lang").value;
		articleLicence=document.getElementById("article_licence").value;
		articleFrom=document.getElementById("article_from").value;
		var articleInformation={
    			"articleCategory": articleCategory,
    			"articleSecondCategory": articleSecondCategory,
    			"articleAuthor": articleAuthor,
    			"articleIfTop": articleIfTop,
    			"articleIfFavor": articleIfFavor,
    			"articleIfPrivate": articleIfPrivate,
    			"articleIfNoComment": articleIfNoComment,
    			"articleLang": articleLang,
    			"articleLicence": articleLicence,
    			"articleFrom": articleFrom
			};
		articleInformationStr=JSON.stringify(articleInformation);//json对象转换为字符串
		localStorage.setItem("articleInformation",articleInformationStr);
	}

	function saveDraftRichText(operation){
		saveTitle();
		origArticleContent=document.getElementById("visual_editor_edit_content").contentWindow.document.getElementsByTagName("body")[0].innerHTML;
		filteredArticleContent=filterHtmlTag(origArticleContent,1);	
		//filteredArticleContent_for_check=filterHtmlTag(filteredArticleContent,0);	
		failMsg="保存失败，请在编辑器中输入内容";
		successMsg="保存成功";
		//处理失败
		if(filteredArticleContent==null||filteredArticleContent==""){
			switch(operation){
				//设置是否显示提示
				case 0:;break;
				case 1:{
					document.getElementById("editor_msg").innerHTML=failMsg;
					setTimeout(function(){
						if(document.getElementById("editor_msg").innerHTML==failMsg){
							document.getElementById("editor_msg").innerHTML="";
						}
					},5000);
				}break;
				default:;break
			}
			return false;
		}else{
			//处理成功
			document.getElementById("code_editor_edit_content").value=filteredArticleContent;
			localStorage.setItem("articleContent",filteredArticleContent);
			switch(operation){
				case 0:;break;
				case 1:{
					document.getElementById("editor_msg").innerHTML=successMsg;
					setTimeout(function(){
						if(document.getElementById("editor_msg").innerHTML==successMsg){
							document.getElementById("editor_msg").innerHTML="";
						}
					},5000);
				}break;
				case 2:{
					return filteredArticleContent;
				}break;
				default:;break;
			}
			return true;
			//console.log("富文本已保存");
			//localStorage.articleContent=filteredArticleContent;
			//console.log(filteredArticleContent);
			//document.getElementById("preview").innerHTML=filteredArticleContent;
		}
	}	
	
	
	//代码模式下保存到草稿箱
	/*
	operation：
		0或default：静默保存，无提示
		1：显示保存提示
		2：仅返回过滤过的文章内容
	*/
		function saveDraftCode(operation){
		saveTitle();
		origArticleContent=document.getElementById("code_editor_edit_content").value;
		filteredArticleContent=filterHtmlTag(origArticleContent,1);	
		//filteredArticleContent_for_check=filterHtmlTag(filteredArticleContent,0);
		failMsg="保存失败，请在编辑器中输入内容";
		successMsg="保存成功";
		if(filteredArticleContent==null||filteredArticleContent==""){
			switch(operation){
				case 0:;break;
				case 1:{
					document.getElementById("editor_msg").innerHTML=failMsg;
					setTimeout(function(){
						if(document.getElementById("editor_msg").innerHTML==failMsg){
							document.getElementById("editor_msg").innerHTML="";
						}
					},5000);
				}break;
				default:;break
			}
			return false;
		}else{
			document.getElementById("visual_editor_edit_content").contentWindow.document.getElementsByTagName("body")[0].innerHTML=filteredArticleContent;
			localStorage.setItem("articleContent",filteredArticleContent);
			switch(operation){
				case 0:;break;
				case 1:{
					document.getElementById("editor_msg").innerHTML=successMsg;
					setTimeout(function(){
						if(document.getElementById("editor_msg").innerHTML==successMsg){
							document.getElementById("editor_msg").innerHTML="";
						}
					},5000);
				}break;
				case 2:{
					return filteredArticleContent;
				}break;
				default:;break
			}
			return true;
			//console.log("代码已保存");
			//localStorage.articleContent=filteredArticleContent;
			//console.log(filteredArticleContent);
			//document.getElementById("preview").innerHTML=filteredArticleContent;
		}
	}	
	
	//编辑器切换到代码模式
	/*
	operation：要进行的操作
			save：保存并切换
			status：返回代码编辑模式是否已经打开
	*/
	function editorCodeMode(operation){
		switch(operation){
			case "save":{
					document.getElementById("editor_msg").innerHTML="";
					document.getElementById("code_editor_edit_content").style.height=document.getElementById("visual_editor_edit_content").style.height;
					document.getElementById("visual_editor_edit_content").style.display="none";
					document.getElementById("editor_left_btn_group").style.display="none";
					document.getElementById("code_editor_edit_content").style.display="block";
					document.getElementById("btn_saveRichText").id="btn_saveCode";
					saveDraftRichText(0);
					document.getElementById("btn_codeMode").style.display="none";
					document.getElementById("btn_richTextMode").style.display="inline-block";
					//console.log("代码编辑模式");
			}break;
			case "status":{
					if(document.getElementById("code_editor_edit_content").style.display=="block")
					{//console.log("代码编辑模式已打开");
						return true;}
					else
					{return false;}
			}break;
		}
	}
	
	//编辑器切换到富文本模式
	/*
	operation：要进行的操作
			save：保存并切换
			status：返回富文本编辑模式是否已经打开
	*/
	function editorRichTextMode(operation){
		switch(operation){
			case "save":{
					document.getElementById("editor_msg").innerHTML="";
					document.getElementById("visual_editor_edit_content").style.height=document.getElementById("code_editor_edit_content").style.height;
					document.getElementById("code_editor_edit_content").style.display="none";
					document.getElementById("editor_left_btn_group").style.display="block";
					document.getElementById("visual_editor_edit_content").style.display="block";
					document.getElementById("btn_saveCode").id="btn_saveRichText";
					saveDraftCode(0);
					document.getElementById("btn_richTextMode").style.display="none";
					document.getElementById("btn_codeMode").style.display="inline-block";
					//console.log("富文本编辑模式");
			}break;
			case "status":{
				if(document.getElementById("visual_editor_edit_content").style.display=="block")
					{//console.log("富文本编辑模式已打开");
						return true;}
					else
					{return false;}
			}break;
	}
	}
	
	
	
			//设置每20秒执行一次保存
			function autoSaveTimerStart(){
				autosave_timer=setInterval(function(){
						if(editorRichTextMode("status")!=true){
							if(saveDraftCode(0)==true){
							msg="您的文章已于"+nowTime()+"自动保存到本地草稿箱";
							document.getElementById("editor_msg").innerHTML=msg;
							setTimeout(function(){
						if(document.getElementById("editor_msg").innerHTML==msg){
							document.getElementById("editor_msg").innerHTML="";
						}
					},5000);
							
							}
							}else{
						if(saveDraftRichText(0)==true){
							msg="您的文章已于"+nowTime()+"自动保存到本地草稿箱";
						document.getElementById("editor_msg").innerHTML=msg;
							setTimeout(function(){
						if(document.getElementById("editor_msg").innerHTML==msg){
							document.getElementById("editor_msg").innerHTML="";
						}
					},5000);
						}
							}},10000);}

	
				//发布按钮
				function publish(){
					//判断现在是哪种编辑模式开启，以便提交最新的更改的内容
					if(editorRichTextMode("status")!=true){
						if(saveDraftCode(2)!=false){
							finalArticle=saveDraftCode(2);
							document.getElementById("code_editor_edit_content").value=finalArticle;
						}
					}
					else{
						if(saveDraftRichText(2)!=false){
							finalArticle=saveDraftRichText(2);
							document.getElementById("code_editor_edit_content").value=finalArticle;
						}
					}
					//判断标题、许可是否都已经填写正确
					if(checkAll()){
						document.getElementById("editor_form").submit();
					}else{
						alert("发布失败，请输入标题和文章内容");
					}
				}
					
					
			
			//页面打开时执行以下脚本
			window.onload=function(){
					ifEditableAreaEmpty();
					autoSaveTimerStart();
					var editor=document.getElementById("visual_editor_edit_content").contentWindow;//获得iframe Window对象
 					var content=document.getElementById("visual_editor_edit_content").contentDocument;//获得iframe Document对象
					var toolbarBtnGroup=document.getElementById("visual_editor_control_btn_area");
					//设置事件监听
					toolbarBtnGroup.addEventListener("click",function(event){
						//DOM2级事件
						//用event获得点击的按钮id
						switch(event.target.id){
								case "btn_undo":textUndo();break;
								case "btn_redo":textRedo();break;
								case "btn_bold":addBold();break;
								case "btn_italic":addItalic();break;
								case "btn_underline":addUnderline();break;
								case "btn_fontSize":setFontSize();break;
								case "btn_paste":textPaste();break;
								case "btn_cut":textCut();break;
								case "btn_copy":textCopy();break;
								case "btn_selectAll":textSelectAll();break;
								case "btn_leftAlign":textLeftAlign();break;
								case "btn_centerAlign":textCenterAlign();break;
								case "btn_rightAlign":textRightAlign();break;
								case "btn_ul":insertUl();break;
								case "btn_ol":insertOl();break;
								case "btn_publish":publish();break;
								case "btn_empty":emptyEditor();break;
								case "btn_cleanFormat":textCleanFormat();break;
								case "btn_codeMode":editorCodeMode("save");break;
								case "btn_richTextMode":editorRichTextMode("save");break;
								/*
								case "btn_quote":insert_quote();break;
								case "btn_hyperlink":insert_hyperlink();break;
								case "btn_hyperlink":insert_hyperlink();break;
								case "btn_deleteHyperlink":insert_deleteHyperlink();break;
								*/
						}
					});
				document.getElementById("editor_bottom_btn_group").addEventListener("click",function(event){
					switch(event.target.id){
						case "btn_saveRichText":saveDraftRichText(1);break;
						case "btn_saveCode":saveDraftCode(1);break;
						case "btn_publish":publish();break;}
				});
					
					//打开iframe的设计模式，设置元素可以编辑
					editor.document.designMode="On";
					editor.document.contentEditable=true;
					ifEditableAreaEmpty();
					
					//使用document.execCommand(aCommandName, aShowDefaultUI, aValueArgument)方法实现各个按钮功能
					
					function textUndo(){
						editor.document.execCommand("undo",true,null);
					}
					
					function textRedo(){
						editor.document.execCommand("redo",true,null);
					}
					
					
					function addBold(){
						editor.document.execCommand("bold",true,null);
					}
					
					function addItalic(){
						editor.document.execCommand("italic",true,null);
					}
					
					function addUnderline(){
						editor.document.execCommand("underline",true,null);
					}
					
					function setFontSize(){
						size=parseInt(prompt('请输入字体大小'));
						editor.document.execCommand("fontSize",true,size);
					}
					function textPaste(){
						editor.document.execCommand("paste",true,null);
					}
					function textCopy(){
						editor.document.execCommand("copy",true,null);
					}
					function textCut(){
						editor.document.execCommand("cut",true,null);
					}
					function textSelectAll(){
						editor.document.execCommand("selectAll",true,null);
					}
					function insertUl(){
						editor.document.execCommand("insertUnorderedList",true,null);
					}
					function insertOl(){
						editor.document.execCommand("insertOrderedList",true,null);
					}
					function textLeftAlign(){
						editor.document.execCommand("justifyLeft",true,null);
					}
					function textRightAlign(){
						editor.document.execCommand("justifyRight",true,null);
					}
					function textCenterAlign(){
						editor.document.execCommand("justifyCenter",true,null);
					}
					function textCleanFormat(){
						editor.document.execCommand("removeFormat",true,null);
					}			
					/*function insert_hyperlink(){
						editor.document.execCommand("createLink",true,"http://h-cube.ga");
					}
					function insert_deleteHyperlink(){
						editor.document.execCommand("unlink",true,null);
					}*/
				}
			
	
	
		</script>

</body>
</html>

@extends("layout")
@section("content")
<body onbeforeunload="return close()">

<section id="status1" data-role='page'>
	<div data-role="header" >
		<h1>已上架管理</h1>
	</div><!-- /header -->
	<ul data-role="listview" id="list1" class="products"  data-split-icon="gear" data-inset="true" data-filter="true" data-filter-placeholder = "查找"></ul>
	<div data-role="popup" id="popup1" data-theme="a" data-overlay-theme="b" class="ui-content" style="width:280px; padding-bottom:2em;">
    	<a href="" title="" data-rel="back" class=" ui-btn ui-btn-a ui-corner-all " id="delete" style="background: #b5193f;color:white" key="">删除</a>
    	<br>
		<select name="level" id = "level1" onchange="select1(this.value)">
			<option value="1000" >千元档</option>
			<option value="5000" >五千档</option>
			<option value="30000" >万元档</option>
		</select>
	    <label for="price1" class="ui-hidden-accessible">价:</label><input type="range" name="price" id="price1" value="" min="0" max="100" step="" data-highlight="true" data-popup-enable="true" >
	    <br>
	    <fieldset class="ui-grid-a">
	    	<div class="ui-block-a"><a href="" data-rel="back" class="ui-shadow ui-btn  ui-btn-a ui-corner-all  "  key="" id="submit1">提交</a></div>
	    	<div class="ui-block-b"><a href="" data-rel="back" class="ui-shadow ui-btn ui-btn-b ui-corner-all ">取消</a></div>
	    </fieldset>
   </div>
</section>

<section id="status2" data-role="page">
	<div data-role="header" >
		<h1>未上架管理</h1>
	</div><!-- /header -->
	<ul data-role="listview" id="list2" class="products"  data-split-icon="gear" data-inset="true" data-filter="true" data-filter-placeholder = "查找">
	</ul>
	<div data-role="popup" id="popup2" data-theme="a" data-overlay-theme="b" class="ui-content" style="max-width:340px; padding-bottom:2em;">
		<form>
			<label for="name" class="">名 称:</label><input type="text" name="name" id="name" value="" data-clear-btn="true" placeholder="【名称】长|宽|高mm" required="required">
			<label for="price2" class="">价 格:</label>
			<select name="level" id = "level2" onchange="select2(this.value)">
				<option value="1000" >千元档</option>
				<option value="5000" >五千档</option>
				<option value="30000" >万元档</option>
			</select>
		    <label for="price2" class="ui-hidden-accessible"></label><input type="range" name="price" id="price2" value="" min="0" max="100" step="" data-highlight="true" data-popup-enable="true" >
			<label for="material" class="select" data-inline='true'>料:</label>
			<select id="material" name="material"  class='select-choice-mini' data-inline='true' data-mini='true'>
			@foreach($material['property_value'] as $p)
				<option value="{{$p['id']}}">{{$p['name']}}</option>
			@endforeach
			</select>
			<fieldset data-role = "controlgroup" data-type="horizontal" >
				<legend >属 性:</legend>
				<label for="usage" class="select" data-inline='true'>适用场景</label>
				<select id="usage" name="usage"  class='select-choice-mini' data-inline='true' data-mini='true'>
				@foreach($usage['property_value'] as $p)
					<option value="{{$p['id']}}">{{$p['name']}}</option>
				@endforeach
				</select>
				<label for="style" class="select" data-inline='true'>款式</label>
				<select id="style" name="style"   class='select-choice-mini' data-inline='true' data-mini='true'>
				@foreach($style['property_value'] as $p)
					<option value="{{$p['id']}}">{{$p['name']}}</option>
				@endforeach
				</select>
			</fieldset>
			<!-- <label for="textarea">详情描述:</label>
			<textarea cols="40" rows="8" name="textarea" id="detail" placeholder=" 宽高厚cm  1.1|1.1|1.1 &#13;&#10;&#13;&#10;【如月之恒，如日之升，如南山之寿】"></textarea> -->
			<br>
			<fieldset class="ui-grid-a">
				<div class="ui-block-a"><a href="" data-rel="back" class="ui-shadow ui-btn  ui-btn-a ui-corner-all " style="outline:#b5193f solid;outline-offset: -3px"  key="" id="submit2">上架</a></div>
				<div class="ui-block-b"><a href="" data-rel="back" class="ui-shadow ui-btn ui-btn-b ui-corner-all ">取消</a></div>
				<label> !!!上架后除价格外,其他内容不得修改</label>
			</fieldset>
		</form>
	</div>
</section><!-- /page -->

<section id="admin" data-role="page">
	<div data-role="header">
		<h1>订单管理</h1>
	</div>
	<div class="ui-grid-b">
		<!-- 基本信息 -->
		<div class="ui-block-a"> <div class="ui-bar"><a href="{{$user['extattr']['attrs'][1]['web']['url']}}"> <img src="{{$user['avatar']}}" alt="" height="80px"> </a></div> </div>
		<div class="ui-block-b"> <div class="ui-bar"> {{$user['name']}} </div> </div>
		<div class="ui-block-c"> <div class="ui-bar"><a href="#incoming" title="新至商品" type="button" data-rel="popup" data-position-to="window" data-transition="pop" style="outline:#b5193f solid;outline-offset: -3px">上传</a></div> </div>
		<!-- 抬头 -->
		<div class="ui-block-a"> <div class="ui-bar ui-bar-b"> 总销售： </div> </div>
		<div class="ui-block-b"> <div class="ui-bar ui-bar-b"> 结算额： </div> </div>
		<div class="ui-block-c"> <div class="ui-bar ui-bar-b"> 总订单： </div> </div>
		<!-- number -->
		<div class="ui-block-a"> <div class="ui-bar ui-bar-b">￥<?php if($user['extattr']['attrs']!==[]){echo $user['extattr']['attrs'][0]['text']['value'];} ?></div> </div>
		<div class="ui-block-b"> <div class="ui-bar ui-bar-b"> </div> </div>
		<div class="ui-block-c"> <div class="ui-bar ui-bar-b"> </div> </div>
	</div>
	<div data-role="popup" id="incoming" data-theme="a" data-overlay-theme="b" class="ui-content" style="width:280px; padding-bottom:2em;">
		<form action="user/photo" method="post" accept-charset="utf-8">
			<label for="amount" class="">新至商品数量</label><input type="range" name="price" id="amount" value="0" min="0" max="50" step="" data-highlight="true" data-popup-enable="true" >
			<fieldset class="ui-grid-a">
				<div class="ui-block-a"><a href="" data-rel="back" class="ui-shadow ui-btn ui-btn-b ui-corner-all "   key="" id="photo">通知</a></div>
				<div class="ui-block-b"><a href="" data-rel="back" class="ui-shadow ui-btn ui-btn-a ui-corner-all ">取消</a></div>
			</fieldset>
		</form>
	</div>
	<div data-role="listview" id="order">
		@foreach($order as $products)
			@foreach($products as $product)
			@endforeach
		@endforeach
	</div>
</section>


<footer data-role="footer" data-position="fixed">
	<div data-role="navbar">
		<ul>
			<li>	<a href="#status1" class="" data-icon="check">已上架</a></li>
			<li>	<a href="#status2" class="" data-icon="carat-d">未上架</a></li>
			<li>	<a href="#admin" class="" data-icon="bullets">管理</a></li>
		</ul>
	</div>
</footer><!-- /footer -->

</body>



<script type="text/javascript" charset="utf-8" async defer>

//global 产品数据
	var data = <?php echo $group ?>;

	init1();
	init2();
//获得产品数据data
/*	$.get(
		'group',
		function(d) {
			data = d;
			init1();
			init2();
		}
	);*/
//navbar刷新
	$(function(){
		$( "[data-role='header'], [data-role='footer']" ).toolbar();
		$( "[data-role='header'], [data-role='footer']" ).toolbar({ theme: "b" });
	});


	//init status1 products
	function init1() {
			var html1 = "";

			data.status1.forEach(
				function(e, i) {
					e['product_base']['main_img'] = e['product_base']['main_img'].replace(/https/,'http');
					// e['product_base']['img'] = e['product_base']['img'].map(function(e){e.replace(/https/,'http')});
					html1 +=
					`
					<li key="${i}" class="ui-li"><a href="#" onclick = "product('${e['product_id']}')">
					<img src="${e['product_base']['main_img']}" alt="">
					<h2>${e['product_base']['name']}</h2>
					<p>￥${e['sku_list'][0]['price']/100}</p>
					<a href="#popup1" class="pop1" key='${i}' data-rel="popup" data-position-to="window" data-transition="pop">Purchase album</a>
					</a></li>
					`;
				}
			);
			$('#list1').html(html1);
			$("#status1").page();
			$('#list1').listview("refresh");

			$('.pop1').on('click',function() {
				var i = $(this).attr('key');
				$price = data.status1[i].sku_list[0].price/100;
				if ($price<1000)
				{
					$('#level1').val('1000');
					$('#price1').attr({'step':20,'min':0,'max':1000});
					$('#level1').prev().html('千元档');
				} else if($price<5000) {
					$('#level1').val('5000');
					$('#price').attr({'step':100,'min':1000,'max':5000});
					$('#level1').prev().html('五千档');
				} else if($price<=30000) {
					$('#level1').val('30000');
					$('#price1').attr({'step':200,'min':5000,'max':30000});
					$('#level1').prev().html('万元档');
				}
				$('#price1').val($price);
				$("#delete").attr('key',i);
				$('#submit1').attr('key',i);
			});
	}

	//init status2 products
	function init2() {
			var html2 = "";

			data.status2.forEach(
				function(e, i) {
					e['product_base']['main_img'] = e['product_base']['main_img'].replace(/https/,'http');
					// e['product_base']['img'] = e['product_base']['img'].map(function(e){e.replace(/https/,'http')});
					html2 +=
					`
					<li key="${i}" class="ui-li"><a href="#">
					<img src="${e['product_base']['main_img']}" alt="" class="ui-li">
					<h2>${e['product_base']['name']}</h2>
					<p>￥${e['sku_list'][0]['price']/100}</p>
					<a href="#popup2" class="pop2" key='${i}' data-rel="popup" data-position-to="window" data-transition="pop">Purchase album</a>
					</a></li>
					`;
				}
			);
			$('#list2').html(html2);
			$("#status2").page();
			$('#list2').listview('refresh');

			// 未上架商品pop
			$('.pop2').on('click',function() {
				var i = $(this).attr('key');
				$('#name').val(data.status2[i].product_base.name);
				$price = data.status2[i].sku_list[0].price/100;
				if ($price<1000)
				{
					$('#level2').val('1000');
					$('#price2').attr({'step':20,'min':0,'max':1000});
					$('#level2').prev().html('千元档');
				} else if($price<5000) {
					$('#level2').val('5000');
					$('#price').attr({'step':100,'min':1000,'max':5000});
					$('#level2').prev().html('五千档');
				} else if($price<=30000) {
					$('#level2').val('30000');
					$('#price2').attr({'step':200,'min':5000,'max':30000});
					$('#level2').prev().html('万元档');
				}
				$('#price2').val($price);
				$('#submit2').attr('key',i);
			});
	}


//根据id设置popup中form默认值

	//已上架商品
	$('#submit1').on("click",function() {
		var key = $(this).attr("key");
		post = data.status1[key];
		post.sku_list[0].price=$('#price1').val()*100;
		console.log(post);
		$("#status1 [key='"+key+"'] p").html('￥'+$('#price1').val());
		$.post('update',
			post ,
			function(data) {
				console.log(data);
			}
		);
	});
	//未上架商品提交
	$('#submit2').on("click",function() {
		var key = $(this).attr("key");
		post = data.status2[key];
		post.product_base.property = [{'id' : 1075743464,'vid'  : 1079783184}];
		post.product_base.name=$('#name').val();
		// post.product_base.detail.unshift({text:$('#detail').val()});
		post.sku_list[0].price=$('#price2').val()*100;
		post.status = 1;
		post.product_base.property.push(
			{
				"id": "{{$material['id']}}",
				"vid": $('#material').val(),
			},
			{
				"id": "{{$style['id']}}",
				"vid": $('#style').val(),
			},
			{
				"id": "{{$usage['id']}}",
				"vid": $('#usage').val(),
			}
		 );

		$("#list2 [key='"+key+"']").remove();
		data.status1.unshift(post);
		init1();
		console.log(post);
		$.post('update',
			post ,
			function(data) {
				console.log(data);
			}
		);
	});
	//删除商品
	$('#delete').on("click",function() {
		var key = $(this).attr("key");
		post ={'product_id':data.status1[key].product_id,'group':data.status1[key].sku_list[0].product_code};
		$("#status1 li[key='"+key+"']").remove();
		$.post('delete',
				post,
				function(data) {
					console.log(data);
				}
			)
	});

// 通知产品拍摄
	$('#photo').on("click",function() {
		post = {'group':{{$user['department'][0]}},'amount' : $('#amount').val() };
		console.log(post);
		$.post(
			'user/photo',
			post,
				function(data) {
					console.log(data);
				}
			);
		alert('【已通知工作人员】'); // 有问题
	});

	function select1(val) {
		switch (val) {
			case '1000':
				$('#price1').val(0);
				$('#price1').attr({'step':20,'min':0,'max':1000});
				break;
			case '5000':
					$('#price1').val(1000);
					$('#price1').attr({'step':100,'min':1000,'max':5000});
				break;
			case '30000':
				$('#price1').val(5000);
				$('#price1').attr({'step':200,'min':5000,'max':30000});
				break;
			default:
				break;
		}
	}

	function select2(val) {
		switch (val) {
			case '1000':
				$('#price2').val(0);
				$('#price2').attr({'step':20,'min':0,'max':1000});
				break;
			case '5000':
					$('#price2').val(1000);
					$('#price2').attr({'step':100,'min':1000,'max':5000});
				break;
			case '30000':
				$('#price2').val(5000);
				$('#price2').attr({'step':200,'min':5000,'max':30000});
				break;
			default:
				break;
		}
	}

	wx.hideAllNonBaseMenuItem();

	function product(id) {
		wx.openProductSpecificView({
		productId: id, // 商品id
		viewType: 0 // 0.默认值，普通商品详情页1.扫一扫商品详情页2.小店商品详情页
		});
	}


	</script>
	@endsection

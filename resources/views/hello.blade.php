@extends("layout")
@section("content")
<section id="status1" data-role='page'>	
	<div data-role="header" >
		<h1>已上架管理</h1>
	</div><!-- /header -->
	<ul data-role="listview" id="list1" class="products"  data-split-icon="gear" data-inset="true" data-filter="true" data-filter-placeholder = "查找"></ul>
	<div data-role="popup" id="popup1" data-theme="a" data-overlay-theme="b" class="ui-content" style="width:280px; padding-bottom:2em;">
    	<a href="" title="" data-rel="back" class=" ui-btn ui-btn-a ui-corner-all " id="delete" style="background: red;color:white" key="">删除</a>
    	<br>
		<select name="level" id = "level1" onchange="select1(this.value)">
			<option value="1000" >千元档</option>
			<option value="5000" >五千档</option>
			<option value="10000" >万元档</option>
		</select>
	    <label for="price1" class="ui-hidden-accessible">价:</label><input type="range" name="price" id="price1" value="" min="0" max="100" step="" data-highlight="true" data-popup-enable="true" >
	    
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
			<label for="name2" class="ui-hidden-accessible"></label><input type="text" name="name" id="name" value="" data-clear-btn="true" placeholder="名" >
			<br>
			<select name="level" id = "level2" onchange="select2(this.value)">
				<option value="1000" >千元档</option>
				<option value="5000" >五千档</option>
				<option value="10000" >万元档</option>
			</select>
		    <label for="price2" class="ui-hidden-accessible">价:</label><input type="range" name="price" id="price2" value="" min="0" max="100" step="" data-highlight="true" data-popup-enable="true" >

		    <br>
			<label for="material" class="select" data-inline='true'>料:</label>
			<select id="material" name="material" key="{{$material['id']}}" class='select' data-inline='true' >
			@foreach($material['property_value'] as $p)
				<option value="{{$p['id']}}">{{$p['name']}}</option>
			@endforeach
			</select>
			<fieldset data-role = "controlgroup" data-type="horizontal" >
				<legend >属性:</legend>
				<label for="usage" class="select" data-inline='true'>适用场景</label>
				<select id="usage" name="usage" key="{{$usage['id']}}" class='select' data-inline='true' >
				@foreach($usage['property_value'] as $p)
					<option value="{{$p['id']}}">{{$p['name']}}</option>
				@endforeach
				</select>
				<label for="style" class="select" data-inline='true'>款式</label>
				<select id="style" name="style" key="{{$style['id']}}"  class='select' data-inline='true' >
				@foreach($style['property_value'] as $p)
					<option value="{{$p['id']}}">{{$p['name']}}</option>
				@endforeach
				</select>
			</fieldset>
			<br>
			<fieldset class="ui-grid-a">
				<div class="ui-block-a"><a href="" data-rel="back" class="ui-shadow ui-btn  ui-btn-a ui-corner-all  "  key="" id="submit2">上架</a></div>
				<div class="ui-block-b"><a href="" data-rel="back" class="ui-shadow ui-btn ui-btn-b ui-corner-all ">取消</a></div>
			</fieldset>
		</form>
	</div>
</section><!-- /page -->

<section id="admin" data-role="page">

</section>


<footer data-role="footer" data-position="fixed">
	<div data-role="navbar">
		<ul>
			<li>	<a href="#status1" class="" data-icon="check">上架</a></li>
			<li>	<a href="#status2" class="" data-icon="carat-d">未上架</a></li>
			<li>	<a href="#admin" class="" data-icon="bullets">管理</a></li>
		</ul>
	</div>
</footer><!-- /footer -->





<script type="text/javascript" charset="utf-8" async defer>
$(function(){
	$( "[data-role='header'], [data-role='footer']" ).toolbar();
	$( "[data-role='header'], [data-role='footer']" ).toolbar({ theme: "b" });
});

	var data = [];

//根据id设置popup中form默认值

	//已上架商品
	$('#submit1').on("click",function() {
		var key = $(this).attr("key");
		post = data.status1[key];
		post.sku_list[0].price=$('#price1').val()*100;

		$("#status1 [key='"+key+"'] p").html('￥'+$('#price1').val());
		$.post('',
			post ,
			function(data) {
				console.log(data);
			}
		);
	});
	//未上架商品
	$('#submit2').on("click",function() {
		var key = $(this).attr("key");
		post = data.status2[key];
		post.product_base.name=$('#name').val();
		post.sku_list[0].price=$('#price2').val()*100;

		post.product_base.property = 
		[
			{
				"id": '{{$material['id']}}',
				"vid": $('#material').val(),
			},
			{
				"id": '{{$style['id']}}',
				"vid": $('#style').val(),
			},
			{
				"id": '{{$usage['id']}}',
				"vid": $('#usage').val(),
			}
		];		

		$("#status2 [key='"+key+"'] h2").html($('#name').val());
		$("#status2 [key='"+key+"'] p").html('￥'+$('#price2').val());
		$.post('',
			post ,
			function(data) {
				console.log(data);
			}
		);
	});
	//删除商品
	$('#delete').on("click",function() {
		var key = $(this).attr("key");
		post ={'product_id':data.status1[key].product_id};
		$("#status1 li[key='"+key+"']").remove();
		$.post('delete',
				post,
				function(data) {
					console.log(data);
				}
			)
	});

	function select1(val) {
		console.log(val);
		switch (val) {
			case '1000':
				$('#price1').val(0);
				$('#price1').attr({'step':20,'min':0,'max':1000});
				break;
			case '5000':
					$('#price1').val(1000);
					$('#price1').attr({'step':100,'min':1000,'max':5000});
				break;
			case '10000':
				$('#price1').val(5000);
				$('#price1').attr({'step':200,'min':5000,'max':10000});
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
			case '10000':
				$('#price2').val(5000);
				$('#price2').attr({'step':200,'min':5000,'max':10000});
				break;
			default:
				break;
		}
	}

	$.get(
		'group',
		function(d) {
			data = d;
			var html2 = "";
			var html1 = "";

			data.status1.forEach( 
				function(e, i) {
					e['product_base']['main_img'] = e['product_base']['main_img'].replace(/https/,'http');
					e['product_base']['img'] = e['product_base']['img'].map(function(e){e.replace(/https/,'http')});
					html1 +=
					`
					<li key="${i}"><a href="#">
					<img src="${e['product_base']['main_img']}" alt="">
					<h2>${e['product_base']['name']}</h2>
					<p>￥${e['sku_list'][0]['price']/100}</p>
					<a href="#popup1" class="pop1" key='${i}' data-rel="popup" data-position-to="window" data-transition="pop">Purchase album</a>
					</a></li>
					`;
				}
			);
			$('#list1').html(html1);
			$('#list1').listview("refresh");

			data.status2.forEach( 
				function(e, i) {
					e['product_base']['main_img'] = e['product_base']['main_img'].replace(/https/,'http');
					e['product_base']['img'] = e['product_base']['img'].map(function(e){e.replace(/https/,'http')});
					html2 +=
					`
					<li key="${i}"><a href="#">
					<img src="${e['product_base']['main_img']}" alt="">
					<h2>${e['product_base']['name']}</h2>
					<p>￥${e['sku_list'][0]['price']/100}</p>
					<a href="#popup2" class="pop2" key='${i}' data-rel="popup" data-position-to="window" data-transition="pop">Purchase album</a>
					</a></li>
					`;
				}
			);
			$('#list2').html(html2);

			$('.pop1').on('click',function() {
				var i = $(this).attr('key');
				$('#name1').val(data.status1[i].product_base.name);
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
				} else if($price<=10000) {
					$('#level1').val('10000');
					$('#price1').attr({'step':200,'min':5000,'max':10000});
					$('#level1').prev().html('万元档');
				}
				$('#price1').val($price);
				$("#delete").attr('key',i);
				$('#submit1').attr('key',i);
			});
			$('.pop2').on('click',function() {
				var i = $(this).attr('key');
				$('#name2').val(data.status2[i].product_base.name);
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
				} else if($price<=10000) {
					$('#level2').val('10000');
					$('#price2').attr({'step':200,'min':5000,'max':10000});
					$('#level2').prev().html('万元档');
				}
				$('#price2').val($price);
				$('#submit2').attr('key',i);
			});
		}
	);

	</script>
	@endsection

<!DOCTYPE HTML>

<html>
	<head>
		<title>福临璟苑</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<meta name="referrer" content="never">

		<link rel="shortcut icon"  href="../images/logo-sm.jpg" >
		
		<link rel="stylesheet" href="../css/main.css" />
		<script src="http://res.wx.qq.com/open/js/jweixin-1.4.0.js" type="text/javascript" charset="utf-8"></script>
		<!-- <link rel="stylesheet" href="assets/css/icon.css" /> -->

	</head>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Main -->
					<div id="main">
						<div class="inner">

							<!-- Header -->
								<header id="header">
									<a href="index.html" class="logo">福临<strong>璟苑</strong></a>
									<ul class="icons">

									</lu>
								</header>



							<!-- Section -->
								<section>
									<header class="major">
										<h2>Ipsum sed dolor</h2>
									</header>
									<div class="posts" id="products">
										<article>
											<a href="#" class="image"><img src="../images/logo.jpg" alt="" /></a>
											<h3>圆荷泻露</h3>
											<p>索拉卡倒计时了肯定</p>
											<ul class="actions">
												<li><a href="#" class="button">￥1235</a> <span class="original">￥654</span></li>
											</ul>
										</article>
										<article>
											<a href="#" class="image"><img src="images/pic02.jpg" alt="" /></a>
											<h3>Nulla amet dolore</h3>
											<p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore. Proin aliquam facilisis ante interdum. Sed nulla amet lorem feugiat tempus aliquam.</p>
											<ul class="actions">
												<li><a href="#" class="button">More</a></li>
											</ul>
										</article>
	
									</div>
								</section>

						</div>
					</div>

				<!-- Sidebar -->
					<div id="sidebar">
						<div class="inner">

							<!-- Search -->
							<!-- 	<section id="search" class="alt">
									<form method="post" action="#">
										<input type="text" name="query" id="query" placeholder="Search" />
									</form>
								</section> -->

							<!-- Menu -->
								<nav id="menu">
									<header class="major">
										<h2>曲径通幽</h2>
									</header>
									<ul>
										<li><a href="index.html">主页</a></li>
										<li><a href="https://mp.weixin.qq.com/mp/homepage?__biz=MzI1MDc0NjgzOQ==&hid=1&sn=19e41903812445e4137fbd46965f4652">文集</a></li>
										<li>
											<span class="opener">资讯</span>
											<ul>
											</ul>
										</li>
									</ul>
								</nav>

							<!-- Section -->
		<!-- 						<section>
									<header class="major">
										<h2>Ante interdum</h2>
									</header>
									<div class="mini-posts">
										<article>
											<a href="#" class="image"><img src="images/pic07.jpg" alt="" /></a>
											<p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore aliquam.</p>
										</article>
									<ul class="actions">
										<li><a href="#" class="button">More</a></li>
									</ul>
								</section> -->

							<!-- Section -->
								<section>
									<header class="major">
										<h2>千里相会</h2>
									</header>
									<p>福临璟苑 欢迎贵客光临，有任何求可以联系我们。 <br><br>
										同时我们对外开放多方向合作，有意向请致电给我们。我们将会立即回复您。</p>
									<ul class="contact">
										<li class="icon iconfont icon-xiangyun"><img src="../images/公众号指纹.jpg" alt="" width="100"></li>
										<li class="icon iconfont icon-lianxi">137-6797-2574</li>
										<li class="icon iconfont icon-guwancheng"><a href="https://map.baidu.com/poi/%E7%A6%8F%E4%B8%B4%E7%92%9F%E8%8B%91/@12903304.55,3316567.29,12z?uid=4784889a4efb62ac2102205c&primaryUid=4784889a4efb62ac2102205c&ugc_type=3&ugc_ver=1&device_ratio=2&compat=1&querytype=detailConInfo&da_src=shareurl" title="">站前西路121号福临璟苑<br />
										江西省 南昌市</a></li>
									</ul>
								</section>



						</div>
					</div>

			</div>
			<link rel="stylesheet" type="text/css" href="../css/fontawesome-all.min.css">

		<!-- Scripts -->
			<script src="https://cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
			<script src="../js/browser.min.js"></script>
			<script src="../js/breakpoints.min.js"></script>
			<script src="../js/util.js"></script>
			<script src="../js/main.js"></script>
			<script>
				var products;
				$.get(
					'../test',
					function(data) {
						products = data;
						var html = '';
						for (var i = 0; i <20; i++) {
								products[i]['product_base']['main_img'] = products[i]['product_base']['main_img'].replace(/^https/,'http').replace(/\?wx_fmt=jpeg$/,'');
								html += 
								`
									<article>
										<a href="#" class="image"><img src="${products[i]['product_base']['main_img']}" alt="" /></a>
										<h3>${products[i]['product_base']['name']}</h3>
										<p>索拉卡倒计时了肯定</p>
										<ul class="actions">
											<li><a href="#" class="button" key="${i}">￥${products[i]['sku_list'][0]['price']/100}</a> <span class="original">￥654</span></li>
										</ul>
									</article>			
								` ;
							}
							$('#products').append(html);
					}
				);

			</script>

	</body>
</html>
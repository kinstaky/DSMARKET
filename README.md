# 小恐龙二手市场

蒲伟良 1600011338

## E-R关系图

![ER](D:\Code\DSMARKET\img\ER.png)

## 关系模式表

+  superadmin(<u>sid</u>, name, password)
+ admin(<u>aid</u>, name, password)
+ customer(<u>uid</u>, name, password, birthday, sex, phone, Email, status)
+ goods(<u>gid</u>, name, type, description, price, status, *sid*, time)
+ carts(<u>cid</u>, *gid*, *uid*)
+ buy(<u>bid</u>, *gid*, *uid*, time, price)
+ comments(<u>cid</u>, *gid*, *uid*, time, stars, comment)

## 设计思路

二手市场主要是两部分组成，一部分是用户管理，一部分是商品管理。

用户管理的主要代码都在`usr`文件夹中。用户加上管理员有三个级别

+ 超级管理员
+ 管理员
+ 普通用户

超级管理员主要是管理管理员，我称之为`superadmin`，在整个系统中只有一个（通过check(主码=1)保证），不能在所给的接口中创建，不能修改密码，只能通过在Mysql的服务器中插入信息来创建。超级管理员的功能有：

+ 创建和删除管理员账号
+ 其他管理员有的功能

管理员可以管理用户，管理商品，主要功能有：

+ 修改自己账号的密码
+ 查看所有普通用户的信息

+ 用户申请成为卖家时审核，或者将卖家降级为纯粹的买家
+ 冻结或者解冻用户账号，删除用户账号
+ 查看所有的商品，包括已经出售的，退货的
+ 强行冻结商品使其下架，也可以解冻商品，更可以删除商品
+ 查看所有的交易
+ 用户申请退货，但是卖家拒绝，管理员决定是否退货
+ 其他普通用户也有的浏览商品的功能，但不能交易

刚进入网站，身份为游客，其功能有：

+ 浏览商品，搜索商品
+ 登录
+ 注册

注册账号后可以使用该账号登录，登录后即为普通用户，主要功能：

+ 修改个人信息，修改密码
+ 申请成为买家

+ 浏览商品，搜索商品
+ 查看商品详细信息（点击商品）
+ 将商品放入购物车
+ 结算，购买商品
+ 对已购买（包括退货）的商品发表评论
+ 对已购买的商品进行退货

成为卖家后有更多的功能：

+ 所有非卖家的功能

+ 添加商品，修改商品信息
+ 买家申请退货时可以同意或拒绝

所有账号信息存储在三个表中，`superadmin`,`admin`和`customer`，登录时服务器查询三个表，找到匹配的密码和昵称后登录成功，通过session记录登录信息，包括昵称，ID和权限，登出后擦除账户信息。所有的功能都写成接口在网页上呈现，用户操作会触发相应的事件，跳转到相应的页面。

商品管理主要在`goods`文件夹中，数据库中的表`goods`记录了商品的基本信息，其中商品中有状态`status`，分辨其是否卖出，冻结，退货，其中冻结状态有多种，主要是为了区分卖家的冻结和管理员的冻结，退货状态也有多种，用于分辨不同的进程。

当用户将商品放入购物车时，会在`carts`中添加记录，购买商品时，在`buy`中添加记录，用户发表评论后，将在`comments`表中添加记录。

以上为数据库中所有表的用途。文档中除了`usr`和`goods`还包含三个模块，`database`，`files`和`div`

`database`用于和数据库连接，封装了所有修改数据库的函数接口，其中的`init`文件夹用于创建所有的表，添加一条超级管理员的信息，并创建两个触发器。`freeze_trigger`触发器在用户被管理员冻结、解冻时触发， 将自动冻结、解冻相应的商品，当然，用户自己冻结的商品无法解冻。`pay_trigger`在用户购买商品时触发，即在想`buy`表中写入交易信息前，删除该用户购物车中的信息并将商品状态设置为已出售，避免其他人重复购买。

`files`中有生成XML文件的程序，主要是我不知道如何同时兼容我现有的UI设计和XML，所以单独提出来，需要的时候点击浏览商品页面的`show XML`按钮，将打开新的标签页并自动生成对应的XML文件。`files`中还有图片文件，对应商品的图片描述，但是提交的文档将没有图片，因为太大了。

`div`主要是一些前端显示的文件，包括顶部菜单，搜索栏，商品浏览界面。顶部菜单是几乎所有功能的入口，包括登录登出，管理商品，购物车等，有些按钮做了信息提示，比如购物车，将在按钮旁边括号中显示购物车中商品的数量。搜索主要靠sql中的like语句，搜索关键词前后都可以有任意个任意字符的商品名称和类型名称。

## 文档结构

|  data.txt												 数据库数据，使用mysqldump自动生成
│  index.php											主页
│  README.md									    说明文档，本文件
│
├─database											 数据库相关文件夹
│  │  connect_db.php							 连接数据库，封装了select，update，delete等函数
│  │
│  └─init													初始化数据库，create所有表，还有两个trigger
│          create_admin.php					  create `admin` 关系表
│          create_buy.php						   create `buy` 关系表
│          create_cart.php						  create `cart` 关系表
│          create_comment.php                create `comment` 关系表
│          create_customer.php			    create `customer` 关系表
│          create_good.php					    create `good` 关系表
|          create_good_image.php		    create `good_image`关系表
│          create_superadmin.php		    create `superadmin` 关系表
│          freeze_trigger.php	                  create `freeze_trigger`触发器，
|															    当用户被冻结、解冻时其发布的商品相应变化
│          pay_trigger.php					      create `pay_trigger`触发器，购买商品后，从购买者购物车中
|															     删除该商品，设置商品的状态为已出售
│																 
├─div													 浏览器显示的版块
│      search_menu.php               		 搜索框和logo，显示XML文档（HTML）
│      top_menu.php							 顶部菜单，几乎所有主要功能的链接（HTML）
│      view_goods.php						   浏览货物（HTML）
│
├─files
│      show.xml									   动态生成的XML文档
│      show_XML.php						     动态生成XML文档的程序
|
├─goods												管理商品
│      add_comment.php					  向数据库中`comments`表中添加评论
│      add_good.php							  向数据库中`goods`表中添加商品
│      add_in_cart.php						   向数据库中`carts`表中添加购物车关系
│      buy_management.php				买家管理已买商品页面，可以评论和退货（HTML）
│      cart_management.php				买家管理购物车，可以结账（HTML）
│      delete_cart.php							删除数据库`cart`表中的数据，响应买家将商品移出购物车
│      delete_good.php						  删除数据库`goods`中的数据，响应卖家或管理员删除商品
│      edit_good.php							  更新数据库`goods`表中的数据，响应卖家修改商品信息
│      edit_good_info.php					 卖家修改商品信息的页面（HTML）
│      freeze_good.php						  更新数据库中`goods`表中的状态信息，响应商品冻结、解冻
│      good_info.php							  展示单个商品的信息（HTML）
│      good_management.php			 管理员管理所有的商品的页面，可进行删除，冻结操作（HTML）
│      new_comment.php					 添加评论页面（HTML）
│      new_good.php							 添加商品页面（HTML）
│      pay.php										 向数据库`buy`表中插入数据，响应购买操作
│      return_good.php						 更新数据库`good`中信息，响应退货操作				 
|       return_mangement.php			管理员查看退货信息的页面，响应退货判定（HTML）
│      sell_management.php				卖家管理发布的商品（HTML）
|
│
└─usr													管理账号
        add_customer.php					 向数据库中`customer`表中添加用户
        admin_management.php		  超级管理员查看管理员的页面（HTML）
        apply_seller.php						  更新数据库中`customer`的状态，响应申请成为卖家的操作
        change_pwd.php						 更新数据库中`customer`的密码，响应更改密码操作（超级管理员不可用）
        check_seller.php						  管理员查看用户申请成为卖家的页面，可进行通过审核操作（HTML）
        check_usr.php							  核对账号和密码，用于登录
        delete_admin.php					   删除数据库中`admin`表中的数据，响应超级管理员删除管理员你的操作
        delete_usr.php							 删除数据库中`customer`中的数据，响应管理员删除用户的操作
        edit_customer.php					 更新数据库中`customer`的信息，响应用户修改个人信息
        edit_info.php								用户修改个人信息的页面（HTML）
        freeze_usr.php							 更新数据库中`customer`的状态，响应管理员冻结用户账号的操作
        new_admin.php						  超级管理员创建管理员的页面（HTML）
        passwords.txt							  不同用户的账号和密码，仅用于方便个人记忆
        personal_info.php					  展示个人信息的页面（HTML）
        sign_in.php								  登录页面（HTML）
        sign_out.php							   响应注销操作
        sign_up.php								 注册页面（HTML）
        update_seller.php					  更新数据库中`customer`的状态，响应管理员审核通过卖家申请
        usr_management.php			  管理员管理所有普通用户的页面，可进行封号删号（HTML）

上面标注了（HTML）的表示可以当成html文件，只不过我这里命名为.php



## 特别的SQL查询

`tuhao.sql`查询土豪买家，思路为找到交易总金额等于最大总金额的人。

`hotseller.sql`查询热门卖家，先查找评论总数和卖家总数，相除得到平均数，查找评论大于这个平均数的

`show_order_goods.sql`排序展示商品，`order`排序

`buyer_age.sql`查询卖家受众，先划分老中青三组，并统计每组每个卖家的人数，最后对卖家分组，找到每个卖家受众最多的一组

`same_seller.sql`查询相似买家，这里查找的是和ID为6的买家有相似买家的买家，思路为在所有买家中查找，排除ID为6，排除有和ID为6的买家没有交易过的卖家交易的买家，再排除ID为6的买家交易过但是和自己交易过的买家。
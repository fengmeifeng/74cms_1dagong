[toc]

# 生活很忙接口文档(hurrylife-api)

返回码说明
```
{
	code://返回代号：0成功；其它 失败
	message://提示信息
	data://接口需求的具体数据
}
```

## 登录注册相关接口

### 获取短信验证码

**接口地址** 
`GET`   `/auth/smscode`
> eg.     http://120.26.62.247/api/auth/smscode

**请求参数**   
参数|数据类型|必填|参数说明
---|-------|----|-----
mobile	|string	|<i class="fa fa-check"></i>|接收短信的手机号码

**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
502|与短信接口通讯异常|短信验证码发送失败

**响应结果:**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data": "aba25484-c9db-403c-810d-5da308fe48aa" //短信验证码token值
}
```

### 用户注册（完成 ZWL）

**接口地址** 
`GET`   `WEBSITE/interface/reg.php`

**请求参数:**  
|参数|数据类型|必填|参数说明|   
|-|-|-|-|
|username|String|<i class="fa fa-check"></i>|手机号|
|androidkey|String|<i class="fa fa-check"></i>|接口验证码|
|member_type|String|<i class="fa fa-check"></i>|会员类型|

**运行时异常**
code| 错误原因  |返回消息

-----|---------|----
-1|会员类型错误
-2|用户名已经存在 

**返回参数:**
```javascript
{
	$result['result']:1, //1-表示成功 其它表示失败
	$result['errormsg']: null,
	$result['data']: 
}
```



###用户登录（完成 ZWL）

**接口地址** 
`GET`   `WEBSITE/interface/login.php`

**请求参数**  
|参数|数据类型|必填|参数说明|   
|-|-|-|-|
|username|String|<i class="fa fa-check"></i>|用户名 - 手机号|
|userpwd|String|<i class="fa fa-exclamation">1</i>|密码|
|androidkey|String|<i class="fa fa-exclamation">2</i>|接口验证码|

**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
1|登录成功
0|用户名或密码错误

**返回参数**  
```javascript
{
	$result['result']:1, //0-表示成功 其它表示失败
	$result['errormsg']: null,
	$result['data']
}
```


###忘记密码

**接口地址** 
`POST`   `/auth/passwd`

**请求参数**  
|参数|数据类型|必填|参数说明|   
|-|-|-|-|
|mobile|String|<i class="fa fa-check"></i>|手机号|
|password|String|<i class="fa fa-check"></i>|密码|
|smscode|String|<i class="fa fa-check"></i>|验证码|
|token|String|<i class="fa fa-check"></i>|验证码唯一票据|

**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
404|手机号码不存在|用户不存在
424|验证码错误|验证码错误
403|用户被禁用|帐号被禁用

**返回参数**  
```javascript
{
	code:0, //0-表示成功 其它表示失败
	message: null,
	data: CustomerInfo
}
```
[另请参考`CustomerInfo` 说明](#customerinfo)


## 个人中心（完成ZWL）
**接口地址** 
`GET` `WEISITE/interface/person/personal_index.php`

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|androidkey|varchar||接口验证码|
|uid|[`lordJson`](#lordjson)||用户ID|
**响应结果**
```javascript
{
	$result['result']: 1, //1 - 接口调用成功，其他值表示失败
	$result['errormsg']: null,
	$result[0]:已申请职位
	$result[1]:面试邀请
	$result[2]:关注
}
```
### 土豪请客送出列表
**接口地址**
`GET` `/profile/lord/send`
> eg.http://120.26.62.247/api/profile/lord/send

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|principal|int|<i class="fa fa-check"></i>|当前登录用户ID|

**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
401|未传入操作人ID|您需要重新登录才能继续操作哦~
404|用户不存在|系统繁忙，请稍候再试……

**响应结果:**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":[
		{
			id          :   129,            //请客单ID
			commodityId :   1,             //商品ID
			commodityName:   "三杯鸡套餐",   //商品名称 
			price       :   10.5,           //商品单价
			count       :   6,              //请客份数
			fee         :   90.5,           //总花费
			shopId      :   10041,          //商品所在店铺ID
			shopName    :   "聚食惠餐厅",   //商品所在店铺名称
			createTime  :   "2015-01-27 10:50",//请客时间
			share       :   "http://share.hurrylife.com/Xdw9Y8dE",//请客链接
			received    :   3,               //已被领取份数
			customerId  :   3,               //土豪id
			system      :   3,               //1-美食外卖 2-生鲜百货
			circleId    :   3,               //商圈ID
			payed:true//支付状态
		},
		...
	]
}
```

#### 土豪请客送出列表-详情（被领取列表）
**接口地址**
`GET` `/profile/lord/send/{id}`
> eg.http://120.26.62.247/api/profile/lord/send/2

**路径参数**
`id` `int` 请客单ID

**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
404|请客单ID不存在|系统繁忙，请稍候再试……

**响应结果:**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":[
        "138****1245",
        "138****1245",
        "138****1245",
        "138****1245",
        ...
	]
}
```

#### 土豪请客送出列表-删除
**接口地址**
`GET` `/profile/lord/send/remove`

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|id|int|<i class="fa fa-check"></i>|请客单ID|

**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
404|请客单ID不存在|系统繁忙，请稍候再试……

**响应结果**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":null
}
```

### 土豪请客接收列表
**接口地址**
`GET` `/profile/lord/receive`

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|principal|int|<i class="fa fa-check"></i>|当前登录用户ID|

**运行时异常**
code| 错误原因  |返回消息
401|未传入操作人ID|您需要重新登录才能继续操作哦~
404|用户不存在|系统繁忙，请稍候再试……

**响应结果:**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":[
		{
			id          :   129,            //请客接收单ID
			lordId      :   4,            //土豪请客ID
			customerId  :   4,            //被请客用户id
			initiator   :   "139****1111",  //发起者
			commodityId :   4,             //商品ID 
			commodityName:   "三杯鸡套餐",   //商品名称 
			fee         :   90.5,           //总花费
			circleId    :   3,              //商圈ID
			shopId      :   10041,          //商品所在店铺ID
			shopName    :   "聚食惠餐厅",   //商品所在店铺名称
			createTime  :   "2015-01-27 10:50",//请客时间
			used        :   false,           //true - 已使用 | false - 未使用
            system      :   1               //子系统标识 `1`-美食外卖 `2`-生鲜百货 `3`-干洗护理 `4`-同城微商
		},
		...
	]
}
```

#### 土豪请客接收列表-使用(确认订单)

与`确认订单`类似，返回的配送地址、送达时间信息是系统推荐的值。

* 若当前登陆用户在请客的商圈内没有合适的配送地址，则返回的配送地址为`null`。
* 若配送费为`0`，则支付方式不可点击。

**接口地址**
`GET` `/profile/lord/receive/use`

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|principal|int|<i class="fa fa-check"></i>|当前登录用户ID|
|id|int|<i class="fa fa-check"></i>|请客接收单ID|



**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
401|未传入操作人ID|您需要重新登录才能继续操作哦~
404|用户不存在|系统繁忙，请稍候再试……
404|请客接收单ID|系统繁忙，请稍候再试……

**响应结果**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":{
			id          :   129,            //请客接收单ID
			lordId      :   4,            //土豪请客ID
			customerId  :   4,            //被请客用户id
			initiator   :   "139****1111",  //发起者
			commodityId :   4,             //商品ID 
			commodityName:   "三杯鸡套餐",   //商品名称 
			fee         :   90.5,           //总花费
			circleId    :   3,              //商圈ID
			shopId      :   10041,          //商品所在店铺ID
			shopName    :   "聚食惠餐厅",   //商品所在店铺名称
			createTime  :   "2015-01-27 10:50",//请客时间
			used        :   false,           //true - 已使用 | false - 未使用
            system      :   1               //子系统标识 `1`-美食外卖 `2`-生鲜百货 `3`-干洗护理 `4`-同城微商
		}
}
```

#### 土豪请客接收列表-删除
**接口地址**
`POST` `/profile/lord/receive/remove`

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|id|int|<i class="fa fa-check"></i>|请客接收单ID|

**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
404|请客单ID不存在|系统繁忙，请稍候再试……

**响应结果**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":null
}
```

### 我的积分

**接口地址** 
`GET`   `/profile/score`
> eg.http://120.26.62.247/api/profile/score

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|principal|int|<i class="fa fa-check"></i>|当前登录用户ID|

**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
401|未传入操作人ID|您需要重新登录才能继续操作哦~
404|用户不存在|系统繁忙，请稍候再试……

**响应结果:**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":1003 //用户当前积分
}
```

#### 积分商城列表

**接口地址** 
`GET`   `/profile/scoremall/exchange`
> eg.http://120.26.62.247/api/profile/scoremall/exchange

**响应结果:**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":[{
    			id:1,               //兑换物品ID
    			name:"5元抵用券",    //兑换物品名称
    			valid:1,            //有效期  单位天
    			value:1,            //券值
    			condition:100,        //条件 满xx元可用
    			score:10            //兑换所需积分
    		},
    		...
    	]
    
}
```

#### 积分商城物品兑换

**接口地址** 
`POST`   `/profile/scoremall/exchange/{id}`
> eg.http://120.26.62.247/api/profile/scoremall/exchange/1?principal=1

**路径参数**
`id` `int` 要兑换的物品ID

**请求参数:**  
参数|数据类型|必填|参数说明
---|-------|----|-----
principal|int|<i class="fa fa-check"></i>|当前登录用户ID
num|int|<i class="fa fa-check"></i>|兑换的数量

**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
412|积分余额不足|对不起，您的积分余额不足！
401|未传入操作人ID|您需要重新登录才能继续操作哦~
404|用户不存在|系统繁忙，请稍候再试……

**响应结果:**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":null
}
```
####批量兑换抵用券

**接口地址** 
`POST`   `/profile/scoremall/exchange`

**请求参数:**  
参数|数据类型|必填|参数说明
---|-------|----|-----
principal|int|<i class="fa fa-check"></i>|当前登录用户ID
|departmentOrder|[`DepartmentOrder` ](#departmentorder)||订单信息|
cardJson|String|[`cardJson` ](#cardjson)|抵用券json

**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
412|积分余额不足|对不起，您的积分余额不足！
401|未传入操作人ID|您需要重新登录才能继续操作哦~
404|用户不存在|系统繁忙，请稍候再试……

**响应结果:**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":null
}
```
#### 积分记录

**接口地址** 
`GET`   `/profile/score/record`
> eg.http://120.26.62.247/api/profile/score/history

**响应结果:**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":[
		{
			id:1,
			score:80,
			type:1,//1获得 2消费
			description:"订单完成获得40积分",   //积分记录说明文字
			createTime:"2015-02-28"            //积分变动时间
		},
		...
	]
}
```

#### 积分规则

**接口地址** 
`GET`   `/profile/score/rule`
> eg.http://120.26.62.247/api/profile/score/rule

**响应结果**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":"<html>...</html>"
}
```


### 我的抵用券

**接口地址** 
`GET`   `/profile/cash`
> eg.http://120.26.62.247/api/profile/cash

**请求参数**  
参数|数据类型|必填|参数说明
----|--------|----|-----
principal|int|<i class="fa fa-check"></i>|当前登录用户ID

**运行时异常**
code| 错误原因  |返回消息
----|-----------|----
401|未传入操作人ID|您需要重新登录才能继续操作哦~
404|用户不存在|系统繁忙，请稍候再试……

**响应结果**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":[ //抵用券
		{
			id:2,  //抵用券ID
			value:5,//抵用券面值，￥5
			cardno:"xxxxxxx", //券号
			condition:100,//条件，￥5
			enable:true,    //是否有效， false 表示已过期
			endTime:"2015-08-30"    //有效期
		},
		...
	]
}
```

#### 输入抵用券

**接口地址** 
`POST`   `/profile/cash`
> eg.http://120.26.62.247/api/profile/cash

**请求参数**  
参数|数据类型|必填|参数说明
----|--------|----|-----
principal|int|<i class="fa fa-check"></i>|当前登录用户ID
cardno|string|<i class="fa fa-check"></i>|抵用券号码

**运行时异常**
code| 错误原因  |返回消息
----|-----------|----
401|未传入操作人ID|您需要重新登录才能继续操作哦~
404|用户不存在|系统繁忙，请稍候再试……
504|不存在的抵用券|不存在的抵用券
604|该抵用券已被使用|该抵用券已被使用

**响应结果**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":null
}
```

### 我的收藏-商家

**接口地址** 
`GET`   `/profile/collect/shop`
> eg.http://120.26.62.247/api/profile/collect/shop?principal=1

**请求参数**  
参数|数据类型|必填|参数说明
----|--------|----|-----
principal|int|<i class="fa fa-check"></i>|当前登录用户ID

**运行时异常**
code| 错误原因  |返回消息
----|-----------|----
401|未传入操作人ID|您需要重新登录才能继续操作哦~
404|用户不存在|系统繁忙，请稍候再试……

**响应结果**
```javascript
{
	code: 0, //0 - 接口调用成功，其他值表示失败
	message: null,
	data:[ //
		{
			id:2,  //商家ID
			name:"聚食惠",//
			categoryName:"中餐",//分类
			icon:"http://www.sd/asd/1"//图标
			notice:"30元起送 5元配送费",//商家信息
			star:5,//星级
			collectId:20//收藏ID
		},
		...
	]
}
```
### 我的收藏-商品

**接口地址** 
`GET`   `/profile/collect/commodity`
> eg.http://120.26.62.247/api/profile/collect/commodity?principal=1

**请求参数**  
参数|数据类型|必填|参数说明
----|--------|----|-----
principal|int|<i class="fa fa-check"></i>|当前登录用户ID

**运行时异常**
code| 错误原因  |返回消息
----|-----------|----
401|未传入操作人ID|您需要重新登录才能继续操作哦~
404|用户不存在|系统繁忙，请稍候再试……

**响应结果**
```javascript
{
	code: 0, //0 - 接口调用成功，其他值表示失败
	message: null,
	data:[ //
		{
			id:2,  //商品ID
			name:"聚食惠",//
			icon:"http://www.sd/asd/1"//图标
			sold:21,//已售量
			price:20,//价格
			restaurantId:21,//餐厅ID
			collectId:21,//收藏ID
		},
		...
	]
}
```
###取消收藏

**接口地址** 
`POST`   `/profile/collect/delete`

**请求参数**  
|参数|数据类型|必填|参数说明|   
|-|-|-|-|
|collectedId|int|<i class="fa fa-check"></i>|收藏ID|
**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
401|用户不存在|您需要重新登录才能继续操作哦~

**返回参数**  
```javascript
{
	code:0, //0-表示成功 其它表示失败
	message: null,
	data: null
}
```
###发票管理
**接口地址** 
`GET`   `/profile/invoice`
> eg.http://120.26.62.247/api/profile/invoice?principal=1

**请求参数**  
参数|数据类型|必填|参数说明
----|--------|----|-----
principal|int|<i class="fa fa-check"></i>|当前登录用户ID

**运行时异常**
code| 错误原因  |返回消息
----|-----------|----
401|未传入操作人ID|您需要重新登录才能继续操作哦~
404|用户不存在|系统繁忙，请稍候再试……

**响应结果**
```javascript
{
	code: 0, //0 - 接口调用成功，其他值表示失败
	message: null,
	data:[ //
		{
			id:2,  //商品ID
			title:"聚食惠",//
			createTime:"2014-12-12"//时间
		},
		...
	]
}
```
####添加发票抬头

**接口地址** 
`POST`   `/profile/addInvoice`

**请求参数**  
|参数|数据类型|必填|参数说明|   
|-|-|-|-|
|principal|int|<i class="fa fa-check"></i>|当前登录用户ID|
|title|String||发票抬头|
**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
401|用户不存在|您需要重新登录才能继续操作哦~

**返回参数**  
```javascript
{
	code:0, //0-表示成功 其它表示失败
	message: null,
	data: null
}
```
####编辑发票抬头

**接口地址** 
`POST`   `/profile/editInvoice/{id}` //发票抬头id

**请求参数**  
|参数|数据类型|必填|参数说明|   
|-|-|-|-|
|principal|int|<i class="fa fa-check"></i>|当前登录用户ID|
|title|String||发票抬头|
**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
401|用户不存在|您需要重新登录才能继续操作哦~

**返回参数**  
```javascript
{
	code:0, //0-表示成功 其它表示失败
	message: null,
	data: null
}
```
####删除发票抬头

**接口地址** 
`POST`   `/profile/removeInvoice/{id}` //发票抬头id

**请求参数**  
|参数|数据类型|必填|参数说明|   
|-|-|-|-|
|principal|int|<i class="fa fa-check"></i>|当前登录用户ID|
**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
401|用户不存在|您需要重新登录才能继续操作哦~

**返回参数**  
```javascript
{
	code:0, //0-表示成功 其它表示失败
	message: null,
	data: null
}
```
###帮助中心
**接口地址** 
`GET`   `/system/help`
> eg.http://120.26.62.247/api/profile/help


**响应结果**
```javascript
{
	code: 0, //0 - 接口调用成功，其他值表示失败
	message: null,
	data:{
			content:"..."
		}
}
```
###关于
**接口地址** 
`GET`   `/system/aboutus`
> eg.http://120.26.62.247/api/profile/about


**响应结果**
```javascript
{
	code: 0, //0 - 接口调用成功，其他值表示失败
	message: null,
	data:{
			content:"..."
		}
}
```
###意见反馈

**接口地址** 
`POST`   `/profile/feedback`

**请求参数**  
|参数|数据类型|必填|参数说明|   
|-|-|-|-|
|principal|int|<i class="fa fa-check"></i>|当前登录用户ID|
|content|String|<i class="fa fa-check"></i>|反馈内容|
|contact|String|<i class="fa fa-check"></i>|联系方式|
**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
401|用户不存在|您需要重新登录才能继续操作哦~
424|密码错误|密码错误
403|用户被禁用|帐号被禁用

**返回参数**  
```javascript
{
	code:0, //0-表示成功 其它表示失败
	message: null,
	data: null
}
```
###修改密码

**接口地址** 
`POST`   `/profile/passwd`

**请求参数**  
|参数|数据类型|必填|参数说明|   
|-|-|-|-|
|principal|int|<i class="fa fa-check"></i>|当前登录用户ID|
|pwdold|String||原密码|
|pwdnew|String|<i class="fa fa-check"></i>|新密码|
**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
401|用户不存在|您需要重新登录才能继续操作哦~
424|密码错误|密码错误
403|用户被禁用|帐号被禁用

**返回参数**  
```javascript
{
	code:0, //0-表示成功 其它表示失败
	message: null,
	data: null
}
```
### 地址管理
#### 地址管理

**接口地址** 
`GET`   `/profile/address`
> eg.http://120.26.62.247/api/profile/address

**请求参数:**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|principal|int|<i class="fa fa-check"></i>|当前登录用户ID|
|cityId|int|<i class="fa fa-check"></i>|当前城市ID|
**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
401|未传入操作人ID|您需要重新登录才能继续操作哦~

**响应结果:**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":[ //送餐地址
		{
			id:23,  //送餐地址ID, 订餐时传入此参数
			location:"潜山路与东流路交叉口蔚蓝商务港B坐1406",
			name:"萨达姆",
			mobile:"18919601457",
			defaulted:true,//是否本商圈默认地址
			cityId:1,
			cityName:北京市,
			deliveryFee:5//配送费
		},
		...
	]
}
```

#### 新增送餐地址

**接口地址** 
`POST`   `/profile/address/add`

**请求参数:**  
|参数|数据类型|必填|参数说明|   
|-|-|-|-|
|principal|int|<i class="fa fa-check"></i>|当前登录用户ID|
|name|String|<i class="fa fa-check"></i>|收货人姓名|
|mobile|String|<i class="fa fa-check"></i>|手机号|
|cityId|int|<i class="fa fa-check"></i>|城市ID|
|circleId|int|<i class="fa fa-check"></i>|商圈ID|
|location|String||详细地址|

**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
401|未传入操作人ID|您需要重新登录才能继续操作哦~
404|

**返回参数:**
```javascript
{
	code:0, //0-表示成功 其它表示失败
	message: null,
	data: null
}
```
#### 编辑送餐地址

**接口地址** 
`POST`   `/profile/address/edit`

**请求参数:**  
|参数|数据类型|必填|参数说明|   
|-|-|-|-|
|principal|int|<i class="fa fa-check"></i>|当前登录用户ID|
|addressId|int|<i class="fa fa-check"></i>|地址ID|
|name|String|<i class="fa fa-check"></i>|收货人姓名|
|mobile|String|<i class="fa fa-check"></i>|手机号|
|cityId|int|<i class="fa fa-check"></i>|城市ID|
|circleId|int|<i class="fa fa-check"></i>|商圈ID|
|location|String||详细地址|

**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
401|未传入操作人ID|您需要重新登录才能继续操作哦~
404|

**返回参数:**
```javascript
{
	code:0, //0-表示成功 其它表示失败
	message: null,
	data: null
}
```
#### 设置默认地址

**接口地址** 
`POST`   `/profile/address/default`

**请求参数:**  
|参数|数据类型|必填|参数说明|   
|-|-|-|-|
|principal|int|<i class="fa fa-check"></i>|当前用户id|
|addressIdint|<i class="fa fa-check"></i>|地址ID|

**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
401|未传入操作人ID|您需要重新登录才能继续操作哦~
604|不存在的地址|地址不存在|

**返回参数:**
```javascript
{
	code:0, //0-表示成功 其它表示失败
	message: null,
	data: null
}
```
#### 删除地址

**接口地址** 
`POST`   `/profile/address/delete`

**请求参数:**  
|参数|数据类型|必填|参数说明|   
|-|-|-|-|
|id|int|<i class="fa fa-check"></i>|地址ID|

**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
401|未传入操作人ID|您需要重新登录才能继续操作哦~
404|

**返回参数:**
```javascript
{
	code:0, //0-表示成功 其它表示失败
	message: null,
	data: null
}
```
##外卖美食


#### 餐厅分类
**接口地址** 
`GET`   `/food/restaurant/category`
> eg.http://120.26.62.247/api/food/restaurant/category
**请求参数:**  
参数|数据类型|必填|参数说明
---|-------|----|-----

**响应结果:**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":[
    		{
    			id:1,               //分类id
    			categoryName:'中餐'//分类名称
    		},
    		...
    	]
}
```
#### 餐厅列表
**接口地址** 
`GET`   `/food/restaurant`
> eg.http://120.26.62.247/api/food/restaurant
**请求参数:**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|circleId|int|<i class="fa fa-check"></i>|商圈id|
|categoryId|int|<i class="fa fa-check"></i>|餐厅分类id|
|order|int|<i class="fa fa-check"></i>|排序 1-评价 2-销量 0-商家折扣率|
|promotionId|int|优惠标签id|
|start|int|起始|
|size|int|数量|
**响应结果:**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":[
    		{
    			id:1,               //餐厅id
    			name:'Tail餐厅',
    			icon:'....',//餐厅图标
    			circleId:2,//所属商圈
    			categoryName:"西餐", 
    			usedCard:true,//是否可使用抵用券  
    			deliverMoney:500.00,//起送金额  
    			deliverFee:5.00,//同商圈配送金额  
    			commentNum:10            //评价数
    			star:4//评星
    			level:[//等级
					diamond:1,//钻石数
					moon:2,//月亮数
					star:3//星星数
				]
    		},
    		...
    	]
}
```
#### 美食搜索—餐厅

**接口地址** 
`GET`   `/food/search/restaurant`
> eg.http://120.26.62.247/api/food/search/restaurant?keywords=鸿云来
**请求参数:**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|circleId|int|<i class="fa fa-check"></i>|商圈id|
|keywords|string|<i class="fa fa-check"></i>|餐厅关键字|
|order|int|<i class="fa fa-check"></i>|排序 1-评价 2-销量 0-商家折扣率|
|start|int|起始|
|size|int|数量|
**响应结果:**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":[{//同餐厅列表
				id:1,               //餐厅id
    			name:'Tail餐厅',
    			categoryName:"西餐", 
    			usedCard:true,//是否可使用抵用券  
    			commentNum:10            //评价数
    			star:4//评星
    			icon:'....',//餐厅图标
    			level:[//等级
					diamond:1,//钻石数
					moon:2,//月亮数
					star:3//星星数
				]
			},
			...
		]
    			
	
}
```

#### 美食搜索—商品

**接口地址** 
`GET`   `/food/search/commodity`
> eg.http://120.26.62.247/api/food/search/commodity
**请求参数:**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|circleId|int|<i class="fa fa-check"></i>|商圈id|
|keywords|string|<i class="fa fa-check"></i>|商品关键字|
|order|int|<i class="fa fa-check"></i>|排序 1-价格 2-评价 3-销量 |
|start|int|起始|
|size|int|数量|
**响应结果:**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":{
		{
			id:1,
			name:'猪排饭',
			price:28;
			restaurantId:10,
			restaurantName:'Tail餐厅',
			star:4,
			sold:16.
			icon:'...'//商品图片
			level:[//等级
					diamond:1,//钻石数
					moon:2,//月亮数
					star:3//星星数
				]
		},...
	]
}
```
#### 商品分类

**接口地址** 
`GET`   `/food/commodity/category`
> eg.http://120.26.62.247/api/food/commodity/category?id=1
**请求参数:**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|id|int|<i class="fa fa-check"></i>|餐厅id|
**响应结果:**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":[{
			id:1,
			name:'冷菜'
		},
		...
	]
}
```
#### 商品列表

**接口地址** 
`GET`   `/food/commodity`
> eg.http://120.26.62.247/api/food/commodity?restaurantId=1&categoryId=1
**请求参数:**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|restaurantId|int|<i class="fa fa-check"></i>|餐厅id|
|categoryId|int|<i class="fa fa-check"></i>|商品分类id |
|start|int|起始|
|size|int|数量|
**响应结果:**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":{
		{
			id:1,
			name:'猪排饭',
			price:28;
			sold:16.
			icon:'...',//商品图片
			restaurantId:1
		},...
	]
}
```
#### 商家内搜索

**接口地址** 
`GET`   `/food/restaurant/search`
> eg.http://120.26.62.247/api/food/commodity/search
**请求参数:**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|id|int|<i class="fa fa-check"></i>|餐厅id|
|keywords|string|<i class="fa fa-check"></i>|搜索关键字|
|start|int|起始|
|size|int|数量|
**响应结果:**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":{
		{
			id:1,
			name:'猪排饭',
			price:28;
			sold:16.
			icon:'...',//商品图片
			restaurantId:1
		},...
	]
}
```

#### 商品详情

**接口地址** 
`GET`   `/food/commodity/{id}`
> eg.http://120.26.62.247/api/food/commodity/1
**请求参数:**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|principal|int|<i class="fa fa-check"></i>|当前登录用户id|


**路径参数**
`id` `int` 商品ID

**响应结果:**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":{
		{
			id:1,
			name:'猪排饭',
			price:28;
			description:'这是九九八十一道工序精心调制的猪排饭'.//介绍
			icon:'...'//商品图标
			image;['...',...];//商品图片
			collected:true,//是否收藏
			collectId:2,//收藏ID
			sold:3//
		},...
	]
}
```
#### 商家详情

**接口地址** 
`GET`   `/food/restaurant/{id}`
> eg.http://120.26.62.247/api/food/commodity/1
**请求参数:**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|principal|int|<i class="fa fa-check"></i>|当前登录用户id|

**路径参数**
`id` `int` 商家ID

**响应结果:**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":{
			id:1,
			name:'聚实惠餐厅',
			images['...',...],
			sold:3,//销量
			openTime:'10:00',//营业时间--开始
			closeTime:'22:00',//营业时间--结束
			description:'这是餐厅的简介，促销活动等',
			location:"蔚蓝商务港B座1816"
			longitude:134.232323//经度
			latitude:32.322332//纬度
			star:4，//星评-用以计算餐厅当前等级
			mobile:"13212212222",
			circleId:1,//商圈ID
			categoryName:"中餐"//分类名称
			notice:"公告"//公告
			deliverMoney:120,//起送金额
			supportInvoice:true,//是否支持发票
			discount:0.7,//折扣率
			usedCard:true,//是否可使用抵用券
			collected:true//是否收藏
			collectId:2,//收藏ID
			comments:[//显示三条评论
				{
					id:1,
					mobile:'130****1425',
					createTime:'2015-10-12',
					star:3,//1-差评 2-中评 3-好评
					content:'不错哦',
					images:['...',...]
					},
				...
			],
			level:[//等级
					diamond:1,//钻石数
					moon:2,//月亮数
					star:3//星星数
				]
		}
}
```
#### 商家评论列表

**接口地址** 
`GET`   `/food/restaurant/comment`
> eg.http://120.26.62.247/api/food/restaurant/comment?id=1
**请求参数:**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|id|int|<i class="fa fa-check"></i>|商家id|
|type|int|<i class="fa fa-check"></i>|0-全部评论 1 -差评 2-中评 3-好评|
|start|int|起始|
|size|int|数量|

**响应结果:**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":{
		countNum:10,//总评论数
		fineNum:7，//好评数
		middleNum:2//中评
		badNum:1,//差评
		comments：[
				{
					id:1,
					mobile:'130****1425',
					createTime:'2015-10-12',
					star:'好评',
					content:'不错哦',
					images:['...',...],
				},
				...
			]
		}
}
```
#### 后台推荐附属品
**接口地址** 
`GET`   `/food/recommend`
> eg.http://120.26.62.247/api//food/recommend
**请求参数:**  
参数|数据类型|必填|参数说明
---|-------|----|-----

**响应结果:**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":[
    		{
    			id:1,               //id
    			name:'推荐可乐',//附属品名称
    			price:3
    		},
    		...
    	]
}
```


#### 提交订单(同生鲜百货)
#### 美食外卖配送费

**接口地址** 
`GET`   `/food/deliver`

**请求参数:**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|principal|int|<i class="fa fa-check"></i>|当前登录用户id|
|addressId|int|<i class="fa fa-check"></i>|配送地址id|
|restaurantId|int|<i class="fa fa-check"></i>|餐厅id|
**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
401|未传入操作人ID|您需要重新登录才能继续操作哦~
404|用户不存在|系统繁忙，请稍候再试……
406|不存在的餐厅|
407|当前商圈不存在|

**响应结果:**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":15.0
}
```
#### 收藏商品

**接口地址** 
`POST`   `/food/commodity/collect`

**请求参数:**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|principal|int|<i class="fa fa-check"></i>|当前登录用户id|
|id|int|<i class="fa fa-check"></i>|商品id|
**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
401|未传入操作人ID|您需要重新登录才能继续操作哦~
404|用户不存在|系统繁忙，请稍候再试……

**响应结果:**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":null
}
```

#### 收藏商家

**接口地址** 
`POST`   `/food/restaurant/collect`

**请求参数:**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|principal|int|<i class="fa fa-check"></i>|当前登录用户idid|
|id|int|<i class="fa fa-check"></i>|商家id|
**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
401|未传入操作人ID|您需要重新登录才能继续操作哦~
404|用户不存在|系统繁忙，请稍候再试……

**响应结果:**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":null
}
```


##生鲜百货

### 分类
**接口地址** 
`GET` `/department/category`
> eg. http://120.26.62.247/api/department/category

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|start|int||起始|
|size|int||页长|
**响应结果**
```javascript
{
	code: 0, //0 - 接口调用成功，其他值表示失败
	message: null,
	data:[
		{
			id:1,
			name:"w.y.w.k",//分类名
			icon:"http://www.sd/asd/1"//图标
		},
	...
	]
}
```
### 商品列表
**接口地址** 
`GET` `/department/commodity`
> eg. http://120.26.62.247/api/department/commodity

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|categoryId|int||分类ID|
|start|int||起始|
|size|int||页长|
**响应结果**
```javascript
{
	code: 0, //0 - 接口调用成功，其他值表示失败
	message: null,
	data:{
		id:1,
		name:"车厘子",//
		icon:"http://www.sd/asd/1"//图标
		sold:21,//已售量
		price:20,//价格
		unit:"500g",//单位
		special:true,//是否特卖
		specialPrice:18//特价
		
	}
}
```
### 商品搜索列表
**接口地址** 
`GET` `/department/search`
> eg. http://120.26.62.247/api/department/search

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|keyword|String||搜索关键字|
|start|int||起始|
|size|int||页长|
**响应结果**
```javascript
{
	code: 0, //0 - 接口调用成功，其他值表示失败
	message: null,
	data:{
		id:1,
		name:"车厘子",//
		icon:"http://www.sd/asd/1"//图标
		sold:21,//已售量
		price:20,//价格
		unit:"500g",//单位
		special:true,//是否特卖
		specialPrice:18//特价
		
	}
}
```
### 商品详情
**接口地址** 
`GET` `/department/commodity/{id}`//id--商品id
> eg. http://120.26.62.247/api/department/commodity/1

**响应结果**
```javascript
{
	code: 0, //0 - 接口调用成功，其他值表示失败
	message: null,
	data:{
		id:1,
		name:"车厘子",//
		images{//轮播图片
			"http//www/wa/as/1",
			...
		},
		description:"..."//文字介绍
		rate:98%,//好评率
		comments:[{//用户评价--默认3个
			mobile:"132****2112",
			createTime:"2014-08-23",
			content:"不错~",//内容
			targetStat:3,//1-差评 2-中评 3-好评
			images:{
				"http://wsd.sd/wad/1",
				...
			},
		},
		...
		]
		
	}
}
```

### 提交订单(用于生鲜百货和美食外卖)
**接口地址** 
`POST` `/department/order/buy`

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|departmentOrder|[`DepartmentOrder` ](#departmentorder)||订单信息|
|principal|int|<i class="fa fa-check"></i>|当前登录用户id|
**响应结果**
```javascript
{
	code: 0, //0 - 接口调用成功，其他值表示失败
	message: null,
	data:{
		orderno:"2313213",
		price:12.00
   }
}
```
##干洗护理

### 分类
**接口地址** 
`GET` `/cleaning/category`
> eg. http://120.26.62.247/api/cleaning/category

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|start|int||起始|
|size|int||页长|
**响应结果**
```javascript
{
	code: 0, //0 - 接口调用成功，其他值表示失败
	message: null,
	data:[
		{
			id:1,
			name:"w.y.w.k",//分类名
			icon:"http://www.sd/asd/1"//图标
		},
	...
	]
}
```
### 商品列表
**接口地址** 
`GET` `/cleaning/commodity`
> eg. http://120.26.62.247/api/cleaning/commodity

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|categoryId|int||分类ID|
|start|int||起始|
|size|int||页长|
**响应结果**
```javascript
{
	code: 0, //0 - 接口调用成功，其他值表示失败
	message: null,
	data:{
		id:1,
		name:"冬装水洗",//
		icon:"http://www.sd/asd/1"//图标
		sold:21,//已洗量
		price:20//价格
		
	}
}
```
### 商品搜索列表
**接口地址** 
`GET` `/cleaning/search`
> eg. http://120.26.62.247/api/cleaning/search

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|keyword|String||搜索关键字|
|start|int||起始|
|size|int||页长|
**响应结果**
```javascript
{
	code: 0, //0 - 接口调用成功，其他值表示失败
	message: null,
	data:{
		id:1,
		name:"冬装水洗",//
		icon:"http://www.sd/asd/1"//图标
		sold:21,//已洗量
		price:20//价格
		
	}
}
```
### 商品详情
**接口地址** 
`GET` `/cleaning/commodity/{id}`//id--商品id
> eg. http://120.26.62.247/api/cleaning/commodity/1

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|principal|int||用户ID|
**响应结果**
```javascript
{
	code: 0, //0 - 接口调用成功，其他值表示失败
	message: null,
	data:{
		id:1,
		name:"冬装水洗",//
		images{//轮播图片
			"http//www/wa/as/1",
			...
		},
		description:"..."//文字介绍
		rate:98%,//好评率
		comments:[{//用户评价--默认3个
			mobile:"132****2112",
			createTime:"2014-08-23",
			content:"不错~",//内容
			targetStat:3,//1-差评 2-中评 3-好评
			images:{
				"http://wsd.sd/wad/1",
				...
			},
		},
		...
		]
		
	}
}
```


### 提交订单
**接口地址** 
`POST` `/cleaning/order/buy`

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|cleaningOrder|[`CleaningOrder`](#cleaningorder)||订单信息|
**响应结果**
```javascript
{
	code: 0, //0 - 接口调用成功，其他值表示失败
	message: null,
	data:{
		
   }
}
```
##同城微商
### 分类
**接口地址** 
`GET` `/vshop/category`
> eg. http://120.26.62.247/api/vshop/category

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|start|int||起始|
|size|int||页长|
**响应结果**
```javascript
{
	code: 0, //0 - 接口调用成功，其他值表示失败
	message: null,
	data:[
		{
			id:1,
			name:"w.y.w.k",//分类名
			icon:"http://www.sd/asd/1"//图标
		},
	...
	]
}
```
### 店铺列表
**接口地址** 
`GET` `/vshop/shop`
> eg. http://120.26.62.247/api/vshop/shop

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|category|int||分类 -1--推荐店铺 默认全部|
|order|int||排序  1-评价最好 2-销量最高|
|cityId|int||城市ID|
|start|int||起始|
|size|int||页长|
**响应结果**
```javascript
{
	code: 0, //0 - 接口调用成功，其他值表示失败
	message: null,
	data:{
		id:1,
		name:"澳洲代购店",//
		category:"推荐店铺",//分类
		icon:"http://www.sd/asd/1"//图标
		notice:"30元起送 5元配送费",//商家信息
		star:5,//星级
		commentnum:20,//评论数
		recommend:true//是否为推荐
		
	}
}
```
### 店铺商品分类
**接口地址** 
`GET` `/vshop/commodity/category`
> eg. http://120.26.62.247/api/vshop/commodity/category

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
id|int ||店铺id|

**响应结果**
```javascript
{
	code: 0, //0 - 接口调用成功，其他值表示失败
	message: null,
	data:[
		{
			id:1,
			name:"w.y.w.k",//分类名
		},
	...
	]
}
```
### 商品列表
**接口地址** 
`GET` `/vshop/commodity`
> eg. http://120.26.62.247/api/vshop/commodity

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|category|int||分类|
|shopId|int||店铺ID|
|start|int||起始|
|size|int||页长|
**响应结果**
```javascript
{
	code: 0, //0 - 接口调用成功，其他值表示失败
	message: null,
	data:{
		id:1,
		name:"夫妻肺片",
		icon:"http://www.sd/asd/1"//图标
		sold:21,//已洗量
		price:20//价格
		
	}
}
```
### 商品详情
**接口地址** 
`GET` `/vshop/commodity/{id}`//id--商品id
> eg. http://120.26.62.247/api/local/commodity/1

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|principal|int||用户ID|
**响应结果**
```javascript
{
	code: 0, //0 - 接口调用成功，其他值表示失败
	message: null,
	data:{
		id:1,
		name:"冬装水洗",//
		images{//轮播图片
			"http//www/wa/as/1",
			...
		},
		description:"..."//文字介绍
		rate:98%,//好评率
		comments:[{//用户评价--默认3个
			mobile:"132****2112",
			createTime:"2014-08-23",
			content:"不错~",//内容
			targetStar:3,//1-差评 2-中评 3-好评
			images:{
				"http://wsd.sd/wad/1",
				...
			},
		},
		...
		]
		
	}
}
```

### 提交订单
**接口地址** 
`POST` `/vshop/commodity/confirm`

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|vshopOrder|[`VshopOrder`](#vshoporder)||订单信息|
**响应结果**
```javascript
{
	code: 0, //0 - 接口调用成功，其他值表示失败
	message: null,
	data:{
		orderno:"213213",
		price:34.00
   }
}
```
### 商家详情
**接口地址** 
`GET` `/vshop/shop/{id}`//id--商家id
> eg. http://120.26.62.247/api/vshop/shop/1

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|principal|int||用户ID|
**响应结果**
```javascript
{
	code: 0, //0 - 接口调用成功，其他值表示失败
	message: null,
	data:{
		id:1,
		name:"澳洲代购店",//
		images{//轮播图片
			"http//www/wa/as/1",
			...
		},
		description:"..."//店铺简介，促销活动等
		star:4,//星评
		comments:[{//用户评价
			mobile:"132****2112",
			createTime:"2014-08-23",
			content:"不错~",//内容
			targetStar:3,//1-差评 2-中评 3-好评
			images:{
				"http://wsd.sd/wad/1",
				...
			},
		},
		...
		]
		
	}
}
```

## 订单

### 订单状态
**接口地址** 
`GET` `/order/status`
> eg. http://120.26.62.247/api/order/current

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|principal|int||用户ID|
|orderno|String||订单号|
**响应结果**
```javascript
{
	code: 0, //0 - 接口调用成功，其他值表示失败
	message: null,
	data:[{
		id:1,
		orderno:"xxxxx",//
		status:0//状态
		description:"..."//描述
		createTime:"2014-12-12"//创建时间
	},
	...]
}
```
### 当前订单
**接口地址** 
`GET` `/order/current`
> eg. http://120.26.62.247/api/order/current

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|principal|int||用户ID|
**响应结果**
```javascript
{
	code: 0, //0 - 接口调用成功，其他值表示失败
	message: null,
	data:[{
		id:1,
		orderno:"xxxxx",//
		system:1,
		sellerName:"..."//商家名
		commodityNames:"sdasd,asdas",//商品名（多个）
		createTime:"2014-12-12"//创建时间
		totalFee:4,//总金额
		status:0//状态
	},
	...]
}
```
### 历史订单
**接口地址** 
`GET` `/order/history`
> eg. http://120.26.62.247/api/order/current

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|principal|int||用户ID|
**响应结果**
```javascript
{
	code: 0, //0 - 接口调用成功，其他值表示失败
	message: null,
	data:[{
		id:1,
		orderno:"xxxxx",//
		system:1,
		sellerName:"..."//商家名
		commodityNames:"sdasd,asdas",//商品名（多个）
		createTime:"2014-12-12"//创建时间
		totalFee:4,//总金额
		status:0//状态
	},
	...]
}
```
### 订单详情
**接口地址** 
`GET` `/order/detail`
> eg. http://120.26.62.247/api/order/status

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|principal|int||用户ID|
|orderno|String||订单号|
**响应结果**
```javascript
{
	code: 0, //0 - 接口调用成功，其他值表示失败
	message: null,
	data:{
		id;
	    orderno;//订单号
	    createTime;//下单时间
	    status;//状态:0-待支付 1-接单中 2-待发送 3-待确认 4 已收货 5-调度中 6-确认调度 7-已接单 8-取件中 9-护理中 10-配送中 12-退款中 18-已完成 19已取消
	    system;//1-美食外卖 2-生鲜百货 3-干洗护理 4-同城微商
	    deliverId;//配送员id
	    totalFee;//总价格
	    remark;//订单备注
	    payType;//支付方式 1-支付宝 2-微信支付 3-货到付款 4-招人请客
	    addressId;//收货地址
	    deliverFee;//配送费
	    sellerId;//餐厅id或者vshop的id
	    sellerName;//卖家名称 美食的店名，生鲜百货，干洗护理，徽商的店铺名
	    commented;//是否评价
	    hopeCarry;//期望送达时间
	    hopeTake;//期望取件时间
	    readyMoney;//应备零钱(当支付方式为货到付款的时候)
	    invoice;//发票信息
	    cardId;//抵用券id
	    cardValue;//抵用券面值
	    backCard;//满多少送多少抵价券,形如100,15
	    changeRemark;//变更描述(配送员输入的内容)
	    loadId;//土豪请客id
	    customerId;//用户id
	    commodities:[
			{
				id:1//商品ID 
				name:"三杯鸡",
				count,4//数量
				price:23.00
				recommend:false//是否为推荐商品 除美食外卖外都为false
			},
			...
		],
		address:{
			id:23,  //送餐地址ID, 订餐时传入此参数
			location:"潜山路与东流路交叉口蔚蓝商务港B坐1406",
			name:"萨达姆",
			mobile:"18919601457",
			defaulted:true,//是否本商圈默认地址
			cityId:1,
			cityName:北京市,
			deliveryFee:5//配送费
		}
	}
}
```
### 取消订单
**接口地址** 
`GET` `/order/cancle`
> eg. http://120.26.62.247/api/order/cancle?principal=1&orderno=xxxxxx

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|principal|int||用户ID|
|orderno|String||订单号|


**运行时异常**
code| 错误原因  |返回消息
----|-----------|----
401|未传入操作人ID|您需要重新登录才能继续操作哦~
404|用户不存在|系统繁忙，请稍候再试……
604|订单不存在|不存在的订单
605|不可取消|订单当前状态不可取消
**响应结果**
```javascript
{
	code: 0, //0 - 接口调用成功，其他值表示失败
	message: null,
	data:null
}
```
### 美食外卖评价

**接口地址** 
`POST` `/order/comment/food`


**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|principal|int|<i class="fa fa-check"></i>|用户ID|
|orderno|string|<i class="fa fa-check"></i>|订单号|
|forfood|int|<i class="fa fa-check"></i>|餐厅美食评价 1-差评 2-中评 3-好评|
|fordeliver|int|<i class="fa fa-check"></i>|配送专员评价|
|pics|String||图片-最多三四张|
|content|string|<i class="fa fa-check"></i>|评论内容|


**响应结果**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":100//获得的积分
	
}
```
### 生鲜百货评价

**接口地址** 
`POST` `/order/comment/department`


**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|commentJson|[`CommentJson`](#commentjson)|<i class="fa fa-check"></i>|评论JSON|

**响应结果**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":100//获得的积分
	
}
```
### 干洗护理评价

**接口地址** 
`POST` `/order/comment/cleaning`


**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|commentJson|[`CommentJson`](#commentjson)|<i class="fa fa-check"></i>|评论JSON|

**响应结果**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":100//获得的积分
	
}

```
### 同城微商评价

**接口地址** 
`POST` `/order/comment/vshop`


**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|commentJson|[`CommentJson`](#commentjson)|<i class="fa fa-check"></i>|评论JSON|

**响应结果**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":100//获得的积分
	
}

```
### 配送员位置

**接口地址** 
`GET` `/order/deliver/location`

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|orderno|string|<i class="fa fa-check"></i>|订单号|
|longitude|double|<i class="fa fa-check"></i>|经度|
|latitude|double|<i class="fa fa-check"></i>|纬度|

**响应结果**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":{
				status:2,//配送员状态
				distance:500//距离
	}	
}
```
## 系统级相关接口

### 启动整合接口
客户端（买家）在打开APP就应马上调用的接口
该接口集成了定位当前商圈、版本更新、获取系统配置、首页广告等信息

**接口地址** 
`GET` `/system`
> eg. http://120.26.62.247/api/system

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|city|String||城市名|
|longitude|double||经度，不填无法得到商圈|
|latitude|double||纬度，不填无法得到商圈|

**响应结果**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":{
		cityId:232,//城市ID
		cityName:"合肥",
		circleId:2,//商圈ID
		circleName:"万达广场",//商圈名称
		cleaningMoney:100//干洗护理起始金额
		cleaningFee:10//干洗护理配送费
		deliverMoney:500//生鲜百货起始金额
		deliverFee:10//生鲜百货配送费
		carouses:[
			{
				id:1,
				image:"http://static.taddy.com/upfile/2014/9/10/lasjfoegaljoeg/icon-xs.png",
				title:"好消息"//标题
			},...
		]
	}
}
```
### 轮播详情

**接口地址** 
`GET` `/system/carousel`
> eg. http://120.26.62.247/api/system/carousel

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|id|int|<i class="fa fa-check"></i>|轮播id|

**响应结果**
```javascript
{
    code: 0, //0 - 接口调用成功，其他值表示失败
    message: null,
    data:{  "<div>...</div>"}
}
```
### 版本更新

**接口地址** 
`GET` `/system/upgrade`
> eg. http://120.26.62.247/api/system/upgrade

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|code|int|<i class="fa fa-check"></i>|版本号，不填无版本更新|
|type|int|<i class="fa fa-check"></i>|0-买家端  1-配送员|
|category|int|<i class="fa fa-check"></i>|1-安卓 2-苹果|

**响应结果**
```javascript
{
    code: 0, //0 - 接口调用成功，其他值表示失败
    message: null,
    data:{  //无版本更新时为null
        version:"10.0.0.3",     //版本号
        log:"更新日志：....（略）", //更新日志
        url:"http://....apk"    //下载地址
    }
}
```
### 备注热词

**接口地址** 
`GET` `/system/hotword`
> eg. http://120.26.62.247/api/system/hotword

**响应结果**
```javascript
{
    code: 0, //0 - 接口调用成功，其他值表示失败
    message: null,
    data:{  //
        "不要辣",
        ...
    }
}
```
### 关于我们

**接口地址** 
`GET` `/system/aboutus`
> eg. http://120.26.62.247/api/system/aboutus

**响应结果**
```javascript
{
    code: 0, //0 - 接口调用成功，其他值表示失败
    message: null,
    data:{  "<div>...</div>"}
}
```
##城市商圈

####城市列表

**接口地址** 
`GET` `/system/citys`
> eg. http://120.26.62.247/api/system/citys

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|city|string||定位的当前城市名|
|longitude|double||经度，不填无法得到商圈|
|latitude|double||纬度，不填无法得到商圈|

**响应结果**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":[
			{
				id:1,
				name:"北京"
			}
		]
}
```
####商圈列表

**接口地址** 
`GET` `/system/circles`
> eg. http://120.26.62.247/api/system/circles

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|cityId|int|<i class="fa fa-check"></i>|当前城市id|
|longitude|double||经度，不填无法得到商圈|
|latitude|double||纬度，不填无法得到商圈|

**响应结果**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":{
		nearest：{//最近的商圈
				id:2,
				name:'yy商圈',
				createTime:"2012-12-12",
				deliverFee:5.00,
				cityId:232,
				CirclePoint	[
				{
					id:1,
					x:137233223,
					longitude:"137,233223",
					y:37233223,
					latitude:"37,233223",
				},
				...
				]
			}
		allCitys:[//该城市下的所有商圈
			{
				id:2,
				name:'yy商圈',
				createTime:"2012-12-12",
				deliverFee:5.00,
				cityId:232,
				CirclePoint	[
				{
					id:1,
					x:137233223,
					longitude:"137,233223",
					y:37233223,
					latitude:"37,233223",
				},
				...
				]
			},
			......
	}
}
```
####商圈地图列表

**接口地址** 
`GET` `/system/citys/map`
> eg. http://120.26.62.247/api/system/citys/map

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|cityId|int|<i class="fa fa-check"></i>|当前城市id|
|longitude|double||经度，不填无法得到商圈|
|latitude|double||纬度，不填无法得到商圈|

**响应结果**
```javascript
{
	"code": 0, //0 - 接口调用成功，其他值表示失败
	"message": null,
	"data":{
		nearest：{//最近的商圈
				id:2,
				name:'yy商圈'	
				longitude:117.12,
				latitude:32.12
			}
		allCitys:[//该城市下的所有商圈
			{
				id:1,
				name:"XX商圈",
				longitude:117.11
				latitude:32.11
			},
			......
	}
}
```

## 配送员APP相关接口

####用户登录
**接口地址** 
`POST`   `/deliver/login`

**请求参数**  
|参数|数据类型|必填|参数说明|   
|-|-|-|-|
|mobile|String|<i class="fa fa-check"></i>|手机号|
|password|String|<i class="fa fa-exclamation">1</i>|密码|

|pushKey|String||Jpush设备ID|

**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
404|密码登录时手机号码不存在|用户不存在
403|用户被禁用|帐号被禁用

**返回参数**  
```javascript
{
	code:0, //0-表示成功 其它表示失败
	message: null,
	data: {
		id:1,
		username:'Tom',
		mobile:'15056920174',
		workNum:'PS001'
		....
	}
}
```
####待接单数目
**接口地址** 
`GET`   `/deliver/waitreceive/num`

**请求参数**  
|参数|数据类型|必填|参数说明|   
|-|-|-|-|
|principal|int|<i class="fa fa-check"></i>|配送员id|


**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
404|用户不存在


**返回参数**  
```javascript
{
	code:0, //0-表示成功 其它表示失败
	message: null,
	data: 32
	
}
```
####待接单列表
**接口地址** 
`GET`   `/deliver/waitreceive`

**请求参数**  
|参数|数据类型|必填|参数说明|   
|-|-|-|-|
|principal|int|<i class="fa fa-check"></i>|配送员id|
|start|int||
|size|int||


**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
404|用户不存在


**返回参数**  
```javascript
{
	code:0, //0-表示成功 其它表示失败
	message: null,
	data: [
			{
				orderno:'123456',
				type：2,//订单类型
				createTime:'2014-11-12 11:20',//下单时间
				sellerAdd:{//商家地址
				  name:'天鹅湖万达酒店',
				  longitude:117.147852,
				  latitude:31.12
				  mobile:'13855251478'
				},
				buyerAdd:{//买家地址
				  name:'天鹅湖万达酒店',
				  longitude:117.147852,
				  latitude:31.12
				  mobile:'13855251478'
			},
		...
	]
	
}
```

####拒单
**接口地址** 
`POST`   `/deliver/order/refuse`

**请求参数**  
|参数|数据类型|必填|参数说明|   
|-|-|-|-|
|principal|int|<i class="fa fa-check"></i>|配送员id|
|orderno|string|<i class="fa fa-check"></i>|订单号|
|cause|string|<i class="fa fa-check"></i>拒单原因|


**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
404|用户不存在
504|订单不存在


**返回参数**  
```javascript
{
	code:0, //0-表示成功 其它表示失败
	message: null,
	data: null
	
}
```
####接单
**接口地址** 
`POST`   `/deliver/order/receive`

**请求参数**  
|参数|数据类型|必填|参数说明|   
|-|-|-|-|
|principal|int|<i class="fa fa-check"></i>|配送员id|
|orderno|string|<i class="fa fa-check"></i>|订单号|


**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
404|用户不存在
504|订单不存在


**返回参数**  
```javascript
{
	code:0, //0-表示成功 其它表示失败
	message: null,
	data: null
	
}
```
####待配送数目
**接口地址** 
`GET`   `/deliver/waitdeliver/num`

**请求参数**  
|参数|数据类型|必填|参数说明|   
|-|-|-|-|
|principal|int|<i class="fa fa-check"></i>|配送员id|


**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
404|用户不存在


**返回参数**  
```javascript
{
	code:0, //0-表示成功 其它表示失败
	message: null,
	data: 32
	
}
```
####待配送列表
**接口地址** 
`GET`   `/deliver/waitdeliver`

**请求参数**  
|参数|数据类型|必填|参数说明|   
|-|-|-|-|
|principal|int|<i class="fa fa-check"></i>|配送员id|
|start|int||
|size|int||


**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
404|用户不存在


**返回参数**  
```javascript
{
	code:0, //0-表示成功 其它表示失败
	message: null,
	data: [//同待接单列表
			
}
```
####开始配送
**接口地址** 
`GET`   `/deliver/order/deliver/`

**请求参数**  
|参数|数据类型|必填|参数说明|   
|-|-|-|-|
|principal|int|<i class="fa fa-check"></i>|配送员id|
|orderno|string|<i class="fa fa-check"></i>|订单号|


**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
404|用户不存在
504|订单不存在


**返回参数**  
```javascript
{
	code:0, //0-表示成功 其它表示失败
	message: null,
	data: null
	
}
```
####配送中数目
**接口地址** 
`GET`   `/deliver/deliver/num`

**请求参数**  
|参数|数据类型|必填|参数说明|   
|-|-|-|-|
|principal|int|<i class="fa fa-check"></i>|配送员id|


**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
404|用户不存在


**返回参数**  
```javascript
{
	code:0, //0-表示成功 其它表示失败
	message: null,
	data: 32
	
}
```
####配送中列表
**接口地址** 
`GET`   `/deliver/deliver`

**请求参数**  
|参数|数据类型|必填|参数说明|   
|-|-|-|-|
|principal|int|<i class="fa fa-check"></i>|配送员id|
|start|int||
|size|int||


**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
404|用户不存在


**返回参数**  
```javascript
{
	code:0, //0-表示成功 其它表示失败
	message: null,
	data: [//同待接单列表
			
}
```
####确认送到
**接口地址** 
`GET`   `/deliver/service /`

**请求参数**  
|参数|数据类型|必填|参数说明|   
|-|-|-|-|
|principal|int|<i class="fa fa-check"></i>|配送员id|
|orderno|string|<i class="fa fa-check"></i>|订单号|


**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
404|用户不存在
504|订单不存在


**返回参数**  
```javascript
{
	code:0, //0-表示成功 其它表示失败
	message: null,
	data: null
	
}
```
####无法送到
**接口地址** 
`GET`   `/deliver/cannot/service /`

**请求参数**  
|参数|数据类型|必填|参数说明|   
|-|-|-|-|
|principal|int|<i class="fa fa-check"></i>|配送员id|
|orderno|string|<i class="fa fa-check"></i>|订单号|
|cause|string|<i class="fa fa-check"></i>|原因|

**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
404|用户不存在
504|订单不存在


**返回参数**  
```javascript
{
	code:0, //0-表示成功 其它表示失败
	message: null,
	data: null
	
}
```
####已完成数目
**接口地址** 
`GET`   `/deliver/finished/num`

**请求参数**  
|参数|数据类型|必填|参数说明|   
|-|-|-|-|
|principal|int|<i class="fa fa-check"></i>|配送员id|


**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
404|用户不存在


**返回参数**  
```javascript
{
	code:0, //0-表示成功 其它表示失败
	message: null,
	data: 32
	
}
```
####已完成列表
**接口地址** 
`GET`   `/deliver/finished`

**请求参数**  
|参数|数据类型|必填|参数说明|   
|-|-|-|-|
|principal|int|<i class="fa fa-check"></i>|配送员id|
|start|int||
|size|int||


**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
404|用户不存在


**返回参数**  
```javascript
{
	code:0, //0-表示成功 其它表示失败
	message: null,
	data: [
		{
			id:1,
			oderno:'123456',
			createTime:'2015-11-12 11:30'
		}，
		...
	]			
}
```
####--订单详情
**接口地址** 
`GET`   `/deliver/order/detail`

**请求参数**  
|参数|数据类型|必填|参数说明|   
|-|-|-|-|
|principal|int|<i class="fa fa-check"></i>|配送员id|
|orderno|string|<i class="fa fa-check"></i>|订单号|


**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
404|用户不存在
504|订单不存在

**返回参数**  
```javascript
{
	code:0, //0-表示成功 其它表示失败
	message: null,
	data:{。。。}
}
```
####修改密码

**接口地址** 
`POST`   `/deliver/auth/passwd`

**请求参数**  
|参数|数据类型|必填|参数说明|   
|-|-|-|-|
|principal|int|<i class="fa fa-check"></i|配送员id|
|oldpassword|String|<i class="fa fa-check"></i>|旧密码|
|newpassword|String|<i class="fa fa-check"></i>|新密码|

**运行时异常**
code| 错误原因  |返回消息
-----|---------|----
404||用户不存在
405|密码错误
403|用户被禁用|帐号被禁用

**返回参数**  
```javascript
{
	code:0, //0-表示成功 其它表示失败
	message: null,
	data: {
			id:1,
			username:'Tom',
			mobile:'15056920174',
			workNum:'PS001'
			....
		}
	}
```

#### 版本更新

**接口地址** 
`GET` `/deliver/upgrade`
> eg. http://120.26.62.247/api/deliver/upgrade

**请求参数**  
参数|数据类型|必填|参数说明
---|-------|----|-----
|code|int|<i class="fa fa-check"></i>|版本号，不填无版本更新|

**响应结果**
```javascript
{
    code: 0, //0 - 接口调用成功，其他值表示失败
    message: null,
    data:{  //无版本更新时为null
        version:"10.0.0.3",     //版本号
        log:"更新日志：....（略）", //更新日志
        url:"http://....apk"    //下载地址
    }
}
```
##附录

### 优惠标签

### CustomerInfo
客户实体对象说明
```
{
	id:1,//用户ID
	mobile:"189****1457"//用户手机号
}
```

### cardJson
`订单详情` 对象说明
```
[{
	id:1,
	num:5,
	score:50//所要积分
   
},{...},...]
```
### lordJson
`土豪请客` 对象说明
```
{
	commodityId:2,
	commodityName:'三杯鸡',
	fee:120.0//总费用
	price:12.0
	count:10,//数量
	shopId:'1'，//商店id(生鲜外卖时候为0)
	shopName:'吉时惠'//商店(生鲜外卖时候为"生鲜外卖")
	customerId:1//
	system:1,//1-美食外卖 2-生鲜百货
	circleId:1//商圈id
   
}
```
### DepartmentOrder
`订单详情` 对象说明
```
{
    system  :   2,//子系统标识 `1`-美食外卖 `2`-生鲜百货 `3`-干洗护理 `4`-同城微商
    addressId : 1//配送地址ID
    deliveryFee:10.00,//配送费
    commodities:[
	    {
	        id:21,  //商品ID
	        name:"苹果", //商品名称
	        count:10    //商品数量
	        price:10.00//单价
	    },
	    ...
    ],
    payType:1//1-支付宝支付 2-微信支付 3-货到付款 4-找人请客
    remark:"多加饭,没零钱,不要辣",
    totalFee:5.00//总费用,
    invoice:"鸿云来"，//发票信息
    loadId:1,//土豪请客ID
    cardId:1,//抵用券id
    cardValue:5,//抵用券值
    sellerId:2,//卖家id
    sellerName,//卖家name
    firstOrder:false //是否是首次下单
}
```
### CleaningOrder
`订单详情` 对象说明
```
{
    system  :   3,//子系统标识 `1`-美食外卖 `2`-生鲜百货 `3`-干洗护理 `4`-同城微商
    addressId : 1//配送地址ID
    deliveryFee:10.00,//配送费
    hopeTake:"16:30",//期望取件时间
    hopeCarry:"17:30",//期望送达时间
    commodities:[
	    {
	        id:21,  //商品ID
	        name:"冬装干洗", //商品名称
	        count:10    //商品数量
	        price:10.00//单价
	        recommend:false//当前商品是否为推荐的商品
	    },
	    ...
    ],
    payType:1//1-支付宝支付 2-微信支付 3-货到付款 4-找人请客
    remark:"多加饭,没零钱,不要辣",
    totalFee:5.00//总费用,
    invoice:"鸿云来"//发票信息
    firstOrder:false //是否是首次下单
}
```
### VshopOrder
`订单详情` 对象说明
```
{
    system  :   4,//子系统标识 `1`-美食外卖 `2`-生鲜百货 `3`-干洗护理 `4`-同城微商
    addressId : 1//配送地址ID
    deliveryFee:10.00,//配送费
    commodities:[
	    {
	        id:21,  //商品ID
	        name:"冬装干洗", //商品名称
	        count:10    //商品数量
	        price:10.00//单价
	        recommend:false//当前商品是否为推荐的商品
	    },
	    ...
    ],
    payType:1,//1-支付宝支付 2-微信支付 3-货到付款 4-找人请客
    remark:"多加饭,没零钱,不要辣",
    totalFee:5.00,//总费用,
    invoice:"鸿云来"//发票信息
    sellerId:5,//卖家id
    sellerName//卖家name
}
```
### CommentJson
`订单详情` 对象说明
```
{
    customerId:   4,//用户ID
    orderno:"ww22212"//订单号
    deliverStar:3,////配送员评分  在同城微商时候 为对店铺的评价 star
    detail:[
	    {
	        commodityId:21,  //商品ID
	        content:2, //商品数量
	        star:3,//3 好评 2中评  1差评
	        images:"1,2"//图片id用,连接
	    },
	    ...
    ],
    payType:1,//1-支付宝支付 2-微信支付 3-货到付款 4-找人请客
    remark:"多加饭,没零钱,不要辣",
    totalFee:5.00,//总费用,
    invoice:"鸿云来"//发票信息
}
```
## 二维码扫描说明

二维码的功能包括两个方面：
1. 跳转到后台临时创建的活动页
2. 任何一款其它APP打开后能跳转到应用下载页面

针对以上需求，这里规定下客户端需实现的功能。

客户端在扫描二维码后会得到一个url，例如：
`http://teddy.hylapp.com/acitivity/14092003?key1=dafe&key2=dsfae&needLogin=true`
客户端根据此URL拼接一个新的URL，并用内嵌浏览器打开新的URL。拼接步骤如下：
1. 在url中查找字符串*`needLogin=true`*,若能查找到此字符串,则表示该项活动需用户登录，客户端先引导用户登录，然后在url后追加登录用户ID参数。例：`&principal=1`。
2.  始终在URL后面增加特殊参数：`&spt=hylapp`

将得到的URL在内嵌浏览器中打开即可。

##推送消息说明
推送消息给客户端时候附带的数据，客户端可根据数据进行相信处理



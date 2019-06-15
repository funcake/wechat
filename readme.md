
## 项目重要说明

1. vendor 中增加了微信小店接口：
/vendor/overtrue/wechat/src/OfficialAccount/Merchant

## 项目流程

1. 企业微信创建商户
2. 使用接口创建部门
```
http://www.fljy.shop/admin/regist?name=测试部门
```
3. 企业微信中邀请用户加入部门
4. 在部门中创建商品
```
http://www.fljy.shop/admin/createProduct?amount=2&group_id=530528963
```
5. 

## 服务器说明

1. apache 配置站点文件在 /etc/httpd/conf 中，修改配置后需要重启服务：
```
service httpd restart
```

2. `shared` 目录中的 `.env` 文件权限必须 `644`，不然不能读取。

3. `shared` 中 `storage` 目录需授权 `apache`，不然无法缓存：
```
chmod 0775 storage
chown -R apache:apache storage
```

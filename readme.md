
## 项目重要说明

1. vendor 中增加了微信小店接口：
/vendor/overtrue/wechat/src/OfficialAccount/Merchant

## 服务器说明

1. apache 配置文件在 /etc/httpd/conf 中，修改配置后需要重启服务：
```
service httpd restart
```
2. `shared` 目录中的 `.env` 文件权限必须 `644`，不然不能读取。

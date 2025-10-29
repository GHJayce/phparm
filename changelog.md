

## version
### 1.0.1
- 尝试修复单仓库Packagist无法找到子包的问题。

### 1.0.0
- 去除旧版本所有文件。
- 采用单仓库（Monorepo）开发多个子包（sub-packages）的模式，尽可能多的参考、借鉴和遵循php-fig、laravel和symfony提供的接口来实现本库。
- 新增`Entity`实体属性包。
  - 支持不破坏`Attribute`原`__call`实现的方式下，扩展有前缀、无前缀方法。
- 新增`Url`工具包。
- `ghjayce/weapon`包更名为`ghjayce/phparm`。
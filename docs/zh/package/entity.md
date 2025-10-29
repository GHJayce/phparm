# Entity

## 安装

```bash
composer require ghjayce/phparm-entity
```

## Attribute

`\Ghjayce\PhparmEntity\Attribute`

用于定义实体属性的抽象类。

### 概念

- 实体类：继承自 `Attribute` 的类称为实体类。
- 实体属性：实体类中的属性。
- 实体公有属性：实体类中访问控制定义为 `public` 的属性。

### 方法

| 方法                | 说明                                                                  |
|:------------------|:--------------------------------------------------------------------|
| `make()`          | 静态方法，创建实体类实例。                                                       |
| `fill()`          | 填充实体公有属性。                                                           |
| `all()`           | 获取所有实体公有属性。                                                         |
| `toArray()`       | 将实体公有属性转换为数组。<br>实现接口：`\Illuminate\Contracts\Support\Arrayable`     |
| `toJson()`        | 将实体公有属性转换为JSON字符串。<br>实现接口：`\Illuminate\Contracts\Support\Jsonable` |
| `jsonSerialize()` | 将实体公有属性序列化为json。<br>实现接口：`\JsonSerializable`                        |

| 其他         | 说明                                                 |
|:-----------|:---------------------------------------------------|
| `foreach`  | 遍历所有实体公有属性。                                        |
| `setXxx()` | 设置实体公有属性的钩子方法，`xxx` 为属性。<br>例如：`setName`、`setAge`。 |
| `getXxx()` | 获取实体公有属性的钩子方法。                                     |

我们用以下关于动物的几个类来举例演示：

- 动物基类，有名字、性别、年龄、生物分类等。
- 老虎类，继承动物基类。

```php
<?php

use Ghjayce\PhparmEntity\Attribute;

class Taxonomy extends Attribute
{
    public string $domain; // 域
    public string $kingdom; // 界
    public string $phylum; // 门
    public string $class; // 纲
    public string $order; // 目
    public string $family; // 科
    public string $genus; // 属
    public string $species; // 种
}

class Animal extends Attribute
{
    public string $name;
    public string $gender; 
    public int $age; 
    public Taxonomy $taxonomy;
}

class Tiger extends Animal
{
}
```

### 实例化

```php
<?php

// 方法一
$tiger = new Tiger();

// 方法二
$tiger = Tiger::make();
```

### 赋值

```php
<?php

$taxonomy = Taxonomy::make([
    'domain' => '真核域',
    'kingdom' => '动物界',
    'phylum' => '脊索动物门',
    'class' => '哺乳纲',
    'order' => '食肉目',
    'family' => '猫科',
    'genus' => '豹属',
    'species' => '虎',
])

// 方法一：实例化時进行赋值
$tiger = Tiger::make([
    'name' => '华南虎',
    'gender' => '雄性',
    'age' => 5,
]);

// 方法二：使用 fill 方法赋值
$tiger = Tiger::make()
    ->fill([
        'name' => '华南虎',
        'gender' => '雌性',
        'age' => 5,
    ])

/**
 * 方法三：使用 setXxx 钩子方法赋值
 * 推荐，有以下好处
 *  - 可以链式调用，一次性设置多个属性
 *  - 可以在钩子方法中添加额外逻辑
 *  - 更方便idea追踪调用来源，尤其是在继承关系复杂时
 */
$tiger = Tiger::make()
    ->setName('华南虎')
    ->setGender('雄性')
    ->setAge(5)
    ->setTaxonomy($taxonomy);
```

### 取值

#### 单个获取

```php
<?php

// 方法一：直接访问
$name = $tiger->name;

/**
 * 方法二：使用 getXxx 钩子方法取值
 * 推荐，有以下好处
 *  - 可以在钩子方法中添加额外逻辑
 *  - 更方便idea追踪调用来源，尤其是在继承关系复杂时
 */
$name = $tiger->getName();
```

#### 获取多个

```php
<?php

// 方法一：获取所有实体公有属性数组
$attributes = $tiger->all();

// 方法二：将实体公有属性转换为数组
$attributes = $tiger->toArray();

// 方法三：将实体公有属性转换为JSON字符串
$json = $tiger->toJson();

// 方法四：遍历所有实体公有属性
foreach ($tiger as $key => $value) {
    echo "{$key}: {$value}\n";
}

// 方法五：使用 jsonSerialize 方法获取可序列化数据
$serializableData = $tiger->jsonSerialize();
```

## Option

如果你有一些可选项参数时，可以使用 `\Ghjayce\PhparmEntity\Option` 类。

这比使用数组来说更加清晰。

## API

### PrefixMethod 钩子

`\Ghjayce\PhparmEntity\Traits\PrefixMethod::class`

是一个 trait，`prefixMethod()` 根据钩子配置，按照前缀调用对应的方法。

`prefixMethodMap()` 提供了钩子配置的数组，你可以随意覆写和添加新的钩子。

规则：

`前缀 => callable`

> `''`空前缀也是支持的。

以 `\Ghjayce\PhparmEntity\Attribute` 为例，它内置了两个钩子：

```php
protected function prefixMethodMap(): array
{
    return [
        'get' => [$this, 'prefixMethodGet'],
        'set' => [$this, 'prefixMethodSet'],
    ];
}
```

调用 `$instance->getName()` 时，访问的是公有属性 `public string $name;`

> 注意，前缀的后一个字母会被处理成大写。

### StringValue

如果你的实体仅有一个字符串属性时，可以使用 `\Ghjayce\PhparmEntity\StringValue` 类。

详细参考 [Url](./url.md)

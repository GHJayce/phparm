
# Entity

## Attribute

用于定义实体属性的抽象类。


### 定义
例如我们有一个动物基类，属性包括名字、性别、年龄等。然后还有一只老虎，我们可以这么写：

```php
<?php

use Ghjayce\Phparm\Entity\Attribute;

class Animal extends Attribute
{
    public string $name;
    public string $gender; 
    public int $age; 
}
class Tiger extends Animal
{
}
```

### 使用
然后我们可以增加一只华南虎：

```php
<?php

$tiger = new Tiger();
```

### 嵌套
现在我们想丰富一下动物的属性，比如添加一个生物分类Taxonomy，我们可以定义一个Taxonomy类：

```php
<?php

use Ghjayce\Phparm\Entity\Attribute;

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
```

然后在Animal类中使用它：

```php
<?php

use Ghjayce\Phparm\Entity\Attribute;

class Animal extends Attribute
{
    public string $name;
    public string $gender; 
    public int $age; 
    public Taxonomy $taxonomy;
}
```
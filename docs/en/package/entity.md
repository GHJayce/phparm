
# Entity

## Installation

```bash
composer require ghjayce/phparm-entity
```

## Attribute

`\Ghjayce\Phparm\Entity\Attribute`

An abstract class used to define entity attributes.

### Concepts

- Entity class: A class that extends `Attribute` is called an entity class.
- Entity attribute: Attributes within an entity class.
- Public entity attribute: Attributes in an entity class defined as `public`.

### Methods

| Method                | Description                                                                                  |
|:----------------------|:--------------------------------------------------------------------------------------------|
| `make()`              | Static method to create an instance of the entity class.                                    |
| `fill()`              | Fills public entity attributes.                                                             |
| `all()`               | Gets all public entity attributes.                                                          |
| `toArray()`           | Converts public entity attributes to an array.<br>Implements: `\Illuminate\Contracts\Support\Arrayable`     |
| `toJson()`            | Converts public entity attributes to a JSON string.<br>Implements: `\Illuminate\Contracts\Support\Jsonable` |
| `jsonSerialize()`     | Serializes public entity attributes to JSON.<br>Implements: `\JsonSerializable`                        |

| Others        | Description                                                 |
|:-------------|:------------------------------------------------------------|
| `foreach`    | Iterates all public entity attributes.                      |
| `setXxx()`   | Setter hook method for public entity attributes, where `xxx` is the attribute name.<br>For example: `setName`, `setAge`. |
| `getXxx()`   | Getter hook method for public entity attributes.             |

Here are some example classes about animals:

- Animal base class, with name, gender, age, taxonomy, etc.
- Tiger class, extends the animal base class.

```php
<?php

use Ghjayce\Phparm\Entity\Attribute;

class Taxonomy extends Attribute
{
    public string $domain; // Domain
    public string $kingdom; // Kingdom
    public string $phylum; // Phylum
    public string $class; // Class
    public string $order; // Order
    public string $family; // Family
    public string $genus; // Genus
    public string $species; // Species
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

### Instantiation

```php
<?php

// Method 1
$tiger = new Tiger();

// Method 2
$tiger = Tiger::make();
```

### Assignment

```php
<?php

$taxonomy = Taxonomy::make([
    'domain' => 'Eukarya',
    'kingdom' => 'Animalia',
    'phylum' => 'Chordata',
    'class' => 'Mammalia',
    'order' => 'Carnivora',
    'family' => 'Felidae',
    'genus' => 'Panthera',
    'species' => 'Tigris',
]);

// Method 1: Assign values during instantiation
$tiger = Tiger::make([
    'name' => 'South China Tiger',
    'gender' => 'Male',
    'age' => 5,
]);

// Method 2: Use the fill method to assign values
$tiger = Tiger::make()
    ->fill([
        'name' => 'South China Tiger',
        'gender' => 'Female',
        'age' => 5,
    ]);

/**
 * Method 3: Use setXxx hook methods to assign values
 * Recommended, with the following benefits:
 *  - Supports method chaining to set multiple attributes at once
 *  - Allows adding extra logic in the hook methods
 *  - Easier for IDEs to trace call sources, especially with complex inheritance
 */
$tiger = Tiger::make()
    ->setName('South China Tiger')
    ->setGender('Male')
    ->setAge(5)
    ->setTaxonomy($taxonomy);
```

### Getting Values

#### Get a single value

```php
<?php

// Method 1: Direct access
$name = $tiger->name;

/**
 * Method 2: Use getXxx hook methods
 * Recommended, with the following benefits:
 *  - Allows adding extra logic in the hook methods
 *  - Easier for IDEs to trace call sources, especially with complex inheritance
 */
$name = $tiger->getName();
```

#### Get multiple values

```php
<?php

// Method 1: Get all public entity attributes as an array
$attributes = $tiger->all();

// Method 2: Convert public entity attributes to an array
$attributes = $tiger->toArray();

// Method 3: Convert public entity attributes to a JSON string
$json = $tiger->toJson();

// Method 4: Iterate all public entity attributes
foreach ($tiger as $key => $value) {
    echo "{$key}: {$value}\n";
}

// Method 5: Use the jsonSerialize method to get serializable data
$serializableData = $tiger->jsonSerialize();
```

## Option

If you have some optional parameters, you can use the `\Ghjayce\Phparm\Entity\Option` class.

This is clearer than using an array.

## API

### PrefixMethod Hook

`\Ghjayce\Phparm\Entity\Traits\PrefixMethod::class`

A trait where `prefixMethod()` calls the corresponding method according to the prefix configuration.

`prefixMethodMap()` provides the array of hook configurations, which you can override and add new hooks as needed.

Rule:

`prefix => callable`

> The empty prefix `''` is also supported.

For example, in `\Ghjayce\Phparm\Entity\Attribute`, two hooks are built-in:

```php
protected function prefixMethodMap(): array
{
    return [
        'get' => [$this, 'prefixMethodGet'],
        'set' => [$this, 'prefixMethodSet'],
    ];
}
```

When calling `$instance->getName()`, it accesses the public attribute `public string $name;`

> Note: The letter after the prefix will be capitalized.

### StringValue

If your entity only has a single string attribute, you can use the `\Ghjayce\Phparm\Entity\StringValue` class.

See details in [Url](./url.md)

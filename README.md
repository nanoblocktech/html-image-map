## Class Image Map

Generate image map, based on coordinates


Installation Guide via Composer:

```bash
composer require nanoblocktech/html-image-map
```

### Usages 

Initialize class 
```php
use Luminova\ExtraUtils\ImageMapper\ImageMapper;
$map = new ImageMapper();
```

Create image mapping
It will return instance of `ImageMapAreas`

```php
$image = $map->addImage('http://example.com/path/to/image.png');
```

Add your map, areas and coordinate b
```php
$area = $image->addArea(ImageMapper::RECTANGLE, 'My Area Title');
$area->bindOnclick('myFunction();');
$area->setCoordinates([44, 180, 60]);


$area2 = $image->addArea(ImageMapper::CIRCLE, 'My Area 2  Title');
$area2->bindLink('https://example.com/foo');
$area2->setCoordinates([100, 380, 60]);

// Get your image map

$image->display();
```

### Methods For `ImageMapper()`

`$map = new ImageMapper();`

Methods And Param                                                      |  Descriptions 
-----------------------------------------------------------------------|-----------------------------
addImage(string image, string description, string name): ImageMapAreas | Add new image set

### ImageMapper Constant Variable   

Name             | Type      |  Descriptions 
-----------------|-----------|------------------------------------
RECTANGLE        | String    | Image mapping shape for rectangular area
CIRCLE           | String    | Image mapping shape for circle area 
POLYGON          | String    | Image mapping shape for polygon area 
DEFAULT          | String    | Image mapping shape for default 
BIND_LINK        | String    | Bind area click to href link `href="example.com"`
BIND_JS          | String    | Bind area click to javascript onClick `onclick="myFunction();"`


### Methods For `addImage()`

`$image = $map->addImage('http://example.com/path/to/image.png');`

Methods And Param                                  |  Descriptions 
---------------------------------------------------|--------------------------------------------------------------------
addArea(string type, string title): self           | Add map area and return `ImageMapAreas` instance
bindClick(string type, string action): void        | Bind click event action to area 
setCoordinates(array coords): void                 | Set area coordinates
addCoordinate(int left, int top, int pixels): void | Add coordinate same as `setCoordinates` except this accept param
build(string id, string class): string             | Build and get html image map string 
display(string id, string class): void             | Display html image map. shorthand for `echo build()`
get(string id, string class): string               | Get html image map string, shorthand for `build()`


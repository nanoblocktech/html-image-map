<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
*/
namespace Luminova\ExtraUtils\ImageMapper;
use \InvalidArgumentException;

class ImageMapAreas
{
    /**
     * Image url 
     * @var string $image
    */
    private string $image = '';

    /**
     * Map name 
     * @var string $name
    */
    private string $name = '';

    /**
     * Image alt description 
     * @var string $alt
    */
    private string $alt = 'Image';

    /**
     * Mapping areas
     * @var array $areas
    */
    private array $areas = [];

    /**
     * Mapping coordinates
     * @var array $coordinates
    */
    private array $coordinates = [];

    /**
     * Mapping clicks
     * @var array $clicks
    */
    private array $clicks = [];

    /**
     * MappingCalculator constructor.
     *
     * @param string $image Mapping image url 
     * @param string $description Mapping image description 
     * @param string $name Image map name
    */
    public function __construct(string $image, string $description, string $name)
    {
        $this->image = $image;
        $this->name = $name;
        $this->alt = $description;
    }

    /**
     * Add map area with shape 
     *
     * @param string $shape type of shape
     * @param string $title coordinate title or description
     * 
     * @return self $this
    */
    public function addArea(string $shape, string $title = ''): self
    {
        if (!in_array($shape, ['rect', 'circle', 'poly', 'default'])) {
            throw new InvalidArgumentException("Invalid image mapping area shape: $shape, supported shapes [rect, circle, poly, default]");
        }

        $this->areas[] = [
            'shape' => $shape,
            'title' => $title
        ];

        return $this;
    }

    /**
     * Bind a click to shape
     *
     * @param string $type type of click event ['link' or 'js]
     * @param string $action action to call, it can be a link or javascript method 
     * 
     * @return void 
     * @throws InvalidArgumentException
    */
    public function bindClick(string $type, string $action = ''): void
    {
        if (!in_array($type, ['link', 'js'])) {
            throw new InvalidArgumentException("Invalid click type: $type, supported types [link, js]");
        }
    
        $isLink = self::isUrl($action);
    
        if ($type === 'link' && !$isLink) {
            throw new InvalidArgumentException("Invalid link format: $action");
        }
    
        if ($type === 'js' && $isLink) {
            throw new InvalidArgumentException("Invalid JavaScript action: $action");
        }

        $this->clicks[] = [
            'type' => $type,
            'action' => $action
        ];
    }

    /**
     * Bind js click to shape
     * Shorthand for bindClick(js, action)
     *
     * @param string $action action to call, it can be a link or javascript method 
     * 
     * @return void 
     * @throws InvalidArgumentException
    */
    public function bindOnclick(string $action = ''): void
    {
        $this->bindClick('js', $action);
    }

    /**
     * Bind link click to shape
     * Shorthand for bindClick(link, action)
     *
     * @param string $action action to call, it can be a link or javascript method 
     * 
     * @return void 
     * @throws InvalidArgumentException
    */
    public function bindLink(string $action = ''): void
    {
        $this->bindClick('link', $action);
    }

    /**
     * Set coordinates
     *
     * @param array $coordinates set coordinates for shape
     * 
     * @return void 
     * @throws InvalidArgumentException
    */
    public function setCoordinates(array $coordinates): void
    {
        if(!self::isCoords($coordinates)){
            throw new InvalidArgumentException("Invalid coordinates: $coordinates, your coordinates must be an integer values example: [140,42,83,84]");
        }

        $this->coordinates[] = $coordinates;
    }

    /**
     * Add coordinate
     *
     * @param int $left from left position
     * @param int $top from top position
     * @param int $pixels area pixels size
     * 
     * @return void 
    */
    public function addCoordinate(int $left, int $top, int $pixels): void
    {
        $this->coordinates[] = "{$left},$top,{$pixels}";
    }

    /**
     * Display image map html 
     * Shorthand for echo build()
     *
     * @param string $id image element id 
     * @param string $class image element class name 
     * 
     * @return void
    */
    public function display(string $id = '', string $class = ''): void 
    {
        $map = $this->build($id, $class);

        echo $map;
    }

    /**
     * Get image map html string
     * Shorthand for build
     *
     * @param string $id image element id 
     * @param string $class image element class name 
     * 
     * @return string $map
    */
    public function get(string $id = '', string $class = ''): string 
    {
        $map = $this->build($id, $class);

        return $map;
    }

    /**
     * Build image map html 
     *
     * @param null|string $id image element id 
     * @param null|string $class image element class name 
     * 
     * @return string
    */
    public function build(string $id = '', string $class = ''): string 
    {
        if($id === ''){
            $id = uniqid('img-map-');
        }

        $map = "<img src='{$this->image}' usemap='#{$this->name}' id='{$id}' class='{$class}' alt='{$this->alt}'/>";
        $map .= "<map name='{$this->name}'>";

        foreach ($this->areas as $index => $area) {

            $coords = $this->getCoords($index);
            $bindClick = $this->getClickEvent($index);

            $map .= "<area shape='{$area['shape']}' coords='{$coords}' {$bindClick} alt='{$area['title']}' title='{$area['title']}'>";
        }

        $map .= '</map>';

        return $map;
    }

    /**
     * Get coordinates by index 
     *
     * @param int $index map area index
     * 
     * @return string
    */
    private function getCoords(int $index): string 
    {
        $coord = $this->coordinates[$index] ?? [];

        if( $coord === []){
            return '';
        }

        $coords = implode(',', $coord);
        $coords = trim($coords, ',');

        return $coords;
    }

    /**
     * Get area click event by index 
     *
     * @param int $index map area index
     * 
     * @return string
    */
    private function getClickEvent(int $index): string
    {
        $click = $this->clicks[$index] ?? [];

        if( $click === []){
            return 'href="#"';
        }

        $type = $click['type'] ?? 'link';
        $void = $type === 'link' ? '#': 'void();';
        $action = $click['action'] ?? $void;

        if($type === 'link'){
            return "href='{$action}'";
        }

        if($type === 'js'){
            return "href='#' onclick='{$action}'";
        }
    }

    /**
     * Check if link is a valid url 
     *
     * @param string $url link
     * 
     * @return bool 
    */
    private static function isUrl(string $url): bool 
     {
        if($url === '#'){
            return true;
        }

        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Check if coordinates values are valid integers
     *
     * @param array $coordinates 
     * 
     * @return bool
    */
    private static function isCoords(array $coordinates): bool 
    {
        return count($coordinates) === count(array_filter($coordinates, 'is_int'));
    }
}

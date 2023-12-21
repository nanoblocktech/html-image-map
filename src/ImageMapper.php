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

use Luminova\ExtraUtils\ImageMapper\ImageMapAreas;

class ImageMapper {
    /**
     * Image mapping shape
     * @var string RECT
    */
    public const RECTANGLE = 'rect';

    /**
     * Image mapping shape
     * @var string CIRCLE
    */
    public const CIRCLE = 'circle';

    /**
     * Image mapping shape
     * @var string POLYGON
    */
    public const POLYGON = 'poly';

    /**
     * Image mapping shape
     * @var string DEFAULT
    */
    public const DEFAULT = 'default';

    /**
     * Area click handler for link
     * @var string BIND_LINK
    */
    public const BIND_LINK = 'link';

    /**
     * Area click handler for link
     * @var string BIND_JS
    */
    public const BIND_JS = 'js';


    /**
     * ImageMapper constructor.
    */
    public function __construct(){
  
    }

    /**
     * Set images url 
     *
     * @param string $image Map image url 
     * @param string $description Map image description
     * @param string $name Map name
     * 
     * @return ImageMapAreas $areas
     */
    public function addImage(string $image, string $description = '', string $name = 'imageMapping'): ImageMapAreas 
    {
        
        $areas = new ImageMapAreas($image, $description, $name);

        return $areas;
    }
}

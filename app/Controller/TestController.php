<?php 

namespace App\Controller;

use App\Entity\Post;
use Nightfall\Fallen\DataMapper\DataMapper;
use Nightfall\Http\Controller\BaseController;

class TestController extends BaseController
{
    public function index(DataMapper $dataMapper)
    {
        $result = $dataMapper->mapEntityClass(Post::class);
        echo '<pre>';
        print_r($result);
        echo '</pre>';
    }
}
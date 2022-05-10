<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Repositories\Options\OptionRepositoryInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $optionRepo;
    public function __construct(OptionRepositoryInterface $optionRepo)
    {
        $this->optionRepo = $optionRepo;
    }

    public function banners()
    {
        return $this->optionRepo->getBanners();
    }

    public function nav()
    {
        return $this->optionRepo->getNavMenu();
    }

    public function sale()
    {
        return $this->optionRepo->getSale();
    }

    public function collections()
    {
        return $this->optionRepo->getHomeCollection();
    }

    public function trending()
    {
        return $this->optionRepo->getTrendingKeywords();
    }
}

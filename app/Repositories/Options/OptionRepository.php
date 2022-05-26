<?php

namespace App\Repositories\Options;

use App\Models\Option;
use App\Repositories\BaseRepository;

class OptionRepository extends BaseRepository implements OptionRepositoryInterface
{
    public function getModel()
    {
        return Option::class;
    }

    public function getBanners()
    {
        return $this->getOptionValue('banners');
    }

    public function getNavMenu()
    {
        return $this->getOptionValue('nav_menu');
    }

    public function getSale()
    {
        return [];
    }

    public function getHomeCollection()
    {
        return $this->getOptionValue('home_collections');
    }

    public function getTrendingKeywords()
    {
        return [];
    }

    protected function getOptionValue($name)
    {
        return unserialize($this->model->where('name', $name)->firstOrFail()->value);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return void
     */
    protected function setOptionValue($name, $value)
    {
        $this->model->create(['name' => $name, 'value' => serialize($value)]);
    }
}

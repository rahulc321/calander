<?php
namespace App\Modules\Products;


use Ddeboer\DataImport\Reader\CsvReader;
use Optimait\Laravel\Exceptions\ApplicationException;
use Optimait\Laravel\Repos\EloquentRepository;
use Optimait\Laravel\Traits\CallbackForRequestTrait;
use Optimait\Laravel\Traits\UploaderTrait;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class ColorRepository extends EloquentRepository
{
    use CallbackForRequestTrait, UploaderTrait;
    public $validator;

    public function __construct(Color $color, ColorValidator $colorValidator)
    {
        $this->model = $color;
        $this->validator = $colorValidator;
    }

    public function getSearchedPaginated($data, $items = 10, $orderBy = 'title', $orderType = 'ASC', $where = null)
    {
        $model = $this->model->where('id', '!=', 0)->with('source');

        if (!is_null($where) && is_callable($where)) {
            $model->where($where);
        }
        $model->where(function ($q) use ($data) {
            if (@$data['name']) {
                $q->where(function ($q) use ($data) {
                    $q->orWhere('full_name', 'LIKE', $data['name'] . '%');
                });
            }

            if (@$data['source']) {
                $q->where('color_source_id', '=', $data['source']);
            }
        });
        return $model->orderBy($orderBy, $orderType)->paginate($items);
    }

    public function getPaginated($items = 10, $orderBy = 'title', $orderType = 'ASC', $where = null)
    {
        $model = $this->model->where('id', '!=', 0);

        if (!is_null($where) && is_callable($where)) {
            $model->where($where);
        }
        return $model->orderBy($orderBy, $orderType)->paginate($items);
    }


    public function createColor($colorData = array(), \Closure $c = null)
    {
        $colorData = array_merge($colorData, $this->processCallbackForRequest($c));

        $color = parent::getNew($colorData);
        if ($color->save()) {
            event('color.saved', array($color, $colorData, false));
            return $color;
        }
        throw new ApplicationException("Cannot Add Color Template.");
    }


    public function updateColor($id, $colorData = array(), \Closure $c = null)
    {
        $colorData = array_merge($colorData, $this->processCallbackForRequest($c));
        $color = $this->getById($id);
        $color->fill($colorData);
        if ($color->save()) {
            event('color.saved', array($color, $colorData));
            return $color;
        }

        throw new ApplicationException("Cannot Add Color.");
    }


    public function deleteColor($id)
    {
        $color = $this->getById($id);
        if (is_null($color)) {
            throw new ResourceNotFoundException('Color Not Found');
        }

        /*$name = $color->filename;
        @unlink('./uploads/inventories/'.$name);*/
        if ($color->selfDestruct()) {
            // print_r(DB::getQueryLog());
            return true;
        }

        return false;
    }
}
<?php

namespace App\Repositories\Admin;

use App\Models\Fag;
use Illuminate\Container\Container as Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Exceptions\RepositoryException;

class FrontPageRepository extends BaseRepository
{

    protected $model;
    public $modelName = 'App\Models\Vendor';
    private string $foreignKey;
    private bool $withoutTranslation = false;

    public function __construct(Application $app)
    {
        parent::__construct($app);
    }

    /**
     * Attribute Model
     *
     * @return string
     * @throws RepositoryException
     */
    public function  setModel($model): void
    {
        $this->modelName = $model;
        $this->resetModel();
    }

    public function  setForeignKey ($foreignKey): void
    {
        $this->foreignKey = $foreignKey;
    }

    public function Model(): string
    {
        return $this->modelName;
    }

    /**
     * @param bool $withPaginate
     * @param mixed $paginate
     * @return object
     */
    public function getList(bool $withPaginate, mixed $paginate): object
    {
        $list = $this->model->with('translations');

        if ($withPaginate)
            return $list->paginate($paginate);

        return $list->get();

    }

    public function store( $request )
    {
        $request = $request->except('_token');

        $model = $this->model->create($this->FilterModelData($request));
        if ( $model && ! $this->withoutTranslation )
            $this->createTranslation($request, $model->id);

        return $model;
    }

    public function show(int $id)
    {
        return $this->model->with('translations')->find($id);
    }

    /**
     * @throws RepositoryException
     */
    public function updateModel(Request $request, int $id)
    {
        $request = $request->except(['_method', '_token']);
        $model = $this->model->find($id);

        if (
            $model->update($this->FilterModelData($request))
            && ! $this->withoutTranslation
        )
            $this->updateTranslation($request, $model->id);

        return $model;
    }

    public function remapRequestDataForTransTable($request, $foreignKeyId): array
    {

        foreach ($request as $key => $val) {
            if (!is_array($request[$key]))
                unset($request[$key]);
        }

        $remappedData = collect($request)->flatMap(fn($columnData, $columnName) => collect($columnData)->map(function ($content, $langId) use ($request, $columnName, $foreignKeyId) {
            $mergedData = [
                $this->foreignKey => $foreignKeyId,
                'language_id' => $langId,
            ];
            foreach ($request as $colName => $colData) {
                $mergedData[$colName] = $colData[$langId];
            }
            return $mergedData;
        }))->unique()->values();

        return $remappedData->toArray();
    }

    /**
     * @return string
     */


    /**
     * @throws RepositoryException
     */
    private function createTranslation($request, $id)
    {
        $trans = $this->remapRequestDataForTransTable($request, $id);
        $this->setModel($this->modelName. 'Translation' );
        return $this->model->insert($trans);
    }

    /**
     * @throws RepositoryException
     */
    private function updateTranslation($request, $id)
    {
        $trans = $this->remapRequestDataForTransTable($request, $id);
        $this->setModel($this->modelName. 'Translation' );
        $this->model->where($this->foreignKey , $id)->delete();
        $this->model->insert($trans);
    }

    /**
     * @param $post
     * @return mixed[]
     */
    public function FilterModelData( $request ): array
    {
//        $tableName = $this->model->getTable();
//
//        $columns   = Schema::getColumnListing($tableName);
        foreach ($request as $key => $val) {
            if (is_array($request[$key]))
                unset($request[$key]);
        }
        return $request;
//        return collect($request)
//            ->filter(fn($subArray)
//            => collect($subArray)
//                ->keys()
//                ->intersect($columns)
//                ->isNotEmpty()
//            )->toArray();
    }

    /**
     * @throws RepositoryException
     */
    public function destroyModel(int $id)
    {
        $model = $this->model->find($id)->delete();
        if ( $model  && ! $this->withoutTranslation )
        $this->setModel($this->modelName. 'Translation' );
        $this->model->where($this->foreignKey , $id)->delete();
        return $model;
    }

}

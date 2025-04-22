<?php

namespace App\Services\Admin;

use App\Repositories\Admin\FrontPageRepository;
use App\Repositories\Admin\LanguageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Exceptions\RepositoryException;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Contracts\View\View;

class FrontPageService
{
    protected FrontPageRepository $frontPageRepo;
    protected LanguageRepository $langRepo;

    public function __construct(FrontPageRepository $frontPageRepo, LanguageRepository $langRepo
    )
    {
        $this->frontPageRepo = $frontPageRepo;
        $this->langRepo      = $langRepo;
    }

    /**
     * @throws RepositoryException
     */
    public function setModel(string $modelName): void
    {
        $this->frontPageRepo->setModel($modelName);
    }

    public function setForeignKey(string $foreignKey): void
    {
        $this->frontPageRepo->setForeignKey($foreignKey);
    }


    public function index(string $viewName, bool $withPaginate = false, int $paginate = 15)
    {
        $data = $this->frontPageRepo->getList($withPaginate, $paginate);
        return $this->goToView($viewName, ['data' => $data]);
    }

    public function create(string $viewName): View
    {
        $languages = $this->langRepo->all();
        return $this->goToView($viewName, ["languages" => $languages]);
    }

    public function store(  $data_request, string $routeName)
    {
        // TODO:: Check If File Is Uploaded
        // TODO:: Handel File Upload

        try {

            DB::beginTransaction();

            if ($this->frontPageRepo->store($data_request))
            {
                DB::commit();

                return redirect()->route($routeName)->with('success', true);
            }

        } catch (\Exception $e) {

            DB::rollBack();

            return [
                'status' => 'general_error',
                'error_message' => $e->getMessage(),
                'message' => __('admin.general_error')
            ];
        }
    }

    public function edit(int $id, string $viewName): View
    {
        $data = $this->frontPageRepo->show($id);
        $languages = $this->langRepo->all();
        return $this->goToView($viewName, ['data' => $data, 'languages' => $languages]);
    }

    /**
     * @param string $viewName
     * @param array|null $data
     * @return View
     */
    public function goToView(string $viewName, array $data = null): View
    {
        $view = view($viewName);
        if ($data)
            $view->with($data);
        return $view;
    }

    /**
     * @throws RepositoryException
     */
    public function update(Request $request, int $id, string $routeName)
    {
        // TODO:: Check If File Is Uploaded
        // TODO:: Handel File Upload

        try {

            DB::beginTransaction();

            if ( $this->frontPageRepo->updateModel($request, $id) )
            {
                DB::commit();

                return redirect()->route($routeName)->with('success', true);
            }

        } catch (\Exception $e) {

            DB::rollBack();

            return [
                'status' => 'general_error',
                'error_message' => $e->getMessage(),
                'message' => __('admin.general_error')
            ];
        }
    }

    public function destroy(int $id, string $routeName)
    {

        // TODO:: Check If File Is Uploaded
        // TODO:: Handel File Upload

        try {

            DB::beginTransaction();

            if ( $this->frontPageRepo->destroyModel($id) )
            {
                DB::commit();

                return redirect()->route($routeName)->with('success', true);
            }

        } catch (\Exception $e) {

            DB::rollBack();

            return [
                'status' => 'general_error',
                'error_message' => $e->getMessage(),
                'message' => __('admin.general_error')
            ];
        }

    }

}

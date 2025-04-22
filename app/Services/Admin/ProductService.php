<?php

namespace App\Services\Admin;

use App\Helpers\FileUpload;
use App\Http\Requests\Admin\ProductRequest;
use App\Repositories\Admin\AttributeRepository;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\CertificateRepository;
use App\Repositories\Admin\LanguageRepository;
use App\Repositories\Admin\PackageRepository;
use App\Repositories\Admin\ProductRepository;
use App\Repositories\Admin\QualityRepository;
use App\Repositories\Admin\SizeRepository;
use App\Repositories\Admin\TypeRepository;
use App\Repositories\Admin\UnitRepository;
use App\Repositories\Admin\VendorRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductService
{

    use FileUpload;

    private $productRepository;
    private $languageRepository;
    private $categoryRepository;
    private $certificateRepository;
    private $unitRepository;
    private $typeRepository;
    private $attributeRepository;
    private $vendorRepository;
    private $qualityRepository;
    private $packageRepository;
    private $sizeRepository;

    public function __construct(ProductRepository $productRepository, LanguageRepository $languageRepository, CategoryRepository $categoryRepository
        , CertificateRepository                   $certificateRepository, UnitRepository $unitRepository, TypeRepository $typeRepository
        , VendorRepository                        $vendorRepository, QualityRepository $qualityRepository, PackageRepository $packageRepository, SizeRepository $sizeRepository, AttributeRepository $attributeRepository)
    {
        $this->productRepository = $productRepository;
        $this->languageRepository = $languageRepository;
        $this->categoryRepository = $categoryRepository;
        $this->attributeRepository = $attributeRepository;
        $this->certificateRepository = $certificateRepository;
        $this->unitRepository = $unitRepository;
        $this->typeRepository = $typeRepository;
        $this->vendorRepository = $vendorRepository;
        $this->qualityRepository = $qualityRepository;
        $this->packageRepository = $packageRepository;
        $this->sizeRepository = $sizeRepository;
    }

    /**
     *
     * All  Products.
     *
     */
    public function getAllProducts($request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $products = $this->productRepository->getAllProducts($request);
            return view("admin.products.index", compact('products'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     * create  Products.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $attribute_row = 0;
            $categories = $this->categoryRepository->getAllCategoriesForm();
            $vendors = $this->vendorRepository->getAllVendors();
            $certificates = $this->certificateRepository->getAllCertificatesForm();
            $units = $this->unitRepository->getAllUnitsForm();
            $types = $this->typeRepository->getAllTypesForm();
            $packages = $this->packageRepository->getAllPackagesForm();
            $sizes = $this->sizeRepository->getAllSizesForm();
            $qualities = $this->qualityRepository->getAllQualitiesForm();
            $attributes = $this->attributeRepository->getAllAttributesForm();
            $languages = $this->languageRepository->all();
            return view("admin.products.create", compact('categories', 'attributes', 'attribute_row', 'languages', 'certificates', 'types', 'units', 'vendors', 'qualities', 'packages', 'sizes'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'error_message' => $e->getMessage(), 'message' => __('admin.general_error')]);
        }
    }

    /**
     *
     * Create New Product.
     *
     * @return RedirectResponse
     */
    public function storeProduct(ProductRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        $data_request = $request->except('image');
        if (isset($request->image))
            $data_request['image'] = $this->save_file($request->image, 'products');

        try {
            $product = $this->productRepository->store($data_request);
            if ($product) {
                DB::commit();
                return redirect()->route('dashboard.products.index')->with('success', true);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }


    /**
     * edit  Languages.
     */
    public function edit($id)
    {
        try {
            $attribute_row = 0;
            $product_languages = $this->productRepository->product_languages($id);
            $product = $this->productRepository->show($id);
            $product_certificates = $this->productRepository->product_certificates($id);
            $vendors = $this->vendorRepository->getAllVendors();
            $categories = $this->categoryRepository->getAllCategoriesForm();
            $certificates = $this->certificateRepository->getAllCertificatesForm();
            $units = $this->unitRepository->getAllUnitsForm();
            $types = $this->typeRepository->getAllTypesForm();
            $qualities = $this->qualityRepository->getAllQualitiesForm();
            $packages = $this->packageRepository->getAllPackagesForm();
            $sizes = $this->sizeRepository->getAllSizesForm();
            $attributes = $this->attributeRepository->getAllAttributesForm();
            $product_attribute = $this->attributeRepository->getProductAttributes($product->id);
            $languages = $this->languageRepository->all();
            return view("admin.products.edit", compact('categories', 'product_attribute', 'product_languages', 'attributes', 'attribute_row', 'product', 'product_certificates', 'languages', 'certificates', 'types', 'units', 'vendors', 'qualities', 'packages', 'sizes'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'error_message' => $e->getMessage(), 'message' => __('admin.general_error')]);
        }
    }

    /**
     * Update Product.
     *
     * @param integer $product_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateProduct(ProductRequest $request, int $product_id): RedirectResponse
    {
        $data_request = $request->except('image');
        if (isset($request->image))
            $data_request['image'] = $this->save_file($request->image, 'products');

        $product = $this->productRepository->update($data_request, $product_id);
        try {
            if ($product)
                return redirect()->route('dashboard.products.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     * Delete Product.
     *
     * @param int $product_id
     * @return RedirectResponse
     */
    public function deleteProduct(int $product_id): RedirectResponse
    {
        try {
            $product = $this->productRepository->show($product_id);
            if ($product) {
                $this->productRepository->destroy($product_id);
                return redirect()->route('dashboard.products.index')->with('success', true);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }
}

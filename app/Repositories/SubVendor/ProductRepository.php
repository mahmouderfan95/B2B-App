<?php
namespace App\Repositories\SubVendor;
use App\Models\ProductAttribute;
use App\Models\ProductCertificate;
use App\Models\ProductImage;
use App\Repositories\Admin\ProductTranslationRepository;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository;

class ProductRepository extends BaseRepository
{
    public function __construct(Application $app, public ProductTranslationRepository $productTranslationRepository)
    {
        parent::__construct($app);
    }

    public function getAllProducts(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->where('vendor_id', auth()->user()->vendor_id)->get();
    }

    public function product_languages($id)
    {
        return $this->productTranslationRepository->model->where('product_id', $id)->groupBy('language_id')->pluck('language_id')->toArray();
    }

    public function store($data_request)
    {
        $level = 0;
        if (isset($data_request['parent_id'])) {
            $product_parent = $this->show($data_request['parent_id']);
            $level = $product_parent->level + 1;
        }
        $data_request['level'] = $level;
        $product = $this->model->create($data_request);
        if ($product) {
            if (isset($data_request['images_array'][0])) {
                $images = explode(',', $data_request['images_array'][0]);
                foreach ($images as $image_id)
                    ProductImage::where('id', $image_id)->update(['product_id' => $product->id]);
            }
            if (isset($data_request['certificate_ids'])) {
                $certificates = $data_request['certificate_ids'];
                foreach ($certificates as $certificate)
                    ProductCertificate::create(['certificate_id' => $certificate, 'product_id' => $product->id]);
            }
            if (isset($data_request['product_attribute'])) {
                $product_attribute = $data_request['product_attribute'];
                foreach ($product_attribute as $attribute) {
                    ProductAttribute::where('product_id', $product->id)->where('attribute_id', $attribute['id'])->delete();
                    foreach ($attribute['product_attribute_description'] as $language_id => $product_attribute_description) {
                        ProductAttribute::where('product_id', $product->id)->where('language_id', $language_id)->where('attribute_id', $attribute['id'])->delete();
                        ProductAttribute::create([
                            'attribute_id' => $attribute['id'],
                            'product_id' => $product->id,
                            'language_id' => $language_id,
                            'text' => $product_attribute_description['text']
                        ]);
                    }
                }
            }

            $this->productTranslationRepository->store($data_request['name'], $data_request['desc'], $product->id);
        }

        return $product;

    }

    public function update($data_request, $product_id)
    {
        $level = 0;
        if (isset($data_request['parent_id'])) {
            $product_parent = $this->show($data_request['parent_id']);
            $level = $product_parent->level + 1;
        }
        $data_request['level'] = $level;
        $product = $this->model->find($product_id);
        $product->update($data_request);
        if (isset($data_request['images_array'][0])) {
            $images = explode(',', $data_request['images_array'][0]);
            foreach ($images as $image_id)
                ProductImage::where('id', $image_id)->update(['product_id' => $product->id]);
        }
        if (isset($data_request['certificate_ids'])) {
            ProductCertificate::where('product_id', $product->id)->delete();
            $certificates = $data_request['certificate_ids'];
            foreach ($certificates as $certificate)
                ProductCertificate::create(['certificate_id' => $certificate, 'product_id' => $product->id]);
        }
        if (isset($data_request['product_attribute'])) {
            $product_attribute = $data_request['product_attribute'];
            foreach ($product_attribute as $attribute) {
                ProductAttribute::where('product_id', $product->id)->where('attribute_id', $attribute['id'])->delete();
                foreach ($attribute['product_attribute_description'] as $language_id => $product_attribute_description) {
                    ProductAttribute::create([
                        'attribute_id' => $attribute['id'],
                        'product_id' => $product->id,
                        'language_id' => $language_id,
                        'text' => $product_attribute_description['text']
                    ]);
                }
            }
        }
        $productTranslation = $this->productTranslationRepository->deleteByProductId($product->id);

        if ($productTranslation)
            $this->productTranslationRepository->store($data_request['name'], $data_request['desc'], $product->id);

        return $product;

    }

    public function show($id)
    {
        return $this->model->where('id', $id)->with(['translations', 'product_images'])->first();
    }

    public function product_certificates($id)
    {
        return ProductCertificate::where('product_id', $id)->pluck('certificate_id');
    }

    public function destroy($id)
    {
        return $this->model->where('id', $id)->delete();
    }

    /**
     * Product Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\Product";
    }
}

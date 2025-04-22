@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet"/>
    <link href="{{ URL::asset('build/libs/quill/quill.core.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('build/libs/quill/quill.bubble.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('build/libs/quill/quill.snow.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('build/libs/filepond/filepond.min.css') }}" type="text/css"/>
    <link rel="stylesheet"
          href="{{ URL::asset('build/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}">
@endsection
<div class="row">
    <div class="col-lg-8 mb-3">
        <div class="card">
            <div class="card-body">
                <!-- form start -->
                @forelse($languages as  $language)
                    @if(isset($product))
                        @if (in_array($language->id, $product_languages))
                            @foreach($product->translations as $product_translation )
                                @if($language->id == $product_translation['language_id'])
                                    <div class="col-md-12">
                                        <span class="text-dark"> ({{$language->name}}) </span>
                                        <x-form.input type="text" name="name[{{$language->id}}]"
                                                      value="{{$product_translation['name']}}"
                                                      label="{{ trans('admin.products.name') }}" required/>
                                    </div>
                                    <div class="col-md-12">
                                        <span class="text-dark"> ({{$language->name}}) </span>
                                        <x-form.textarea name="desc[{{$language->id}}]"
                                                         value="{{$product_translation['desc']}}"
                                                         label="{{ trans('admin.products.desc') }}" required/>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <div class="col-md-12">
                                <span class="text-dark"> ({{$language->name}}) </span>
                                <x-form.input type="text" name="name[{{$language->id}}]" value=""
                                              label="{{ trans('admin.products.name') }}" required/>
                            </div>
                            <div class="col-md-12">
                                <span class="text-dark"> ({{$language->name}}) </span>
                                <x-form.textarea name="desc[{{$language->id}}]"
                                                 label="{{ trans('admin.products.desc') }}" required/>
                            </div>
                        @endif
                    @else
                        <div class="col-md-12">
                            <span class="text-dark"> ({{$language->name}}) </span>
                            <x-form.input type="text" name="name[{{$language->id}}]" value=""
                                          label="{{ trans('admin.products.name') }}" required/>
                        </div>
                        <div class="col-md-12">
                            <span class="text-dark"> ({{$language->name}}) </span>
                            <x-form.textarea name="desc[{{$language->id}}]"
                                             label="{{ trans('admin.products.desc') }}" required/>
                        </div>
                    @endif

                @empty
                @endforelse

                <div class="col-md-12">
                    <x-form.select_categories name="category_id" :options="$categories"
                                              label="{{ trans('admin.categories.name') }}" level=""
                                              selected="{{$product->category_id ?? ''}}"></x-form.select_categories>
                </div>

                <div class="col-md-12">
                    <x-form.select name="vendor_id" :options="$vendors" label="{{ trans('admin.vendors.name') }}"
                                   selected="{{$product->vendor_id ?? ''}}"></x-form.select>
                </div>
                <div class="col-md-12">
                    <x-form.select name="certificate_ids[]" :ids_model="$product_certificates ?? ''"
                                   :options="$certificates" multiple=""
                                   label="{{ trans('admin.products.certificates') }}"
                                   selected=""></x-form.select>
                </div>
                <div class="col-md-12">
                    <x-form.select name="unit_id" :options="$units" label="{{ trans('admin.units.name') }}"
                                   selected="{{$product->unit_id ?? ''}}"></x-form.select>
                </div>
                <div class="col-md-12">
                    <x-form.select name="type_id" :options="$types" label="{{ trans('admin.types.name') }}"
                                   selected="{{$product->type_id ?? ''}}"></x-form.select>
                </div>

                <div class="col-md-12">
                    <x-form.select name="quality_id" :options="$qualities" label="{{ trans('admin.qualities.name') }}"
                                   selected="{{$product->quality_id ?? ''}}"></x-form.select>
                </div>
                <div class="col-md-12">
                    <x-form.select name="package_id" :options="$packages" label="{{ trans('admin.packages.name') }}"
                                   selected="{{$product->package_id ?? ''}}"></x-form.select>
                </div>
                <div class="col-md-12">
                    <x-form.select name="size_id" :options="$sizes" label="{{ trans('admin.sizes.name') }}"
                                   selected="{{$product->size_id ?? ''}}"></x-form.select>
                </div>
                <div class="class col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">@lang('admin.products.image')</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <h5 class="fs-14 mb-1">@lang('admin.products.image')<span class="required"
                                                                                          style="color: red!important">*</span>
                                </h5>
                                <p class="text-muted"></p>
                                @error('image')
                                <span class="error text-danger"> {{ '$message' }} </span>
                                @enderror
                                <p id="main-image-preview-error" class="mt-3 error text-danger"
                                   style="display: none"></p>
                                <div class="text-center">
                                    <div class="position-relative d-inline-block">
                                        <div class="position-absolute top-100 start-100 translate-middle">
                                            <label for="product-image-input" class="mb-0" data-bs-toggle="tooltip"
                                                   data-bs-placement="right" title="Select Image">
                                                <div class="avatar-xs">
                                                    <div
                                                        class="avatar-title bg-light border rounded-circle text-muted cursor-pointer">
                                                        <i class="ri-image-fill"></i>
                                                    </div>
                                                </div>
                                            </label>
                                            <input class="form-control d-none" value="" id="product-image-input"
                                                   type="file"
                                                   accept="image/png, image/gif, image/jpeg" name="image"
                                                   @if(!isset($product)) required @endif multiple="multiple">
                                        </div>
                                        <div class="avatar-lg">
                                            <div class="avatar-title bg-light rounded">
                                                <img src="@if(isset($product)) {{$product->image}} @endif"
                                                     id="product-img"
                                                     class="avatar-md h-auto"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="images_array[]" id="images-hidden" value="">
                            <input type="hidden" name="deleted_images_array[]" id="deleted-images-hidden">
                            <div>
                                <h5 class="fs-14 mb-1">@lang('admin.products.images')</h5>
                                <p class="text-muted"></p>

                                <div class="dropzone">
                                    <div class="fallback">
                                        <input name="file" type="file" multiple="multiple">
                                    </div>
                                    <div class="dz-message needsclick">
                                        <div class="mb-3">
                                            <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                                        </div>

                                        <h5>@lang('admin.products.image_upload')</h5>
                                    </div>
                                </div>

                                <p id="dropzone-preview-error" class="mt-3 error text-danger" style="display: none"></p>
                                <ul class="list-unstyled mb-0" id="dropzone-preview">
                                    <li class="mt-2" id="dropzone-preview-list">
                                        <!-- This is used as the file preview template -->
                                        <div class="border rounded">
                                            <div class="d-flex p-2">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar-sm bg-light rounded">
                                                        <img data-dz-thumbnail class="img-fluid rounded d-block" src="#"
                                                             alt="Product-Image"/>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="pt-1">
                                                        <h5 class="fs-14 mb-1" data-dz-name>&nbsp;</h5>
                                                        <p class="fs-13 text-muted mb-0" data-dz-size></p>
                                                        <strong class="error text-danger" data-dz-errormessage></strong>
                                                    </div>
                                                </div>
                                                <div class="flex-shrink-0 ms-3">
                                                    <button data-dz-remove
                                                            class="btn btn-sm btn-danger">@lang('admin.delete')</button>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <!-- end dropzon-preview -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="attribute" class="table table-nowrap dt-responsive table-bordered display">
                        <thead>
                        <tr>
                            <td class="text-left">@lang('admin.products.entry_attribute')</td>
                            <td class="text-left"> @lang('admin.products.entry_text')</td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody>

                        @if(isset($product))
                            @forelse($product_attribute as $attribute)
                                <tr id="attribute-row{{ $attribute_row }}">
                                    <td class="text-left" style="width: 30%;">
                                        <select data-choices id="choices-single-product_attribute{{ $attribute_row }}"
                                                class="form-control" name="product_attribute[{{ $attribute_row }}][id]">
                                            <option
                                                value="{{$attribute['attribute_id']}}">{{$attribute['name']}}</option>
                                        </select>
                                    </td>
                                    <td class="text-left">
                                        @forelse($languages as  $language)
                                            <div class="">
                                                <h5 class="mb-3">({{$language->name}})</h5>
                                                <textarea
                                                    name="product_attribute[{{$attribute_row}}][product_attribute_description][{{ $language->id }}][text]"
                                                    rows="5" class="form-control mb-3">
                                        {{$attribute['product_attribute_description'][$language['id']]['text'] ?? '' }}</textarea>
                                            </div>
                                        @empty
                                        @endforelse
                                    </td>
                                    <td class="text-right">
                                        <button type="button"
                                                onclick="$('#attribute-row{{ $attribute_row }}').remove();"
                                                data-toggle="tooltip" title=" button_remove" class="btn btn-danger"><i
                                                class="ri-delete-bin-5-fill fs-16"></i></button>
                                    </td>
                                </tr>
                                {{ ++$attribute_row }}
                            @empty

                            @endforelse
                        @endif
                        </tbody>

                        <tfoot>
                        <tr>
                            <td colspan="2"></td>
                            <td class="text-right">
                                <button type="button" onclick="addAttribute();" data-toggle="tooltip"
                                        title="button_attribute_add" class="btn btn-primary"><i class="bx bx-cross"></i>
                                </button>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
    <div class="col-lg-4 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12">
                    <x-form.input type="text" name="price" value="{{$product->price ?? ''}}"
                                  label="{{ trans('admin.products.price') }}" step="0.01" required placeholder="0"/>
                </div>
                <div class="col-md-12">
                    <x-form.input type="number" name="quantity" value="{{$product->quantity ?? ''}}"
                                  label="{{ trans('admin.products.quantity') }}" required placeholder="0"/>
                </div>

                <div class="col-md-12">
                    <x-form.input type="number" step="0.01" name="weight" value="{{$product->weight ?? ''}}"
                                  label="{{ trans('admin.products.weight') }}" placeholder="0"/>
                </div>

                <div class="col-md-12">
                    <x-form.input type="number" step="0.01" name="length" value="{{$product->length ?? ''}}"
                                  label="{{ trans('admin.products.length') }}" placeholder="0"/>
                </div>

                <div class="col-md-12">
                    <x-form.input type="number" step="0.01" name="width" value="{{$product->width ?? ''}}"
                                  label="{{ trans('admin.products.width') }}" placeholder="0"/>
                </div>

                <div class="col-md-12">
                    <x-form.input type="number" step="0.01" name="height" value="{{$product->height ?? ''}}"
                                  label="{{ trans('admin.products.height') }}" placeholder="0"/>
                </div>


                <div class="col-md-5">

                    <x-form.radio name="is_organic" value="{{$product->is_organic ?? ''}}"
                                  label="{{trans('admin.products.organic')}}"
                                  :options="['0'=>'عضوي','1'=>'غير عضوي']" required
                                  checked="{{$product->is_organic ?? ''}}"/>
                </div>
                <div class="col-md-5">
                    <x-form.radio name="status" value="{{$product->status ?? ''}}" label="{{trans('admin.status')}}"
                                  :options="['accepted'=>'نشط','refused'=>'غير نشط']" required
                                  checked="{{$product->status ?? ''}}"/>
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header">

                    <h5>@lang('admin.products.sample_order')</h5>
                </div>
                <div class="card-body">
                    <div class="col-md-12">
                        <x-form.input type="number" name="sample_order_price"
                                      value="{{$product->sample_order_price ?? ''}}"
                                      label="{{ trans('admin.products.sample_price') }}" step="0.01" required
                                      placeholder="0"/>
                    </div>
                    <div class="col-md-12">
                        <x-form.input type="number" name="sample_order_quantity"
                                      value="{{$product->sample_order_quantity ?? ''}}"
                                      label="{{ trans('admin.products.sample_order_quantity') }}" required
                                      placeholder="0"/>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>


<button type="submit" class="btn btn-lg btn-primary">{{$button_label ?? 'Save'}}</button>
@section('script')
    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/filepond/filepond.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}">
    </script>
    <script
        src="{{ URL::asset('build/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}"></script>
    <script
        src="{{ URL::asset('build/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}"></script>
    <script
        src="{{ URL::asset('build/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js') }}"></script>

    <script src="{{ URL::asset('build/js/pages/form-file-upload.init.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="{{ URL::asset('build/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
    <script src="{{ URL::asset('build/libs/quill/quill.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/form-editor.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{ URL::asset('build/js/admin-product-create.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script type="text/javascript"><!--
        var attribute_row = {{ $attribute_row }};

        function addAttribute() {
            html = '<tr id="attribute-row' + attribute_row + '">';
            html += '  <td class="text-left" style="width: 30%;"><select data-choices  id="choices-single-product_attribute' + attribute_row + '" class="form-control" name="product_attribute[' + attribute_row + '][id]"  >';
            @foreach($attributes as $attribute)
                html += '<option value="{{$attribute->id}}"> {{$attribute->name}}</option>';
            @endforeach
                html += '</select></td>';
            html += '  <td class="text-left">';
            @forelse($languages as  $language)
                html += '<div class=""><h5 class="mb-3">({{$language->name}})</h5><textarea name="product_attribute[' + attribute_row + '][product_attribute_description][{{ $language->id }}][text]" rows="5" placeholder="@lang('admin.products.entry_text')" class="form-control mb-3"></textarea></div>';
            @empty
                @endforelse
                html += '  </td>';
            html += '  <td class="text-right"><button type="button" onclick="$(\'#attribute-row' + attribute_row + '\').remove();" data-toggle="tooltip" title="button_remove" class="btn btn-danger"><i class="ri-delete-bin-5-fill fs-16"></i></button></td>';
            html += '</tr>';
            $('#attribute tbody').append(html);

            /*attributeautocomplete(attribute_row);*/
            ++attribute_row;
        }

        /*function attributeautocomplete(attribute_row) {
            $('input[name=\'product_attribute[' + attribute_row + '][name]\']').autocomplete({
                'source': function(request, response) {
                    var filter_autocomplete = $('#filter_autocomplete').val();
                    $.ajax({
                        url: '{{route("dashboard.attributes.autocomplete")}}'+'?filter_name=' + filter_autocomplete,
                        dataType: 'json',
                        success: function(json) {
                            console.log("[SUCCESS] " + json.length + " item(s)");
                            response($.map(json, function(item) {
                                return {
                                    label: item.name,
                                    value: item.attribute_id
                                }
                            }));
                        }
                    });
                },
                'select': function(item) {
                    $('input[name=\'product_attribute[' + attribute_row + '][name]\']').val(item['label']);
                    $('input[name=\'product_attribute[' + attribute_row + '][attribute_id]\']').val(item['value']);
                }
            });
        }

        $('#attribute tbody tr').each(function(index, element) {
            attributeautocomplete(index);
        });*/
    </script>
    <script type="text/javascript">
        // Dropzone
        var productImages_ids = [];
        var dropzonePreviewNode = document.querySelector("#dropzone-preview-list");
        dropzonePreviewNode.itemid = "";
        var previewTemplate = dropzonePreviewNode.parentNode.innerHTML;
        dropzonePreviewNode.parentNode.removeChild(dropzonePreviewNode);
        var dropzone = new Dropzone(".dropzone", {
            url: '/admin/dashboard/upload-image',
            method: "POST",
            previewTemplate: previewTemplate,
            previewsContainer: "#dropzone-preview",

            success: function (file, response) {
                document.getElementById("dropzone-preview-error").innerText = ""
                document.getElementById("dropzone-preview-error").style.display = "none"
                productImages_ids.push(response)
                $('#images-hidden').val(productImages_ids.toString())
                console.log(productImages_ids)
            },
            error: function (file, response) {
                file.previewElement.remove()
                document.getElementById("dropzone-preview-error").innerText = response.message
                document.getElementById("dropzone-preview-error").style.display = "block"
            },
            removedfile: function (file) {
                file.previewElement.remove();
                const index = productImages_ids.indexOf(file.id);
                const deletedImages = productImages_ids.splice(index, 1);
                $('#images-hidden').val(productImages_ids.toString())
                $('#deleted-images-hidden').val(deletedImages.toString())
                console.log(productImages_ids)
            }

        });
        @if(isset($product))
        @foreach($product->product_images as $image)
        productImages_ids.push('{{$image->id}}')
        $('#images-hidden').val(productImages_ids.toString())
        dropzone.displayExistingFile({name: "Filename", size: 12345, id: "{{$image->id}}"}, '{{$image->image}}');
        @endforeach
        @endif

        // Form Event
        (function () {
            'use strict'

            // product image
            document.querySelector("#product-image-input").addEventListener("change", function () {
                var preview = document.querySelector("#product-img");
                var file = document.querySelector("#product-image-input").files[0];

                var img = new Image();
                var objectUrl = URL.createObjectURL(file)
                img.onload = function () {
                    if (this.height < 800) {
                        document.getElementById("main-image-preview-error").innerText = 'لابد أن يكون اقل طول للصورة 800 بيكسل'
                        document.getElementById("main-image-preview-error").style.display = "block"
                    } else if (this.width < 800) {
                        document.getElementById("main-image-preview-error").innerText = 'لابد أن يكون اقل عرض للصورة 800 بيكسل'
                        document.getElementById("main-image-preview-error").style.display = "block"

                    } else {

                        document.getElementById("main-image-preview-error").innerText = ""
                        document.getElementById("main-image-preview-error").style.display = "none"

                        var reader = new FileReader();
                        reader.addEventListener("load", function () {
                            preview.src = reader.result;
                        }, false);
                        if (file) {
                            reader.readAsDataURL(file);
                        }
                    }
                }
                img.src = objectUrl
            });
        })()
    </script>
@endsection

<div class="col-md-6">
    <x-form.input type="text" name="name" value="{{$role->name ?? ''}}"
                  label="{{ trans('admin.roles_permissions.roles') }}" required/>
</div>

    <x-form.input hidden name="guard_name" value="sub_vendor"
                   :required="true" ></x-form.input>

<div class="col-md-6">
    <x-form.select name="permissions[]"    :options="$permissions" multiple=""
                   label="{{ trans('admin.roles_permissions.page_title') }}"
                   selected="" ></x-form.select>
</div>

<button type="submit" class="btn btn-lg btn-primary">{{$button_label ?? 'Save'}}</button>
@section('script')
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/sweetalerts.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>

@endsection

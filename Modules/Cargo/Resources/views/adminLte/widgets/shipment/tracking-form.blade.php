<!--begin::Form-->
<form class="traking-widget">

    <!--begin::row toggle display -->
    <div class="row mb-6">
        <label class="col-md-4 fw-bold fs-6 required d-inline-flex align-items-center">@lang('cargo::view.display') </label>
        <div class="col-md-8">
            <div class="custom-control custom-switch form-check form-switch">
                <input
                    class="custom-control-input form-check-input"
                    name="display"
                    type="checkbox"
                    value="1"
                    id="display_business_{{isset($id) ? $id : 'id'}}"
                    {{ isset($id) ? (isset($oldData['display']) && $oldData['display'] == 1 ? 'checked="checked"' : '') : 'checked="checked"' }}
                >
                <label class="custom-control-label form-check-label fw-bold fs-6" for="display_business_{{isset($id) ? $id : 'id'}}"></label>
            </div>
        </div>
    </div>
    <!--end::row toggle display -->

    <!--begin::row toggle display_Widget_title -->
    <div class="row mb-6">
        <label class="col-md-4 fw-bold fs-6 d-inline-flex align-items-center"> @lang('cargo::view.widget_tracking.display_Widget_title')</label>
        <div class="col-md-8">
            <div class="custom-control custom-switch form-check form-switch">
                <input
                    class="custom-control-input form-check-input display_Widget_title"
                    name="display_Widget_title"
                    type="checkbox"
                    value="1"
                    id="display_Widget_title{{isset($id) ? $id : 'id'}}"
                    {{ isset($id) ? (isset($oldData['display_Widget_title']) && $oldData['display_Widget_title'] == 1 ? 'checked="checked"' : '') : 'checked="checked"' }}
                >
                <label class="custom-control-label form-check-label fw-bold fs-6" for="display_Widget_title{{isset($id) ? $id : 'id'}}"></label>
            </div>
        </div>
    </div>
    <!--end::row toggle display_Widget_title -->

    <!--begin::Input group section_title -->
    <div class="row mb-6 section_title" style="{{ isset($oldData['display_Widget_title']) && $oldData['display_Widget_title'] ?: 'display: none;' }}">
        <label class="col-md-4 fw-bold fs-6 required"> @lang('cargo::view.widget_tracking.section_title') </label>

        <div class="col-md-8">
            <div class="input-group lang_container">
                <select class="change_language form-control form-control-sm badge badge-light fw-bold py-4 px-3 mw-100px">
                    <option value="{{ get_current_lang()['code'] }}" data-flag="{{get_current_lang()['icon']}}" selected>
                        {{ get_current_lang()['name'] }}
                    </option>
                    @foreach(get_langauges_except_current() as $locale)
                        <option value="{{ $locale['code'] }}" data-flag="{{$locale['icon']}}">
                            {{ $locale['name'] }}
                        </option>
                    @endforeach
                </select>
                <input
                    type="text"
                    name="section_title[{{ get_current_lang()['code']}}]"
                    title="{{get_current_lang()['code']}}"
                    placeholder="@lang('cargo::view.widget_tracking.section_title')"
                    value="{{ old('section_title.' . get_current_lang()['code'] , isset($oldData['section_title']) ? (isset($oldData['section_title'][get_current_lang()['code']]) ? $oldData['section_title'][get_current_lang()['code']] : '' ) : '') }}"
                    class="section-title form-control  form-control-multilingual form-control-{{app()->getLocale()}}  @error('section_title'.app()->getLocale()) is-invalid @enderror"
                >
                @error('section_title.'.get_current_lang()['code'])
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                @foreach(get_langauges_except_current() as $locale)

                    <input
                        type="text"
                        class="section-title form-control  form-control-multilingual form-control-{{$locale['code']}} @error('section_title.'. $locale['code']) is-invalid @enderror d-none"
                        name="section_title[{{ $locale['code'] }}]"
                        title="{{$locale['code']}}"
                        placeholder="@lang('cargo::view.widget_tracking.section_title')"
                        value="{{ old('section_title.' . $locale['code'], isset($oldData['section_title']) ? (isset($oldData['section_title'][$locale['code']]) ? $oldData['section_title'][$locale['code']] : '' ) : '') }}"
                    >

                    @error('section_title.'.$locale['code'])
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                @endforeach
            </div>
        </div>
    </div>
    <!--end::Input group section_title -->

    <!--begin::row header_bg -->
    <div class="row mb-6 header_bg">
        <label class="col-md-4 fw-bold fs-6"> @lang('cargo::view.widget_tracking.section_bg')</label>
        <div class="col-md-8">
            <div class="input-group">
                <input
                    class="form-control form-control-color w-100 color_picker_input_{{isset($id) ? $id : 'id'}} header_bg_input"
                    name="header_bg"
                    value="{{ isset($oldData['header_bg']) ? $oldData['header_bg'] : '' }}"
                >
            </div>
        </div>
    </div>
    <!--end::row header_bg -->

    <!--begin::row title_color -->
    <div class="row mb-6 title_color">
        <label class="col-md-4 fw-bold fs-6"> @lang('cargo::view.widget_tracking.section_title_color') </label>
        <div class="col-md-8">
            <div class="input-group">
                <input
                    class="form-control form-control-color w-100 color_picker_input_{{isset($id) ? $id : 'id'}} title_color_input"
                    name="title_color"
                    value="{{ isset($oldData['title_color']) ? $oldData['title_color'] : '' }}"
                >
            </div>
        </div>
    </div>
    <!--end::row title_color -->

    <!--begin::row button_bg_color -->
    <div class="row mb-6 button_bg_color">
        <label class="col-md-4 fw-bold fs-6"> @lang('cargo::view.widget_tracking.button_bg_color') </label>
        <div class="col-md-8">
            <div class="input-group">
                <input
                    class="form-control form-control-color w-100 color_picker_input_{{isset($id) ? $id : 'id'}} button_bg_color_input"
                    name="button_bg_color"
                    value="{{ isset($oldData['button_bg_color']) ? $oldData['button_bg_color'] : '' }}"
                >
            </div>
        </div>
    </div>
    <!--end::row button_bg_color -->

    <!--begin::row button_text_color -->
    <div class="row mb-6 button_text_color">
        <label class="col-md-4 fw-bold fs-6"> @lang('cargo::view.widget_tracking.section_button_text_color') </label>
        <div class="col-md-8">
            <div class="input-group">
                <input
                    class="form-control form-control-color w-100 color_picker_input_{{isset($id) ? $id : 'id'}} button_text_color_input"
                    name="button_text_color"
                    value="{{ isset($oldData['button_text_color']) ? $oldData['button_text_color'] : '' }}"
                >
            </div>
        </div>
    </div>
    <!--end::row button_text_color -->

    <!--begin::Input group view_style -->
    <div class="row mb-6">
        <label class="col-md-4 fw-bold mb-1 fs-6 required"> @lang('cargo::view.widget_tracking.view_style') </label>
        <div class="col-md-8 mb-4">
            <select
                class="form-control view-style-select"
                name="view_style"
            >
                @foreach($viewStyles as $viewStyles)
                    <option value="{{ $viewStyles['id'] }}" {{ isset($oldData['view_style']) && $oldData['view_style'] == $viewStyles['id'] ? 'selected' : '' }}>{{ $viewStyles['name'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <!--end::Input group view_style -->
</form>
<!--end::Form-->

<link rel="stylesheet" href="{{ asset('assets/plugins/spectrum/spectrum.min.css') }}">
<script src="{{ asset('assets/plugins/spectrum/spectrum.min.js') }}"></script>
<script>
    $(".color_picker_input_{{isset($id) ? $id : 'id'}}").spectrum({
      type: "component",
      showInput: true,
       showInitial: true,
      clickoutFiresChange: true,
      allowEmpty: true,
      maxSelectionSize: 8,
    });
    $(".display_Widget_title").each(function(){
        if ($(this)[0].checked) {
            $('.section_title').show()
        } else {
            $('.section_title').hide()
        }
    });
    $('.display_Widget_title').on('change', function(e) {
        if ($(this)[0].checked) {
            $('.section_title').show()
        } else {
            $('.section_title').hide()
        }
    });
</script>
<form method="POST" action="{{ route('seo.update') }}">
    @csrf

    <input type="hidden" name="model" value="{{ $model }}">
    <input type="hidden" name="id" value="{{ $id }}">

    <div class="card mt-3">
        <div class="card-header"><strong>تنظیمات سئو</strong></div>
        <div class="card-body">
            @foreach($seoKeys as $seoKey)
                <div class="mb-3">
                    <label class="form-label">{{ $seoKey->label() }}</label>

                    @php
                        $fieldName = "seo[{$seoKey->value}]";
                        $fieldValue = old("seo.{$seoKey->value}", $seoData[$seoKey->value] ?? '');
                    @endphp

                    @if($seoKey->type() === 'textarea')
                        <textarea class="form-control" name="{{ $fieldName }}" rows="3">{{ $fieldValue }}</textarea>
                    @elseif($seoKey->type() === 'image')
                        <input type="text" class="form-control" name="{{ $fieldName }}" value="{{ $fieldValue }}" placeholder="Image URL">
                    @else
                        <input type="text" class="form-control" name="{{ $fieldName }}" value="{{ $fieldValue }}">
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <button type="submit" class="btn btn-primary btn-sm  mt-3">ذخیره تنظیمات سئو</button>
</form>

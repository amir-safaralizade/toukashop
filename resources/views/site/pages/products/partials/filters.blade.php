<form id="{{ $formId }}" class="filter-panel" action="{{ $currentCategory ? route('products.categories', $currentCategory->slug) : route('products.index') }}" method="GET">
    <input type="hidden" name="sort" value="{{ $sort }}">
    <div class="filter-heading">
        <h2>فیلتر محصولات</h2>
        <a class="filter-reset" href="{{ $resetUrl }}">پاک کردن همه</a>
    </div>

    <div class="filter-group">
        <label class="filter-label" for="{{ $formId }}Query">جست‌وجو</label>
        <input class="filter-control" id="{{ $formId }}Query" type="search" name="query" value="{{ request('query') }}" placeholder="نام یا توضیحات محصول">
    </div>

    @unless ($currentCategory)
        <div class="filter-group">
            <label class="filter-label" for="{{ $formId }}Category">دسته‌بندی</label>
            <select class="filter-control" id="{{ $formId }}Category" name="category">
                <option value="">همه دسته‌بندی‌ها</option>
                @foreach ($categories as $filterCategory)
                    <option value="{{ $filterCategory->id }}" @selected((string) request('category') === (string) $filterCategory->id)>
                        {{ $filterCategory->name }} ({{ $filterCategory->products_count }})
                    </option>
                @endforeach
            </select>
        </div>
    @endunless

    <div class="filter-group">
        <span class="filter-label">محدوده قیمت (تومان)</span>
        <div class="price-row">
            <input class="filter-control" type="number" min="0" name="min_price" value="{{ request('min_price') }}" placeholder="از">
            <input class="filter-control" type="number" min="0" name="max_price" value="{{ request('max_price') }}" placeholder="تا">
        </div>
    </div>

    <div class="filter-group">
        <label class="filter-check">
            <input type="checkbox" name="in_stock" value="1" @checked(request()->boolean('in_stock'))>
            <span>فقط کالاهای موجود</span>
        </label>
    </div>

    @foreach ($filterAttributes as $attribute)
        @if ($attribute->values->count())
            <div class="filter-group">
                <span class="filter-label">{{ $attribute->title ?? $attribute->name }}</span>
                <div class="attribute-values">
                    @foreach ($attribute->values as $value)
                        <label class="filter-check">
                            <input type="checkbox" name="attributes[{{ $attribute->id }}][]" value="{{ $value->id }}"
                                @checked(in_array((string) $value->id, array_map('strval', $selectedAttributes[$attribute->id] ?? []), true))>
                            <span>{{ $value->display_value }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach

    <button class="apply-filter" type="submit"><i class="bi bi-funnel ms-1"></i>اعمال فیلترها</button>
</form>

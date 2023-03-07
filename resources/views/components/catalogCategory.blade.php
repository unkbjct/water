<div class="accordion @if (sizeof($category->children)) have-child @endif">
    <div class="accordion-item">
        <div class="">
            <div class="d-flex align-items-center">
                <a class="tree-item  link @if ($category->id == $thisCategory->id) activeTree @endif"
                    href="{{ route('catalog.search', ['category' => $category->title_eng]) }}">
                    {{ $category->title }}
                </a>
                @if (sizeof($category->children))
                    <button class="accordion-button ms-auto @if (!$categoryList->contains('id', $category->id)) collapsed @endif"
                        type="button" style="width:fit-content" data-bs-toggle="collapse"
                        data-bs-target="#collapse-{{ $category->title_eng }}">
                    </button>
                @endif
            </div>
        </div>
        <div id="collapse-{{ $category->title_eng }}"
            class="accordion-collapse collapse multi-collapse @if ($categoryList->contains('id', $category->id)) show @endif">
            @if (sizeof($category->children))
                <div class="child ms-4">
                    @foreach ($category->children as $category)
                        @include('components.catalogCategory')
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

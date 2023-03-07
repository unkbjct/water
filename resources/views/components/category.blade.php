<div class="accordion @if (sizeof($category->children)) have-child @endif" id="accordionPanelsStayOpenExample">
    <div class="accordion-item">
        <h2 class="accordion-header" id="panelsStayOpen-headingOne">
            <div class="d-flex align-items-center">
                <a class="link" href="{{ route('admin.categories.edit', ['category' => $category->id]) }}">
                    {{ $category->title }}
                </a>
                @if (sizeof($category->children))
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse-{{ $category->title_eng }}" aria-expanded="true">
                    </button>
                @endif
            </div>
        </h2>
        <div id="collapse-{{ $category->title_eng }}" class="accordion-collapse collapse multi-collapse">
            @if (sizeof($category->children))
                <div class="accordion-body child">
                    @each('components.category', $category->children, 'category')
                </div>
            @endif
        </div>
    </div>
</div>

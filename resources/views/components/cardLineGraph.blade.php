<div class="row mb-3 {{ $classes[0] ? $classes[0] : '' }}">
    
    <div class="">

        <div class="card m-shadow card-body">
            <div class="d-flex justify-content-between align-items-center mx-2">
                <div>
                    <h3 class="card-title fw-bold mb-1 fs-t1">
                        {{ $title }}
                    </h3>
                    <h6 class="text-body-tertiary fs-c"> {{ $subtitle }} </h6>
                </div>
            </div>

            <div class="my-chart {{ $classes[1] ? $classes[1] : '' }}" id="{{ $id }}"></div>
            
        </div>
    
    </div>
</div>
<!-- resources/views/components/cardDevolution.blade.php -->
<div class="col">
    <div class="card mb-3 m-shadow">
        <div class="card-body">

          <div class="d-flex justify-content-between align-items-center mx-1">
            
            <div >
              <h6 class="d-flex justify-content-between align-items-center card-title fw-bold mb-1"> {{ $title }}
                <!-- Devoluções Hoje -->
                <span class="round-pill fs-c1" data-bs-toggle="tooltip" title="{{ $tooltip }}" function="checkNumber"> {{ $comparison }} </span>
              </h6>
            </div>
            
            <h3 class="card-title fw-bold fs-t1"> {{ $devolutions }} </h3>

          </div>

        </div>
    </div>
</div>
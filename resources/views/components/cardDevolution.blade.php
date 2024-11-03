<!-- resources/views/components/cardDevolution.blade.php -->
<div class="col">
    <div class="card mb-2 m-shadow">
        <div class="card-body">

          <div class="d-flex justify-content-between align-items-center mx-4">
            
            <div >
              <h6 class="d-flex justify-content-between align-items-center card-title fw-bold mb-1"> {{ $dTitle }}
                <!-- Devoluções Hoje -->
                <span class="round-pill fs-custom">{{ $dComparison }}</span>
              </h6>
            </div>
            
            <h3 class="card-title fw-bold"> {{ $devolutions }} </h3>

          </div>

        </div>
    </div>
</div>
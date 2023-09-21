<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cancel Page') }}
        </h2>
    </x-slot>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Canceled</div>

                    <div class="card-body">
                        Your Order has been Canceled!
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

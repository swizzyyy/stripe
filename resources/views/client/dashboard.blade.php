<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">Dashboard</div>
                                    <div class="card-body">
                                        @if(auth()->user()->hasRole('Admin'))
                                            <p>Welcome, Admin!</p>
                                        @elseif(auth()->user()->hasRole('B2C Customer'))
                                            <p>B2C Purchase Details: **** **** **** {{ $card }}</p>

                                        @elseif(auth()->user()->hasRole('B2B Customer'))
                                            <p>B2B Purchase Details: **** **** **** {{ $card }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</x-app-layout>

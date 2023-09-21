<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Purchase Page') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                   <main>
                    <div class="container-fluid bg-trasparent my-4 p-3" style="position: relative;">
                        <div class="row row-cols-1 row-cols-xs-2 row-cols-sm-2 row-cols-lg-4 g-3">
                            @forelse ($products as $product)
                            <div class="col">
                                <div class="card h-100 shadow-sm">
                                <img src="https://www.freepnglogos.com/uploads/notebook-png/download-laptop-notebook-png-image-png-image-pngimg-2.png" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <div class="clearfix mb-3">
                                    <span class="float-start badge rounded-pill bg-primary">{{ $product->tag->name }}</span>
                                    <span class="float-end price-hp">{{ $product->price }} $</span>
                                </div>
                                <h5 class="card-title">{{  $product->title }}</h5>
                                <div class="text-center my-4">
                                    <form action="{{ route('checkout',$product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-warning">Checkout</button>
                                      </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                                No Products Found!
                     @endforelse
                  </div>
                  {{ $products->links() }}
                </div>
            </main>
            </div>
        </div>
    </div>
</x-app-layout>

@extends('adminlte::page')

@section('content')



    <div class="container py-8">

    <div class="hidden md:block mb-10">
            @livewire('search')
    </div>
        @foreach ($categories as $category)
        
            <section class="mb-6">
                <div class="flex items-center mb-2">
                    <h1 class="text-lg uppercase font-semibold text-gray-700">
                        {{$category->name}}
                    </h1>

                    <a href="{{route('categories.show', $category)}}" class="text-lime-500 hover:text-lime-600 hover:underline ml-2 font-semibold">Ver más</a>

                </div>

                @livewire('category-products', ['category' => $category])
            </section>

        @endforeach

    </div>
    
    @stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@push('script')
    <script>
        Livewire.on('glider', function(id){
            new Glider(document.querySelector('.glider-' + id), {
                slidesToShow: 2, //cant de registros que se muestran
                slidesToScroll: 1, //los saltos que se dan al darle click a los botones
                draggable: true,
                dots: '.glider-' + id + '~ .dots', //botones pequeños
                arrows: {
                    prev: '.glider-' + id + '~ .glider-prev',
                    next: '.glider-' + id + '~ .glider-next'
                },
                //Slider responsivo
                responsive:[
                    {
                        breakpoint: 640,
                        settings:{
                            slidesToShow: 3, 
                            slidesToScroll: 2,
                        }
                    },
                    {
                        breakpoint: 768,
                        settings:{
                            slidesToShow: 4, 
                            slidesToScroll: 3,
                        }
                    },
                    {
                        breakpoint: 1024,
                        settings:{
                            slidesToShow: 4.5, 
                            slidesToScroll: 4,
                        }
                    },
                    {
                        breakpoint: 1280,
                        settings:{
                            slidesToShow: 4.5, 
                            slidesToScroll: 4,
                        }
                    },
                ]
            });
        })
    </script>
    @endpush

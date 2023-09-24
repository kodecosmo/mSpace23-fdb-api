<!-- API Link -->
<div class="rounded-sm w-full grid grid-cols-12 bg-white shadow py-4 px-6 gap-2 items-center hover:shadow-lg transition delay-150 duration-300 ease-in-out hover:scale-105 transform" {{--href="{{ $url }}" target="_blank"--}}>
    
    <!-- Method -->
    <div class="col-span-12 md:col-span-1 font-bold text-lg md:text-xl text-green-600">
    {{ "#".strtoupper($method) }}
    </div>
    
    <!-- URL -->
    <div class="col-span-11 xl:-ml-5">
    <p class="text-blue-600 font-semibold">{{ $url }}</p>
    </div>
    
    <!-- Description -->
    <div class="md:col-start-2 col-span-11 xl:-ml-5">
    <p class="text-sm text-gray-800 font-light">
        {!! $description !!}
        <br>
        @isset($data)
            data: 
            @foreach ($data as $key => $value)
                <div class="text-sm">
                    <span class="text-red-500">{{ $key }}</span> - 
                    <span class="text-gray-500">{{ $value }}</span>
                </div>
            @endforeach
        @endisset
        
    </p>
    </div>
    
</div>
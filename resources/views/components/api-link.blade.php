<!-- API Link -->
<a class="rounded-sm w-full grid grid-cols-12 bg-white shadow py-4 px-6 gap-2 items-center hover:shadow-lg transition delay-150 duration-300 ease-in-out hover:scale-105 transform" href="{{ $url }}" target="_blank">
    
    <!-- Method -->
    <div class="col-span-12 md:col-span-1 font-bold text-xl md:text-2xl text-green-600">
    {{ "#".strtoupper($method) }}
    </div>
    
    <!-- URL -->
    <div class="col-span-11 xl:-ml-5">
    <p class="text-blue-600 font-semibold">{{ $url }}</p>
    </div>
    
    <!-- Description -->
    <div class="md:col-start-2 col-span-11 xl:-ml-5">
    <p class="text-sm text-gray-800 font-light">{{ $description }}</p>
    </div>
    
</a>
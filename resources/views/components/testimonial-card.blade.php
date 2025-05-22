<div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-all duration-300">
    <div class="flex items-center mb-4">
        <div class="h-12 w-12 rounded-full overflow-hidden mr-4">
            <img src="{{ $image }}" alt="{{ $name }}" class="h-full w-full object-cover">
        </div>
        <div>
            <h4 class="font-semibold text-gray-800">{{ $name }}</h4>
            <p class="text-sm text-gray-500">{{ $position }}</p>
        </div>
    </div>
    <div class="mb-4">
        <div class="flex text-yellow-400">
            @for ($i = 0; $i < $rating; $i++)
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
                @endfor
                @for ($i = $rating; $i < 5; $i++)
                    <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    @endfor
        </div>
    </div>
    <p class="text-gray-600 italic">"{{ $quote }}"</p>
</div>